# API Testing Guide — Mj.Kontak

> **Panduan praktis pengujian REST API via Postman / Insomnia**  
> **Base URL:** `http://localhost:8000/api`  
> **Auth:** Laravel Sanctum Bearer Token

---

## Daftar Isi

1. [Pre-requisites](#1-pre-requisites)
2. [Environment Variables](#2-environment-variables)
3. [Collection: Auth](#3-collection-auth)
4. [Collection: Users (User Scope)](#4-collection-users-user-scope)
5. [Collection: Kontaks (User Scope)](#5-collection-kontaks-user-scope)
6. [Collection: Admin Dashboard](#6-collection-admin-dashboard)
7. [Collection: Admin Users](#7-collection-admin-users)
8. [Collection: Admin Kontaks](#8-collection-admin-kontaks)
9. [Test Scenarios](#9-test-scenarios)

---

## 1. Pre-requisites

### 1.1 Jalankan Backend Server

```bash
# Dari folder backend/
php artisan serve
```

Server akan berjalan di `http://localhost:8000`.

### 1.2 Siapkan Database (Seed Data)

```bash
# Dari folder backend/
php artisan migrate --seed
```

Perintah ini akan membuat:
- **Admin user**: `admin@example.com` / `password`
- **10 user biasa** (masing-masing 1 kontak)

### 1.3 Setup Postman

**Langkah-langkah:**

1. Buka Postman
2. Klik **Environments** (sidebar kiri) → **Create Environment**
3. Beri nama: `Mj.Kontak`
4. Tambah variabel sesuai tabel [Environment Variables](#2-environment-variables)
5. Klik **Save**
6. Pilih environment `Mj.Kontak` dari dropdown kanan atas

### 1.4 Cara Mendapatkan Token

1. Buat request baru: **POST** `{{base_url}}/login`
2. Tab **Headers**: `Content-Type: application/json`
3. Tab **Body** → **raw** → **JSON**:

```json
{
  "email": "admin@example.com",
  "password": "password"
}
```

4. Klik **Send**
5. Copy nilai `data.token` dari response JSON
6. Paste ke environment variable `token`

### 1.5 Set Authorization Header

Untuk setiap request yang membutuhkan auth, set header:

| Key | Value |
|---|---|
| `Authorization` | `Bearer {{token}}` |
| `Accept` | `application/json` |
| `Content-Type` | `application/json` |

> **Tips:** Di Postman, Anda bisa set header `Authorization: Bearer {{token}}` di **Collection-level** (bukan request-level) agar semua request dalam satu collection otomatis memakainya.

---

## 2. Environment Variables

Buat variabel berikut di Postman Environment:

| Variable | Initial Value | Didapat Dari | Keterangan |
|---|---|---|---|
| `base_url` | `http://localhost:8000/api` | — | Base URL API |
| `token` | `(kosong)` | Response login | Bearer token |
| `admin_email` | `admin@example.com` | Seeder | Email admin |
| `admin_password` | `password` | Seeder | Password admin |
| `user_email` | `(kosong)` | Response register | Email user baru |
| `user_password` | `(kosong)` | Buat sendiri | Password user baru |
| `user_id` | `(kosong)` | Response detail user | ID user |
| `kontak_id` | `(kosong)` | Response create kontak | ID kontak |
| `target_user_id` | `(kosong)` | Response admin list users | ID user untuk admin |

---

## 3. Collection: Auth

### 3.1 Login

| Item | Nilai |
|---|---|
| **Method** | `POST` |
| **URL** | `{{base_url}}/login` |
| **Headers** | `Content-Type: application/json` |

**Body (raw JSON):**
```json
{
  "email": "admin@example.com",
  "password": "password"
}
```

**Expected Result:** `200 OK`
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

**Error Test — Password Salah:**
```json
{
  "email": "admin@example.com",
  "password": "salahpassword"
}
```
→ `422 Validation Error`

---

### 3.2 Logout

| Item | Nilai |
|---|---|
| **Method** | `POST` |
| **URL** | `{{base_url}}/logout` |
| **Headers** | `Authorization: Bearer {{token}}` |

**Body:** (kosong)

**Expected Result:** `200 OK`
```json
{
  "data": {
    "message": "Berhasil logout."
  }
}
```

---

### 3.3 Get Current User

| Item | Nilai |
|---|---|
| **Method** | `GET` |
| **URL** | `{{base_url}}/user` |
| **Headers** | `Authorization: Bearer {{token}}` |

**Body:** (kosong)

**Expected Result:** `200 OK`
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

---

## 4. Collection: Users (User Scope)

Semua endpoint di grup ini **terbatas hanya untuk data user yang sedang login**.

### 4.1 Register User Baru

| Item | Nilai |
|---|---|
| **Method** | `POST` |
| **URL** | `{{base_url}}/users` |
| **Headers** | `Content-Type: application/json` |

> **Catatan:** Endpoint ini **public** (tidak perlu token).

**Body (raw JSON):**
```json
{
  "name": "Budi Santoso",
  "email": "budi@example.com",
  "password": "rahasia123"
}
```

**Expected Result:** `201 Created`

Response akan mengandung `token` + `user`. **Copy nilai `data.token` ke environment variable `token`** dan `data.user.id` ke `user_id` untuk digunakan di request berikutnya.

```json
{
  "data": {
    "token": "2|xyz789abc...",
    "user": {
      "id": 12,
      "name": "Budi Santoso",
      "email": "budi@example.com",
      "role": "user",
      "created_at": "2026-07-02T12:00:00.000000Z"
    }
  }
}
```

**Error Test — Email Duplikat:**
```json
{
  "name": "Budi Santoso",
  "email": "budi@example.com",
  "password": "rahasia123"
}
```
→ `422 Validation Error`

---

### 4.2 List Profile Sendiri

| Item | Nilai |
|---|---|
| **Method** | `GET` |
| **URL** | `{{base_url}}/users` |
| **Headers** | `Authorization: Bearer {{token}}` |

**Expected Result:** `200 OK`
```json
{
  "data": [
    {
      "id": 12,
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

---

### 4.3 Detail User

| Item | Nilai |
|---|---|
| **Method** | `GET` |
| **URL** | `{{base_url}}/users/{{user_id}}` |
| **Headers** | `Authorization: Bearer {{token}}` |

**Expected Result:** `200 OK`
```json
{
  "data": {
    "id": 12,
    "name": "Budi Santoso",
    "email": "budi@example.com",
    "role": "user",
    "created_at": "2026-07-02T12:00:00.000000Z"
  }
}
```

**Error Test — Akses User Lain:**
```
GET {{base_url}}/users/1
```
→ `404 Not Found` (karena user lain)

---

### 4.4 Update User

| Item | Nilai |
|---|---|
| **Method** | `PUT` |
| **URL** | `{{base_url}}/users/{{user_id}}` |
| **Headers** | `Authorization: Bearer {{token}}` |

**Body (raw JSON) — update nama + email:**
```json
{
  "name": "Budi Santoso Update",
  "email": "budi_baru@example.com"
}
```

**Body — update password saja:**
```json
{
  "password": "passwordbaru123"
}
```

**Expected Result:** `200 OK`
```json
{
  "data": {
    "id": 12,
    "name": "Budi Santoso Update",
    "email": "budi_baru@example.com",
    "role": "user",
    "created_at": "2026-07-02T12:00:00.000000Z"
  }
}
```

---

### 4.5 Hapus User

| Item | Nilai |
|---|---|
| **Method** | `DELETE` |
| **URL** | `{{base_url}}/users/{{user_id}}` |
| **Headers** | `Authorization: Bearer {{token}}` |

**Expected Result:** `204 No Content` (response body kosong)

> **Catatan:** Semua kontak milik user ini akan ikut terhapus (cascade).

---

## 5. Collection: Kontaks (User Scope)

Semua endpoint di grup ini **terbatas hanya untuk kontak milik user yang sedang login**.

### 5.1 List Kontak

| Item | Nilai |
|---|---|
| **Method** | `GET` |
| **URL** | `{{base_url}}/kontaks` |
| **Headers** | `Authorization: Bearer {{token}}` |

**Query Params (opsional):** `?page=1&per_page=15`

**Expected Result:** `200 OK`
```json
{
  "data": [
    {
      "id": 1,
      "user_id": 12,
      "nama_kontak": "Siti Aisyah",
      "email": "siti@example.com",
      "nomor_hp": "08123456789",
      "created_at": "2026-07-02T12:30:00.000000Z"
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

---

### 5.2 Tambah Kontak Baru

| Item | Nilai |
|---|---|
| **Method** | `POST` |
| **URL** | `{{base_url}}/kontaks` |
| **Headers** | `Authorization: Bearer {{token}}` |

**Body (raw JSON):**
```json
{
  "nama_kontak": "Siti Aisyah",
  "email": "siti@example.com",
  "nomor_hp": "08123456789"
}
```

**Expected Result:** `201 Created`

**Copy `data.id` dari response ke environment variable `kontak_id`.**
```json
{
  "data": {
    "id": 10,
    "user_id": 12,
    "nama_kontak": "Siti Aisyah",
    "email": "siti@example.com",
    "nomor_hp": "08123456789",
    "created_at": "2026-07-02T13:00:00.000000Z"
  }
}
```

**Error Test — Field Kosong:**
```json
{
  "nama_kontak": "",
  "email": "",
  "nomor_hp": ""
}
```
→ `422 Validation Error`

---

### 5.3 Detail Kontak

| Item | Nilai |
|---|---|
| **Method** | `GET` |
| **URL** | `{{base_url}}/kontaks/{{kontak_id}}` |
| **Headers** | `Authorization: Bearer {{token}}` |

**Expected Result:** `200 OK`

---

### 5.4 Update Kontak

| Item | Nilai |
|---|---|
| **Method** | `PUT` |
| **URL** | `{{base_url}}/kontaks/{{kontak_id}}` |
| **Headers** | `Authorization: Bearer {{token}}` |

**Body (raw JSON) — update nama dan nomor HP saja:**
```json
{
  "nama_kontak": "Siti Aisyah Update",
  "nomor_hp": "08999999999"
}
```

**Expected Result:** `200 OK`

---

### 5.5 Hapus Kontak

| Item | Nilai |
|---|---|
| **Method** | `DELETE` |
| **URL** | `{{base_url}}/kontaks/{{kontak_id}}` |
| **Headers** | `Authorization: Bearer {{token}}` |

**Expected Result:** `204 No Content`

---

## 6. Collection: Admin Dashboard

### 6.1 Dashboard Statistik

| Item | Nilai |
|---|---|
| **Method** | `GET` |
| **URL** | `{{base_url}}/admin/dashboard` |
| **Headers** | `Authorization: Bearer {{token}}` |

> **Penting:** Token harus milik user dengan role `admin`.

**Expected Result:** `200 OK`
```json
{
  "total_users": 12,
  "total_kontaks": 11
}
```

**Error Test — Non-Admin Token:**
→ `403 Forbidden`

---

## 7. Collection: Admin Users

Semua endpoint admin user **tidak ada filter ownership** — bisa akses user manapun.

### 7.1 List Semua User

| Item | Nilai |
|---|---|
| **Method** | `GET` |
| **URL** | `{{base_url}}/admin/users` |
| **Headers** | `Authorization: Bearer {{token}}` |

**Expected Result:** `200 OK`
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
    "total": 12
  }
}
```

### 7.2 Tambah User (Admin)

| Item | Nilai |
|---|---|
| **Method** | `POST` |
| **URL** | `{{base_url}}/admin/users` |
| **Headers** | `Authorization: Bearer {{token}}` |

**Body (raw JSON):**
```json
{
  "name": "User Dari Admin",
  "email": "user_dari_admin@example.com",
  "password": "password123"
}
```

**Expected Result:** `201 Created`
```json
{
  "data": {
    "id": 13,
    "name": "User Dari Admin",
    "email": "user_dari_admin@example.com",
    "role": "user",
    "created_at": "2026-07-02T14:00:00.000000Z"
  }
}
```

> **Catatan:** Berbeda dengan registrasi publik, response tidak mengandung `token`.

**Copy `data.id` ke environment variable `target_user_id`.**

### 7.3 Detail User (Admin)

| Item | Nilai |
|---|---|
| **Method** | `GET` |
| **URL** | `{{base_url}}/admin/users/{{target_user_id}}` |
| **Headers** | `Authorization: Bearer {{token}}` |

**Expected Result:** `200 OK`

### 7.4 Update User (Admin)

| Item | Nilai |
|---|---|
| **Method** | `PUT` |
| **URL** | `{{base_url}}/admin/users/{{target_user_id}}` |
| **Headers** | `Authorization: Bearer {{token}}` |

**Body (raw JSON) — upgrade role ke admin:**
```json
{
  "name": "User Dari Admin Update",
  "role": "admin"
}
```

**Expected Result:** `200 OK`

### 7.5 Hapus User (Admin)

| Item | Nilai |
|---|---|
| **Method** | `DELETE` |
| **URL** | `{{base_url}}/admin/users/{{target_user_id}}` |
| **Headers** | `Authorization: Bearer {{token}}` |

**Expected Result:** `204 No Content`

> **Catatan:** Kontak milik user yang dihapus akan ikut terhapus (cascade).

---

## 8. Collection: Admin Kontaks

### 8.1 List Semua Kontak

| Item | Nilai |
|---|---|
| **Method** | `GET` |
| **URL** | `{{base_url}}/admin/kontaks` |
| **Headers** | `Authorization: Bearer {{token}}` |

**Expected Result:** `200 OK`

### 8.2 Tambah Kontak (Admin)

| Item | Nilai |
|---|---|
| **Method** | `POST` |
| **URL** | `{{base_url}}/admin/kontaks` |
| **Headers** | `Authorization: Bearer {{token}}` |

**Body (raw JSON):**
```json
{
  "user_id": 2,
  "nama_kontak": "Kontak Milik User 2",
  "email": "kontak@example.com",
  "nomor_hp": "08111111111"
}
```

**Expected Result:** `201 Created`

> **Catatan:** Admin wajib menentukan `user_id` (pemilik kontak).

### 8.3 Detail Kontak (Admin)

| Item | Nilai |
|---|---|
| **Method** | `GET` |
| **URL** | `{{base_url}}/admin/kontaks/{id}` |
| **Headers** | `Authorization: Bearer {{token}}` |

**Expected Result:** `200 OK`

### 8.4 Update Kontak (Admin)

| Item | Nilai |
|---|---|
| **Method** | `PUT` |
| **URL** | `{{base_url}}/admin/kontaks/{id}` |
| **Headers** | `Authorization: Bearer {{token}}` |

**Body (raw JSON):**
```json
{
  "nama_kontak": "Kontak Update"
}
```

**Expected Result:** `200 OK`

### 8.5 Hapus Kontak (Admin)

| Item | Nilai |
|---|---|
| **Method** | `DELETE` |
| **URL** | `{{base_url}}/admin/kontaks/{id}` |
| **Headers** | `Authorization: Bearer {{token}}` |

**Expected Result:** `204 No Content`

---

## 9. Test Scenarios

### Skenario 1: User Flow Lengkap

Tujuan: Menguji alur lengkap dari registrasi user biasa hingga hapus kontak.

| Langkah | Request | Yang Dilakukan |
|---|---|---|
| 1 | `POST /api/users` | Register user baru → **copy token + user_id** |
| 2 | `GET /api/user` | Verifikasi data user |
| 3 | `GET /api/kontaks` | Pastikan list kontak kosong |
| 4 | `POST /api/kontaks` | Tambah kontak "Siti Aisyah" → **copy kontak_id** |
| 5 | `POST /api/kontaks` | Tambah kontak "Ahmad Rizki" (email: null) |
| 6 | `GET /api/kontaks` | Pastikan ada 2 kontak |
| 7 | `PUT /api/kontaks/{{kontak_id}}` | Update nama kontak |
| 8 | `GET /api/kontaks/{{kontak_id}}` | Verifikasi nama sudah berubah |
| 9 | `DELETE /api/kontaks/{{kontak_id}}` | Hapus kontak |
| 10 | `GET /api/kontaks` | Pastikan kontak sudah tidak ada |
| 11 | `PUT /api/users/{{user_id}}` | Update profil (ganti nama, email, password) |
| 12 | `POST /api/logout` | Logout |
| 13 | `POST /api/login` | Login dengan email + password baru |
| 14 | `DELETE /api/users/{{user_id}}` | Hapus akun |
| 15 | `POST /api/login` | Pastikan login gagal (akun sudah dihapus) |

---

### Skenario 2: Admin Flow Lengkap

Tujuan: Menguji akses admin penuh terhadap seluruh data.

| Langkah | Request | Yang Dilakukan |
|---|---|---|
| 1 | `POST /api/login` | Login sebagai admin@example.com → **copy token** |
| 2 | `GET /api/admin/dashboard` | Lihat total users dan kontak |
| 3 | `GET /api/admin/users` | Lihat semua user (pastikan ada >1) |
| 4 | `POST /api/admin/users` | Buat user baru (tanpa token) → **copy target_user_id** |
| 5 | `PUT /api/admin/users/{{target_user_id}}` | Ubah role user baru menjadi admin |
| 6 | `POST /api/admin/kontaks` | Buat kontak untuk user target (isi user_id) |
| 7 | `GET /api/admin/kontaks` | Pastikan kontak baru muncul di list |
| 8 | `DELETE /api/admin/kontaks/{id}` | Hapus kontak yang baru dibuat |
| 9 | `DELETE /api/admin/users/{{target_user_id}}` | Hapus user target |
| 10 | `GET /api/admin/dashboard` | Pastikan total_users berkurang 1 |
| 11 | `POST /api/logout` | Logout |

---

### Skenario 3: Negative / Error Flow

Tujuan: Menguji penanganan error di berbagai situasi.

| Langkah | Request | Expected Error |
|---|---|---|
| 1 | `GET /api/admin/dashboard` **tanpa token** | `401 Unauthenticated` |
| 2 | `GET /api/admin/users` pakai **token user biasa** | `403 Forbidden` |
| 3 | `POST /api/login` dengan **password salah** | `422 Validation Error` — "Email atau password salah." |
| 4 | `POST /api/users` dengan **email duplikat** | `422 Validation Error` — "Email sudah digunakan." |
| 5 | `POST /api/kontaks` dengan **field kosong** | `422 Validation Error` |
| 6 | `GET /api/users/1` sebagai **user biasa** | `404 Not Found` (bukan data sendiri) |
| 7 | `GET /api/kontaks/99999` (ID tidak ada) | `404 Not Found` |
| 8 | `DELETE /api/kontaks/99999` (ID tidak ada) | `404 Not Found` |
| 9 | `POST /api/login` dengan **format email salah** | `422 Validation Error` |
| 10 | `POST /api/users` dengan **password 3 karakter** | `422 Validation Error` — "min:8" |
| 11 | Kirim request dengan **token expired/invalid** | `401 Unauthenticated` |
| 12 | Akses `DELETE /api/kontaks/1` pakai **token user yang bukan pemilik kontak** | `404 Not Found` |

---

## Lampiran

### A. Postman Collection Siap Import

Untuk mempermudah, Anda bisa membuat Collection Postman dengan struktur folder seperti ini:

```
Mj.Kontak API
├── Auth
│   ├── Login
│   ├── Logout
│   └── Get Current User
├── Users (User Scope)
│   ├── Register
│   ├── List Profile
│   ├── Detail
│   ├── Update
│   └── Delete
├── Kontaks (User Scope)
│   ├── List
│   ├── Create
│   ├── Detail
│   ├── Update
│   └── Delete
├── Admin Dashboard
│   └── Dashboard Stats
├── Admin Users
│   ├── List All
│   ├── Create
│   ├── Detail
│   ├── Update
│   └── Delete
└── Admin Kontaks
    ├── List All
    ├── Create
    ├── Detail
    ├── Update
    └── Delete
```

### B. Quick Reference: Headers per Endpoint

| Endpoint | Auth Required | Content-Type |
|---|---|---|
| `POST /api/login` | ❌ | `application/json` |
| `POST /api/users` (register) | ❌ | `application/json` |
| Semua endpoint lain | ✅ `Bearer {{token}}` | `application/json` |

### C. Status Codes Cheat Sheet

| Status | Artinya | Penyebab Umum |
|---|---|---|
| `200 OK` | Sukses | GET, PUT, POST login/logout |
| `201 Created` | Berhasil buat data | POST store |
| `204 No Content` | Berhasil hapus | DELETE |
| `401 Unauthenticated` | Token tidak ada/expired | Lupa set header Authorization |
| `403 Forbidden` | Bukan admin | Akses `/admin/*` dengan token user biasa |
| `404 Not Found` | Data tidak ada / bukan milik sendiri | ID salah atau akses data user lain |
| `422 Validation Error` | Data tidak valid | Field kosong, email duplikat, password pendek |
| `500 Server Error` | Error backend | Cek log Laravel (`storage/logs/laravel.log`) |
