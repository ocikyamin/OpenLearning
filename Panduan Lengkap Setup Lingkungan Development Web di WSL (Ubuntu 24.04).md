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
# Instal Node.js Menggunakan NVM
## 1. Update Sistem

```bash
sudo apt update
sudo apt install curl -y
````

---

## 2. Instal NVM

```bash
curl -o- https://raw.githubusercontent.com/nvm-sh/nvm/v0.39.7/install.sh | bash
```

---

## 3. Aktifkan NVM

Buka file konfigurasi:

```bash
nano ~/.bashrc
```

Tambahkan di bagian paling bawah:

```bash
export NVM_DIR="$HOME/.nvm"
[ -s "$NVM_DIR/nvm.sh" ] && \. "$NVM_DIR/nvm.sh"
[ -s "$NVM_DIR/bash_completion" ] && \. "$NVM_DIR/bash_completion"
```

Simpan dengan:

```
CTRL + O → Enter → CTRL + X
```

---

## 4. Muat Ulang Terminal

```bash
source ~/.bashrc
```

---

## 5. Instal Node.js

Instal versi stabil (LTS):

```bash
nvm install --lts
```

---

## 6. Verifikasi Instalasi

```bash
nvm -v
node -v
npm -v
```

Jika semua menampilkan **nomor versi**, instalasi berhasil.

```


> **Jika Mengalami Error** : Command 'nvm' not found, but there are 14 similar ones.

Lakukan Langkah Berikut :

## 1. Muat Ulang Konfigurasi Bash
Seringkali NVM sudah terinstal tapi terminal belum "sadar". Jalankan perintah ini:

```bash
source ~/.bashrc
```

Setelah itu, coba ketik `nvm -v`. Jika muncul angka versi, berarti masalah selesai. 
## 2. Instal Ulang NVM (Jika Langkah 1 Gagal)
Jika tetap tidak ditemukan, instal kembali menggunakan script resmi untuk memastikan semua dependensi terpasang: 
``` bash
# Update package list
sudo apt update

# Instal curl jika belum ada
sudo apt install curl -y

# Jalankan script instalasi NVM terbaru
curl -o- https://raw.githubusercontent.com/nvm-sh/nvm/v0.40.1/install.sh | bash

```
## 3. Masukkan Konfigurasi ke .bashrc Secara Manual
Jika setelah instalasi nvm masih tidak berfungsi, script instalasi mungkin gagal menulis ke file .bashrc Anda secara otomatis. 
Buka file .bashrc dengan editor teks:

`` bash
nano ~/.bashrc
```

scroll ke bagian paling bawah file, lalu tempelkan kode berikut:

``` bash
export NVM_DIR="$HOME/.nvm"
[ -s "$NVM_DIR/nvm.sh" ] && \. "$NVM_DIR/nvm.sh"  # Memuat nvm
[ -s "$NVM_DIR/bash_completion" ] && \. "$NVM_DIR/bash_completion"  # Memuat nvm bash_completion
```

Simpan dengan menekan `Ctrl + O`, lalu Enter. Keluar dengan `Ctrl + X`.
Jalankan lagi: `source ~/.bashrc`. 
## 4. Instal Node.js 
Setelah perintah nvm sudah dikenali, Anda bisa langsung menginstal Node.js versi terbaru (LTS): 
``` bash
nvm install --lts
```

Tips Tambahan: Pastikan Anda tidak menggunakan sudo saat menjalankan perintah nvm, karena NVM dirancang untuk berjalan di level user agar tidak terjadi masalah perizinan (permission) di kemudian hari.


---

### **1\. Instalasi Laravel Installer Global**

Jalankan perintah ini untuk mengunduh paket installer Laravel secara global menggunakan Composer:
```bash
composer global require laravel/installer
```

### **2\. Konfigurasi Path Shell (.bashrc)**

Agar terminal mengenali perintah laravel, Anda perlu menambahkan direktori bin Composer ke dalam variabel $PATH.

**Langkah Manual:**

1. Buka file .bashrc dengan editor nano:
```bash
nano \~/.bashrc
```
2. Gulir ke bagian paling bawah file dan tempelkan baris berikut:  
   ```bash
   export PATH="$HOME/.config/composer/vendor/bin:$PATH"
   ```

3. Simpan dengan menekan Ctrl \+ O, lalu Enter. Keluar dengan Ctrl \+ X.

### **3\. Aktivasi Perubahan Path**

Agar perubahan di atas langsung aktif di sesi terminal yang sedang terbuka tanpa harus restart, jalankan perintah source:

```bash
source \~/.bashrc
```

### **4\. Verifikasi dan Testing**

Pastikan installer sudah terpasang dengan benar dan coba buat satu proyek uji coba.

**Cek Versi:**

```bash
laravel \--version
```

**Buat Proyek Baru:**
```bash
\# Membuat proyek bernama 'my-app'  
laravel new my-app
```

**Catatan:** Jika muncul pilihan saat instalasi (seperti starter kit atau database), pilih sesuai preferensi Anda (misal: No starter kit, MySQL).
