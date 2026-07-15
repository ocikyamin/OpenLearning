# Tugas 7 — Form Request & Validation

---

## Tujuan

Mahasiswa mampu membuat form dengan validasi menggunakan Form Request, menampilkan error messages, menangani old input, dan menampilkan flash data.

---

## Soal

### 1. Persiapan

Buat project baru dan database MySQL `db_tugas7`.

Buat satu model **Product** dengan migration:

| Kolom | Tipe | Keterangan |
|-------|------|------------|
| `id` | auto-increment | — |
| `name` | string(100) | — |
| `sku` | string(20) | Kode produk, unique |
| `price` | integer | Harga dalam rupiah |
| `stock` | integer | Stok, default 0 |
| `category` | string(50) | — |
| `description` | text | Nullable |
| `is_active` | boolean | Default true |
| `user_id` | foreign key | → users |
| `timestamps` | — | — |

### 2. Form Request StoreProductRequest

Buat Form Request dengan aturan:

| Field | Aturan | Pesan Error Kustom |
|-------|--------|-------------------|
| `name` | required, max:100 | "Nama produk wajib diisi", "Nama maksimal 100 karakter" |
| `sku` | required, alpha_dash, unique:products | "Kode SKU wajib diisi", "Format SKU tidak valid", "SKU sudah digunakan" |
| `price` | required, integer, min:0 | "Harga wajib diisi", "Harga harus angka", "Harga tidak boleh negatif" |
| `stock` | required, integer, min:0 | — (default) |
| `category` | required, in:Elektronik,Fashion,Makanan,Buku,Olahraga | "Pilih kategori yang valid" |
| `description` | nullable, max:1000 | "Deskripsi maksimal 1000 karakter" |
| `is_active` | boolean | — |

### 3. Form Request UpdateProductRequest

Buat Form Request untuk update dengan aturan yang sama, kecuali `sku` bersifat **unique tapi ignore produk yang sedang diedit**.

### 4. Resource Controller

Buat `ProductController --resource` lengkap:
- `index` — daftar produk, paginate 10
- `create` — form tambah
- `store` — simpan dengan `StoreProductRequest`
- `show` — detail produk
- `edit` — form edit
- `update` — update dengan `UpdateProductRequest`
- `destroy` — hapus produk

Setiap redirect harus menyertakan flash message `success`.

### 5. View

Buat layout utama dan halaman-halaman berikut:

**Halaman daftar:** tabel produk dengan kolom No, Nama, SKU, Harga, Stok, Kategori, Status (Aktif/Nonaktif), Aksi (Edit/Hapus). Tambah tombol "Tambah Produk".

**Halaman form (create & edit):**
- Gunakan layout yang sama
- Tampilkan error per field dengan `@error`
- Gunakan `old()` untuk mengisi nilai setelah gagal validasi
- Gunakan `@selected`, `@checked` untuk select dan checkbox
- Tampilkan `@csrf` dan `@method` yang sesuai

**Halaman detail:** tampilkan semua informasi produk.

**Flash message:** tampilkan alert hijau di layout jika ada session success.

### 6. Validasi Kustom (Opsional)

Buat `Rule` kustom `StockSufficient` yang memvalidasi bahwa stok tidak boleh melebihi 999. Gunakan di Form Request.

---

## Ketentuan Pengumpulan

- Kumpulkan: migration, model, Form Request (Store & Update), controller, routes, semua view
- Sertakan screenshot: hasil submit form kosong (tampilkan error), hasil sukses simpan (flash message), hasil edit dengan slug duplikat (tampilkan error unique)

---

## Rubrik Penilaian

| Aspek | Bobot |
|-------|-------|
| Form Request (Store & Update) dengan aturan lengkap | 25% |
| Form Request Update dengan ignore unique | 10% |
| Resource Controller & Route | 15% |
| View form (old, error, selected, checked) | 25% |
| Flash message & layout | 10% |
| Validasi kustom (opsional) | 10% |
| Kerapihan kode | 5% |
