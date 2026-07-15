# Tugas 9 — Upload File & Storage

---

## Tujuan

Mahasiswa mampu mengimplementasikan upload file, validasi file, menampilkan gambar/download file, dan menghapus file menggunakan Laravel Storage.

---

## Soal

### 1. Persiapan

Buat project baru dan database MySQL `db_tugas9`. Install Breeze (stack Blade) untuk template dasar.

```bash
composer create-project laravel/laravel tugas-upload
cd tugas-upload
composer require laravel/breeze
php artisan breeze:install blade
npm install && npm run build
```

Buat storage link: `php artisan storage:link`

### 2. Migration & Model

Buat tabel **documents** dengan kolom:

| Kolom | Tipe | Keterangan |
|-------|------|------------|
| `id` | auto-increment | Primary key |
| `title` | string(150) | Judul dokumen |
| `file_path` | string(255) | Path file di storage |
| `file_name` | string(255) | Nama asli file |
| `file_type` | string(50) | MIME type |
| `file_size` | integer | Ukuran dalam bytes |
| `description` | text | Nullable, deskripsi dokumen |
| `user_id` | foreign key | → users |
| `timestamps` | — | — |

Buat model `Document` dengan `$fillable` dan `casts()` yang sesuai.

Tambahkan **accessor** `file_size_formatted` yang mengembalikan ukuran file dalam format yang mudah dibaca (B, KB, MB).

### 3. UploadController

Buat `UploadController` dengan method:

| Method | Route | Keterangan |
|--------|-------|------------|
| `index()` | GET `/documents` | Daftar dokumen yang diupload user |
| `create()` | GET `/documents/upload` | Form upload |
| `store()` | POST `/documents` | Proses upload & simpan |
| `show()` | GET `/documents/{document}` | Detail & preview dokumen |
| `download()` | GET `/documents/{document}/download` | Download file |
| `destroy()` | DELETE `/documents/{document}` | Hapus dokumen (file + record) |

Route harus diproteksi dengan middleware `auth`.

### 4. Validasi Upload

Buat Form Request `StoreDocumentRequest` dengan aturan:

| Field | Aturan |
|-------|--------|
| `title` | required, max:150 |
| `file` | required, file, max:5120 (5MB), mimes:jpg,jpeg,png,pdf,doc,docx |
| `description` | nullable, max:500 |

Pesan error kustom:
- `file.max` → "Ukuran file maksimal 5MB"
- `file.mimes` → "Tipe file harus: jpg, jpeg, png, pdf, doc, atau docx"

### 5. View

Buat halaman berikut dengan layout Breeze:

**Daftar Dokumen** (`/documents`):
- Tabel: No, Judul, Tipe File, Ukuran, Tanggal Upload, Aksi (Lihat, Download, Hapus)
- Hanya menampilkan dokumen milik user yang login
- Tidak ada pagination (sederhana saja)

**Form Upload** (`/documents/upload`):
- Field: title (text), file (file input), description (textarea)
- Tampilkan `@error` dan `old()` setelah gagal validasi
- Tampilkan preview upload yang akan dilakukan (gunakan JavaScript sederhana atau cukup tampilkan nama file yang dipilih)

**Detail Dokumen** (`/documents/{document}`):
- Tampilkan semua info dokumen (judul, tipe, ukuran, tanggal, deskripsi)
- Jika file adalah gambar (jpg/jpeg/png), tampilkan preview gambar
- Tombol Download dan Hapus

### 6. Download & Hapus

- **Download:** gunakan `Storage::download()` dengan nama asli file
- **Hapus:** hapus file dari storage menggunakan `Storage::delete()`, lalu hapus record dari database
- Setelah hapus, redirect ke `/documents` dengan flash message "Dokumen berhasil dihapus"

### 7. Bonus (Opsional)

Buat halaman `/documents/gallery` yang menampilkan semua gambar (jpg/jpeg/png) dalam bentuk grid card. Gunakan query scope `images()` di model Document.

---

## Ketentuan Pengumpulan

- Kumpulkan: migration, model, Form Request, controller, route, semua file view
- Sertakan screenshot: form upload (kosong & error), daftar dokumen, detail dengan preview gambar, download berhasil, dan hapus berhasil
- Screenshot folder `storage/app/public/` untuk membuktikan file tersimpan

---

## Rubrik Penilaian

| Aspek | Bobot |
|-------|-------|
| Migration & Model (termasuk accessor) | 15% |
| Form Request & Validasi (aturan + pesan kustom) | 15% |
| Upload + Store (simpan ke storage + database) | 20% |
| View (daftar, form, detail, preview gambar) | 25% |
| Download & Hapus (Storage::download & delete) | 15% |
| Bonus gallery (grid card) | 5% |
| Kerapihan kode | 5% |
