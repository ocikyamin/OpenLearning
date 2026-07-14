# Tugas 7 — Authentication & Middleware

---

## Tujuan

Mahasiswa mampu mengimplementasikan otentikasi (login/register) dan otorisasi (policy & role) menggunakan Laravel Breeze, middleware, Gate, dan Policy.

---

## Soal

### 1. Persiapan

Buat project baru dengan Breeze dan database MySQL `db_tugas7`.

```bash
composer create-project laravel/laravel tugas-auth
cd tugas-auth
composer require laravel/breeze
php artisan breeze:install blade
npm install && npm run build
```

Buat database:

```sql
CREATE DATABASE db_tugas7 CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

Jalankan migrasi: `php artisan migrate`

### 2. Migration

Buat migrasi untuk tabel **projects**:

| Kolom | Tipe | Keterangan |
|-------|------|------------|
| `id` | auto-increment | Primary key |
| `title` | string(150) | Judul project |
| `description` | text | Deskripsi, nullable |
| `status` | string(20) | Default 'planning' |
| `deadline` | date | Tenggat waktu, nullable |
| `is_completed` | boolean | Default false |
| `user_id` | foreign key | Foreign key ke users |
| `timestamps` | — | — |

Juga buat migrasi untuk menambah kolom `role` di tabel users:

```php
$table->string('role')->default('user');
```

### 3. Model & Role

**Model Project** — dengan `$fillable`, `casts()`, relasi `user()`.

**Model User** — tambahkan method helper:
- `isAdmin(): bool` — role === 'admin'
- `isManager(): bool` — role === 'manager'

### 4. ProjectPolicy

Buat policy dengan method:

| Method | Aturan |
|--------|--------|
| `viewAny(User $user)` | true (semua user bisa lihat daftar) |
| `create(User $user)` | true (semua user bisa buat) |
| `update(User $user, Project $project)` | hanya pemilik atau admin/manager |
| `delete(User $user, Project $project)` | hanya pemilik atau admin |

Daftarkan policy di `AppServiceProvider`.

### 5. Middleware CheckRole

Buat middleware `CheckRole` yang menerima parameter role. Daftarkan dengan alias `role`.

Jika user tidak memiliki role yang sesuai, kembalikan response 403.

### 6. Route

| URL | Middleware | Keterangan |
|-----|-----------|------------|
| `/projects` | `auth` | Resource controller penuh |
| `/admin` | `auth`, `role:admin` | Halaman admin sederhana |
| `/manager/projects` | `auth`, `role:manager` | Lihat semua project (milik siapa pun) |

### 7. Controller

Buat `ProjectController` lengkap (resource):
- Setiap operasi update/delete harus diproteksi dengan `Gate::authorize()`
- Manager bisa melihat semua project di `/manager/projects`
- Di halaman daftar, hanya tampilkan tombol Edit/Hapus jika user diizinkan oleh Policy

Buat `AdminController` sederhana untuk halaman admin.

### 8. View

Buat halaman berikut:

**Daftar Project** (`/projects`):
- Tabel: No, Judul, Status, Deadline, Pemilik, Aksi
- Tombol "Buat Project"
- Tombol Edit/Hapus hanya muncul jika `@can('update', $project)` / `@can('delete', $project)`

**Form Buat/Edit Project:**
- Field: title, description, status (select: planning, active, completed, archived), deadline (date)
- Validasi lengkap dengan Form Request atau validate()
- Tampilkan error dan old input

**Detail Project** (`/projects/{project}`):
- Semua informasi project
- Tombol Edit/Hapus jika authorized

**Halaman Admin** (`/admin`):
- Tampilkan "Panel Admin" dan daftar semua user (nama, email, role)
- Sederhana saja

**Halaman Manager** (`/manager/projects`):
- Tampilkan semua project (milik user mana pun)
- Tidak perlu tombol edit/hapus

### 9. Seeder

Buat seeder yang membuat:
1. Admin: `admin@example.com` role 'admin'
2. Manager: `manager@example.com` role 'manager'
3. User biasa: `user@example.com` role 'user'
4. 10 project (milik acak dari ketiga user di atas)

---

## Ketentuan Pengumpulan

- Kumpulkan: migration, model, policy, middleware, controller, route, semua view, seeder
- Screenshot: hasil register dan login sebagai user berbeda, buat/edit/hapus project sebagai pemilik vs bukan pemilik, akses halaman admin/manager

---

## Rubrik Penilaian

| Aspek | Bobot |
|-------|-------|
| Breeze + Migration (termasuk kolom role) | 15% |
| Policy (update: pemilik/admin, delete: pemilik/admin) | 20% |
| Middleware CheckRole (admin, manager) | 15% |
| Controller + Gate::authorize() | 20% |
| View (tabel, form, otorisasi tombol) | 20% |
| Seeder (3 user + 10 project) | 10% |
