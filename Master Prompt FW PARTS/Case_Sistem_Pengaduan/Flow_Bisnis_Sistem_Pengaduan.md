# Case Study: Sistem Pengaduan Akademik

## 1. Product Overview

**Latar Belakang:**
Mahasiswa di sebuah kampus kesulitan menyampaikan keluhan atau pengaduan secara terstruktur. Pengaduan sering disampaikan melalui pesan WhatsApp pribadi ke dosen, chat grup, atau lisan — yang tidak terdokumentasi dengan baik. Pihak kampus tidak memiliki dashboard terpusat untuk memantau, menindaklanjuti, dan melacak status penyelesaian setiap pengaduan.

**Masalah:**
- Tidak ada saluran pengaduan resmi yang terstandarisasi
- Mahasiswa tidak bisa melacak status pengaduannya
- Admin kampus kesulitan mengelola dan memprioritaskan pengaduan yang masuk
- Tidak ada data historis pengaduan yang bisa dianalisis untuk perbaikan berkelanjutan

**Solusi:**
Sistem Pengaduan Akademik berbasis web yang memungkinkan mahasiswa melapor, admin memproses, dan semua pihak memantau status penyelesaian secara transparan melalui kode tracking unik.

---

## 2. Actors & Goals

| Aktor | Peran | Tujuan |
|-------|-------|--------|
| Pelapor | Mahasiswa atau pihak yang melaporkan masalah | Melapor dengan/tanpa login, melacak status via kode tracking, mendapat kepastian laporan ditindaklanjuti |
| Petugas Admin | Staf kampus yang mengelola pengaduan | Memantau, memfilter, memproses, dan mengubah status pengaduan; mengelola kategori dan pengguna sistem |

---

## 3. Core Features

| ID | Fitur | Acceptance Criteria | Prioritas |
|----|-------|---------------------|-----------|
| F-01 | Pengajuan Pengaduan | Pelapor dapat mengirim pengaduan lengkap dengan kategori, judul, deskripsi, dan lampiran (gambar/dokumen/tautan), serta memilih anonim atau tidak | High |
| F-02 | Pelacakan via Kode Tracking | Pelapor dapat memasukkan kode tracking dan melihat status terkini pengaduan tanpa perlu login | High |
| F-03 | Registrasi Akun | Pengguna dapat mendaftar dengan nama, email, dan password | High |
| F-04 | Login / Logout | Pengguna dapat login dan logout menggunakan email dan password | High |
| F-05 | Riwayat Pengaduan Pelapor | Pelapor yang login dapat melihat daftar semua pengaduan yang pernah diajukan dari akunnya | Medium |
| F-06 | Dashboard Admin | Admin melihat ringkasan statistik pengaduan (total, per status, per kategori) | High |
| F-07 | Daftar & Filter Pengaduan | Admin dapat melihat semua pengaduan, memfilter berdasarkan status, dan mencari berdasarkan kata kunci | High |
| F-08 | Ubah Status Pengaduan | Admin dapat mengubah status pengaduan sesuai aturan transisi yang berlaku | High |
| F-09 | Kelola Kategori | Admin dapat menambah, melihat, mengubah, dan menghapus kategori pengaduan | Medium |
| F-10 | Kelola Pengguna | Admin dapat menambah, melihat, mengubah, dan menghapus pengguna sistem, termasuk mengubah peran (role) | Medium |

---

## 4. User Flows

### Alur A: Pelapor Mengajukan Pengaduan

1. Pelapor membuka halaman pengaduan (tanpa perlu login jika memilih anonim).
2. Pelapor mengisi formulir: memilih kategori, menulis judul dan deskripsi, melampirkan bukti (gambar/dokumen/tautan), dan memilih apakah identitasnya ditampilkan atau anonim.
3. Sistem memvalidasi data, menyimpan pengaduan, dan menghasilkan kode tracking unik.
4. Pelapor menerima kode tracking untuk memantau status nanti.

### Alur B: Pelapor Melacak Status Pengaduan

1. Pelapor membuka halaman pelacakan dan memasukkan kode tracking yang diterima sebelumnya.
2. Sistem menampilkan detail pengaduan: judul, deskripsi, status terkini, bukti lampiran, dan riwayat perubahan status.
3. Jika pengaduan bersifat anonim, identitas pelapor tidak ditampilkan.

### Alur C: Admin Mengelola Pengaduan Masuk

1. Admin login ke dashboard menggunakan kredensial khusus.
2. Admin melihat daftar semua pengaduan, bisa memfilter berdasarkan status (pending/processing/resolved/rejected) atau mencari berdasarkan kata kunci.
3. Admin membuka detail pengaduan untuk meninjau isi laporan dan lampiran.
4. Admin mengubah status pengaduan sesuai dengan tindakan yang diambil.

### Alur D: Admin Mengelola Kategori

1. Admin masuk ke halaman kelola kategori.
2. Admin dapat menambah kategori baru (nama, slug), melihat daftar kategori, mengubah nama, atau menghapus kategori.
3. Kategori yang sudah memiliki pengaduan terkait tidak boleh dihapus.

### Alur E: Admin Mengelola Pengguna

1. Admin masuk ke halaman kelola pengguna.
2. Admin dapat menambah pengguna baru, melihat daftar pengguna, mengubah data/role, atau menghapus pengguna.
3. Pengguna yang memiliki riwayat pengaduan sebaiknya dinonaktifkan, bukan dihapus permanen.

### Alur F: Registrasi & Autentikasi

1. Pelapor mendaftar dengan nama, email, dan password.
2. Pelapor login dengan email dan password untuk mengakses fitur tambahan.
3. Setelah login, pelapor bisa mengajukan pengaduan tanpa mengisi data diri lagi dan melihat riwayat pengaduan.

---

## 5. Business Rules

### Status Pengaduan

Setiap pengaduan memiliki status yang mencerminkan tahap penanganan:

```
pending → processing → resolved (final)
pending → rejected (final)
processing → rejected (final)
```

| Dari | Ke | Syarat |
|------|----|--------|
| pending | processing | Admin menerima dan mulai memproses aduan |
| pending | rejected | Admin menolak aduan (tidak valid, duplikat, di luar wewenang) |
| processing | resolved | Aduan selesai ditangani |
| processing | rejected | Ditolak setelah ditinjau lebih lanjut |
| resolved | — | Status final, tidak bisa diubah |
| rejected | — | Status final, tidak bisa diubah |

### Anonimitas

- Pelapor bisa memilih untuk melapor secara anonim.
- Jika anonim, identitas pelapor tidak boleh ditampilkan di halaman pelacakan publik maupun di dashboard admin.
- Pelapor anonim tetap mendapatkan kode tracking.

### Kode Tracking

- Setiap pengaduan memiliki kode tracking unik yang auto-generate.
- Kode tracking tidak bisa diubah setelah pengaduan dibuat.
- Format kode: kombinasi prefix, tanggal, dan karakter acak (misal: `ADU-202606-A8X9K2`).
- Kode tracking adalah satu-satunya cara pelapor anonim mengakses data pengaduannya.

### Kategori

- Setiap pengaduan harus memiliki satu kategori.
- Kategori yang sudah memiliki pengaduan terkait tidak boleh dihapus.
- Nama kategori harus unik.

### Lampiran

- Pelapor bisa melampirkan file gambar (JPEG, PNG), dokumen (PDF), atau tautan URL.
- Batas ukuran file: maksimal 5MB per file.

### Akses

- Halaman pengajuan dan pelacakan aduan: publik.
- Dashboard admin: hanya untuk pengguna dengan peran admin.
- Admin tidak bisa mengubah status pengaduan yang sudah `resolved` atau `rejected`.

---

## 6. Non-Functional Requirements

| Aspek | Deskripsi | Tolak Ukur |
|-------|-----------|------------|
| Keamanan | Password di-hash, akses admin terproteksi role-based | Tidak ada akses tanpa otorisasi ke halaman admin |
| Usability | Antarmuka sederhana dan intuitif | Pengguna pertama kali bisa menyelesaikan pengaduan tanpa panduan |
| Responsif | Tampilan berfungsi di desktop dan mobile | Semua halaman bisa diakses dari layar HP tanpa error layout |
| Performa | Halaman dimuat dengan cepat | Waktu muat halaman < 3 detik |
| Reliabilitas | Data tidak hilang saat error | Operasi penyimpanan menggunakan transaksi database |

---

## 7. Out of Scope

- Notifikasi real-time (email, WhatsApp, push notification)
- Export laporan ke PDF atau Excel
- Rating kepuasan penyelesaian
- Dashboard analitik lanjutan (grafik tren, prediksi)
- Fitur komentar atau diskusi antara pelapor dan admin
- Multi-bahasa (i18n)
- Integrasi dengan sistem akademik yang sudah ada
- Aplikasi mobile native

---

## 8. End-to-End Scenarios

### Skenario A: Mahasiswa melaporkan AC rusak secara anonim (Happy Path)

| Langkah | Aksi | Hasil |
|---------|------|-------|
| 1 | Pelapor membuka halaman pengaduan | Melihat formulir pengaduan |
| 2 | Memilih kategori Fasilitas, mengisi judul "AC Rusak di Ruang 203", deskripsi detail, memilih anonim, upload foto | Pengaduan terkirim, mendapat kode tracking `ADU-202606-A8X9K2` |
| 3 | Pelapor membuka halaman lacak, masukkan kode tracking | Melihat status: **pending** |
| 4 | Admin login ke dashboard | Melihat ringkasan pengaduan baru |
| 5 | Admin buka detail, tinjau isi dan lampiran | Admin yakin ini valid |
| 6 | Admin ubah status menjadi **processing** | Status berubah |
| 7 | Pelapor cek lagi via tracking | Melihat status: **processing** |
| 8 | Admin selesai menangani, ubah status jadi **resolved** | Status berubah |
| 9 | Pelapor cek terakhir | Melihat status: **resolved** |

### Skenario B: Aduan ditolak karena duplikat (Error Path)

| Langkah | Aksi | Hasil |
|---------|------|-------|
| 1 | Pelapor mengirim pengaduan | Mendapat kode tracking |
| 2 | Admin login dan melihat pengaduan baru | Admin sadar ini duplikat dari pengaduan sebelumnya |
| 3 | Admin mengubah status menjadi **rejected** | Status berubah |
| 4 | Pelapor cek status | Melihat status: **rejected** |

### Skenario C: Kode tracking salah (Edge Case)

| Langkah | Aksi | Hasil |
|---------|------|-------|
| 1 | Pelapor memasukkan kode `ADU-202606-WRONG` di halaman lacak | Sistem menampilkan pesan: "Kode tracking tidak ditemukan" |

### Skenario D: Validasi gagal saat mengisi pengaduan (Error Path)

| Langkah | Aksi | Hasil |
|---------|------|-------|
| 1 | Pelapor mengirim formulir tanpa mengisi judul | Sistem menolak, pesan: "Judul pengaduan wajib diisi" |
| 2 | Pelapor mengisi judul, kirim lagi | Pengaduan berhasil dikirim |

### Skenario E: Pengguna biasa mencoba akses admin (Error Path)

| Langkah | Aksi | Hasil |
|---------|------|-------|
| 1 | Pengguna biasa login dengan akun mahasiswa | Login berhasil |
| 2 | Pengguna mencoba mengakses halaman dashboard admin | Ditolak, mendapat pesan "Akses ditolak" |

### Skenario F: Admin CRUD kategori (Happy Path)

| Langkah | Aksi | Hasil |
|---------|------|-------|
| 1 | Admin login dan masuk ke halaman kelola kategori | Melihat daftar kategori |
| 2 | Admin klik "Tambah Kategori", isi nama "Olahraga" | Kategori baru tersimpan |
| 3 | Admin lihat daftar kategori | Kategori "Olahraga" muncul |
| 4 | Admin ubah nama menjadi "Fasilitas Olahraga" | Nama berubah |
| 5 | Admin hapus kategori (tidak terkait aduan) | Kategori terhapus |

### Skenario G: Admin CRUD pengguna (Happy Path)

| Langkah | Aksi | Hasil |
|---------|------|-------|
| 1 | Admin login dan masuk ke halaman kelola pengguna | Melihat daftar pengguna |
| 2 | Admin klik "Tambah Pengguna", isi data role "pelapor" | Pengguna baru tersimpan |
| 3 | Admin lihat daftar pengguna | Pengguna baru muncul |
| 4 | Admin ubah role dari "pelapor" jadi "admin" | Role berubah |
| 5 | Admin hapus pengguna tanpa riwayat aduan | Pengguna terhapus |
