# Tugas 2 — Routing & Controller

---

## Tujuan

Mahasiswa mampu mendefinisikan route, menggunakan route parameters, membuat controller, dan mengelola response.

---

## Soal

### 1. Route & Controller Dasar

Buat project baru atau gunakan project tugas sebelumnya.

Buat **ProductController** dengan method berikut:

| Method | Route | Tampilkan |
|--------|-------|-----------|
| `index()` | `GET /produk` | Daftar produk (hardcoded array) |
| `show($id)` | `GET /produk/{id}` | Detail produk dengan ID tertentu |
| `kategori($kategori)` | `GET /produk/kategori/{kategori}` | Filter produk berdasarkan kategori |

Data produk (gunakan array di dalam controller):

```php
$produk = [
    ['id' => 1, 'nama' => 'Laptop', 'harga' => 12000000, 'kategori' => 'elektronik'],
    ['id' => 2, 'nama' => 'Baju', 'harga' => 150000, 'kategori' => 'fashion'],
    ['id' => 3, 'nama' => 'Buku', 'harga' => 75000, 'kategori' => 'pendidikan'],
    ['id' => 4, 'nama' => 'Mouse', 'harga' => 250000, 'kategori' => 'elektronik'],
];
```

### 2. Named Route & Redirect

- Beri nama `produk.index` pada route daftar produk
- Beri nama `produk.show` pada route detail produk
- Buat route `/cari` yang me-redirect ke route `produk.index`
- Buat route `/promo` yang me-redirect ke route `produk.show` dengan parameter `id=2`

### 3. Route Group

Buat route group dengan prefix `admin` untuk route berikut:

| Route | Method | Tampilkan |
|-------|--------|-----------|
| `/admin/dashboard` | GET | "Dashboard Admin" |
| `/admin/produk` | GET | "Manajemen Produk" |
| `/admin/produk/tambah` | POST | "Produk ditambahkan" |

### 4. Response JSON

Buat route `/api/produk` yang mengembalikan data produk dalam format JSON (bisa copy dari data array yang sama).

### 5. Halaman 404 Kustom

Buat route `/produk/{id}` — jika ID tidak ditemukan di array, kembalikan response dengan status code 404 dan pesan "Produk tidak ditemukan".

---

## Ketentuan Pengumpulan

- Kumpulkan file `routes/web.php` dan `app/Http/Controllers/ProductController.php`
- Sertakan screenshot hasil setiap route di browser
- Batas pengumpulan: sebelum pertemuan berikutnya

---

## Rubrik Penilaian

| Aspek | Bobot |
|-------|-------|
| Route & Controller dasar (index, show, kategori) | 30% |
| Named route & redirect | 20% |
| Route group prefix admin | 15% |
| Response JSON | 15% |
| Penanganan error 404 kustom | 10% |
| Kerapihan kode & dokumentasi | 10% |
