# Pertemuan 3 — Blade Templating

---

## Tujuan Pembelajaran

Setelah pertemuan ini, mahasiswa diharapkan mampu:

- Memahami sintaks dasar Blade
- Membuat layout utama dan mewariskannya ke halaman lain
- Menggunakan komponen Blade
- Menampilkan data di view dengan berbagai cara
- Menggunakan control structures (@if, @foreach, dll)
- Membuat form dengan CSRF protection
- Mengelola asset CSS/JavaScript dengan Vite

---

## Apa Itu Blade?

Blade adalah **template engine** bawaan Laravel. Bedanya dengan template engine lain: **Blade tidak membatasi kita untuk menggunakan PHP kode biasa** di dalam template.

File Blade berekstensi `.blade.php` dan disimpan di `resources/views/`.

### Keunggulan Blade

- Ringan — tidak ada overhead di cache
- Mendukung inheritance layout
- Components & slots
- Sintaks bersih dan mudah dibaca
- Otomatis di-cache untuk performa

---

## 1. Sintaks Dasar Blade

### Output Data

```blade
{{ $nama }}                         <!-- Escape XSS (aman) -->
{{ $user->email }}                  <!-- Property object -->
{{ $user['email'] }}                <!-- Array -->
{{ $angka1 + $angka2 }}             <!-- Ekspresi -->
{!! $htmlContent !!}                <!-- Tanpa escape (hati-hati) -->
```

### Blade Comment (tidak tampil di HTML)

```blade
{{-- Ini komentar Blade, tidak tampak di source HTML --}}
```

### PHP Native di Blade

```blade
@php
    $judul = 'Blade Templating';
    $counter = 1;
    $total = 10;
@endphp

<p>{{ $judul }} - Halaman {{ $counter }} dari {{ $total }}</p>
```

---

## 2. Control Structures

### Kondisional

```blade
@if($nilai >= 80)
    <p>Grade A</p>
@elseif($nilai >= 60)
    <p>Grade B</p>
@else
    <p>Grade C</p>
@endif

@unless(Auth::check())
    <p>Silakan login</p>
@endunless

@isset($user)
    <p>Nama: {{ $user->name }}</p>
@endisset

@empty($posts)
    <p>Belum ada post</p>
@endempty
```

### Looping

```blade
@for($i = 0; $i < 10; $i++)
    <p>Iterasi {{ $i + 1 }}</p>
@endfor

@foreach($users as $user)
    <p>{{ $user->name }} ({{ $user->email }})</p>
@endforeach

@forelse($posts as $post)
    <article>
        <h3>{{ $post->title }}</h3>
        <p>{{ $post->excerpt }}</p>
    </article>
@empty
    <p>Tidak ada artikel.</p>
@endforelse

@while($item = array_shift($items))
    <p>{{ $item }}</p>
@endwhile
```

### Loop Variables

```blade
@foreach($posts as $post)
    @if($loop->first)
        <div class="featured">
    @endif

    <div class="post">{{ $post->title }}</div>

    @if($loop->last)
        </div>
    @endif

    {{-- $loop->iteration — nomor urut (mulai 1) --}}
    {{-- $loop->index — nomor urut (mulai 0) --}}
    {{-- $loop->count — total iterasi --}}
    {{-- $loop->remaining — sisa iterasi --}}
    {{-- $loop->first — boolean, true jika iterasi pertama --}}
    {{-- $loop->last — boolean, true jika iterasi terakhir --}}
@endforeach
```

---

## 3. Layout dengan Template Inheritance

Ini adalah fitur utama Blade. Kita buat satu **layout utama** yang bisa digunakan oleh semua halaman.

### Membuat Layout

`resources/views/layouts/app.blade.php`:

```blade
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Aplikasi Laravel')</title>
    <link rel="stylesheet" href="/css/app.css">
    @stack('styles')
</head>
<body>
    <nav class="navbar">
        <div class="container">
            <a href="/">Home</a>
            <a href="{{ route('posts.index') }}">Posts</a>
            <a href="/about">About</a>
        </div>
    </nav>

    <main class="container">
        @yield('content')
    </main>

    <footer class="footer">
        <p>&copy; 2026 — Pemrograman III</p>
    </footer>

    @stack('scripts')
</body>
</html>
```

### Halaman yang Menggunakan Layout

`resources/views/posts/index.blade.php`:

```blade
@extends('layouts.app')

@section('title', 'Daftar Post')

@section('content')
    <h1>Daftar Post</h1>

    @forelse($posts as $post)
        <article class="card">
            <h2>{{ $post->title }}</h2>
            <p>{{ $post->excerpt }}</p>
            <a href="{{ route('posts.show', $post->id) }}">Baca Selengkapnya</a>
        </article>
    @empty
        <p>Belum ada post.</p>
    @endforelse
@endsection

@push('styles')
    <style>
        .card { margin-bottom: 1rem; padding: 1rem; border: 1px solid #ddd; }
    </style>
@endpush
```

### @yield vs @section vs @show

```blade
{{-- Di layout --}}
@yield('title', 'Default')           <!-- Bagian dengan default -->
@section('sidebar')                  <!-- Bagian dengan default -->
    <p>Sidebar default</p>
@show                                 <!-- @show = section + yield -->

{{-- Di halaman --}}
@section('title', 'Judul Halaman')   <!-- String sederhana -->
@section('sidebar')                   <!-- Konten kompleks -->
    @parent                           <!-- Sertakan konten default layout -->
    <p>Konten tambahan dari halaman</p>
@endsection
```

---

## 4. Komponen Blade

Komponen adalah potongan UI yang bisa digunakan ulang.

### Anonymous Component (tanpa class)

Buat file `resources/views/components/alert.blade.php`:

```blade
<div class="alert alert-{{ $type }}">
    {{ $slot }}
</div>
```

Gunakan di view:

```blade
<x-alert type="success">
    Data berhasil disimpan!
</x-alert>

<x-alert type="danger">
    Terjadi kesalahan saat menyimpan data.
</x-alert>
```

### Komponen dengan Props

`resources/views/components/card.blade.php`:

```blade
<div class="card">
    <h3>{{ $title }}</h3>
    <div class="card-body">
        {{ $slot }}
    </div>
    @if(isset($footer))
        <div class="card-footer">
            {{ $footer }}
        </div>
    @endif
</div>
```

Penggunaan:

```blade
<x-card title="Judul Artikel">
    <p>Ini adalah konten artikel.</p>
    <x-slot:footer>
        Dipublikasikan: 1 Januari 2026
    </x-slot:footer>
</x-card>
```

---

## 5. Include & Subview

```blade
{{-- Menyertakan file view lain --}}
@include('partials.header')

{{-- Include dengan data --}}
@include('partials.card', ['item' => $post])

{{-- Include jika file ada --}}
@includeIf('partials.ads')

{{-- Include jika kondisi terpenuhi --}}
@includeWhen(Auth::check(), 'partials.profile')
@includeUnless(Auth::check(), 'partials.login')

{{-- Include dari koleksi --}}
@each('partials.card', $posts, 'post', 'partials.empty')
```

---

## 6. Form & CSRF

### CSRF Protection

Semua form POST di Laravel memerlukan **token CSRF**:

```blade
<form method="POST" action="/posts">
    @csrf
    <input type="text" name="title" placeholder="Judul">
    <textarea name="body" placeholder="Isi"></textarea>
    <button type="submit">Simpan</button>
</form>
```

### Method Spoofing

HTML form hanya mendukung GET dan POST. Untuk PUT/PATCH/DELETE:

```blade
{{-- PUT --}}
<form method="POST" action="/posts/1">
    @csrf
    @method('PUT')
    ...
</form>

{{-- DELETE --}}
<form method="POST" action="/posts/1">
    @csrf
    @method('DELETE')
    <button type="submit">Hapus</button>
</form>
```

### Old Input & Error

```blade
<form method="POST" action="/posts">
    @csrf

    <input
        type="text"
        name="title"
        value="{{ old('title') }}"
        class="@error('title') is-invalid @enderror"
    >

    @error('title')
        <p class="error">{{ $message }}</p>
    @enderror

    <textarea name="body">{{ old('body') }}</textarea>

    @error('body')
        <p class="error">{{ $message }}</p>
    @enderror

    <button type="submit">Simpan</button>
</form>
```

---

## 7. Stacks

Stacks memungkinkan kita menambahkan konten CSS/JS dari halaman anak ke layout utama.

```blade
{{-- Di layout: --}}
<head>
    @stack('styles')
</head>
<body>
    @stack('scripts')
</body>

{{-- Di halaman: --}}
@push('scripts')
    <script src="/js/custom.js"></script>
@endpush

@push('styles')
    <link rel="stylesheet" href="/css/custom.css">
@endpush

{{-- Prepends (ditambahkan di awal): --}}
@prepend('scripts')
    <script>console.log('Pertama!');</script>
@endprepend
```

---

## 8. Vite & Asset

Laravel 13 menggunakan **Vite** sebagai bundler.

### Di Layout

```blade
{{-- Di <head> --}}
@vite(['resources/css/app.css', 'resources/js/app.js'])
```

### Di Terminal

```bash
npm install && npm run build     # Production
npm run dev                      # Development (hot reload)
```

### Menyertakan Asset dari Public

```blade
<img src="{{ asset('images/logo.png') }}" alt="Logo">
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
<script src="{{ asset('js/script.js') }}"></script>
```

---

## Praktikum: Membuat Layout & Halaman

### 1. Buat Layout Utama

`resources/views/layouts/app.blade.php`:

```blade
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'My App')</title>
    @vite(['resources/css/app.css'])
</head>
<body>
    <nav>
        <a href="/">Home</a>
        <a href="{{ route('posts.index') }}">Posts</a>
        <a href="/about">About</a>
    </nav>

    <main>
        @yield('content')
    </main>

    <footer>
        &copy; 2026
    </footer>

    @vite(['resources/js/app.js'])
</body>
</html>
```

### 2. Buat Halaman Home

`resources/views/home.blade.php`:

```blade
@extends('layouts.app')

@section('title', 'Home')

@section('content')
    <h1>Selamat Datang</h1>
    <p>Ini adalah aplikasi Laravel pertama saya.</p>
@endsection
```

### 3. Buat Halaman About

`resources/views/about.blade.php`:

```blade
@extends('layouts.app')

@section('title', 'Tentang')

@section('content')
    <h1>Tentang Kami</h1>
    <p>Aplikasi ini dibuat untuk pembelajaran Pemrograman III.</p>

    <ul>
        <li>Laravel 13</li>
        <li>Blade Templating</li>
        <li>MySQL</li>
    </ul>
@endsection
```

### 4. Tambahkan Route

`routes/web.php`:

```php
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

Route::get('/about', function () {
    return view('about');
});

Route::get('/posts', function () {
    $posts = [
        ['id' => 1, 'title' => 'Belajar Laravel', 'excerpt' => 'Pengenalan Laravel untuk pemula.'],
        ['id' => 2, 'title' => 'Blade Templating', 'excerpt' => 'Template engine Laravel.'],
        ['id' => 3, 'title' => 'Eloquent ORM', 'excerpt' => 'Interaksi database dengan Eloquent.'],
    ];

    return view('posts.index', compact('posts'));
})->name('posts.index');
```

### 5. Buat View Posts Index

`resources/views/posts/index.blade.php`:

```blade
@extends('layouts.app')

@section('title', 'Daftar Post')

@section('content')
    <h1>Daftar Post</h1>

    @forelse($posts as $post)
        <article>
            <h2>{{ $post['title'] }}</h2>
            <p>{{ $post['excerpt'] }}</p>
        </article>
    @empty
        <p>Tidak ada post.</p>
    @endforelse
@endsection
```

---

## Rangkuman

| Konsep | Sintaks |
|--------|---------|
| Output data | `{{ $var }}` |
| Escape HTML | `{{ $var }}` (otomatis) |
| Tanpa escape | `{!! $html !!}` |
| Layout | `@extends('layouts.app')` |
| Section | `@section('content') ... @endsection` |
| Yield | `@yield('title')` |
| Component | `<x-alert type="success">` |
| Kondisi | `@if`, `@elseif`, `@else`, `@unless` |
| Looping | `@for`, `@foreach`, `@forelse` |
| CSRF | `@csrf` |
| Method | `@method('PUT')` |
| Stack | `@push`, `@stack` |
| Old input | `old('field')` |
| Error | `@error('field')` |

---

## Referensi

- [Blade Templates](https://laravel.com/docs/13.x/blade)
- [Blade Components](https://laravel.com/docs/13.x/blade#components)
- [Vite in Laravel](https://laravel.com/docs/13.x/vite)

---

**Lanjut ke:** [Pertemuan 4 — Migration & Eloquent ORM](../04-Migration-Eloquent/README.md)

**Kembali ke:** [Pertemuan 2 — Routing & Controller](../02-Routing-Controller/README.md)
