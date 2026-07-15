# BAB 5 — Migration & Eloquent ORM

---

## 5.1 Tujuan Pembelajaran

Setelah menyelesaikan BAB 5 ini, teman-teman diharapkan mampu:

- Menjelaskan konsep Migration dan Eloquent ORM
- Membuat dan menjalankan file migrasi untuk membuat/mengubah tabel
- Menggunakan Schema Builder untuk mendefinisikan kolom dan index
- Membuat Seeder dan Factory untuk data dummy
- Membuat Model Eloquent dan memahami konvensinya
- Melakukan operasi CRUD (Create, Read, Update, Delete) menggunakan Eloquent
- Menggunakan Artisan Tinker untuk menguji query secara interaktif

---

## 5.2 Pendahuluan

Pada BAB 2–4, kita telah belajar membuat halaman web statis dan semi-dinamis menggunakan route, controller, dan Blade. Namun, aplikasi web yang sesungguhnya membutuhkan **database** untuk menyimpan data secara permanen — seperti artikel, user, produk, dan lain-lain.

Di PHP native, kita biasanya menulis query SQL langsung di dalam kode:

```php
$query = "SELECT * FROM artikel WHERE id = $id";
$result = mysqli_query($conn, $query);
```

Pendekatan ini memiliki beberapa masalah:

1. **Rawan SQL injection** — jika tidak hati-hati menyaring input
2. **Sulit dilacak perubahannya** — siapa yang mengubah struktur tabel dan kapan?
3. **Banyak kode boilerplate** — koneksi, query, fetch, dan error handling berulang-ulang
4. **Tergantung database tertentu** — query MySQL belum tentu compatible dengan PostgreSQL

Laravel menyelesaikan masalah-masalah tersebut dengan dua fitur utama:

- **Migration** — sistem version control untuk database. Setiap perubahan struktur tabel dicatat dalam file migrasi yang bisa di-rollback kapan saja.
- **Eloquent ORM** — Object-Relational Mapping yang memungkinkan kita berinteraksi dengan database menggunakan sintaks PHP yang intuitif, tanpa menulis SQL secara langsung.

---

## 5.3 Konfigurasi Database

Sebelum mulai membuat tabel, kita perlu memastikan project Laravel terhubung ke database.

### 5.3.1 Setting di File `.env`

Buka file `.env` di root project Laravel. Cari dan sesuaikan bagian berikut:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=belajar_laravel
DB_USERNAME=root
DB_PASSWORD=
```

Penjelasan:

| Variabel | Fungsi |
|----------|--------|
| `DB_CONNECTION` | Jenis database: `mysql` untuk MySQL |
| `DB_HOST` | Alamat server database (127.0.0.1 artinya localhost) |
| `DB_PORT` | Port MySQL (bawaan 3306) |
| `DB_DATABASE` | Nama database yang akan digunakan |
| `DB_USERNAME` | Username MySQL |
| `DB_PASSWORD` | Password MySQL |

### 5.3.2 Membuat Database

Buka terminal MySQL atau tool seperti phpMyAdmin, Laragon, atau MySQL Workbench, lalu buat database:

```sql
CREATE DATABASE belajar_laravel CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

Atau jika menggunakan Laragon, bisa klik kanan → Database → Create Database.

### 5.3.3 Verifikasi Koneksi

Untuk memastikan koneksi berhasil, jalankan perintah Artisan berikut:

```bash
php artisan migrate:status
```

Jika muncul daftar migrasi (meskipun belum dijalankan), artinya koneksi berhasil. Jika muncul error, periksa kembali konfigurasi `.env` dan pastikan MySQL server sedang berjalan.

---

## 5.4 Migration

Migration adalah cara Laravel untuk membuat dan mengubah struktur tabel database. Setiap migrasi adalah file PHP yang berisi instruksi naik (`up`) dan turun (`down`).

### 5.4.1 Anatomi File Migrasi

Buka folder `database/migrations/`. Kita akan melihat beberapa file migrasi bawaan Laravel:

```
2024_01_01_000000_create_users_table.php
2024_01_01_000001_create_personal_access_tokens_table.php
```

Format nama file migrasi:

```
YYYY_MM_DD_HHMMSS_nama_migrasi.php
```

Timestamp otomatis ini memastikan urutan eksekusi migrasi konsisten di semua lingkungan (lokal, staging, production).

### 5.4.2 Membuat Migration

Gunakan Artisan CLI:

```bash
php artisan make:migration create_articles_table
```

Perintah di atas akan menghasilkan file di `database/migrations/` dengan nama seperti `2026_07_14_123456_create_articles_table.php`.

Isi file tersebut:

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
```

### 5.4.3 Mendefinisikan Kolom dengan Schema Builder

Sekarang kita akan menambahkan kolom-kolom yang diperlukan. Ubah method `up()` menjadi seperti berikut:

```php
public function up(): void
{
    Schema::create('articles', function (Blueprint $table) {
        $table->id();
        $table->string('title');
        $table->string('slug')->unique();
        $table->text('body');
        $table->string('category');
        $table->boolean('published')->default(false);
        $table->foreignId('user_id')->constrained()->cascadeOnDelete();
        $table->timestamps();
    });
}
```

**Penjelasan tiap method:**

| Method | Fungsi |
|--------|--------|
| `$table->id()` | Kolom `id` sebagai auto-increment primary key (bigInteger) |
| `$table->string('title')` | Kolom `title` tipe VARCHAR |
| `$table->string('slug')->unique()` | Kolom `slug` dengan constraint UNIQUE |
| `$table->text('body')` | Kolom `body` tipe TEXT |
| `$table->boolean('published')->default(false)` | Kolom boolean dengan nilai default `false` |
| `$table->foreignId('user_id')->constrained()->cascadeOnDelete()` | Kolom foreign key `user_id` yang merujuk ke tabel `users`, otomatis dihapus jika user dihapus |
| `$table->timestamps()` | Membuat kolom `created_at` dan `updated_at` |

> **Catatan:** Method `constrained()` secara otomatis akan membuat foreign key yang merujuk ke tabel `users` (dari nama kolom `user_id`). Jika nama kolom berbeda, misalnya `author_id`, kita bisa tentukan nama tabelnya: `->constrained('users')`.

### 5.4.4 Migration yang Mengubah Tabel

Selain membuat tabel baru, kita juga bisa mengubah tabel yang sudah ada. Misalnya, menambahkan kolom `excerpt` ke tabel `articles`:

```bash
php artisan make:migration add_excerpt_to_articles_table
```

Isi file migrasinya:

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->text('excerpt')->nullable()->after('body');
        });
    }

    public function down(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->dropColumn('excerpt');
        });
    }
};
```

**Poin penting:**
- Gunakan `->nullable()` jika kolom boleh kosong
- Gunakan `->after('body')` untuk menentukan posisi kolom
- Method `down()` harus reversibel — siapkan `dropColumn()` agar rollback berfungsi
- **Jangan pernah mengubah migrasi yang sudah dijalankan** di production. Buat migrasi baru untuk perubahan

### 5.4.5 Menjalankan Migration

```bash
php artisan migrate
```

Perintah ini akan menjalankan semua migrasi yang belum pernah dijalankan. Laravel menyimpan catatan eksekusi di tabel `migrations`.

**Perintah migration lainnya:**

| Perintah | Fungsi |
|----------|--------|
| `php artisan migrate` | Menjalankan migrasi yang belum dijalankan |
| `php artisan migrate:fresh` | Menghapus semua tabel lalu migrasi ulang |
| `php artisan migrate:rollback` | Membatalkan migrasi terakhir (satu batch) |
| `php artisan migrate:reset` | Membatalkan semua migrasi |
| `php artisan migrate:refresh` | Rollback lalu migrasi ulang |
| `php artisan migrate:status` | Melihat status setiap migrasi |
| `php artisan make:migration nama` | Membuat file migrasi baru |

### 5.4.6 Prinsip Penting Migration

1. **Satu migrasi untuk satu perubahan** — jangan mencampur DDL (buat tabel) dan DML (isi data) dalam satu file
2. **Migration bersifat immutable** — setelah dijalankan di production, jangan diedit. Buat migrasi baru
3. **`down()` harus reversible** — pastikan rollback berfungsi dengan baik
4. **Tambahkan index** pada kolom yang sering digunakan di `WHERE`, `ORDER BY`, atau `JOIN`

---

## 5.5 Seeder & Factory

Seeder dan Factory digunakan untuk mengisi database dengan data dummy untuk keperluan pengembangan dan testing.

### 5.5.1 Model Factory

Factory adalah class yang mendefinisikan bagaimana data dummy dibuat untuk suatu model.

```bash
php artisan make:factory ArticleFactory
```

Buka file `database/factories/ArticleFactory.php`:

```php
<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ArticleFactory extends Factory
{
    public function definition(): array
    {
        $title = fake()->sentence(4);

        return [
            'title' => $title,
            'slug' => Str::slug($title),
            'body' => fake()->paragraphs(3, true),
            'excerpt' => fake()->sentence(10),
            'category' => fake()->randomElement(['Teknologi', 'Olahraga', 'Pendidikan', 'Hiburan']),
            'published' => fake()->boolean(80),
            'user_id' => 1,
        ];
    }
}
```

**Penjelasan:**
- `fake()` adalah helper Laravel yang menggunakan library Faker untuk menghasilkan data realistis
- `fake()->sentence(4)` — menghasilkan kalimat acak dengan 4 kata
- `fake()->paragraphs(3, true)` — menghasilkan 3 paragraf teks
- `fake()->randomElement([...])` — memilih secara acak dari array
- `Str::slug($title)` — mengubah judul menjadi format slug URL

### 5.5.2 Database Seeder

Seeder adalah class yang menjalankan perintah untuk mengisi data ke database.

Buka file `database/seeders/DatabaseSeeder.php`:

```php
<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
        ]);

        Article::factory(20)->create();
    }
}
```

Penjelasan:
- `User::factory()->create([...])` — membuat satu user dengan data spesifik
- `Article::factory(20)->create()` — membuat 20 artikel data dummy

### 5.5.3 Menjalankan Seeder

```bash
php artisan migrate:fresh --seed
```

Perintah ini akan:
1. Menghapus semua tabel
2. Menjalankan migrasi ulang
3. Menjalankan semua seeder

Alternatif jika hanya ingin menjalankan seeder tanpa migrasi:

```bash
php artisan db:seed
```

Atau seeder spesifik:

```bash
php artisan db:seed --class=ArticleSeeder
```

### 5.5.4 Factory States

Factory states memungkinkan kita membuat variasi data. Misalnya, artikel yang sudah dipublikasikan:

```php
public function published(): static
{
    return $this->state(fn (array $attributes) => [
        'published' => true,
    ]);
}
```

Penggunaan:

```php
Article::factory()->published()->count(5)->create();
```

---

## 5.6 Eloquent Model

Model adalah representasi dari sebuah tabel database dalam bentuk class PHP. Setiap instance model mewakili satu baris data.

### 5.6.1 Membuat Model

```bash
php artisan make:model Article
```

Lebih efisien, kita bisa membuat model sekaligus dengan migration, factory, dan seeder dalam satu perintah:

```bash
php artisan make:model Article -mf
```

- `-m` : membuat migration
- `-f` : membuat factory
- `-s` : membuat seeder

### 5.6.2 Konvensi Penamaan

Eloquent mengikuti konvensi "tabel jamak, model tunggal":

| Model | Tabel |
|-------|-------|
| `Article` | `articles` |
| `User` | `users` |
| `PostCategory` | `post_categories` |
| `ProductReview` | `product_reviews` |

Jika tabel tidak mengikuti konvensi, kita bisa mendefinisikan nama tabel secara eksplisit:

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $table = 'artikel_saya';
}
```

### 5.6.3 Atribut Model

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'body',
        'excerpt',
        'category',
        'published',
        'user_id',
    ];

    protected function casts(): array
    {
        return [
            'published' => 'boolean',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }
}
```

**Penjelasan:**

| Properti/Method | Fungsi |
|-----------------|--------|
| `$fillable` | Daftar kolom yang boleh diisi massal (mass assignment) |
| `$guarded` | Kebalikan dari `$fillable` — kolom yang tidak boleh diisi massal |
| `casts()` | Mengkonversi tipe data secara otomatis (string → boolean, datetime, array, dll) |

### 5.6.4 Menggunakan Model di Controller

```php
<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::latest()->where('published', true)->get();

        return view('articles.index', compact('articles'));
    }

    public function show(Article $article)
    {
        return view('articles.show', compact('article'));
    }
}
```

Perhatikan parameter `show(Article $article)` — ini adalah **Route Model Binding**. Laravel secara otomatis akan mencari artikel berdasarkan ID dari URL. Jika tidak ditemukan, Laravel akan mengembalikan error 404.

---

## 5.7 CRUD dengan Eloquent

CRUD adalah singkatan dari **Create, Read, Update, Delete** — empat operasi dasar pada data.

### 5.7.1 Create (Menyimpan Data Baru)

```php
// Method 1 — Mass assignment (gunakan $fillable)
Article::create([
    'title' => 'Belajar Larvel untuk Pemula',
    'slug' => 'belajar-laravel-untuk-pemula',
    'body' => 'Artikel tentang dasar-dasar Laravel...',
    'category' => 'Teknologi',
    'published' => true,
    'user_id' => 1,
]);

// Method 2 — Instance model
$article = new Article();
$article->title = 'Belajar Laravel untuk Pemula';
$article->slug = 'belajar-laravel-untuk-pemula';
$article->body = 'Artikel tentang dasar-dasar Laravel...';
$article->category = 'Teknologi';
$article->published = true;
$article->user_id = 1;
$article->save();
```

### 5.7.2 Read (Mengambil Data)

```php
// Semua data
$articles = Article::all();

// Dengan kondisi
$articles = Article::where('category', 'Teknologi')
    ->where('published', true)
    ->orderBy('created_at', 'desc')
    ->get();

// Satu data berdasarkan ID
$article = Article::find(1);

// Satu data berdasarkan kondisi (jika tidak ditemukan, throw 404)
$article = Article::where('slug', 'belajar-laravel-untuk-pemula')->firstOrFail();

// Pagination (10 data per halaman)
$articles = Article::paginate(10);
```

### 5.7.3 Update (Memperbarui Data)

```php
// Method 1 — Mass assignment
Article::where('id', 1)->update([
    'title' => 'Judul Baru',
    'body' => 'Konten yang diperbarui...',
]);

// Method 2 — Instance model
$article = Article::find(1);
$article->title = 'Judul Baru';
$article->body = 'Konten yang diperbarui...';
$article->save();
```

### 5.7.4 Delete (Menghapus Data)

```php
// Hapus satu data
Article::find(1)->delete();

// Hapus dengan kondisi
Article::where('published', false)->delete();

// Hapus tanpa memuat model (lebih efisien)
Article::destroy(1);
Article::destroy([1, 2, 3]);
```

### 5.7.5 Query Scopes

Untuk query yang sering digunakan, buat **local scope** di model:

```php
public function scopePublished(Builder $query): Builder
{
    return $query->where('published', true);
}

public function scopeCategory(Builder $query, string $category): Builder
{
    return $query->where('category', $category);
}
```

Penggunaan di controller:

```php
$articles = Article::published()
    ->category('Teknologi')
    ->latest()
    ->get();
```

---

## 5.8 Query Builder vs Eloquent

Laravel menyediakan dua pendekatan untuk berinteraksi dengan database:

### Query Builder (`DB::table()`)

```php
$articles = DB::table('articles')
    ->where('published', true)
    ->orderBy('created_at', 'desc')
    ->get();
```

### Eloquent ORM (Menggunakan Model)

```php
$articles = Article::where('published', true)
    ->latest()
    ->get();
```

**Kapan menggunakan apa?**

| Situasi | Gunakan |
|---------|---------|
| CRUD standar pada entitas | **Eloquent** — lebih ekspresif dan terstruktur |
| Query sederhana tanpa relasi | **Eloquent** |
| Report/aggregasi kompleks | **Query Builder** |
| Update massal banyak data | **Query Builder** (lebih efisien) |
| Relasi antar tabel | **Eloquent** — fitur relationship sangat kuat |

Sebagai aturan umum: **gunakan Eloquent untuk segala interaksi dengan model yang memiliki relasi**. Cadangkan Query Builder untuk laporan atau operasi massal yang tidak memerlukan fitur ORM.

---

## 5.9 Praktikum: CRUD Artikel dengan MySQL

Pada praktikum ini, kita akan membangun fitur CRUD untuk artikel menggunakan MySQL sebagai database.

### 5.9.1 Persiapan Database

1. Buka MySQL dan buat database:

```sql
CREATE DATABASE belajar_laravel CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

2. Setting file `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=belajar_laravel
DB_USERNAME=root
DB_PASSWORD=
```

3. Verifikasi koneksi:

```bash
php artisan migrate:status
```

### 5.9.2 Membuat Model, Migration, Factory

Jalankan satu perintah untuk membuat semuanya sekaligus:

```bash
php artisan make:model Article -mf
```

### 5.9.3 Mendefinisikan Migration

Buka file migrasi `database/migrations/xxxx_xx_xx_create_articles_table.php`:

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('body');
            $table->text('excerpt')->nullable();
            $table->string('category');
            $table->boolean('published')->default(false);
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
```

### 5.9.4 Mendefinisikan Factory

Buka file `database/factories/ArticleFactory.php`:

```php
<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ArticleFactory extends Factory
{
    public function definition(): array
    {
        $title = fake()->sentence(4);

        return [
            'title' => $title,
            'slug' => Str::slug($title),
            'body' => fake()->paragraphs(3, true),
            'excerpt' => fake()->sentence(10),
            'category' => fake()->randomElement(['Teknologi', 'Olahraga', 'Pendidikan', 'Hiburan']),
            'published' => fake()->boolean(80),
            'user_id' => User::factory(),
        ];
    }
}
```

### 5.9.5 Mendefinisikan Seeder

Buka file `database/seeders/DatabaseSeeder.php`:

```php
<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
        ]);

        Article::factory(20)->create();
    }
}
```

### 5.9.6 Mengisi Model

Buka file `app/Models/Article.php`:

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'body',
        'excerpt',
        'category',
        'published',
        'user_id',
    ];

    protected function casts(): array
    {
        return [
            'published' => 'boolean',
        ];
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('published', true);
    }

    public function scopeCategory(Builder $query, string $category): Builder
    {
        return $query->where('category', $category);
    }

    public function author(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
```

### 5.9.7 Menjalankan Migrasi dan Seeder

```bash
php artisan migrate:fresh --seed
```

Output yang diharapkan:

```
Dropped all tables successfully.
Migration table created successfully.
...
CREATE TABLE articles
...
Seeding: Database\Seeders\DatabaseSeeder
Seeded:  Database\Seeders\DatabaseSeeder
```

### 5.9.8 Membuat Controller

```bash
php artisan make:controller ArticleController --resource
```

Buka `app/Http/Controllers/ArticleController.php`:

```php
<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::with('author')
            ->published()
            ->latest()
            ->paginate(10);

        return view('articles.index', compact('articles'));
    }

    public function show(Article $article)
    {
        if (!$article->published) {
            abort(404);
        }

        return view('articles.show', compact('article'));
    }
}
```

### 5.9.9 Mendefinisikan Route

Buka `routes/web.php`:

```php
<?php

use App\Http\Controllers\ArticleController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

Route::get('/articles', [ArticleController::class, 'index'])->name('articles.index');
Route::get('/articles/{article}', [ArticleController::class, 'show'])->name('articles.show');
```

### 5.9.10 Membuat View

Buat folder `resources/views/articles/`.

**Layout utama** — `resources/views/layouts/app.blade.php`:

```blade
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Blog')</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <nav class="bg-white shadow p-4">
        <div class="max-w-4xl mx-auto flex gap-4">
            <a href="/" class="font-bold">Home</a>
            <a href="{{ route('articles.index') }}">Artikel</a>
        </div>
    </nav>

    <main class="max-w-4xl mx-auto p-4">
        @yield('content')
    </main>
</body>
</html>
```

**Halaman daftar artikel** — `resources/views/articles/index.blade.php`:

```blade
@extends('layouts.app')

@section('title', 'Daftar Artikel')

@section('content')
    <h1 class="text-3xl font-bold mb-6">Daftar Artikel</h1>

    @forelse($articles as $article)
        <article class="bg-white rounded-lg shadow p-6 mb-4">
            <h2 class="text-xl font-semibold">
                <a href="{{ route('articles.show', $article) }}" class="text-blue-600 hover:text-blue-800">
                    {{ $article->title }}
                </a>
            </h2>
            <p class="text-gray-600 mt-2">{{ $article->excerpt }}</p>
            <div class="text-sm text-gray-400 mt-2">
                {{ $article->category }} &middot; {{ $article->created_at->format('d M Y') }}
            </div>
        </article>
    @empty
        <p class="text-gray-500">Belum ada artikel.</p>
    @endforelse

    <div class="mt-6">
        {{ $articles->links() }}
    </div>
@endsection
```

**Halaman detail artikel** — `resources/views/articles/show.blade.php`:

```blade
@extends('layouts.app')

@section('title', $article->title)

@section('content')
    <article class="bg-white rounded-lg shadow p-6">
        <h1 class="text-3xl font-bold mb-4">{{ $article->title }}</h1>

        <div class="text-sm text-gray-400 mb-6">
            {{ $article->category }} &middot;
            {{ $article->created_at->format('d M Y') }}
        </div>

        <div class="prose max-w-none">
            {{ $article->body }}
        </div>

        <a href="{{ route('articles.index') }}" class="inline-block mt-6 text-blue-600 hover:text-blue-800">
            &larr; Kembali ke daftar
        </a>
    </article>
@endsection
```

### 5.9.11 Uji Coba

1. Jalankan server: `php artisan serve`
2. Buka `http://localhost:8000/articles`
3. Jika berhasil, akan muncul daftar 20 artikel yang sudah di-seed
4. Klik salah satu artikel untuk melihat detailnya

### 5.9.12 Eksplorasi dengan Tinker

Tinker adalah interactive shell untuk menguji Eloquent query secara langsung:

```bash
php artisan tinker
```

Coba beberapa perintah berikut:

```php
// Melihat semua artikel
App\Models\Article::all();

// Mencari artikel dengan ID
App\Models\Article::find(1);

// Menghitung artikel yang dipublikasikan
App\Models\Article::where('published', true)->count();

// Membuat artikel baru
App\Models\Article::create([
    'title' => 'Artikel dari Tinker',
    'slug' => 'artikel-dari-tinker',
    'body' => 'Dibuat melalui php artisan tinker',
    'category' => 'Teknologi',
    'published' => true,
    'user_id' => 1,
]);

// Keluar dari Tinker
exit
```

---

## 5.10 Rangkuman

| Konsep | Intinya |
|--------|---------|
| Migration | Version control untuk struktur database |
| Schema Builder | Mendefinisikan kolom, tipe data, index, foreign key |
| Seeder | Mengisi database dengan data awal |
| Factory | Generator data dummy untuk development |
| Eloquent Model | Representasi class untuk tabel database |
| `$fillable` | Kolom yang boleh diisi mass assignment |
| `casts()` | Konversi tipe data otomatis |
| Scopes | Query reusable dalam model |
| CRUD | Create, Read, Update, Delete dengan Eloquent |
| Tinker | Interactive shell untuk testing query |

---

## 5.11 Referensi

- [Laravel Migration](https://laravel.com/docs/13.x/migrations)
- [Laravel Seeding](https://laravel.com/docs/13.x/seeding)
- [Eloquent ORM](https://laravel.com/docs/13.x/eloquent)
- [Eloquent CRUD](https://laravel.com/docs/13.x/eloquent#inserting-and-updating-models)
- [Query Builder](https://laravel.com/docs/13.x/queries)
- [Laravel Tinker](https://laravel.com/docs/13.x/artisan#tinker)

---

**Lanjut ke:** [BAB 6 — Relasi Database](../BAB-06-Relasi-Database/README.md)

**Kembali ke:** [BAB 4 — Blade Templating](../BAB-04-Blade-Templating/README.md)
