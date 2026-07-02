# Membuat Project Laravel di WSL / Ubuntu

Setelah Apache, PHP, MySQL, Composer, dan Laravel Installer siap, saatnya membuat project Laravel pertama.

---

## Langkah 1 — Install Laravel Installer

Laravel 13 menyediakan **Laravel Installer** — alat resmi untuk membuat project Laravel. Installernya akan menuntun kita memilih starter kit, testing framework, dan database.

```bash
composer global require laravel/installer
```

Verifikasi:

```bash
laravel --version
```

---

## Langkah 2 — Siapkan Folder Project

Project Laravel bisa disimpan di `/var/www/html/` atau di folder home (`~`).

```bash
sudo mkdir -p /var/www/html
sudo chown -R $USER:$USER /var/www/html
```

> **Catatan:** Jangan menyimpan project di folder Windows (`/mnt/c/...`) karena akses baca-tulisnya lambat.

---

## Langkah 3 — Buat Project Laravel

```bash
cd /var/www/html
laravel new belajar-laravel
```

Perintah ini akan menampilkan beberapa pertanyaan interaktif:

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
| **What starter kit?** | `None` | Kita belajar dari dasar |
| **Which testing framework?** | `PHPUnit` | Paling umum |
| **Which database?** | `SQLite` (default) atau pilih `MySQL` | **SQLite** = langsung jalan tanpa setup database |
| **Will you use Pest?** | `no` | |

> **Mengapa SQLite?** SQLite tidak memerlukan server database terpisah — file database langsung dibuat otomatis. Nanti saat materi database tiba, kita bisa ganti ke MySQL.

Proses memakan waktu 3-10 menit. Jika berhasil akan muncul:

```
✔  Application ready! Build something amazing.
```

---

## Langkah 4 — Atur Hak Akses (Permission)

```bash
cd /var/www/html/belajar-laravel
sudo chown -R $USER:www-data storage bootstrap/cache
sudo chmod -R 775 storage bootstrap/cache
```

---

## Langkah 5 — Jalankan Project

Install dependency frontend dulu:

```bash
npm install && npm run build
```

Lalu jalankan server development:

```bash
composer run dev
```

Perintah `composer run dev` menjalankan tiga hal sekaligus:
- Laravel development server di `http://localhost:8000`
- Vite untuk kompilasi CSS/JavaScript
- Queue worker

> **Catatan:** Terminal harus tetap terbuka selama coding.

---

## Langkah 6 — Akses Project

1. Buka browser di Windows
2. Ketik: `http://localhost:8000`

Jika muncul halaman Laravel, berarti sukses 🎉

---

## Langkah 7 — Alternatif: Pakai Apache + Virtual Host

Jika ingin akses via `http://belajar-laravel.test` (tanpa `:8000` dan tanpa `composer run dev`):

### A. Konfigurasi Virtual Host

```bash
sudo nano /etc/apache2/sites-available/belajar-laravel.conf
```

Isi dengan:

```apache
<VirtualHost *:80>
    ServerName belajar-laravel.test
    DocumentRoot /var/www/html/belajar-laravel/public

    <Directory /var/www/html/belajar-laravel>
        Options Indexes MultiViews FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>

    ErrorLog ${APACHE_LOG_DIR}/error.log
    CustomLog ${APACHE_LOG_DIR}/access.log combined
</VirtualHost>
```

Simpan (Ctrl+X, Y, Enter), lalu aktifkan:

```bash
sudo a2ensite belajar-laravel.conf
sudo a2enmod rewrite
sudo service apache2 restart
```

### B. Edit Hosts File Windows

1. Buka **Notepad sebagai Administrator**
2. Buka `C:\Windows\System32\drivers\etc\hosts`
3. Tambahkan di baris paling bawah:

   ```
   127.0.0.1  belajar-laravel.test
   ```
4. Simpan

### C. Akses

Buka browser → `http://belajar-laravel.test`

---

## Jika Memilih MySQL (Bukan SQLite)

Jika saat `laravel new` memilih MySQL, lakukan langkah tambahan berikut:

### A. Buat Database

```bash
sudo mysql -u root -p
```

```sql
CREATE DATABASE belajar_laravel CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
EXIT;
```

### B. Konfigurasi .env

```bash
cd /var/www/html/belajar-laravel
nano .env
```

Sesuaikan:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=belajar_laravel
DB_USERNAME=root
DB_PASSWORD=password-anda
```

Ganti `password-anda` dengan password MySQL yang dibuat saat `mysql_secure_installation`.

### C. Jalankan Migration

```bash
php artisan migrate
```

---

## Perintah Cepat Harian

```bash
# Jalankan Apache + MySQL
sudo service apache2 start
sudo service mysql start

# Masuk folder project & jalankan
cd /var/www/html/belajar-laravel
composer run dev
```

Atau buat alias:

```bash
echo 'alias art="php artisan"' >> ~/.bashrc
echo 'alias dev="composer run dev"' >> ~/.bashrc
source ~/.bashrc
```

Setelah itu, cukup ketik `art` atau `dev`.

---

## Ringkasan

| No | Langkah | Perintah |
|----|---------|----------|
| 1 | Install Laravel Installer | `composer global require laravel/installer` |
| 2 | Buat project | `laravel new belajar-laravel` |
| 3 | Atur permission | `sudo chmod -R 775 storage bootstrap/cache` |
| 4 | Install frontend | `npm install && npm run build` |
| 5 | Jalankan server | `composer run dev` |
| 6 | Akses browser | `http://localhost:8000` |

---

**Lanjut ke:** [Error yang Sering Terjadi →](04-error-sering.md)

---
