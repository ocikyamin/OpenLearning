# Roadmap — Bahan Ajar Laravel Framework

> Dokumen ini berisi rencana keseluruhan dan progres pembuatan bahan ajar.
> Terakhir diperbarui: 14 Juli 2026

---

## Status Progres

| Bagian | File | Status |
|--------|------|--------|
| Setup Environment | 9 file (Laragon + WSL + checklist) | ✅ **Selesai** |
| BAB 1 — HTTP Dasar | `README.md` + `video.md` | ✅ **Selesai** |
| BAB 2 — Pengantar Laravel & MVC | `README.md` + `video.md` | ✅ **Selesai** |
| BAB 3 — Routing & Controller | `README.md` + `video.md` | ✅ **Selesai** |
| BAB 4 — Blade Templating | `README.md` + `video.md` | ✅ **Selesai** |
| BAB 5 — Migration & Eloquent | `README.md` + `video.md` | ✅ **Selesai** |
| BAB 6 — Relasi Database | `README.md` + `video.md` | ✅ **Selesai** |
| BAB 7 — Form Validation | `README.md` + `video.md` | ✅ **Selesai** |
| BAB 8 — Authentication | `README.md` + `video.md` | ✅ **Selesai** |
| BAB 9 — Upload File & Storage | `README.md` + `video.md` | ✅ **Selesai** |
| BAB 10 — Livewire | `README.md` + `video.md` | ✅ **Selesai** |
| Referensi | 4 file (3 cheatsheet + link) | ✅ **Selesai** |
| Tugas | 3 file baru + 7 rename | ✅ Selesai |
| Slide presentasi | `.pdf` per BAB | ⬜ Belum |

---

## Struktur Folder

```
📁 Laravel Framework/
│
├── 📁 00-Persiapan/                         ✅ ← 9 file
├── 📁 BAB-01-HTTP-Dasar/                    ✅ ← README.md, video.md
├── 📁 BAB-02-Pengantar-Laravel-dan-MVC/     ✅ ← README.md, video.md
├── 📁 BAB-03-Routing-dan-Controller/        ✅ ← README.md, video.md
├── 📁 BAB-04-Blade-Templating/              ✅ ← README.md, video.md
├── 📁 BAB-05-Migration-dan-Eloquent-ORM/    ✅ ← README.md, video.md
├── 📁 BAB-06-Relasi-Database/               ✅ ← README.md, video.md
├── 📁 BAB-07-Form-Request-dan-Validation/   ✅ ← README.md, video.md
├── 📁 BAB-08-Authentication-dan-Middleware/  ✅ ← README.md, video.md
├── 📁 BAB-09-Upload-File-dan-Storage/       ✅ ← README.md, video.md
├── 📁 BAB-10-Livewire/                      ✅ ← README.md, video.md
├── 📁 Referensi/                            ✅ ← 4 file
├── 📁 Tugas/                                ✅ ← 10 file tugas
├── ROADMAP.md                               ✅ ← file ini
├── PLAN-EKSEKUSI.md                         ✅ ← catatan progres
└── README.md                                ✅ ← dokumentasi utama
```

---

## Rencana Konten Per BAB

| # | Topik | Konten |
|---|-------|--------|
| 1 | **HTTP Dasar & Postman** | Client-server, HTTP methods, Status code, Header, Postman/Thunder Client, Query parameter, Request body |
| 2 | **Pengantar Laravel & MVC** | Instalasi Laravel, Struktur folder, Konsep MVC, Routing dasar, View, Artisan CLI, Environment file |
| 3 | **Routing & Controller** | Route methods, Route parameters, Named routes, Route group, Controller, Resource controller, Request & Response |
| 4 | **Blade Templating** | Syntax Blade, Layout & template inheritance, Components, Form & CSRF, Loop, Conditional, Error handling |
| 5 | **Migration & Eloquent ORM** | Schema Builder, Migration file, Seeder, Factory, Eloquent Model, Query Builder, CRUD, Tinker, search scope |
| 6 | **Relasi Database** | One-to-one, One-to-many, Many-to-many, Eager loading, Pivot table, withCount, whereBelongsTo |
| 7 | **Form Request & Validation** | Validasi di Controller, Form Request, Custom rule, Error messages, Flash data |
| 8 | **Authentication & Middleware** | Breeze starter kit, Login/Register, Middleware custom, Gate & Policy, Roles, Dashboard statis |
| 9 | **Upload File & Storage** | Storage link, Upload file, Validasi file, Image manipulation, Download & Hapus |
| 10 | **Livewire** | Component, Action, Data binding, Form, Tabel search realtime, Pagination |

---

## Yang Perlu Dilakukan Nanti

1. Buat `rubrik-penilaian.md` — rubrik penilaian tugas & project akhir
2. Buat panduan project akhir (`tugas-akhir.md`)
3. Review konsistensi gaya penulisan semua file
4. Upload slide PDF jika sudah dibuat

---

## Catatan

- Gaya penulisan: **santai akademik** — formal tapi tidak kaku, menggunakan "kita" dan "teman-teman"
- Penjelasan bersifat **naratif seperti buku/modul ajar**, bukan hanya poin-poin teknis
- Semua panduan mengacu pada **Laravel 13.x** sesuai [dokumentasi resmi](https://laravel.com/docs/13.x)
- Setup environment menggunakan **Laragon** (Windows) atau **WSL + Ubuntu**
- Database menggunakan **MySQL** langsung sejak awal
- Setiap praktikum dimulai dari langkah paling awal (buat project, setup database, dll.)

---

## Progress Bar

```
▰▰▰▰▰▰▰▰▰▰▰▰▰▰▰▰▰▰▰▰▰▰▰▰▰▰▰▰▰▰▱▱▱▱  (70%)
```

| Item | Selesai | Total |
|------|---------|-------|
| Folder materi | 10 | 10 |
| Tugas | 10 | 10 |
| Referensi | 4 | 4 |
| Persiapan | 9 | 9 |
| **Total** | **33** | **~47** |
