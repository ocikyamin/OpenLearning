# Pertemuan 1 — Pengantar Laravel & Konsep MVC

---

## Tujuan Pembelajaran

Setelah pertemuan ini, mahasiswa diharapkan mampu:

- Menjelaskan apa itu Laravel dan mengapa menggunakannya
- Memahami arsitektur MVC (Model-View-Controller)
- Mengetahui struktur folder project Laravel
- Menggunakan Artisan CLI untuk perintah dasar
- Menjalankan project Laravel dan menampilkan halaman pertama

---

## Apa Itu Laravel?

Laravel adalah **framework PHP** untuk pengembangan web dengan arsitektur **MVC**. Laravel dirilis pertama kali tahun 2011 oleh Taylor Otwell. Saat ini (2026) sudah mencapai versi **13.x**.

### Mengapa Laravel?

| Dibanding PHP Native | Keuntungan Laravel |
|----------------------|--------------------|
| Routing manual | Routing terstruktur dan ekspresif |
| Query SQL mentah | Eloquent ORM yang elegan |
| Template campur logic | Blade templating engine |
| Keamanan manual | Proteksi CSRF, XSS, SQL injection built-in |
| Testing manual | PHPUnit/Pest terintegrasi |
| Migrasi database manual | Migration & Seeder otomatis |

### Fitur Unggulan Laravel 13

- **Eloquent ORM** — interaksi database dengan sintaks PHP yang intuitif
- **Blade Templating** — engine template yang ringan dan powerful
- **Routing** — definisi route yang bersih dan terorganisir
- **Artisan CLI** — command line工具 untuk berbagai tugas
- **Migration** — version control untuk database
- **Middleware** — filter HTTP request
- **Queue & Jobs** — pemrosesan tugas latar belakang
- **Testing** — dukungan penuh untuk unit test dan feature test

---

## Konsep MVC

MVC adalah pola arsitektur yang memisahkan aplikasi menjadi tiga komponen utama:

```
┌─────────────────────────────────────────────────┐
│                   BROWSER                        │
│                     │                            │
│                     ▼                            │
│              ┌─────────────┐                     │
│              │   ROUTER    │                     │
│              └──────┬──────┘                     │
│                     │                            │
│         ┌───────────┼───────────┐                │
│         ▼           ▼           ▼                │
│   ┌─────────┐ ┌─────────┐ ┌─────────┐           │
│   │  MODEL  │ │  VIEW   │ │CONTROLLER│           │
│   │ (Data)  │ │(Tampilan)│ │ (Logika) │           │
│   └────┬────┘ └─────────┘ └─────────┘           │
│        │                                         │
│        ▼                                         │
│   ┌─────────┐                                    │
│   │ DATABASE│                                    │
│   └─────────┘                                    │
└─────────────────────────────────────────────────┘
```

### Penjelasan MVC

| Komponen | Tugas | Analogi Restoran |
|----------|-------|------------------|
| **Model** | Mengelola data & logika bisnis, berinteraksi dengan database | Dapur — menyiapkan makanan |
| **View** | Menampilkan data ke pengguna (tampilan HTML/Blade) | Piring — penyajian makanan |
| **Controller** | Menghubungkan Model dan View, memproses input user | Pelayan — menerima pesanan & mengantar |

### Alur Request di Laravel

```
1. Browser mengirim request ke URL tertentu
2. Router mencocokkan URL dengan route yang terdefinisi
3. Route mengarahkan ke Controller method yang sesuai
4. Controller berkomunikasi dengan Model (jika perlu data)
5. Model mengambil/menyimpan data dari database
6. Controller mengirim data ke View
7. View merender HTML dan dikirim ke browser
```

---

## Struktur Folder Laravel

Setelah membuat project Laravel, kita akan melihat struktur folder seperti ini:

```
belajar-laravel/
├── app/                    → Inti aplikasi
│   ├── Http/
│   │   ├── Controllers/    → Controller (logika request)
│   │   └── Middleware/     → Middleware (filter request)
│   ├── Models/             → Eloquent Model (representasi tabel)
│   └── Providers/          → Service Provider
├── bootstrap/              → File bootstrap aplikasi
├── config/                 → Konfigurasi aplikasi
├── database/               → Migration, factory, seeder
│   └── migrations/         → File migrasi tabel
├── public/                 → Document root (satu-satunya folder publik)
├── resources/              → View, CSS, JavaScript
│   └── views/              → File Blade template (.blade.php)
├── routes/                 → Definisi route
│   ├── web.php             → Route untuk web (browser)
│   └── api.php             → Route untuk API
├── storage/                → Log, cache, file upload
├── tests/                  → Unit test & feature test
├── .env                    → Konfigurasi environment (tidak di-commit)
├── artisan                 → CLI Laravel
├── composer.json           → Dependency PHP
├── package.json            → Dependency frontend
└── vite.config.js          → Konfigurasi Vite
```

### Folder Penting yang Sering Kita Akses

| Folder | Fungsinya |
|--------|-----------|
| `routes/web.php` | Tempat mendefinisikan route web |
| `app/Http/Controllers/` | Tempat menyimpan Controller |
| `app/Models/` | Tempat menyimpan Model |
| `resources/views/` | Tempat menyimpan file Blade (tampilan) |
| `database/migrations/` | Tempat menyimpan file migrasi tabel |
| `config/` | Tempat konfigurasi aplikasi |

---

## Artisan CLI

Artisan adalah command-line tool bawaan Laravel. Kita bisa menjalankannya melalui terminal:

```bash
php artisan <perintah>
```

### Perintah Dasar Artisan

| Perintah | Fungsi |
|----------|--------|
| `php artisan list` | Lihat semua perintah yang tersedia |
| `php artisan serve` | Jalankan development server |
| `php artisan make:controller NamaController` | Buat controller baru |
| `php artisan make:model NamaModel` | Buat model baru |
| `php artisan make:migration create_nama_tabel` | Buat file migrasi |
| `php artisan migrate` | Jalankan semua migrasi |
| `php artisan migrate:fresh` | Hapus tabel lalu migrasi ulang |
| `php artisan key:generate` | Generate application key |
| `php artisan tinker` | Interactive shell untuk mencoba kode |
| `php artisan route:list` | Lihat semua route yang terdaftar |
| `php artisan cache:clear` | Hapus cache |

---

## Praktikum: Halaman Pertama

### 1. Buka Project

```bash
cd belajar-laravel
composer run dev
```

### 2. Definisikan Route Pertama

Buka file `routes/web.php`. Kita akan melihat:

```php
<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
```

Kode di atas artinya:
- `Route::get('/')` — Jika user mengakses URL `/` (root)
- `function () { return view('welcome'); }` — Tampilkan file view `welcome.blade.php`

### 3. Buat Route Baru

Tambahkan route kedua di bawah route yang sudah ada:

```php
Route::get('/halo', function () {
    return 'Halo, ini Laravel pertamaku!';
});
```

### 4. Uji Coba

Buka browser, ketik: `http://localhost:8000/halo`

Jika muncul tulisan **"Halo, ini Laravel pertamaku!"**, berarti routing sudah berfungsi ✅

### 5. Buat View Baru

Buat file baru `resources/views/halo.blade.php`:

```html
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halo Laravel</title>
</head>
<body>
    <h1>Halo, Selamat datang di Laravel!</h1>
    <p>Ini adalah view pertama saya.</p>
</body>
</html>
```

Lalu ubah route di `web.php` menjadi:

```php
Route::get('/halo', function () {
    return view('halo');
});
```

Refresh browser → halaman akan berubah sesuai file blade yang kita buat.

---

## Rangkuman

| Konsep | Intinya |
|--------|---------|
| Laravel | Framework PHP dengan arsitektur MVC |
| MVC | Model (data), View (tampilan), Controller (logika) |
| Routes/web.php | Tempat mendefinisikan URL aplikasi |
| Artisan | CLI tool untuk membantu pengembangan |
| Blade | Template engine Laravel (`.blade.php`) |
| `php artisan serve` | Perintah menjalankan server development |

---

## Referensi

- [Dokumentasi Laravel 13](https://laravel.com/docs/13.x)
- [Laravel Directory Structure](https://laravel.com/docs/13.x/structure)
- [Artisan Console](https://laravel.com/docs/13.x/artisan)
- [Laracasts: Laravel From Scratch](https://laracasts.com/series/laravel-from-scratch)

---

## Bahan Pendukung

- `slide.pdf` — belum tersedia
- `video.md` — belum tersedia
- [Link video playlist](video.md)

---

**Lanjut ke:** [Pertemuan 2 — Routing & Controller](../02-Routing-Controller/README.md)
