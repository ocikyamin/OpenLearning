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
├── 📁 00-Persiapan/                             → Panduan setup environment
├── 📁 BAB-01-Pengantar-Laravel-dan-MVC/         → BAB 1: Pengantar & MVC
├── 📁 BAB-02-Routing-dan-Controller/            → BAB 2: Route & Controller
├── 📁 BAB-03-Blade-Templating/                  → BAB 3: Blade templating
├── 📁 BAB-04-Migration-dan-Eloquent-ORM/        → BAB 4: Migration & ORM
├── 📁 BAB-05-Relasi-Database/                   → BAB 5: Relasi antar tabel
├── 📁 BAB-06-Form-Request-dan-Validation/       → BAB 6: Validasi form
├── 📁 BAB-07-Authentication-dan-Middleware/     → BAB 7: Login & register
├── 📁 BAB-08-REST-API/                          → BAB 8: API dasar
├── 📁 Referensi/                                → Cheatsheet & link
├── 📁 Tugas/                                    → Soal tugas per BAB
└── README.md                                    → Dokumentasi utama
```

---

## Cara Menggunakan Repositori

Repositori ini berisi **dokumentasi bahan ajar**, bukan project Laravel. Setiap mahasiswa diharapkan membuat project Laravel sendiri di laptop masing-masing.

### 1. Clone Repositori
```bash
git clone https://github.com/<username>/<repository>.git
cd "Laravel Framework"
```

### 2. Ikuti Panduan Setup
Baca folder [`00-Persiapan/`](00-Persiapan/Pilih-Jalur.md) untuk menyiapkan environment pengembangan.

### 3. Baca Materi Per BAB
Setiap folder `BAB-01-*` sampai `BAB-08-*` berisi materi sesuai silabus. Mulai dari [BAB 1](BAB-01-Pengantar-Laravel-dan-MVC/README.md).

### 4. Kerjakan Tugas
Soal tugas tersedia di folder [`Tugas/`](Tugas/).

---

## Silabus / Materi Perkuliahan

| BAB | Topik | Materi | Tugas | Status |
|-----|-------|--------|-------|--------|
| 1 | Pengenalan Laravel & Konsep MVC | [📖](BAB-01-Pengantar-Laravel-dan-MVC/README.md) | [📝](Tugas/tugas-01.md) | ✅ |
| 2 | Routing & Controller | [📖](BAB-02-Routing-dan-Controller/README.md) | [📝](Tugas/tugas-02.md) | ✅ |
| 3 | Blade Templating & Layout | [📖](BAB-03-Blade-Templating/README.md) | [📝](Tugas/tugas-03.md) | ✅ |
| 4 | Migration & Eloquent ORM | [📖](BAB-04-Migration-dan-Eloquent-ORM/README.md) | 📝 | ✅ |
| 5 | Relasi Database (1:1, 1:N, N:N) | [📖](BAB-05-Relasi-Database/README.md) | 📝 | ⬜ |
| 6 | Form Request & Validation | [📖](BAB-06-Form-Request-dan-Validation/README.md) | 📝 | ⬜ |
| 7 | Authentication & Middleware | [📖](BAB-07-Authentication-dan-Middleware/README.md) | 📝 | ⬜ |
| 8 | REST API Dasar | [📖](BAB-08-REST-API/README.md) | 📝 | ⬜ |
| 9 | File Upload & Storage | *(opsional)* | 📝 | ⬜ |
| 10 | Testing Dasar (PHPUnit/Pest) | *(opsional)* | 📝 | ⬜ |
| 11 | Deployment | *(opsional)* | 📝 | ⬜ |
| 12 | Project Akhir | — | 🎯 | ⬜ |

> ✅ = Materi tersedia | ⬜ = Belum tersedia | 🎯 = Tugas akhir

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