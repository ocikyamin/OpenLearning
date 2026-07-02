# Eloquent ORM — Cheatsheet

---

## Model

### Membuat Model

```bash
php artisan make:model Post
php artisan make:model Post -m     # + migration
php artisan make:model Post -mc    # + migration + controller
```

### Konvensi Tabel

| Model | Tabel |
|-------|-------|
| `Post` | `posts` |
| `User` | `users` |
| `Category` | `categories` |
| `ArticleCategory` | `article_categories` |

*(Bisa diubah dengan property `$table`)*

### Property Dasar

```php
class Post extends Model
{
    protected $table = 'artikel';       // Nama tabel (jika berbeda)
    protected $primaryKey = 'id';       // Primary key (default: id)
    public $timestamps = false;         // Nonaktifkan timestamps
    protected $fillable = ['title', 'body'];  // Mass assignable
    protected $guarded = ['id'];        // Tidak bisa diisi massal
}
```

---

## Query Builder

### Read (SELECT)

```php
Post::all();                                // Semua data
Post::get();                                // Semua data (sama)
Post::find(1);                              // Cari by primary key
Post::find([1, 2, 3]);                      // Cari beberapa ID
Post::first();                              // Data pertama
Post::where('status', 'aktif')->get();      // Dengan kondisi
Post::where('title', 'like', '%laravel%')->get();
Post::orderBy('created_at', 'desc')->get();
Post::limit(10)->get();
Post::count();                              // Jumlah data
Post::pluck('title', 'id');                 // Ambil kolom tertentu
```

### Create (INSERT)

```php
// Cara 1: create (mass assignment)
Post::create([
    'title' => 'Judul Post',
    'body' => 'Isi post...'
]);

// Cara 2: save
$post = new Post();
$post->title = 'Judul Post';
$post->body = 'Isi post...';
$post->save();

// Cara 3: firstOrCreate
Post::firstOrCreate(
    ['title' => 'Judul Post'],
    ['body' => 'Isi post...']
);
```

### Update (UPDATE)

```php
// Cara 1: find + update
$post = Post::find(1);
$post->title = 'Judul baru';
$post->save();

// Cara 2: mass update
Post::where('status', 'draft')->update(['status' => 'publish']);

// Cara 3: update or create
Post::updateOrCreate(
    ['id' => 1],
    ['title' => 'Judul', 'body' => 'Isi']
);
```

### Delete (DELETE)

```php
$post = Post::find(1);
$post->delete();

Post::destroy(1);           // Hapus by ID
Post::destroy([1, 2, 3]);   // Hapus beberapa ID
Post::where('status', 'draft')->delete();

// Soft delete
Post::find(1)->delete();
Post::withTrashed()->get();         // Termasuk yg terhapus
Post::onlyTrashed()->get();         // Hanya yg terhapus
Post::withTrashed()->find(1)->restore();  // Kembalikan
```

---

## Relasi

### One to One

```php
// Di User model
public function profile()
{
    return $this->hasOne(Profile::class);
}

// Di Profile model
public function user()
{
    return $this->belongsTo(User::class);
}

// Penggunaan
$user->profile;          // Ambil profile
$user->profile->phone;   // Ambil nomor telepon
```

### One to Many

```php
// Di User model
public function posts()
{
    return $this->hasMany(Post::class);
}

// Di Post model
public function user()
{
    return $this->belongsTo(User::class);
}

// Penggunaan
$user->posts;                   // Semua post user
$user->posts()->where('status', 'publish')->get();
$post->user->name;              // Nama penulis post
```

### Many to Many

```php
// Di Post model
public function tags()
{
    return $this->belongsToMany(Tag::class);
}

// Di Tag model
public function posts()
{
    return $this->belongsToMany(Post::class);
}

// Penggunaan
$post->tags;                    // Semua tag dari post
$tag->posts;                    // Semua post dengan tag ini
$post->tags()->attach([1, 2]);  // Tambah relasi
$post->tags()->detach([1]);     // Hapus relasi
$post->tags()->sync([1, 2, 3]); // Sinkronisasi relasi
```

---

## Eager Loading

```php
// Tanpa eager loading (N+1 problem)
$posts = Post::all();           // 1 query
foreach ($posts as $post) {
    echo $post->user->name;     // N query (N = jumlah post)
}

// Dengan eager loading
$posts = Post::with('user')->get();  // 2 queries total

// Multi relasi
$posts = Post::with(['user', 'comments', 'tags'])->get();

// Nested
$posts = Post::with('comments.user')->get();
```

---

## Aggregates

```php
Post::count();
Post::max('views');
Post::min('views');
Post::avg('rating');
Post::sum('total');
Post::where('status', 'publish')->count();
```

---

## Scope (Filter)

### Global Scope (di Model)

```php
protected static function booted()
{
    static::addGlobalScope('aktif', function ($query) {
        $query->where('status', 'aktif');
    });
}
```

### Local Scope

```php
// Di Model
public function scopePublish($query)
{
    return $query->where('status', 'publish');
}

public function scopePopular($query)
{
    return $query->where('views', '>', 100);
}

// Penggunaan
Post::publish()->get();
Post::publish()->popular()->get();
```

---

## Mutator & Accessor

### Accessor (get → saat ambil data)

```php
// Di Model
public function getTitleAttribute($value)
{
    return ucfirst($value);
}

// Penggunaan
$post->title;  // otomatis huruf pertama kapital
```

### Mutator (set → saat simpan data)

```php
// Di Model
public function setTitleAttribute($value)
{
    $this->attributes['title'] = strtolower($value);
}

// Penggunaan
$post->title = 'JUDUL';  // otomatis diubah jadi 'judul'
```

---

## Factory & Seeder

```php
// DatabaseSeeder.php
public function run()
{
    User::factory(10)->create();
    Post::factory(50)->create();
}

// PostFactory.php
public function definition()
{
    return [
        'title' => fake()->sentence(),
        'body' => fake()->paragraphs(3, true),
        'user_id' => User::factory(),
    ];
}

// Jalankan
php artisan db:seed
php artisan migrate:fresh --seed
```
