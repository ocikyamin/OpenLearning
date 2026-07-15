# Tugas 10 — Livewire

---

## Tujuan

Mahasiswa mampu membuat komponen Livewire interaktif dengan data binding, action, validasi realtime, search, dan pagination.

---

## Soal

### 1. Persiapan

Buat project baru dan database MySQL `db_tugas10`.

```bash
composer create-project laravel/laravel tugas-livewire
cd tugas-livewire
composer require livewire/livewire
```

Atur database di `.env`. Jalankan migrasi bawaan Laravel.

### 2. Migration & Model

Buat tabel **articles** dengan kolom:

| Kolom | Tipe | Keterangan |
|-------|------|------------|
| `id` | auto-increment | Primary key |
| `title` | string(200) | Judul artikel |
| `slug` | string(200) | Unique |
| `content` | text | Isi artikel |
| `status` | string(20) | Default 'draft' (draft/published/archived) |
| `author` | string(100) | Nama penulis |
| `user_id` | foreign key | → users |
| `timestamps` | — | — |

Buat model `Article` dengan `$fillable`, `casts()`, relasi `user()`.

Buat factory dan seeder untuk membuat 1 user admin dan 50 artikel.

### 3. Livewire Component: ArticleList

Buat komponen `App\Livewire\ArticleList` dengan fitur:

**Properties:**
```php
public $search = '';
public $status = '';
public $sortField = 'created_at';
public $sortDirection = 'desc';
public $perPage = 10;
```

**Query scope di model Article:**
- `scopeSearch($query, $search)` — cari berdasarkan title atau author
- `scopeStatus($query, $status)` — filter status

**Fitur:**
- Search: gunakan `wire:model.live` pada input pencarian
- Filter status: dropdown dengan wire:model.live
- Sort: klik header tabel untuk mengubah sortField & sortDirection (toggle asc/desc)
- Pagination: gunakan `Livewire\WithPagination`
- Tampilkan tabel: No, Judul (`wire:navigate` ke detail), Penulis, Status, Tanggal, Aksi

### 4. Livewire Component: ArticleForm

Buat komponen `App\Livewire\ArticleForm` untuk **create & edit** artikel.

**Properties:**
```php
public $articleId;
public $title;
public $content;
public $status = 'draft';
public $author;
public $isEdit = false;
```

**Validasi realtime:**
| Field | Aturan |
|-------|--------|
| `title` | required, min:5, max:200 |
| `content` | required, min:20 |
| `status` | required, in:draft,published,archived |
| `author` | required, min:3, max:100 |

Gunakan `$this->validate()` atau `#[Rule]` attribute. Tampilkan error per field dengan `@error`.

**Method:**
- `mount($articleId = null)` — jika ada ID, load data untuk edit
- `save()` — simpan atau update artikel, generate slug otomatis dari title (gunakan `Str::slug()`), lalu redirect ke daftar artikel dengan flash message
- `updated($propertyName)` — validasi realtime per field (gunakan `$this->validateOnly()`)
- `resetForm()` — reset semua field

### 5. View & Routing

**Layout:** Gunakan layout sederhana (bisa `components/layouts/app.blade.php`) dengan navbar.

**Route:**
| URL | Method | Tampilan |
|-----|--------|----------|
| `/articles` | GET | `livewire:article-list` |
| `/articles/create` | GET | `livewire:article-form` |
| `/articles/{article}/edit` | GET | `livewire:article-form` |
| `/articles/{article}` | GET | Detail artikel (view biasa atau component) |
| `/articles/{article}/delete` | POST | Hapus artikel & redirect |

### 6. Halaman Detail

Buat halaman detail artikel biasa (bukan Livewire, cukup Blade biasa) yang menampilkan:
- Judul, penulis, status, tanggal publikasi
- Konten artikel (render dengan `{{ $article->content }}`)
- Tombol Edit & Hapus (POST form untuk hapus)

### 7. Flash Message

Tampilkan flash message `success` di layout:
- Setelah create: "Artikel berhasil dibuat"
- Setelah update: "Artikel berhasil diperbarui"
- Setelah delete: "Artikel berhasil dihapus"

Gunakan `session()->flash()` di Livewire component.

---

## Ketentuan Pengumpulan

- Kumpulkan: migration, model, factory, seeder, semua komponen Livewire, view Blade, routes/web.php
- Screenshot: daftar artikel (search, filter, sort), form create (dengan error validasi realtime), form edit (data terisi), detail artikel, hapus artikel
- Tunjukkan bahwa search dan filter berfungsi tanpa reload halaman

---

## Rubrik Penilaian

| Aspek | Bobot |
|-------|-------|
| Migration & Model (termasuk scope) | 10% |
| ArticleList (search, filter, sort, pagination) | 25% |
| ArticleForm (create, edit, validasi realtime) | 30% |
| Detail artikel (view biasa) | 10% |
| Routing & layout | 10% |
| Factory & Seeder (50 artikel) | 5% |
| Flash message & UX | 5% |
| Kerapihan kode | 5% |
