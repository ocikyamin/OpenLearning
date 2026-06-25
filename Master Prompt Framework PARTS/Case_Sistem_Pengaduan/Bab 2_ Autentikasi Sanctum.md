# **Bab 2: Autentikasi Sanctum & Respon Global**

**Author:** Abdul Yamin, S.Pd., M.Kom

**Fokus:** Login, Register, Role Management, dan API Trait

## **Pendahuluan**

Bab ini membahas sistem autentikasi menggunakan Laravel Sanctum berbasis Token dan format respons JSON terstandar.

## **1. Membangun "ApiResponser" Trait**

Untuk menghindari pengulangan kode, dibuat satu fungsi pusat untuk menangani respons API.

Buat file `app/Traits/ApiResponser.php`:

```php
namespace App\Traits;

trait ApiResponser
{
    protected function successResponse($data, $message = null, $code = 200)
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data
        ], $code);
    }

    protected function errorResponse($message, $code)
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'data' => null
        ], $code);
    }
}
```

## **2. Membuat AuthController**

Jalankan:

```bash
php artisan make:controller AuthController
```

Controller ini bertugas mengeluarkan "Kunci Masuk" (Token).

```php
// app/Http/Controllers/AuthController.php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Traits\ApiResponser;

class AuthController extends Controller
{
    use ApiResponser;

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(), 422);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user' // Default role
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return $this->successResponse([
            'user' => $user,
            'access_token' => $token,
            'token_type' => 'Bearer'
        ], 'Registrasi berhasil', 201);
    }

    public function login(Request $request)
    {
        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return $this->errorResponse('Kredensial tidak valid', 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return $this->successResponse([
            'user' => $user,
            'access_token' => $token,
        ], 'Login berhasil');
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return $this->successResponse(null, 'Logout berhasil');
    }
}
```

## **3. Mendaftarkan Route**

Buka `routes/api.php` dan buat pembagian rute antara *Public* dan *Protected*.

```php
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

// Rute Publik
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Rute Terlindungi (Wajib pakai Bearer Token di Header)
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
      
    // Cek profil
    Route::get('/profile', function (Request $request) {
        return response()->json(['success' => true, 'data' => $request->user()]);
    });
});
```

## **4. Gate & Middleware untuk Role Admin**

Admin kampus perlu endpoint khusus yang tidak bisa diakses mahasiswa biasa. Laravel Gate menyediakan cara deklaratif untuk memeriksa role.

### Definisi Gate di AppServiceProvider

```php
<?php
// app/Providers/AppServiceProvider.php
namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Gate::define('is-admin', function ($user) {
            return $user->role === 'admin';
        });
    }
}
```

### Middleware untuk Route Admin

Gate bisa digunakan langsung di route atau controller. Di bab selanjutnya, kita akan membuat middleware `admin` untuk melindungi seluruh grup route.

```php
// Contoh penggunaan Gate di controller
public function index()
{
    if (!Gate::allows('is-admin')) {
        return response()->json([
            'success' => false,
            'message' => 'Akses ditolak. Hanya admin.',
            'data' => null
        ], 403);
    }
    // ... logika admin
}
```

## **🎯 Tugas Akhir Bab 2**

Tes API menggunakan Postman/Insomnia. Lakukan registrasi, ambil tokennya, masukkan ke tab **Authorization -> Bearer Token**, lalu coba akses endpoint `/profile`. Jika berhasil keluar datamu, kamu lulus tahap ini!
