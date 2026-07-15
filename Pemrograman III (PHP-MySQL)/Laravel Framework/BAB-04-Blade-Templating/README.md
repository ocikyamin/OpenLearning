# BAB 4 — Blade Templating

---

## 4.1 Tujuan Pembelajaran

Setelah menyelesaikan BAB 4 ini, teman-teman diharapkan mampu:

- Memahami konsep dan sintaks dasar Blade
- Membuat layout utama dan mewariskannya ke halaman lain
- Menggunakan komponen Blade untuk UI yang dapat digunakan ulang
- Menampilkan data di view dengan berbagai cara
- Menggunakan control structures seperti @if, @foreach, dan lain-lain
- Membuat form dengan CSRF protection
- Mengelola asset CSS/JavaScript dengan Vite

---

## 4.2 Pendahuluan

Pada BAB 3, kita belajar bagaimana route mengarahkan request ke Controller, dan Controller bisa mengembalikan teks atau view. Namun, aplikasi web yang sesungguhnya membutuhkan tampilan yang rapi dan terstruktur. Di sinilah **Blade** berperan.

Blade adalah **template engine** bawaan Laravel. Yang membedakan Blade dari template engine lain adalah: **Blade tidak membatasi kita untuk menggunakan kode PHP biasa** di dalam template. Artinya, kita bisa menggunakan sintaks Blade yang bersih, namun tetap memiliki fleksibilitas penuh jika diperlukan.

File Blade menggunakan ekstensi `.blade.php` dan disimpan di folder `resources/views/`.

### 4.2.1 Keunggulan Blade

- **Ringan** — tidak ada overhead yang berarti, semua template di-cache menjadi kode PHP biasa
- **Layout inheritance** — kita bisa membuat satu layout utama dan mewariskannya ke halaman lain
- **Components & slots** — potongan UI yang bisa digunakan ulang di berbagai halaman
- **Sintaks bersih** — kode menjadi lebih pendek dan mudah dibaca
- **Cache otomatis** — Blade secara otomatis meng-cache template untuk meningkatkan performa

---

## 4.3 Sintaks Dasar Blade

### 4.3.1 Menampilkan Data

```blade
{{ $nama }}                         {{-- Escape otomatis, aman dari XSS --}}
{{ $user->email }}                  {{-- Property dari object --}}
{{ $user['email'] }}                {{-- Key dari array --}}
{{ $angka1 + $angka2 }}             {{-- Ekspresi matematika --}}
{!! $htmlContent !!}                {{-- Tanpa escape, hati-hati jika ada input user --}}
```

> **Catatan:** Gunakan `{{ }}` hampir di semua situasi karena Blade akan meng-escape karakter berbahaya (XSS). Gunakan `{!! !!}` hanya jika benar-benar yakin kontennya aman.

### 4.3.2 Komentar Blade

Komentar di Blade tidak akan muncul di source HTML yang dikirim ke browser:

```blade
{{-- Ini komentar Blade, tidak akan tampak di HTML --}}
```

### 4.3.3 PHP Native di Blade

Jika perlu menulis kode PHP biasa di dalam template:

```blade
@php
    $judul = 'Blade Templating';
    $counter = 1;
    $total = 10;
@endphp

<p>{{ $judul }} — Halaman {{ $counter }} dari {{ $total }}</p>
```

---

## 4.4 Control Structures

### 4.4.1 Kondisional

```blade
@if($nilai >= 80)
    <p>Grade A</p>
@elseif($nilai >= 60)
    <p>Grade B</p>
@else
    <p>Grade C</p>
@endif

@unless(Auth::check())
    <p>Silakan login terlebih dahulu</p>
@endunless

@isset($user)
    <p>Nama: {{ $user->name }}</p>
@endisset

@empty($posts)
    <p>Belum ada artikel</p>
@endempty
```

### 4.4.2 Looping

```blade
@for($i = 0; $i < 10; $i++)
    <p>Iterasi ke-{{ $i + 1 }}</p>
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

### 4.4.3 Loop Variables

Dalam setiap perulangan `@foreach`, Blade menyediakan variabel `$loop` yang berisi informasi tentang perulangan saat ini:

```blade
@foreach($posts as $post)
    @if($loop->first)
        <div class="featured">
    @endif

    <div class="post">{{ $post->title }}</div>

    @if($loop->last)
        </div>
    @endif

    {{-- $loop->iteration   — nomor urut (mulai dari 1) --}}
    {{-- $loop->index       — nomor urut (mulai dari 0) --}}
    {{-- $loop->count       — total jumlah iterasi --}}
    {{-- $loop->remaining   — sisa iterasi yang belum dijalankan --}}
    {{-- $loop->first       — true jika iterasi pertama --}}
    {{-- $loop->last        — true jika iterasi terakhir --}}
    {{-- $loop->even        — true jika iterasi genap --}}
    {{-- $loop->odd         — true jika iterasi ganjil --}}
@endforeach
```

---

## 4.5 Layout dengan Template Inheritance

Salah satu fitur terkuat Blade adalah **template inheritance**. Kita bisa membuat satu layout utama yang berisi kerangka halaman (header, navbar, sidebar, footer), lalu setiap halaman bisa mewarisi layout tersebut dan mengisi bagian-bagian tertentu.

### 4.5.1 Membuat Layout Utama

Buat file `resources/views/layouts/app.blade.php`:

```blade
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Aplikasi Laravel')</title>
    @stack('styles')
</head>
<body>
    <nav class="navbar">
        <div class="container">
            <a href="/">Beranda</a>
            <a href="{{ route('posts.index') }}">Artikel</a>
            <a href="/about">Tentang</a>
        </div>
    </nav>

    <main class="container">
        @yield('content')
    </main>

    <footer class="footer">
        <p>&copy; {{ date('Y') }} — Pemrograman III</p>
    </footer>

    @stack('scripts')
</body>
</html>
```

### 4.5.2 Halaman yang Menggunakan Layout

Buat file `resources/views/posts/index.blade.php`:

```blade
@extends('layouts.app')

@section('title', 'Daftar Artikel')

@section('content')
    <h1>Daftar Artikel</h1>

    @forelse($posts as $post)
        <article class="card">
            <h2>{{ $post->title }}</h2>
            <p>{{ $post->excerpt }}</p>
            <a href="{{ route('posts.show', $post->id) }}">Baca Selengkapnya</a>
        </article>
    @empty
        <p>Belum ada artikel.</p>
    @endforelse
@endsection

@push('styles')
    <style>
        .card { margin-bottom: 1rem; padding: 1rem; border: 1px solid #ddd; }
    </style>
@endpush
```

### 4.5.3 Perbedaan @yield, @section, dan @show

```blade
{{-- Di layout --}}
@yield('title', 'Default Title')         {{-- Bagian dengan nilai default --}}

@section('sidebar')                       {{-- Bagian dengan konten default --}}
    <p>Sidebar default</p>
@show                                      {{-- @show = langsung menampilkan konten --}}

{{-- Di halaman anak --}}
@section('title', 'Judul Halaman')        {{-- String sederhana --}}

@section('sidebar')                       {{-- Konten kompleks --}}
    @parent                               {{-- Menyertakan konten default dari layout --}}
    <p>Konten tambahan dari halaman</p>
@endsection
```

---

## 4.6 Komponen Blade

Komponen adalah potongan UI yang bisa digunakan di berbagai halaman.

### 4.6.1 Anonymous Component (tanpa class)

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

### 4.6.2 Komponen dengan Props dan Slot

Buat file `resources/views/components/card.blade.php`:

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

Penggunaan di view:

```blade
<x-card title="Judul Artikel">
    <p>Ini adalah konten dari artikel.</p>
    <x-slot:footer>
        Dipublikasikan: 1 Januari 2026
    </x-slot:footer>
</x-card>
```

---

## 4.7 Include & Subview

Selain layout inheritance, kita juga bisa menyertakan file view lain ke dalam view:

```blade
{{-- Menyertakan file partial --}}
@include('partials.header')

{{-- Menyertakan dengan data tambahan --}}
@include('partials.card', ['item' => $post])

{{-- Menyertakan jika file tersedia --}}
@includeIf('partials.ads')

{{-- Menyertakan jika kondisi terpenuhi --}}
@includeWhen(Auth::check(), 'partials.profile')
@includeUnless(Auth::check(), 'partials.login')

{{-- Iterasi koleksi dengan partial --}}
@each('partials.card', $posts, 'post', 'partials.empty')
```

---

## 4.8 Form & CSRF

### 4.8.1 CSRF Protection

Laravel melindungi aplikasi dari serangan **CSRF (Cross-Site Request Forgery)**. Setiap form POST harus menyertakan token CSRF:

```blade
<form method="POST" action="/posts">
    @csrf
    <input type="text" name="title" placeholder="Judul">
    <textarea name="body" placeholder="Isi"></textarea>
    <button type="submit">Simpan</button>
</form>
```

### 4.8.2 Method Spoofing

HTML form hanya mendukung method GET dan POST. Untuk method PUT, PATCH, atau DELETE, kita menggunakan **method spoofing**:

```blade
{{-- Form dengan method PUT --}}
<form method="POST" action="/posts/1">
    @csrf
    @method('PUT')
    <input type="text" name="title">
    <button type="submit">Update</button>
</form>

{{-- Form dengan method DELETE --}}
<form method="POST" action="/posts/1">
    @csrf
    @method('DELETE')
    <button type="submit">Hapus</button>
</form>
```

### 4.8.3 Old Input & Error Messages

Saat validasi form gagal, Laravel akan mengembalikan input sebelumnya dan pesan error. Blade menyediakan helper untuk menampilkannya:

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

## 4.9 Stacks

Stacks memungkinkan halaman anak menambahkan konten CSS atau JavaScript ke layout utama secara terstruktur:

```blade
{{-- Di layout --}}
<head>
    @stack('styles')
</head>
<body>
    @stack('scripts')
</body>

{{-- Di halaman anak --}}
@push('scripts')
    <script src="/js/custom.js"></script>
@endpush

@push('styles')
    <link rel="stylesheet" href="/css/custom.css">
@endpush

{{-- Prepends — menambahkan di awal stack --}}
@prepend('scripts')
    <script>console.log('Akan tampil pertama!');</script>
@endprepend
```

---

## 4.10 Vite & Asset

Laravel 13 menggunakan **Vite** sebagai bundler untuk CSS dan JavaScript.

### 4.10.1 Di Layout

```blade
{{-- Di bagian <head> --}}
@vite(['resources/css/app.css', 'resources/js/app.js'])
```

### 4.10.2 Di Terminal

```bash
npm install && npm run build     # Untuk production
npm run dev                      # Untuk development (hot reload)
```

### 4.10.3 Menyertakan Asset dari Public

```blade
<img src="{{ asset('images/logo.png') }}" alt="Logo">
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
<script src="{{ asset('js/script.js') }}"></script>
```

---

## 4.11 Praktikum: Membuat Layout dan Halaman

Pada praktikum ini, kita akan membuat layout utama dan beberapa halaman menggunakan Blade. Pastikan project Laravel sudah siap dan server berjalan.

### 4.11.1 Membuat Layout Utama

Buat folder `resources/views/layouts/` jika belum ada. Lalu buat file `resources/views/layouts/app.blade.php`:

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
        <a href="/">Beranda</a>
        <a href="{{ route('posts.index') }}">Artikel</a>
        <a href="/about">Tentang</a>
    </nav>

    <main>
        @yield('content')
    </main>

    <footer>
        &copy; 2026 — Pemrograman III
    </footer>
</body>
</html>
```

### 4.11.2 Membuat Halaman Beranda

Buat file `resources/views/home.blade.php`:

```blade
@extends('layouts.app')

@section('title', 'Beranda')

@section('content')
    <h1>Selamat Datang</h1>
    <p>Ini adalah aplikasi Laravel pertama saya menggunakan Blade templating.</p>
@endsection
```

### 4.11.3 Membuat Halaman Tentang

Buat file `resources/views/about.blade.php`:

```blade
@extends('layouts.app')

@section('title', 'Tentang')

@section('content')
    <h1>Tentang Kami</h1>
    <p>Aplikasi ini dibuat untuk pembelajaran Pemrograman III di Laravel Framework.</p>

    <ul>
        <li>Laravel 13</li>
        <li>Blade Templating</li>
        <li>MySQL</li>
    </ul>
@endsection
```

### 4.11.4 Menambahkan Route

Buka `routes/web.php` dan tambahkan:

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

### 4.11.5 Membuat View Daftar Artikel

Buat folder `resources/views/posts/` jika belum ada. Lalu buat file `resources/views/posts/index.blade.php`:

```blade
@extends('layouts.app')

@section('title', 'Daftar Artikel')

@section('content')
    <h1>Daftar Artikel</h1>

    @forelse($posts as $post)
        <article>
            <h2>{{ $post['title'] }}</h2>
            <p>{{ $post['excerpt'] }}</p>
        </article>
    @empty
        <p>Tidak ada artikel.</p>
    @endforelse
@endsection
```

### 4.11.6 Uji Coba

Jalankan server (`php artisan serve`), lalu akses URL berikut:

| URL | Yang Diharapkan |
|-----|-----------------|
| `http://localhost:8000/` | Halaman beranda dengan layout utama |
| `http://localhost:8000/about` | Halaman tentang dengan layout yang sama |
| `http://localhost:8000/posts` | Daftar artikel dengan perulangan Blade |

---

## 4.12 Rangkuman

| Konsep | Sintaks |
|--------|---------|
| Output data | `{{ $var }}` (escape otomatis) |
| Tanpa escape | `{!! $html !!}` |
| Layout induk | `@extends('layouts.app')` |
| Section | `@section('content') ... @endsection` |
| Tempat konten | `@yield('content')` |
| Komponen | `<x-alert type="success">` |
| Kondisional | `@if`, `@elseif`, `@else`, `@unless` |
| Looping | `@for`, `@foreach`, `@forelse` |
| CSRF token | `@csrf` |
| Method spoofing | `@method('PUT')` |
| Stack CSS/JS | `@push`, `@stack` |
| Old input | `old('field')` |
| Error | `@error('field')` |

---

## 4.13 Referensi

- [Blade Templates](https://laravel.com/docs/13.x/blade)
- [Blade Components](https://laravel.com/docs/13.x/blade#components)
- [Vite in Laravel](https://laravel.com/docs/13.x/vite)

---

**Lanjut ke:** [BAB 5 — Migration & Eloquent ORM](../BAB-05-Migration-dan-Eloquent-ORM/README.md)

**Kembali ke:** [BAB 3 — Routing & Controller](../BAB-03-Routing-dan-Controller/README.md)
