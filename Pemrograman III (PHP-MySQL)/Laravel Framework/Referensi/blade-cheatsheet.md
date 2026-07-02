# Blade Templating — Cheatsheet

---

## Struktur File

Blade file berekstensi `.blade.php` dan disimpan di `resources/views/`.

```
resources/views/
├── layouts/
│   ├── app.blade.php          → Layout utama
│   └── admin.blade.php        → Layout admin
├── posts/
│   ├── index.blade.php        → Daftar post
│   └── show.blade.php         → Detail post
└── welcome.blade.php          → Halaman awal
```

---

## Sintaks Blade

### Output Data

```blade
{{ $variable }}                     <!-- Escape XSS -->
{!! $htmlContent !!}                <!-- Tanpa escape (hati-hati) -->
{{ $name ?: 'Default' }}            <!-- Ternary singkat -->
@{{ Ini akan tetap dikirim Vue/JS }} <!-- Literal -->
```

### Blade Directive

```blade
@if(count($posts) > 0)
    <p>Ada {{ count($posts) }} post</p>
@elseif(count($posts) === 0)
    <p>Tidak ada post</p>
@else
    <p>Error</p>
@endif

@unless(Auth::check())
    <p>Silakan login</p>
@endunless

@isset($user)
    <p>User: {{ $user->name }}</p>
@endisset

@empty($posts)
    <p>Post kosong</p>
@endempty

@switch($role)
    @case('admin')
        <p>Admin</p>
        @break
    @case('user')
        <p>User</p>
        @break
    @default
        <p>Guest</p>
@endswitch
```

### Looping

```blade
@for($i = 0; $i < 10; $i++)
    <p>Iterasi {{ $i }}</p>
@endfor

@foreach($posts as $post)
    <p>{{ $post->title }}</p>
@endforeach

@forelse($posts as $post)
    <p>{{ $post->title }}</p>
@empty
    <p>Tidak ada post</p>
@endforelse

@while($user->isActive())
    <p>User aktif</p>
@endwhile

<!-- Loop variables -->
@foreach($posts as $post)
    @if($loop->first) <ul> @endif
    <li>{{ $loop->iteration }}. {{ $post->title }}</li>
    @if($loop->last) </ul> @endif
@endforeach

{{-- $loop->first, $loop->last, $loop->iteration --}}
{{-- $loop->index, $loop->count, $loop->remaining --}}
```

---

## Layout

### Layout Utama (`layouts/app.blade.php`)

```blade
<!DOCTYPE html>
<html>
<head>
    <title>@yield('title', 'Default Title')</title>
    @stack('styles')
</head>
<body>
    <header>
        @include('partials.navbar')
    </header>

    <main>
        @yield('content')
    </main>

    <footer>
        @include('partials.footer')
    </footer>

    @stack('scripts')
</body>
</html>
```

### Halaman yang Menggunakan Layout

```blade
@extends('layouts.app')

@section('title', 'Halaman Post')

@section('content')
    <h1>Daftar Post</h1>
    @foreach($posts as $post)
        <article>{{ $post->title }}</article>
    @endforeach
@endsection

@push('styles')
    <link rel="stylesheet" href="/css/post.css">
@endpush

@push('scripts')
    <script src="/js/post.js"></script>
@endpush
```

### Components (Laravel 13)

```blade
{{-- resources/views/components/alert.blade.php --}}
<div class="alert alert-{{ $type }}">
    {{ $slot }}
</div>

{{-- Penggunaan --}}
<x-alert type="success">
    Data berhasil disimpan!
</x-alert>

<x-alert type="danger">
    Terjadi kesalahan!
</x-alert>
```

---

## Form

### CSRF Protection

```blade
<form method="POST" action="/posts">
    @csrf
    ...
</form>
```

### Method Spoofing

```blade
<form method="POST" action="/posts/1">
    @csrf
    @method('PUT')
    ...
</form>
```

### Old Input (setelah validasi gagal)

```blade
<input type="text" name="title" value="{{ old('title') }}">
<textarea name="body">{{ old('body') }}</textarea>

@error('title')
    <p class="error">{{ $message }}</p>
@enderror
```

---

## Include & Subview

```blade
@include('partials.navbar')
@include('partials.card', ['item' => $post])
@includeIf('partials.ads')           <!-- Jika file ada -->
@includeWhen(Auth::check(), 'partials.profile')
{{-- @each('partials.card', $posts, 'post') --}}
```

---

## Stack

```blade
@push('scripts')
    <script src="/js/library.js"></script>
@endpush

@prepend('styles')
    <link rel="stylesheet" href="/css/critical.css">
@endprepend

<!-- Di layout: -->
@stack('scripts')  <!-- Output: library.js -->
@stack('styles')   <!-- Output: critical.css -->
```

---

## Utility

```blade
@php
    $counter = 1;
    $total = count($posts);
@endphp

@dd($variable)     <!-- Dump & die -->
@dump($variable)   <!-- Dump saja -->

<!-- Auth -->
@auth
    <p>Selamat datang, {{ Auth::user()->name }}</p>
@endauth

@guest
    <p>Silakan login</p>
@endguest

<!-- Production only -->
@production
    <script src="/js/app.min.js"></script>
@endproduction

<!-- Environment -->
@env('local')
    <p>Mode development</p>
@endenv
```

---

## Tips

1. **Hindari logic berat di view** — simpan di controller atau service
2. **Gunakan layout** — jangan mengulang HTML di setiap halaman
3. **Gunakan component** — untuk elemen UI yang berulang
4. **Selalu gunakan `{{ }}`** — untuk mencegah XSS
5. **Gunakan `@error`** — untuk menampilkan pesan validasi
