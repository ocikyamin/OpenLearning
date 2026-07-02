# Roadmap — Bahan Ajar Laravel Framework

> Dokumen ini berisi rencana keseluruhan dan progres pembuatan bahan ajar.
> Terakhir diperbarui: 2 Juli 2026

---

## Status Progres

| Bagian | File | Status |
|--------|------|--------|
| Setup Environment | 9 file (Laragon + WSL + checklist) | ✅ **Selesai** |
| Pertemuan 1 — Pengantar MVC | `README.md` + `video.md` | ✅ **Selesai** |
| Pertemuan 2 — Routing & Controller | `README.md` + `video.md` | ✅ **Selesai** |
| Pertemuan 3 — Blade Templating | `README.md` + `video.md` | ✅ **Selesai** |
| Pertemuan 4 — Migration & Eloquent | `README.md` | ⬜ Belum |
| Pertemuan 5 — Relasi Database | `README.md` | ⬜ Belum |
| Pertemuan 6 — Form Validation | `README.md` | ⬜ Belum |
| Pertemuan 7 — Authentication | `README.md` | ⬜ Belum |
| Pertemuan 8 — REST API | `README.md` | ⬜ Belum |
| Referensi | 4 file (3 cheatsheet + link) | ✅ **Selesai** |
| Tugas 1 | `tugas-01.md` | ✅ **Selesai** |
| Tugas 2 | `tugas-02.md` | ✅ **Selesai** |
| Tugas 3 | `tugas-03.md` | ✅ **Selesai** |
| Tugas 4—8 | 5 file | ⬜ Belum |
| Slide presentasi | `.pdf` per pertemuan | ⬜ Belum |

---

## Struktur Folder

```
📁 Laravel Framework/
│
├── 📁 00-Persiapan/               ✅ ← 9 file (Pilih-Jalur, Laragon, WSL, checklist)
│
├── 📁 01-Pengantar-Laravel/       ✅ ← README.md, video.md
│   └── slide.pdf                  ⬜
│
├── 📁 02-Routing-Controller/      ✅ ← README.md, video.md
│   └── slide.pdf                  ⬜
│
├── 📁 03-Blade-Templating/        ✅ ← README.md, video.md
│   └── slide.pdf                  ⬜
│
├── 📁 04-Migration-Eloquent/      ⬜ ← folder siap, konten belum
│   └── slide.pdf                  ⬜
│
├── 📁 05-Relasi-Database/         ⬜ ← folder siap, konten belum
│   └── slide.pdf                  ⬜
│
├── 📁 06-Form-Validation/         ⬜ ← folder siap, konten belum
│   └── slide.pdf                  ⬜
│
├── 📁 07-Authentication/          ⬜ ← folder siap, konten belum
│   └── slide.pdf                  ⬜
│
├── 📁 08-REST-API/                ⬜ ← folder siap, konten belum
│   └── slide.pdf                  ⬜
│
├── 📁 Referensi/                  ✅ ← 4 file
│
├── 📁 Tugas/                      ← 3 selesai, 5 belum
│   ├── tugas-01.md                ✅
│   ├── tugas-02.md                ✅
│   ├── tugas-03.md                ✅
│   ├── tugas-04.md                ⬜
│   ├── tugas-05.md                ⬜
│   ├── tugas-06.md                ⬜
│   ├── tugas-07.md                ⬜
│   ├── tugas-08.md                ⬜
│   └── rubrik-penilaian.md        ⬜
│
├── ROADMAP.md                     ✅ ← file ini
└── README.md                      ✅ ← dokumentasi utama
```

---

## Rencana Konten Per Pertemuan

| # | Topik | Konten yang Harus Dibuat |
|---|-------|--------------------------|
| 4 | **Migration & Eloquent ORM** | Schema Builder, Migration file, Seeder, Factory, Eloquent Model, Query Builder, CRUD dengan database, Tinker |
| 5 | **Relasi Database** | One-to-one, One-to-many, Many-to-many, Eager loading, Pivot table |
| 6 | **Form Request & Validation** | Validasi di Controller, Form Request, Custom rule, Error messages, Flash data |
| 7 | **Authentication & Middleware** | Breeze starter kit, Login/Register, Middleware custom, Gate & Policy, Roles |
| 8 | **REST API Dasar** | API routes, Resource controller, JSON response, Sanctum token auth, Postman testing |

### Opsional (Jika Waktu Memungkinkan)

| # | Topik | Konten |
|---|-------|--------|
| 9 | File Upload & Storage | Upload file, Storage link, Validasi file, Image manipulation |
| 10 | Testing | PHPUnit, Feature test, Unit test, Database test |
| 11 | Deployment | Hosting, Environment production, Optimasi, Forge/Vapor |

---

## Yang Perlu Dilakukan Nanti

### Setiap Pertemuan Baru
1. Buat `README.md` — materi lengkap dengan teori + praktikum
2. Buat `video.md` — link video pendukung
3. Buat `slide.pdf` — file presentasi (jika ada)
4. Buat `tugas-XX.md` di folder `Tugas/`
5. Update `README.md` utama — ubah status ⬜ → ✅

### Setelah Semua Pertemuan Selesai
1. Buat `rubrik-penilaian.md` — rubrik penilaian tugas & project akhir
2. Buat panduan project akhir (`tugas-akhir.md`)
3. Review konsistensi gaya penulisan semua file
4. Upload slide PDF jika sudah dibuat

---

## Catatan

- Gaya penulisan: **santai akademik** — formal tapi tidak kaku, menggunakan "kita" dan "teman-teman"
- Semua panduan mengacu pada **Laravel 13.x** sesuai [dokumentasi resmi](https://laravel.com/docs/13.x)
- Setup environment menggunakan **Laragon** (Windows) atau **WSL + Ubuntu**
- Database disarankan **SQLite** untuk awal, lalu migrasi ke **MySQL** di pertemuan 4

---

## Progress Bar

```
▰▰▰▰▰▰▰▰▰▰▰▰▰▰▰▰▰▰▰▰▰▰▰▱▱▱▱▱▱▱▱  (42%)
```

| Item | Selesai | Total |
|------|---------|-------|
| Folder materi | 3 | 8 |
| Tugas | 3 | 8 |
| Referensi | 4 | 4 |
| Persiapan | 9 | 9 |
| **Total** | **19** | **~45** |
