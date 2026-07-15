# Rencana Pembuatan Gambar Visual Kurikulum

> Prioritas pembuatan diagram/gambar untuk mendukung bahan ajar 10 BAB.
> Disusun: 15 Juli 2026

---

## Prioritas Tinggi — Konsep Abstrak (Belum Ada Visual)

| BAB | Visual | File | Lokasi | Prompt untuk AI Image Generator |
|-----|--------|------|--------|-------------------------------|
| **3** | Diagram alur **Request → Route → Controller → Response** | `03-request-lifecycle.png` | BAB-03 bagian awal | Buat diagram alur horizontal dengan 4 kotak: "HTTP Request" (panah ke) "Router" (panah ke) "Controller" (panah ke) "Response". Di bawah Controller ada kotak "Model" dan "View" dengan panah ke Controller. Warna biru gradasi, gaya profesional edukasi, font sans-serif, latar putih bersih. Label panah: "mencocokkan URL", "memproses", "mengembalikan". |
| **4** | Diagram **Template Inheritance Blade** | `04-blade-inheritance.png` | BAB-04 bagian `@extends`, `@section` | Buat diagram hierarki dari atas ke bawah: Kotak utama "layouts/main.blade.php" dengan slot kosong di tengah. Di bawahnya 3 kotak anak: "home.blade.php", "about.blade.php", "contact.blade.php" dengan panah ke layout bertuliskan "@extends". Panah dari masing-masing anak ke slot layout bertuliskan "@section('content')". Warna hijau/teal, gaya clean edukasi. |
| **5** | Diagram **Migration Flow** | `05-migration-flow.png` | BAB-05 bagian Migration | Buat diagram alur vertikal: 1. "Buat file migration" (php artisan make:migration) → 2. "Definisi kolom (Schema::create)" → 3. "php artisan migrate" (panah ke database) → 4. "Tabel terbuat di MySQL". Tambah cabang dari step 3 ke "php artisan migrate:rollback" (panah ke "Tabel dihapus"). Warna oranye/biru, gaya teknis edukasi. |
| **5** | **Mapping Eloquent ke Tabel Database** | `05-eloquent-mapping.png` | BAB-05 bagian Eloquent | Buat diagram berdampingan: Kiri "Model Post" (kotak class PHP dengan properti $fillable, $casts), panah ke kanan "tabel posts" (kotak tabel MySQL dengan kolom id, title, body, created_at, updated_at). Label panah: "Eloquent ORM mapping". Tampilkan juga contoh relasi: "User hasMany Post" dengan panah ke "tabel users". Warna biru/ungu. |
| **10** | **Siklus Hidup Livewire** | `10-livewire-lifecycle.png` | BAB-10 bagian Livewire Component | Buat diagram siklus melingkar atau alur: "mount()" → "render()" → "Tampilan Blade" → "user action (wire:click)" → "action()" → "updated()" → "render()" → "Tampilan update". Beri warna berbeda untuk lifecycle hooks (hijau) vs aksi user (oranye). Gaya modern, clean. |

---

## Prioritas Sedang — Upgrade ASCII ke PNG

| BAB | Diagram ASCII Saat Ini | File | Rekomendasi | Prompt untuk AI Image Generator |
|-----|------------------------|------|-------------|-------------------------------|
| **1** | HTTP Request structure | `01-http-request.png` | **→ PNG** | Diagram anatomi HTTP Request: kotak horizontal terbagi menjadi 4 bagian — "METHOD (GET/POST)", "URL (/produk?kategori=elektronik)", "HTTP Version (HTTP/1.1)", di bawahnya "Headers (Host, User-Agent, Accept)" dan "Body (untuk POST/PUT/PATCH)". Gaya clean edukasi, warna biru/abu-abu. |
| **1** | URL structure | `01-url-structure.png` | **→ PNG** | Tampilkan URL lengkap `https://localhost:8000/produk?kategori=elektronik&page=1` dengan kotak/garis bawah per-bagian: protocol (https://), host (localhost), port (:8000), path (/produk), query string (?kategori=elektronik&page=1). Masing-masing ada label. Warna biru/ungu gradasi, gaya edukasi. |
| **1** | HTTP Response structure | `01-http-response.png` | **→ PNG** | Diagram anatomi HTTP Response: kotak horizontal — "HTTP Version (HTTP/1.1)", "Status Code (200)", "Status Text (OK)". Di bawah: "Headers (Content-Type, Set-Cookie)" dan "Body (HTML/JSON)". Warna hijau untuk 200/success, merah untuk 404/error. Gaya clean edukasi. |
| **2** | MVC Architecture | `02-mvc-architecture.png` | **→ PNG** — diagram paling penting | Diagram alur MVC: Browser (atas) → panah "HTTP Request" → Router (tengah) → bercabang ke Model (kiri, terhubung ke Database), View (kanan, menampilkan HTML), Controller (tengah, logika bisnis). Panah kembali dari Controller/View → Browser "HTTP Response". Database di paling bawah. Warna biru (Controller), hijau (Model), oranye (View). Gaya profesional, modern. |
| **2** | Laravel folder structure | `02-folder-structure.png` | **→ PNG** | Pohon direktori Laravel dengan ikon folder. Folder utama: app/ (dengan Http/Controllers/, Http/Middleware/, Models/), bootstrap/, config/, database/ (migrations/, factories/, seeders/), public/, resources/ (views/, css/, js/), routes/, storage/, tests/. Setiap folder dengan deskripsi singkat. Gaya seperti tree terminal tapi modern dengan ikon. |
| **6** | ERD Relasi Database | `06-erd-relations.png` | **→ PNG** + tambah ERD 1:1, 1:N, N:N | Buat Entity Relationship Diagram dengan 3 contoh relasi: (1) "User 1---1 Profile" — one-to-one, (2) "Category 1---* Product" — one-to-many, (3) "Post *---* Tag" via pivot table "post_tag" — many-to-many. Tampilkan kolom kunci di setiap tabel (id, foreign_key). Gaya diagram ERD standar, warna kalem. |
| **8** | Middleware flow | `08-middleware-flow.png` | **→ PNG** | Diagram alur horizontal: "Request" → "Middleware Stack" (tumpukan 3 kotak: auth, guest, custom) → "Route" → "Controller" → "Response". Dari kotak Middleware ada panah ke bawah "Gagal" → "Redirect/403". Warna biru untuk alur sukses, merah untuk gagal. Gaya clean edukasi. |
| **9** | Storage symlink path | `09-storage-symlink.png` | **→ PNG** | Diagram alur vertikal: "storage/app/public/uploads/abc123.jpg" → panah "symlink" → "public/storage/uploads/abc123.jpg" → panah "URL" → "http://localhost:8000/storage/uploads/abc123.jpg". Gunakan ikon folder/file, warna hijau untuk symlink, biru untuk URL. |

---

## Prioritas Rendah — Opsional

| BAB | Visual | File | Lokasi | Prompt untuk AI Image Generator |
|-----|--------|------|--------|-------------------------------|
| **7** | Flow validasi form | `07-validation-flow.png` | BAB-07 bagian awal | Diagram alur: "User submit form" → "Request" → "Form Request Validation" — cabang "Lolos" ke "Controller → Simpan → Flash Message Success", cabang "Gagal" ke "Redirect Back → Old Input + Error Messages → Tampilkan @error". Warna hijau untuk lolos, merah untuk gagal. |
| **4** | Struktur komponen Blade | `04-blade-components.png` | BAB-04 bagian Components | Tampilkan 3 komponen sebagai kotak terpisah: (1) Komponen "x-card" dengan slot $title, $slot, $footer, (2) Komponen "x-alert" dengan $type (info/warning/danger/success) dan $slot, (3) Cara penggunaannya di Blade: `<x-card title="Judul">... slot ...</x-card>`. Gaya clean edukasi. |

---

## Catatan

- Total visual: **17 gambar** (3 prioritas tinggi + 8 upgrade + 2 opsional + 1 sudah ada + 3 bonus)
- File gambar disimpan di folder `-/` dengan format `NN-nama.png`
- Path relatif dari masing-masing BAB ke gambar: `../-/nama-file.png`
- Prompt di atas bisa digunakan di AI image generator seperti Midjourney, DALL-E, Stable Diffusion, atau dibuat manual dengan tools diagram (draw.io, Figma, Canva)
- Untuk hasil maksimal, gunakan style konsisten: warna solid flat, font sans-serif, latar putih bersih, ikon minimalis
