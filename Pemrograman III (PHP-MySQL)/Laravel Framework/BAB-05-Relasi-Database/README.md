# BAB 5 — Relasi Database

---

## 5.1 Tujuan Pembelajaran

Setelah menyelesaikan BAB 5 ini, teman-teman diharapkan mampu:

- Menjelaskan jenis-jenis relasi database (one-to-one, one-to-many, many-to-many)
- Mendefinisikan relasi antar model menggunakan Eloquent
- Membuat migrasi dengan foreign key dan pivot table
- Menggunakan eager loading untuk mencegah N+1 problem
- Mengambil data agregat dengan `withCount()`
- Menggunakan `whereBelongsTo()` untuk query berdasarkan relasi

---

## 5.2 Pendahuluan

Pada BAB 4, kita telah belajar membuat satu model `Article` yang berdiri sendiri. Namun, di dunia nyata, data tidak pernah benar-benar terisolasi. Sebuah artikel pasti ditulis oleh **user** (penulis). Sebuah artikel bisa memiliki banyak **komentar**. Sebuah artikel bisa memiliki banyak **tag**, dan satu tag bisa digunakan di banyak artikel.

Relasi database adalah cara menghubungkan tabel-tabel yang berbeda sehingga data bisa diakses secara terstruktur dan efisien. Tanpa relasi, kita harus menyimpan semua data dalam satu tabel besar — yang akan menyebabkan duplikasi data, pemborosan storage, dan sulitnya pemeliharaan.

Eloquent ORM membuat pengelolaan relasi menjadi sangat intuitif. Kita cukup mendefinisikan hubungan antar model di class PHP, dan Eloquent akan secara otomatis menyusun query JOIN yang tepat.

### Jenis Relasi yang Akan Dipelajari

| Relasi | Contoh | Keterangan |
|--------|--------|------------|
| **One-to-One** (1:1) | User → Profile | Satu user memiliki satu profile |
| **One-to-Many** (1:N) | Article → Comment | Satu artikel memiliki banyak komentar |
| **Many-to-Many** (N:N) | Article → Tag | Satu artikel bisa punya banyak tag, dan satu tag bisa dipakai banyak artikel |

---

## 5.3 One-to-One (1:1)

Relasi one-to-one berarti satu record di tabel A berhubungan dengan **satu** record di tabel B.

Contoh: setiap user memiliki satu profile (berisi bio, avatar, nomor telepon, dll).

### 5.3.1 Membuat Migration

```bash
php artisan make:migration create_profiles_table
```

```php
Schema::create('profiles', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained()->cascadeOnDelete();
    $table->text('bio')->nullable();
    $table->string('avatar')->nullable();
    $table->string('phone', 20)->nullable();
    $table->string('address')->nullable();
    $table->timestamps();
});
```

### 5.3.2 Mendefinisikan Relasi di Model

**Model User:**

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class User extends Model
{
    public function profile(): HasOne
    {
        return $this->hasOne(Profile::class);
    }
}
```

**Model Profile — relasi kebalikannya (inverse):**

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Profile extends Model
{
    protected $fillable = ['user_id', 'bio', 'avatar', 'phone', 'address'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
```

### 5.3.3 Menggunakan Relasi One-to-One

```php
// Mendapatkan profile dari user
$user = User::find(1);
$profile = $user->profile; // otomatis: SELECT * FROM profiles WHERE user_id = 1

// Mendapatkan user dari profile
$profile = Profile::find(1);
$user = $profile->user; // otomatis: SELECT * FROM users WHERE id = 1

// Membuat profile untuk user
$user->profile()->create([
    'bio' => 'Seorang developer Laravel',
    'phone' => '08123456789',
]);
```

---

## 5.4 One-to-Many (1:N)

Relasi one-to-many berarti satu record di tabel A berhubungan dengan **banyak** record di tabel B.

Contoh: satu artikel memiliki banyak komentar. Satu user bisa menulis banyak artikel.

### 5.4.1 Membuat Migration

```bash
php artisan make:migration create_comments_table
```

```php
Schema::create('comments', function (Blueprint $table) {
    $table->id();
    $table->foreignId('article_id')->constrained()->cascadeOnDelete();
    $table->foreignId('user_id')->constrained()->cascadeOnDelete();
    $table->text('body');
    $table->timestamps();
});
```

### 5.4.2 Mendefinisikan Relasi di Model

**Model Article:**

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Article extends Model
{
    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }
}
```

**Model Comment:**

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comment extends Model
{
    protected $fillable = ['article_id', 'user_id', 'body'];

    public function article(): BelongsTo
    {
        return $this->belongsTo(Article::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
```

### 5.4.3 Menggunakan Relasi One-to-Many

```php
// Semua komentar dari sebuah artikel
$article = Article::find(1);
$comments = $article->comments;

// Artikel dari seorang penulis
$user = User::find(1);
$articles = $user->articles; // asumsikan ada relasi articles() di User

// Membuat komentar baru untuk artikel
$article->comments()->create([
    'user_id' => 1,
    'body' => 'Artikel yang sangat bermanfaat!',
]);
```

### 5.4.4 Query dengan whereHas dan whereDoesntHave

Untuk mencari artikel yang memiliki (atau tidak memiliki) komentar:

```php
// Artikel yang memiliki minimal satu komentar
$articles = Article::whereHas('comments')->get();

// Artikel yang memiliki komentar dari user tertentu
$articles = Article::whereHas('comments', function ($query) {
    $query->where('user_id', 1);
})->get();

// Artikel yang belum memiliki komentar sama sekali
$articles = Article::whereDoesntHave('comments')->get();
```

---

## 5.5 Many-to-Many (N:N)

Relasi many-to-many berarti satu record di tabel A berhubungan dengan **banyak** record di tabel B, dan sebaliknya. Relasi ini membutuhkan **tabel pivot** sebagai perantara.

Contoh: satu artikel bisa memiliki banyak tag (Teknologi, PHP, Laravel), dan satu tag bisa digunakan di banyak artikel.

### 5.5.1 Tabel Pivot

Tabel pivot adalah tabel perantara yang menghubungkan dua tabel. Nama tabel pivot biasanya gabungan dari kedua nama tabel dalam bentuk singular, dipisah underscore, sesuai urutan abjad: `article_tag`.

Struktur tabel pivot:

```
article_tag
├── article_id  → foreign key ke articles
└── tag_id      → foreign key ke tags
```

### 5.5.2 Membuat Migration untuk Tags dan Pivot

```bash
php artisan make:migration create_tags_table
php artisan make:migration create_article_tag_table
```

**Migration Tags:**

```php
Schema::create('tags', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->string('slug')->unique();
    $table->timestamps();
});
```

**Migration Pivot (`article_tag`):**

```php
Schema::create('article_tag', function (Blueprint $table) {
    $table->id();
    $table->foreignId('article_id')->constrained()->cascadeOnDelete();
    $table->foreignId('tag_id')->constrained()->cascadeOnDelete();
    $table->timestamps();

    $table->unique(['article_id', 'tag_id']); // mencegah duplikasi
});
```

> **Catatan:** Nama tabel pivot adalah gabungan dua nama model dalam bentuk **singular** dan **sesuai urutan abjad**: `article_tag` (bukan `tag_article`). Eloquent mengikuti konvensi ini secara otomatis.

### 5.5.3 Mendefinisikan Relasi di Model

**Model Article:**

```php
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

public function tags(): BelongsToMany
{
    return $this->belongsToMany(Tag::class);
}
```

**Model Tag:**

```php
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

public function articles(): BelongsToMany
{
    return $this->belongsToMany(Article::class);
}
```

### 5.5.4 Menggunakan Relasi Many-to-Many

```php
// Tag dari sebuah artikel
$article = Article::find(1);
$tags = $article->tags;

// Artikel dari sebuah tag
$tag = Tag::find(1);
$articles = $tag->articles;

// Menambahkan tag ke artikel
$article->tags()->attach(1);              // tambah tag ID 1
$article->tags()->attach([2, 3, 4]);      // tambah banyak tag sekaligus

// Menghapus tag dari artikel
$article->tags()->detach(1);
$article->tags()->detach([2, 3]);

// Sinkronisasi (hapus yang tidak ada di list, tambah yang belum)
$article->tags()->sync([1, 3, 5]);        // hasil akhir: tag 1, 3, 5 saja

// Sync tanpa menghapus (tambah yang belum, biarkan yang sudah ada)
$article->tags()->syncWithoutDetaching([2, 6]);
```

### 5.5.5 Kolom Tambahan di Tabel Pivot

Tabel pivot bisa memiliki kolom tambahan. Misalnya, kolom `created_at` untuk mencatat kapan tag ditambahkan ke artikel.

Tambahkan kolom di migrasi pivot:

```php
Schema::create('article_tag', function (Blueprint $table) {
    $table->id();
    $table->foreignId('article_id')->constrained()->cascadeOnDelete();
    $table->foreignId('tag_id')->constrained()->cascadeOnDelete();
    $table->timestamps();
    $table->unique(['article_id', 'tag_id']);
});
```

Akses data pivot di model:

```php
public function tags(): BelongsToMany
{
    return $this->belongsToMany(Tag::class)
        ->withTimestamps()
        ->withPivot('created_at');
}
```

---

## 5.6 Eager Loading & N+1 Problem

Salah satu masalah performa paling umum di Laravel adalah **N+1 query problem**.

### 5.6.1 Apa Itu N+1?

Perhatikan kode berikut:

```php
$articles = Article::all(); // 1 query

foreach ($articles as $article) {
    echo $article->author->name; // N query (setiap iterasi query sekali)
}
```

Kode di atas menghasilkan **1 + N query** — 1 query untuk mengambil semua artikel, lalu N query untuk mengambil author setiap artikel. Jika ada 100 artikel, total query = 101.

Masalah ini sering tidak terlihat di lingkungan development dengan data sedikit, tetapi akan sangat terasa di production dengan ribuan data.

### 5.6.2 Solusi: Eager Loading

Gunakan method `with()` untuk mengambil relasi sekaligus dalam satu query:

```php
$articles = Article::with('author')->get(); // 2 query

foreach ($articles as $article) {
    echo $article->author->name; // tidak ada query tambahan
}
```

Berapa query sekarang?

1. `SELECT * FROM articles`
2. `SELECT * FROM users WHERE id IN (1, 2, 3, ...)`

Hanya **2 query** berapa pun jumlah artikelnya.

### 5.6.3 Eager Loading Multiple Relasi

```php
$articles = Article::with(['author', 'comments', 'tags'])->get();
```

### 5.6.4 Nested Eager Loading

```php
$articles = Article::with('comments.user')->get();
// Artikel + komentar + user dari setiap komentar
// Total: 3 query
```

### 5.6.5 Constrained Eager Loading

Kadang kita hanya perlu sebagian data dari relasi. Bisa dibatasi dengan closure:

```php
$articles = Article::with(['comments' => function ($query) {
    $query->latest()->limit(5);
}])->get();
```

### 5.6.6 Mencegah Lazy Loading

Untuk menangkap N+1 sejak development, aktifkan pencegahan di `AppServiceProvider`:

```php
use Illuminate\Database\Eloquent\Model;

public function boot(): void
{
    Model::preventLazyLoading(! app()->isProduction());
}
```

Dengan ini, jika ada kode yang memanggil relasi tanpa eager loading, Laravel akan melempar `LazyLoadingViolationException`.

---

## 5.7 withCount

Jika kita hanya perlu **jumlah** data dari suatu relasi (bukan datanya), gunakan `withCount()`. Ini lebih efisien daripada memuat seluruh koleksi lalu menghitungnya.

```php
use App\Models\Article;

$articles = Article::withCount('comments')->get();

foreach ($articles as $article) {
    echo $article->title . ': ' . $article->comments_count . ' komentar';
}
```

Hasilnya:

```
Belajar Laravel: 5 komentar
Blade Templating: 2 komentar
Eloquent ORM: 0 komentar
```

**withCount dengan kondisi:**

```php
$articles = Article::withCount([
    'comments',
    'comments as approved_comments_count' => function ($query) {
        $query->where('approved', true);
    },
])->get();
```

---

## 5.8 whereBelongsTo

Daripada menulis foreign key secara manual, gunakan `whereBelongsTo()` untuk query yang lebih bersih:

```php
// Kurang baik — menyebut foreign key langsung
$articles = Article::where('user_id', $user->id)->get();

// Lebih baik — pakai whereBelongsTo
$articles = Article::whereBelongsTo($user)->get();

// Jika nama relasi berbeda dari default
$articles = Article::whereBelongsTo($user, 'author')->get();
```

---

## 5.9 Praktikum: Membangun Relasi Database

Pada praktikum ini, kita akan mengembangkan aplikasi artikel dari BAB 4 dengan menambahkan fitur komentar dan tag.

### 5.9.1 Persiapan

Pastikan project Laravel dari BAB 4 sudah siap. Jika belum, buat project baru dan jalankan migrasi BAB 4 terlebih dahulu.

```bash
composer create-project laravel/laravel blog-relasi
cd blog-relasi
```

Setting database `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=blog_relasi
DB_USERNAME=root
DB_PASSWORD=
```

Buat database MySQL:

```sql
CREATE DATABASE blog_relasi CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### 5.9.2 Membuat Model, Migration, Seeder

Buat model Article beserta migration dan factory:

```bash
php artisan make:model Article -mf
php artisan make:model Comment -mf
php artisan make:model Tag -mf
```

### 5.9.3 Migration Articles

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

### 5.9.4 Migration Comments

`database/migrations/xxxx_create_comments_table.php`:

```php
Schema::create('comments', function (Blueprint $table) {
    $table->id();
    $table->foreignId('article_id')->constrained()->cascadeOnDelete();
    $table->foreignId('user_id')->constrained()->cascadeOnDelete();
    $table->text('body');
    $table->timestamps();
});
```

### 5.9.5 Migration Tags

`database/migrations/xxxx_create_tags_table.php`:

```php
Schema::create('tags', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->string('slug')->unique();
    $table->timestamps();
});
```

Buat migration pivot:

```bash
php artisan make:migration create_article_tag_table
```

```php
Schema::create('article_tag', function (Blueprint $table) {
    $table->id();
    $table->foreignId('article_id')->constrained()->cascadeOnDelete();
    $table->foreignId('tag_id')->constrained()->cascadeOnDelete();
    $table->timestamps();
    $table->unique(['article_id', 'tag_id']);
});
```

### 5.9.6 Mendefinisikan Model

**Model `app/Models/Article.php`:**

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class)->withTimestamps();
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('published', true);
    }
}
```

**Model `app/Models/Comment.php`:**

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = ['article_id', 'user_id', 'body'];

    public function article(): BelongsTo
    {
        return $this->belongsTo(Article::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
```

**Model `app/Models/Tag.php`:**

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug'];

    public function articles(): BelongsToMany
    {
        return $this->belongsToMany(Article::class)->withTimestamps();
    }
}
```

### 5.9.7 Factory dan Seeder

**ArticleFactory** — `database/factories/ArticleFactory.php`:

```php
<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ArticleFactory extends Factory
{
    public function definition(): array
    {
        $title = fake()->sentence(4);

        return [
            'title' => $title,
            'slug' => Str::slug($title),
            'body' => fake()->paragraphs(3, true),
            'excerpt' => fake()->sentence(10),
            'category' => fake()->randomElement(['Teknologi', 'Olahraga', 'Pendidikan', 'Hiburan']),
            'published' => fake()->boolean(80),
            'user_id' => User::factory(),
        ];
    }
}
```

**CommentFactory** — `database/factories/CommentFactory.php`:

```php
<?php

namespace Database\Factories;

use App\Models\Article;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
{
    public function definition(): array
    {
        return [
            'article_id' => Article::factory(),
            'user_id' => User::factory(),
            'body' => fake()->paragraph(),
        ];
    }
}
```

**TagFactory** — `database/factories/TagFactory.php`:

```php
<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class TagFactory extends Factory
{
    public function definition(): array
    {
        $name = fake()->unique()->word();

        return [
            'name' => ucfirst($name),
            'slug' => Str::slug($name),
        ];
    }
}
```

**DatabaseSeeder** — `database/seeders/DatabaseSeeder.php`:

```php
<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Comment;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
        ]);

        $tags = Tag::factory(10)->create();

        Article::factory(20)
            ->create(['user_id' => $user->id])
            ->each(function (Article $article) use ($tags) {
                Comment::factory(rand(0, 5))->create([
                    'article_id' => $article->id,
                ]);

                $article->tags()->attach(
                    $tags->random(rand(2, 4))->pluck('id')->toArray()
                );
            });
    }
}
```

### 5.9.8 Menjalankan Migrasi dan Seeder

```bash
php artisan migrate:fresh --seed
```

### 5.9.9 Membuat Controller

```bash
php artisan make:controller ArticleController
```

`app/Http/Controllers/ArticleController.php`:

```php
<?php

namespace App\Http\Controllers;

use App\Models\Article;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::with(['author', 'tags'])
            ->withCount('comments')
            ->published()
            ->latest()
            ->paginate(10);

        return view('articles.index', compact('articles'));
    }

    public function show(Article $article)
    {
        if (!$article->published) {
            abort(404);
        }

        $article->load(['author', 'tags', 'comments.user']);

        return view('articles.show', compact('article'));
    }
}
```

### 5.9.10 Route

`routes/web.php`:

```php
<?php

use App\Http\Controllers\ArticleController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => view('home'));

Route::get('/articles', [ArticleController::class, 'index'])->name('articles.index');
Route::get('/articles/{article}', [ArticleController::class, 'show'])->name('articles.show');
```

### 5.9.11 View

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
        @yield('content')
    </main>
</body>
</html>
```

**Daftar Artikel — `resources/views/articles/index.blade.php`:**

```blade
@extends('layouts.app')

@section('title', 'Daftar Artikel')

@section('content')
    <h1 class="text-3xl font-bold mb-6">Daftar Artikel</h1>

    @forelse($articles as $article)
        <article class="bg-white rounded-lg shadow p-6 mb-4">
            <h2 class="text-xl font-semibold">
                <a href="{{ route('articles.show', $article) }}" class="text-blue-600 hover:text-blue-800">
                    {{ $article->title }}
                </a>
            </h2>

            <p class="text-gray-600 mt-2">{{ $article->excerpt }}</p>

            <div class="flex items-center gap-2 mt-3">
                @foreach($article->tags as $tag)
                    <span class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded">
                        {{ $tag->name }}
                    </span>
                @endforeach
            </div>

            <div class="text-sm text-gray-400 mt-2">
                {{ $article->author->name }}
                &middot; {{ $article->category }}
                &middot; {{ $article->created_at->format('d M Y') }}
                &middot; {{ $article->comments_count }} komentar
            </div>
        </article>
    @empty
        <p class="text-gray-500">Belum ada artikel.</p>
    @endforelse

    <div class="mt-6">
        {{ $articles->links() }}
    </div>
@endsection
```

**Detail Artikel — `resources/views/articles/show.blade.php`:**

```blade
@extends('layouts.app')

@section('title', $article->title)

@section('content')
    <article class="bg-white rounded-lg shadow p-6 mb-6">
        <h1 class="text-3xl font-bold mb-4">{{ $article->title }}</h1>

        <div class="flex items-center gap-2 mb-4">
            @foreach($article->tags as $tag)
                <span class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded">
                    {{ $tag->name }}
                </span>
            @endforeach
        </div>

        <div class="text-sm text-gray-400 mb-6">
            {{ $article->author->name }}
            &middot; {{ $article->category }}
            &middot; {{ $article->created_at->format('d M Y') }}
        </div>

        <div class="prose max-w-none">
            {{ $article->body }}
        </div>

        <a href="{{ route('articles.index') }}" class="inline-block mt-6 text-blue-600 hover:text-blue-800">
            &larr; Kembali
        </a>
    </article>

    <section class="bg-white rounded-lg shadow p-6">
        <h2 class="text-xl font-bold mb-4">Komentar ({{ $article->comments->count() }})</h2>

        @forelse($article->comments as $comment)
            <div class="border-b border-gray-200 pb-4 mb-4 last:border-0">
                <p class="font-semibold">{{ $comment->user->name }}</p>
                <p class="text-gray-700 mt-1">{{ $comment->body }}</p>
                <p class="text-xs text-gray-400 mt-1">{{ $comment->created_at->diffForHumans() }}</p>
            </div>
        @empty
            <p class="text-gray-500">Belum ada komentar.</p>
        @endforelse
    </section>
@endsection
```

### 5.9.12 Uji Coba

1. Jalankan server: `php artisan serve`
2. Buka `http://localhost:8000/articles`
3. Hasil: daftar artikel dengan tag, nama author, jumlah komentar
4. Klik artikel: tampil detail artikel, tag, dan daftar komentar

### 5.9.13 Eksplorasi Query dengan Tinker

```bash
php artisan tinker
```

```php
use App\Models\Article;
use App\Models\Tag;

// Lihat query yang dihasilkan eager loading
Article::with(['author', 'tags'])->get();

// Cek jumlah komentar per artikel
Article::withCount('comments')->get();

// Cari artikel dengan tag tertentu
Article::whereHas('tags', fn ($q) => $q->where('name', 'Laravel'))->get();

// Hitung artikel per tag
Tag::withCount('articles')->get();
```

---

## 5.10 Rangkuman

| Konsep | Intinya |
|--------|---------|
| One-to-One | `hasOne()` / `belongsTo()` — satu user punya satu profile |
| One-to-Many | `hasMany()` / `belongsTo()` — satu artikel punya banyak komentar |
| Many-to-Many | `belongsToMany()` — artikel dan tag, butuh tabel pivot |
| Tabel Pivot | `article_tag` — perantara relasi N:N |
| Eager Loading | `with('relasi')` — mencegah N+1 query |
| `withCount()` | Menghitung jumlah relasi tanpa memuat data |
| `whereBelongsTo()` | Query bersih tanpa foreign key manual |
| `whereHas()` | Filter berdasarkan keberadaan relasi |

---

## 5.11 Referensi

- [Eloquent Relationships](https://laravel.com/docs/13.x/eloquent-relationships)
- [Eager Loading](https://laravel.com/docs/13.x/eloquent-relationships#eager-loading)
- [Many to Many](https://laravel.com/docs/13.x/eloquent-relationships#many-to-many)
- [Pivot Table](https://laravel.com/docs/13.x/eloquent-relationships#many-to-many-model-structure)

---

**Lanjut ke:** [BAB 6 — Form Request & Validation](../BAB-06-Form-Request-dan-Validation/README.md)

**Kembali ke:** [BAB 4 — Migration & Eloquent ORM](../BAB-04-Migration-dan-Eloquent-ORM/README.md)
