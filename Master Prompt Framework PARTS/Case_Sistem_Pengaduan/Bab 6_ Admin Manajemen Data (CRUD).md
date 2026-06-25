# **Bab 6: Admin Manajemen Data (CRUD Categories & Users)**

**Author:** Abdul Yamin, S.Pd., M.Kom

**Fokus:** Middleware Role Admin, CRUD Categories, CRUD Users

## **Pendahuluan**

Admin kampus membutuhkan endpoint untuk mengelola data kategori aduan dan akun pengguna. Keduanya dilindungi oleh middleware `admin` yang memeriksa kolom `role` di tabel `users`.

## **1. Middleware CheckAdminRole**

Middleware ini memastikan hanya user dengan role `admin` yang bisa mengakses grup route tertentu.

### A. Membuat Middleware

```bash
php artisan make:middleware CheckAdminRole
```

### B. Implementasi

```php
<?php
// app/Http/Middleware/CheckAdminRole.php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckAdminRole
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->user() || $request->user()->role !== 'admin') {
            return response()->json([
                'success' => false,
                'message' => 'Akses ditolak. Hanya admin.',
                'data' => null
            ], 403);
        }

        return $next($request);
    }
}
```

### C. Registrasi Middleware (Laravel 11/13)

Di `bootstrap/app.php`:

```php
<?php
// bootstrap/app.php
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        api: __DIR__.'/../routes/api.php',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'admin' => \App\Http\Middleware\CheckAdminRole::class,
        ]);
    })
    ->withExceptions(function ($exceptions) {
        //
    })->create();
```

## **2. Admin CRUD Categories**

Kategori aduan (Fasilitas, Akademik, Pelecehan, dll) dikelola sepenuhnya oleh admin.

### A. FormRequest untuk Validasi

```bash
php artisan make:request StoreCategoryRequest
php artisan make:request UpdateCategoryRequest
```

```php
<?php
// app/Http/Requests/StoreCategoryRequest.php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:categories,slug',
        ];
    }
}
```

```php
<?php
// app/Http/Requests/UpdateCategoryRequest.php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'sometimes|string|max:255',
            'slug' => 'sometimes|string|max:255|unique:categories,slug,' . $this->route('category'),
        ];
    }
}
```

### B. AdminCategoryController

```bash
php artisan make:controller AdminCategoryController
```

```php
<?php
// app/Http/Controllers/AdminCategoryController.php
namespace App\Http\Controllers;

use App\Models\Category;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Traits\ApiResponser;

class AdminCategoryController extends Controller
{
    use ApiResponser;

    public function index()
    {
        $categories = Category::latest()->get();
        return $this->successResponse($categories, 'Daftar kategori');
    }

    public function store(StoreCategoryRequest $request)
    {
        $category = Category::create($request->validated());
        return $this->successResponse($category, 'Kategori berhasil dibuat', 201);
    }

    public function show(Category $category)
    {
        return $this->successResponse($category, 'Detail kategori');
    }

    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $category->update($request->validated());
        return $this->successResponse($category, 'Kategori berhasil diperbarui');
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return $this->successResponse(null, 'Kategori berhasil dihapus');
    }
}
```

## **3. Admin CRUD Users**

Admin dapat mengelola akun pengguna, termasuk mengubah role antara `admin` dan `user`.

### A. FormRequest untuk Validasi

```bash
php artisan make:request StoreUserRequest
php artisan make:request UpdateUserRequest
```

```php
<?php
// app/Http/Requests/StoreUserRequest.php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8',
            'role' => 'required|in:admin,user',
        ];
    }
}
```

```php
<?php
// app/Http/Requests/UpdateUserRequest.php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $userId = $this->route('user');

        return [
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|string|email|max:255|unique:users,email,' . $userId,
            'password' => 'sometimes|string|min:8',
            'role' => 'sometimes|in:admin,user',
        ];
    }
}
```

### B. AdminUserController

```bash
php artisan make:controller AdminUserController
```

```php
<?php
// app/Http/Controllers/AdminUserController.php
namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Traits\ApiResponser;
use Illuminate\Support\Facades\Hash;

class AdminUserController extends Controller
{
    use ApiResponser;

    public function index()
    {
        $users = User::latest()->get();
        return $this->successResponse($users, 'Daftar pengguna');
    }

    public function store(StoreUserRequest $request)
    {
        $data = $request->validated();
        $data['password'] = Hash::make($data['password']);

        $user = User::create($data);
        return $this->successResponse($user, 'Pengguna berhasil dibuat', 201);
    }

    public function show(User $user)
    {
        return $this->successResponse($user, 'Detail pengguna');
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $data = $request->validated();

        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        $user->update($data);
        return $this->successResponse($user, 'Pengguna berhasil diperbarui');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return $this->successResponse(null, 'Pengguna berhasil dihapus');
    }
}
```

## **4. Routing & Seeder**

### A. Route Admin

Semua route admin dikelompokkan dalam satu grup middleware `auth:sanctum` dan `admin`.

```php
<?php
// routes/api.php
use App\Http\Controllers\AdminCategoryController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\AdminComplaintController;

// Rute Publik
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/complaints/track/{tracking_code}', [ComplaintController::class, 'track']);

// Rute Terlindungi (User)
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/profile', function (Request $request) {
        return response()->json(['success' => true, 'data' => $request->user()]);
    });
    Route::post('/complaints', [ComplaintController::class, 'store']);
});

// Rute Terlindungi (Admin)
Route::middleware(['auth:sanctum', 'admin'])->prefix('admin')->group(function () {
    // Manajemen Aduan
    Route::get('/complaints', [AdminComplaintController::class, 'index']);
    Route::put('/complaints/{complaint}/status', [AdminComplaintController::class, 'updateStatus']);

    // Manajemen Kategori
    Route::get('/categories', [AdminCategoryController::class, 'index']);
    Route::post('/categories', [AdminCategoryController::class, 'store']);
    Route::get('/categories/{category}', [AdminCategoryController::class, 'show']);
    Route::put('/categories/{category}', [AdminCategoryController::class, 'update']);
    Route::delete('/categories/{category}', [AdminCategoryController::class, 'destroy']);

    // Manajemen Pengguna
    Route::get('/users', [AdminUserController::class, 'index']);
    Route::post('/users', [AdminUserController::class, 'store']);
    Route::get('/users/{user}', [AdminUserController::class, 'show']);
    Route::put('/users/{user}', [AdminUserController::class, 'update']);
    Route::delete('/users/{user}', [AdminUserController::class, 'destroy']);
});
```

### B. API Reference

| Method | Endpoint | Auth | Deskripsi |
|--------|----------|------|-----------|
| POST | `/api/register` | - | Registrasi mahasiswa |
| POST | `/api/login` | - | Login (mendapat token) |
| POST | `/api/logout` | user | Hapus token |
| GET | `/api/profile` | user | Lihat profil sendiri |
| POST | `/api/complaints` | user | Buat aduan baru |
| GET | `/api/complaints/track/{code}` | - | Lacak aduan publik |
| GET | `/api/admin/complaints` | admin | Monitoring semua aduan |
| PUT | `/api/admin/complaints/{id}/status` | admin | Update status aduan |
| GET | `/api/admin/categories` | admin | Daftar kategori |
| POST | `/api/admin/categories` | admin | Tambah kategori |
| GET | `/api/admin/categories/{id}` | admin | Detail kategori |
| PUT | `/api/admin/categories/{id}` | admin | Edit kategori |
| DELETE | `/api/admin/categories/{id}` | admin | Hapus kategori |
| GET | `/api/admin/users` | admin | Daftar pengguna |
| POST | `/api/admin/users` | admin | Tambah pengguna |
| GET | `/api/admin/users/{id}` | admin | Detail pengguna |
| PUT | `/api/admin/users/{id}` | admin | Edit pengguna |
| DELETE | `/api/admin/users/{id}` | admin | Hapus pengguna |

## **🎯 Tugas Akhir Bab 6**

1. Buat middleware `CheckAdminRole` dan daftarkan dengan alias `admin`.
2. Buat `AdminCategoryController` + `StoreCategoryRequest` + `UpdateCategoryRequest`.
3. Buat `AdminUserController` + `StoreUserRequest` + `UpdateUserRequest`.
4. Uji semua endpoint admin menggunakan Postman dengan token admin (`admin@kampus.ac.id`).
5. Pastikan akses dengan token user biasa mendapat response 403 Forbidden.
