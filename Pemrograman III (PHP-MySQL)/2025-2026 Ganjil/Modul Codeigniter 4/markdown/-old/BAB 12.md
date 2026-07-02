#**BAB 12 – VALIDASI DAN UPLOAD FILE**



## **Tujuan Pembelajaran**

Setelah mengikuti pertemuan ini, mahasiswa diharapkan mampu:

1. Mengimplementasikan **validasi input** pada form CodeIgniter 4.
2. Menggunakan **flashdata** untuk menampilkan pesan error atau sukses.
3. Menambahkan **fitur upload file (foto)** pada sistem CRUD mahasiswa.
4. Mengelola file upload di folder `public/uploads`.
5. Memahami konsep **security dan sanitasi input** di CodeIgniter 4.



## **Pendahuluan**

Validasi dan upload file adalah dua fitur penting dalam pengembangan aplikasi web.

* **Validasi** memastikan data yang dikirim oleh pengguna memenuhi aturan tertentu.
* **Upload file** memungkinkan pengguna mengirim berkas seperti gambar, dokumen, atau video ke server.

Dalam CodeIgniter 4, kedua fitur ini sudah didukung secara **built-in**, sehingga implementasinya cukup mudah menggunakan class `Validation` dan `File Upload`.


## **Langkah-Langkah Praktikum**

### 1. Menambahkan Kolom Foto pada Database

Buka **phpMyAdmin**, kemudian ubah tabel `mahasiswa`:

```sql

ALTER TABLE mahasiswa ADD COLUMN foto VARCHAR(255) DEFAULT NULL AFTER alamat;
```

---

### 2. Mengatur Folder Upload

Buat folder baru di dalam project:

```
public/uploads
```

Pastikan folder ini bisa diakses dan memiliki permission **write (tulis)**.

---

### 3. Mengubah Model Mahasiswa

Buka file:

```
app/Models/MahasiswaModel.php
```

Ubah bagian `allowedFields` menjadi:

```php

protected $allowedFields = ['nama', 'nim', 'jurusan', 'alamat', 'foto'];
```

---

### 4. Menambahkan Validasi di Controller

Buka file:

```
app/Controllers/Mahasiswa.php
```

Ubah method `store()` dan `update()` agar memiliki validasi dan fitur upload foto:

```php

public function store()
{
    $validation = \Config\Services::validation();

    $rules = [
        'nama' => 'required|min_length[3]',
        'nim' => 'required|numeric|is_unique[mahasiswa.nim]',
        'jurusan' => 'required',
        'foto' => 'uploaded[foto]|is_image[foto]|mime_in[foto,image/jpg,image/jpeg,image/png]|max_size[foto,2048]',
    ];

    if (!$this->validate($rules)) {
        return redirect()->back()->withInput()->with('errors', $validation->getErrors());
    }

    $file = $this->request->getFile('foto');
    $namaFile = $file->getRandomName();
    $file->move('uploads', $namaFile);

    $this->mahasiswa->insert([
        'nama' => $this->request->getPost('nama'),
        'nim' => $this->request->getPost('nim'),
        'jurusan' => $this->request->getPost('jurusan'),
        'alamat' => $this->request->getPost('alamat'),
        'foto' => $namaFile,
    ]);

    return redirect()->to('/mahasiswa')->with('success', 'Data berhasil ditambahkan!');
}
```

---

### 5. Update Method `update()` untuk Upload Baru

Tambahkan pengecekan jika user tidak mengganti foto:

```php

public function update($id)
{
    $validation = \Config\Services::validation();

    $rules = [
        'nama' => 'required|min_length[3]',
        'nim' => "required|numeric|is_unique[mahasiswa.nim,id,{$id}]",
        'jurusan' => 'required',
        'foto' => 'is_image[foto]|mime_in[foto,image/jpg,image/jpeg,image/png]|max_size[foto,2048]',
    ];

    if (!$this->validate($rules)) {
        return redirect()->back()->withInput()->with('errors', $validation->getErrors());
    }

    $data = [
        'nama' => $this->request->getPost('nama'),
        'nim' => $this->request->getPost('nim'),
        'jurusan' => $this->request->getPost('jurusan'),
        'alamat' => $this->request->getPost('alamat'),
    ];

    $file = $this->request->getFile('foto');
    if ($file->isValid() && !$file->hasMoved()) {
        $namaFile = $file->getRandomName();
        $file->move('uploads', $namaFile);
        $data['foto'] = $namaFile;
    }

    $this->mahasiswa->update($id, $data);

    return redirect()->to('/mahasiswa')->with('success', 'Data berhasil diperbarui!');
}
```

---

### 6. Menambahkan Flashdata Error ke View

#### 📄 Ubah file: `app/Views/mahasiswa/create.php`

Tambahkan di atas form:

```php

<?php if (session()->getFlashdata('errors')): ?>
  <div class="alert alert-danger">
    <ul>
      <?php foreach (session()->getFlashdata('errors') as $error): ?>
        <li><?= esc($error) ?></li>
      <?php endforeach; ?>
    </ul>
  </div>
<?php endif; ?>
```

Tambahkan input file:

```html

<div class="mb-3">
  <label>Foto</label>
  <input type="file" name="foto" class="form-control">
</div>
```

Pastikan form mendukung upload:

```html

<form action="/mahasiswa/store" method="post" enctype="multipart/form-data">
```

---

#### 📄 Ubah file: `app/Views/mahasiswa/edit.php`

Tambahkan:

```html

<div class="mb-3">
  <label>Foto</label><br>
  <img src="/uploads/<?= $mahasiswa['foto'] ?>" alt="Foto Mahasiswa" width="100"><br>
  <input type="file" name="foto" class="form-control mt-2">
</div>
```

---

#### 📄 Ubah file: `app/Views/mahasiswa/index.php`

Tambahkan kolom **Foto** di tabel:

```php

<th>Foto</th>
```

Lalu di baris data:

```php

<td>
  <?php if ($m['foto']): ?>
    <img src="/uploads/<?= $m['foto'] ?>" width="50">
  <?php else: ?>
    <span class="text-muted">-</span>
  <?php endif; ?>
</td>
```

---

## 🧪 **Uji Coba**

1. Jalankan server:

   ```
   
   php spark serve
   ```
2. Akses halaman:
   👉 `http://localhost:8080/mahasiswa`
3. Tambahkan data baru dengan mengunggah foto.
4. Pastikan:

   * Validasi muncul jika ada input kosong.
   * Foto tersimpan di folder `public/uploads`.
   * Flashdata pesan sukses tampil setelah menambah atau mengedit data.

---

## 🧩 **Latihan Mahasiswa**

1. Tambahkan validasi agar **NIM minimal 8 digit dan unik**.
2. Batasi format foto hanya **JPG dan PNG** maksimal **2 MB**.
3. Tambahkan kolom “Tanggal Lahir” dan tampilkan formatnya seperti `12 Oktober 2025`.

---

## 💬 **Tugas Praktikum**

Buat **CRUD Data Santri** dengan validasi dan upload foto:

* Kolom: `nama`, `nis`, `kelas`, `alamat`, `foto`.
* Gunakan flashdata untuk menampilkan pesan sukses/gagal.
* Tampilkan foto di tabel daftar santri.

---

## 💡 **Tips Tambahan**

* Gunakan helper `esc()` untuk mencegah XSS pada tampilan data.
* Jangan menyimpan file upload di folder `app/`, karena folder itu tidak bisa diakses langsung oleh browser.
* Gunakan nama acak (`getRandomName()`) untuk menghindari bentrok nama file.
