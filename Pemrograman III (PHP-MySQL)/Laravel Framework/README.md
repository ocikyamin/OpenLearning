# Laravel Framework — Pemrograman III (PHP-MySQL)

**Pengajar:** Abdul Yamin, S.Pd., M.Kom  
**Framework:** Laravel 13  
**Semester:** Ganjil/Genap 2025/2026

Repositori ini berisi bahan ajar, modul, dan contoh proyek untuk mata kuliah **Pemrograman III** dengan fokus pada pengembangan web menggunakan **Laravel Framework** dan **MySQL**.

---

## Tujuan Pembelajaran

Setelah mengikuti perkuliahan ini, mahasiswa diharapkan mampu:

- Memahami konsep **HTTP** dan arsitektur **MVC** pada Laravel
- Mengelola **routing** dan **controller**
- Membangun tampilan dengan **Blade Templating**
- Mengelola database menggunakan **Migration** dan **Eloquent ORM**
- Membangun **relasi antar tabel** (one-to-one, one-to-many, many-to-many)
- Memvalidasi input menggunakan **Form Request & Validation**
- Menerapkan **Authentication** & **Middleware**
- Mengupload dan mengelola **file**
- Membuat komponen interaktif dengan **Livewire**

---

## Prasyarat

Sebelum memulai, pastikan perangkat Anda telah terinstall:

| Software | Versi Minimal |
|----------|--------------|
| PHP | ≥ 8.3 (disarankan PHP 8.4) |
| Composer | ≥ 2.x |
| MySQL / MariaDB | ≥ 8.0 / 10.4 |
| Node.js | ≥ 18.x |
| Git | ≥ 2.x |
| Web Browser | Modern (Chrome/Edge/Firefox) |

> **Catatan:** Disarankan menggunakan **Laragon** (Windows) untuk kemudahan pengelolaan lingkungan pengembangan.

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
Setiap folder `BAB-01-*` sampai `BAB-10-*` berisi materi sesuai silabus. Mulai dari [BAB 1](BAB-01-HTTP-Dasar/README.md).

### 4. Kerjakan Tugas
Soal tugas tersedia di folder [`Tugas/`](Tugas/).

---

## Struktur Folder

```
📁 Laravel Framework/
├── 📁 00-Persiapan/                         → Panduan setup environment
├── 📁 BAB-01-HTTP-Dasar/                    → BAB 1: HTTP & Postman
├── 📁 BAB-02-Pengantar-Laravel-dan-MVC/     → BAB 2: Pengantar & MVC
├── 📁 BAB-03-Routing-dan-Controller/        → BAB 3: Route & Controller
├── 📁 BAB-04-Blade-Templating/              → BAB 4: Blade templating
├── 📁 BAB-05-Migration-dan-Eloquent-ORM/    → BAB 5: Migration & ORM
├── 📁 BAB-06-Relasi-Database/               → BAB 6: Relasi antar tabel
├── 📁 BAB-07-Form-Request-dan-Validation/   → BAB 7: Validasi form
├── 📁 BAB-08-Authentication-dan-Middleware/ → BAB 8: Login & otorisasi
├── 📁 BAB-09-Upload-File-dan-Storage/       → BAB 9: Upload file
├── 📁 BAB-10-Livewire/                      → BAB 10: Livewire
├── 📁 Referensi/                            → Cheatsheet & link
├── 📁 Tugas/                                → Soal tugas per BAB
└── README.md                                → Dokumentasi utama
```

---

## Silabus / Materi Perkuliahan

| BAB | Topik | Materi | Tugas | Status |
|-----|-------|--------|-------|--------|
| 1 | HTTP Dasar & Postman | [📖](BAB-01-HTTP-Dasar/README.md) | [📝](Tugas/tugas-01.md) | ✅ |
| 2 | Pengenalan Laravel & Konsep MVC | [📖](BAB-02-Pengantar-Laravel-dan-MVC/README.md) | [📝](Tugas/tugas-02.md) | ✅ |
| 3 | Routing & Controller | [📖](BAB-03-Routing-dan-Controller/README.md) | [📝](Tugas/tugas-03.md) | ✅ |
| 4 | Blade Templating & Layout | [📖](BAB-04-Blade-Templating/README.md) | [📝](Tugas/tugas-04.md) | ✅ |
| 5 | Migration & Eloquent ORM | [📖](BAB-05-Migration-dan-Eloquent-ORM/README.md) | [📝](Tugas/tugas-05.md) | ✅ |
| 6 | Relasi Database (1:1, 1:N, N:N) | [📖](BAB-06-Relasi-Database/README.md) | [📝](Tugas/tugas-06.md) | ✅ |
| 7 | Form Request & Validation | [📖](BAB-07-Form-Request-dan-Validation/README.md) | [📝](Tugas/tugas-07.md) | ✅ |
| 8 | Authentication & Middleware | [📖](BAB-08-Authentication-dan-Middleware/README.md) | [📝](Tugas/tugas-08.md) | ✅ |
| 9 | Upload File & Storage | [📖](BAB-09-Upload-File-dan-Storage/README.md) | [📝](Tugas/tugas-09.md) | ✅ |
| 10 | Livewire | [📖](BAB-10-Livewire/README.md) | [📝](Tugas/tugas-10.md) | ✅ |

> ✅ = Materi tersedia | 📝 = Tugas tersedia

---

## Referensi

- [Laravel 13 Documentation](https://laravel.com/docs/13.x)
- [Eloquent ORM Documentation](https://laravel.com/docs/13.x/eloquent)
- [MySQL Documentation](https://dev.mysql.com/doc/)
- [Livewire Documentation](https://livewire.laravel.com/)
- [Composer Documentation](https://getcomposer.org/doc/)
- [Laracasts - Learn Laravel](https://laracasts.com)

---

## Kontributor

| Nama | Peran |
|------|-------|
| Abdul Yamin, S.Pd., M.Kom | Dosen Pengampu |

---

## Lisensi

Repositori ini digunakan untuk kepentingan pendidikan dan pengajaran. Silakan digunakan dan dikembangkan sesuai kebutuhan.
