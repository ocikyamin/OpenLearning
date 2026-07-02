# Tugas 1 — Pengantar Laravel

---

## Tujuan

Mahasiswa mampu membuat project Laravel, mendefinisikan route, dan menampilkan view sederhana.

---

## Soal

### 1. Project Baru

Buat project Laravel baru dengan nama `tugas-laravel-1`.

> Gunakan perintah `laravel new tugas-laravel-1`, pilih SQLite.

### 2. Route & View

Buatlah halaman dengan ketentuan berikut:

| URL | Yang Ditampilkan |
|-----|------------------|
| `/profile` | Nama lengkap, NIM, dan kelas |
| `/bio` | Paragraf tentang diri sendiri (minimal 3 kalimat) |
| `/p` | Mengarahkan (redirect) ke `/profile` |

### 3. Layout

Buat layout utama bernama `layouts/app.blade.php` yang digunakan oleh kedua halaman di atas. Layout harus memiliki:

- Tag `<title>` yang dinamis (berubah sesuai halaman)
- Navigasi sederhana (link ke `/profile` dan `/bio`)
- Footer berisi tulisan "© 2026 — Pemrograman III"

### 4. Data Dinamis

Buat route `/hitung/{angka1}/{angka2}` yang menampilkan hasil penjumlahan dua angka tersebut.

Contoh: `/hitung/5/3` → menampilkan "Hasil penjumlahan 5 + 3 = 8"

---

## Ketentuan Pengumpulan

- Kumpulkan dalam bentuk screenshot kode dan hasil di browser
- atau kumpulkan link repository GitHub (jika sudah bisa git)
- Batas pengumpulan: sebelum pertemuan berikutnya

---

## Rubrik Penilaian

| Aspek | Bobot |
|-------|-------|
| Project berjalan dengan benar | 20% |
| Route & View (/profile, /bio) | 20% |
| Layout dengan template | 25% |
| Route dinamis (/hitung) | 20% |
| Kerapihan kode & struktur folder | 15% |
