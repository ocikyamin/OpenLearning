## FORMAT VIDEO DEMO UAS

Proyek Pemrograman III (PHP & MySQL – CI4)

**Durasi video** : **8–12 menit**
**Bentuk** : Screen recording + suara penjelasan (wajah boleh tampil di awal/akhir)
**Semua anggota** : wajib berbicara (minimal 1 bagian per orang)

---

## **1. Opening & Identitas Kelompok (± 1 menit)**

Tampilkan **slide atau layar awal** berisi:

* Judul aplikasi
* Nama kelompok
* Nama anggota + NIM
* Mata kuliah & dosen

**Narasi yang disampaikan:**

> “Video ini merupakan demo proyek UAS mata kuliah Bahasa Pemrograman III menggunakan CodeIgniter 4 dan MySQL.”

---

## **2. Penjelasan Tema & Gambaran Aplikasi (± 1 menit)**

Tampilkan **halaman utama aplikasi**.

Jelaskan secara singkat:

* Tema aplikasi (contoh: sistem pengaduan, manajemen data santri, inventori, dsb.)
* Masalah yang ingin diselesaikan
* Target pengguna aplikasi

**Catatan penting untuk mahasiswa:**

* Tidak perlu teori panjang
* Fokus ke *apa fungsi aplikasi ini*

---

## **3. Struktur Proyek & CLI (± 1 menit)**

Tampilkan:

* Struktur folder CI4 di VS Code
* Folder `Controllers`, `Models`, `Views`, `Database/Migrations`

Lalu jelaskan:

* Semua controller, model, migration dibuat dengan **php spark**
* Tampilkan **contoh command CLI**, misalnya:

```
php spark make:controller User
php spark make:model UserModel
php spark make:migration CreateUsersTable
```

---

## **4. Database, ERD & Migration (± 1–2 menit)**

Tampilkan salah satu:

* Gambar ERD
* Atau file migration

Jelaskan:

* Jumlah tabel yang digunakan
* Relasi antar tabel (one-to-many / many-to-many)
* Contoh field penting

Tekankan:

* **Semua tabel dibuat melalui migration**
* Bukan manual di phpMyAdmin

---

## **5. Demo Login & Register (± 1 menit)**

Tampilkan langsung:

* Halaman login
* Halaman register
* Proses login berhasil

Jelaskan:

* Autentikasi menggunakan session
* Role user jika ada

---

## **6. Demo CRUD Lengkap (± 2 menit)**

Pilih **1 modul utama**, lalu perlihatkan:

* Tambah data
* Tampil data
* Edit data
* Hapus data

Jelaskan singkat:

* Controller
* Model
* View menggunakan layout dinamis

---

## **7. Demo JOIN Relasi Tabel (± 1 menit)**

Tampilkan:

* Halaman yang menggunakan data dari **lebih dari satu tabel**
* Contoh: data transaksi + user, data santri + kelas

Jelaskan:

* Relasi tabel
* Query JOIN (cukup dijelaskan, tidak perlu detail kode)

---

## **8. Demo AJAX & Validasi (± 1 menit)**

Tampilkan:

* Form dengan AJAX (tanpa reload)
* Pesan sukses / error
* Validasi client & server

Tekankan:

* Menggunakan **jQuery AJAX**
* Minimal satu modul

---

## **9. Layout Bootstrap & Template Dinamis (± 1 menit)**

Tampilkan:

* File `layout/main.php`
* Contoh `extend` dan `section`

Jelaskan:

* Menggunakan Bootstrap
* Layout dinamis (header, sidebar, footer satu file)
* Halaman lain hanya isi konten

---

## **10. Penutup & Pembagian Tugas (± 1 menit)**

Sampaikan:

* Ringkasan fitur aplikasi
* Pembagian tugas tiap anggota
* Kendala dan solusi singkat

Akhiri dengan:

> “Demikian demo proyek UAS kami. Terima kasih.”

---

## **KETENTUAN TEKNIS VIDEO (WAJIB)**

* Audio **jelas**
* Tidak terpotong
* Aplikasi **berjalan tanpa error**
* Durasi **tidak kurang dari 8 menit**
* Video menampilkan **demo nyata**, bukan slide saja

---

## **KESALAHAN YANG HARUS DIHINDARI MAHASISWA**

* Hanya menjelaskan tanpa demo
* Tidak menampilkan migration & CLI
* Tidak memperlihatkan AJAX
* Tidak menjelaskan layout CI4
* Hanya satu orang yang bicara

