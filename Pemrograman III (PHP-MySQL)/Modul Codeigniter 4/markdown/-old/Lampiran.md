
# 📎 **LAMPIRAN MODUL CODEIGNITER 4**

---

## 📂 **1. Struktur Folder Project CodeIgniter 4**

Setelah mengikuti semua bab (1–7), struktur folder proyek Anda seharusnya seperti ini:

```

santri_ci4/
│
├── app/
│   ├── Config/
│   │   ├── App.php
│   │   ├── Database.php
│   │   └── Routes.php
│   │
│   ├── Controllers/
│   │   ├── BaseController.php
│   │   ├── Dashboard.php
│   │   ├── Mahasiswa.php
│   │   └── Auth.php
│   │
│   ├── Models/
│   │   ├── MahasiswaModel.php
│   │   ├── JurusanModel.php
│   │   └── UserModel.php
│   │
│   ├── Views/
│   │   ├── layout/
│   │   │   ├── header.php
│   │   │   ├── navbar.php
│   │   │   └── footer.php
│   │   │
│   │   ├── mahasiswa/
│   │   │   ├── index.php
│   │   │   ├── create.php
│   │   │   └── edit.php
│   │   │
│   │   ├── dashboard/
│   │   │   └── index.php
│   │   │
│   │   └── auth/
│   │       ├── login.php
│   │       └── register.php
│   │
│   └── Helpers/
│       └── custom_helper.php (optional)
│
├── public/
│   ├── uploads/
│   │   └── (foto mahasiswa)
│   │
│   ├── css/
│   │   └── bootstrap.min.css
│   ├── js/
│   │   └── bootstrap.bundle.min.js
│   └── index.php
│
├── writable/
│   └── logs/
│
├── vendor/
│
├── .env
├── composer.json
└── spark
```

---

## 🧩 **2. Daftar Kode Penting**

### 🔹 `app/Config/Routes.php`

Pastikan seluruh route sudah terdaftar:

```php

$routes->get('/', 'Dashboard::index', ['filter' => 'auth']);
$routes->get('/dashboard', 'Dashboard::index', ['filter' => 'auth']);

$routes->get('/login', 'Auth::login');
$routes->post('/login', 'Auth::loginProcess');
$routes->get('/logout', 'Auth::logout');

$routes->get('/mahasiswa', 'Mahasiswa::index', ['filter' => 'auth']);
$routes->get('/mahasiswa/create', 'Mahasiswa::create', ['filter' => 'auth']);
$routes->post('/mahasiswa/store', 'Mahasiswa::store', ['filter' => 'auth']);
$routes->get('/mahasiswa/edit/(:num)', 'Mahasiswa::edit/$1', ['filter' => 'auth']);
$routes->post('/mahasiswa/update/(:num)', 'Mahasiswa::update/$1', ['filter' => 'auth']);
$routes->get('/mahasiswa/delete/(:num)', 'Mahasiswa::delete/$1', ['filter' => 'auth']);
```

---

### 🔹 `app/Controllers/Auth.php`

Controller login:

```php

<?php

namespace App\Controllers;
use App\Models\UserModel;

class Auth extends BaseController
{
    public function login()
    {
        return view('auth/login');
    }

    public function loginProcess()
    {
        $userModel = new UserModel();
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');
        $user = $userModel->where('username', $username)->first();

        if ($user && password_verify($password, $user['password'])) {
            session()->set('isLoggedIn', true);
            session()->set('user', $user);
            return redirect()->to('/dashboard');
        } else {
            return redirect()->back()->with('error', 'Username atau password salah.');
        }
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}
```

---

### 🔹 `app/Models/UserModel.php`

```php

<?php

namespace App\Models;
use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $allowedFields = ['username', 'password'];
}
```

---

### 🔹 `app/Views/auth/login.php`

```html

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Login Aplikasi</title>
  <link rel="stylesheet" href="/css/bootstrap.min.css">
</head>
<body class="bg-light">
<div class="container mt-5">
  <div class="col-md-4 offset-md-4">
    <div class="card shadow">
      <div class="card-header bg-primary text-white text-center">
        <h5>Login Sistem</h5>
      </div>
      <div class="card-body">
        <?php if(session()->getFlashdata('error')): ?>
          <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
        <?php endif; ?>

        <form method="post" action="/login">
          <div class="mb-3">
            <label>Username</label>
            <input type="text" name="username" class="form-control" required>
          </div>
          <div class="mb-3">
            <label>Password</label>
            <input type="password" name="password" class="form-control" required>
          </div>
          <button type="submit" class="btn btn-primary w-100">Masuk</button>
        </form>
      </div>
    </div>
  </div>
</div>
</body>
</html>
```

---

## 📊 **3. Contoh Tabel Database Final**

Berikut semua tabel akhir:

### 🧾 Tabel `users`

| id | username | password |
| -- | -------- | -------- |
| 1  | admin    | (bcrypt) |

### 🧾 Tabel `jurusan`

| id | nama_jurusan       | keterangan                |
| -- | ------------------ | ------------------------- |
| 1  | Teknik Informatika | Fokus pada software       |
| 2  | Sistem Informasi   | Fokus pada manajemen data |
| 3  | Teknik Komputer    | Fokus pada hardware       |

### 🧾 Tabel `mahasiswa`

| id | nama | nim | jurusan_id | alamat | foto |
| -- | ---- | --- | ---------- | ------ | ---- |

---

## 📘 **4. Konfigurasi `.env`**

Pastikan file `.env` aktif dan disesuaikan:

```

app.baseURL = 'http://localhost:8080/'
database.default.hostname = localhost
database.default.database = santri_ci4
database.default.username = root
database.default.password =
database.default.DBDriver = MySQLi
database.default.DBPrefix =
```

---

## 🧰 **5. Instalasi dan Menjalankan Project**

1. Pastikan XAMPP aktif (`Apache` dan `MySQL`).
2. Buka Command Prompt di folder project:

   ```bash

   cd c:/xampp/htdocs/santri_ci4
   composer install
   ```
3. Jalankan server bawaan CodeIgniter:

   ```bash
   
   php spark serve
   ```
4. Akses di browser:
   👉 `http://localhost:8080`

---

## 📦 **6. Troubleshooting Umum**

| Masalah           | Penyebab                          | Solusi                                        |
| ----------------- | --------------------------------- | --------------------------------------------- |
| “Class not found” | Namespace salah                   | Pastikan huruf besar/kecil sesuai dengan file |
| “404 Not Found”   | Route belum didaftarkan           | Periksa `app/Config/Routes.php`               |
| Upload gagal      | Folder `public/uploads` belum ada | Buat manual dan beri izin tulis               |
| Tidak bisa login  | Password belum di-hash            | Gunakan `password_hash()` saat insert user    |

---

## 📘 **7. Contoh Dashboard Akhir**

Berikut tampilan akhir (deskriptif):

* Navbar dengan menu: Dashboard | Mahasiswa | Jurusan | Logout
* Dashboard menampilkan:

  * Total Mahasiswa
  * Total Jurusan
  * Tabel Statistik per Jurusan
  * (Opsional) Grafik Chart.js

---

## 🧩 **8. Rangkuman Kompetensi**

| Pertemuan | Materi                   | Kompetensi Akhir                      |
| --------- | ------------------------ | ------------------------------------- |
| 1         | Instalasi & Struktur CI4 | Memahami arsitektur MVC               |
| 2         | Routing & Controller     | Membuat route dan controller dasar    |
| 3         | Model & View             | CRUD dasar tanpa relasi               |
| 4         | CRUD Mahasiswa           | Menyimpan data ke database            |
| 5         | Validasi & Upload        | Menerapkan validasi dan upload foto   |
| 6         | Login & Session          | Sistem login sederhana                |
| 7         | Join & Dashboard         | Menampilkan relasi dan statistik data |

---

## 📚 **9. Referensi Belajar Lanjutan**

1. Dokumentasi resmi CodeIgniter 4: [https://codeigniter.com/user_guide/](https://codeigniter.com/user_guide/)
2. Tutorial Bootstrap 5: [https://getbootstrap.com/docs/5.0/](https://getbootstrap.com/docs/5.0/)
3. Chart.js Documentation: [https://www.chartjs.org/docs/](https://www.chartjs.org/docs/)
4. Artikel komunitas CI4 Indonesia: [https://codeigniter.id/](https://codeigniter.id/)

