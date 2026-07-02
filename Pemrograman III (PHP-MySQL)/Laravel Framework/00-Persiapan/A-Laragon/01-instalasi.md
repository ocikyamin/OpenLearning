# Instalasi Laragon

Laragon adalah aplikasi all-in-one yang menyediakan Apache, PHP, MySQL, dan berbagai tools lain yang kita butuhkan untuk pengembangan Laravel. Cukup install sekali, semua beres.

---

## Langkah 1 — Download Laragon

1. Buka situs resmi Laragon di [https://laragon.org/download/](https://laragon.org/download/)
2. Cari tulisan **Laragon Full** (bukan Portable, bukan Lite)
3. Klik download, tunggu hingga selesai (ukuran file sekitar 150-200 MB)

> **Mengapa harus Laragon Full?** Karena versi Full sudah menyertakan PHP, MySQL, Composer, Node.js, dan Git sekaligus. Jadi teman-teman tidak perlu menginstal satu per satu.

---

## Langkah 2 — Install Laragon

1. Klik dua kali file installer yang sudah di-download
2. Pilih bahasa **English** (maaf, belum ada bahasa Indonesia)
3. Klik **Next** hingga sampai di halaman pemilihan komponen
4. Pastikan semua komponen berikut **tercentang (✅)** :
    - ✅ Apache
    - ✅ PHP
    - ✅ MySQL atau MariaDB (pilih salah satu)
    - ✅ Composer
    - ✅ Git
    - ✅ Node.js
    - (Yang lain boleh dicentang atau tidak, tidak terlalu penting)
5. Pilih lokasi instalasi. Disarankan:
    - `C:\laragon` (default) — jika drive C: masih lega
    - `D:\laragon` — jika drive C: sudah penuh
6. Klik **Next → Install → Finish**

---

## Langkah 3 — Jalankan Laragon

1. Buka Laragon dari Start Menu atau klik shortcut di desktop
2. Akan muncul jendela Laragon dengan tampilan seperti ini:

   ```
   ┌──────────────────────────────────┐
   │  Laragon                         │
   │                                  │
   │  [Apache] [MySQL] [Start All]    │
   │                                  │
   │  Web  →  laragon.test            │
   │  DB   →  MySQL 8.0.x             │
   │  PHP  →  8.4.x                   │
   └──────────────────────────────────┘
   ```

3. Klik tombol **Start All**
4. Jika berhasil, tombol akan berubah warna menjadi **hijau**
5. Untuk memastikan, buka browser dan ketik: `http://localhost`
   - Jika muncul halaman Laragon, berarti instalasi berhasil ✅

---

## Langkah 4 — Kenali Tampilan Laragon

| Bagian | Fungsi |
|--------|--------|
| Tombol **Start All** | Menjalankan Apache dan MySQL sekaligus |
| Tombol **Stop All** | Mematikan semua service |
| **Web** | Alamat website (localhost) |
| **DB** | Port database (3306) |
| **PHP** | Versi PHP yang aktif |
| **Terminal** | Membuka command line (berguna nanti) |
| **Root** | Membuka folder `C:\laragon\www` tempat kita menyimpan project |

---

## Langkah 5 — Uji Coba PHP & Composer

1. Klik tombol **Terminal** di Laragon (ikon >_)
2. Ketik perintah berikut:

   ```bash
   php -v
   ```
3. Harusnya muncul tulisan seperti:
   ```
   PHP 8.4.x (cli) ...
   ```

4. Ketik juga:

   ```bash
   composer -v
   ```
   Jika muncul informasi Composer, berarti semuanya sudah siap.

---

## Langkah 6 — Install Laravel Installer

Laravel 13 menyediakan **Laravel Installer** — alat khusus yang memudahkan kita membuat project Laravel. Installernya akan menuntun kita memilih starter kit, testing framework, dan database secara interaktif.

```bash
composer global require laravel/installer
```

### Verifikasi

```bash
laravel --version
```

Harus muncul: `Laravel Installer ...`

---

## Ringkasan

| No | Langkah | Keterangan |
|----|---------|------------|
| 1 | Download Laragon Full | https://laragon.org/download/ |
| 2 | Install | Pilih komponen, atur lokasi |
| 3 | Start All | Apache + MySQL berjalan |
| 4 | Cek localhost | Harus muncul halaman Laragon |
| 5 | Cek PHP & Composer | `php -v` dan `composer -v` |
| 6 | Install Laravel Installer | `composer global require laravel/installer` |

---

## Catatan Penting

- Setiap kali ingin coding Laravel, **Laragon harus dalam keadaan running** (Start All)
- Jika laptop dimatikan, besoknya jalankan Laragon lagi dan klik **Start All**
- Icon Laragon ada di system tray (pojok kanan bawah). Klik kanan untuk akses cepat

---

**Lanjut ke:** [Membuat Project Laravel →](02-buat-project.md)
