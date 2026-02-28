# Modul Tutorial: Instalasi Web Server (LAMP Stack) di WSL Ubuntu

**Tujuan:** Membangun lingkungan server lokal di Ubuntu yang berjalan di atas Windows Subsystem for Linux (WSL) untuk keperluan pengembangan aplikasi web.

---

## 1. Persiapan: Pembaruan Repositori

Sebelum menginstal paket apa pun, kita harus memastikan daftar paket di Ubuntu adalah yang terbaru untuk menghindari konflik versi.

* **Perintah:**
```bash
sudo apt update && sudo apt upgrade -y

```


* **Penjelasan:** * `sudo`: Menjalankan perintah sebagai administrator (root).
* `apt update`: Memperbarui daftar aplikasi dari server Ubuntu.
* `upgrade`: Mengunduh dan menginstal pembaruan aplikasi yang sudah ada.



---

## 2. Instalasi Web Server (Apache)

Apache adalah perangkat lunak web server yang bertugas menerima permintaan (request) dari browser dan mengirimkan halaman web kembali ke pengguna.

* **Langkah Instalasi:**
```bash
sudo apt install apache2 -y

```


* **Menjalankan Service (Penting untuk WSL):**
Berbeda dengan Ubuntu biasa, di WSL Anda harus menyalakan service secara manual setiap kali membuka terminal baru:
```bash
sudo service apache2 start

```


* **Verifikasi:**
Buka browser di Windows (Chrome/Edge), lalu ketik **`localhost`**. Jika muncul halaman "Apache2 Ubuntu Default Page", instalasi berhasil.

---

## 3. Instalasi Database Server (MySQL)

MySQL digunakan untuk menyimpan data aplikasi web Anda secara terorganisir.

* **Langkah Instalasi:**
```bash
sudo apt install mysql-server -y

```


* **Menjalankan Service:**
```bash
sudo service mysql start

```


* **Keamanan Dasar (Opsional):**
Untuk mengatur password root database, jalankan:
```bash
sudo mysql_secure_installation

```



---

## 4. Instalasi PHP (Bahasa Pemrograman)

Sesuai permintaan Anda, kita akan menggunakan perintah standar Ubuntu untuk menginstal PHP beserta modul integrasinya.

* **Perintah:**
```bash
sudo apt install php libapache2-mod-php php-mysql -y

```


* **Penjelasan Paket:**
* **`php`**: Inti dari bahasa pemrograman PHP. (Pada Ubuntu 24.04, ini secara otomatis menginstal **PHP 8.3**).
* **`libapache2-mod-php`**: Modul yang memungkinkan Apache untuk memproses file PHP.
* **`php-mysql`**: Driver agar PHP bisa terhubung dan berkomunikasi dengan database MySQL.



---

## 5. Pengujian Integrasi (Uji Coba PHP)

Langkah ini sangat penting untuk memastikan bahwa Apache benar-benar bisa menjalankan kode PHP.

1. **Berpindah ke Direktori Web:**
Secara default, folder website Anda berada di: `/var/www/html/`
2. **Membuat File Tes:**
Jalankan perintah ini untuk membuat file bernama `info.php`:
```bash
echo "<?php phpinfo(); ?>" | sudo tee /var/www/html/info.php

```


3. **Restart Web Server:**
Agar Apache mengenali instalasi PHP yang baru, restart service-nya:
```bash
sudo service apache2 restart

```


4. **Cek Hasil:**
Buka browser dan akses: **`localhost/info.php`**. Anda harus melihat tabel informasi versi PHP yang sangat detail.

---

## 6. Ringkasan Perintah Operasional

Sebagai mahasiswa, Anda akan sering menggunakan perintah-perintah di bawah ini untuk mengelola server Anda:

| Tugas | Perintah |
| --- | --- |
| Cek status Apache | `sudo service apache2 status` |
| Menghentikan Apache | `sudo service apache2 stop` |
| Masuk ke Terminal MySQL | `sudo mysql -u root -p` |
| Lokasi file web (Root Document) | `/var/www/html/` |

---

> **Catatan Tambahan:** > Karena folder `/var/www/html` adalah folder sistem, Anda memerlukan izin `sudo` untuk menambah atau mengedit file di sana. Jika ingin mengedit file menggunakan **VS Code** dari Windows, Anda bisa mengetik `code .` di dalam direktori tersebut pada terminal Ubuntu.

Ini adalah langkah yang sangat krusial. Secara *default*, folder `/var/www/html` dimiliki oleh `root`, sehingga Anda akan sering menemui kendala "Permission Denied" saat ingin membuat atau mengedit file melalui VS Code atau teks editor lainnya.

# Cara mengatur hak akses (permission)
agar Anda (user **xx**) bisa mengelola file dengan bebas, namun Apache tetap bisa membacanya.

---

### Langkah 1: Tambahkan User Anda ke Group `www-data`

Apache berjalan menggunakan user dan group bernama `www-data`. Kita akan memasukkan user Anda ke dalam group tersebut.

* **Perintah:**
```bash
sudo usermod -aG www-data $USER

```


* **Penjelasan:** `$USER` adalah variabel otomatis yang merujuk pada username Anda (dalam hal ini `ay`).

---

### Langkah 2: Ubah Kepemilikan Folder

Kita akan mengubah pemilik folder `/var/www/html` agar menjadi milik Anda, namun tetap dalam group `www-data`.

* **Perintah:**
```bash
sudo chown -R $USER:www-data /var/www/html

```


* **Penjelasan:** `-R` berarti *Recursive* (berlaku untuk semua sub-folder dan file di dalamnya). Sekarang Anda adalah pemilik sah folder tersebut.

---

### Langkah 3: Atur Izin Akses (Permissions)

Kita berikan izin baca, tulis, dan eksekusi yang tepat.

* **Perintah:**
```bash
sudo chmod -R 775 /var/www/html

```


* **Penjelasan:** * `7` (Pemilik/Anda): Bisa baca, tulis, dan hapus.
* `7` (Group/Apache): Bisa baca dan tulis (penting jika website Anda perlu mengunggah file).
* `5` (Publik): Hanya bisa baca dan lihat.



---

### Langkah 4: Terapkan Perubahan (Log Out & Log In)

Agar perubahan group ini terbaca oleh sistem Ubuntu, Anda harus melakukan *refresh* pada sesi user Anda.

* **Cara Tercepat di WSL:**
Tutup terminal Ubuntu Anda, lalu buka kembali. Atau ketik:
```bash
newgrp www-data

```



---

### Tips Pro: Membuka Folder Web di VS Code

Sekarang, karena izin sudah diatur, Anda bisa membuka folder website Anda langsung di Visual Studio Code Windows dengan sangat mudah.

1. Masuk ke folder web: `cd /var/www/html`
2. Ketik perintah: **`code .`**
3. VS Code di Windows akan terbuka dan terhubung langsung ke Ubuntu WSL. Anda sekarang bisa membuat file `index.php`, mengeditnya, dan langsung menekan `Ctrl + S` tanpa hambatan izin lagi.

---

### Ringkasan Status Izin

| Komponen | Status Sebelum | Status Sesudah |
| --- | --- | --- |
| **Pemilik (Owner)** | `root` | `ay` (User Anda) |
| **Izin Edit** | Harus pakai `sudo` | Bisa langsung simpan |
| **Akses Browser** | Terbatas | Lancar Jaya |

---

Sekarang Web Server Anda sudah benar-benar "nyaman" untuk digunakan coding.

Menginstal **phpMyAdmin** adalah langkah yang sangat cerdas. Ini akan memberikan Anda antarmuka visual (berbasis web) untuk mengelola database MySQL, jadi Anda tidak perlu terus-menerus mengetik perintah SQL yang rumit di terminal.

Berikut adalah panduan modul untuk instalasi phpMyAdmin di WSL Ubuntu 24.04 Anda.

---

# Modul Tutorial: Instalasi phpMyAdmin (Database Manager)

**Tujuan:** Memasang antarmuka grafis berbasis web untuk mengelola database MySQL dengan mudah.

---

## 1. Instalasi Paket phpMyAdmin

Kita akan mengunduh phpMyAdmin beserta ekstensi PHP tambahan yang dibutuhkannya agar berjalan optimal.

* **Perintah:**
```bash
sudo apt update
sudo apt install phpmyadmin php-mbstring php-zip php-gd php-json php-curl -y

```



---

## 2. Konfigurasi Selama Instalasi (PENTING!)

Saat proses instalasi berjalan, akan muncul beberapa jendela biru (ncurses). **Jangan asal tekan Enter!** Ikuti instruksi ini:

1. **Web Server Selection:**
* Akan ada pilihan `apache2` dan `lighttpd`.
* Tekan **[Spasi]** pada pilihan **apache2** hingga muncul tanda bintang (`[*]`).
* Tekan **[Tab]** untuk pindah ke tombol `<OK>`, lalu tekan **[Enter]**.


2. **Configure database for phpmyadmin with dbconfig-common?**
* Pilih **<Yes>** dan tekan **[Enter]**.


3. **MySQL application password for phpmyadmin:**
* Masukkan password untuk aplikasi phpMyAdmin (ini internal, bisa disamakan dengan password database Anda agar mudah diingat).
* Masukkan lagi untuk konfirmasi.



---

## 3. Konfigurasi Hak Akses MySQL (Penting untuk User Root)

Secara default di Ubuntu baru, user `root` MySQL menggunakan plugin `auth_socket`, yang artinya Anda hanya bisa masuk lewat terminal. Agar bisa login ke phpMyAdmin, kita perlu mengubahnya.

1. **Masuk ke MySQL terminal:**
```bash
sudo mysql

```


2. **Jalankan perintah SQL ini (Ganti `password_anda` dengan password pilihan Anda):**
```sql
ALTER USER 'root'@'localhost' IDENTIFIED WITH mysql_native_password BY 'password_anda';
FLUSH PRIVILEGES;
EXIT;

```



---

## 4. Mengaktifkan Ekstensi PHP & Restart Apache

Kita perlu memastikan modul `mbstring` aktif dan Apache mengetahui adanya phpMyAdmin.

* **Perintah:**
```bash
sudo phpenmod mbstring
sudo service apache2 restart

```



---

## 5. Verifikasi di Browser

1. Buka browser Anda.
2. Akses alamat: **`localhost/phpmyadmin`**
3. **Login:**
* **Username:** `root`
* **Password:** (Password yang Anda buat di Langkah 3 tadi)



---

## Troubleshooting: Jika muncul error "404 Not Found"

Terkadang Apache tidak otomatis "mengaitkan" phpMyAdmin. Jika `localhost/phpmyadmin` tidak bisa dibuka, jalankan perintah ini untuk membuat *link* manual:

```bash
sudo ln -s /etc/phpmyadmin/apache.conf /etc/apache2/conf-available/phpmyadmin.conf
sudo a2enconf phpmyadmin.conf
sudo service apache2 reload

```

---

### Ringkasan Operasional Mahasiswa

| Komponen | Detail |
| --- | --- |
| **URL Akses** | `http://localhost/phpmyadmin` |
| **User Default** | `root` |
| **Fungsi Utama** | Membuat database, tabel, dan ekspor/impor SQL secara visual |

---

Sekarang Web Server Anda sudah sangat lengkap! Ada **Apache** (Web Server), **MySQL** (Database), **PHP** (Bahasa), dan **phpMyAdmin** (Manager).
