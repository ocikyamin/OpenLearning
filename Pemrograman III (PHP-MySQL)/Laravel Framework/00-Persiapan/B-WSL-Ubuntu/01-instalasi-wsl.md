# Instalasi WSL 2 + Ubuntu

WSL (Windows Subsystem for Linux) adalah fitur Windows yang memungkinkan kita menjalankan Linux langsung di dalam Windows — tanpa perlu dual boot atau mesin virtual. Dengan WSL, kita bisa merasakan lingkungan kerja Linux yang mirip dengan server sungguhan.

---

## Sebelum Memulai

Pastikan hal-hal berikut sudah terpenuhi:

- Windows 10 versi 2004 ke atas, atau Windows 11
- RAM minimal 8 GB
- Koneksi internet yang stabil
- Virtualisasi sudah aktif di BIOS (biasanya sudah aktif secara default di laptop modern)

> **Bagaimana cek apakah virtualisasi aktif?** Buka Task Manager (Ctrl+Shift+Esc) → tab Performance. Di bagian bawah, cari tulisan **Virtualization: Enabled**.

---

## Langkah 1 — Install WSL

Caranya sangat mudah. Cukup satu perintah saja:

1. Klik kanan tombol Start → pilih **Windows PowerShell (Admin)** atau **Terminal (Admin)**
2. Ketik perintah berikut:

   ```powershell
   wsl --install
   ```
3. Tunggu prosesnya. WSL akan otomatis:
   - Mengaktifkan fitur WSL di Windows
   - Menginstall Ubuntu versi terbaru
   - Mengatur WSL 2 sebagai versi default

> **Lamanya:** Sekitar 5-15 menit tergantung koneksi internet.

4. Jika sudah selesai, akan muncul pemberitahuan untuk **restart komputer**
5. Lakukan restart

---

## Langkah 2 — Setup Ubuntu

Setelah restart, secara otomatis akan terbuka jendela Ubuntu. Jika tidak, cari "Ubuntu" di Start Menu.

1. Tunggu hingga proses instalasi selesai (beberapa menit, muncul tulisan-tulisan)
2. Akan diminta membuat **username** dan **password**:

   ```
   Enter new UNIX username: mahasiswa      
   New password: 
   Retype new password: 
   ```

   > **Tips:**
   > - Username: pakai nama panggilan saja, misal `mahasiswa` atau nama masing-masing
   > - Password: buat yang mudah diingat. Saat mengetik, tidak ada bintang/indikasi — itu normal
   > - Password ini akan diminta setiap kali kita menggunakan perintah `sudo`

3. Jika sudah selesai, akan muncul tampilan seperti ini:

   ```
   mahasiswa@LAPTOP:~$ 
   ```

   Selamat! Sekarang kita sudah berada di dalam terminal Ubuntu ✅

---

## Langkah 3 — Update Ubuntu

Sebelum mulai menginstal apapun, biasakan untuk memperbarui daftar package terlebih dahulu:

```bash
sudo apt update && sudo apt upgrade -y
```

Proses ini akan memakan waktu 2-5 menit. Biarkan saja.

---

## Langkah 4 — Kenali Perintah Dasar Terminal

| Perintah | Fungsi |
|----------|--------|
| `pwd` | Lihat posisi folder saat ini |
| `ls` | Lihat daftar file dan folder |
| `cd nama-folder` | Masuk ke folder tertentu |
| `cd ..` | Kembali ke folder sebelumnya |
| `mkdir nama-folder` | Buat folder baru |
| `clear` | Bersihkan layar terminal |
| `sudo` | Jalankan perintah sebagai administrator (akan diminta password) |
| `exit` | Keluar dari terminal |

> **Tips:** Tidak perlu dihafal semua. Nanti sambil jalan, perintah-perintah ini akan sering digunakan sehingga otomatis hafal.

---

## Langkah 5 — Cara Mengakses File Windows dari Ubuntu

File atau folder di Windows bisa diakses dari Ubuntu melalui `/mnt/`:

```bash
ls /mnt/c/Users/
```

Misal, untuk mengakses folder Downloads:

```bash
ls /mnt/c/Users/nama-user/Downloads
```

> **Peringatan Penting:** Untuk project Laravel, **jangan bekerja di folder /mnt/c/**. Akses baca-tulisnya lambat. Simpan project di dalam filesystem Ubuntu (folder home `~` atau `/var/www/html`). Ini akan dijelaskan nanti.

---

## Perintah WSL yang Berguna (Dari PowerShell/Terminal Windows)

| Perintah (PowerShell/CMD) | Fungsi |
|---------------------------|--------|
| `wsl` | Masuk ke terminal Ubuntu |
| `wsl --shutdown` | Matikan WSL (jika ada masalah) |
| `wsl -l -v` | Lihat daftar distribusi dan versi WSL |

---

## Ringkasan

| No | Langkah | Perintah |
|----|---------|----------|
| 1 | Buka PowerShell sebagai Administrator | — |
| 2 | Install WSL | `wsl --install` |
| 3 | Restart komputer | — |
| 4 | Setup username & password Ubuntu | — |
| 5 | Update Ubuntu | `sudo apt update && sudo apt upgrade -y` |

---

**Lanjut ke:** [Instalasi LAMP (Apache, PHP, MySQL) →](02-instalasi-lamp.md)
