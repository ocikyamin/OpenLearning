# Laravel Framework - Pemrograman III (PHP-MySQL)

**Pengajar:** Abdul Yamin, S.Pd., M.Kom  
**Framework:** Laravel 13  
**Semester:** Ganjil/Genap 2025/2026

Repositori ini berisi bahan ajar, modul, dan contoh proyek untuk mata kuliah **Pemrograman III** dengan fokus pada pengembangan web menggunakan **Laravel Framework** dan **MySQL**.

---

## Tujuan Pembelajaran

Setelah mengikuti perkuliahan ini, mahasiswa diharapkan mampu:

- Memahami arsitektur **MVC** (Model-View-Controller) pada Laravel
- Mengelola **routing** dan **controller**
- Membangun tampilan dengan **Blade Templating**
- Mengelola database menggunakan **Migration** dan **Eloquent ORM**
- Membangun **relasi antar tabel** (one-to-one, one-to-many, many-to-many)
- Memvalidasi input menggunakan **Form Request & Validation**
- Menerapkan **Authentication** & **Middleware**
- Membangun **REST API** dasar dengan Laravel
- Mengintegrasikan Laravel dengan **MySQL**

---

## Prasyarat

Sebelum memulai, pastikan perangkat Anda telah terinstall:

| Software | Versi Minimal |
|----------|--------------|
| PHP | ≥ 8.3 (disarankan PHP 8.4) |
| Composer | ≥ 2.x |
| MySQL / MariaDB | ≥ 8.0 / 10.4 |
| Node.js / Bun | ≥ 18.x |
| Git | ≥ 2.x |
| Web Browser | Modern (Chrome/Edge/Firefox) |

> **Catatan:** Disarankan menggunakan **Laragon** (Windows) atau **Herd** (Mac) untuk kemudahan pengelolaan lingkungan pengembangan.  
> Laravel 13 membutuhkan **PHP 8.3 minimal** (PHP 8.4 direkomendasikan).

---

## Struktur Folder

```
📁 Laravel Framework/
├── 📁 Laravel Basic/        → Proyek Laravel dasar (praktikum)
├── 📁 Modul/                → Modul ajar (PDF / DOC) [jika ada]
├── 📁 Contoh/               → Contoh kode tambahan [jika ada]
└── README.md                → Dokumentasi repositori
```

---

## Cara Menggunakan Repositori

### 1. Clone Repositori
```bash
git clone https://github.com/<username>/<repository>.git
cd "Laravel Framework/Laravel Basic"
```

### 2. Buat Project
```bash
laravel new nama-project
```
Ikuti pertanyaan interaktif: pilih **None** (starter kit), **PHPUnit**, dan **SQLite** (atau **MySQL**).

### 3. Install & Build Frontend
```bash
npm install && npm run build
```

### 4. Konfigurasi Database (Jika Pilih MySQL)
Sesuaikan file `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel_basic
DB_USERNAME=root
DB_PASSWORD=
```
Jalankan migration:
```bash
php artisan migrate
```

### 5. Jalankan Server
```bash
composer run dev
```
Akses di browser: `http://localhost:8000`

---

## Silabus / Materi Perkuliahan

| Pertemuan | Topik | Status |
|-----------|-------|--------|
| 1 | Pengenalan Laravel & Konsep MVC | ⬜ |
| 2 | Routing & Controller | ⬜ |
| 3 | Blade Templating & Layout | ⬜ |
| 4 | Migration & Schema Builder | ⬜ |
| 5 | Eloquent ORM & Query Builder | ⬜ |
| 6 | Relasi Database (1:1, 1:N, N:N) | ⬜ |
| 7 | Form Request & Validation | ⬜ |
| 8 | Authentication & Middleware | ⬜ |
| 9 | File Upload & Storage | ⬜ |
| 10 | REST API Dasar | ⬜ |
| 11 | Testing Dasar (PHPUnit/Pest) | ⬜ |
| 12 | Project Akhir | ⬜ |

> Status akan diisi saat materi sudah tersedia (`✅` = selesai, `⬜` = belum).

---

## Aturan Penulisan Kode

Agar kode tetap konsisten dan mudah dipahami, ikuti panduan berikut:

- Ikuti **PSR-12** standar penulisan PHP
- Gunakan **Eloquent** daripada raw SQL query
- Terapkan **Route Model Binding** bila memungkinkan
- Gunakan **Form Request** untuk validasi
- Simpan logic bisnis di **Service Class** (bukan di Controller)
- Tulis **docblock** pada method/function

---

## Referensi

- [Laravel 13 Documentation](https://laravel.com/docs/13.x)
- [Eloquent ORM Documentation](https://laravel.com/docs/13.x/eloquent)
- [MySQL Documentation](https://dev.mysql.com/doc/)
- [Composer Documentation](https://getcomposer.org/doc/)
- [Laracasts - Learn Laravel](https://laracasts.com)
- [Laravel Herd (Mac/Windows)](https://herd.laravel.com)

---

## Kontributor

| Nama | Peran |
|------|-------|
| Abdul Yamin, S.Pd., M.Kom | Dosen Pengampu |

---

## Lisensi

Repositori ini digunakan untuk kepentingan pendidikan dan pengajaran. Silakan digunakan dan dikembangkan sesuai kebutuhan.