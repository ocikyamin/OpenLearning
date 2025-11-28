# **SOAL UJIAN AKHIR SEMESTER (UAS) – PROYEK PEMROGRAMAN WEB PHP & MYSQL**

**Program Studi : Pendidikan Teknik Informatika dan Komputer**
**Mata Kuliah : Bahasa Pemrograman III (PHP & MySQL)**
**Dosen Pengampu : Abdul Yamin, S.Pd., M.Kom**
**Semester : V**
**Model UAS : Proyek Kelompok (maksimal 3 mahasiswa)**

---

# **I. Deskripsi Umum Tugas**

Mahasiswa diminta membuat **proyek aplikasi web nyata** sesuai tema yang telah disetujui dosen. Aplikasi wajib dikembangkan menggunakan:

* **CodeIgniter 4 (CI4)**
* **CLI / php spark** untuk generate file (Membuat db, migration, controller, model, filters)
* **Migration (WAJIB)**
* **Autentikasi dasar (Login & Register, session)**
* **CRUD lengkap**
* **Relasi/Join minimal 2 tabel**
* **jQuery AJAX minimal pada satu modul**
* **Validasi server dan client**
* **Template Bootstrap dengan layouting dinamis (WAJIB)**
* Dokumentasi berbentuk makalah sesuai format ilmiah

Aplikasi harus berjalan penuh tanpa error.

---

# **II. Tujuan Pembelajaran**

Melalui project ini mahasiswa mampu:

1. Menerapkan struktur MVC dalam CI4.
2. Menggunakan CLI untuk membangun modul secara standar.
3. Membangun database menggunakan migration.
4. Mengembangkan aplikasi dengan tampilan UI modern berbasis Bootstrap
5. Membuat layout dinamis (template master + section konten).
6. Menerapkan login, CRUD, join tabel, dan AJAX.
7. Menyusun laporan ilmiah sebagai dokumentasi proyek.
8. Bekerja dalam tim dengan pembagian tugas.

---

# **III. Ketentuan Teknis Proyek (WAJIB)**

## **A. Struktur Proyek**

* Semua file utama (controller, model, migration) **wajib** dibuat dengan CLI:

  ```
  php spark make:controller ...
  php spark make:model ...
  php spark make:migration ...
  ```
* Menggunakan struktur folder standar CI4
* Menyertakan file `.env.example`

---

## **B. Database**

* Menggunakan MySQL/MariaDB
* Semua tabel dibuat melalui migration
* Minimal memiliki:

  * Tabel user (login/register)
  * Minimal **3 tabel**
  * Minimal **1 relasi one-to-many atau many-to-many**

---

## **C. Fitur Minimal**

1. **Login & Register** (wajib menggunakan session)
2. **CRUD minimal 2 modul**
3. **Fitur khusus menggunakan JOIN relasi tabel**
4. **Minimal 1 modul menggunakan jQuery AJAX**
5. **Validasi form (server + client)**

---

## **D. Wajib Menggunakan Bootstrap + Layout Dinamis**

Setiap kelompok wajib:

### **1. Menggunakan Bootstrap (Template)**

* Tampilan harus responsif
* Harus menggunakan minimal:

* 1 file **layout utama** (misal: `app/Views/layout/main.php`)
* File halaman dibuat dengan teknik **section + extend**
  Contoh:

  ```php
  <?= $this->extend('layout/main'); ?>
  <?= $this->section('content'); ?>
      <!-- Konten CRUD -->
  <?= $this->endSection(); ?>
  ```

### **2. Navigasi Dinamis**

* Sidebar atau navbar harus di-*render* dari satu file
* Halaman CRUD hanya mengisi konten saja (modular)


# **IV. Dokumentasi Proyek (Laporan UAS)**

Laporan disusun berbentuk **makalah ilmiah** dengan isi:

### **Bab I – Pendahuluan**

* Latar belakang
* Rumusan masalah
* Tujuan
* Manfaat

### **Bab II – Perancangan Sistem**

* Use case
* ERD
* Struktur database
* Flow sistem (Opsional)
* Desain UI (wireframe opsional)
* Struktur folder CI4 + layout dinamis

### **Bab III – Implementasi**

* Konfigurasi CI4
* Migration
* Screenshots halaman
* Penjelasan layout Bootstrap
* Modul login, CRUD, join, AJAX
* Command CLI yang digunakan

### **Bab IV – Pengujian**

* Tabel pengujian
* Pengujian login
* Pengujian CRUD
* Pengujian AJAX
* Pengujian layout responsif

### **Bab V – Penutup**

* Kesimpulan
* Saran pengembangan

### **Lampiran**

* Potongan kode
* Link GitHub
* Export SQL (opsional)

---

# **V. Presentasi / Rekaman Demo Project**
Kelompok wajib melakukan salah satu:

---

## **1. Presentasi Langsung (10–12 menit)**

Format:

1. Perkenalan tim
2. Penjelasan tema
3. Demo aplikasi
4. Penjelasan layout Bootstrap
5. ERD & migration
6. Penutup
7. Tanya jawab

---

## **2. Rekaman Video (8–12 menit)**

Format video:

* Identitas kelompok
* Penjelasan tema
* Demo login, CRUD, join, AJAX
* Tampilkan penggunaan Bootstrap dan layout dinamis
* Penjelasan ERD & migration
* Penutup

Semua anggota wajib tampil/suara.

---

# **VI. Penilaian**

### **1. Penilaian Kode (60%)**

| Komponen                   | Bobot |
| -------------------------- | ----- |
| Penggunaan CLI             | 10%   |
| Migration                  | 10%   |
| Login/Register             | 10%   |
| CRUD                       | 10%   |
| Relasi/Join                | 10%   |
| AJAX                       | 5%    |
| Layout dinamis + Bootstrap | 5%    |

### **2. Penilaian Aplikasi (20%)**

* Responsif & rapi
* Fitur sesuai tema
* Tidak error

### **3. Penilaian Laporan (20%)**

* Struktur makalah
* Perancangan
* Implementasi
* Pengujian
* Kerapian

### **4. Penilaian Presentasi/Video (Tambahan 20%)**

* Kelengkapan penjelasan
* Demo berhasil
* Penjelasan teknis jelas
* Kekompakan tim

---

# **VII. Pengumpulan**

* ZIP aplikasi + link GitHub
* PDF laporan
* Video presentasi (jika tidak tampil langsung)
* Deadline: Mengikut Batas Perkulihan Kalender Akademik

---

# **VIII. Sanksi**

* Tidak menggunakan Bootstrap → **-10 poin**
* Tidak membuat layout dinamis (extend/section CI4) → **-10 poin**
* Migration tidak dibuat → **project tidak dinilai**
* Tidak menggunakan CLI → **-10 poin**
* Plagiasi → **nilai 0**
* Terlambat → **-5 poin per hari**
