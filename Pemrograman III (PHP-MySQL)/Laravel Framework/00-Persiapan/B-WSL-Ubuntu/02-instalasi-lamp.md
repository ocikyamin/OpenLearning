# Instalasi LAMP Stack (Apache, PHP, MySQL) di WSL / Ubuntu

Setelah WSL dan Ubuntu terinstall, kita perlu menyiapkan web server, PHP, dan database — yang biasa disebut **LAMP Stack** (Linux, Apache, MySQL, PHP).

---

## Langkah 1 — Install Apache

Apache adalah web server yang akan melayani halaman Laravel kita.

```bash
sudo apt update
sudo apt install apache2 -y
```

Setelah selesai, cek apakah Apache sudah berjalan:

```bash
sudo systemctl status apache2
```

Jika muncul tulisan **active (running)** , berarti sukses ✅

> **Catatan:** Pada WSL, systemctl mungkin tidak berfungsi penuh. Jika tidak muncul status, coba jalankan:
> ```bash
> sudo service apache2 start
> ```

### Uji Coba Apache

1. Buka browser di Windows
2. Ketik: `http://localhost`
3. Jika muncul halaman "Apache2 Ubuntu Default Page", berarti Apache berfungsi ✅

### Perintah Dasar Apache

```bash
sudo service apache2 start     # Menjalankan Apache
sudo service apache2 stop      # Mematikan Apache
sudo service apache2 restart   # Restart Apache
```

---

## Langkah 2 — Install PHP

Laravel 13 membutuhkan **PHP 8.3** minimal. Disarankan menggunakan **PHP 8.5** (atau PHP 8.4 jika 8.5 belum tersedia).

### Cara A — Install PHP 8.5 (Direkomendasikan)

```bash
sudo apt install software-properties-common -y
sudo add-apt-repository ppa:ondrej/php -y
sudo apt update
sudo apt install php8.5 php8.5-cli php8.5-common php8.5-mysql \
                 php8.5-mbstring php8.5-xml php8.5-curl php8.5-gd \
                 php8.5-zip php8.5-bz2 php8.5-intl -y
```

### Cara B — Install PHP 8.4 (Alternatif)

```bash
sudo apt install software-properties-common -y
sudo add-apt-repository ppa:ondrej/php -y
sudo apt update
sudo apt install php8.4 php8.4-cli php8.4-common php8.4-mysql \
                 php8.4-mbstring php8.4-xml php8.4-curl php8.4-gd \
                 php8.4-zip php8.4-bz2 php8.4-intl -y
```

### Cara C — Install PHP 8.3 (Minimal)

```bash
sudo apt install php8.3 php8.3-cli php8.3-common php8.3-mysql \
                 php8.3-mbstring php8.3-xml php8.3-curl php8.3-gd \
                 php8.3-zip php8.3-bz2 php8.3-intl -y
```

### Pasang PHP untuk Apache

Sesuaikan versi PHP yang dipilih:

```bash
# Jika PHP 8.5
sudo apt install libapache2-mod-php8.5 -y

# Jika PHP 8.4
sudo apt install libapache2-mod-php8.4 -y

# Jika PHP 8.3
sudo apt install libapache2-mod-php8.3 -y

sudo service apache2 restart
```

### Verifikasi PHP

```bash
php -v
```

Seharusnya muncul: `PHP 8.5.x (cli) ...`

---

## Langkah 3 — Install MySQL

MySQL adalah database yang akan menyimpan data aplikasi kita.

```bash
sudo apt install mysql-server -y
```

### Verifikasi

```bash
sudo service mysql status
```

### Setup Keamanan (Saran: lakukan)

```bash
sudo mysql_secure_installation
```

Ikuti panduannya:
- Enter → lampaui (biarkan root password kosong dulu)
- Ketik **Y** untuk setiap pertanyaan:
  - Set root password? → ketik password baru
  - Remove anonymous users? → Y
  - Disallow root login remotely? → Y
  - Remove test database? → Y
  - Reload privilege tables? → Y

### Login ke MySQL

```bash
sudo mysql -u root -p
```

Masukkan password yang tadi dibuat. Jika berhasil masuk, akan muncul:

```
mysql>
```

Ketik `EXIT;` untuk keluar.

---

## Langkah 4 — Install Composer

Composer adalah pengelola library PHP yang akan menginstall Laravel dan dependensinya.

```bash
sudo apt install composer -y
```

### Verifikasi

```bash
composer -v
```

---

## Langkah 5 — Install Node.js

Node.js diperlukan Laravel untuk mengelola file CSS dan JavaScript (via Vite).

```bash
curl -fsSL https://deb.nodesource.com/setup_20.x | sudo -E bash -
sudo apt install nodejs -y
```

### Verifikasi

```bash
node -v
npm -v
```

---

## Langkah 6 — Install Git

Git adalah version control yang akan membantu kita mengelola kode.

```bash
sudo apt install git -y
```

### Verifikasi

```bash
git --version
```

### Konfigurasi Awal Git

```bash
git config --global user.name "Nama Lengkap"
git config --global user.email "email@example.com"
```

---

## Langkah 7 — Uji Semua

Jalankan perintah-perintah berikut untuk memastikan semuanya terinstall dengan benar:

```bash
apache2 -v
php -v
mysql --version
composer -v
node -v
npm -v
git --version
```

Semua harus menampilkan versi tanpa error.

---

## Ringkasan Perintah Instalasi

```bash
# Apache
sudo apt install apache2 -y

# PHP 8.4
sudo add-apt-repository ppa:ondrej/php -y
sudo apt install php8.4 php8.4-cli php8.4-mysql php8.4-mbstring \
                 php8.4-xml php8.4-curl php8.4-gd php8.4-zip -y
sudo apt install libapache2-mod-php8.4 -y

# MySQL
sudo apt install mysql-server -y

# Composer
sudo apt install composer -y

# Node.js
curl -fsSL https://deb.nodesource.com/setup_20.x | sudo -E bash -
sudo apt install nodejs -y

# Git
sudo apt install git -y
```

Simpan perintah di atas di Notepad. Suatu saat jika install ulang laptop, tinggal copy-paste.

---

**Lanjut ke:** [Membuat Project Laravel di WSL →](03-buat-project.md)
