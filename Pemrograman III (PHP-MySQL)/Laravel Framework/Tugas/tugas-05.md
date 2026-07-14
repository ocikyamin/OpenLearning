# Tugas 5 — Relasi Database

---

## Tujuan

Mahasiswa mampu mendefinisikan dan menggunakan relasi database (one-to-many, many-to-many), eager loading, dan query agregat dengan Eloquent.

---

## Soal

### 1. Persiapan

Buat project baru atau gunakan project dari tugas sebelumnya. Buat database `db_tugas5`.

### 2. Migration

Buat tabel-tabel berikut:

**Tabel `categories`**

| Kolom | Tipe | Keterangan |
|-------|------|------------|
| `id` | auto-increment | Primary key |
| `name` | string(50) | Nama kategori |
| `slug` | string(50) | Unique |
| `timestamps` | — | — |

**Tabel `products`** (ulang dari tugas 4, tanpa kolom `category` — gunakan relasi ke `categories`)

| Kolom | Tipe | Keterangan |
|-------|------|------------|
| `id` | auto-increment | Primary key |
| `name` | string(100) | — |
| `slug` | string(100) | Unique |
| `price` | integer | — |
| `stock` | integer | Default 0 |
| `description` | text | Nullable |
| `is_active` | boolean | Default true |
| `category_id` | foreign key | → categories |
| `user_id` | foreign key | → users |
| `timestamps` | — | — |

**Tabel `order_items`**

| Kolom | Tipe | Keterangan |
|-------|------|------------|
| `id` | auto-increment | Primary key |
| `product_id` | foreign key | → products |
| `quantity` | integer | Jumlah barang |
| `price` | integer | Harga saat checkout |
| `customer_name` | string(100) | Nama pembeli |
| `notes` | text | Nullable, catatan tambahan |
| `timestamps` | — | — |

### 3. Model & Relasi

Buat model dan definisikan relasi berikut:

| Model | Relasi | Ke |
|-------|--------|----|
| `Product` | `belongsTo` | `Category` |
| `Product` | `hasMany` | `OrderItem` |
| `Product` | `belongsTo` | `User` |
| `Category` | `hasMany` | `Product` |
| `OrderItem` | `belongsTo` | `Product` |

**Product** juga harus memiliki:
- `$fillable`, `casts()` untuk `is_active` dan `price`
- Local scope `active()` dan `minPrice(int $price)`

### 4. Factory & Seeder

**CategoryFactory**: buat 5 kategori (acak)

**ProductFactory**: 30 produk, masing-masing terhubung ke kategori dan user admin secara acak

**OrderItemFactory**: 50 order item, masing-masing terhubung ke produk acak

**DatabaseSeeder**: jalankan semua factory dan buat satu user admin.

### 5. Route & Controller

Buat route dan controller untuk:

| URL | Method | Keterangan |
|-----|--------|------------|
| `/products` | GET | Daftar produk dengan eager loading category |
| `/products/{product}` | GET | Detail produk + daftar order item + eager loading semua relasi |
| `/products/category/{category:slug}` | GET | Filter produk berdasarkan kategori |
| `/products/top` | GET | 5 produk dengan order item terbanyak (pakai `withCount`) |

### 6. View

**Layout utama** — `layouts/app.blade.php`:
- Navigasi: Home, Produk, Kategori (dropdown dari semua kategori)

**Halaman daftar produk** — tampilkan:
- Nama, kategori, harga, stok
- Jumlah order item (pakai `withCount`)
- Filter: link ke `/products/category/{slug}` untuk setiap kategori

**Halaman detail produk** — tampilkan:
- Semua info produk
- Daftar order item (customer, quantity, total harga)
- Total semua order item untuk produk ini

**Halaman filter kategori** — sama seperti daftar tapi hanya produk dari kategori tertentu

**Halaman top products** — tabel 5 produk terlaris:
- Ranking, nama, kategori, jumlah order item

### 7. Eksplorasi Tinker

Jalankan perintah berikut dan screenshot hasilnya:

```php
use App\Models\Product;
use App\Models\Category;

// Eager loading
Product::with(['category', 'user'])->get();

// withCount
Product::withCount('orderItems')->orderBy('order_items_count', 'desc')->take(5)->get();

// whereHas
Category::whereHas('products', fn ($q) => $q->where('is_active', true))->get();
```

---

## Ketentuan Pengumpulan

- Kumpulkan semua file: migration, model, factory, seeder, controller, routes, view
- Screenshot: hasil migrate --seed, setiap halaman browser, dan perintah Tinker
- Batas pengumpulan: sebelum BAB berikutnya

---

## Rubrik Penilaian

| Aspek | Bobot |
|-------|-------|
| Migration & foreign key | 15% |
| Model & relasi (belongsTo, hasMany) | 20% |
| Factory & Seeder (data acak) | 10% |
| Route & Controller (eager loading, withCount) | 20% |
| View (layout, daftar, detail, filter, top) | 25% |
| Tinker (3 query) | 10% |
