# Flow Bisnis - Sistem Pengaduan Akademik

## 1. Aktor Sistem

| Aktor | Peran | Akses |
|-------|-------|-------|
| **Pelapor** | Mahasiswa/masyarakat yang melapor | Public (dengan/sans token) |
| **Admin Kampus** | Memantau & mengelola aduan | Protected (auth:sanctum + role admin) |

## 2. Diagram Alur Bisnis

```
                        +-------------------+
                        |   PELAPOR         |
                        | (Login / Anonim)  |
                        +--------+----------+
                                 |
                    Kirim Data Aduan + File
                                 |
                                 v
                        +-------------------+
                        |   SISTEM API      |
                        | 1. Validasi Input |
                        | 2. DB Transaction |
                        | 3. Simpan Aduan   |
                        | 4. Upload File    |
                        +--------+----------+
                                 |
                      Generate Tracking Code
                                 |
                                 v
            +--------------------+--------------------+
            |                                         |
            v                                         v
   +------------------+           +----------------------------+
   | PELAPOR          |           |         ADMIN              |
   | Lacak via kode   |           | Login -> Dashboard         |
   +--------+---------+           +-------------+--------------+
            |                                   |
            v                                   +-----------+----------+
   +------------------+                                      |          |
   | GET /complaints/ |                          +-----------+  +------+--------+
   | track/{kode}     |                          | Kelola    |  | Kelola       |
   | -> Status Aduan  |                          | Aduan     |  | Master Data  |
   +------------------+                          +-----+-----+  +------+-------+
                                                       |               |
                                                       v               v
                                              +---------------+  +-------------+
                                              | List / Filter |  | CRUD        |
                                              | Update Status |  | Categories  |
                                              +---------------+  | & Users     |
                                                                  +-------------+
```

## 3. Flow Registrasi & Autentikasi

**Endpoint:**
- `POST /api/register` — Daftar akun baru
- `POST /api/login` — Login, dapat Bearer Token
- `POST /api/logout` — Hapus token (auth:sanctum)

**Alur:**

```
Pelapor -> POST /register (name, email, password)
       <- 201 + { user, access_token, token_type: "Bearer" }

Pelapor -> POST /login (email, password)
       <- 200 + { user, access_token }

Pelapor -> POST /logout (Authorization: Bearer {token})
       <- 200 + { success: true }
```

**Contoh Request Register:**

```json
POST /api/register
{
    "name": "Budi Santoso",
    "email": "budi@student.ac.id",
    "password": "rahasia123",
    "password_confirmation": "rahasia123"
}
```

**Contoh Response Register:**

```json
{
    "success": true,
    "message": "Registrasi berhasil",
    "data": {
        "user": {
            "id": 1,
            "name": "Budi Santoso",
            "email": "budi@student.ac.id",
            "role": "user"
        },
        "access_token": "1|abc123def456...",
        "token_type": "Bearer"
    }
}
```

**Contoh Request Login:**

```json
POST /api/login
{
    "email": "budi@student.ac.id",
    "password": "rahasia123"
}
```

**Contoh Response Login:**

```json
{
    "success": true,
    "message": "Login berhasil",
    "data": {
        "user": {
            "id": 1,
            "name": "Budi Santoso",
            "email": "budi@student.ac.id",
            "role": "user"
        },
        "access_token": "1|abc123def456...",
        "token_type": "Bearer"
    }
}
```

## 4. Flow Pengajuan Aduan (Public)

**Endpoint:** `POST /api/complaints`

**Alur:**

```
Pelapor -> POST /complaints (multipart/form-data)
       - category_id, title, description
       - is_anonymous (boolean)
       - evidences[] (file: jpeg/png/jpg/pdf, max 5MB)
       - links[] (url)

Sistem -> Validasi (FormRequest)
       -> DB::transaction
           -> Generate tracking_code (ADU-YYYYMM-XXXXXX)
           -> Simpan Complaint
           -> Upload file ke storage/app/public/complaints/
           -> Simpan ComplaintEvidence (type: image/link)
       -> Return tracking_code
```

**Contoh Request:**

```
POST /api/complaints
Content-Type: multipart/form-data

category_id: 1
title: "AC Rusak di Ruang 203"
description: "AC tidak mengeluarkan udara dingin sejak 3 hari lalu"
is_anonymous: false
evidences[0]: (file: foto_ac.jpg)
links[0]: "https://drive.google.com/file/d/xxx"
```

**Contoh Response:**

```json
{
    "success": true,
    "message": "Aduan berhasil dikirim!",
    "data": {
        "tracking_code": "ADU-202606-A8X9K2",
        "note": "Simpan kode tracking ini untuk mengecek status aduan Anda."
    }
}
```

## 5. Flow Pelacakan Aduan (Public - Tanpa Login)

**Endpoint:** `GET /api/complaints/track/{tracking_code}`

**Alur:**

```
Pelapor -> GET /complaints/track/ADU-202606-A8X9K2

Sistem -> Complaint::with(['category','user','evidences'])
       -> where tracking_code
       -> ComplaintResource (sembunyikan identitas jika anonim)
```

**Contoh Response:**

```json
{
    "success": true,
    "message": "Detail status aduan",
    "data": {
        "id": 1,
        "kode_pelacakan": "ADU-202606-A8X9K2",
        "judul": "AC Rusak di Ruang 203",
        "deskripsi": "AC tidak mengeluarkan udara dingin sejak 3 hari lalu",
        "status": "processing",
        "kategori": "Fasilitas",
        "pelapor": "Budi Santoso",
        "bukti_lampiran": [
            {
                "tipe": "image",
                "url": "https://api.example.com/storage/complaints/foto_ac.jpg"
            },
            {
                "tipe": "link",
                "url": "https://drive.google.com/file/d/xxx"
            }
        ],
        "dilaporkan_pada": "24 Jun 2026 14:30"
    }
}
```

## 6. Flow Monitoring Admin (Protected)

**Endpoint:** `GET /api/admin/complaints?status=pending&page=1`

**Alur:**

```
Admin -> Login -> Dapat Token
      -> GET /admin/complaints (Authorization: Bearer {token})
      -> Optional: ?status=pending (filter)

Sistem -> Complaint::with(['category','user','evidences'])
       -> when(status) -> filter
       -> latest() -> paginate(15)
       -> ComplaintResource::collection()
```

**Contoh Response:**

```json
{
    "success": true,
    "message": "Data monitoring aduan",
    "data": {
        "current_page": 1,
        "data": [
            {
                "id": 1,
                "kode_pelacakan": "ADU-202606-A8X9K2",
                "judul": "AC Rusak di Ruang 203",
                "status": "pending",
                "kategori": "Fasilitas",
                "pelapor": "Budi Santoso",
                "dilaporkan_pada": "24 Jun 2026 14:30"
            }
        ],
        "last_page": 1,
        "per_page": 15,
        "total": 1
    }
}
```

## 7. Flow Update Status Admin (Protected)

**Endpoint:** `PUT /api/admin/complaints/{id}/status`

**Alur:**

```
Admin -> PUT /admin/complaints/1/status
      -> Body: { "status": "processing" }

Sistem -> Validasi (in: pending,processing,resolved,rejected)
       -> $complaint->update(['status' => $request->status])
       -> Return ComplaintResource
```

**Contoh Request:**

```json
PUT /api/admin/complaints/1/status
Authorization: Bearer {admin_token}
{
    "status": "processing"
}
```

**Contoh Response:**

```json
{
    "success": true,
    "message": "Status aduan berhasil diperbarui",
    "data": {
        "id": 1,
        "kode_pelacakan": "ADU-202606-A8X9K2",
        "judul": "AC Rusak di Ruang 203",
        "status": "processing",
        "kategori": "Fasilitas",
        "pelapor": "Budi Santoso",
        "dilaporkan_pada": "24 Jun 2026 14:30"
    }
}
```

### 7.1 Status Transisi

Berikut diagram transisi status aduan yang valid:

```
             +-----------+
             |  pending  |
             +-----+-----+
                   |
          +--------+--------+
          |                  |
          v                  v
    +----------+       +----------+
    |processing|       | rejected |
    +-----+----+       +----------+
          |
          v
    +----------+
    | resolved |
    +----------+
```

**Aturan Transisi:**
| Dari | Ke | Keterangan |
|------|-----|-----------|
| `pending` | `processing` | Admin menerima dan memproses aduan |
| `pending` | `rejected` | Admin menolak aduan (tidak valid/duplikat) |
| `processing` | `resolved` | Aduan selesai ditangani |
| `processing` | `rejected` | Ditolak setelah ditinjau |
| `resolved` | - | Status final, tidak bisa diubah |
| `rejected` | - | Status final, tidak bisa diubah |

### 7.2 Admin CRUD Categories

Admin dapat mengelola data kategori aduan secara penuh (*Create, Read, Update, Delete*).

**Endpoint:**

| Method | Endpoint | Fungsi |
|--------|----------|--------|
| `GET` | `/api/admin/categories` | Menampilkan semua kategori |
| `POST` | `/api/admin/categories` | Menambah kategori baru |
| `GET` | `/api/admin/categories/{id}` | Menampilkan detail kategori |
| `PUT` | `/api/admin/categories/{id}` | Mengupdate data kategori |
| `DELETE` | `/api/admin/categories/{id}` | Menghapus kategori |

#### 7.2.A List Categories

**Alur:**
```
Admin -> GET /admin/categories (Authorization: Bearer {token})

Sistem -> Category::all()
```

**Contoh Response:**
```json
{
    "success": true,
    "message": "Daftar kategori",
    "data": [
        {
            "id": 1,
            "name": "Fasilitas",
            "slug": "fasilitas",
            "created_at": "2026-06-01T00:00:00.000000Z"
        },
        {
            "id": 2,
            "name": "Akademik",
            "slug": "akademik",
            "created_at": "2026-06-01T00:00:00.000000Z"
        }
    ]
}
```

#### 7.2.B Create Category

**Alur:**
```
Admin -> POST /admin/categories
      -> Body: { "name": "Fasilitas", "slug": "fasilitas" }

Sistem -> Validasi (name required, slug unique)
       -> Category::create()
```

**Contoh Request:**
```json
POST /api/admin/categories
Authorization: Bearer {admin_token}
{
    "name": "Fasilitas",
    "slug": "fasilitas"
}
```

**Contoh Response:**
```json
{
    "success": true,
    "message": "Kategori berhasil ditambahkan",
    "data": {
        "id": 1,
        "name": "Fasilitas",
        "slug": "fasilitas",
        "created_at": "2026-06-24T00:00:00.000000Z"
    }
}
```

#### 7.2.C Show Category

**Alur:**
```
Admin -> GET /admin/categories/1

Sistem -> Category::findOrFail($id)
```

**Contoh Response:**
```json
{
    "success": true,
    "message": "Detail kategori",
    "data": {
        "id": 1,
        "name": "Fasilitas",
        "slug": "fasilitas",
        "created_at": "2026-06-24T00:00:00.000000Z"
    }
}
```

#### 7.2.D Update Category

**Alur:**
```
Admin -> PUT /admin/categories/1
      -> Body: { "name": "Fasilitas & Infrastruktur", "slug": "fasilitas-infrastruktur" }

Sistem -> Validasi
       -> Category::findOrFail($id)->update()
```

**Contoh Request:**
```json
PUT /api/admin/categories/1
Authorization: Bearer {admin_token}
{
    "name": "Fasilitas & Infrastruktur",
    "slug": "fasilitas-infrastruktur"
}
```

**Contoh Response:**
```json
{
    "success": true,
    "message": "Kategori berhasil diperbarui",
    "data": {
        "id": 1,
        "name": "Fasilitas & Infrastruktur",
        "slug": "fasilitas-infrastruktur",
        "created_at": "2026-06-24T00:00:00.000000Z"
    }
}
```

#### 7.2.E Delete Category

**Alur:**
```
Admin -> DELETE /admin/categories/1

Sistem -> Category::findOrFail($id)->delete()
```

**Contoh Response:**
```json
{
    "success": true,
    "message": "Kategori berhasil dihapus",
    "data": null
}
```

**Catatan:** Kategori yang sudah memiliki relasi dengan aduan (complaints) sebaiknya tidak dihapus secara langsung. Implementasi bisa menggunakan *soft delete* atau validasi relasi sebelum menghapus.

### 7.3 Admin CRUD Users

Admin dapat mengelola data pengguna (user) sistem, termasuk mengubah role (admin/user).

**Endpoint:**

| Method | Endpoint | Fungsi |
|--------|----------|--------|
| `GET` | `/api/admin/users` | Menampilkan semua user |
| `POST` | `/api/admin/users` | Menambah user baru |
| `GET` | `/api/admin/users/{id}` | Menampilkan detail user |
| `PUT` | `/api/admin/users/{id}` | Mengupdate data user |
| `DELETE` | `/api/admin/users/{id}` | Menghapus user |

#### 7.3.A List Users

**Alur:**
```
Admin -> GET /admin/users (Authorization: Bearer {token})

Sistem -> User::all()
```

**Contoh Response:**
```json
{
    "success": true,
    "message": "Daftar pengguna",
    "data": [
        {
            "id": 1,
            "name": "Admin Kampus",
            "email": "admin@kampus.ac.id",
            "role": "admin",
            "created_at": "2026-01-01T00:00:00.000000Z"
        },
        {
            "id": 2,
            "name": "Budi Santoso",
            "email": "budi@student.ac.id",
            "role": "user",
            "created_at": "2026-06-24T00:00:00.000000Z"
        }
    ]
}
```

#### 7.3.B Create User

**Alur:**
```
Admin -> POST /admin/users
      -> Body: { "name": "Siti Rahma", "email": "siti@student.ac.id", "password": "...", "role": "user" }

Sistem -> Validasi (email unique, password min:8)
       -> User::create()
```

**Contoh Request:**
```json
POST /api/admin/users
Authorization: Bearer {admin_token}
{
    "name": "Siti Rahma",
    "email": "siti@student.ac.id",
    "password": "rahasia123",
    "password_confirmation": "rahasia123",
    "role": "user"
}
```

**Contoh Response:**
```json
{
    "success": true,
    "message": "User berhasil ditambahkan",
    "data": {
        "id": 3,
        "name": "Siti Rahma",
        "email": "siti@student.ac.id",
        "role": "user",
        "created_at": "2026-06-24T00:00:00.000000Z"
    }
}
```

#### 7.3.C Show User

**Alur:**
```
Admin -> GET /admin/users/1

Sistem -> User::findOrFail($id)
```

**Contoh Response:**
```json
{
    "success": true,
    "message": "Detail pengguna",
    "data": {
        "id": 1,
        "name": "Admin Kampus",
        "email": "admin@kampus.ac.id",
        "role": "admin",
        "created_at": "2026-01-01T00:00:00.000000Z"
    }
}
```

#### 7.3.D Update User

**Alur:**
```
Admin -> PUT /admin/users/1
      -> Body: { "name": "Admin Utama", "role": "admin" }

Sistem -> Validasi (email unique jika diubah)
       -> User::findOrFail($id)->update()
```

**Contoh Request:**
```json
PUT /api/admin/users/1
Authorization: Bearer {admin_token}
{
    "name": "Admin Utama",
    "email": "admin@kampus.ac.id",
    "role": "admin"
}
```

**Contoh Response:**
```json
{
    "success": true,
    "message": "User berhasil diperbarui",
    "data": {
        "id": 1,
        "name": "Admin Utama",
        "email": "admin@kampus.ac.id",
        "role": "admin",
        "created_at": "2026-01-01T00:00:00.000000Z"
    }
}
```

#### 7.3.E Delete User

**Alur:**
```
Admin -> DELETE /admin/users/1

Sistem -> User::findOrFail($id)->delete()
```

**Contoh Response:**
```json
{
    "success": true,
    "message": "User berhasil dihapus",
    "data": null
}
```

**Catatan:** Hapus user akan menghapus semua relasi aduannya (tergantung implementasi `nullOnDelete`). Disarankan untuk tidak menghapus user yang memiliki riwayat aduan, atau gunakan *soft delete*.

## 8. Flow Error Handling

Setiap API *endpoint* memiliki mekanisme *error handling* yang terstandar dengan format JSON.

### 8.1 Validasi Gagal (422)

Terjadi ketika input tidak memenuhi aturan validasi.

**Contoh Request Salah:**

```json
POST /api/complaints
Content-Type: application/json

{
    "title": "",
    "category_id": 99
}
```

**Contoh Response:**

```json
{
    "success": false,
    "message": "Validasi gagal, mohon periksa inputan Anda.",
    "errors": {
        "title": ["The title field is required."],
        "category_id": ["The selected category_id is invalid."]
    }
}
```

### 8.2 Data Tidak Ditemukan (404)

Terjadi ketika *tracking code* atau ID aduan tidak ada di database.

**Contoh Request:**

```
GET /api/complaints/track/ADU-202606-XXXXXX
```

**Contoh Response:**

```json
{
    "success": false,
    "message": "Endpoint atau Data tidak ditemukan.",
    "data": null
}
```

### 8.3 Kredensial Tidak Valid / Token Expired (401)

Terjadi ketika token tidak dikirim, token salah, atau sudah kadaluwarsa.

**Contoh Request:**

```
GET /api/admin/complaints
Authorization: Bearer invalid_token_xxx
```

**Contoh Response:**

```json
{
    "success": false,
    "message": "Kredensial tidak valid",
    "data": null
}
```

Atau dari Laravel Sanctum:

```json
{
    "message": "Unauthenticated."
}
```

### 8.4 Server Error / Database Error (500)

Terjadi ketika ada kegagalan sistem, misalnya upload file gagal, koneksi database terputus, dll.

**Contoh Response:**

```json
{
    "success": false,
    "message": "Terjadi kesalahan sistem: ...",
    "data": null
}
```

**Catatan:** Di lingkungan *production* (`APP_DEBUG=false`), pesan *error* detail tidak akan ditampilkan untuk keamanan.

### 8.5 Diagram Error Flow

```
                         +-------------------+
                         |   REQUEST MASUK   |
                         +--------+----------+
                                  |
                                  v
                         +-------------------+
                         |  CORS Check       |
                         | (Origin diizinkan?)|
                         +--------+----------+
                                  |
                          +-------+--------+
                          |                |
                     (Tidak)            (Ya)
                          |                |
                          v                v
                   +-----------+    +-------------------+
                   | 403 CORS  |    | Autentikasi Check |
                   +-----------+    +--------+----------+
                                             |
                                     +-------+--------+
                                     |                |
                                (Tidak)            (Ya)
                                     |                |
                                     v                v
                              +-----------+    +-------------------+
                              | 401       |    | Validasi Input    |
                              | Unauthor. |    +--------+----------+
                              +-----------+             |
                                                  +-----+-----+
                                                  |           |
                                             (Gagal)     (Lolos)
                                                  |           |
                                                  v           v
                                          +-----------+   +-------------------+
                                          | 422       |   | Proses Bisnis    |
                                          | Validasi  |   +--------+----------+
                                          +-----------+            |
                                                           +-------+--------+
                                                           |                |
                                                      (Gagal)          (Sukses)
                                                           |                |
                                                           v                v
                                                    +-----------+    +-----------+
                                                    | 500 Server|    | 200/201   |
                                                    | Error     |    | Success   |
                                                    +-----------+    +-----------+
```

## 9. CORS Configuration Flow

CORS (Cross-Origin Resource Sharing) diperlukan ketika aplikasi Frontend (React/Vue/Flutter) berjalan di domain/port berbeda dengan API Laravel.

### 9.1 Masalah

```
Browser (React di port 3000)       API Laravel (port 8000)
       |                                  |
       |--- GET /api/complaints -------->|
       |                                  |
       |<-- Blokir (CORS Error) ---------|
       |                                  |
```

### 9.2 Solusi: Konfigurasi `config/cors.php`

```php
// config/cors.php
return [
    'paths' => ['api/*', 'sanctum/csrf-cookie'],
    'allowed_origins' => ['*'], // Ganti dengan domain frontend di production
    'allowed_headers' => ['*'],
    'allowed_methods' => ['*'],
    'supports_credentials' => false,
];
```

### 9.3 Alur CORS

```
Frontend                          API Laravel
   |                                  |
   |--- OPTIONS /api/complaints ---->|  (Preflight Request)
   |    (Origin: http://localhost:3000) |
   |<-- 200 OK ----------------------|
   |    Access-Control-Allow-Origin: *|
   |                                  |
   |--- GET /api/complaints -------->|  (Actual Request)
   |    Origin: http://localhost:3000   |
   |<-- 200 + Data ------------------|
   |    Access-Control-Allow-Origin: *|
```

### 9.4 Checklist CORS

| Lingkungan | `allowed_origins` | Keterangan |
|------------|-------------------|-------------|
| Development | `['*']` | Izinkan semua origin |
| Production | `['https://pengaduan-kampus.com']` | Hanya domain resmi |

**Catatan:** Pastikan frontend mengirim *header* `Accept: application/json` agar Laravel mengenali sebagai *request* API dan mengembalikan error dalam format JSON.

## 10. API Reference

### 10.1 Daftar Endpoint

| Method | Endpoint | Auth | Fungsi |
|--------|----------|------|--------|
| `POST` | `/api/register` | - | Mendaftarkan akun baru |
| `POST` | `/api/login` | - | Login dan mendapat token |
| `POST` | `/api/logout` | `auth:sanctum` | Hapus token (logout) |
| `GET` | `/api/profile` | `auth:sanctum` | Lihat data user login |
| `POST` | `/api/complaints` | `-` (opsional) | Kirim aduan baru |
| `GET` | `/api/complaints/track/{code}` | - | Lacak status aduan via kode |
| `GET` | `/api/admin/complaints` | `auth:sanctum` + role admin | List semua aduan (pagination) |
| `GET` | `/api/admin/complaints?status=` | `auth:sanctum` + role admin | Filter aduan berdasarkan status |
| `PUT` | `/api/admin/complaints/{id}/status` | `auth:sanctum` + role admin | Ubah status aduan |
| `GET` | `/api/admin/categories` | `auth:sanctum` + role admin | Menampilkan semua kategori |
| `POST` | `/api/admin/categories` | `auth:sanctum` + role admin | Menambah kategori baru |
| `GET` | `/api/admin/categories/{id}` | `auth:sanctum` + role admin | Detail kategori |
| `PUT` | `/api/admin/categories/{id}` | `auth:sanctum` + role admin | Mengupdate kategori |
| `DELETE` | `/api/admin/categories/{id}` | `auth:sanctum` + role admin | Menghapus kategori |
| `GET` | `/api/admin/users` | `auth:sanctum` + role admin | Menampilkan semua user |
| `POST` | `/api/admin/users` | `auth:sanctum` + role admin | Menambah user baru |
| `GET` | `/api/admin/users/{id}` | `auth:sanctum` + role admin | Detail user |
| `PUT` | `/api/admin/users/{id}` | `auth:sanctum` + role admin | Mengupdate user |
| `DELETE` | `/api/admin/users/{id}` | `auth:sanctum` + role admin | Menghapus user |

### 10.2 Format Respons Global

Semua *endpoint* menggunakan format respons terstandar:

**Sukses (200/201):**
```json
{
    "success": true,
    "message": "Pesan sesuai konteks",
    "data": { ... }
}
```

**Error (4xx/5xx):**
```json
{
    "success": false,
    "message": "Deskripsi error",
    "data": null
}
```

**Error Validasi (422):**
```json
{
    "success": false,
    "message": "Validasi gagal, mohon periksa inputan Anda.",
    "errors": {
        "field": ["Error message 1", "Error message 2"]
    }
}
```

### 10.3 Status Code

| Kode | Deskripsi |
|------|-----------|
| `200` | Sukses (GET, PUT) |
| `201` | Created (POST) |
| `204` | No Content (DELETE) |
| `401` | Unauthorized |
| `403` | Forbidden (bukan admin) |
| `404` | Not Found |
| `422` | Validation Error |
| `500` | Server Error |

## 11. Skema Relasi Database

### 11.1 ERD (Entity Relationship Diagram)

```
+-------------------+       +-------------------+       +---------------------------+
|      users        |       |    categories     |       |    complaints             |
+-------------------+       +-------------------+       +---------------------------+
| id (PK)           |       | id (PK)           |       | id (PK)                   |
| name              |       | name              |       | tracking_code (unique)    |
| email (unique)    |       | slug (unique)     |       | user_id (FK, nullable)    |
| password          |       | created_at        |       | category_id (FK)          |
| role (enum)       |       | updated_at        |       | title                     |
| created_at        |       +-------------------+       | description               |
| updated_at        |                                    | is_anonymous (boolean)     |
+-------------------+                                    | status (enum)             |
        | 1                                             | created_at                |
        |                                                | updated_at                |
        +--- * complaints (nullable -> anonim)           | deleted_at (soft delete)  |
                                                         +---------------------------+
                                                                   | 1
                                                                   |
                                                                   +--- * complaint_evidences
                                                                         |
                                                         +---------------------------+
                                                         | complaint_evidences       |
                                                         +---------------------------+
                                                         | id (PK)                   |
                                                         | complaint_id (FK)         |
                                                         | type (enum: image/doc/    |
                                                         |        link)              |
                                                         | file_path (nullable)      |
                                                         | url_link (nullable)       |
                                                         | created_at                |
                                                         | updated_at                |
                                                         +---------------------------+
```

### 11.2 Relasi Antar Tabel

| Tabel | Relasi | Tabel Tujuan | Keterangan |
|-------|--------|-------------|------------|
| `users` | `1 --- *` | `complaints` | Satu user bisa punya banyak aduan (nullable untuk anonim) |
| `categories` | `1 --- *` | `complaints` | Satu kategori bisa dipakai banyak aduan |
| `complaints` | `1 --- *` | `complaint_evidences` | Satu aduan bisa punya banyak bukti |

### 11.3 Detail Kolom per Tabel

**Tabel `users`** (bawaan Laravel + modifikasi)
| Kolom | Tipe | Aturan | Catatan |
|-------|------|--------|---------|
| `id` | bigint (PK) | auto increment | - |
| `name` | varchar(255) | required | - |
| `email` | varchar(255) | required, unique | - |
| `password` | varchar(255) | required | Hash |
| `role` | enum('admin','user') | default: 'user' | Ditambahkan lewat migrasi |

**Tabel `categories`**
| Kolom | Tipe | Aturan | Catatan |
|-------|------|--------|---------|
| `id` | bigint (PK) | auto increment | - |
| `name` | varchar(255) | required | Nama kategori |
| `slug` | varchar(255) | required, unique | Untuk URL/link |
| `created_at` | timestamp | - | Otomatis |
| `updated_at` | timestamp | - | Otomatis |

**Tabel `complaints`**
| Kolom | Tipe | Aturan | Catatan |
|-------|------|--------|---------|
| `id` | bigint (PK) | auto increment | - |
| `tracking_code` | varchar(255) | required, unique | Format: ADU-YYYYMM-XXXXXX |
| `user_id` | bigint (FK) | nullable | Null = anonim |
| `category_id` | bigint (FK) | required | - |
| `title` | varchar(255) | required | Judul aduan |
| `description` | text | required | Deskripsi aduan |
| `is_anonymous` | boolean | default: false | Anonim atau tidak |
| `status` | enum('pending','processing','resolved','rejected') | default: 'pending' | Status aduan |
| `created_at` | timestamp | - | Otomatis |
| `updated_at` | timestamp | - | Otomatis |
| `deleted_at` | timestamp | nullable | Soft delete |

**Tabel `complaint_evidences`**
| Kolom | Tipe | Aturan | Catatan |
|-------|------|--------|---------|
| `id` | bigint (PK) | auto increment | - |
| `complaint_id` | bigint (FK) | required, cascade on delete | - |
| `type` | enum('image','document','link') | required | Jenis bukti |
| `file_path` | varchar(255) | nullable | Path file jika image/document |
| `url_link` | varchar(255) | nullable | URL jika link |
| `created_at` | timestamp | - | Otomatis |
| `updated_at` | timestamp | - | Otomatis |

## 12. Skenario End-to-End

### Skenario A: Mahasiswa melaporkan AC rusak secara anonim (Lengkap)

| Langkah | Aksi | Endpoint | Hasil |
|---------|------|----------|-------|
| 1 | Kirim aduan tanpa login | `POST /api/complaints` | Dapat `tracking_code: ADU-202606-X8Y9Z1` |
| 2 | Cek status via kode | `GET /api/complaints/track/ADU-202606-X8Y9Z1` | Status: `pending` |
| 3 | Admin login | `POST /api/login` | Dapat token admin |
| 4 | Admin lihat daftar | `GET /api/admin/complaints?status=pending` | Lihat aduan baru |
| 5 | Admin proses aduan | `PUT /api/admin/complaints/1/status` `{status:"processing"}` | Status -> `processing` |
| 6 | Mahasiswa cek lagi | `GET /api/complaints/track/ADU-202606-X8Y9Z1` | Status: `processing`, pelapor: `Anonim` |
| 7 | Admin selesai | `PUT /api/admin/complaints/1/status` `{status:"resolved"}` | Status -> `resolved` |
| 8 | Mahasiswa cek akhir | `GET /api/complaints/track/ADU-202606-X8Y9Z1` | Status: `resolved` |

### Skenario B: Aduan ditolak karena duplikat

| Langkah | Aksi | Endpoint | Hasil |
|---------|------|----------|-------|
| 1 | Kirim aduan | `POST /api/complaints` | Dapat `tracking_code: ADU-202606-ABC123` |
| 2 | Admin login | `POST /api/login` | Dapat token admin |
| 3 | Admin lihat daftar | `GET /api/admin/complaints` | Lihat semua aduan |
| 4 | Admin tinjau dan tolak | `PUT /api/admin/complaints/2/status` `{status:"rejected"}` | Status -> `rejected` |
| 5 | Pelapor cek status | `GET /api/complaints/track/ADU-202606-ABC123` | Status: `rejected` |

### Skenario C: Error handling - Tracking code tidak ditemukan

| Langkah | Aksi | Endpoint | Hasil |
|---------|------|----------|-------|
| 1 | Pelapor salah memasukkan kode | `GET /api/complaints/track/ADU-202606-WRONG` | `404` Data tidak ditemukan |

### Skenario D: Error handling - Akses tanpa token

| Langkah | Aksi | Endpoint | Hasil |
|---------|------|----------|-------|
| 1 | Request admin tanpa login | `GET /api/admin/complaints` | `401` Unauthenticated |

### Skenario E: Error handling - Validasi gagal

| Langkah | Aksi | Endpoint | Hasil |
|---------|------|----------|-------|
| 1 | Kirim aduan tanpa judul | `POST /api/complaints` | `422` Validasi gagal, field `title` wajib diisi |

### Skenario F: Admin CRUD - Tambah kategori baru

| Langkah | Aksi | Endpoint | Hasil |
|---------|------|----------|-------|
| 1 | Admin login | `POST /api/login` | Dapat token admin |
| 2 | Tambah kategori | `POST /api/admin/categories` `{name:"Olahraga", slug:"olahraga"}` | `201` Kategori berhasil ditambahkan |
| 3 | Lihat daftar kategori | `GET /api/admin/categories` | Kategori "Olahraga" muncul di list |
| 4 | Edit kategori | `PUT /api/admin/categories/3` `{name:"Fasilitas Olahraga"}` | `200` Kategori diperbarui |
| 5 | Hapus kategori | `DELETE /api/admin/categories/3` | `200` Kategori berhasil dihapus |

### Skenario G: Admin CRUD - Kelola user

| Langkah | Aksi | Endpoint | Hasil |
|---------|------|----------|-------|
| 1 | Admin login | `POST /api/login` | Dapat token admin |
| 2 | Tambah user baru | `POST /api/admin/users` `{name:"Dosen A", role:"user"}` | `201` User ditambahkan |
| 3 | Lihat daftar user | `GET /api/admin/users` | Semua user tampil termasuk role-nya |
| 4 | Ubah role user | `PUT /api/admin/users/2` `{role:"admin"}` | `200` User diubah jadi admin |
| 5 | Hapus user | `DELETE /api/admin/users/3` | `200` User berhasil dihapus |

### Skenario H: Error handling - Non-admin akses endpoint admin

| Langkah | Aksi | Endpoint | Hasil |
|---------|------|----------|-------|
| 1 | User biasa login | `POST /api/login` (role: user) | Dapat token user |
| 2 | Akses endpoint admin | `GET /api/admin/categories` | `403` Forbidden (hanya admin) |
