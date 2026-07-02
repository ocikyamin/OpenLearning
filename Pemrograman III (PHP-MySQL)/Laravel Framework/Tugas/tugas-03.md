# Tugas 3 — Blade Templating

---

## Tujuan

Mahasiswa mampu membuat layout utama, halaman dengan template inheritance, dan menampilkan data menggunakan Blade.

---

## Soal

Buat aplikasi dengan **layout utama** dan **beberapa halaman** seperti di bawah ini.

### 1. Layout Utama

Buat file `resources/views/layouts/main.blade.php` dengan struktur:

- `<title>` dinamis menggunakan `@yield`
- Navigasi dengan link: **Home**, **Produk**, **Tentang**, **Kontak**
- Bagian `@yield('content')` untuk konten utama
- Sidebar (opsional, bisa menggunakan `@section('sidebar')`)
- Footer: "© 2026 — Toko Laravel"

### 2. Halaman Home (`/`)

Menggunakan layout utama, menampilkan:

- Judul "Selamat Datang di Toko Kami"
- 3-4 produk unggulan dalam bentuk **card component** (gunakan `<x-card>`)
- Setiap card berisi: nama produk, harga, dan tombol "Detail"

### 3. Halaman Produk (`/produk`)

- Menampilkan daftar produk dalam bentuk **tabel HTML**
- Data produk dikirim dari **controller** (bukan closure di route)
- Kolom tabel: No, Nama, Harga, Kategori, Aksi
- Jika array produk kosong, tampilkan pesan "Tidak ada produk"
- Gunakan `@forelse`

### 4. Halaman Detail Produk (`/produk/{id}`)

- Menampilkan detail satu produk: nama, harga, kategori, deskripsi
- Jika ID tidak ditemukan, tampilkan pesan error "Produk tidak ditemukan"
- Gunakan komponen `x-alert` untuk menampilkan pesan error

### 5. Halaman Tentang (`/tentang`)

- Layout utama, judul "Tentang Toko Kami"
- Paragraf tentang toko
- Daftar kelebihan menggunakan `@foreach`

### 6. Halaman Kontak (`/kontak`)

- Form kontak sederhana dengan method POST dan `@csrf`
- Field: Nama, Email, Pesan
- Gunakan `old()` untuk mengisi nilai setelah submit
- Jika ada error validasi, tampilkan menggunakan `@error`

### 7. Komponen Blade

Buat komponen berikut di `resources/views/components/`:

**`card.blade.php`**:
```blade
<div class="card">
    <h3>{{ $title }}</h3>
    <div class="card-body">{{ $slot }}</div>
    @if(isset($footer))<div class="card-footer">{{ $footer }}</div>@endif
</div>
```

**`alert.blade.php`**:
```blade
<div class="alert alert-{{ $type ?? 'info' }}">
    {{ $slot }}
</div>
```

---

## Data Produk

Gunakan data berikut di controller:

```php
$produk = [
    ['id' => 1, 'nama' => 'Laptop Pro 15', 'harga' => 15000000, 'kategori' => 'Elektronik', 'deskripsi' => 'Laptop dengan spesifikasi tinggi untuk produktivitas.'],
    ['id' => 2, 'nama' => 'Smartphone X', 'harga' => 5000000, 'kategori' => 'Elektronik', 'deskripsi' => 'Smartphone dengan kamera canggih.'],
    ['id' => 3, 'nama' => 'Kemeja Flanel', 'harga' => 200000, 'kategori' => 'Fashion', 'deskripsi' => 'Kemeja flanel hangat dan nyaman.'],
    ['id' => 4, 'nama' => 'Sepatu Olahraga', 'harga' => 350000, 'kategori' => 'Fashion', 'deskripsi' => 'Sepatu olahraga ringan dan fleksibel.'],
    ['id' => 5, 'nama' => 'Novel Petualangan', 'harga' => 85000, 'kategori' => 'Buku', 'deskripsi' => 'Novel petualangan seru untuk dibaca.'],
];
```

---

## Ketentuan Pengumpulan

- Kumpulkan file: semua file Blade di `resources/views/`, Controller, dan `routes/web.php`
- Sertakan screenshot setiap halaman
- Batas pengumpulan: sebelum pertemuan berikutnya

---

## Rubrik Penilaian

| Aspek | Bobot |
|-------|-------|
| Layout utama (navbar, title, footer) | 15% |
| Halaman Home dengan card component | 15% |
| Halaman Produk dengan tabel & @forelse | 20% |
| Halaman Detail dengan penanganan error | 15% |
| Halaman Tentang & Kontak (form + csrf) | 15% |
| Komponen Blade (card, alert) | 10% |
| Kerapihan kode & konsistensi | 10% |
