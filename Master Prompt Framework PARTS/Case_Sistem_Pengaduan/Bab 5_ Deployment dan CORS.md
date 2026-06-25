# **Bab 5: Deployment, CORS & Global Exception**

**Author:** Abdul Yamin, S.Pd., M.Kom

**Fokus:** Integrasi Frontend, Keamanan Server, dan Persiapan Produksi

## **Pendahuluan**

Sistem pengaduan telah selesai dibangun. API perlu dapat dikonsumsi oleh aplikasi Frontend (Mobile App / Web SPA).

Bab ini membahas masalah CORS saat menghubungkan aplikasi Frontend ke Laravel.

## **1. Menangani Masalah CORS (Cross-Origin Resource Sharing)**

Saat React (berjalan di port 3000) mencoba menembak API Laravel (di port 8000 atau domain lain), browser akan memblokirnya demi keamanan. Kita harus membuka gerbangnya.

Buka file `config/cors.php` (Jika tidak ada, publish lewat artisan: `php artisan config:publish cors`).

```php
// config/cors.php
return [
    // Endpoint mana saja yang diizinkan? Karena kita pakai /api, izinkan semua rute API
    'paths' => ['api/*', 'sanctum/csrf-cookie'],

    // Siapa saja yang boleh memanggil API ini?
    // Saat development gunakan '*', saat production ganti ke domain frontend kalian
    'allowed_origins' => ['*'], // Contoh di prod: ['https://pengaduan-kampus.com']

    // Headers yang diizinkan (Bearer Token wajib masuk sini)
    'allowed_headers' => ['*'],

    // Method HTTP yang diizinkan
    'allowed_methods' => ['*'], // Izinkan GET, POST, PUT, DELETE, dll

    'exposed_headers' => [],
    'max_age' => 0,
    'supports_credentials' => false,
];
```

## **2. Global Exception Handling (Standar Laravel 13)**

Ingat! API tidak boleh mereturn error halaman HTML kuning/Whoops!. Semua *response crash* server harus berbentuk JSON agar Frontend tidak *force close*.

Di Laravel 11 & 13, Exception diatur di `bootstrap/app.php`:

```php
// bootstrap/app.php
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withExceptions(function (Exceptions $exceptions) {
          
        // Memaksa error "Data Tidak Ditemukan (404)" menjadi JSON
        $exceptions->renderable(function (NotFoundHttpException $e, Request $request) {
            if ($request->wantsJson() || $request->is('api/*')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Endpoint atau Data tidak ditemukan.',
                    'data' => null
                ], 404);
            }
        });

        // Memaksa error "Validasi Gagal (422)" menjadi JSON rapi
        $exceptions->renderable(function (ValidationException $e, Request $request) {
            if ($request->wantsJson() || $request->is('api/*')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validasi gagal, mohon periksa inputan Anda.',
                    'errors' => $e->errors()
                ], 422);
            }
        });

        // Memaksa error "Unauthenticated (401)" menjadi JSON
        $exceptions->renderable(function (\Illuminate\Auth\AuthenticationException $e, Request $request) {
            if ($request->wantsJson() || $request->is('api/*')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Kredensial tidak valid. Token tidak ditemukan atau kadaluarsa.',
                    'data' => null
                ], 401);
            }
        });

        // Memaksa error "Forbidden (403)" menjadi JSON
        $exceptions->renderable(function (\Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException $e, Request $request) {
            if ($request->wantsJson() || $request->is('api/*')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Akses ditolak. Hanya admin yang dapat mengakses endpoint ini.',
                    'data' => null
                ], 403);
            }
        });

        // Fallback untuk error server (500) saat APP_DEBUG=false
        $exceptions->renderable(function (\Throwable $e, Request $request) {
            if (($request->wantsJson() || $request->is('api/*')) && !config('app.debug')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan sistem. Silakan coba lagi.',
                    'data' => null
                ], 500);
            }
        });

    })->create();
```

## **3. Checklist Sebelum Deployment (cPanel / VPS)**

Sebelum project ini kamu upload ke server production (misalnya VPS Ubuntu dengan Nginx atau Shared Hosting cPanel), pastikan 3 hal ini:

1. **Jalankan Optimasi Cache:**
   ```bash
   php artisan config:cache
   php artisan route:cache
   ```

2. **Environment `.env`:**
   Ubah `APP_ENV=production` dan `APP_DEBUG=false`. Ini mencegah kode rahasia aplikasimu bocor jika terjadi error tak terduga.

3. **Storage Link di Server:**
   Akses terminal SSH di server kamu dan jalankan `php artisan storage:link`. Jika menggunakan cPanel, pastikan kamu membuat *symlink* secara manual lewat script PHP jika terminal tidak diizinkan.

## **🎉 Penutup**

Silabus telah selesai. Arsitektur API Sistem Pengaduan Akademik siap digunakan.

Dokumentasikan API menggunakan **Postman Collection** agar tim Frontend dapat memahami kontrak data.
