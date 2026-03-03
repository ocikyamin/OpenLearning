* Fokus per topik
* Tidak melelahkan mahasiswa
* Mudah direvisi jika ada update versi
* Cocok untuk LMS / YouTube playlist

Di bawah ini saya susun:

1. Struktur pembagian part
2. Tujuan tiap video
3. Narasi lengkap yang bisa langsung Anda baca
4. Alasan konseptual kenapa pakai WSL + Ubuntu

---

# 🎬 STRUKTUR VIDEO YANG DIREKOMENDASIKAN

## ✅ PART 1 — Kenapa Perlu WSL & Ubuntu? (Fondasi Konseptual)

Durasi: 5–7 menit
Tujuan: Mahasiswa paham *why*, bukan sekadar ikut install.

## ✅ PART 2 — Install WSL & Ubuntu 24.04

Durasi: 6–8 menit
Tujuan: Instalasi bersih sampai terminal terbuka.

## ✅ PART 3 — Setup User & Update System

Durasi: 5–6 menit
Tujuan: Konfigurasi awal + mindset best practice.

## (Opsional) PART 4 — Verifikasi & Struktur Dasar Linux

Durasi: 5 menit
Tujuan: Mengenalkan terminal sebagai lingkungan kerja programmer.

Total ideal: **3 part utama** (opsional 4 kalau ingin lebih matang secara pedagogis).

---

# 🎙 NARASI VIDEO

---

# 🎬 PART 1

# Kenapa Kita Menggunakan WSL dan Ubuntu?

### 🎙 Narasi:

Di video ini kita tidak langsung instalasi.
Kita akan pahami dulu: **kenapa kita menggunakan WSL dan Ubuntu?**

Sebagai programmer, kita perlu lingkungan kerja yang stabil, konsisten, dan mendekati server production.

Mayoritas server di dunia berjalan menggunakan Linux.
Contohnya:

* Server cloud seperti Amazon Web Services
* Google Cloud
* Microsoft Azure

Sebagian besar menjalankan distribusi Linux.

Kalau kita belajar programming hanya di Windows tanpa environment Linux, ada beberapa masalah:

* Perintah berbeda
* Struktur file berbeda
* Permission berbeda
* Beberapa tools tidak optimal di Windows native

### Lalu kenapa tidak install Linux langsung?

Karena:

* Tidak semua mahasiswa siap dual boot
* Risiko partisi
* Repot untuk pemula

### Maka solusinya: WSL

WSL adalah singkatan dari **Windows Subsystem for Linux**.

WSL memungkinkan kita menjalankan Linux di dalam Windows tanpa virtual machine.

Artinya:

* Tidak perlu install VirtualBox
* Tidak perlu dual boot
* Ringan
* Native integration dengan Windows

### Kenapa Ubuntu?

Kita menggunakan Ubuntu karena:

* Distribusi Linux paling populer
* Dokumentasi sangat banyak
* Stabil
* Cocok untuk server
* Banyak tutorial

Versi yang kita gunakan adalah Ubuntu 24.04 karena:

* Versi LTS (Long Term Support)
* Stabil untuk pembelajaran jangka panjang

Jadi mindset kita jelas:

> Kita tidak sedang install Linux untuk gaya-gayaan.
> Kita sedang membangun environment profesional.

Di video berikutnya, kita mulai instalasi.

---

# 🎬 PART 2

# Instalasi WSL dan Ubuntu 24.04

### 🎙 Narasi:

Sekarang kita masuk ke tahap instalasi.

Pastikan laptop sudah restart setelah mengaktifkan WSL.

Langkah pertama, buka PowerShell.

Kemudian jalankan perintah berikut:

```powershell
wsl --install -d Ubuntu-24.04
```

Perintah ini akan:

* Mengunduh Ubuntu 24.04
* Menginstal image Linux
* Mengkonfigurasi environment awal

Tunggu hingga proses selesai.

Jika berhasil, akan muncul jendela terminal hitam otomatis.

Jangan panik.

Itu adalah mesin Linux kita yang sedang pertama kali diaktifkan.

Di tahap ini biasanya muncul pesan:

Installing, this may take a few minutes...

Tunggu sampai selesai.

Di video berikutnya kita akan membuat user Linux.

---

# 🎬 PART 3

# Membuat User dan Update Sistem

### 🎙 Narasi:

Sekarang Ubuntu sudah terbuka.

Langkah pertama adalah membuat user.

Akan muncul:

Enter new UNIX username:

Isi dengan:

* Huruf kecil semua
* Tanpa spasi

Contoh:
budi
mahasiswa
rahmat

Tekan Enter.

Selanjutnya sistem meminta password.

Perhatikan ini baik-baik.

Saat mengetik password:

* Tidak ada bintang
* Tidak ada kursor bergerak

Ini bukan error.
Ini sistem keamanan Linux.

Ketik saja sampai selesai lalu tekan Enter.

Jika berhasil, akan muncul tampilan seperti:

username@LAPTOP-NAMA:~$

Artinya Anda sudah masuk ke sistem Linux.

---

Sekarang kita lakukan kebiasaan profesional:

Update sistem.

Jalankan:

```bash
sudo apt update && sudo apt upgrade -y
```

Kenapa ini penting?

Karena:

* Memperbarui repository
* Menutup celah keamanan
* Menghindari konflik paket
* Menjaga sistem tetap stabil

Masukkan password ketika diminta.

Tunggu hingga selesai.

Sekarang environment Linux Anda sudah siap digunakan.

---

# 🎬 (OPSIONAL) PART 4

# Memahami Terminal sebagai Workspace Programmer

Jika ingin lebih mendidik secara konsep:

Anda bisa tambahkan:

* Perintah `pwd`
* `ls`
* `cd`
* Struktur home directory

Tujuannya agar mahasiswa tidak hanya instalasi, tapi memahami bahwa:

> Terminal adalah workspace utama programmer backend.

---

# 🎯 Rekomendasi Final untuk Anda (Sebagai Pengajar)

Karena Anda mengajar pemrograman di era AI, saya sarankan:

Jangan hanya ajarkan cara install.

Ajarkan mindset:

* Environment parity
* Reproducible development
* Production similarity
* CLI literacy

Kalau hanya install tanpa konteks, mahasiswa akan lupa.

Kalau mereka paham kenapa Linux dominan di server, mereka akan lebih menghargai prosesnya.

---

Jika Anda mau, saya bisa bantu:

* Buatkan script narasi yang lebih “dramatis dan engaging”
* Buatkan storyboard visual per menit
* Atau buatkan versi untuk LMS lengkap dengan learning objective dan assessment

Anda ingin formatnya untuk YouTube, LMS kampus, atau materi kelas internal?
