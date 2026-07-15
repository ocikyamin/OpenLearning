# BAB 9 — Upload File & Storage

---

## 9.1 Tujuan Pembelajaran

Setelah menyelesaikan BAB 9 ini, teman-teman diharapkan mampu:

- Menjelaskan konsep file storage di Laravel
- Mengkonfigurasi dan membuat storage link
- Membuat form upload file dengan validasi
- Menyimpan file ke storage
- Menampilkan file (gambar) di halaman web
- Mendownload file
- Menghapus file dari storage

---

## 9.2 Pendahuluan

Banyak aplikasi web membutuhkan fitur upload file — foto profil, gambar artikel, lampiran dokumen, dan lain-lain. Laravel menyediakan sistem file storage yang fleksibel dan aman melalui **Laravel Filesystem**.

Laravel menggunakan **disks** untuk menentukan di mana file disimpan:

- `local` — disimpan di `storage/app/` (tidak bisa diakses publik)
- `public` — disimpan di `storage/app/public/` (bisa diakses publik via symlink)
- `s3` — disimpan di Amazon S3 (cloud storage)

Untuk keperluan belajar, kita akan menggunakan disk `public`.

---

## 9.3 Konfigurasi Storage

### 9.3.1 Storage Link

File yang diupload ke disk `public` disimpan di `storage/app/public/`. Agar file-file ini bisa diakses dari browser, kita perlu membuat **simbolic link** dari `public/storage` ke `storage/app/public`.

```bash
php artisan storage:link
```

Setelah perintah ini dijalankan, kita bisa mengakses file di `http://localhost:8000/storage/nama-file.jpg`.

### 9.3.2 Konfigurasi di `.env`

Secara default, Laravel menggunakan disk `local`. Untuk upload file publik, kita akan menggunakan disk `public`. Konfigurasi ada di `config/filesystems.php`.

```php
'disks' => [
    'local' => [
        'driver' => 'local',
        'root' => storage_path('app/private'),
    ],

    'public' => [
        'driver' => 'local',
        'root' => storage_path('app/public'),
        'url' => env('APP_URL').'/storage',
        'visibility' => 'public',
    ],

    // ...
],
```

---

## 9.4 Upload File Dasar

### 9.4.1 Form Upload

```blade
<form method="POST" action="{{ route('files.store') }}" enctype="multipart/form-data">
    @csrf

    <input type="file" name="file">

    @error('file')
        <p class="text-red-500">{{ $message }}</p>
    @enderror

    <button type="submit">Upload</button>
</form>
```

**Penting:** Jangan lupa tambahkan `enctype="multipart/form-data"` pada form yang mengandung upload file. Tanpa ini, file tidak akan terkirim.

### 9.4.2 Menyimpan File di Controller

```php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

public function store(Request $request)
{
    $validated = $request->validate([
        'file' => ['required', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:2048'],
    ]);

    $path = $request->file('file')->store('uploads', 'public');

    // Alternatif:
    // $path = Storage::disk('public')->put('uploads', $request->file('file'));

    return back()->with('success', 'File berhasil diupload');
}
```

### 9.4.3 Menyimpan dengan Nama Kustom

```php
$path = $request->file('file')->storeAs(
    'uploads', 'nama-file.' . $request->file('file')->extension(), 'public'
);
```

Atau menggunakan nama asli file:

```php
$path = $request->file('file')->storePubliclyAs(
    'uploads', $request->file('file')->getClientOriginalName(), 'public'
);
```

### 9.4.4 Path yang Dihasilkan

```
storage/app/public/uploads/abc123.jpg
         ↓ (symlink)
public/storage/uploads/abc123.jpg
         ↓
http://localhost:8000/storage/uploads/abc123.jpg
```

---

## 9.5 Validasi File

### 9.5.1 Aturan Validasi

| Aturan | Fungsi |
|--------|--------|
| `file` | Input harus berupa file |
| `image` | Harus file gambar |
| `mimes:jpg,png,pdf` | Ekstensi file yang diizinkan |
| `max:2048` | Ukuran maksimal dalam KB (2048 KB = 2 MB) |
| `min:100` | Ukuran minimal dalam KB |

### 9.5.2 Contoh Validasi di Form Request

```php
public function rules(): array
{
    return [
        'avatar' => ['required', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
        'dokumen' => ['nullable', 'file', 'mimes:pdf,doc,docx', 'max:5120'],
    ];
}

public function messages(): array
{
    return [
        'avatar.required' => 'Foto profil wajib diupload.',
        'avatar.image' => 'File harus berupa gambar.',
        'avatar.mimes' => 'Format gambar harus JPG atau PNG.',
        'avatar.max' => 'Ukuran gambar maksimal 2 MB.',
    ];
}
```

---

## 9.6 Menampilkan File

### 9.6.1 Mendapatkan URL File

```php
use Illuminate\Support\Facades\Storage;

$url = Storage::url('uploads/abc123.jpg');
// Hasil: /storage/uploads/abc123.jpg

$fullUrl = Storage::disk('public')->url('uploads/abc123.jpg');
// Hasil: http://localhost:8000/storage/uploads/abc123.jpg
```

### 9.6.2 Menampilkan Gambar di Blade

```blade
<img src="{{ Storage::url($article->image) }}" alt="{{ $article->title }}">

{{-- Atau jika path disimpan lengkap --}}
<img src="{{ asset('storage/' . $article->image) }}" alt="{{ $article->title }}">
```

### 9.6.3 Cek Apakah File Ada

```php
if (Storage::disk('public')->exists($path)) {
    // File tersedia
}
```

---

## 9.7 Download File

```php
public function download($id)
{
    $file = FileModel::findOrFail($id);

    return Storage::disk('public')->download($file->path, $file->original_name);
}
```

Di Blade:

```blade
<a href="{{ route('files.download', $file) }}" class="text-blue-600">
    Download {{ $file->original_name }}
</a>
```

---

## 9.8 Hapus File

### 9.8.1 Menghapus dari Storage

```php
use Illuminate\Support\Facades\Storage;

// Hapus file
Storage::disk('public')->delete($path);

// Hapus direktori
Storage::disk('public')->deleteDirectory('uploads/lama');
```

### 9.8.2 Hapus File Saat Data Dihapus

Gunakan event `deleting` di model untuk menghapus file otomatis:

```php
use Illuminate\Support\Facades\Storage;

protected static function booted(): void
{
    static::deleting(function ($model) {
        if ($model->image) {
            Storage::disk('public')->delete($model->image);
        }
    });
}
```

---

## 9.9 Image Manipulation (Opsional)

Untuk memanipulasi gambar (resize, crop, filter), kita bisa menggunakan library **Intervention Image**:

```bash
composer require intervention/image-laravel
```

Contoh resize gambar setelah upload:

```php
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;

$image = Image::read($request->file('avatar'));
$image->resize(300, 300);

$path = 'avatars/' . uniqid() . '.jpg';
Storage::disk('public')->put($path, $image->encode());

return $path;
```

---

## 9.10 Praktikum: Upload Gambar Artikel

Pada praktikum ini, kita akan menambahkan fitur upload gambar ke aplikasi artikel dari BAB 8.

### 9.10.1 Persiapan

Gunakan project dari BAB 8 atau buat project Breeze baru.

```bash
composer create-project laravel/laravel blog-upload
cd blog-upload
composer require laravel/breeze
php artisan breeze:install blade
npm install && npm run build
```

Setting database MySQL di `.env` dan buat database.

### 9.10.2 Migration — Tambah Kolom Image

```bash
php artisan make:migration add_image_to_articles_table
```

```php
Schema::table('articles', function (Blueprint $table) {
    $table->string('image')->nullable()->after('excerpt');
});
```

```bash
php artisan migrate
```

### 9.10.3 Model — Update $fillable

```php
protected $fillable = [
    'title', 'slug', 'body', 'excerpt', 'image',
    'category', 'published', 'user_id',
];
```

### 9.10.4 Form Request — Validasi File

`app/Http/Requests/StoreArticleRequest.php`:

```php
public function rules(): array
{
    return [
        'title' => ['required', 'max:255'],
        'slug' => ['required', 'alpha_dash', Rule::unique('articles')],
        'body' => ['required'],
        'excerpt' => ['nullable', 'max:500'],
        'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
        'category' => ['required', Rule::in(['Teknologi', 'Olahraga', 'Pendidikan', 'Hiburan'])],
        'published' => ['boolean'],
    ];
}
```

### 9.10.5 Controller — Simpan File

Method `store` di `ArticleController`:

```php
public function store(StoreArticleRequest $request)
{
    $data = $request->validated();

    if ($request->hasFile('image')) {
        $data['image'] = $request->file('image')->store('articles', 'public');
    }

    $data['user_id'] = $request->user()->id;

    Article::create($data);

    return redirect()->route('articles.index')
        ->with('success', 'Artikel berhasil dibuat');
}
```

Method `update`:

```php
public function update(UpdateArticleRequest $request, Article $article)
{
    $data = $request->validated();

    if ($request->hasFile('image')) {
        // Hapus gambar lama
        if ($article->image) {
            Storage::disk('public')->delete($article->image);
        }

        $data['image'] = $request->file('image')->store('articles', 'public');
    }

    $article->update($data);

    return redirect()->route('articles.index')
        ->with('success', 'Artikel berhasil diperbarui');
}
```

Method `destroy` (hapus file otomatis):

```php
public function destroy(Article $article)
{
    if ($article->image) {
        Storage::disk('public')->delete($article->image);
    }

    $article->delete();

    return redirect()->route('articles.index')
        ->with('success', 'Artikel berhasil dihapus');
}
```

### 9.10.6 View — Form Upload

Di form create dan edit, tambahkan input file:

```blade
<div class="mb-4">
    <label class="block font-semibold mb-1">Gambar Artikel</label>
    <input type="file" name="image"
           class="w-full border rounded px-3 py-2 @error('image') border-red-500 @enderror">
    @error('image')
        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
    @enderror
</div>
```

Untuk form edit, tampilkan gambar yang sudah ada:

```blade
@if($article->image)
    <div class="mb-2">
        <img src="{{ Storage::url($article->image) }}" class="w-48 rounded shadow">
    </div>
@endif
```

### 9.10.7 View — Tampilkan Gambar

Di halaman daftar artikel:

```blade
@if($article->image)
    <img src="{{ Storage::url($article->image) }}" alt="{{ $article->title }}"
         class="w-full h-48 object-cover rounded mb-2">
@endif
```

Di halaman detail:

```blade
@if($article->image)
    <img src="{{ Storage::url($article->image) }}" alt="{{ $article->title }}"
         class="w-full max-w-2xl rounded-lg shadow mb-6">
@endif
```

### 9.10.8 Storage Link

Jangan lupa jalankan:

```bash
php artisan storage:link
```

### 9.10.9 Uji Coba

1. Jalankan server: `php artisan serve`
2. Buka halaman tambah artikel
3. Upload gambar dan isi form
4. Submit — gambar akan tampil di daftar dan detail artikel
5. Edit artikel — upload gambar baru, gambar lama akan terganti
6. Hapus artikel — gambar akan terhapus otomatis

---

## 9.11 Rangkuman

| Konsep | Intinya |
|--------|---------|
| `php artisan storage:link` | Membuat symlink public/storage |
| `enctype="multipart/form-data"` | Wajib untuk form upload |
| `store('folder', 'disk')` | Simpan file |
| `Storage::url('path')` | Dapatkan URL file |
| `mimes:jpg,png` | Validasi ekstensi file |
| `max:2048` | Validasi ukuran file (KB) |
| `Storage::delete('path')` | Hapus file |
| `deleting` event | Hapus file otomatis saat data dihapus |

---

## 9.12 Referensi

- [Laravel Filesystem](https://laravel.com/docs/13.x/filesystem)
- [Laravel File Uploads](https://laravel.com/docs/13.x/filesystem#file-uploads)
- [Intervention Image](https://image.intervention.io/)
- [MDN: File Input](https://developer.mozilla.org/en-US/docs/Web/HTML/Element/input/file)

---

**Lanjut ke:** [BAB 10 — Livewire](../BAB-10-Livewire/README.md)

**Kembali ke:** [BAB 8 — Authentication & Middleware](../BAB-08-Authentication-dan-Middleware/README.md)
