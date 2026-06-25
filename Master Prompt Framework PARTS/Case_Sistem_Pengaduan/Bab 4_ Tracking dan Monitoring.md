# **Bab 4: API Resources, Tracking & Monitoring**

**Author:** Abdul Yamin, S.Pd., M.Kom

**Fokus:** Pelacakan Aduan, Dashboard Admin, dan Optimalisasi Query

## **Pendahuluan**

Pelapor yang telah mendapatkan `tracking_code` perlu memantau proses aduan. Admin kampus membutuhkan *endpoint* untuk menarik data dan mengubah status aduan.

**API Resources** digunakan agar JSON yang diterima Frontend terformat rapi dengan URL gambar yang sudah terkonversi.

## **1. Membuat API Resource**

Resource ini akan menyembunyikan identitas jika pelapor memilih opsi **Anonim**.

```bash
php artisan make:resource ComplaintResource
```

```php
// app/Http/Resources/ComplaintResource.php
namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class ComplaintResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'kode_pelacakan' => $this->tracking_code,
            'judul' => $this->title,
            'deskripsi' => $this->description,
            'status' => $this->status,
            'kategori' => $this->category->name, // Relasi
              
            // Logika Anonim (Keamanan Data)
            'pelapor' => $this->is_anonymous ? 'Anonim (Disembunyikan)' : ($this->user->name ?? 'Masyarakat Umum'),
              
            // Format File/Link
            'bukti_lampiran' => $this->evidences->map(function ($evidence) {
                return [
                    'tipe' => $evidence->type,
                    // Otomatis buat full URL gambar agar frontend tidak pusing
                    'url' => $evidence->type === 'link'
                             ? $evidence->url_link
                             : asset('storage/' . $evidence->file_path)
                ];
            }),
              
            'dilaporkan_pada' => $this->created_at->translatedFormat('d M Y H:i'),
        ];
    }
}
```

## **2. Endpoint Tracking (Untuk Publik)**

Fungsi `track` di `ComplaintController` menggunakan **Eager Loading** (`with()`) untuk mencegah *N+1 Query Problem*.

```php
// Di dalam ComplaintController.php
use App\Http\Resources\ComplaintResource;

public function track($tracking_code)
{
    // with() menarik relasi sekaligus dalam 1 query database
    $complaint = Complaint::with(['category', 'user', 'evidences'])
                          ->where('tracking_code', $tracking_code)
                          ->first();

    if (!$complaint) {
        return $this->errorResponse('Data aduan tidak ditemukan', 404);
    }

    return $this->successResponse(
        new ComplaintResource($complaint), 
        'Detail status aduan'
    );
}
```

## **3. Endpoint Monitoring & Update Status (Khusus Admin)**

Buat `AdminComplaintController` untuk sisi admin (Dashboard).

```php
// app/Http/Controllers/AdminComplaintController.php
namespace App\Http\Controllers;

use App\Models\Complaint;
use App\Http\Resources\ComplaintResource;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;

class AdminComplaintController extends Controller
{
    use ApiResponser;

    // Menampilkan semua data untuk admin (Pagination)
    public function index(Request $request)
    {
        $complaints = Complaint::with(['category', 'user', 'evidences'])
            ->when($request->status, function ($query, $status) {
                return $query->where('status', $status); // Fitur Filter status
            })
            ->latest()
            ->paginate(15);

        return $this->successResponse(
            ComplaintResource::collection($complaints)->response()->getData(true),
            'Data monitoring aduan'
        );
    }

    // Admin merubah status aduan
    public function updateStatus(Request $request, Complaint $complaint)
    {
        $request->validate(['status' => 'required|in:pending,processing,resolved,rejected']);

        // Aturan transisi status yang valid
        $allowedTransitions = [
            'pending'   => ['processing', 'rejected'],
            'processing' => ['resolved', 'rejected'],
            'resolved'  => [],
            'rejected'  => [],
        ];

        $currentStatus = $complaint->status;

        if (!in_array($request->status, $allowedTransitions[$currentStatus] ?? [])) {
            return $this->errorResponse(
                "Status tidak bisa diubah dari {$currentStatus} ke {$request->status}",
                422
            );
        }
          
        $complaint->update(['status' => $request->status]);

        return $this->successResponse(
            new ComplaintResource($complaint), 
            'Status aduan berhasil diperbarui'
        );
    }
}
```

## **4. Konfigurasi Rute**

```php
// routes/api.php
use App\Http\Controllers\AdminComplaintController;

// Rute Publik
Route::get('/complaints/track/{tracking_code}', [ComplaintController::class, 'track']);

// Rute Terlindungi Khusus Admin (Middleware 'admin' + 'auth:sanctum')
// Middleware 'admin' dibuat di Bab 6
Route::middleware(['auth:sanctum', 'admin'])->prefix('admin')->group(function () {
    Route::get('/complaints', [AdminComplaintController::class, 'index']);
    Route::put('/complaints/{complaint}/status', [AdminComplaintController::class, 'updateStatus']);
});
```
