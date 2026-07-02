# Product Requirements Document — Mj.Kontak

> **Project:** Mj.Kontak — Aplikasi Manajemen Kontak Berbasis Web  
> **Version:** 1.0.0  
> **Last Updated:** 2026-07-02

---

## 1. Project Overview

### 1.1 Deskripsi

Mj.Kontak adalah aplikasi *fullstack* manajemen kontak berbasis web dengan sistem autentikasi dua peran (admin/user). Aplikasi ini memungkinkan pengguna biasa untuk mengelola kontak pribadi mereka (CRUD), sementara administrator memiliki akses penuh ke seluruh data pengguna dan kontak melalui panel admin terpisah.

### 1.2 Tujuan Utama

1. Menyediakan sistem penyimpanan kontak digital yang aman dan terorganisir per pengguna.
2. Memisahkan akses data antar pengguna biasa (*user-scoped*) dengan administrator (*global access*).
3. Memberikan pengalaman UI yang berbeda: **navbar hijau** untuk pengguna biasa, **sidebar ungu** untuk admin.

### 1.3 Target Pengguna

| Peran | Kemampuan |
|---|---|
| **User** | CRUD kontak milik sendiri, kelola profil sendiri (edit/hapus akun) |
| **Admin** | CRUD seluruh user, CRUD seluruh kontak, lihat dashboard statistik |

### 1.4 Bahasa

Seluruh antarmuka, validasi backend, dan *flash messages* menggunakan **Bahasa Indonesia**.

---

## 2. Tech Stack

### 2.1 Backend — Laravel 13

| Komponen | Teknologi | Versi |
|---|---|---|
| Framework | Laravel | ^13.8 |
| PHP | PHP | ^8.3 |
| Database (dev) | MySQL | via `127.0.0.1:3306/mi2_backend` |
| Database (test) | SQLite (in-memory) | — |
| Autentikasi API | Laravel Sanctum | ^4.3 |
| Code Formatter | Laravel Pint | ^1.27 |
| Testing | PHPUnit | ^12.5 |
| Dev Tooling | Pail (log viewer), Tinker (REPL), Boost (MCP) | — |

### 2.2 Frontend — Vue 3 SPA

| Komponen | Teknologi | Versi |
|---|---|---|
| Framework | Vue | ^3.5 |
| Bahasa | TypeScript | ~6.0 |
| Bundler | Vite | ^8.0 |
| State Management | Pinia | ^3.0 |
| Router | Vue Router | ^5.1 |
| CSS | Tailwind CSS | ^4.3 |
| Icons | @heroicons/vue | ^2.2 |
| HTTP Client | Axios | ^1.18 |
| Type Checker | vue-tsc | ^3.3 |
| Build | npm-run-all2 | ^9.0 |

### 2.3 Arsitektur Monorepo

```
fullstack/
  backend/          — Laravel 13 API
    app/
      Http/
        Controllers/Api/    — 6 controller (Auth, User, Kontak, Admin*)
        Requests/           — 4 Form Request
        Resources/          — 2 API Resource (User, Kontak)
        Middleware/         — AdminMiddleware
      Models/               — User, Kontak
    database/
      migrations/           — 7 file migrasi
      factories/            — UserFactory, KontakFactory
      seeders/              — DatabaseSeeder, AdminUserSeeder
    routes/
      api.php               — 24 endpoint
    tests/                  — 2 stub test (belum coverage nyata)
  frontend/         — Vue 3 SPA
    src/
      views/                — LoginView.vue (entry auth)
      modules/
        user/               — components, views, router, stores
        admin/              — components, views, router, stores
      shared/               — api, stores, utils, components
```

---

## 3. Functional Requirements

### 3.1 Modul Autentikasi (Auth)

| ID | Fitur | Deskripsi |
|---|---|---|
| AUTH-01 | Login | User memasukkan email & password → validasi → return Bearer token + data user |
| AUTH-02 | Logout | Revoke token aktif → hapus dari localStorage → redirect ke halaman login |
| AUTH-03 | Auto-logout | Response interceptor axios otomatis logout bila mendapat 401 |
| AUTH-04 | Guard navigasi | Vue Router guard redirect ke `/login` bila tidak terautentikasi; redirect user biasa/admin sesuai peran |
| AUTH-05 | Registrasi | `POST /api/users` publik → buat user + generate token + auto-login |

### 3.2 Modul Manajemen Kontak (User Scope)

| ID | Fitur | Deskripsi |
|---|---|---|
| KONTAK-01 | Lihat daftar kontak | Tabel/pagination semua kontak milik user yang login |
| KONTAK-02 | Tambah kontak | Form `nama_kontak`, `email` (nullable), `nomor_hp` → `POST /api/kontaks` |
| KONTAK-03 | Edit kontak | Form pre-filled → `PUT /api/kontaks/{id}` (partial update) |
| KONTAK-04 | Hapus kontak | Konfirmasi dialog → `DELETE /api/kontaks/{id}` → 204 + filter array lokal |
| KONTAK-05 | Scoping data | User hanya bisa lihat/edit/hapus kontak dengan `user_id = auth()->id()` |

### 3.3 Modul Profil User

| ID | Fitur | Deskripsi |
|---|---|---|
| PROFIL-01 | Lihat profil | Card dengan nama, email, role, *member since* |
| PROFIL-02 | Edit profil | Form pre-filled (name, email, password opsional) → `PUT /api/users/{id}` |
| PROFIL-03 | Hapus akun | Konfirmasi dialog → `DELETE /api/users/{id}` → cascade hapus kontak → logout |
| PROFIL-04 | Scoping data | User hanya bisa edit/hapus data user milik sendiri (`id === auth()->id()`) |

### 3.4 Modul Admin — Dashboard

| ID | Fitur | Deskripsi |
|---|---|---|
| DASH-01 | Statistik | Card: Total Users, Total Kontaks dari `GET /api/admin/dashboard` |

### 3.5 Modul Admin — Manajemen User

| ID | Fitur | Deskripsi |
|---|---|---|
| ADM-USR-01 | Lihat semua user | Tabel pagination semua user (tanpa filter) |
| ADM-USR-02 | Tambah user | Form → `POST /api/admin/users` (tanpa generate token) |
| ADM-USR-03 | Edit user | Form pre-filled → `PUT /api/admin/users/{id}` |
| ADM-USR-04 | Hapus user | Konfirmasi dialog → `DELETE /api/admin/users/{id}` → 204 |

### 3.5 Modul Admin — Manajemen Kontak

| ID | Fitur | Deskripsi |
|---|---|---|
| ADM-KON-01 | Lihat semua kontak | Tabel pagination semua kontak (tanpa filter user) |
| ADM-KON-02 | Tambah kontak | Form termasuk `user_id` (pilih user) → `POST /api/admin/kontaks` |
| ADM-KON-03 | Edit kontak | Form pre-filled → `PUT /api/admin/kontaks/{id}` |
| ADM-KON-04 | Hapus kontak | Konfirmasi dialog → `DELETE /api/admin/kontaks/{id}` → 204 |

---

## 4. Data Schema & API Contract

### 4.1 Entity Relationship

```
User (1) ──── hasMany ────> Kontak (N)
  ├── id (PK, BIGINT UNSIGNED)
  ├── name (VARCHAR 255, NOT NULL)
  ├── email (VARCHAR 255, UNIQUE, NOT NULL)
  ├── password (VARCHAR 255, NOT NULL, hashed)
  ├── role (VARCHAR 255, DEFAULT 'user')
  └── timestamps

Kontak
  ├── id (PK, BIGINT UNSIGNED)
  ├── user_id (FK → users.id, CASCADE DELETE)
  ├── nama_kontak (VARCHAR 255, NOT NULL)
  ├── email (VARCHAR 255, NULLABLE)
  ├── nomor_hp (VARCHAR 255, NOT NULL)
  └── timestamps
```

### 4.2 Response Format Standar

| Kondisi | HTTP Status | Body |
|---|---|---|
| Success (single) | 200 / 201 | `{ data: { ... } }` |
| Success (collection) | 200 | `{ data: [...], meta: { current_page, last_page, per_page: 15, total } }` |
| Validation Error | 422 | `{ message, errors: { field: [msg] } }` |
| Unauthenticated | 401 | `{ message: "Unauthenticated." }` |
| Forbidden (bukan admin) | 403 | `{ message: "Forbidden." }` |
| Not Found | 404 | `{ message: "Not Found." }` |
| Delete success | 204 | — (No Content) |
| Server Error | 500 | `{ message: "Terjadi kesalahan server." }` |

### 4.3 Endpoint API (24 Route)

**Public (`auth:sanctum`):**

| Method | Endpoint | Controller#Method |
|---|---|---|
| POST | `/api/login` | `AuthController@login` |
| POST | `/api/users` | `UserController@store` |

**Authenticated (`auth:sanctum`):**

| Method | Endpoint | Controller#Method |
|---|---|---|
| POST | `/api/logout` | `AuthController@logout` |
| GET | `/api/user` | `AuthController@user` |
| GET | `/api/users` | `UserController@index` |
| GET | `/api/users/{user}` | `UserController@show` |
| PUT | `/api/users/{user}` | `UserController@update` |
| DELETE | `/api/users/{user}` | `UserController@destroy` |
| GET | `/api/kontaks` | `KontakController@index` |
| POST | `/api/kontaks` | `KontakController@store` |
| GET | `/api/kontaks/{kontak}` | `KontakController@show` |
| PUT | `/api/kontaks/{kontak}` | `KontakController@update` |
| DELETE | `/api/kontaks/{kontak}` | `KontakController@destroy` |

**Admin (`auth:sanctum` + `admin`):**

| Method | Endpoint | Controller#Method |
|---|---|---|
| GET | `/api/admin/dashboard` | `AdminDashboardController@__invoke` |
| GET | `/api/admin/users` | `AdminUserController@index` |
| POST | `/api/admin/users` | `AdminUserController@store` |
| GET | `/api/admin/users/{user}` | `AdminUserController@show` |
| PUT | `/api/admin/users/{user}` | `AdminUserController@update` |
| DELETE | `/api/admin/users/{user}` | `AdminUserController@destroy` |
| GET | `/api/admin/kontaks` | `AdminKontakController@index` |
| POST | `/api/admin/kontaks` | `AdminKontakController@store` |
| GET | `/api/admin/kontaks/{kontak}` | `AdminKontakController@show` |
| PUT | `/api/admin/kontaks/{kontak}` | `AdminKontakController@update` |
| DELETE | `/api/admin/kontaks/{kontak}` | `AdminKontakController@destroy` |

### 4.4 Field Naming Convention

- **Semua field** menggunakan **snake_case** di seluruh stack (backend JSON + frontend TypeScript interface).
- Tidak ada konversi camelCase.
- Contoh: `user_id`, `nama_kontak`, `nomor_hp`, `created_at`.

### 4.5 Nullable Fields

| Entity | Field | Tipe Frontend |
|---|---|---|
| Kontak | `email` | `string \| null` |

Frontend wajib handle dengan `?? '-'` di tampilan tabel dan `?? ''` di form.

---

## 5. User Interface & Experience

### 5.1 Alur Navigasi

```
[Login] ──(auth sukses)──> [Router Guard]
                             ├── role=admin  ──> [/admin/dashboard]
                             └── role=user   ──> [/users]

[Login] (sudah login) ──> redirect sesuai role
[/] (root) ──> redirect sesuai role
[/admin/*] (non-admin) ──> redirect ke [/users]
```

### 5.2 Layout Components

**AppLayout (User)**
- Fixed top navbar (height: 56px mobile, 64px desktop)
- Warna hijau sebagai aksen (border bottom, active link)
- Navigasi: Users, Kontaks
- Nama user + button Logout di kanan
- Wrapper `<slot />` untuk konten halaman

**AdminLayout (Admin)**
- Fixed left sidebar (width: 240px, putih/ungu)
- Overlay mobile + hamburger toggle (lg:hidden)
- Navigasi: Dashboard, Users, Kontaks
- Profile card (nama + "Admin") + Logout di bagian bawah sidebar
- Konten area dengan `lg:pl-60` offset untuk desktop

### 5.3 Shared Components

| Komponen | Fungsi |
|---|---|
| `FlashMessage` | Toast notification di top-right, auto-hide 4 detik, dua varian (success=green, error=red) |
| `PageHeader` | Judul halaman + tombol "Tambah" (router-link hijau) |
| `DataTable` | Tabel responsif (mobile: cards, desktop: table) + 3 state (loading skeleton, error + retry, empty) |
| `Pagination` | Navigasi halaman dengan Prev/Next, ellipsis untuk >5 halaman |
| `ConfirmDialog` | Modal konfirmasi untuk aksi hapus, dengan loading state |

### 5.4 Halaman User

| Route | Halaman | Komponen |
|---|---|---|
| `/users` | Profile Card (nama, email, role, member since) + Edit/Hapus | `UsersList.vue` |
| `/users/create` | Form registrasi (name, email, password) | `UserForm.vue` |
| `/users/:id/edit` | Form edit profil (name, email, password opsional) | `UserForm.vue` |
| `/kontaks` | Tabel daftar kontak + pagination | `KontaksList.vue` |
| `/kontaks/create` | Form tambah kontak (nama_kontak, email, nomor_hp) | `KontakForm.vue` |
| `/kontaks/:id/edit` | Form edit kontak | `KontakForm.vue` |

### 5.5 Halaman Admin

| Route | Halaman | Komponen |
|---|---|---|
| `/admin/dashboard` | Stat card: Total Users, Total Kontaks | `Dashboard.vue` |
| `/admin/users` | Tabel semua user + pagination | `Users.vue` |
| `/admin/users/create` | Form tambah user | `UserForm.vue` |
| `/admin/users/:id/edit` | Form edit user | `UserForm.vue` |
| `/admin/kontaks` | Tabel semua kontak + pagination | `Kontaks.vue` |
| `/admin/kontaks/create` | Form tambah kontak (termasuk user_id) | `KontakForm.vue` |
| `/admin/kontaks/:id/edit` | Form edit kontak | `KontakForm.vue` |

### 5.6 Warna & Tema

| Elemen | Warna | Kode |
|---|---|---|
| User navbar active | Hijau | `green-600` / `green-50` (bg) |
| Admin sidebar | Ungu | `purple-900` (bg), `purple-800` (hover/active) |
| Tombol utama | Hijau | `green-600` → `hover:green-500` |
| Tombol hapus | Merah | `red-600` → `hover:red-50` (outline) atau `bg-red-600` |
| Background | Abu-abu | `bg-gray-50` |

---

## 6. Business Logic & Constraints

### 6.1 Autentikasi & Otorisasi

| Aturan | Implementasi |
|---|---|
| Sanctum Bearer Token | Setiap request butuh header `Authorization: Bearer <token>` |
| Token expiration | `null` — token tidak pernah kadaluwarsa |
| Role check | `User::isAdmin()` → `$this->role === 'admin'` |
| Admin middleware | `AdminMiddleware` — abort 403 jika bukan admin |
| API error format | `bootstrap/app.php` → `shouldRenderJsonWhen(fn($r) => $r->is('api/*'))` |

### 6.2 Data Scoping

| Controller | Rule |
|---|---|
| `UserController` | Hanya akses user dengan `id === auth()->id()`; selain itu abort 404 |
| `KontakController` | Hanya akses kontak dengan `user_id === auth()->id()`; selain itu abort 404 |
| `AdminUserController` | Tidak ada filter — akses penuh ke semua user |
| `AdminKontakController` | Tidak ada filter — akses penuh ke semua kontak |

### 6.3 Validasi Backend

**User:**
| Field | Store | Update |
|---|---|---|
| `name` | required, string, max:255 | sometimes, string, max:255 |
| `email` | required, email, unique:users | sometimes, email, unique:users (ignore current) |
| `password` | required, string, min:8 | sometimes, string, min:8 |

**Kontak (user endpoint — via FormRequest):**
| Field | Store | Update |
|---|---|---|
| `nama_kontak` | required, string, max:255 | sometimes, string, max:255 |
| `email` | required, email, max:255 | sometimes, email, max:255 |
| `nomor_hp` | required, string, max:255 | sometimes, string, max:255 |

**Kontak (admin endpoint — via inline validation):**
| Field | Store | Update |
|---|---|---|
| `user_id` | required, exists:users,id | sometimes, exists:users,id |
| `nama_kontak` | required, string, max:255 | sometimes, string, max:255 |
| `email` | required, email, max:255 | sometimes, email, max:255 |
| `nomor_hp` | required, string, max:255 | sometimes, string, max:255 |

**Catatan:** Admin kontak endpoint menggunakan inline `$request->validate()` (bukan FormRequest), tidak konsisten dengan controller lain yang menggunakan FormRequest class.

### 6.4 Relasi & Cascade

- `Kontak.user_id` → foreign key ke `users.id` dengan **`cascadeOnDelete`**
- Menghapus user akan otomatis menghapus semua kontak miliknya

### 6.5 Response Status Code

| Operasi | Status | Catatan |
|---|---|---|
| `index` | 200 | `{ data: [...], meta: {...} }` |
| `store` | **201** | `{ data: {...} }` |
| `show` | 200 | `{ data: {...} }` |
| `update` | 200 | `{ data: {...} }` |
| `destroy` | **204** | No Content |

**Pengecualian:**
- `POST /api/login` → 200 (bukan 201), return `{ data: { token, user } }`
- `POST /api/users` (registrasi user) → 201, return `{ data: { token, user } }` (auto-login)
- `POST /api/logout` → 200, return `{ data: { message } }`
- `GET /api/admin/dashboard` → 200, return `{ total_users, total_kontaks }` (tanpa wrapper data)

### 6.6 Pagination

- Semua endpoint `index` menggunakan Laravel `LengthAwarePaginator`
- Default `per_page`: 15
- Bisa diubah via query parameter `?per_page=...`
- Respons menyertakan `meta: { current_page, last_page, per_page, total }`

### 6.7 CORS

- `allowed_origins`: `['*']` (wildcard — development)
- `allowed_methods`: `['*']`
- `allowed_headers`: `['*']`
- `supports_credentials`: `false`

---

## 7. Error Handling

### 7.1 Frontend Error Helper

Semua *catch block* di frontend menggunakan helper terpusat di `src/shared/utils/error.ts`:

| Fungsi | Deskripsi |
|---|---|
| `isNetworkError(err)` | Cek apakah error disebabkan oleh gagal koneksi (`!err.response`) |
| `isValidationError(err)` | Cek apakah error adalah HTTP 422 |
| `extractValidationErrors(err)` | Ambil `errors` object dari response 422 untuk display per-field |
| `extractErrorMessage(err, fallback)` | Ambil pesan error dari response, dengan *fallback* Bahasa Indonesia |

### 7.2 Urutan Pengecekan di Catch Block

```
1. Cek network error → tampilkan "Gagal terhubung ke server. Periksa koneksi Anda."
2. Cek validation error (422) → tampilkan per-field errors + flash message
3. Sisanya (500, 403, 404, dll) → tampilkan pesan dari server atau fallback
```

### 7.3 Network Error

- **Deteksi:** `!err.response`
- **Aksi:** Flash message error "Gagal terhubung ke server. Periksa koneksi Anda."
- Tidak ada retry otomatis — user bisa klik "Coba Lagi" pada DataTable error state.

### 7.4 Validation Error (422)

- **Deteksi:** `err.response?.status === 422`
- **Aksi:** Field errors ditampilkan di bawah masing-masing input (`errors.field[0]`), flash message error "Data tidak valid."
- Backend mengirim validation error dalam Bahasa Indonesia (contoh: `"Email sudah digunakan."`).

### 7.5 Unauthenticated (401)

- **Deteksi:** Axios response interceptor di `src/shared/api/axios.ts`
- **Aksi:** Panggil `auth.logout()` → hapus token dari localStorage + redirect ke `/login`
- Tidak ada retry — user harus login ulang.

### 7.6 Forbidden (403)

- **Deteksi:** `err.response?.status === 403`
- **Aksi:** Flash message error dari server (default: "Terjadi kesalahan server.")
- Biasanya terjadi saat user non-admin mengakses `/admin/*` routes — dicegah juga oleh router guard.

### 7.7 NotFound (404)

- **Deteksi:** `err.response?.status === 404`
- **Aksi:** Flash message error dari server.
- Tidak ada fallback routing — user bisa navigasi manual kembali ke index.

### 7.8 Delete Success — Local State Sync

Setelah sukses menghapus item, frontend **tidak refetch dari API**, melainkan memfilter array lokal:

```
items = items.filter(item => item.id !== deletedId)
meta.total--
```

Ini menghindarkan request tambahan dan membuat UI langsung update.

---

## 8. Security Considerations

| Aspek | Implementasi |
|---|---|
| Token storage | `localStorage` (SPA convention) |
| Password hashing | Laravel `Hash::make()` via model `casts: ['password' => 'hashed']` |
| SQL Injection | Eloquent ORM + parameter binding |
| XSS | Vue.js template auto-escaping |
| CSRF | Sanctum token-based (stateless), CSRF tidak relevan untuk API |
| Data leakage | `UserResource` mengekspos `id, name, email, role, created_at` — tidak ekspos password/remember_token |
| Owner scoping | `if ($user->id !== auth()->id()) abort(404)` — user tidak bisa akses data orang lain |

---

## 9. Known Issues & Technical Debt

| Issue | Dampak | Prioritas |
|---|---|---|
| Admin kontak endpoint pakai inline `$request->validate()` bukan FormRequest | Inkonsistensi kode | Low |
| Hanya 2 stub test, tidak ada coverage untuk kontak CRUD, admin endpoints | Tidak ada regression safety | High |
| `LoginView.vue` tetap di `src/views/` (bukan shared/module) | Inkonsistensi struktur folder | Low |
| `admin.kontak.edit` dan `admin.users.edit` link di sidebar menuju index (belum ada navigasi detail) | UX kurang optimal | Low |
| User `index` endpoint mengembalikan hanya 1 record (filter by `auth()->id()`) — endpoint mubazir | Bisa hapus atau ganti dengan `GET /user` | Low |
