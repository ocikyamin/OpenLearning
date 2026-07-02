# REST API Specification — Mj.Kontak

> **Project:** Mj.Kontak — Aplikasi Manajemen Kontak  
> **Base URL:** `http://localhost:8000/api`  
> **Auth:** Laravel Sanctum Bearer Token  
> **Version:** 1.0.0

Dokumen ini adalah panduan teknis REST API untuk mahasiswa dan AI Coding. Setiap endpoint mencakup request, response, validasi, dan contoh error.

---

## Daftar Isi

1. [API Overview](#1-api-overview)
2. [Autentikasi (Auth)](#2-autentikasi-auth)
3. [Manajemen User (Scope User)](#3-manajemen-user-scope-user)
4. [Manajemen Kontak (Scope User)](#4-manajemen-kontak-scope-user)
5. [Admin — Dashboard](#5-admin--dashboard)
6. [Admin — Manajemen User](#6-admin--manajemen-user)
7. [Admin — Manajemen Kontak](#7-admin--manajemen-kontak)
8. [Data Dictionary](#8-data-dictionary)
9. [Validation Rules Summary](#9-validation-rules-summary)

---

## 1. API Overview

### 1.1 Base URL

```
http://localhost:8000/api
```

### 1.2 Authentication

| Aspek | Detail |
|---|---|
| **Mekanisme** | Laravel Sanctum — Bearer Token |
| **Header** | `Authorization: Bearer <token>` |
| **Public endpoints** | `POST /api/login`, `POST /api/users` |
| **Protected endpoints** | Semua endpoint lain (middleware `auth:sanctum`) |
| **Admin endpoints** | Semua `/api/admin/*` (middleware `auth:sanctum` + `admin`) |

### 1.3 Response Envelope

**Single resource (200, 201):**
```json
{
  "data": { ... }
}
```

**Collection with pagination (200):**
```json
{
  "data": [ ... ],
  "meta": {
    "current_page": 1,
    "last_page": 3,
    "per_page": 15,
    "total": 42
  }
}
```

**Delete success (204):**
- Tidak ada response body

**Error — Validation (422):**
```json
{
  "message": "Data tidak valid.",
  "errors": {
    "email": ["Email sudah digunakan."]
  }
}
```

**Error — Unauthenticated (401):**
```json
{
  "message": "Unauthenticated."
}
```

**Error — Forbidden (403):**
```json
{
  "message": "Forbidden."
}
```

**Error — Not Found (404):**
```json
{
  "message": "Not Found."
}
```

### 1.4 Naming Convention

- Semua field menggunakan **snake_case** (Laravel default)
- Frontend tidak boleh konversi ke camelCase
- Contoh: `user_id`, `nama_kontak`, `nomor_hp`, `created_at`

### 1.5 Pagination

| Parameter | Default | Deskripsi |
|---|---|---|
| `page` | 1 | Halaman yang diminta |
| `per_page` | 15 | Jumlah item per halaman |

Response disertai `meta`:
```json
{
  "meta": {
    "current_page": 1,
    "last_page": 5,
    "per_page": 15,
    "total": 72
  }
}
```

### 1.6 Status Codes per Operation

| Operation | Method | Status | Response Body |
|---|---|---|---|
| `index` (daftar) | GET | 200 | `{ data: [...], meta: {...} }` |
| `store` (buat) | POST | **201** | `{ data: {...} }` |
| `show` (detail) | GET | 200 | `{ data: {...} }` |
| `update` (ubah) | PUT | 200 | `{ data: {...} }` |
| `destroy` (hapus) | DELETE | **204** | — (no content) |

**Pengecualian:**
| Endpoint | Status | Catatan |
|---|---|---|
| `POST /api/login` | 200 | Bukan 201 |
| `POST /api/users` (registrasi) | 201 | Return token |
| `POST /api/logout` | 200 | Return message |
| `GET /api/user` | 200 | Return current user |
| `GET /api/admin/dashboard` | 200 | Response tanpa `data` wrapper |

### 1.7 Middleware Stack

```
Request ──> CORS ──> api/* ──> auth:sanctum ──> admin (hanya /admin/*)
                    │                │
            Semua endpoint    Protected endpoint
            public: login,     
            users (store)
```

- CORS: semua origin/method/header diizinkan (`config/cors.php`)
- API errors otomatis JSON karena `bootstrap/app.php`: `shouldRenderJsonWhen(fn($r) => $r->is('api/*'))`

---

## 2. Autentikasi (Auth)

### 2.1 Login

> Membuat sesi baru. Mengembalikan token Bearer + data user.

**Endpoint:** `POST /api/login`  
**Middleware:** — (public)  
**Rate Limit:** Tidak ada

#### Request Body
```json
{
  "email": "admin@example.com",
  "password": "password"
}
```

#### Validation Rules
| Field | Rules |
|---|---|
| `email` | required, email |
| `password` | required, string |

#### Success Response (200)
```json
{
  "data": {
    "token": "1|abc123def456...",
    "user": {
      "id": 1,
      "name": "Admin",
      "email": "admin@example.com",
      "role": "admin",
      "created_at": "2026-07-02T00:00:00.000000Z"
    }
  }
}
```

#### Error Response (422) — Kredensial Salah
```json
{
  "message": "Email atau password salah.",
  "errors": {
    "email": ["Email atau password salah."]
  }
}
```

#### Error Response (422) — Validasi Gagal
```json
{
  "message": "Email atau password salah.",
  "errors": {
    "email": ["Email atau password salah."]
  }
}
```

---

### 2.2 Logout

> Menghapus token Bearer yang sedang aktif.

**Endpoint:** `POST /api/logout`  
**Middleware:** `auth:sanctum`  
**Header:** `Authorization: Bearer <token>`

#### Request Body
Tidak ada.

#### Success Response (200)
```json
{
  "data": {
    "message": "Berhasil logout."
  }
}
```

#### Error Response (401)
```json
{
  "message": "Unauthenticated."
}
```

---

### 2.3 Get Current User

> Mengambil data user yang sedang terautentikasi.

**Endpoint:** `GET /api/user`  
**Middleware:** `auth:sanctum`

#### Request Body
Tidak ada.

#### Success Response (200)
```json
{
  "data": {
    "id": 1,
    "name": "Admin",
    "email": "admin@example.com",
    "role": "admin",
    "created_at": "2026-07-02T00:00:00.000000Z"
  }
}
```

#### Error Response (401)
```json
{
  "message": "Unauthenticated."
}
```

---

## 3. Manajemen User (Scope User)

Semua endpoint di seksi ini terbatas hanya untuk user yang sedang login. Jika user mencoba mengakses data user lain, backend akan mengembalikan **404 Not Found** (bukan 403).

### 3.1 Register User Baru

> Mendaftarkan user baru. Otomatis generate token + auto-login.

**Endpoint:** `POST /api/users`  
**Middleware:** — (public)

#### Request Body
```json
{
  "name": "Budi Santoso",
  "email": "budi@example.com",
  "password": "rahasia123"
}
```

#### Validation Rules
| Field | Rules |
|---|---|
| `name` | required, string, max:255 |
| `email` | required, email, unique:users,email |
| `password` | required, string, min:8 |

#### Success Response (201)
```json
{
  "data": {
    "token": "2|xyz789abc...",
    "user": {
      "id": 11,
      "name": "Budi Santoso",
      "email": "budi@example.com",
      "role": "user",
      "created_at": "2026-07-02T12:00:00.000000Z"
    }
  }
}
```

#### Error Response (422) — Validasi
```json
{
  "message": "Data tidak valid.",
  "errors": {
    "email": ["Email sudah digunakan."],
    "password": ["Password minimal 8 karakter."]
  }
}
```

---

### 3.2 List User (Diri Sendiri)

> Mengembalikan data user yang sedang login (hanya 1 record).

**Endpoint:** `GET /api/users`  
**Middleware:** `auth:sanctum`

#### Request Body
Tidak ada.

#### Success Response (200)
```json
{
  "data": [
    {
      "id": 11,
      "name": "Budi Santoso",
      "email": "budi@example.com",
      "role": "user",
      "created_at": "2026-07-02T12:00:00.000000Z"
    }
  ],
  "meta": {
    "current_page": 1,
    "last_page": 1,
    "per_page": 15,
    "total": 1
  }
}
```

> **Catatan:** Endpoint ini menggunakan `where('id', auth()->id())` sehingga hanya mengembalikan 1 record meskipun ada banyak user di database.

---

### 3.3 Detail User

> Menampilkan detail user tertentu. Hanya user sendiri yang bisa diakses.

**Endpoint:** `GET /api/users/{id}`  
**Middleware:** `auth:sanctum`

#### Request Body
Tidak ada.

#### Success Response (200)
```json
{
  "data": {
    "id": 11,
    "name": "Budi Santoso",
    "email": "budi@example.com",
    "role": "user",
    "created_at": "2026-07-02T12:00:00.000000Z"
  }
}
```

#### Error Response (404) — User Lain
```json
{
  "message": "Not Found."
}
```

> **Logika ownership:** `if ($user->id !== auth()->id()) abort(404)`

---

### 3.4 Update User

> Memperbarui data profil user sendiri. Semua field opsional (partial update).

**Endpoint:** `PUT /api/users/{id}`  
**Middleware:** `auth:sanctum`

#### Request Body
```json
{
  "name": "Budi Santoso Update",
  "email": "budi_baru@example.com",
  "password": "passwordbaru123"
}
```

Semua field bersifat opsional. Contoh hanya kirim 1 field:
```json
{
  "name": "Budi Santoso Update"
}
```

#### Validation Rules
| Field | Rules |
|---|---|
| `name` | sometimes, string, max:255 |
| `email` | sometimes, email, unique:users,email (ignore current user) |
| `password` | sometimes, string, min:8 |

#### Success Response (200)
```json
{
  "data": {
    "id": 11,
    "name": "Budi Santoso Update",
    "email": "budi_baru@example.com",
    "role": "user",
    "created_at": "2026-07-02T12:00:00.000000Z"
  }
}
```

#### Error Response (422)
```json
{
  "message": "Data tidak valid.",
  "errors": {
    "email": ["Email sudah digunakan."]
  }
}
```

#### Error Response (404) — Bukan Data Sendiri
```json
{
  "message": "Not Found."
}
```

---

### 3.5 Hapus User

> Menghapus akun user sendiri. Semua kontak milik user akan ikut terhapus (cascade).

**Endpoint:** `DELETE /api/users/{id}`  
**Middleware:** `auth:sanctum`

#### Request Body
Tidak ada.

#### Success Response (204)
Tidak ada response body.

#### Error Response (404) — Bukan Data Sendiri
```json
{
  "message": "Not Found."
}
```

> **Catatan:** Karena `cascadeOnDelete` pada foreign key `kontaks.user_id`, semua kontak user akan otomatis terhapus.

---

## 4. Manajemen Kontak (Scope User)

Semua endpoint di seksi ini terbatas hanya untuk kontak milik user yang login (`user_id === auth()->id()`).

### 4.1 List Kontak

> Mengembalikan daftar kontak milik user yang login, dengan pagination.

**Endpoint:** `GET /api/kontaks`  
**Middleware:** `auth:sanctum`

#### Request Query Parameters
| Parameter | Tipe | Default | Deskripsi |
|---|---|---|---|
| `page` | integer | 1 | Halaman |
| `per_page` | integer | 15 | Item per halaman |

#### Request Body
Tidak ada.

#### Success Response (200)
```json
{
  "data": [
    {
      "id": 1,
      "user_id": 11,
      "nama_kontak": "Siti Aisyah",
      "email": "siti@example.com",
      "nomor_hp": "08123456789",
      "created_at": "2026-07-02T12:30:00.000000Z"
    },
    {
      "id": 2,
      "user_id": 11,
      "nama_kontak": "Ahmad Rizki",
      "email": null,
      "nomor_hp": "087654321",
      "created_at": "2026-07-02T12:35:00.000000Z"
    }
  ],
  "meta": {
    "current_page": 1,
    "last_page": 1,
    "per_page": 15,
    "total": 2
  }
}
```

> **Catatan:** `email` bisa bernilai `null`. Frontend wajib handle dengan `?? '-'` atau `?? ''`.

---

### 4.2 Tambah Kontak

> Menambahkan kontak baru. `user_id` otomatis diisi dari user yang sedang login.

**Endpoint:** `POST /api/kontaks`  
**Middleware:** `auth:sanctum`

#### Request Body
```json
{
  "nama_kontak": "Siti Aisyah",
  "email": "siti@example.com",
  "nomor_hp": "08123456789"
}
```

#### Validation Rules
| Field | Rules |
|---|---|
| `nama_kontak` | required, string, max:255 |
| `email` | required, email, max:255 |
| `nomor_hp` | required, string, max:255 |

#### Success Response (201)
```json
{
  "data": {
    "id": 3,
    "user_id": 11,
    "nama_kontak": "Siti Aisyah",
    "email": "siti@example.com",
    "nomor_hp": "08123456789",
    "created_at": "2026-07-02T13:00:00.000000Z"
  }
}
```

#### Error Response (422)
```json
{
  "message": "Data tidak valid.",
  "errors": {
    "email": ["Email tidak valid."],
    "nomor_hp": ["Nomor HP wajib diisi."]
  }
}
```

> **Catatan:** `user_id` tidak perlu dikirim. Backend akan mengisi dari `auth()->id()`.

---

### 4.3 Detail Kontak

> Menampilkan detail kontak. Hanya kontak milik sendiri yang bisa diakses.

**Endpoint:** `GET /api/kontaks/{id}`  
**Middleware:** `auth:sanctum`

#### Request Body
Tidak ada.

#### Success Response (200)
```json
{
  "data": {
    "id": 3,
    "user_id": 11,
    "nama_kontak": "Siti Aisyah",
    "email": "siti@example.com",
    "nomor_hp": "08123456789",
    "created_at": "2026-07-02T13:00:00.000000Z"
  }
}
```

#### Error Response (404) — Bukan Milik Sendiri
```json
{
  "message": "Not Found."
}
```

> **Logika ownership:** `if ($kontak->user_id !== auth()->id()) abort(404)`

---

### 4.4 Update Kontak

> Memperbarui data kontak. Semua field opsional.

**Endpoint:** `PUT /api/kontaks/{id}`  
**Middleware:** `auth:sanctum`

#### Request Body
```json
{
  "nama_kontak": "Siti Aisyah Update",
  "nomor_hp": "08999999999"
}
```

#### Validation Rules
| Field | Rules |
|---|---|
| `nama_kontak` | sometimes, string, max:255 |
| `email` | sometimes, email, max:255 |
| `nomor_hp` | sometimes, string, max:255 |

#### Success Response (200)
```json
{
  "data": {
    "id": 3,
    "user_id": 11,
    "nama_kontak": "Siti Aisyah Update",
    "email": "siti@example.com",
    "nomor_hp": "08999999999",
    "created_at": "2026-07-02T13:00:00.000000Z"
  }
}
```

#### Error Response (404) — Bukan Milik Sendiri
```json
{
  "message": "Not Found."
}
```

---

### 4.5 Hapus Kontak

> Menghapus kontak.

**Endpoint:** `DELETE /api/kontaks/{id}`  
**Middleware:** `auth:sanctum`

#### Request Body
Tidak ada.

#### Success Response (204)
Tidak ada response body.

#### Error Response (404) — Bukan Milik Sendiri
```json
{
  "message": "Not Found."
}
```

---

## 5. Admin — Dashboard

### 5.1 Statistik Dashboard

> Mengembalikan jumlah total user dan kontak di seluruh sistem.

**Endpoint:** `GET /api/admin/dashboard`  
**Middleware:** `auth:sanctum`, `admin`  
**Header:** `Authorization: Bearer <token>`

#### Request Body
Tidak ada.

#### Success Response (200)
```json
{
  "total_users": 11,
  "total_kontaks": 20
}
```

> **Catatan:** Endpoint ini tidak menggunakan wrapper `data`. Ini satu-satunya response yang tidak konsisten dengan endpoint lain.

#### Error Response (403) — Bukan Admin
```json
{
  "message": "Forbidden."
}
```

---

## 6. Admin — Manajemen User

Semua endpoint admin user memiliki akses penuh ke semua user (tanpa filter ownership).

### 6.1 List Semua User

**Endpoint:** `GET /api/admin/users`  
**Middleware:** `auth:sanctum`, `admin`

#### Request Body
Tidak ada.

#### Success Response (200)
```json
{
  "data": [
    {
      "id": 1,
      "name": "Admin",
      "email": "admin@example.com",
      "role": "admin",
      "created_at": "2026-07-02T00:00:00.000000Z"
    },
    {
      "id": 2,
      "name": "User Satu",
      "email": "user1@example.com",
      "role": "user",
      "created_at": "2026-07-02T01:00:00.000000Z"
    }
  ],
  "meta": {
    "current_page": 1,
    "last_page": 1,
    "per_page": 15,
    "total": 11
  }
}
```

---

### 6.2 Tambah User (Admin)

> Admin membuat user baru. Berbeda dengan registrasi user biasa, endpoint ini **tidak** menghasilkan token.

**Endpoint:** `POST /api/admin/users`  
**Middleware:** `auth:sanctum`, `admin`

#### Request Body
```json
{
  "name": "User Baru",
  "email": "userbaru@example.com",
  "password": "password123"
}
```

#### Validation Rules
Sama dengan `StoreUserRequest`: name (required, string, max:255), email (required, email, unique:users), password (required, string, min:8).

#### Success Response (201)
```json
{
  "data": {
    "id": 12,
    "name": "User Baru",
    "email": "userbaru@example.com",
    "role": "user",
    "created_at": "2026-07-02T14:00:00.000000Z"
  }
}
```

> **Perbedaan dengan `POST /api/users` (registrasi publik):** Endpoint ini hanya return `{ data: user }` tanpa `token`.

---

### 6.3 Detail User (Admin)

**Endpoint:** `GET /api/admin/users/{id}`  
**Middleware:** `auth:sanctum`, `admin`

#### Success Response (200)
```json
{
  "data": {
    "id": 2,
    "name": "User Satu",
    "email": "user1@example.com",
    "role": "user",
    "created_at": "2026-07-02T01:00:00.000000Z"
  }
}
```

> **Catatan:** Admin endpoint tidak memiliki ownership check — bisa akses user manapun.

---

### 6.4 Update User (Admin)

**Endpoint:** `PUT /api/admin/users/{id}`  
**Middleware:** `auth:sanctum`, `admin`

#### Request Body
```json
{
  "name": "User Satu Update",
  "role": "admin"
}
```

#### Validation Rules
Sama dengan `UpdateUserRequest`: name (sometimes, string, max:255), email (sometimes, email, unique:users ignore current), password (sometimes, string, min:8).

#### Success Response (200)
```json
{
  "data": {
    "id": 2,
    "name": "User Satu Update",
    "email": "user1@example.com",
    "role": "admin",
    "created_at": "2026-07-02T01:00:00.000000Z"
  }
}
```

---

### 6.5 Hapus User (Admin)

**Endpoint:** `DELETE /api/admin/users/{id}`  
**Middleware:** `auth:sanctum`, `admin`

#### Success Response (204)
Tidak ada response body.

> **Catatan:** Kontak milik user yang dihapus akan ikut terhapus (cascade).

---

## 7. Admin — Manajemen Kontak

Semua endpoint admin kontak memiliki akses penuh ke semua kontak.

### 7.1 List Semua Kontak

**Endpoint:** `GET /api/admin/kontaks`  
**Middleware:** `auth:sanctum`, `admin`

#### Success Response (200)
```json
{
  "data": [
    {
      "id": 1,
      "user_id": 2,
      "nama_kontak": "Siti Aisyah",
      "email": "siti@example.com",
      "nomor_hp": "08123456789",
      "created_at": "2026-07-02T12:30:00.000000Z"
    },
    {
      "id": 2,
      "user_id": 3,
      "nama_kontak": "Ahmad Rizki",
      "email": null,
      "nomor_hp": "087654321",
      "created_at": "2026-07-02T12:35:00.000000Z"
    }
  ],
  "meta": {
    "current_page": 1,
    "last_page": 2,
    "per_page": 15,
    "total": 20
  }
}
```

---

### 7.2 Tambah Kontak (Admin)

> Admin dapat membuat kontak untuk **user manapun** dengan menentukan `user_id`.

**Endpoint:** `POST /api/admin/kontaks`  
**Middleware:** `auth:sanctum`, `admin`

#### Request Body
```json
{
  "user_id": 2,
  "nama_kontak": "Kontak Baru",
  "email": "kontakbaru@example.com",
  "nomor_hp": "08111111111"
}
```

#### Validation Rules (inline — bukan FormRequest)
| Field | Rules |
|---|---|
| `user_id` | required, exists:users,id |
| `nama_kontak` | required, string, max:255 |
| `email` | required, email, max:255 |
| `nomor_hp` | required, string, max:255 |

#### Success Response (201)
```json
{
  "data": {
    "id": 21,
    "user_id": 2,
    "nama_kontak": "Kontak Baru",
    "email": "kontakbaru@example.com",
    "nomor_hp": "08111111111",
    "created_at": "2026-07-02T15:00:00.000000Z"
  }
}
```

> **Perbedaan dengan `POST /api/kontaks` (user scope):** Admin wajib mengirim `user_id`. User scope tidak menerima `user_id` (otomatis dari auth).

---

### 7.3 Detail Kontak (Admin)

**Endpoint:** `GET /api/admin/kontaks/{id}`  
**Middleware:** `auth:sanctum`, `admin`

#### Success Response (200)
```json
{
  "data": {
    "id": 1,
    "user_id": 2,
    "nama_kontak": "Siti Aisyah",
    "email": "siti@example.com",
    "nomor_hp": "08123456789",
    "created_at": "2026-07-02T12:30:00.000000Z"
  }
}
```

---

### 7.4 Update Kontak (Admin)

**Endpoint:** `PUT /api/admin/kontaks/{id}`  
**Middleware:** `auth:sanctum`, `admin`

#### Request Body
```json
{
  "nama_kontak": "Siti Aisyah Update"
}
```

#### Validation Rules (inline)
| Field | Rules |
|---|---|
| `user_id` | sometimes, exists:users,id |
| `nama_kontak` | sometimes, string, max:255 |
| `email` | sometimes, email, max:255 |
| `nomor_hp` | sometimes, string, max:255 |

#### Success Response (200)
```json
{
  "data": {
    "id": 1,
    "user_id": 2,
    "nama_kontak": "Siti Aisyah Update",
    "email": "siti@example.com",
    "nomor_hp": "08123456789",
    "created_at": "2026-07-02T12:30:00.000000Z"
  }
}
```

---

### 7.5 Hapus Kontak (Admin)

**Endpoint:** `DELETE /api/admin/kontaks/{id}`  
**Middleware:** `auth:sanctum`, `admin`

#### Success Response (204)
Tidak ada response body.

---

## 8. Data Dictionary

### 8.1 Tabel `users`

| Field | Type | Nullable | Default | Constraints | Keterangan |
|---|---|---|---|---|---|
| `id` | bigint unsigned | No | — | PK, auto increment | |
| `name` | varchar(255) | No | — | | Nama lengkap user |
| `email` | varchar(255) | No | — | **UNIQUE** | Alamat email, digunakan untuk login |
| `email_verified_at` | timestamp | Yes | null | | Tidak digunakan di aplikasi ini |
| `password` | varchar(255) | No | — | Hashed (bcrypt) | Disimpan terenkripsi, tidak pernah diekspos |
| `role` | varchar(255) | No | `'user'` | | Nilai: `'user'` atau `'admin'` |
| `remember_token` | varchar(100) | Yes | null | | Token remember me (tidak dipakai SPA) |
| `created_at` | timestamp | Yes | null | | Waktu pembuatan |
| `updated_at` | timestamp | Yes | null | | Waktu update terakhir |

**Relasi:** `User hasMany Kontak` (satu user punya banyak kontak)

**Contoh data:**
```json
{
  "id": 1,
  "name": "Admin",
  "email": "admin@example.com",
  "role": "admin",
  "created_at": "2026-07-02T00:00:00.000000Z"
}
```

---

### 8.2 Tabel `kontaks`

| Field | Type | Nullable | Default | Constraints | Keterangan |
|---|---|---|---|---|---|
| `id` | bigint unsigned | No | — | PK, auto increment | |
| `user_id` | bigint unsigned | No | — | **FK → users.id, ON DELETE CASCADE** | Pemilik kontak |
| `nama_kontak` | varchar(255) | No | — | | Nama kontak/kenalan |
| `email` | varchar(255) | **Yes** | null | | Email kontak (boleh kosong/tidak diketahui) |
| `nomor_hp` | varchar(255) | No | — | | Nomor handphone. Tidak ada validasi format spesifik |
| `created_at` | timestamp | Yes | null | | Waktu pembuatan |
| `updated_at` | timestamp | Yes | null | | Waktu update terakhir |

**Relasi:** `Kontak belongsTo User` (setiap kontak dimiliki oleh satu user)

**Contoh data:**
```json
{
  "id": 1,
  "user_id": 11,
  "nama_kontak": "Siti Aisyah",
  "email": "siti@example.com",
  "nomor_hp": "08123456789",
  "created_at": "2026-07-02T12:30:00.000000Z"
}
```

**Contoh data (email null):**
```json
{
  "id": 2,
  "user_id": 11,
  "nama_kontak": "Ahmad Rizki",
  "email": null,
  "nomor_hp": "087654321",
  "created_at": "2026-07-02T12:35:00.000000Z"
}
```

---

### 8.3 Tabel `personal_access_tokens`

| Field | Type | Nullable | Default | Constraints | Keterangan |
|---|---|---|---|---|---|
| `id` | bigint unsigned | No | — | PK, auto increment | |
| `tokenable_type` | varchar(255) | No | — | | Polymorphic: `App\Models\User` |
| `tokenable_id` | bigint unsigned | No | — | FK ke user | ID user pemilik token |
| `name` | varchar(255) | No | — | | Nama token (biasanya `'api-token'`) |
| `token` | varchar(64) | No | — | **UNIQUE** | SHA-256 hash dari token asli |
| `abilities` | text | Yes | null | | JSON array of abilities |
| `last_used_at` | timestamp | Yes | null | | Waktu terakhir token dipakai |
| `expires_at` | timestamp | Yes | null | | Waktu kedaluwarsa (null = tidak pernah) |
| `created_at` | timestamp | Yes | null | | |
| `updated_at` | timestamp | Yes | null | | |

**Catatan:** Token asli (plain text) hanya diberikan sekali saat login/registrasi dan tidak bisa diambil lagi. Jika hilang, user harus login ulang.

---

### 8.4 Business Rules per Field

| Entity | Field | Business Rule |
|---|---|---|
| User | `role` | Default `'user'`. Hanya admin yang bisa mengubah role (via `PUT /api/admin/users/{id}`). |
| User | `email` | Harus unik di seluruh sistem. Tidak bisa didaftarkan 2x. |
| User | `password` | Minimal 8 karakter. Disimpan sebagai hash (bcrypt). Tidak pernah dikembalikan di response. |
| Kontak | `user_id` | Diisi otomatis dari user yang login (endpoint user). Admin bisa menentukan manual. |
| Kontak | `email` | **Nullable.** Boleh tidak diisi. Frontend wajib handle null. |
| Kontak | `nomor_hp` | Tidak ada validasi format. Bisa diisi dengan angka, +62, tanda kurung, dll. |

---

## 9. Validation Rules Summary

### 9.1 User

| Field | Store (Create) | Update |
|---|---|---|
| `name` | required, string, max:255 | sometimes, string, max:255 |
| `email` | required, email, unique:users | sometimes, email, unique:users (ignore current) |
| `password` | required, string, min:8 | sometimes, string, min:8 |

### 9.2 Kontak (User Scope — FormRequest)

| Field | Store (Create) | Update |
|---|---|---|
| `nama_kontak` | required, string, max:255 | sometimes, string, max:255 |
| `email` | required, email, max:255 | sometimes, email, max:255 |
| `nomor_hp` | required, string, max:255 | sometimes, string, max:255 |

### 9.3 Kontak (Admin Scope — inline validation)

| Field | Store (Create) | Update |
|---|---|---|
| `user_id` | required, exists:users,id | sometimes, exists:users,id |
| `nama_kontak` | required, string, max:255 | sometimes, string, max:255 |
| `email` | required, email, max:255 | sometimes, email, max:255 |
| `nomor_hp` | required, string, max:255 | sometimes, string, max:255 |

### 9.4 Auth

| Field | Login |
|---|---|
| `email` | required, email |
| `password` | required, string |

---

## Lampiran

### A. Flow Autentikasi

```
┌──────────┐     POST /api/login          ┌──────────┐
│          │  ─────────────────────────>   │          │
│  Client  │     { email, password }       │  Backend │
│ (Vue SPA)│                               │ (Laravel)│
│          │  <─────────────────────────   │          │
└──────────┘     200 { data: { token,     └──────────┘
                          user } }

┌──────────┐     GET /api/user             ┌──────────┐
│          │  ─────────────────────────>   │          │
│  Client  │     Authorization: Bearer..   │  Backend │
│          │  <─────────────────────────   │          │
└──────────┘     200 { data: UserResource }└──────────┘
```

### B. Ownership Logic

```
User A (id=1)  ──>  GET /api/users/1  ──>  200 (data milik sendiri)
User A (id=1)  ──>  GET /api/users/2  ──>  404 (bukan milik sendiri)
User A (id=1)  ──>  GET /api/admin/users/2  ──> 403 (bukan admin)

Admin (role=admin)  ──>  GET /api/admin/users/2  ──> 200 (akses penuh)
Admin (role=admin)  ──>  GET /api/users  ──> 200 (hanya data admin sendiri)
```

### C. Endpoint Count

| Kategori | Jumlah Endpoint |
|---|---|
| Public | 2 |
| Authenticated (user scope) | 10 |
| Admin | 11 |
| **Total** | **24** (dengan `apiResource` diekspansi) |
