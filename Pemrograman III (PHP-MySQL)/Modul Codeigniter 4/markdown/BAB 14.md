
# **BAB 14 – CRUD Join Tabel dan Dashboard**

---

## **Tujuan Pembelajaran**

Setelah mempelajari bab ini, mahasiswa diharapkan mampu:

1. Membuat **relasi antar tabel** di database (misalnya *mahasiswa – jurusan*).
2. Menggunakan **JOIN** dalam Model CodeIgniter 4 untuk menampilkan data gabungan.
3. Menyajikan data **statistik dan ringkasan** di halaman dashboard.
4. Menggunakan fungsi agregasi (COUNT, SUM, AVG) untuk membuat laporan sederhana.

---

## **Konsep Dasar Relasi dan JOIN**

### 1. Relasi Antar Tabel

Dalam sistem akademik, setiap mahasiswa memiliki **jurusan**.
Artinya, tabel `mahasiswa` akan menyimpan `jurusan_id` yang terhubung dengan tabel `jurusan`.

Jenis relasi yang umum:

* **One to Many (1–N)** → satu jurusan memiliki banyak mahasiswa.
* **One to One (1–1)** → satu santri memiliki satu akun pengguna.
* **Many to Many (N–N)** → satu santri bisa ikut banyak kegiatan (biasanya butuh tabel pivot).

### 2. JOIN

`JOIN` digunakan untuk mengambil data dari dua tabel sekaligus berdasarkan kolom yang saling berhubungan.
Contoh:

```sql

SELECT mahasiswa.nama, jurusan.nama_jurusan
FROM mahasiswa
JOIN jurusan ON jurusan.id = mahasiswa.jurusan_id;
```

---

## **Langkah-Langkah Praktikum**

### 1. Menambah Tabel Jurusan

Masuk ke phpMyAdmin, jalankan SQL berikut:

```sql

CREATE TABLE jurusan (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nama_jurusan VARCHAR(100) NOT NULL,
  keterangan TEXT
);
```

Isi beberapa data contoh:

```sql

INSERT INTO jurusan (nama_jurusan, keterangan) VALUES
('Teknik Informatika', 'Fokus pada pengembangan software dan sistem komputer'),
('Sistem Informasi', 'Menggabungkan teknologi dan manajemen informasi'),
('Teknik Komputer', 'Fokus pada perangkat keras dan jaringan komputer');
```

---

### 2. Tambahkan Kolom Relasi di Tabel Mahasiswa

Tambahkan kolom `jurusan_id` pada tabel mahasiswa:

```sql

ALTER TABLE mahasiswa ADD jurusan_id INT AFTER alamat;
```

Isi nilai jurusan_id sesuai data yang ada:

```sql

UPDATE mahasiswa SET jurusan_id = 1 WHERE id <= 3;
UPDATE mahasiswa SET jurusan_id = 2 WHERE id > 3 AND id <= 6;
UPDATE mahasiswa SET jurusan_id = 3 WHERE id > 6;
```

---

### 3. Membuat Model Jurusan

Buat file:

```

app/Models/JurusanModel.php
```

Isi dengan:

```php

<?php

namespace App\Models;
use CodeIgniter\Model;

class JurusanModel extends Model
{
    protected $table = 'jurusan';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nama_jurusan', 'keterangan'];
}
```

---

### 4. Modifikasi Model Mahasiswa untuk JOIN

Buka file:

```
app/Models/MahasiswaModel.php
```

Tambahkan fungsi baru:

```php

public function getMahasiswaWithJurusan()
{
    return $this->select('mahasiswa.*, jurusan.nama_jurusan')
                ->join('jurusan', 'jurusan.id = mahasiswa.jurusan_id', 'left')
                ->findAll();
}
```

---

### 5. Modifikasi Controller Mahasiswa

Buka file:

```

app/Controllers/Mahasiswa.php
```

Ubah fungsi `index()` menjadi:

```php

public function index()
{
    $model = new MahasiswaModel();
    $data['mahasiswa'] = $model->getMahasiswaWithJurusan();
    return view('mahasiswa/index', $data);
}
```

Dan di `create()` serta `edit()`, tambahkan data jurusan:

```php

public function create()
{
    $jurusanModel = new \App\Models\JurusanModel();
    $data['jurusan'] = $jurusanModel->findAll();
    return view('mahasiswa/create', $data);
}
```

---

### 6. Modifikasi Form Tambah/Edit Mahasiswa

Buka:

```

app/Views/mahasiswa/create.php
```

Tambahkan dropdown jurusan:

```html

<div class="mb-3">
  <label>Jurusan</label>
  <select name="jurusan_id" class="form-select" required>
    <option value="">-- Pilih Jurusan --</option>
    <?php foreach ($jurusan as $j): ?>
      <option value="<?= $j['id'] ?>"><?= $j['nama_jurusan'] ?></option>
    <?php endforeach; ?>
  </select>
</div>
```

---

### 7. Tampilkan Nama Jurusan di Daftar Mahasiswa

Buka file:

```

app/Views/mahasiswa/index.php
```

Tambahkan kolom baru:

```html

<th>Jurusan</th>
```

dan pada data baris:

```html

<td><?= $m['nama_jurusan'] ?></td>
```

---

### 8. Membuat Dashboard Statistik

Buka file:

```

app/Controllers/Dashboard.php
```

Ubah fungsi `index()` menjadi:

```php

public function index()
{
    $db = \Config\Database::connect();

    $totalMahasiswa = $db->table('mahasiswa')->countAllResults();
    $totalJurusan   = $db->table('jurusan')->countAllResults();

    $query = $db->query("SELECT jurusan.nama_jurusan, COUNT(mahasiswa.id) as jumlah
                         FROM jurusan 
                         LEFT JOIN mahasiswa ON jurusan.id = mahasiswa.jurusan_id
                         GROUP BY jurusan.id");

    $statistik = $query->getResultArray();

    return view('dashboard/index', [
        'totalMahasiswa' => $totalMahasiswa,
        'totalJurusan' => $totalJurusan,
        'statistik' => $statistik
    ]);
}
```

---

### 9. Modifikasi Tampilan Dashboard

Buka file:

```

app/Views/dashboard/index.php
```

Tambahkan elemen berikut:

```html

<div class="row mt-4">
  <div class="col-md-3">
    <div class="card bg-primary text-white text-center p-3 shadow-sm">
      <h5>Total Mahasiswa</h5>
      <h3><?= $totalMahasiswa ?></h3>
    </div>
  </div>
  <div class="col-md-3">
    <div class="card bg-success text-white text-center p-3 shadow-sm">
      <h5>Total Jurusan</h5>
      <h3><?= $totalJurusan ?></h3>
    </div>
  </div>
</div>

<h5 class="mt-5">📊 Statistik Mahasiswa per Jurusan</h5>
<table class="table table-striped mt-3">
  <thead class="table-dark">
    <tr>
      <th>Nama Jurusan</th>
      <th>Jumlah Mahasiswa</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($statistik as $s): ?>
      <tr>
        <td><?= $s['nama_jurusan'] ?></td>
        <td><?= $s['jumlah'] ?></td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>
```

---

## 🧩 **Uji Coba**

1. Jalankan server:

   ```bash

   php spark serve
   ```
2. Akses `http://localhost:8080/mahasiswa`
   Pastikan kolom jurusan tampil di daftar mahasiswa.
3. Tambah data mahasiswa baru dengan memilih jurusan.
4. Akses `http://localhost:8080/dashboard`
   Lihat tampilan statistik total mahasiswa dan jurusan.

---

## 💬 **Latihan Mahasiswa**

1. Tambahkan **grafik batang** jumlah mahasiswa per jurusan menggunakan Chart.js.
2. Buat halaman **daftar jurusan**, lengkap dengan fitur tambah, edit, hapus.
3. Tambahkan filter pencarian mahasiswa berdasarkan jurusan di halaman daftar mahasiswa.
