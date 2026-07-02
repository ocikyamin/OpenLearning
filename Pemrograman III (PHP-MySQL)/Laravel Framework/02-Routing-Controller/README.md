# Pertemuan 2 — Routing & Controller

---

## Tujuan Pembelajaran

Setelah pertemuan ini, mahasiswa diharapkan mampu:

- Mendefinisikan route untuk berbagai method HTTP
- Mengirim data melalui route parameters
- Memberi nama pada route
- Mengelompokkan route
- Membuat Controller dan menghubungkannya ke route
- Menggunakan Resource Controller untuk operasi CRUD
- Memahami objek Request dan Response

---

## Routing di Laravel

Routing adalah mekanisme yang menghubungkan **URL** yang diminta pengguna dengan **logika** yang harus dijalankan. Semua route web didefinisikan di file `routes/web.php`.

### Anatomi Route

```php
Route::method('/url', callback);
```

| Bagian | Fungsi |
|--------|--------|
| `Route::` | Facade untuk mendefinisikan route |
| `method` | HTTP method: `get`, `post`, `put`, `patch`, `delete` |
| `/url` | URL pattern yang akan dicocokkan |
| `callback` | Fungsi atau controller method yang akan dijalankan |

---

## 1. Basic Routing

### Route GET

```php
Route::get('/', function () {
    return view('welcome');
});

Route::get('/about', function () {
    return 'Halaman About';
});

Route::get('/contact', function () {
    return view('contact');
});
```

### Route POST

Digunakan saat mengirim data (form login, register, dll):

```php
Route::post('/simpan', function () {
    return 'Data berhasil disimpan';
});
```

### Route PUT / PATCH

Digunakan untuk memperbarui data:

```php
Route::put('/update', function () {
    return 'Data berhasil diperbarui';
});

Route::patch('/edit', function () {
    return 'Data berhasil diedit';
});
```

### Route DELETE

Digunakan untuk menghapus data:

```php
Route::delete('/hapus', function () {
    return 'Data berhasil dihapus';
});
```

### Route Multimethod (Match & Any)

```php
// Hanya GET dan POST
Route::match(['get', 'post'], '/login', function () {
    return 'Login page';
});

// Semua method
Route::any('/test', function () {
    return 'Bisa diakses method apapun';
});
```

---

## 2. Route Parameters

### Required Parameter

```php
Route::get('/user/{id}', function ($id) {
    return "User ID: " . $id;
});

Route::get('/post/{slug}', function ($slug) {
    return "Post: " . $slug;
});

// Multiple parameters
Route::get('/post/{category}/{slug}', function ($category, $slug) {
    return "Kategori: $category, Post: $slug";
});
```

### Optional Parameter

Parameter dengan tanda `?` dan nilai default:

```php
Route::get('/user/{name?}', function ($name = 'Guest') {
    return "Halo, $name";
});
```

Akses `/user` → "Halo, Guest"  
Akses `/user/Andi` → "Halo, Andi"

### Regex Constraint

Membatasi format parameter:

```php
Route::get('/user/{id}', function ($id) {
    return "User ID: $id";
})->where('id', '[0-9]+');

Route::get('/post/{slug}', function ($slug) {
    return "Post: $slug";
})->where('slug', '[a-z-]+');

// Multiple constraints
Route::get('/user/{id}/{name}', function ($id, $name) {
    //
})->where(['id' => '[0-9]+', 'name' => '[a-z]+']);
```

### Global Constraint (di `AppServiceProvider`)

```php
// app/Providers/AppServiceProvider.php
use Illuminate\Support\Facades\Route;

public function boot(): void
{
    Route::pattern('id', '[0-9]+');
}
```

Setelah ini, semua parameter `{id}` di route manapun otomatis hanya menerima angka.

---

## 3. Named Routes

Memberi nama pada route — memudahkan kita merujuk route tertentu dari view atau controller.

```php
Route::get('/profile', function () {
    return 'Halaman Profile';
})->name('profile');

Route::get('/user/{id}', function ($id) {
    //
})->name('user.show');
```

### Menggunakan Named Route

```php
// Dari controller / closure
$url = route('profile');
return redirect()->route('profile');

// Dari Blade (view)
<a href="{{ route('profile') }}">Profile</a>
<a href="{{ route('user.show', ['id' => 1]) }}">User 1</a>
```

### Keuntungan Named Route

Jika URL berubah, kita tidak perlu mengubah semua link di view — cukup ubah di route saja:

```php
Route::get('/profil-saya', function () {
    //
})->name('profile');
```

Di view tetap `route('profile')`, meskipun URL berubah.

---

## 4. Route Groups

Mengelompokkan route yang memiliki kesamaan — misalnya prefix URL, middleware, atau namespace yang sama.

### Prefix

```php
Route::prefix('admin')->group(function () {
    Route::get('/dashboard', function () {
        return 'Admin Dashboard';
    });  // URL: /admin/dashboard

    Route::get('/users', function () {
        return 'Daftar User';
    });  // URL: /admin/users

    Route::get('/settings', function () {
        return 'Pengaturan';
    });  // URL: /admin/settings
});
```

### Route Name Prefix

```php
Route::name('admin.')->group(function () {
    Route::get('/admin/dashboard', function () {
        //
    })->name('dashboard');  // route('admin.dashboard')
});
```

### Middleware Group

```php
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return 'Dashboard';
    });

    Route::get('/profile', function () {
        return 'Profile';
    });
});
```

---

## 5. Controller

Controller memisahkan logika aplikasi dari definisi route. Daripada menulis fungsi di `web.php`, kita pindahkan ke file Controller.

### Membuat Controller

```bash
php artisan make:controller UserController
```

File akan dibuat di `app/Http/Controllers/UserController.php`:

```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        return 'Daftar User';
    }

    public function show($id)
    {
        return "User dengan ID: $id";
    }
}
```

### Menghubungkan Controller ke Route

```php
use App\Http\Controllers\UserController;

Route::get('/users', [UserController::class, 'index']);
Route::get('/users/{id}', [UserController::class, 'show']);
```

### Single Action Controller

Untuk controller yang hanya memiliki satu method:

```bash
php artisan make:controller ProfileController --invokable
```

```php
class ProfileController extends Controller
{
    public function __invoke()
    {
        return 'Halaman Profile';
    }
}
```

Route:

```php
Route::get('/profile', ProfileController::class);
```

---

## 6. Resource Controller

Resource Controller menyediakan method-method standar untuk operasi CRUD (Create, Read, Update, Delete).

### Membuat Resource Controller

```bash
php artisan make:controller PostController --resource
```

### Method yang Dihasilkan

| Method | Route | URL | Fungsi |
|--------|-------|-----|--------|
| `index()` | `GET` | `/posts` | Menampilkan daftar |
| `create()` | `GET` | `/posts/create` | Form tambah data |
| `store()` | `POST` | `/posts` | Menyimpan data baru |
| `show($id)` | `GET` | `/posts/{id}` | Detail data |
| `edit($id)` | `GET` | `/posts/{id}/edit` | Form edit data |
| `update($id)` | `PUT/PATCH` | `/posts/{id}` | Memperbarui data |
| `destroy($id)` | `DELETE` | `/posts/{id}` | Menghapus data |

### Mendaftarkan Resource Route

```php
Route::resource('posts', PostController::class);
```

Satu baris di atas setara dengan 7 route sekaligus.

### Membatasi Method

```php
// Hanya index dan show
Route::resource('posts', PostController::class)->only(['index', 'show']);

// Kecualikan create dan edit
Route::resource('posts', PostController::class)->except(['create', 'edit']);
```

### API Resource (tanpa create/edit)

```php
Route::apiResource('posts', PostController::class);
// Hanya: index, store, show, update, destroy
```

---

## 7. Request & Response

### Objek Request

Laravel secara otomatis mengirimkan objek `Illuminate\Http\Request` ke setiap method controller.

```php
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function store(Request $request)
    {
        // Ambil input
        $name = $request->input('name');
        $email = $request->input('email');

        // Ambil semua input
        $allData = $request->all();

        // Cek apakah ada input tertentu
        if ($request->has('name')) {
            //
        }

        // Ambil hanya beberapa field
        $data = $request->only(['name', 'email']);

        // Ambil kecuali beberapa field
        $data = $request->except(['password']);

        // Ambil input dengan default
        $role = $request->input('role', 'user');

        // Method HTTP
        $method = $request->method();

        // Cek method
        if ($request->isMethod('post')) {
            //
        }

        // URL path
        $path = $request->path();

        // Full URL
        $url = $request->fullUrl();
    }
}
```

### Redirect Response

```php
// Redirect ke URL
return redirect('/dashboard');

// Redirect ke named route
return redirect()->route('profile');

// Redirect dengan flash message
return redirect('/dashboard')->with('success', 'Data berhasil disimpan');

// Redirect back (ke halaman sebelumnya)
return back();

// Redirect ke route dengan parameter
return redirect()->route('user.show', ['id' => 1]);
```

### Response JSON

```php
return response()->json([
    'success' => true,
    'message' => 'Data berhasil disimpan',
    'data' => $user
]);

// Dengan status code
return response()->json(['error' => 'Not found'], 404);
```

### Response dengan Header

```php
return response('Halo')
    ->header('Content-Type', 'text/plain')
    ->header('X-Custom-Header', 'value');
```

---

## Praktikum: Route & Controller

### 1. Route Dasar

Buka `routes/web.php` dan tambahkan:

```php
Route::get('/halo', function () {
    return 'Halo dari route!';
});

Route::get('/user/{nama}', function ($nama) {
    return "Halo, $nama!";
});

Route::get('/admin', function () {
    return redirect('/dashboard');
});
```

### 2. Buat Controller

```bash
php artisan make:controller ArtikelController
```

Buka `app/Http/Controllers/ArtikelController.php` dan isi:

```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ArtikelController extends Controller
{
    public function index()
    {
        return 'Daftar Artikel';
    }

    public function show($id)
    {
        return "Artikel dengan ID: $id";
    }

    public function kategori($kategori)
    {
        $daftar = [
            'teknologi' => 'Artikel tentang teknologi',
            'olahraga' => 'Artikel tentang olahraga',
            'pendidikan' => 'Artikel tentang pendidikan',
        ];

        if (isset($daftar[$kategori])) {
            return $daftar[$kategori];
        }

        return "Kategori $kategori tidak ditemukan";
    }
}
```

### 3. Tambahkan Route ke Controller

Di `routes/web.php`:

```php
use App\Http\Controllers\ArtikelController;

Route::get('/artikel', [ArtikelController::class, 'index']);
Route::get('/artikel/{id}', [ArtikelController::class, 'show']);
Route::get('/artikel/kategori/{kategori}', [ArtikelController::class, 'kategori']);
```

### 4. Gunakan Named Route

Ubah route artikel menjadi named route:

```php
Route::get('/artikel', [ArtikelController::class, 'index'])->name('artikel.index');
Route::get('/artikel/{id}', [ArtikelController::class, 'show'])->name('artikel.show');
```

Di view Blade:

```blade
<a href="{{ route('artikel.index') }}">Daftar Artikel</a>
<a href="{{ route('artikel.show', ['id' => 5]) }}">Lihat Artikel 5</a>
```

### 5. Uji Coba

| URL | Hasil |
|-----|-------|
| `http://localhost:8000/halo` | "Halo dari route!" |
| `http://localhost:8000/user/Budi` | "Halo, Budi!" |
| `http://localhost:8000/artikel` | "Daftar Artikel" |
| `http://localhost:8000/artikel/3` | "Artikel dengan ID: 3" |
| `http://localhost:8000/artikel/kategori/teknologi` | "Artikel tentang teknologi" |
| `http://localhost:8000/artikel/kategori/musik` | "Kategori musik tidak ditemukan" |

---

## Rangkuman

| Konsep | Intinya |
|--------|---------|
| Route | Menghubungkan URL dengan callback/controller |
| Route parameter | `{id}`, `{slug?}` — data dinamis dari URL |
| Named route | `->name('profile')` — memudahkan referensi route |
| Route group | `prefix()`, `name()`, `middleware()` — mengelompokkan route |
| Controller | Memisahkan logika dari rute (file terpisah) |
| Resource controller | 7 method CRUD standar |
| Request | Objek untuk mengakses input, header, method HTTP |
| Response | Redirect, JSON, atau response dengan header |

---

## Referensi

- [Laravel Routing](https://laravel.com/docs/13.x/routing)
- [Laravel Controllers](https://laravel.com/docs/13.x/controllers)
- [Laravel Request](https://laravel.com/docs/13.x/requests)
- [Laravel Responses](https://laravel.com/docs/13.x/responses)

---

**Lanjut ke:** [Pertemuan 3 — Blade Templating](../03-Blade-Templating/README.md)

**Kembali ke:** [Pertemuan 1 — Pengantar Laravel](../01-Pengantar-Laravel/README.md)
