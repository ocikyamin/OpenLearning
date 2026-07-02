## Product Requirements Document (PRD): TaskFlow System

## 1. Project Overview
TaskFlow adalah aplikasi manajemen tugas berbasis web yang memungkinkan pengguna untuk mengatur proyek, melacak daftar tugas, dan mengelola prioritas secara efisien. Sistem ini menggunakan arsitektur Decoupled (Terpisah) dengan Laravel sebagai REST API dan Vue.js sebagai Single Page Application (SPA).
## 2. Tech Stack Standard

* Backend: Laravel 13.x (PHP 8.3+)
* Frontend: Vue.js 3/4 (Composition API)
* State Management: Pinia (untuk Vue)
* Database: MySQL / PostgreSQL
* API Standard: RESTful API dengan JSON Response (CamelCase)
* Authentication: Laravel Sanctum (Token Based)

## 3. User Personas

* Personal User: Individu yang ingin mencatat tugas harian dan membaginya ke dalam beberapa proyek.

## 4. Functional Requirements (Fitur Utama)

## M1: Authentication & User Profile

* Registration: User dapat mendaftar dengan nama, email, dan password.
* Login: User mendapatkan token untuk akses API.
* Logout: Revoke token akses.

## M2: Project Management

* Create Project: Membuat wadah tugas dengan nama, deskripsi, dan label warna.
* View Projects: Menampilkan daftar semua proyek milik user tersebut.
* Update/Delete Project: Mengubah detail atau menghapus proyek (Cascading delete ke tugas terkait).

## M3: Task Management (Core)

* Create Task: Menambahkan tugas ke dalam proyek tertentu.
* Task Properties: Judul, Deskripsi, Tanggal Jatuh Tempo (Deadline), Prioritas (Low, Medium, High).
* Status Update: Mengubah status tugas (todo, in_progress, completed).
* Filtering: Filter tugas berdasarkan status atau prioritas di dalam satu proyek.

## M4: Tagging System (Many-to-Many)

* Manage Tags: Membuat label kategori (misal: "Urgent", "Work", "Personal").
* Assign Tags: Menempelkan satu atau lebih tag ke dalam satu tugas.

## 5. Data Schema (Entity Relationship)

| Entity| Attributes | Relations |
|---|---|---|
| User | id, name, email, password | HasMany Projects, HasMany Tasks |
| Project | id, user_id, name, description, color | BelongsTo User, HasMany Tasks |
| Task | id, project_id, user_id, title, description, due_date, priority, status | BelongsTo Project, BelongsToMany Tags |
| Tag | id, name, color | BelongsToMany Tasks |

## 6. API Contract (Contoh Endpoint Utama)

| Method | Endpoint | Description |
|---|---|---|
| POST | /api/login | Mendapatkan token akses. |
| GET | /api/projects | Mengambil semua proyek user. |
| POST | /api/projects | Membuat proyek baru. |
| GET | /api/projects/{id}/tasks | Mengambil semua tugas dalam proyek tertentu. |
| PATCH | /api/tasks/{id}/status | Mengupdate status tugas (Todo -> Done). |

## 7. User Interface (UI) Requirements

   1. Dashboard: Menampilkan statistik singkat (Jumlah tugas selesai vs tertunda).
   2. Sidebar: Daftar proyek untuk navigasi cepat.
   3. Task Board: Tampilan daftar tugas dengan indikator warna berdasarkan prioritas.
   4. Form Modal: Input data tanpa berpindah halaman menggunakan Vue components.

## 8. Business Rules & Constraints

* Data Isolation: User tidak boleh melihat proyek atau tugas milik user lain.
* Validation: Judul tugas wajib diisi (min 5 karakter). Tanggal jatuh tempo tidak boleh di masa lalu.
* Consistency: API Resource harus selalu mengembalikan format camelCase (misal: due_date di DB menjadi dueDate di JSON).

<!-- ------------------------------
## 💡 Contoh Instruksi Selanjutnya untuk Anda:
Anda bisa memberikan PRD ini ke OpenCode AI dengan perintah:

"Berdasarkan PRD TaskFlow ini, buatkan file migrations dan models Laravel yang sesuai, lengkap dengan relasi Eloquent-nya."

Setelah itu, lanjutkan dengan:

"Sekarang buatkan API Resources dan Controllers yang menangani CRUD sesuai endpoint di PRD ini." -->
