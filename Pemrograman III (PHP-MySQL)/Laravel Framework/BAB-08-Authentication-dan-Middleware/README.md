# BAB 8 — Authentication & Middleware

---

## 8.1 Tujuan Pembelajaran

Setelah menyelesaikan BAB 8 ini, teman-teman diharapkan mampu:

- Menjelaskan perbedaan otentikasi (login) dan otorisasi (hak akses)
- Menginstal Breeze sebagai starter kit autentikasi
- Memahami alur login, register, dan logout di Laravel
- Menggunakan middleware `auth` dan `guest` di route
- Membuat middleware kustom untuk pengecekan role
- Membuat Gate untuk otorisasi sederhana
- Membuat Policy untuk otorisasi berbasis model
- Menerapkan role-based access control sederhana

---

## 8.2 Pendahuluan

Sejauh ini, aplikasi kita bisa diakses oleh siapa saja tanpa perlu login. Di dunia nyata, kita membutuhkan sistem yang bisa:

1. **Mengidentifikasi pengguna** — siapa yang mengakses aplikasi (otentikasi)
2. **Membatasi akses** — apa yang boleh dilakukan pengguna (otorisasi)

**Otentikasi (Authentication)** adalah proses memverifikasi identitas pengguna — biasanya melalui email dan password. Setelah terverifikasi, aplikasi tahu siapa penggunanya.

**Otorisasi (Authorization)** adalah proses menentukan apa yang boleh dilakukan pengguna yang sudah terotentikasi. Misalnya: hanya penulis artikel yang bisa mengedit artikelnya sendiri, admin bisa menghapus artikel siapa pun.

Laravel menyediakan sistem otentikasi yang lengkap dan aman. Mulai dari Laravel 11+, kita bisa menggunakan **Breeze** sebagai starter kit yang siap pakai.

---

## 8.3 Instalasi Breeze

Breeze adalah starter kit minimalis untuk otentikasi Laravel. Ia menyediakan halaman login, register, forgot password, reset password, dan profil — lengkap dengan Blade views dan Tailwind CSS.

### 8.3.1 Membuat Project Baru

```bash
composer create-project laravel/laravel blog-auth
cd blog-auth
```

### 8.3.2 Setting Database

`.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=blog_auth
DB_USERNAME=root
DB_PASSWORD=
```

Buat database:

```sql
CREATE DATABASE blog_auth CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### 8.3.3 Install Breeze

```bash
composer require laravel/breeze
```

Kemudian jalankan perintah instalasi:

```bash
php artisan breeze:install blade
```

Perintah ini akan:
- Membuat file-file view untuk login, register, forgot password, reset password, dan profil
- Menambahkan route autentikasi
- Menambahkan beberapa controller
- Menginstal Tailwind CSS dan Vite

### 8.3.4 Instal Dependency Frontend

```bash
npm install
npm run build
```

### 8.3.5 Jalankan Migrasi

```bash
php artisan migrate
```

### 8.3.6 Uji Coba

```bash
php artisan serve
```

Buka `http://localhost:8000`. Kita akan melihat halaman welcome dengan tombol **Log in** dan **Register** di pojok kanan atas.

Coba daftarkan akun baru, lalu login. Setelah login, kita akan diarahkan ke halaman **Dashboard** yang menampilkan "You're logged in!".

---

## 8.4 Memahami Fitur Breeze

### 8.4.1 Route yang Dihasilkan Breeze

Breeze menambahkan route otentikasi di file `routes/auth.php` (di-load secara otomatis oleh `bootstrap/app.php`):

| URL | Method | Middleware | Fungsi |
|-----|--------|-----------|--------|
| `/login` | GET | `guest` | Form login |
| `/login` | POST | `guest` | Proses login |
| `/register` | GET | `guest` | Form register |
| `/register` | POST | `guest` | Proses register |
| `/forgot-password` | GET | `guest` | Form lupa password |
| `/forgot-password` | POST | `guest` | Kirim email reset password |
| `/reset-password` | GET | `guest` | Form reset password (via token) |
| `/reset-password` | POST | `guest` | Proses reset password |
| `/verify-email` | GET | `auth` | Verifikasi email |
| `/logout` | POST | `auth` | Logout |

### 8.4.2 Middleware `guest` dan `auth`

Route yang menggunakan middleware `guest` hanya bisa diakses oleh pengguna yang **belum login**. Jika sudah login dan mencoba mengakses `/login`, pengguna akan diarahkan ke `/dashboard`.

Route yang menggunakan middleware `auth` hanya bisa diakses oleh pengguna yang **sudah login**. Jika belum login, pengguna akan diarahkan ke halaman login.

### 8.4.3 Menambahkan Route yang Butuh Login

Untuk menambahkan halaman yang hanya bisa diakses setelah login, bungkus dalam middleware `auth`:

```php
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::resource('articles', ArticleController::class);
});
```

### 8.4.4 Mengakses Data User yang Login

Di controller:

```php
$user = $request->user();
// atau
$user = auth()->user();

// Cek apakah user sudah login
if (auth()->check()) {
    // ...
}
```

Di Blade:

```blade
@auth
    <p>Selamat datang, {{ auth()->user()->name }}</p>
@endauth

@guest
    <p>Silakan login terlebih dahulu</p>
@endguest
```

---

## 8.5 Middleware

Middleware adalah filter yang dijalankan sebelum request mencapai route. Laravel memiliki beberapa middleware bawaan, dan kita juga bisa membuat middleware kustom.

### 8.5.1 Middleware Bawaan

| Middleware | Fungsi |
|------------|--------|
| `auth` | Pastikan user sudah login |
| `guest` | Pastikan user belum login |
| `throttle:60,1` | Batasi request (60 kali per menit) |
| `verified` | Pastikan email sudah diverifikasi |

### 8.5.2 Cara Kerja Middleware

```
Request → Middleware → Route → Controller → Response
              ↓ (gagal)
          Redirect / Error
```

### 8.5.3 Membuat Middleware Kustom

Misalnya, kita ingin memastikan user memiliki role tertentu.

```bash
php artisan make:middleware CheckRole
```

`app/Http/Middleware/CheckRole.php`:

```php
<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if ($request->user()->role !== $role) {
            abort(403);
        }

        return $next($request);
    }
}
```

### 8.5.4 Mendaftarkan Middleware

Di `bootstrap/app.php`, daftarkan middleware dengan alias:

```php
return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        // ...
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'role' => \App\Http\Middleware\CheckRole::class,
        ]);
    })
    // ...
```

### 8.5.5 Menggunakan Middleware Kustom

```php
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', function () {
        return 'Dashboard Admin';
    });
});
```

### 8.5.6 Multiple Middleware

```php
Route::get('/admin', function () {
    //
})->middleware(['auth', 'verified', 'role:admin']);
```

---

## 8.6 Gate

Gate adalah cara sederhana untuk otorisasi — cocok untuk aksi yang tidak terikat pada model tertentu.

### 8.6.1 Mendefinisikan Gate

Bukalah `app/Providers/AppServiceProvider.php`:

```php
<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Gate::define('admin', function (User $user) {
            return $user->role === 'admin';
        });

        Gate::define('edit-articles', function (User $user) {
            return in_array($user->role, ['admin', 'editor']);
        });
    }
}
```

### 8.6.2 Menggunakan Gate di Controller

```php
use Illuminate\Support\Facades\Gate;

public function destroy(Article $article)
{
    Gate::authorize('admin');

    $article->delete();

    return redirect()->route('articles.index')
        ->with('success', 'Artikel berhasil dihapus');
}
```

### 8.6.3 Gate di Blade

```blade
@can('admin')
    <a href="/admin">Panel Admin</a>
@endcan

@cannot('edit-articles')
    <p>Anda tidak memiliki izin untuk mengedit artikel.</p>
@endcannot
```

---

## 8.7 Policy

Policy adalah class otorisasi yang terfokus pada satu model. Misalnya `ArticlePolicy` berisi method untuk authorize operasi CRUD pada Article.

### 8.7.1 Membuat Policy

```bash
php artisan make:policy ArticlePolicy --model=Article
```

`app/Policies/ArticlePolicy.php`:

```php
<?php

namespace App\Policies;

use App\Models\Article;
use App\Models\User;

class ArticlePolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Article $article): bool
    {
        return $article->published || $user->id === $article->user_id;
    }

    public function create(User $user): bool
    {
        return $user !== null;
    }

    public function update(User $user, Article $article): bool
    {
        return $user->id === $article->user_id;
    }

    public function delete(User $user, Article $article): bool
    {
        return $user->id === $article->user_id || $user->role === 'admin';
    }
}
```

### 8.7.2 Mendaftarkan Policy

Di `app/Providers/AppServiceProvider.php`:

```php
use App\Models\Article;
use App\Policies\ArticlePolicy;
use Illuminate\Support\Facades\Gate;

public function boot(): void
{
    Gate::policy(Article::class, ArticlePolicy::class);
}
```

### 8.7.3 Menggunakan Policy di Controller

```php
public function update(UpdateArticleRequest $request, Article $article)
{
    Gate::authorize('update', $article);

    $article->update($request->validated());

    return redirect()->route('articles.index')
        ->with('success', 'Artikel berhasil diperbarui');
}

public function destroy(Article $article)
{
    Gate::authorize('delete', $article);

    $article->delete();

    return redirect()->route('articles.index')
        ->with('success', 'Artikel berhasil dihapus');
}
```

### 8.7.4 Authorization di Form Request

Policy juga bisa dipanggil dari Form Request:

```php
public function authorize(): bool
{
    return $this->user()->can('update', $this->route('article'));
}
```

### 8.7.5 Policy di Blade

```blade
@can('update', $article)
    <a href="{{ route('articles.edit', $article) }}">Edit</a>
@endcan

@can('delete', $article)
    <form method="POST" action="{{ route('articles.destroy', $article) }}">
        @csrf
        @method('DELETE')
        <button type="submit">Hapus</button>
    </form>
@endcan
```

---

## 8.8 Roles Sederhana

Untuk kebutuhan sederhana, kita bisa menambahkan kolom `role` di tabel users.

### 8.8.1 Migration

```bash
php artisan make:migration add_role_to_users_table
```

```php
Schema::table('users', function (Blueprint $table) {
    $table->string('role')->default('user')->after('email');
});
```

Jalankan migrasi:

```bash
php artisan migrate
```

### 8.8.2 Model User

Tambahkan `$fillable` untuk role dan helper method:

```php
class User extends Model
{
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isEditor(): bool
    {
        return $this->role === 'editor';
    }
}
```

### 8.8.3 Gate Berbasis Role

```php
Gate::define('admin', fn (User $user) => $user->isAdmin());
Gate::define('editor', fn (User $user) => $user->isEditor());
```

### 8.8.4 Middleware Berbasis Role

Gunakan middleware `CheckRole` yang kita buat di sub-bab 7.5.3.

```php
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin', function () {
        return 'Admin Panel';
    });
});
```

---

## 8.9 Praktikum: Aplikasi Artikel dengan Auth

Pada praktikum ini, kita akan membuat aplikasi artikel yang memerlukan login untuk membuat, mengedit, dan menghapus artikel. Setiap pengguna hanya bisa mengedit/menghapus artikel miliknya sendiri.

### 8.9.1 Persiapan

Buat project baru dengan Breeze:

```bash
composer create-project laravel/laravel blog-auth
cd blog-auth
composer require laravel/breeze
php artisan breeze:install blade
npm install && npm run build
```

Setting database MySQL di `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=blog_auth
DB_USERNAME=root
DB_PASSWORD=
```

Buat database dan jalankan migrasi:

```sql
CREATE DATABASE blog_auth CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

```bash
php artisan migrate
```

### 8.9.2 Migration Artikel

```bash
php artisan make:migration create_articles_table
```

```php
Schema::create('articles', function (Blueprint $table) {
    $table->id();
    $table->string('title');
    $table->string('slug')->unique();
    $table->text('body');
    $table->text('excerpt')->nullable();
    $table->string('category');
    $table->boolean('published')->default(false);
    $table->foreignId('user_id')->constrained()->cascadeOnDelete();
    $table->timestamps();
});
```

### 8.9.3 Model Article

```bash
php artisan make:model Article
```

`app/Models/Article.php`:

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Article extends Model
{
    protected $fillable = [
        'title', 'slug', 'body', 'excerpt',
        'category', 'published', 'user_id',
    ];

    protected function casts(): array
    {
        return [
            'published' => 'boolean',
        ];
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
```

### 8.9.4 Policy

```bash
php artisan make:policy ArticlePolicy --model=Article
```

`app/Policies/ArticlePolicy.php`:

```php
<?php

namespace App\Policies;

use App\Models\Article;
use App\Models\User;

class ArticlePolicy
{
    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, Article $article): bool
    {
        return $user->id === $article->user_id;
    }

    public function delete(User $user, Article $article): bool
    {
        return $user->id === $article->user_id;
    }
}
```

Daftarkan policy di `app/Providers/AppServiceProvider.php`:

```php
use App\Models\Article;
use App\Policies\ArticlePolicy;
use Illuminate\Support\Facades\Gate;

public function boot(): void
{
    Gate::policy(Article::class, ArticlePolicy::class);
}
```

### 8.9.5 Route

`routes/web.php`:

```php
<?php

use App\Http\Controllers\ArticleController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    Route::resource('articles', ArticleController::class);
});
```

Semua route artikel hanya bisa diakses setelah login.

### 8.9.6 Controller

```bash
php artisan make:controller ArticleController
```

`app/Http/Controllers/ArticleController.php`:

```php
<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::with('author')
            ->latest()
            ->paginate(10);

        return view('articles.index', compact('articles'));
    }

    public function create()
    {
        return view('articles.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'max:255'],
            'category' => ['required'],
            'body' => ['required'],
            'excerpt' => ['nullable', 'max:500'],
            'published' => ['boolean'],
        ]);

        $article = Article::create([
            ...$validated,
            'slug' => Str::slug($validated['title']),
            'user_id' => $request->user()->id,
        ]);

        return redirect()->route('articles.show', $article)
            ->with('success', 'Artikel berhasil dibuat');
    }

    public function show(Article $article)
    {
        return view('articles.show', compact('article'));
    }

    public function edit(Article $article)
    {
        Gate::authorize('update', $article);

        return view('articles.edit', compact('article'));
    }

    public function update(Request $request, Article $article)
    {
        Gate::authorize('update', $article);

        $validated = $request->validate([
            'title' => ['required', 'max:255'],
            'category' => ['required'],
            'body' => ['required'],
            'excerpt' => ['nullable', 'max:500'],
            'published' => ['boolean'],
        ]);

        $article->update($validated);

        return redirect()->route('articles.show', $article)
            ->with('success', 'Artikel berhasil diperbarui');
    }

    public function destroy(Article $article)
    {
        Gate::authorize('delete', $article);

        $article->delete();

        return redirect()->route('articles.index')
            ->with('success', 'Artikel berhasil dihapus');
    }
}
```

### 8.9.7 View

**Layout — `resources/views/layouts/app.blade.php`:**

```blade
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Blog')</title>
    @vite(['resources/css/app.css'])
</head>
<body class="bg-gray-100">
    <nav class="bg-white shadow p-4">
        <div class="max-w-4xl mx-auto flex justify-between items-center">
            <div class="flex gap-4">
                <a href="/" class="font-bold">Home</a>
                <a href="{{ route('articles.index') }}">Artikel</a>
            </div>
            <div class="flex gap-4 items-center">
                @auth
                    <span>{{ auth()->user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-gray-600 hover:text-gray-800">Logout</button>
                    </form>
                @endauth
            </div>
        </div>
    </nav>

    <main class="max-w-4xl mx-auto p-4">
        @if(session('success'))
            <div class="bg-green-100 text-green-800 p-4 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        @yield('content')
    </main>
</body>
</html>
```

**Daftar Artikel — `resources/views/articles/index.blade.php`:**

```blade
@extends('layouts.app')

@section('title', 'Artikel Saya')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">Artikel Saya</h1>
        <a href="{{ route('articles.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded">
            + Artikel Baru
        </a>
    </div>

    @forelse($articles as $article)
        <div class="bg-white rounded-lg shadow p-6 mb-4">
            <h2 class="text-xl font-semibold">
                <a href="{{ route('articles.show', $article) }}" class="text-blue-600 hover:text-blue-800">
                    {{ $article->title }}
                </a>
            </h2>
            <p class="text-gray-600 mt-2">{{ $article->excerpt ?? Str::limit($article->body, 150) }}</p>
            <div class="text-sm text-gray-400 mt-2">
                {{ $article->category }} &middot; {{ $article->created_at->format('d M Y') }}
                oleh {{ $article->author->name }}
            </div>
            @can('update', $article)
                <div class="flex gap-2 mt-3">
                    <a href="{{ route('articles.edit', $article) }}" class="text-yellow-600">Edit</a>
                    <form method="POST" action="{{ route('articles.destroy', $article) }}" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-800"
                                onclick="return confirm('Yakin hapus?')">Hapus</button>
                    </form>
                </div>
            @endcan
        </div>
    @empty
        <p class="text-gray-500">Belum ada artikel.</p>
    @endforelse

    <div class="mt-6">{{ $articles->links() }}</div>
@endsection
```

**Form Tambah — `resources/views/articles/create.blade.php`:**

```blade
@extends('layouts.app')

@section('title', 'Tulis Artikel')

@section('content')
    <h1 class="text-3xl font-bold mb-6">Tulis Artikel Baru</h1>

    <form method="POST" action="{{ route('articles.store') }}" class="bg-white rounded-lg shadow p-6">
        @csrf

        <div class="mb-4">
            <label class="block font-semibold mb-1">Judul</label>
            <input type="text" name="title" value="{{ old('title') }}"
                   class="w-full border rounded px-3 py-2 @error('title') border-red-500 @enderror">
            @error('title') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
        </div>

        <div class="mb-4">
            <label class="block font-semibold mb-1">Kategori</label>
            <select name="category" class="w-full border rounded px-3 py-2 @error('category') border-red-500 @enderror">
                <option value="">Pilih</option>
                @foreach(['Teknologi', 'Olahraga', 'Pendidikan', 'Hiburan'] as $cat)
                    <option value="{{ $cat }}" @selected(old('category') === $cat)>{{ $cat }}</option>
                @endforeach
            </select>
            @error('category') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
        </div>

        <div class="mb-4">
            <label class="block font-semibold mb-1">Konten</label>
            <textarea name="body" rows="10"
                      class="w-full border rounded px-3 py-2 @error('body') border-red-500 @enderror">{{ old('body') }}</textarea>
            @error('body') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
        </div>

        <div class="mb-4">
            <label class="block font-semibold mb-1">Ringkasan (opsional)</label>
            <textarea name="excerpt" rows="3"
                      class="w-full border rounded px-3 py-2">{{ old('excerpt') }}</textarea>
        </div>

        <div class="mb-4">
            <label class="flex items-center gap-2">
                <input type="checkbox" name="published" value="1" @checked(old('published'))>
                Publikasikan sekarang
            </label>
        </div>

        <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
            Simpan
        </button>
    </form>
@endsection
```

**Form Edit — `resources/views/articles/edit.blade.php`:**

```blade
@extends('layouts.app')

@section('title', 'Edit Artikel')

@section('content')
    <h1 class="text-3xl font-bold mb-6">Edit Artikel</h1>

    <form method="POST" action="{{ route('articles.update', $article) }}" class="bg-white rounded-lg shadow p-6">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="block font-semibold mb-1">Judul</label>
            <input type="text" name="title" value="{{ old('title', $article->title) }}"
                   class="w-full border rounded px-3 py-2 @error('title') border-red-500 @enderror">
            @error('title') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
        </div>

        <div class="mb-4">
            <label class="block font-semibold mb-1">Kategori</label>
            <select name="category" class="w-full border rounded px-3 py-2 @error('category') border-red-500 @enderror">
                <option value="">Pilih</option>
                @foreach(['Teknologi', 'Olahraga', 'Pendidikan', 'Hiburan'] as $cat)
                    <option value="{{ $cat }}" @selected(old('category', $article->category) === $cat)>{{ $cat }}</option>
                @endforeach
            </select>
            @error('category') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
        </div>

        <div class="mb-4">
            <label class="block font-semibold mb-1">Konten</label>
            <textarea name="body" rows="10"
                      class="w-full border rounded px-3 py-2 @error('body') border-red-500 @enderror">{{ old('body', $article->body) }}</textarea>
            @error('body') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
        </div>

        <div class="mb-4">
            <label class="flex items-center gap-2">
                <input type="checkbox" name="published" value="1" @checked(old('published', $article->published))>
                Publikasikan
            </label>
        </div>

        <button type="submit" class="bg-yellow-600 text-white px-6 py-2 rounded hover:bg-yellow-700">
            Perbarui
        </button>
    </form>
@endsection
```

**Detail — `resources/views/articles/show.blade.php`:**

```blade
@extends('layouts.app')

@section('title', $article->title)

@section('content')
    <article class="bg-white rounded-lg shadow p-6">
        <h1 class="text-3xl font-bold mb-4">{{ $article->title }}</h1>

        <div class="text-sm text-gray-400 mb-6">
            {{ $article->category }} &middot;
            {{ $article->created_at->format('d M Y') }} &middot;
            oleh {{ $article->author->name }}
            @if($article->published)
                <span class="text-green-600">Dipublikasikan</span>
            @else
                <span class="text-gray-500">Draft</span>
            @endif
        </div>

        <div class="prose max-w-none">{{ $article->body }}</div>

        @can('update', $article)
            <div class="flex gap-2 mt-6">
                <a href="{{ route('articles.edit', $article) }}" class="bg-yellow-600 text-white px-4 py-2 rounded">
                    Edit
                </a>
            </div>
        @endcan

        <a href="{{ route('articles.index') }}" class="inline-block mt-4 text-blue-600">&larr; Kembali</a>
    </article>
@endsection
```

### 8.9.8 Uji Coba

1. **Jalankan server**: `php artisan serve`
2. **Buka** `http://localhost:8000`
3. **Klik Register** — daftarkan akun baru
4. **Buat artikel** — klik "+ Artikel Baru", isi dan simpan
5. **Coba edit/hapus** — hanya artikel milik sendiri yang muncul tombol edit/hapus
6. **Logout** — coba akses `/articles` → akan diarahkan ke halaman login

---

## 8.10 Rangkuman

| Konsep | Intinya |
|--------|---------|
| **Otentikasi** | Verifikasi identitas (login/register) |
| **Otorisasi** | Pembatasan akses (apa yang boleh dilakukan) |
| **Breeze** | Starter kit auth Laravel (login, register, dll) |
| **Middleware `auth`** | Pastikan user sudah login |
| **Middleware kustom** | Filter request buatan sendiri (misal `CheckRole`) |
| **Gate** | Otorisasi sederhana tanpa model |
| **Policy** | Otorisasi berbasis model (CRUD) |
| **`@can` / `@cannot`** | Blade directive untuk otorisasi |

---

## 8.11 Referensi

- [Laravel Breeze](https://laravel.com/docs/13.x/starter-kits#breeze)
- [Laravel Authentication](https://laravel.com/docs/13.x/authentication)
- [Laravel Middleware](https://laravel.com/docs/13.x/middleware)
- [Laravel Authorization (Gate & Policy)](https://laravel.com/docs/13.x/authorization)

---

**Lanjut ke:** [BAB 9 — Upload File & Storage](../BAB-09-Upload-File-dan-Storage/README.md)

**Kembali ke:** [BAB 7 — Form Request & Validation](../BAB-07-Form-Request-dan-Validation/README.md)
