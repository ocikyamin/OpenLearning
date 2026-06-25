# **Bab 1: Arsitektur Database & Relasi Model**

**Author:** Abdul Yamin, S.Pd., M.Kom

**Fokus:** Skema Database, Relasi Tabel, dan Migrasi

## **Pendahuluan**

Bab ini kita akan membangun skema database untuk sistem pengaduan. Relasi tabel dirancang untuk menangani pelapor (login atau anonim), kategori masalah, dan lampiran bukti (gambar/link).

Desain database yang baik mencegah *query* API yang lambat dan tidak terstruktur.

## **1. Instalasi dan Setup API**

Buka terminal dan jalankan perintah ini untuk membuat project baru dan mengaktifkan mode API (karena di Laravel 11/13 API tidak aktif otomatis).

```bash
composer create-project laravel/laravel api-pengaduan
cd api-pengaduan
php artisan install:api
```

Jangan lupa konfigurasi `.env` kalian untuk koneksi ke database MySQL.

## **2. Desain Database (Migration Layer)**

Kita akan membuat 3 tabel utama: `categories`, `complaints`, dan `complaint_evidences`.

Jalankan perintah ini:

```bash
php artisan make:model Category -m
php artisan make:model Complaint -m
php artisan make:model ComplaintEvidence -m
```

### **A. Tabel Categories**

Digunakan untuk mengelompokkan aduan (contoh: Fasilitas, Pelecehan, Administrasi). Buka file migrasinya:

```php
// database/migrations/xxxx_create_categories_table.php
public function up(): void
{
    Schema::create('categories', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->string('slug')->unique();
        $table->timestamps();
    });
}
```

### **B. Tabel Complaints (Aduan)**

Ini adalah tabel inti. Perhatikan bahwa `user_id` boleh kosong (nullable) untuk mendukung pelaporan **Anonim**. Kita menggunakan `tracking_code` agar anonim tetap bisa melacak status aduannya.

```php
// database/migrations/xxxx_create_complaints_table.php
public function up(): void
{
    Schema::create('complaints', function (Blueprint $table) {
        $table->id();
        $table->string('tracking_code')->unique(); // ex: ADU-2026-X8Y9
        $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
        $table->foreignId('category_id')->constrained();
          
        $table->string('title');
        $table->text('description');
        $table->boolean('is_anonymous')->default(false);
        $table->enum('status', ['pending', 'processing', 'resolved', 'rejected'])->default('pending');
          
        $table->timestamps();
        $table->softDeletes(); // Wajib! Aduan tidak boleh hilang dari database
    });
}
```

### **C. Tabel Complaint Evidences (Bukti Lampiran)**

Satu aduan bisa memiliki banyak bukti (*One-to-Many*). Bukti bisa berupa file/gambar atau link URL.

```php
// database/migrations/xxxx_create_complaint_evidences_table.php
public function up(): void
{
    Schema::create('complaint_evidences', function (Blueprint $table) {
        $table->id();
        $table->foreignId('complaint_id')->constrained()->cascadeOnDelete();
        $table->enum('type', ['image', 'document', 'link']);
        $table->string('file_path')->nullable(); // Jika gambar/pdf
        $table->string('url_link')->nullable();  // Jika link eksternal/gdrive
        $table->timestamps();
    });
}
```

Setelah itu, jalankan:

```bash
php artisan migrate
```

## **3. Menghubungkan Model (Relasi Eloquent)**

Setelah migrasi, relasi antar tabel dihubungkan di dalam Models.

**1. Model Complaint (`app/Models/Complaint.php`)**

```php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Complaint extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'tracking_code', 'user_id', 'category_id', 'title', 
        'description', 'is_anonymous', 'status'
    ];

    // Relasi ke User (Pelapor)
    public function user() {
        return $this->belongsTo(User::class);
    }

    // Relasi ke Kategori
    public function category() {
        return $this->belongsTo(Category::class);
    }

    // Relasi ke Bukti (One to Many)
    public function evidences() {
        return $this->hasMany(ComplaintEvidence::class);
    }
}
```

**2. Model ComplaintEvidence (`app/Models/ComplaintEvidence.php`)**

```php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ComplaintEvidence extends Model
{
    protected $fillable = ['complaint_id', 'type', 'file_path', 'url_link'];

    public function complaint() {
        return $this->belongsTo(Complaint::class);
    }
}
```

## **4. Manajemen Role (Kolom role di Tabel Users)**

Tabel `users` bawaan Laravel perlu ditambahkan kolom `role` untuk membedakan admin kampus dan mahasiswa.

### A. Migration Add Role

Jalankan perintah ini:

```bash
php artisan make:migration add_role_to_users_table
```

Kemudian isi method `up()` dan `down()`:

```php
<?php
// database/migrations/xxxx_add_role_to_users_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['admin', 'user'])->default('user')->after('password');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('role');
        });
    }
};
```

### B. Update Model User

Tambahkan `role` ke `$fillable` dan `$casts`:

```php
// app/Models/User.php
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'role' => 'string',
    ];
}
```

### C. Database Seeder (Admin Default)

Buat seeder untuk akun admin awal agar bisa login ke dashboard:

```bash
php artisan make:seeder AdminUserSeeder
```

```php
<?php
// database/seeders/AdminUserSeeder.php
namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin Kampus',
            'email' => 'admin@kampus.ac.id',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);
    }
}
```

Jalankan seeder:

```bash
php artisan db:seed --class=AdminUserSeeder
```

## **5. Ringkasan Tabel Database**

Sistem memiliki 4 tabel utama:

| Tabel | Fungsi | Relasi |
|-------|--------|--------|
| `users` | Data pengguna (admin + pelapor) | One-to-Many ke `complaints` |
| `categories` | Kategori aduan | One-to-Many ke `complaints` |
| `complaints` | Aduan inti | BelongsTo `users` & `categories`, HasMany `evidences` |
| `complaint_evidences` | Bukti lampiran | BelongsTo `complaints` |

## **🎯 Tugas Akhir Bab 1**

Jalankan migrasi role dan seeder. Pastikan `php artisan migrate` berjalan tanpa error. Login dengan `admin@kampus.ac.id` / `password` untuk verifikasi.
