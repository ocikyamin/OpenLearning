# 📘 Panduan Lengkap Setup Lingkungan Development Web di WSL (Ubuntu 24.04)

Selamat datang! Panduan ini dirancang khusus untuk mahasiswa yang ingin mempelajari pengembangan web menggunakan lingkungan Linux di atas Windows. Kita akan membangun lingkungan development lengkap (**LAMP Stack + Node.js**) dari nol hingga siap digunakan untuk coding.

Ikuti langkah-langkah berikut secara berurutan. **Jangan melompat langkah** agar tidak terjadi error. Setiap bagian memiliki langkah verifikasi untuk memastikan instalasi berhasil.

---

## 📑 Daftar Isi
1. [Instalasi Windows Subsystem for Linux (WSL)](#1-instalasi-windows-subsystem-for-linux-wsl)
2. [Setup Awal Ubuntu 24.04](#2-setup-awal-ubuntu-2404)
3. [Instalasi Web Server (LAMP Stack)](#3-instalasi-web-server-lamp-stack)
4. [Instalasi phpMyAdmin (Manajer Database)](#4-instalasi-phpmyadmin-manajer-database)
5. [Optimasi Izin File & Integrasi VS Code](#5-optimasi-izin-file--integrasi-vs-code)
6. [Instalasi Composer (Dependency Manager PHP)](#6-instalasi-composer-dependency-manager-php)
7. [Instalasi Node.js & npm (JavaScript Runtime)](#7-instalasi-nodejs--npm-javascript-runtime)
8. [Penutup & Langkah Selanjutnya](#8-penutup--langkah-selanjutnya)

---

## 1. Instalasi Windows Subsystem for Linux (WSL)

Langkah pertama adalah mengaktifkan fitur WSL di Windows Anda.

### Langkah-langkah:
1.  **Buka PowerShell sebagai Administrator**
    *   Klik tombol **Start**.
    *   Ketik `PowerShell`.
    *   Klik kanan pada **Windows PowerShell** dan pilih **Run as Administrator**.
2.  **Jalankan Perintah Instalasi**
    *   Ketik perintah berikut lalu tekan **Enter**:
        ```powershell
        wsl --install
        ```
3.  **Restart Komputer**
    *   Setelah proses selesai, **wajib restart** laptop/PC Anda. Fitur WSL tidak akan aktif sepenuhnya tanpa restart.
4.  **✅ Verifikasi Instalasi**
    *   Setelah menyala kembali, buka PowerShell lagi dan ketik:
        ```powershell
        wsl --status
        ```
    *   **Status Sukses:** Jika muncul keterangan `Default Distribution: Ubuntu` dan `Version: 2`, maka WSL berhasil terinstal.

---

## 2. Setup Awal Ubuntu 24.04

Secara default, `wsl --install` mungkin menginstal versi Ubuntu lama. Kita akan memastikan menggunakan versi terbaru (24.04).

### 1️⃣ Instalasi Ubuntu Spesifik
Buka PowerShell dan jalankan perintah:
```powershell
wsl --install -d Ubuntu-24.04
```
*Tunggu hingga proses download dan instalasi selesai. Jendela terminal Ubuntu akan terbuka otomatis.*

### 2️⃣ Membuat User Baru
Saat pertama kali Ubuntu terbuka, tunggu hingga muncul permintaan:
```text
Enter new UNIX username:
```
*   **Aturan Username:** Gunakan huruf kecil semua, tanpa spasi (Contoh: `budi`, `mahasiswa`).
*   Tekan **Enter** setelah mengetik.

### 3️⃣ Mengatur Password
Sistem akan meminta password:
```text
New password:
Retype new password:
```
*   **⚠ PENTING:** Saat mengetik password, **kursor tidak akan bergerak** dan tidak ada tanda bintang (`***`). Ini normal di Linux.
*   Ketik password rahasia Anda, tekan **Enter**, lalu ketik ulang untuk konfirmasi.

### 4️⃣ Update Sistem
Langkah wajib setelah instalasi adalah memperbarui sistem.
Jalankan perintah ini di terminal Ubuntu:
```bash
sudo apt update && sudo apt upgrade -y
```
*   Masukkan password user yang baru dibuat jika diminta.
*   Jika diminta konfirmasi `Y/n`, ketik `y` lalu Enter.

### 5️⃣ ✅ Verifikasi Instalasi Ubuntu
*   **Status Sukses:** Jika muncul tulisan `Installation successful!` dan prompt berubah menjadi `username@LAPTOP-NAMA:~$`, maka Ubuntu siap digunakan.

---

## 3. Instalasi Web Server (LAMP Stack)

Kita akan membangun lingkungan server lokal untuk menjalankan aplikasi web.

### 1. Instalasi Web Server (Apache)
Apache bertugas menerima permintaan dari browser.
```bash
sudo apt install apache2 -y
```
**Menjalankan Service:**
```bash
sudo service apache2 start
```
**✅ Verifikasi Apache:**
*   Buka browser (Chrome/Edge) di Windows, ketik `localhost`.
*   **Status Sukses:** Jika muncul halaman "Apache2 Ubuntu Default Page", Apache berhasil.

### 2. Instalasi Database Server (MySQL)
MySQL untuk menyimpan data aplikasi.
```bash
sudo apt install mysql-server -y
sudo service mysql start
```
**✅ Verifikasi MySQL:**
*   Coba masuk ke terminal MySQL:
    ```bash
    sudo mysql
    ```
*   **Status Sukses:** Jika prompt berubah menjadi `mysql>`, ketik `EXIT;` untuk keluar.

### 3. Instalasi PHP
PHP adalah bahasa pemrograman untuk logika website.
```bash
sudo apt install php libapache2-mod-php php-mysql -y
```

### 4. Pengujian Integrasi PHP
Pastikan Apache bisa menjalankan kode PHP.
1.  Buat file tes:
    ```bash
    echo "<?php phpinfo(); ?>" | sudo tee /var/www/html/info.php
    ```
2.  Restart Apache:
    ```bash
    sudo service apache2 restart
    ```
3.  **✅ Verifikasi PHP:**
    *   Buka browser dan akses `localhost/info.php`.
    *   **Status Sukses:** Jika muncul tabel informasi versi PHP, instalasi LAMP berhasil.

---

## 4. Instalasi phpMyAdmin (Manajer Database)

phpMyAdmin memberikan antarmuka grafis untuk mengelola database MySQL.

### 1. Instalasi Paket
```bash
sudo apt update
sudo apt install phpmyadmin php-mbstring php-zip php-gd php-json php-curl -y
```

### 2. Konfigurasi Instalasi (PENTING!)
Akan muncul jendela biru selama instalasi. Ikuti panduan ini:
1.  **Web Server Selection:** Pilih `apache2` (tekan **Spasi** hingga ada tanda `[*]`), lalu tekan **Tab** ke `<OK>` dan **Enter**.
2.  **Configure database:** Pilih `Yes` dan tekan **Enter**.
3.  **Password:** Masukkan password untuk aplikasi phpMyAdmin (bisa sama dengan password database agar mudah diingat).

### 3. Konfigurasi Akses MySQL
User `root` MySQL perlu diubah agar bisa login via phpMyAdmin.

1.  Masuk ke terminal MySQL:
    ```bash
    sudo mysql
    ```
2.  Jalankan perintah SQL berikut (ganti `password_anda` dengan password yang Anda inginkan):
    ```sql
    ALTER USER 'root'@'localhost' IDENTIFIED WITH mysql_native_password BY 'password_anda';
    FLUSH PRIVILEGES;
    EXIT;
    ```
3.  Aktifkan modul PHP dan restart Apache:
    ```bash
    sudo phpenmod mbstring
    sudo service apache2 restart
    ```

### 4. ✅ Verifikasi phpMyAdmin
*   Buka browser, akses: `localhost/phpmyadmin`
*   **Login:** Username `root`, Password: Password yang Anda buat pada langkah konfigurasi SQL di atas.
*   **Status Sukses:** Jika berhasil masuk ke dashboard phpMyAdmin, instalasi berhasil.

> **⚠ Troubleshooting (Error 404):**
> Jika halaman tidak ditemukan, jalankan perintah ini:
> ```bash
> sudo ln -s /etc/phpmyadmin/apache.conf /etc/apache2/conf-available/phpmyadmin.conf
> sudo a2enconf phpmyadmin.conf
> sudo service apache2 reload
> ```

---

## 5. Optimasi Izin File & Integrasi VS Code

Secara default, folder website (`/var/www/html`) dimiliki oleh `root`. Anda akan sering gặp error "Permission Denied" saat ingin menyimpan file dari VS Code. Mari kita perbaiki.

### 1. Atur Hak Akses (Permission)
Jalankan perintah berikut satu per satu di terminal Ubuntu:

*   **Tambahkan user Anda ke group Apache:**
    ```bash
    sudo usermod -aG www-data $USER
    ```
*   **Ubah kepemilikan folder web menjadi milik Anda:**
    ```bash
    sudo chown -R $USER:www-data /var/www/html
    ```
*   **Berikan izin akses yang tepat:**
    ```bash
    sudo chmod -R 775 /var/www/html
    ```

### 2. Terapkan Perubahan
Agar perubahan group terbaca, tutup terminal Ubuntu lalu buka kembali, atau ketik:
```bash
newgrp www-data
```

### 3. Coding dengan VS Code
1.  Masuk ke folder web:
    ```bash
    cd /var/www/html
    ```
2.  Buka di VS Code:
    ```bash
    code .
    ```
3.  **✅ Verifikasi VS Code:**
    *   VS Code di Windows akan terbuka terhubung ke Ubuntu.
    *   Buat file baru `test.html`, ketik "Halo", simpan (`Ctrl + S`).
    *   **Status Sukses:** Jika file tersimpan tanpa error permission, setup berhasil.

---

## 6. Instalasi Composer (Dependency Manager PHP)

Composer adalah alat untuk mengelola library atau paket pada PHP (wajib untuk Laravel, dll).

### 1. Instalasi Dependensi PHP
Pastikan paket pendukung CLI PHP terinstal:
```bash
sudo apt install php-cli php-mbstring unzip curl -y
```

### 2. Download & Instalasi Composer
Unduh script installer resmi Composer:
```bash
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
php composer-setup.php
sudo mv composer.phar /usr/local/bin/composer
php -r "unlink('composer-setup.php');"
```

### 3. ✅ Verifikasi Composer
Cek versi Composer untuk memastikan berhasil:
```bash
composer --version
```
*   **Status Sukses:** Jika muncul versi Composer (contoh: `Composer version 2.x.x...`), maka instalasi berhasil.

---

## 7. Instalasi Node.js & npm (JavaScript Runtime)

Node.js memungkinkan Anda menjalankan JavaScript di luar browser (backend) dan menggunakan tools modern seperti React, Vue, atau Vite.

### 1. Instalasi Node.js
Kita akan menggunakan repositori default Ubuntu untuk kemudahan instalasi.
```bash
sudo apt install nodejs npm -y
```

### 2. ✅ Verifikasi Node.js & npm
Cek versi yang terinstal:
```bash
node -v
npm -v
```
*   **Status Sukses:**
    *   Jika `node -v` menampilkan versi (contoh: `v18.x.x` atau `v20.x.x`).
    *   Jika `npm -v` menampilkan versi (contoh: `9.x.x` atau `10.x.x`).
    *   Maka Node.js siap digunakan.

> **Catatan:** Jika Anda memerlukan versi Node.js yang lebih spesifik atau terbaru di masa depan, Anda dapat menggunakan **NVM (Node Version Manager)**, namun untuk panduan dasar ini, versi `apt` sudah cukup untuk memulai.

---

## 8. Penutup & Langkah Selanjutnya

Selamat! 🎉 Anda sekarang memiliki lingkungan development web yang **LENGKAP**:
*   ✅ **OS:** Ubuntu 24.04 via WSL
*   ✅ **Web Server:** Apache
*   ✅ **Database:** MySQL & phpMyAdmin
*   ✅ **Bahasa Backend:** PHP & Composer
*   ✅ **Bahasa Frontend/Tools:** Node.js & npm
*   ✅ **Editor:** VS Code Terintegrasi

### Langkah Selanjutnya untuk Pembelajaran:
1.  **Mulai Coding:** Buat file `index.php` di `/var/www/html` dan coba tampilkan "Hello World".
2.  **Instalasi Framework:**
    *   PHP: Coba instal Laravel (`composer create-project laravel/laravel contoh-app`).
    *   JS: Coba instal React/Vite (`npm create vite@latest`).
3.  **Git:** Instal Git (`sudo apt install git`) untuk version control.

Selamat belajar dan semoga sukses dalam praktikum! 🚀
