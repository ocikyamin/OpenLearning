# **BAB 11 – CRUD DASAR (Create, Read, Update, Delete)**

---

## **Tujuan Pembelajaran**

Setelah mengikuti pertemuan ini, mahasiswa mampu:

1. Membuat tabel database dan model yang sesuai.
2. Membuat form input data menggunakan Bootstrap.
3. Menampilkan data dari database dalam bentuk tabel.
4. Mengedit dan menghapus data menggunakan Controller.
5. Memahami alur kerja CRUD (Create, Read, Update, Delete) di CodeIgniter 4.

---

## **Konsep Dasar CRUD**

CRUD adalah singkatan dari empat operasi utama dalam pengelolaan data:

* **Create** → Menambah data baru ke database.
* **Read** → Menampilkan data dari database.
* **Update** → Mengubah data yang sudah ada.
* **Delete** → Menghapus data dari database.

Di CodeIgniter 4, operasi CRUD biasanya dilakukan melalui **Model** yang berinteraksi dengan database, sedangkan **Controller** berperan mengatur alur logika, dan **View** menampilkan hasil ke pengguna.

---

## **Langkah-Langkah Praktikum**

### 1. Membuat Tabel Database

Buka **phpMyAdmin**, lalu buat database dengan nama:

```sql

CREATE DATABASE ci4_mahasiswa;
USE ci4_mahasiswa;

CREATE TABLE mahasiswa (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nama VARCHAR(100) NOT NULL,
  nim VARCHAR(20) NOT NULL UNIQUE,
  jurusan VARCHAR(100) NOT NULL,
  alamat TEXT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

---

### 2. Mengatur Koneksi Database

Buka file:

```

app/Config/Database.php
```

Cari bagian:

```php

public $default = [
    'DSN'      => '',
    'hostname' => 'localhost',
    'username' => 'root',
    'password' => '',
    'database' => 'ci4_mahasiswa',
    'DBDriver' => 'MySQLi',
    'DBPrefix' => '',
    'pConnect' => false,
    'DBDebug'  => (ENVIRONMENT !== 'production'),
    'charset'  => 'utf8',
    'DBCollat' => 'utf8_general_ci',
    'swapPre'  => '',
    'encrypt'  => false,
    'compress' => false,
    'strictOn' => false,
    'failover' => [],
    'port'     => 3306,
];
```

---

### 3. Membuat Model

Buat file baru:

```

app/Models/MahasiswaModel.php
```

Isi dengan kode berikut:

```php

<?php

namespace App\Models;
use CodeIgniter\Model;

class MahasiswaModel extends Model
{
    protected $table = 'mahasiswa';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nama', 'nim', 'jurusan', 'alamat'];
}
```

Model ini akan digunakan untuk berinteraksi dengan tabel `mahasiswa`.

---

### 4. Membuat Controller

Buat file baru:

```
app/Controllers/Mahasiswa.php
```

Isi dengan kode:

```php

<?php

namespace App\Controllers;
use App\Models\MahasiswaModel;

class Mahasiswa extends BaseController
{
    protected $mahasiswa;

    public function __construct()
    {
        $this->mahasiswa = new MahasiswaModel();
    }

    public function index()
    {
        $data['mahasiswa'] = $this->mahasiswa->findAll();
        return view('mahasiswa/index', $data);
    }

    public function create()
    {
        return view('mahasiswa/create');
    }

    public function store()
    {
        $this->mahasiswa->insert([
            'nama' => $this->request->getPost('nama'),
            'nim' => $this->request->getPost('nim'),
            'jurusan' => $this->request->getPost('jurusan'),
            'alamat' => $this->request->getPost('alamat'),
        ]);
        return redirect()->to('/mahasiswa')->with('success', 'Data berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $data['mahasiswa'] = $this->mahasiswa->find($id);
        return view('mahasiswa/edit', $data);
    }

    public function update($id)
    {
        $this->mahasiswa->update($id, [
            'nama' => $this->request->getPost('nama'),
            'nim' => $this->request->getPost('nim'),
            'jurusan' => $this->request->getPost('jurusan'),
            'alamat' => $this->request->getPost('alamat'),
        ]);
        return redirect()->to('/mahasiswa')->with('success', 'Data berhasil diperbarui!');
    }

    public function delete($id)
    {
        $this->mahasiswa->delete($id);
        return redirect()->to('/mahasiswa')->with('success', 'Data berhasil dihapus!');
    }
}
```

---

### 5. Menambahkan Routing

Buka file:

```
app/Config/Routes.php
```

Tambahkan baris berikut di dalam `$routes`:

```php

$routes->get('/mahasiswa', 'Mahasiswa::index');
$routes->get('/mahasiswa/create', 'Mahasiswa::create');
$routes->post('/mahasiswa/store', 'Mahasiswa::store');
$routes->get('/mahasiswa/edit/(:num)', 'Mahasiswa::edit/$1');
$routes->post('/mahasiswa/update/(:num)', 'Mahasiswa::update/$1');
$routes->get('/mahasiswa/delete/(:num)', 'Mahasiswa::delete/$1');
```

---

### 6. Membuat View

#### 📄 File: `app/Views/layouts/header.php`

```html

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>CRUD Mahasiswa</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
```

#### 📄 File: `app/Views/layouts/footer.php`

```html

</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
```

---

#### 📄 File: `app/Views/mahasiswa/index.php`

```php

<?= $this->include('layouts/header') ?>

<h2>Data Mahasiswa</h2>

<a href="/mahasiswa/create" class="btn btn-primary mb-3">+ Tambah Data</a>

<?php if (session()->getFlashdata('success')) : ?>
  <div class="alert alert-success">
    <?= session()->getFlashdata('success') ?>
  </div>
<?php endif; ?>

<table class="table table-bordered table-striped">
  <thead class="table-dark">
    <tr>
      <th>No</th>
      <th>Nama</th>
      <th>NIM</th>
      <th>Jurusan</th>
      <th>Alamat</th>
      <th>Aksi</th>
    </tr>
  </thead>
  <tbody>
    <?php $no = 1; foreach ($mahasiswa as $m): ?>
      <tr>
        <td><?= $no++ ?></td>
        <td><?= $m['nama'] ?></td>
        <td><?= $m['nim'] ?></td>
        <td><?= $m['jurusan'] ?></td>
        <td><?= $m['alamat'] ?></td>
        <td>
          <a href="/mahasiswa/edit/<?= $m['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
          <a href="/mahasiswa/delete/<?= $m['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus data ini?')">Hapus</a>
        </td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>

<?= $this->include('layouts/footer') ?>
```

---

#### 📄 File: `app/Views/mahasiswa/create.php`

```php

<?= $this->include('layouts/header') ?>

<h3>Tambah Data Mahasiswa</h3>

<form action="/mahasiswa/store" method="post">
  <div class="mb-3">
    <label>Nama</label>
    <input type="text" name="nama" class="form-control" required>
  </div>
  <div class="mb-3">
    <label>NIM</label>
    <input type="text" name="nim" class="form-control" required>
  </div>
  <div class="mb-3">
    <label>Jurusan</label>
    <input type="text" name="jurusan" class="form-control" required>
  </div>
  <div class="mb-3">
    <label>Alamat</label>
    <textarea name="alamat" class="form-control"></textarea>
  </div>
  <button class="btn btn-success">Simpan</button>
  <a href="/mahasiswa" class="btn btn-secondary">Kembali</a>
</form>

<?= $this->include('layouts/footer') ?>
```

---

#### 📄 File: `app/Views/mahasiswa/edit.php`

```php

<?= $this->include('layouts/header') ?>

<h3>Edit Data Mahasiswa</h3>

<form action="/mahasiswa/update/<?= $mahasiswa['id'] ?>" method="post">
  <div class="mb-3">
    <label>Nama</label>
    <input type="text" name="nama" class="form-control" value="<?= $mahasiswa['nama'] ?>" required>
  </div>
  <div class="mb-3">
    <label>NIM</label>
    <input type="text" name="nim" class="form-control" value="<?= $mahasiswa['nim'] ?>" required>
  </div>
  <div class="mb-3">
    <label>Jurusan</label>
    <input type="text" name="jurusan" class="form-control" value="<?= $mahasiswa['jurusan'] ?>" required>
  </div>
  <div class="mb-3">
    <label>Alamat</label>
    <textarea name="alamat" class="form-control"><?= $mahasiswa['alamat'] ?></textarea>
  </div>
  <button class="btn btn-warning">Update</button>
  <a href="/mahasiswa" class="btn btn-secondary">Kembali</a>
</form>

<?= $this->include('layouts/footer') ?>
```

---

## 🧩 **Latihan Mahasiswa**

1. Ubah kolom `jurusan` menjadi dropdown dengan pilihan seperti:

   * Informatika
   * Sistem Informasi
   * Manajemen Informatika

2. Tambahkan kolom baru `email` pada tabel `mahasiswa` dan tampilkan di view.

3. Ubah tombol “Hapus” menjadi modal konfirmasi Bootstrap agar tampilan lebih menarik.

---

## **Tugas Individu**

Buat **CRUD Data Dosen** dengan kolom berikut:

* `id`, `nama`, `nidn`, `mata_kuliah`, `no_hp`

Gunakan konsep yang sama seperti modul ini dan tampilkan dalam tampilan tabel Bootstrap.
