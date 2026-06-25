# **Bab 3: Upload Pengaduan & Integritas Data**

**Author:** Abdul Yamin, S.Pd., M.Kom

**Fokus:** Logika Pelaporan, Manipulasi File, dan Transaksi Database Aman

## **Pendahuluan**

Bab ini membahas pembuatan *endpoint* pengaduan dengan dukungan upload gambar/foto bukti. Proses penyimpanan file ke server dan data ke database perlu menangani kemungkinan gagal jaringan.

Karena itu, `DB::transaction` digunakan untuk memastikan data tetap konsisten jika terjadi kegagalan.

## **1. Persiapan Storage**

Jalankan perintah ini agar gambar yang di-upload bisa diakses publik (Frontend):

```bash
php artisan storage:link
```

## **2. Membuat FormRequest**

Kita pastikan semua data yang dikirim sesuai standar sebelum menyentuh Controller.

```bash
php artisan make:request StoreComplaintRequest
```

```php
// app/Http/Requests/StoreComplaintRequest.php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreComplaintRequest extends FormRequest
{
    public function authorize(): bool { return true; } // Bisa diakses siapa saja

    public function rules(): array
    {
        return [
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'is_anonymous' => 'boolean',
            'evidences' => 'nullable|array',
            'evidences.*' => 'file|mimes:jpeg,png,jpg,pdf|max:5120', // Maks 5MB per file
            'links' => 'nullable|array',
            'links.*' => 'url'
        ];
    }
}
```

## **3. Controller Pengaduan dengan DB Transaction**

Buat `ComplaintController` untuk menangani logika pengaduan.

```bash
php artisan make:controller ComplaintController
```

```php
// app/Http/Controllers/ComplaintController.php
namespace App\Http\Controllers;

use App\Models\Complaint;
use App\Http\Requests\StoreComplaintRequest;
use App\Traits\ApiResponser;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ComplaintController extends Controller
{
    use ApiResponser;

    public function store(StoreComplaintRequest $request)
    {
        try {
            // DB::transaction menjamin jika ada 1 error, SEMUA operasi dibatalkan (Rollback)
            $complaint = DB::transaction(function () use ($request) {
                  
                // 1. Generate Kode Tracking unik
                $trackingCode = 'ADU-' . date('Ym') . '-' . strtoupper(Str::random(6));

                // 2. Tentukan User (Jika ada token maka tercatat, jika tidak maka Null)
                $userId = auth('sanctum')->check() ? auth('sanctum')->id() : null;

                // 3. Simpan Aduan Induk
                $complaint = Complaint::create([
                    'tracking_code' => $trackingCode,
                    'user_id' => $userId,
                    'category_id' => $request->category_id,
                    'title' => $request->title,
                    'description' => $request->description,
                    'is_anonymous' => $request->is_anonymous ?? false,
                    'status' => 'pending'
                ]);

                // 4. Proses Upload File (Jika Ada)
                if ($request->hasFile('evidences')) {
                    foreach ($request->file('evidences') as $file) {
                        $path = $file->store('complaints', 'public'); // Simpan di storage/app/public/complaints
                          
                        $complaint->evidences()->create([
                            'type' => 'image',
                            'file_path' => $path
                        ]);
                    }
                }

                // 5. Proses Bukti Link (Jika Ada)
                if ($request->has('links')) {
                    foreach ($request->links as $link) {
                        $complaint->evidences()->create([
                            'type' => 'link',
                            'url_link' => $link
                        ]);
                    }
                }

                return $complaint;
            });

            return $this->successResponse([
                'tracking_code' => $complaint->tracking_code,
                'note' => 'Simpan kode tracking ini untuk mengecek status aduan Anda.'
            ], 'Aduan berhasil dikirim!', 201);

        } catch (\Exception $e) {
            // Jika gagal upload/database error, tidak akan ada data setengah matang.
            return $this->errorResponse('Terjadi kesalahan sistem: ' . $e->getMessage(), 500);
        }
    }
}
```

## **4. Routing Pengaduan Publik**

Buka `routes/api.php`, kita letakkan ini di area **Publik** karena orang tidak perlu login untuk lapor.

```php
use App\Http\Controllers\ComplaintController;

Route::post('/complaints', [ComplaintController::class, 'store']);
```

## **🎯 Kesimpulan**

Metode di atas mencegah *file corrupt* atau data yatim (*orphan data*). Input *Multipart/form-data* dapat ditangani untuk kebutuhan Frontend web/mobile.
