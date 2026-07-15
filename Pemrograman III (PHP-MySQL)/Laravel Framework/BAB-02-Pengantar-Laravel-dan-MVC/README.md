# BAB 2 — Pengantar Laravel & Konsep MVC

---

## 2.1 Tujuan Pembelajaran

Setelah menyelesaikan BAB 2 ini, teman-teman diharapkan mampu:

- Menjelaskan apa itu Laravel dan mengapa kita perlu menggunakannya
- Memahami arsitektur MVC (Model-View-Controller) sebagai fondasi Laravel
- Mengenal struktur folder project Laravel
- Menggunakan Artisan CLI untuk perintah-perintah dasar
- Membuat project Laravel pertama dan menampilkan halaman di browser

---

## 2.2 Pendahuluan

Pernahkah teman-teman membangun website menggunakan PHP native? Biasanya kita mencampur kode PHP, HTML, dan query SQL dalam satu file. Semakin besar aplikasinya, semakin sulit mengelola kode tersebut. Di sinilah **framework** hadir sebagai solusi.

**Laravel** adalah framework PHP yang dirancang untuk membuat pengembangan web menjadi lebih cepat, rapi, dan menyenangkan. Laravel menggunakan arsitektur **MVC (Model-View-Controller)** yang memisahkan logika aplikasi, tampilan, dan data. Dengan pemisahan ini, kode kita menjadi lebih terstruktur, mudah dipelihara, dan bisa dikerjakan oleh tim.

Laravel pertama kali dirilis pada tahun 2011 oleh Taylor Otwell. Hingga tahun 2026, Laravel telah mencapai versi **13.x** dan menjadi salah satu framework PHP paling populer di dunia.

---

## 2.3 Mengapa Memilih Laravel?

Mungkin teman-teman bertanya, "Apa bedanya Laravel dengan PHP biasa?" Mari kita lihat perbandingannya:

| Aspek | PHP Native | Laravel |
|-------|-----------|---------|
| Routing | Manual (if-else) | Terstruktur dan ekspresif |
| Database | Query SQL mentah | Eloquent ORM yang elegan |
| Template | Campur logic di HTML | Blade templating engine |
| Keamanan | Manual | CSRF, XSS, SQL injection built-in |
| Migrasi DB | Manual | Migration & Seeder otomatis |

### 2.3.1 Fitur Unggulan Laravel 13

- **Eloquent ORM** — berinteraksi dengan database menggunakan sintaks PHP yang intuitif, tanpa menulis SQL secara langsung
- **Blade Templating** — engine template yang ringan dan powerful, namun tetap mengizinkan kita menggunakan kode PHP biasa
- **Routing** — pendefinisian alamat URL yang bersih dan terorganisir
- **Artisan CLI** — alat bantu dari terminal untuk berbagai tugas seperti membuat controller, model, migrasi, dan lain-lain
- **Migration** — version control untuk database, memudahkan kita mengubah struktur tabel tanpa kehilangan data
- **Middleware** — filter untuk HTTP request, misalnya untuk memastikan pengguna sudah login sebelum mengakses halaman tertentu
- **Queue & Jobs** — pemrosesan tugas latar belakang, seperti mengirim email atau memproses file
- **Testing** — dukungan penuh untuk unit test dan feature test menggunakan PHPUnit atau Pest

---

## 2.4 Konsep MVC

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

### 2.4.1 Penjelasan Tiap Komponen

| Komponen | Tugas | Analogi Restoran |
|----------|-------|------------------|
| **Model** | Mengelola data dan logika bisnis, berinteraksi dengan database | Dapur — menyiapkan makanan |
| **View** | Menampilkan data ke pengguna dalam bentuk halaman HTML | Piring — tempat penyajian makanan |
| **Controller** | Menghubungkan Model dan View, memproses input dari pengguna | Pelayan — menerima pesanan dan mengantarkannya |

### 2.4.2 Alur Request di Laravel

Agar lebih mudah dipahami, mari kita lihat bagaimana sebuah request dari browser diproses oleh Laravel:

1. **Browser** mengirim request ke URL tertentu (misalnya `http://localhost:8000/about`)
2. **Router** mencocokkan URL tersebut dengan route yang sudah didefinisikan di file `routes/web.php`
3. **Route** mengarahkan request ke method Controller yang sesuai
4. **Controller** berkomunikasi dengan Model jika perlu mengambil atau menyimpan data
5. **Model** mengambil atau menyimpan data dari database
6. **Controller** mengirim data yang sudah diproses ke View
7. **View** merender halaman HTML dan mengirimkannya kembali ke browser

---

## 2.5 Praktikum: Membuat Project Laravel Pertama

Pada praktikum kali ini, kita akan membuat project Laravel dari awal dan menampilkan halaman pertama. Pastikan teman-teman sudah menyelesaikan setup environment terlebih dahulu. Jika belum, silakan ikuti panduan di folder **00-Persiapan/**.

### 2.5.1 Prasyarat

Sebelum memulai praktikum, pastikan hal-hal berikut sudah siap:

- PHP minimal versi 8.3 (disarankan 8.4) sudah terinstall
- Composer sudah terinstall
- Web browser (Chrome, Firefox, atau Edge)
- Terminal atau command prompt

> **Bagi yang belum melakukan instalasi**, silakan buka folder `00-Persiapan/` dan pilih jalur yang sesuai: **Laragon** untuk pengguna Windows, atau **WSL + Ubuntu** untuk pengguna yang menggunakan WSL.

### 2.5.2 Membuat Project Laravel Baru

Buka terminal atau command prompt, lalu jalankan perintah berikut:

```bash
composer create-project laravel/laravel belajar-laravel
```

Perintah di atas akan:
- Mengunduh Laravel versi terbaru (13.x) beserta seluruh dependensinya
- Membuat folder baru bernama `belajar-laravel`
- Mengatur file `.env` dan generate application key secara otomatis

Proses ini membutuhkan waktu beberapa menit tergantung kecepatan internet. Jika berhasil, kita akan melihat folder baru bernama `belajar-laravel`.

### 2.5.3 Masuk ke Folder Project

Setelah project berhasil dibuat, masuk ke dalam folder tersebut:

```bash
cd belajar-laravel
```

Semua perintah Laravel selanjutnya harus dijalankan dari dalam folder project ini.

### 2.5.4 Menjalankan Development Server

Laravel memiliki server bawaan untuk keperluan pengembangan. Jalankan perintah berikut:

```bash
php artisan serve
```

Atau bisa juga menggunakan:

```bash
composer run dev
```

Setelah perintah dijalankan, kita akan melihat output seperti ini:

```
INFO  Server running on [http://127.0.0.1:8000].
```

Artinya, server Laravel sudah berjalan. Buka browser dan ketik alamat: **http://localhost:8000**

Kita akan melihat halaman selamat datang (welcome page) bawaan Laravel. Selamat! Project Laravel pertama kita sudah berhasil berjalan.

> **Catatan:** Biarkan terminal tetap terbuka selama proses pengembangan. Untuk menghentikan server, tekan `Ctrl + C`.

### 2.5.5 Mengenal Struktur Folder Project

Sebelum kita mulai menulis kode, penting untuk memahami struktur folder project Laravel. Berikut penjelasan folder-folder utama yang akan sering kita akses:

```
belajar-laravel/
├── app/                    → Inti aplikasi — berisi Controller, Model, dan logika utama
│   ├── Http/
│   │   ├── Controllers/    → Tempat menyimpan Controller
│   │   └── Middleware/     → Tempat menyimpan Middleware
│   └── Models/             → Tempat menyimpan Eloquent Model
├── bootstrap/              → File bootstrap untuk menjalankan framework
├── config/                 → File konfigurasi aplikasi (database, mail, dll)
├── database/               → Migration, factory, dan seeder
│   └── migrations/         → File migrasi untuk membuat/mengubah tabel
├── public/                 → Satu-satunya folder yang bisa diakses publik (document root)
├── resources/              → File view (Blade), CSS, dan JavaScript
│   └── views/              → Tempat menyimpan file template Blade
├── routes/                 → Definisi route aplikasi
│   ├── web.php             → Route untuk keperluan web (browser)
│   └── api.php             → Route untuk keperluan API
├── storage/                → Tempat log, cache, dan file upload
├── tests/                  → Unit test dan feature test
├── .env                    → Konfigurasi environment (jangan di-commit ke git)
├── artisan                 → File untuk menjalankan perintah Artisan CLI
├── composer.json           → Daftar dependency PHP
├── package.json            → Daftar dependency frontend (JavaScript/CSS)
└── vite.config.js          → Konfigurasi Vite untuk bundling asset
```

**Folder yang paling sering kita akses:**

| Folder | Fungsinya |
|--------|-----------|
| `routes/web.php` | Mendefinisikan URL aplikasi |
| `app/Http/Controllers/` | Menyimpan Controller |
| `app/Models/` | Menyimpan Model |
| `resources/views/` | Menyimpan file Blade (tampilan) |
| `database/migrations/` | Menyimpan file migrasi tabel |
| `config/` | Konfigurasi aplikasi |

### 2.5.6 Mengenal Artisan CLI

**Artisan** adalah command-line tool bawaan Laravel. Kita bisa menjalankannya melalui terminal dengan format:

```bash
php artisan <perintah>
```

Berikut perintah-perintah dasar yang akan sering kita gunakan:

| Perintah | Fungsi |
|----------|--------|
| `php artisan list` | Melihat semua perintah yang tersedia |
| `php artisan serve` | Menjalankan development server |
| `php artisan make:controller NamaController` | Membuat controller baru |
| `php artisan make:model NamaModel` | Membuat model baru |
| `php artisan make:migration create_nama_tabel` | Membuat file migrasi |
| `php artisan migrate` | Menjalankan semua migrasi |
| `php artisan migrate:fresh` | Menghapus tabel lalu migrasi ulang |
| `php artisan key:generate` | Generate application key |
| `php artisan tinker` | Interactive shell untuk mencoba kode |
| `php artisan route:list` | Melihat semua route yang terdaftar |
| `php artisan cache:clear` | Menghapus cache |

### 2.5.7 Membuat Halaman Pertama dengan Route

Sekarang kita akan membuat halaman sederhana sendiri. Bukalah file `routes/web.php` dengan code editor. Di dalamnya, kita akan melihat kode berikut:

```php
<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
```

Apa arti kode di atas?

- `Route::get('/')` — Jika pengguna mengakses URL utama (root) yaitu `http://localhost:8000/`
- `function () { return view('welcome'); }` — Maka tampilkan file view bernama `welcome.blade.php` yang ada di folder `resources/views/`

Sekarang, mari kita buat route baru. Tambahkan kode berikut di bawah route yang sudah ada:

```php
Route::get('/halo', function () {
    return 'Halo, ini Laravel pertamaku!';
});
```

Simpan file tersebut. Buka browser dan akses: **http://localhost:8000/halo**

Jika muncul tulisan **"Halo, ini Laravel pertamaku!"** di browser, berarti routing sudah berfungsi dengan baik.

### 2.5.8 Membuat Halaman dengan File View (Blade)

Selanjutnya, kita akan membuat halaman menggunakan file Blade. Blade adalah template engine bawaan Laravel yang akan kita pelajari lebih dalam di BAB 4.

Buat file baru di `resources/views/halo.blade.php`:

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
    <p>Ini adalah view pertama saya menggunakan Blade.</p>
</body>
</html>
```

Sekarang, ubah route yang kita buat tadi di `routes/web.php` menjadi seperti berikut:

```php
Route::get('/halo', function () {
    return view('halo');
});
```

Refresh browser di **http://localhost:8000/halo**. Halaman akan berubah sesuai dengan file blade yang kita buat.

---

## 2.6 Rangkuman

| Konsep | Intinya |
|--------|---------|
| Laravel | Framework PHP open-source dengan arsitektur MVC |
| MVC | Model (data), View (tampilan), Controller (logika) |
| Routes/web.php | Tempat mendefinisikan URL aplikasi |
| Artisan | CLI tool untuk membantu pengembangan |
| Blade | Template engine Laravel dengan ekstensi `.blade.php` |
| `php artisan serve` | Perintah untuk menjalankan server development |

---

## 2.7 Referensi

- [Dokumentasi Laravel 13](https://laravel.com/docs/13.x)
- [Laravel Directory Structure](https://laravel.com/docs/13.x/structure)
- [Artisan Console](https://laravel.com/docs/13.x/artisan)
- [Laracasts: Laravel From Scratch](https://laracasts.com/series/laravel-from-scratch)

---

## 2.8 Bahan Pendukung

- `slide.pdf` — belum tersedia
- `video.md` — link video pendukung

---

**Kembali ke:** [BAB 1 — HTTP Dasar](../BAB-01-HTTP-Dasar/README.md)

**Lanjut ke:** [BAB 3 — Routing & Controller](../BAB-03-Routing-dan-Controller/README.md)
