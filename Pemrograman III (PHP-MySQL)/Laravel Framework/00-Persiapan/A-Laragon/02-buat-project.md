# Membuat Project Laravel di Laragon

Setelah Laragon terinstall dan Laravel installer siap, langkah berikutnya adalah membuat project Laravel pertama kita.

---

## Langkah 1 — Buka Terminal Laragon

1. Pastikan Laragon sudah **Start All** (tombol hijau)
2. Klik tombol **Terminal** (ikon >_) di pojok kanan bawah Laragon
3. Akan terbuka jendela hitam (command line)

> Terminal ini khusus untuk Laragon. Perintah yang kita ketik di sini akan langsung terhubung dengan PHP dan Composer yang sudah disediakan Laragon.

---

## Langkah 2 — Buat Project Laravel dengan Laravel Installer

```bash
cd C:\laragon\www
laravel new belajar-laravel
```

Perintah ini akan menampilkan beberapa pertanyaan interaktif. Jawab saja seperti berikut:

```
┌──────────────────────────────────────────────┐
│  Laravel Installer                           │
│                                              │
│  What starter kit? → None                    │
│  Which testing framework? → PHPUnit          │
│  Which database? → SQLite (default)          │
│  Will you use Pest? → no                     │
└──────────────────────────────────────────────┘
```

| Pertanyaan | Jawaban | Keterangan |
|------------|---------|------------|
| **What starter kit?** | `None` | Kita akan belajar dari dasar, tanpa starter kit |
| **Which testing framework?** | `PHPUnit` | Paling umum dan mudah |
| **Which database?** | `SQLite` (default) atau `MySQL` | **SQLite** dipilih agar langsung jalan tanpa setup database. Jika ingin pakai MySQL, pilih MySQL |
| **Will you use Pest?** | `no` | Kita akan pakai PHPUnit biasa |

> **Mengapa disarankan SQLite dulu?** Karena SQLite tidak perlu setup server database terpisah. File database langsung dibuat otomatis oleh Laravel. Kita bisa ganti ke MySQL nanti saat materi database tiba.

Proses ini akan memakan waktu 3-10 menit tergantung kecepatan internet. Jika berhasil, akan muncul:

```
✔  Application ready! Build something amazing.
```

---

## Langkah 3 — Jalankan Project

Pertama, install dependency frontend:

```bash
cd belajar-laravel
npm install && npm run build
```

Lalu jalankan server development:

```bash
composer run dev
```

Perintah `composer run dev` ini akan menjalankan tiga hal sekaligus:
- **Laravel development server** di `http://localhost:8000`
- **Vite** untuk kompilasi CSS/JavaScript
- **Queue worker** (untuk antrian pekerjaan)

> **Catatan:** Terminal harus tetap terbuka selama coding. Jika ditutup, server akan mati.

---

## Langkah 4 — Akses Project di Browser

1. Buka browser (Chrome/Edge/Firefox)
2. Ketik alamat: [http://localhost:8000](http://localhost:8000)

Jika muncul halaman Laravel dengan logo dan tulisan "Laravel", berarti sukses 🎉

---

## Langkah 5 — Alternatif: Pakai Apache Laragon (Tanpa `composer run dev`)

Jika teman-teman lebih nyaman menggunakan Apache bawaan Laragon (sehingga tidak perlu `composer run dev`):

1. Pastikan Laragon sudah **Start All**
2. Klik kanan icon Laragon → **Preferences** → centang **Auto Virtual Hosts**
3. Restart Laragon
4. Akses: `http://belajar-laravel.test`

Laragon akan otomatis mengenali folder `belajar-laravel` dan menyajikannya lewat Apache.

---

## Jika Memilih MySQL (Bukan SQLite)

Pada langkah 2, jika teman-teman memilih **MySQL** saat `laravel new`, ada beberapa langkah tambahan:

### A. Buat Database

#### Via phpMyAdmin (Mudah)

1. Buka browser, ketik: `http://localhost/phpmyadmin`
2. Klik tab **Databases**
3. Pada kolom **Create database**, ketik: `belajar_laravel`
4. Pilih **utf8mb4_general_ci** → **Create**

#### Via Terminal

```bash
mysql -u root -p
```
(Password: kosong, langsung Enter)

```sql
CREATE DATABASE belajar_laravel CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
EXIT;
```

### B. Sesuaikan File .env

Buka file `.env` di folder project, cari dan sesuaikan:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=belajar_laravel
DB_USERNAME=root
DB_PASSWORD=
```

### C. Jalankan Migration

```bash
cd C:\laragon\www\belajar-laravel
php artisan migrate
```

Jika muncul:

```
Migration table created successfully.
Migrating: 2014_10_12_000000_create_users_table
```

Berhasil ✅

---

## Ringkasan Perintah Penting

| Perintah | Fungsi |
|----------|--------|
| `laravel new nama-project` | Buat project Laravel baru (interaktif) |
| `npm install && npm run build` | Install & build asset frontend |
| `composer run dev` | Jalankan server + Vite + queue |
| `php artisan migrate` | Jalankan migration database |
| `php artisan make:controller NamaController` | Buat controller baru |

---

**Lanjut ke:** [Error yang Sering Terjadi →](03-error-sering.md)
