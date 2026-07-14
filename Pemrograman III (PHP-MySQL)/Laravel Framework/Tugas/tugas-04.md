# Tugas 4 — Migration & Eloquent ORM

---

## Tujuan

Mahasiswa mampu membuat migration, model, factory, seeder, dan melakukan operasi CRUD menggunakan Eloquent dengan database MySQL.

---

## Soal

### 1. Persiapan Project

Buat project Laravel baru dengan nama `tugas-relasi-mysql`.

Atur koneksi database di `.env` untuk menggunakan **MySQL** dengan database `db_tugas4`.

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=db_tugas4
DB_USERNAME=root
DB_PASSWORD=
```

Buat database di MySQL:

```sql
CREATE DATABASE db_tugas4 CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### 2. Migration

Buat migrasi untuk tabel **products** dengan kolom berikut:

| Kolom | Tipe | Keterangan |
|-------|------|------------|
| `id` | auto-increment | Primary key |
| `name` | string(100) | Nama produk |
| `slug` | string(100) | Slug URL, unique |
| `price` | integer | Harga dalam rupiah |
| `stock` | integer | Stok barang, default 0 |
| `category` | string(50) | Kategori produk |
| `description` | text | Deskripsi, boleh null |
| `is_active` | boolean | Status aktif, default true |
| `user_id` | foreign key | Foreign key ke tabel users |
| `timestamps` | — | created_at & updated_at |

**Ketentuan:**
- Gunakan `constrained()->cascadeOnDelete()` untuk foreign key
- Tambahkan `->index()` pada kolom `category`
- Tulis method `down()` yang reversible

### 3. Model

Buat model `Product` dengan ketentuan:

- `$fillable` yang sesuai
- Method `casts()` untuk `is_active` (boolean) dan `price` (integer)
- Local scope `active()` untuk mengambil produk yang aktif
- Local scope `category(string $category)` untuk filter kategori
- Relasi `user()`: belongsTo ke User

### 4. Factory & Seeder

Buat factory untuk Product yang menghasilkan data realistis:
- `name`: kalimat 3 kata
- `slug`: slug dari name
- `price`: angka acak antara 10.000 dan 1.000.000
- `stock`: angka acak 0–100
- `category`: acak dari [Elektronik, Fashion, Makanan, Buku, Olahraga]
- `description`: 2 paragraf
- `is_active`: 80% true

Buat **DatabaseSeeder** yang:
1. Membuat satu user admin (email: `admin@toko.test`)
2. Membuat 30 produk milik user tersebut

### 5. Route & Controller

Buat `ProductController` (gunakan `--resource`) dan daftarkan route dengan prefix `/products` dan hanya method `index` dan `show`.

### 6. View

**Daftar Produk** (`/products`):
- Tampilkan produk aktif saja
- Gunakan eager loading `user` dan `withCount` untuk kolom tambahan (tidak ada)
- Paginate 10 per halaman
- Tampilkan: nama, kategori, harga (format Rupiah), stok, status aktif/nonaktif
- Setiap produk bisa diklik ke halaman detail

**Detail Produk** (`/products/{id}`):
- Tampilkan semua informasi produk
- Jika produk tidak aktif, tampilkan 404

### 7. Tinker

Jalankan `php artisan tinker` dan buktikan dengan screenshot bahwa query berikut berhasil:

```php
use App\Models\Product;

// Produk yang aktif
Product::active()->count();

// Produk per kategori
Product::category('Elektronik')->count();

// Relasi user
Product::with('user')->first()->user->name;
```

---

## Ketentuan Pengumpulan

- Kumpulkan file: migration, model, factory, seeder, controller, routes/web.php, dan semua file view
- Sertakan screenshot: hasil `php artisan migrate:fresh --seed`, tiap halaman di browser, dan hasil perintah Tinker
- Batas pengumpulan: sebelum BAB berikutnya

---

## Rubrik Penilaian

| Aspek | Bobot |
|-------|-------|
| Migration (foreign key, index, down) | 15% |
| Model ($fillable, casts, scopes, relasi) | 15% |
| Factory & Seeder (data realistis) | 15% |
| Controller & Route (eager loading, paginate) | 20% |
| View (daftar & detail produk) | 20% |
| Tinker (3 query berhasil) | 10% |
| Kerapihan kode & dokumentasi | 5% |
