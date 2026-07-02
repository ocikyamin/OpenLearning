# Error yang Sering Terjadi — Laragon

Kumpulan error yang paling sering dialami mahasiswa saat setup Laravel di Laragon beserta solusinya.

---

## 1. Port 80 / 3306 Sudah Dipakai Aplikasi Lain

**Gejala:** Apache atau MySQL gagal start. Tombol tidak berubah hijau.

**Penyebab:** Aplikasi lain (seperti IIS, Skype, atau XAMPP yang masih jalan) sudah menggunakan port 80 atau 3306.

**Solusi:**

**Opsi A — Hentikan aplikasi yang memakai port:**
- Jika ada XAMPP masih jalan, stop dulu
- Jika ada IIS (biasanya di Windows 10/11 Pro), nonaktifkan lewat **Control Panel → Turn Windows Features on or off** → uncheck IIS
- Jika Skype terinstall, buka Skype → Tools → Options → Advanced → Connection → uncheck "Use port 80"

**Opsi B — Ganti port Laragon:**
1. Klik kanan icon Laragon → **Preferences**
2. **Apache** → ganti port dari `80` ke `8080`
3. **MySQL** → ganti port dari `3306` ke `3307`
4. Simpan, lalu Start All lagi

Setelah mengganti port, akses Laravel via `http://localhost:8080` (bukan `:80`).

---

## 2. Hanya Muncul Daftar Folder (Directory Listing), Bukan Halaman Laravel

**Gejala:** Saat membuka `http://localhost/belajar-laravel`, yang muncul adalah daftar isi folder, bukan halaman Laravel.

**Penyebab:** Apache tidak diarahkan ke folder `public`.

**Solusi:**

1. Klik kanan icon Laragon → **Preferences**
2. Centang **Auto Virtual Hosts**
3. Klik **Save**
4. Restart Laragon (Stop All → Start All)
5. Akses lagi: `http://localhost/belajar-laravel`

Atau, akses langsung ke folder public:
```
http://localhost/belajar-laravel/public
```

---

## 3. 'php' atau 'composer' Tidak Dikenali

**Gejala:** Di terminal, mengetik `php -v` atau `composer -v` muncul error `'php' is not recognized as an internal or external command`.

**Penyebab:** Path PHP atau Composer belum ditambahkan ke environment variable Windows.

**Solusi:**

Cara termudah: **jangan pakai CMD biasa.** Selalu buka terminal **dari Laragon** (klik tombol Terminal). Terminal Laragon sudah otomatis terkonfigurasi dengan path yang benar.

---

## 4. No Application Encryption Key

**Gejala:** Error `No application encryption key has been specified.` saat membuka Laravel.

**Penyebab:** Kita lupa menjalankan `php artisan key:generate` setelah membuat project.

**Solusi:**

Di terminal Laragon:
```bash
cd C:\laragon\www\belajar-laravel
php artisan key:generate
```

Setelah itu, refresh browser.

---

## 5. 403 Forbidden / Access Denied

**Gejala:** Muncul halaman putih dengan tulisan `403 Forbidden` atau `Access denied`.

**Penyebab:** Biasanya karena file `.htaccess` tidak terbaca atau indeks direktori tidak diizinkan.

**Solusi:**

1. Pastikan file `.htaccess` ada di folder project Laravel (tepatnya di dalam folder `public`)
2. Klik kanan icon Laragon → **Preferences** → **Apache**
3. Pastikan **"Enable mod_rewrite"** sudah dicentang
4. Restart Laragon

---

## 6. MySQL: Access Denied for User 'root'@'localhost'

**Gejala:** Gagal login ke MySQL.

**Solusi:**

Pastikan password root Laragon adalah **kosong**. Coba:

```bash
mysql -u root -p
```

Lalu saat diminta password, langsung tekan **Enter** (tanpa mengetik apapun).

Jika tetap gagal, reset password MySQL melalui menu Laragon:
1. Klik kanan icon Laragon → **MySQL** → **Change root password**
2. Biarkan kosong, klik OK
3. Restart MySQL

---

## 7. Composer: Out of Memory / Timeout

**Gejala:** Gagal saat `laravel new` atau `composer install` karena memory habis atau koneksi timeout.

**Solusi:**

```bash
php -d memory_limit=-1 /path/to/composer.phar global require laravel/installer
```

Atau jika timeout:

```bash
export COMPOSER_PROCESS_TIMEOUT=2000
composer global require laravel/installer
```

---

## 8. Tips Jika Semua Error di Atas Tidak Membantu

1. **Restart laptop** — kadang masalah sepele selesai dengan restart
2. **Reinstall Laragon** — uninstall dulu, lalu install ulang
3. **Tanya ke dosen atau teman** — jangan malu bertanya
4. **Catat pesan error** — screenshot atau copy paste pesan error-nya, lalu kirim ke grup

---

**Kembali ke:** [Membuat Project Laravel →](02-buat-project.md)
