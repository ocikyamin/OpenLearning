# Error yang Sering Terjadi — WSL / Ubuntu

Kumpulan error yang paling sering dialami mahasiswa saat setup Laravel di WSL + Ubuntu.

---

## 1. WSL Gagal Install — Virtualization Tidak Aktif

**Gejala:** Error `Please enable virtualization` atau `WslRegisterDistribution failed with error 0x80370102`.

**Solusi:**

1. Restart laptop, masuk ke **BIOS/UEFI** (biasanya tekan F2, F10, atau DEL saat booting)
2. Cari menu **Intel Virtualization Technology** (VT-x) atau **AMD SVM Mode**
3. Ubah ke **Enabled**
4. Simpan dan keluar (F10)

> Jika sudah di BIOS tapi tidak menemukan menu tersebut, kemungkinan laptop memang tidak mendukung virtualisasi. Solusinya: gunakan Laragon saja (panduan ada di folder A-Laragon).

---

## 2. Apache Gagal Start — Port 80 Sudah Dipakai

**Gejala:** Error `Could not bind to address 0.0.0.0:80` saat menjalankan Apache.

**Penyebab:** Aplikasi Windows (IIS, Skype, atau Docker) sudah memakai port 80.

**Solusi:**

**Opsi A — Hentikan aplikasi yang memakai port 80:**

Di PowerShell/Terminal Windows (Administrator), jalankan:

```powershell
net stop w3svc     # Jika IIS berjalan
net stop http      # Jika HTTP Service berjalan
```

**Opsi B — Ganti port Apache ke 8080:**

```bash
sudo nano /etc/apache2/ports.conf
```

Ubah `Listen 80` menjadi `Listen 8080`. Lalu restart:

```bash
sudo service apache2 restart
```

Akses project via `http://belajar-laravel.test:8080`

---

## 3. Permission Denied — Tidak Bisa Menulis ke Storage

**Gejala:** Error `The stream or file could not be opened` atau `Unable to write to cache`.

**Solusi:**

```bash
cd /var/www/html/belajar-laravel
sudo chown -R $USER:www-data storage bootstrap/cache
sudo chmod -R 775 storage bootstrap/cache
```

Jika masih error, untuk sementara (hanya untuk development):

```bash
sudo chmod -R 777 storage bootstrap/cache
```

---

## 4. MySQL: Access Denied for User 'root'@'localhost'

**Gejala:** Gagal login MySQL meskipun sudah memasukkan password dengan benar.

**Solusi:**

Coba login dengan cara berikut:

```bash
sudo mysql -u root -p
```

Jika masih gagal, coba tanpa password:

```bash
sudo mysql
```

Jika berhasil masuk, ubah metode autentikasi:

```sql
ALTER USER 'root'@'localhost' IDENTIFIED WITH mysql_native_password BY 'password-baru';
FLUSH PRIVILEGES;
EXIT;
```

Setelah itu coba login lagi:

```bash
mysql -u root -p
```

---

## 5. Laravel: No Application Encryption Key

**Gejala:** Halaman Laravel error: `No application encryption key has been specified.`

**Solusi:**

```bash
cd /var/www/html/belajar-laravel
php artisan key:generate
```

---

## 6. Project Berjalan Lambat (Karena Disimpan di /mnt/c/)

**Gejala:** `composer install` atau `php artisan` berjalan sangat lambat.

**Penyebab:** Project disimpan di drive Windows (`/mnt/c/...`) yang akses baca-tulisnya lambat dari WSL.

**Solusi:** Pindahkan project ke filesystem Ubuntu:

```bash
mv /mnt/c/Users/nama/Documents/project-laravel ~/project-laravel   # atau
sudo mv /mnt/c/Users/nama/Documents/project-laravel /var/www/html/
```

> **Aturan penting:** Selama kuliah Laravel, simpan project di `/var/www/html/` atau di folder home `~`. Jangan di `/mnt/c/`.

---

## 7. File hosts Tidak Bisa Disimpan

**Gejala:** Gagal menyimpan file hosts setelah menambahkan `127.0.0.1 belajar-laravel.test`.

**Solusi:**

1. Buka **Notepad sebagai Administrator** (klik kanan → Run as administrator)
2. Buka file `C:\Windows\System32\drivers\etc\hosts`
3. Edit dan simpan

Jika tetap gagal, periksa apakah file hosts dalam keadaan **Read-only**:
1. Klik kanan file hosts → **Properties**
2. Hilangkan centang **Read-only**
3. **Apply → OK**

---

## 8. 503 Service Unavailable atau 403 Forbidden

**Gejala:** Muncul error 503 atau 403 saat mengakses project.

**Solusi:**

```bash
# Aktifkan rewrite module
sudo a2enmod rewrite

# Restart Apache
sudo service apache2 restart

# Cek error log
sudo tail -f /var/log/apache2/error.log
```

---

## 9. Tips Jika Semua Error di Atas Tidak Membantu

1. **Restart WSL** — di PowerShell/Terminal Windows, jalankan:

   ```powershell
   wsl --shutdown
   ```

   Lalu buka Ubuntu lagi dan coba lagi.

2. **Restart laptop** — jangan remehkan kekuatan restart

3. **Cek log** — seringkali pesan error sudah jelas tinggal dibaca:

   ```bash
   sudo tail -f /var/log/apache2/error.log
   cat /var/www/html/belajar-laravel/storage/logs/laravel.log
   ```

4. **Tanya ke dosen atau teman** — sertakan screenshot atau copy paste pesan error-nya

5. **Jika benar-benar mentok** — gunakan Laragon saja. Tidak ada yang salah dengan pindah jalur.

---

**Kembali ke:** [Membuat Project Laravel →](03-buat-project.md)
