# BAB 6 — Form Request & Validation

---

## 6.1 Tujuan Pembelajaran

Setelah menyelesaikan BAB 6 ini, teman-teman diharapkan mampu:

- Memvalidasi input form langsung di Controller
- Membuat Form Request class untuk validasi terpisah
- Menggunakan berbagai aturan validasi bawaan Laravel
- Membuat aturan validasi kustom
- Menampilkan pesan error dan old input di Blade
- Mengelola flash data setelah form submit
- Menerapkan prinsip keamanan mass assignment

---

## 6.2 Pendahuluan

Sejauh ini, kita telah belajar menampilkan data dari database ke halaman web. Namun, aplikasi web yang sesungguhnya juga harus bisa **menerima input dari pengguna** — baik itu form registrasi, form artikel, form komentar, dan lain-lain.

Setiap input dari pengguna harus **divalidasi** sebelum diproses. Validasi adalah proses memeriksa apakah data yang dikirim memenuhi aturan yang kita tentukan. Contoh aturan validasi:

- `name` harus diisi
- `email` harus format email yang valid
- `password` minimal 8 karakter
- `age` harus angka antara 17–100

Tanpa validasi, aplikasi kita rentan terhadap data rusak, error server, hingga serangan keamanan. Laravel menyediakan sistem validasi yang kuat dan ekspresif, mulai dari validasi sederhana di Controller hingga Form Request class yang terstruktur.

---

## 6.3 Validasi Dasar di Controller

### 6.3.1 Menggunakan validate()

Cara paling sederhana adalah menggunakan method `validate()` pada objek Request:

```php
<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'body' => 'required',
            'category' => 'required|in:Teknologi,Olahraga,Pendidikan',
            'published' => 'boolean',
        ]);

        Article::create($validated);

        return redirect()->route('articles.index')
            ->with('success', 'Artikel berhasil dibuat');
    }
}
```

**Penjelasan:**
- Parameter `validate()` adalah array asosiatif: key = nama field, value = aturan validasi
- Jika validasi gagal, Laravel otomatis mengarahkan kembali ke halaman sebelumnya dan menyimpan error di session
- Jika validasi lolos, method mengembalikan array data yang sudah tervalidasi

### 6.3.2 Aturan Validasi Umum

| Aturan | Fungsi |
|--------|--------|
| `required` | Field harus diisi |
| `required_if:field,value` | Wajib jika field lain bernilai tertentu |
| `nullable` | Field boleh kosong |
| `string` | Harus berupa string |
| `integer` | Harus berupa integer |
| `numeric` | Harus angka (termasuk desimal) |
| `boolean` | Harus true/false/1/0 |
| `email` | Format email valid |
| `min:N` | Minimal N karakter (string) atau N (angka) |
| `max:N` | Maksimal N karakter atau angka |
| `size:N` | Panjang/ukuran harus tepat N |
| `in:a,b,c` | Nilai harus salah satu dari a, b, c |
| `unique:table,column` | Nilai harus unik di tabel tertentu |
| `exists:table,column` | Nilai harus ada di tabel tertentu |
| `date` | Format tanggal valid |
| `image` | File harus gambar |
| `mimes:jpg,png` | Ekstensi file tertentu |
| `max:2048` | Ukuran file maksimal (dalam KB) |

### 6.3.3 Validasi dengan Array Syntax

Laravel mendukung dua cara penulisan aturan validasi. Di kode sebelumnya kita menggunakan **string notation** (`'required|max:255'`). Alternatifnya adalah **array syntax** yang lebih mudah dibaca saat aturannya kompleks:

```php
$validated = $request->validate([
    'title' => ['required', 'max:255'],
    'email' => ['required', 'email', Rule::unique('users')],
    'category' => ['required', Rule::in(['Teknologi', 'Olahraga', 'Pendidikan'])],
]);
```

Untuk konsistensi, pilih salah satu gaya dan gunakan secara konsisten di seluruh project.

### 6.3.4 Menampilkan Error di View

Ketika validasi gagal, Laravel akan:

1. Redirect kembali ke halaman form
2. Menyimpan error di session (via `$errors`)
3. Menyimpan input sebelumnya (via `old()`)

Di Blade:

```blade
<form method="POST" action="/articles">
    @csrf

    <input
        type="text"
        name="title"
        value="{{ old('title') }}"
        class="@error('title') border-red-500 @enderror"
    >

    @error('title')
        <p class="text-red-500">{{ $message }}</p>
    @enderror

    <textarea name="body">{{ old('body') }}</textarea>

    @error('body')
        <p class="text-red-500">{{ $message }}</p>
    @enderror

    <button type="submit">Simpan</button>
</form>
```

### 6.3.5 Flash Data

Setelah berhasil menyimpan data, kita sering menampilkan pesan sukses. Gunakan `with()` pada redirect:

```php
return redirect()->route('articles.index')
    ->with('success', 'Artikel berhasil dibuat');
```

Tampilkan di view:

```blade
@if(session('success'))
    <div class="bg-green-100 text-green-800 p-4 rounded">
        {{ session('success') }}
    </div>
@endif
```

---

## 6.4 Form Request Class

Validasi di Controller memang sederhana, tapi untuk aplikasi yang lebih besar, menulis semua aturan validasi di Controller akan membuat Controller menjadi gemuk dan sulit diuji. Solusinya adalah **Form Request** — class khusus yang menangani validasi.

### 6.4.1 Membuat Form Request

```bash
php artisan make:request StoreArticleRequest
```

File akan dibuat di `app/Http/Requests/StoreArticleRequest.php`:

```php
<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreArticleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'max:255'],
            'slug' => ['required', 'unique:articles,slug'],
            'body' => ['required'],
            'excerpt' => ['nullable', 'max:500'],
            'category' => ['required', Rule::in(['Teknologi', 'Olahraga', 'Pendidikan', 'Hiburan'])],
            'published' => ['boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Judul artikel wajib diisi.',
            'title.max' => 'Judul maksimal 255 karakter.',
            'slug.unique' => 'Slug sudah digunakan, gunakan judul lain.',
            'body.required' => 'Konten artikel wajib diisi.',
        ];
    }
}
```

**Penjelasan method:**

| Method | Fungsi |
|--------|--------|
| `authorize()` | Menentukan siapa yang boleh mengirim request ini |
| `rules()` | Mendefinisikan aturan validasi |
| `messages()` | Kustom pesan error (opsional) |

### 6.4.2 Menggunakan Form Request di Controller

```php
use App\Http\Requests\StoreArticleRequest;

public function store(StoreArticleRequest $request)
{
    Article::create($request->validated());

    return redirect()->route('articles.index')
        ->with('success', 'Artikel berhasil dibuat');
}
```

Perhatikan, Controller menjadi sangat bersih:
- Validasi ditangani sepenuhnya oleh Form Request
- Method `$request->validated()` hanya mengembalikan data yang sudah tervalidasi
- Controller hanya fokus pada logika bisnis

### 6.4.3 Form Request untuk Update

Buat Form Request terpisah untuk update:

```bash
php artisan make:request UpdateArticleRequest
```

```php
public function rules(): array
{
    return [
        'title' => ['required', 'max:255'],
        'slug' => ['required', Rule::unique('articles')->ignore($this->route('article'))],
        'body' => ['required'],
        'excerpt' => ['nullable', 'max:500'],
        'category' => ['required', Rule::in(['Teknologi', 'Olahraga', 'Pendidikan', 'Hiburan'])],
        'published' => ['boolean'],
    ];
}
```

Perbedaan dengan Store: aturan `unique` mengecualikan artikel yang sedang diedit agar tidak konflik dengan slug-nya sendiri.

### 6.4.4 Authorize di Form Request

Jika hanya user tertentu yang boleh membuat artikel:

```php
public function authorize(): bool
{
    return $this->user() !== null;
}
```

Atau dengan Gate/Policy:

```php
public function authorize(): bool
{
    return $this->user()->can('create', Article::class);
}
```

---

## 6.5 Aturan Validasi Lanjutan

### 6.5.1 Conditional Validation dengan Rule::when()

```php
use Illuminate\Validation\Rule;

public function rules(): array
{
    return [
        'account_type' => ['required', Rule::in(['personal', 'business'])],
        'company_name' => [
            Rule::when($this->account_type === 'business', ['required', 'max:255']),
        ],
    ];
}
```

### 6.5.2 Custom Validation dengan after()

Jika validasi membutuhkan logika yang melibatkan beberapa field:

```php
public function after(): array
{
    return [
        function (Validator $validator) {
            if ($this->stock && $this->stock < 0) {
                $validator->errors()->add('stock', 'Stok tidak boleh negatif.');
            }
        },
    ];
}
```

### 6.5.3 Kustom Aturan Validasi

Buat aturan kustom jika aturan bawaan tidak mencukupi:

```bash
php artisan make:rule SlugUnique
```

```php
<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class SlugUnique implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (Article::where('slug', $value)->exists()) {
            $fail('Slug sudah digunakan. Silakan gunakan judul yang berbeda.');
        }
    }
}
```

Penggunaan di Form Request:

```php
use App\Rules\SlugUnique;

public function rules(): array
{
    return [
        'slug' => ['required', new SlugUnique],
    ];
}
```

---

## 6.6 Prinsip Keamanan

### 6.6.1 Mass Assignment Protection

Jangan pernah menggunakan `$request->all()` untuk operasi mass assignment. Gunakan `$request->validated()` atau tetapkan kolom secara eksplisit:

```php
// Berbahaya — user bisa mengisi kolom is_admin, user_id, dll
Article::create($request->all());

// Aman — hanya data yang sudah divalidasi
Article::create($request->validated());
```

Pastikan setiap model memiliki `$fillable`:

```php
class Article extends Model
{
    protected $fillable = [
        'title', 'slug', 'body', 'excerpt', 'category', 'published', 'user_id',
    ];
}
```

### 6.6.2 CSRF Protection

Semua form POST, PUT, PATCH, DELETE harus menyertakan token CSRF. Blade directive `@csrf` akan menambahkan input hidden dengan token yang valid.

```blade
<form method="POST" action="/articles">
    @csrf
    ...
</form>
```

Jangan lupa sertakan `@csrf` di setiap form — Laravel akan menolak request tanpa token CSRF.

---

## 6.7 Praktikum: Form Artikel dengan Validasi

Pada praktikum ini, kita akan membuat fitur tambah dan edit artikel dengan validasi lengkap menggunakan Form Request.

### 6.7.1 Persiapan

Gunakan project dari BAB 5 atau buat project baru dengan migrasi articles, categories, tags, dan comments.

```bash
composer create-project laravel/laravel blog-validation
cd blog-validation
```

Setting database MySQL di `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=blog_validation
DB_USERNAME=root
DB_PASSWORD=
```

Buat database:

```sql
CREATE DATABASE blog_validation CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### 6.7.2 Model Article

```bash
php artisan make:model Article -m
```

`app/Models/Article.php`:

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

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
}
```

### 6.7.3 Migration Articles

`database/migrations/xxxx_create_articles_table.php`:

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

### 6.7.4 Form Request Store

```bash
php artisan make:request StoreArticleRequest
```

`app/Http/Requests/StoreArticleRequest.php`:

```php
<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreArticleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'max:255'],
            'slug' => ['required', 'alpha_dash', Rule::unique('articles')],
            'body' => ['required'],
            'excerpt' => ['nullable', 'max:500'],
            'category' => ['required', Rule::in(['Teknologi', 'Olahraga', 'Pendidikan', 'Hiburan'])],
            'published' => ['boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Judul artikel wajib diisi.',
            'title.max' => 'Judul maksimal 255 karakter.',
            'slug.required' => 'Slug wajib diisi.',
            'slug.unique' => 'Slug sudah digunakan.',
            'slug.alpha_dash' => 'Slug hanya boleh huruf, angka, strip, dan underscore.',
            'body.required' => 'Konten artikel wajib diisi.',
            'category.required' => 'Pilih kategori artikel.',
            'category.in' => 'Kategori tidak valid.',
        ];
    }
}
```

### 6.7.5 Form Request Update

```bash
php artisan make:request UpdateArticleRequest
```

`app/Http/Requests/UpdateArticleRequest.php`:

```php
<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateArticleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'max:255'],
            'slug' => [
                'required',
                'alpha_dash',
                Rule::unique('articles')->ignore($this->route('article')),
            ],
            'body' => ['required'],
            'excerpt' => ['nullable', 'max:500'],
            'category' => ['required', Rule::in(['Teknologi', 'Olahraga', 'Pendidikan', 'Hiburan'])],
            'published' => ['boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Judul artikel wajib diisi.',
            'title.max' => 'Judul maksimal 255 karakter.',
            'slug.unique' => 'Slug sudah digunakan.',
            'body.required' => 'Konten artikel wajib diisi.',
            'category.required' => 'Pilih kategori artikel.',
        ];
    }
}
```

### 6.7.6 Controller

```bash
php artisan make:controller ArticleController
```

`app/Http/Controllers/ArticleController.php`:

```php
<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreArticleRequest;
use App\Http\Requests\UpdateArticleRequest;
use App\Models\Article;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::latest()->paginate(10);
        return view('articles.index', compact('articles'));
    }

    public function create()
    {
        return view('articles.create');
    }

    public function store(StoreArticleRequest $request)
    {
        Article::create($request->validated() + ['user_id' => $request->user()->id]);

        return redirect()->route('articles.index')
            ->with('success', 'Artikel berhasil dibuat');
    }

    public function show(Article $article)
    {
        return view('articles.show', compact('article'));
    }

    public function edit(Article $article)
    {
        return view('articles.edit', compact('article'));
    }

    public function update(UpdateArticleRequest $request, Article $article)
    {
        $article->update($request->validated());

        return redirect()->route('articles.index')
            ->with('success', 'Artikel berhasil diperbarui');
    }

    public function destroy(Article $article)
    {
        $article->delete();

        return redirect()->route('articles.index')
            ->with('success', 'Artikel berhasil dihapus');
    }
}
```

### 6.7.7 Route

`routes/web.php`:

```php
<?php

use App\Http\Controllers\ArticleController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => view('home'));

Route::resource('articles', ArticleController::class);
```

### 6.7.8 View

**Layout — `resources/views/layouts/app.blade.php`:**

```blade
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Blog')</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <nav class="bg-white shadow p-4">
        <div class="max-w-4xl mx-auto flex gap-4">
            <a href="/" class="font-bold">Home</a>
            <a href="{{ route('articles.index') }}">Artikel</a>
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

**Daftar — `resources/views/articles/index.blade.php`:**

```blade
@extends('layouts.app')

@section('title', 'Daftar Artikel')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">Daftar Artikel</h1>
        <a href="{{ route('articles.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded">
            + Tambah Artikel
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
            </div>
            <div class="flex gap-2 mt-3">
                <a href="{{ route('articles.edit', $article) }}" class="text-yellow-600 hover:text-yellow-800">Edit</a>
                <form method="POST" action="{{ route('articles.destroy', $article) }}" onsubmit="return confirm('Yakin hapus?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-red-600 hover:text-red-800">Hapus</button>
                </form>
            </div>
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

@section('title', 'Tambah Artikel')

@section('content')
    <h1 class="text-3xl font-bold mb-6">Tambah Artikel</h1>

    <form method="POST" action="{{ route('articles.store') }}" class="bg-white rounded-lg shadow p-6">
        @csrf

        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Judul</label>
            <input type="text" name="title" value="{{ old('title') }}"
                   class="w-full border rounded px-3 py-2 @error('title') border-red-500 @enderror">
            @error('title')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Slug</label>
            <input type="text" name="slug" value="{{ old('slug') }}"
                   class="w-full border rounded px-3 py-2 @error('slug') border-red-500 @enderror">
            @error('slug')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Kategori</label>
            <select name="category" class="w-full border rounded px-3 py-2 @error('category') border-red-500 @enderror">
                <option value="">Pilih Kategori</option>
                <option value="Teknologi" @selected(old('category') === 'Teknologi')>Teknologi</option>
                <option value="Olahraga" @selected(old('category') === 'Olahraga')>Olahraga</option>
                <option value="Pendidikan" @selected(old('category') === 'Pendidikan')>Pendidikan</option>
                <option value="Hiburan" @selected(old('category') === 'Hiburan')>Hiburan</option>
            </select>
            @error('category')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Konten</label>
            <textarea name="body" rows="8"
                      class="w-full border rounded px-3 py-2 @error('body') border-red-500 @enderror">{{ old('body') }}</textarea>
            @error('body')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Ringkasan (opsional)</label>
            <textarea name="excerpt" rows="3"
                      class="w-full border rounded px-3 py-2">{{ old('excerpt') }}</textarea>
            @error('excerpt')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label class="flex items-center gap-2">
                <input type="checkbox" name="published" value="1" @checked(old('published'))>
                <span>Publikasikan segera</span>
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
            <label class="block text-gray-700 font-semibold mb-2">Judul</label>
            <input type="text" name="title" value="{{ old('title', $article->title) }}"
                   class="w-full border rounded px-3 py-2 @error('title') border-red-500 @enderror">
            @error('title')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Slug</label>
            <input type="text" name="slug" value="{{ old('slug', $article->slug) }}"
                   class="w-full border rounded px-3 py-2 @error('slug') border-red-500 @enderror">
            @error('slug')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Kategori</label>
            <select name="category" class="w-full border rounded px-3 py-2 @error('category') border-red-500 @enderror">
                <option value="">Pilih Kategori</option>
                @foreach(['Teknologi', 'Olahraga', 'Pendidikan', 'Hiburan'] as $cat)
                    <option value="{{ $cat }}" @selected(old('category', $article->category) === $cat)>{{ $cat }}</option>
                @endforeach
            </select>
            @error('category')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Konten</label>
            <textarea name="body" rows="8"
                      class="w-full border rounded px-3 py-2 @error('body') border-red-500 @enderror">{{ old('body', $article->body) }}</textarea>
            @error('body')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label class="flex items-center gap-2">
                <input type="checkbox" name="published" value="1" @checked(old('published', $article->published))>
                <span>Publikasikan</span>
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
            {{ $article->category }} &middot; {{ $article->created_at->format('d M Y') }}
            @if($article->published)
                &middot; <span class="text-green-600">Dipublikasikan</span>
            @else
                &middot; <span class="text-gray-500">Draft</span>
            @endif
        </div>

        <div class="prose max-w-none">{{ $article->body }}</div>

        <div class="flex gap-2 mt-6">
            <a href="{{ route('articles.edit', $article) }}" class="bg-yellow-600 text-white px-4 py-2 rounded">Edit</a>
            <a href="{{ route('articles.index') }}" class="text-blue-600 hover:text-blue-800">&larr; Kembali</a>
        </div>
    </article>
@endsection
```

### 6.7.9 Uji Coba

1. Jalankan migrasi: `php artisan migrate`
2. Jalankan server: `php artisan serve`
3. Buka `http://localhost:8000/articles`
4. Coba tambah artikel baru melalui form
5. Coba submit form kosong — lihat pesan error muncul
6. Coba edit artikel — lihat form terisi dengan data lama
7. Coba hapus artikel — lihat konfirmasi dan pesan sukses

---

## 6.8 Rangkuman

| Konsep | Intinya |
|--------|---------|
| `validate()` | Validasi cepat langsung di Controller |
| Form Request | Class terpisah untuk validasi — controller lebih bersih |
| `validated()` | Ambil data yang sudah tervalidasi saja |
| `@error` | Menampilkan error per field di Blade |
| `old()` | Menampilkan input sebelumnya setelah error |
| `session('success')` | Flash message setelah operasi berhasil |
| `Rule::unique()->ignore()` | Validasi unique saat update |
| `$fillable` | Proteksi mass assignment |
| `@csrf` | Token CSRF wajib di semua form POST |

---

## 6.9 Referensi

- [Laravel Validation](https://laravel.com/docs/13.x/validation)
- [Form Request](https://laravel.com/docs/13.x/validation#form-request-validation)
- [Custom Validation Rules](https://laravel.com/docs/13.x/validation#custom-validation-rules)
- [Error Messages](https://laravel.com/docs/13.x/validation#customizing-the-error-messages)
- [CSRF Protection](https://laravel.com/docs/13.x/csrf)

---

**Lanjut ke:** [BAB 7 — Authentication & Middleware](../BAB-07-Authentication-dan-Middleware/README.md)

**Kembali ke:** [BAB 5 — Relasi Database](../BAB-05-Relasi-Database/README.md)
