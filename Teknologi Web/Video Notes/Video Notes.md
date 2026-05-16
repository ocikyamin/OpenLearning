# CRUD AJAX CodeIgniter4
> Oleh : Abdul Yamin

Menggunakan:

* CodeIgniter 4
* jQuery AJAX
* Bootstrap 5

Database:

* tabel `users`

---

# Struktur Project

```text id="jthc3z"
app/
├── Controllers/
│   └── UserController.php
│
├── Models/
│   └── UserModel.php
│
├── Views/
│   └── Users/
│       ├── index.php
│       ├── list.php
│       ├── form_add.php
│       └── form_edit.php
```

---

# DATABASE

## SQL Table

```sql id="gcnz0n"
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP
    ON UPDATE CURRENT_TIMESTAMP
);
```

---

# MODEL

## app/Models/UserModel.php

```php id="4pbb7l"
<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';

    protected $primaryKey = 'id';

    protected $allowedFields = [
        'name',
        'email'
    ];

    protected $useTimestamps = true;
}
```

---

# PART 1 — READ DATA AJAX

# Tujuan

Menampilkan data user tanpa reload halaman.

---

# STEP 1 — Routes

## app/Config/Routes.php

```php id="xy16x2"
$routes->get('user', 'UserController::index');

$routes->get('user/list', 'UserController::list');
```

---

# STEP 2 — Controller

## app/Controllers/UserController.php

```php id="g97mb9"
<?php

namespace App\Controllers;

use App\Models\UserModel;

class UserController extends BaseController
{
    public function index()
    {
        return view('Users/index');
    }

    // Menampilkan Data User
    public function list()
    {
        $userModel = new UserModel();

        $data = [
            'users' => $userModel->findAll()
        ];

        $response = [
            'user' => view('Users/list', $data)
        ];

        return $this->response->setJSON($response);
    }
}
```

---

# STEP 3 — index.php

## app/Views/Users/index.php

```php id="vd2op8"
<?= $this->extend('Layout') ?>
<?= $this->section('isi') ?>

<div class="card mt-4">

    <div class="card-body">

        <div class="alert bg-light">

            <button class="btn btn-primary btn-sm">
                New User
            </button>

        </div>

        <div id="content"></div>

    </div>

</div>

<script>

$(document).ready(function(){

    loadUserData();

});

function loadUserData()
{
    $.ajax({

        type: "GET",

        url: "<?= base_url('user/list') ?>",

        dataType: "json",

        success: function(res){

            $('#content').html(res.user);

        }

    });
}

</script>

<?= $this->endSection() ?>
```

---

# STEP 4 — list.php

## app/Views/Users/list.php

```php id="hmqqv6"
<table class="table table-sm table-striped table-hover">

    <thead>

        <tr>
            <th>No</th>
            <th>Email</th>
            <th>Fullname</th>
            <th>Action</th>
        </tr>

    </thead>

    <tbody>

        <?php
        $no = 1;

        foreach($users as $user){ ?>

        <tr>

            <td><?= $no++ ?>.</td>

            <td><?= $user['email'] ?></td>

            <td><?= $user['name'] ?></td>

            <td>

                <button class="btn btn-info btn-sm">
                    Edit
                </button>

                <button class="btn btn-danger btn-sm">
                    Delete
                </button>

            </td>

        </tr>

        <?php } ?>

    </tbody>

</table>
```

---

# HASIL PART 1

```text id="9bl0gm"
Data berhasil tampil tanpa reload halaman
```

---

# PART 2 — TAMBAH DATA AJAX

# Tujuan

Menambah data menggunakan modal Bootstrap dan AJAX.

---

# STEP 1 — Routes

Tambahkan:

```php id="zw1n0x"
$routes->get('user/form-add', 'UserController::formAdd');

$routes->post('user/store', 'UserController::store');
```

---

# STEP 2 — Controller

Tambahkan di `UserController.php`

```php id="4lj6y7"
// Form Tambah
public function formAdd()
{
    $response = [
        'form' => view('Users/form_add')
    ];

    return $this->response->setJSON($response);
}


// Simpan Data
public function store()
{
    $userModel = new UserModel();

    $userModel->insert([
        'name'  => $this->request->getPost('name'),
        'email' => $this->request->getPost('email')
    ]);

    return $this->response->setJSON([
        'status' => true
    ]);
}
```

---

# STEP 3 — form_add.php

## app/Views/Users/form_add.php

```php id="0evllv"
<div class="modal fade" id="modalAdd">

    <div class="modal-dialog">

        <div class="modal-content">

            <div class="modal-header">
                <h5>Add User</h5>
            </div>

            <div class="modal-body">

                <form id="formAdd">

                    <div class="mb-3">

                        <label>Fullname</label>

                        <input type="text"
                            name="name"
                            class="form-control">

                    </div>

                    <div class="mb-3">

                        <label>Email</label>

                        <input type="email"
                            name="email"
                            class="form-control">

                    </div>

                </form>

            </div>

            <div class="modal-footer">

                <button type="button"
                    class="btn btn-secondary"
                    data-bs-dismiss="modal">
                    Close
                </button>

                <button onclick="saveUser()"
                    class="btn btn-primary">
                    Save
                </button>

            </div>

        </div>

    </div>

</div>
```

---

# STEP 4 — Update index.php

Tambahkan:

```html id="8e1lws"
<div id="view-modal"></div>
```

di bawah:

```html id="ykd20k"
<div id="content"></div>
```

---

# STEP 5 — Tambahkan JavaScript

Tambahkan di bawah `loadUserData()`

```javascript id="d9ogpy"
// Open Form Add
function openFormUser()
{
    $.ajax({

        type: "GET",

        url: "<?= base_url('user/form-add') ?>",

        dataType: "json",

        success: function(res){

            $('#view-modal').html(res.form);

            $('#modalAdd').modal('show');

        }

    });
}


// Simpan User
function saveUser()
{
    $.ajax({

        type: "POST",

        url: "<?= base_url('user/store') ?>",

        data: $('#formAdd').serialize(),

        dataType: "json",

        success: function(res){

            $('#modalAdd').modal('hide');

            loadUserData();

        }

    });
}
```

---

# STEP 6 — Update Tombol

Ganti:

```html id="zyj49q"
<button class="btn btn-primary btn-sm">
```

menjadi:

```html id="e9c7x8"
<button onclick="openFormUser()"
    class="btn btn-primary btn-sm">
```

---

# HASIL PART 2

```text id="j8e3ei"
Tambah data berhasil tanpa reload halaman
```

---

# PART 3 — EDIT DATA AJAX

# Tujuan

Mengubah data user menggunakan modal AJAX.

---

# STEP 1 — Routes

Tambahkan:

```php id="v4a5db"
$routes->get('user/form-edit/(:num)', 'UserController::formEdit/$1');

$routes->post('user/update', 'UserController::update');
```

---

# STEP 2 — Controller

Tambahkan:

```php id="b0fg7n"
// Form Edit
public function formEdit($id)
{
    $userModel = new UserModel();

    $data = [
        'user' => $userModel->find($id)
    ];

    $response = [
        'form' => view('Users/form_edit', $data)
    ];

    return $this->response->setJSON($response);
}


// Update Data
public function update()
{
    $userModel = new UserModel();

    $id = $this->request->getPost('id');

    $userModel->update($id, [
        'name'  => $this->request->getPost('name'),
        'email' => $this->request->getPost('email')
    ]);

    return $this->response->setJSON([
        'status' => true
    ]);
}
```

---

# STEP 3 — form_edit.php

## app/Views/Users/form_edit.php

```php id="slw84u"
<div class="modal fade" id="modalEdit">

    <div class="modal-dialog">

        <div class="modal-content">

            <div class="modal-header">
                <h5>Edit User</h5>
            </div>

            <div class="modal-body">

                <form id="formEdit">

                    <input type="hidden"
                        name="id"
                        value="<?= $user['id'] ?>">

                    <div class="mb-3">

                        <label>Fullname</label>

                        <input type="text"
                            name="name"
                            value="<?= $user['name'] ?>"
                            class="form-control">

                    </div>

                    <div class="mb-3">

                        <label>Email</label>

                        <input type="email"
                            name="email"
                            value="<?= $user['email'] ?>"
                            class="form-control">

                    </div>

                </form>

            </div>

            <div class="modal-footer">

                <button type="button"
                    class="btn btn-secondary"
                    data-bs-dismiss="modal">
                    Close
                </button>

                <button onclick="updateUser()"
                    class="btn btn-primary">
                    Update
                </button>

            </div>

        </div>

    </div>

</div>
```

---

# STEP 4 — Tambahkan JavaScript

Tambahkan:

```javascript id="w6qvh4"
// Open Form Edit
function editUser(id)
{
    $.ajax({

        type: "GET",

        url: "<?= base_url('user/form-edit') ?>/" + id,

        dataType: "json",

        success: function(res){

            $('#view-modal').html(res.form);

            $('#modalEdit').modal('show');

        }

    });
}


// Update User
function updateUser()
{
    $.ajax({

        type: "POST",

        url: "<?= base_url('user/update') ?>",

        data: $('#formEdit').serialize(),

        dataType: "json",

        success: function(res){

            $('#modalEdit').modal('hide');

            loadUserData();

        }

    });
}
```

---

# STEP 5 — Update Tombol Edit

Ganti tombol edit di `list.php`

```php id="t23wr2"
<button class="btn btn-info btn-sm">
```

menjadi:

```php id="wtl9aj"
<button
    onclick="editUser(<?= $user['id'] ?>)"
    class="btn btn-info btn-sm">
```

---

# HASIL PART 3

```text id="cw68wt"
Edit data berhasil tanpa reload halaman
```

---

# PART 4 — DELETE DATA AJAX

# Tujuan

Menghapus data menggunakan AJAX.

---

# STEP 1 — Routes

Tambahkan:

```php id="c0k4vg"
$routes->post('user/delete', 'UserController::delete');
```

---

# STEP 2 — Controller

Tambahkan:

```php id="nn49s2"
// Delete Data
public function delete()
{
    $userModel = new UserModel();

    $id = $this->request->getPost('id');

    $userModel->delete($id);

    return $this->response->setJSON([
        'status' => true
    ]);
}
```

---

# STEP 3 — JavaScript Delete

Tambahkan:

```javascript id="c0q84n"
// Delete User
function deleteUser(id)
{
    let hapus = confirm('Yakin hapus data ?');

    if(hapus){

        $.ajax({

            type: "POST",

            url: "<?= base_url('user/delete') ?>",

            data: {
                id:id
            },

            dataType: "json",

            success: function(res){

                loadUserData();

            }

        });

    }
}
```

---

# STEP 4 — Update Tombol Delete

Ganti:

```php id="7opgb8"
<button class="btn btn-danger btn-sm">
```

menjadi:

```php id="ngqf2v"
<button
    onclick="deleteUser(<?= $user['id'] ?>)"
    class="btn btn-danger btn-sm">
```

---

# HASIL AKHIR

```text id="lv14kq"
✓ Read Data AJAX
✓ Tambah Data AJAX
✓ Edit Data AJAX
✓ Delete Data AJAX
✓ Modal Bootstrap
✓ Tanpa Reload Halaman
```
