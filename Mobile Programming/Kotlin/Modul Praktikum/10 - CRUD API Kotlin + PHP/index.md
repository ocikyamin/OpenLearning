

Tentu, ini adalah tutorial lengkap sesuai spesifikasi yang Anda berikan. Tutorial ini dirancang untuk mahasiswa tingkat pemula hingga menengah dengan bahasa yang mudah dipahami dan langkah-langkah yang dapat diikuti secara langsung.

---

### **Tutorial Lengkap: Membuat Aplikasi CRUD Notes dengan Backend PHP (CodeIgniter 4) dan Client Android (Kotlin)**

---

### **1. Ringkasan Tutorial**

*   **Tujuan Pembelajaran:** Setelah menyelesaikan tutorial ini, mahasiswa diharapkan mampu:
    1.  Membangun RESTful API sederhana menggunakan PHP dan framework CodeIgniter 4.
    2.  Mengelola database MySQL dengan migrasi CodeIgniter 4.
    3.  Menerapkan operasi CRUD (Create, Read, Update, Delete) melalui API.
    4.  Mengonsumsi RESTful API di aplikasi Android menggunakan Kotlin dan library Retrofit.
    5.  Menerapkan arsitektur MVVM (Model-View-ViewModel) dengan LiveData dan ViewModel di Android.
    6.  Menampilkan data dari API ke dalam RecyclerView.
*   **Estimasi Waktu Belajar:** 4 - 6 jam (tergantung kecepatan dan pemahaman masing-masing mahasiswa).
*   **Hasil Akhir:** Sebuah aplikasi CRUD "Catatan" (Notes) yang terdiri dari:
    *   **Backend:** API PHP yang berjalan pada server lokal, dengan endpoint untuk mengelola data catatan.
    *   **Frontend:** Aplikasi Android yang dapat menampilkan, menambah, mengedit, dan menghapus catatan dengan mengkomunikasikan aksi ke backend API.

---

### **2. Prasyarat**

Sebelum memulai, pastikan Anda telah menginstal perangkat lunak dan memahami konsep berikut:

*   **Software:**
    1.  **PHP 8+**: Lingkungan PHP yang berjalan.
    2.  **Composer**: Dependency manager untuk PHP.
    3.  **Web Server**: XAMPP, WAMP, MAMP, atau Laragon (sudah termasuk Apache, MySQL, phpMyAdmin).
    4.  **Database Server**: MySQL (sudah termasuk dalam paket Web Server di atas).
    5.  **Android Studio**: IDE resmi untuk pengembangan Android.
    6.  **JDK (Java Development Kit)**: Versi 11 atau lebih baru.
    7.  **Postman**: Aplikasi untuk menguji API.
*   **Pengetahuan Dasar:**
    1.  Pemahaman dasar sintaks PHP dan konsep OOP (Object-Oriented Programming).
    2.  Pemahaman dasar sintaks Kotlin.
    3.  Konsep dasar HTTP (Method: GET, POST, PUT, DELETE) dan format data JSON.
    4.  Familiar dengan penggunaan terminal/command line.

---

### **3. Bagian 1: Backend API dengan CodeIgniter 4**

Kita akan membangun backend terlebih dahulu. Backend ini akan menyediakan endpoint yang akan digunakan oleh aplikasi Android.

#### **3.1. Setup Proyek CodeIgniter 4**

1.  Buka terminal atau command prompt Anda.
2.  Navigasikan ke direktori root server web Anda (misalnya `htdocs` untuk XAMPP).
3.  Jalankan perintah berikut untuk membuat proyek CodeIgniter 4 baru menggunakan Composer:

    ```bash
    composer create-project codeigniter4/appstarter crud-notes-api
    ```

4.  Tunggu hingga proses instalasi selesai. Anda akan memiliki folder baru bernama `crud-notes-api`.
5.  Jalankan server pengembangan bawaan CodeIgniter untuk memastikan instalasi berhasil:

    ```bash
    cd crud-notes-api
    php spark serve
    ```

6.  Buka browser dan akses `http://localhost:8080`. Anda seharusnya melihat halaman selamat datang CodeIgniter 4.

    `[ILUSTRASI: Tampilan halaman selamat datang CodeIgniter 4 di browser]`

#### **3.2. Konfigurasi Database & Migrasi**

1.  **Buat Database:** Buka phpMyAdmin (biasanya di `http://localhost/phpmyadmin`) dan buat database baru, misalnya `db_notes`.

2.  **Konfigurasi `.env`:** Di dalam proyek `crud-notes-api`, cari file bernama `env`. Salin file ini dan ubah namanya menjadi `.env`. Buka file `.env` dan cari bagian konfigurasi database. Sesuaikan dengan pengaturan database Anda:

    ```ini
    # DATABASE
    database.default.hostname = localhost
    database.default.database = db_notes
    database.default.username = root
    database.default.password = 
    database.default.DBDriver = MySQLi
    database.default.DBPrefix =
    ```

3.  **Buat Migrasi:** Migrasi adalah cara untuk mengelola skema database. Kita akan membuat migrasi untuk tabel `notes`.

    ```bash
    php spark make:migration CreateNotesTable
    ```

    Perintah ini akan membuat file baru di `app/Database/Migrations/` dengan nama seperti `2023-10-27-123456_CreateNotesTable.php`.

4.  **Edit File Migrasi:** Buka file migrasi yang baru dibuat dan tambahkan kode berikut di dalam method `up()`:

    ```php
    // app/Database/Migrations/2023-10-27-123456_CreateNotesTable.php

    <?php

    namespace App\Database\Migrations;

    use CodeIgniter\Database\Migration;

    class CreateNotesTable extends Migration
    {
        public function up()
        {
            $this->forge->addField([
                'id'          => [
                    'type'           => 'INT',
                    'constraint'     => 5,
                    'unsigned'       => true,
                    'auto_increment' => true,
                ],
                'title'       => [
                    'type'       => 'VARCHAR',
                    'constraint' => '255',
                ],
                'body'        => [
                    'type' => 'TEXT',
                ],
                'created_at'  => [
                    'type' => 'DATETIME',
                    'null' => true,
                ],
                'updated_at'  => [
                    'type' => 'DATETIME',
                    'null' => true,
                ],
            ]);
            $this->forge->addKey('id', true);
            $this->forge->createTable('notes');
        }

        public function down()
        {
            $this->forge->dropTable('notes');
        }
    }
    ```

5.  **Jalankan Migrasi:** Eksekusi perintah berikut di terminal untuk membuat tabel `notes` di database Anda:

    ```bash
    php spark migrate
    ```

    Sekarang, cek database `db_notes` di phpMyAdmin. Anda akan melihat tabel `notes` dengan struktur yang telah didefinisikan.

#### **3.3. Membuat Model (`NoteModel`)**

Model digunakan untuk berinteraksi dengan tabel `notes`.

1.  Buat file baru di `app/Models/NoteModel.php`.
2.  Tambahkan kode berikut:

    ```php
    // app/Models/NoteModel.php

    <?php

    namespace App\Models;

    use CodeIgniter\Model;

    class NoteModel extends Model
    {
        protected $table            = 'notes';
        protected $primaryKey       = 'id';
        protected $useAutoIncrement = true;
        protected $returnType       = 'array';
        protected $useSoftDeletes   = false;
        protected $protectFields    = true;
        protected $allowedFields    = ['title', 'body'];

        // Dates
        protected $useTimestamps = true;
        protected $dateFormat    = 'datetime';
        protected $createdField  = 'created_at';
        protected $updatedField  = 'updated_at';
    }
    ```

*   `$table`: Nama tabel yang akan dihubungkan.
*   `$allowedFields`: Daftar kolom yang diizinkan untuk diisi secara massal (penting untuk keamanan).

#### **3.4. Membuat Controller RESTful (`Notes`)**

Controller akan menangani logika bisnis dan merespons permintaan HTTP.

1.  Buat file baru di `app/Controllers/Notes.php`.
2.  Tambahkan kode berikut. Kode ini mencakup semua endpoint CRUD yang dibutuhkan dengan format respons JSON yang konsisten.

    ```php
    // app/Controllers/Notes.php

namespace App\Controllers;
use CodeIgniter\API\ResponseTrait;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\NoteModel;

class Notes extends BaseController
{
    use ResponseTrait;

    public function index()
    {
        $model = new NoteModel();
        $data  = $model->findAll();

        return $this->respond([
            'status' => 'success',
            'data'   => $data
        ], ResponseInterface::HTTP_OK);
    }

    public function show($id = null)
    {
        $model = new NoteModel();
        $data  = $model->find($id);

        if (!$data) {
            return $this->failNotFound('Note not found');
        }

        return $this->respond([
            'status' => 'success',
            'data'   => $data
        ]);
    }

    public function create()
    {
        // ambil JSON body
        $input = $this->request->getJSON(true);

        $rules = [
            'title' => 'required|max_length[255]',
            'body'  => 'required',
        ];

        if (!$this->validate($rules)) {
            return $this->respond([
                'status' => 'error',
                'errors' => $this->validator->getErrors()
            ], ResponseInterface::HTTP_BAD_REQUEST);
        }

        $model = new NoteModel();
        $model->insert($input);

        return $this->respondCreated([
            'status'  => 'success',
            'message' => 'Note created successfully',
            'data'    => ['id' => $model->getInsertID()]
        ]);
    }

    public function update($id = null)
{
    $model = new NoteModel();
    $note  = $model->find($id);

    if (!$note) {
        return $this->failNotFound('Note not found');
    }

    // Ambil JSON input
    $input = $this->request->getJSON(true);

    if (empty($input)) {
        return $this->fail('No input data received');
    }

    $rules = [
        'title' => 'required|max_length[255]',
        'body'  => 'required',
    ];

    if (!$this->validate($rules)) {
        return $this->respond([
            'status' => 'error',
            'errors' => $this->validator->getErrors()
        ], 400);
    }

    $model->update($id, $input);

    return $this->respond([
        'status'  => 'success',
        'message' => 'Note updated successfully'
    ]);
}


    public function delete($id = null)
    {
        $model = new NoteModel();
        $note  = $model->find($id);

        if (!$note) {
            return $this->failNotFound('Note not found');
        }

        $model->delete($id);

        return $this->respondDeleted([
            'status'  => 'success',
            'message' => 'Note deleted successfully'
        ]);
    }
    }```

#### **3.5. Menambahkan Keamanan Dasar (CORS & API Key)**

1.  **CORS (Cross-Origin Resource Sharing):** Agar aplikasi Android (yang berjalan pada origin yang berbeda) dapat mengakses API ini, kita perlu mengaktifkan CORS.
    *   Buka file `app/Config/Filters.php`.
    *   Cari `$globals` dan tambahkan filter `cors` ke array `before`.

    ```php
    // app/Config/Filters.php

    public $globals = [
        'before' => [
            // 'honeypot',
            // 'csrf',
            'cors', // Tambahkan baris ini
        ],
        'after'  => [
            'toolbar',
            // 'honeypot',
        ],
    ];
    ```

2.  **API Key Sederhana:** Kita akan membuat filter sederhana untuk memeriksa API Key pada setiap permintaan.
    *   Buat file baru di `app/Filters/ApiKeyFilter.php`.
    *   Tambahkan kode berikut:

    ```php
    // app/Filters/ApiKeyFilter.php

    <?php

    namespace App\Filters;

    use CodeIgniter\Filters\FilterInterface;
    use CodeIgniter\HTTP\RequestInterface;
    use CodeIgniter\HTTP\ResponseInterface;

    class ApiKeyFilter implements FilterInterface
    {
        public function before(RequestInterface $request, $arguments = null)
        {
            $apiKey = $request->getHeaderLine('X-API-Key');
            $validApiKey = 'YOUR_SECRET_API_KEY'; // Ganti dengan key yang lebih aman

            if ($apiKey !== $validApiKey) {
                $response = service('response');
                $response->setJSON([
                    'status' => 'error',
                    'message' => 'Invalid API Key'
                ]);
                $response->setStatusCode(ResponseInterface::HTTP_UNAUTHORIZED);
                return $response;
            }
        }

        public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
        {
            // Do nothing
        }
    }
    ```

3.  **Terapkan Filter ke Route:** Sekarang, kita perlu mendaftarkan filter ini dan menerapkannya pada route `Notes`.
    *   Buka `app/Config/Routes.php`.
    *   Daftarkan alias untuk filter `ApiKeyFilter` di bagian `$aliases`.

    ```php
    // app/Config/Routes.php

    public $aliases = [
        'csrf'     => \CodeIgniter\Filters\CSRF::class,
        'toolbar'  => \CodeIgniter\Filters\DebugToolbar::class,
        'honeypot' => \CodeIgniter\Filters\Honeypot::class,
        'cors'     => \App\Filters\CorsFilter::class, // Biasanya sudah ada
        'api-key'  => \App\Filters\ApiKeyFilter::class, // Tambahkan ini
    ];
    ```

    *   Tambahkan route untuk controller `Notes` dan terapkan filter `api-key`.

    ```php
    // app/Config/Routes.php

    $routes->group('api/notes', ['filter' => 'api-key'], function ($routes) {
        $routes->get('/', 'Notes::index');
        $routes->get('(:num)', 'Notes::show/$1');
        $routes->post('/', 'Notes::create');
        $routes->put('(:num)', 'Notes::update/$1');
        $routes->delete('(:num)', 'Notes::delete/$1');
    });
    ```

#### **3.6. Pengujian API dengan Postman dan cURL**

Pastikan server PHP Anda masih berjalan (`php spark serve`). Sekarang kita akan menguji setiap endpoint.

*   **Base URL:** `http://localhost:8080/api/notes`
*   **Header (untuk semua request):** `X-API-Key` dengan nilai `YOUR_SECRET_API_KEY`.

1.  **GET /api/notes (Mendapatkan semua catatan)**
    *   **Metode:** GET
    *   **URL:** `http://localhost:8080/api/notes`
    *   **cURL:**
        ```bash
        curl -X GET "http://localhost:8080/api/notes" -H "X-API-Key: YOUR_SECRET_API_KEY"
        ```
    *   **Response (Contoh):**
        ```json
        {
            "status": "success",
            "data": []
        }
        ```

2.  **POST /api/notes (Membuat catatan baru)**
    *   **Metode:** POST
    *   **URL:** `http://localhost:8080/api/notes`
    *   **Body (raw, JSON):**
        ```json
        {
            "title": "Judul Catatan Pertama",
            "body": "Ini adalah isi dari catatan pertama saya."
        }
        ```
    *   **cURL:**
        ```bash
        curl -X POST "http://localhost:8080/api/notes" \
        -H "X-API-Key: YOUR_SECRET_API_KEY" \
        -H "Content-Type: application/json" \
        -d '{"title": "Judul Catatan Pertama", "body": "Ini adalah isi dari catatan pertama saya."}'
        ```
    *   **Response (Contoh):**
        ```json
        {
            "status": "success",
            "message": "Note created successfully",
            "data": {
                "id": 1
            }
        }
        ```

3.  **GET /api/notes/{id} (Mendapatkan satu catatan)**
    *   **Metode:** GET
    *   **URL:** `http://localhost:8080/api/notes/1`
    *   **cURL:**
        ```bash
        curl -X GET "http://localhost:8080/api/notes/1" -H "X-API-Key: YOUR_SECRET_API_KEY"
        ```
    *   **Response (Contoh):**
        ```json
        {
            "status": "success",
            "data": {
                "id": 1,
                "title": "Judul Catatan Pertama",
                "body": "Ini adalah isi dari catatan pertama saya.",
                "created_at": "2023-10-27T10:30:00.000Z",
                "updated_at": "2023-10-27T10:30:00.000Z"
            }
        }
        ```

4.  **PUT /api/notes/{id} (Memperbarui catatan)**
    *   **Metode:** PUT
    *   **URL:** `http://localhost:8080/api/notes/1`
    *   **Body (raw, JSON):**
        ```json
        {
            "title": "Judul Catatan Pertama (Diubah)",
            "body": "Ini adalah isi dari catatan pertama yang sudah diperbarui."
        }
        ```
    *   **cURL:**
        ```bash
        curl -X PUT "http://localhost:8080/api/notes/1" \
        -H "X-API-Key: YOUR_SECRET_API_KEY" \
        -H "Content-Type: application/json" \
        -d '{"title": "Judul Catatan Pertama (Diubah)", "body": "Ini adalah isi dari catatan pertama yang sudah diperbarui."}'
        ```
    *   **Response (Contoh):**
        ```json
        {
            "status": "success",
            "message": "Note updated successfully"
        }
        ```

5.  **DELETE /api/notes/{id} (Menghapus catatan)**
    *   **Metode:** DELETE
    *   **URL:** `http://localhost:8080/api/notes/1`
    *   **cURL:**
        ```bash
        curl -X DELETE "http://localhost:8080/api/notes/1" -H "X-API-Key: YOUR_SECRET_API_KEY"
        ```
    *   **Response (Contoh):**
        ```json
        {
            "status": "success",
            "message": "Note deleted successfully"
        }
        ```

`[ILUSTRASI: Tampilan Postman saat melakukan request POST ke endpoint /api/notes dengan header dan body yang benar]`

---

### **4. Bagian 2: Aplikasi Client Android dengan Kotlin**

Setelah backend siap, kita akan membangun aplikasi Android untuk mengonsumsinya.

#### **4.1. Setup Proyek Android Studio**

1.  Buka Android Studio.
2.  Pilih **New Project** -> **Empty Views Activity**.
3.  Konfigurasi proyek:
    *   **Name:** `NotesApp`
    *   **Package name:** `com.example.notesapp` (atau sesuai keinginan)
    *   **Language:** **Kotlin**
    *   **Minimum SDK:** API 24 (Android 7.0) atau lebih tinggi.
    *   Klik **Finish**.

#### **4.2. Struktur Proyek dan Dependensi**

1.  Buka file `build.gradle.kts` (Module :app).
2.  Tambahkan dependensi berikut di dalam blok `dependencies { ... }`:

    ```kotlin
    // build.gradle.kts (Module :app)

    dependencies {
        // ... dependensi lainnya

        // Retrofit untuk networking
        implementation("com.squareup.retrofit2:retrofit:2.9.0")
        implementation("com.squareup.retrofit2:converter-gson:2.9.0") // Konverter JSON

        // OkHttp Logging Interceptor untuk debugging
        implementation("com.squareup.okhttp3:logging-interceptor:4.11.0")

        // ViewModel dan LiveData untuk arsitektur MVVM
        implementation("androidx.lifecycle:lifecycle-viewmodel-ktx:2.7.0")
        implementation("androidx.lifecycle:lifecycle-livedata-ktx:2.7.0")
        implementation("androidx.activity:activity-ktx:1.8.2") // untuk by viewModels()

        // RecyclerView untuk menampilkan daftar
        implementation("androidx.recyclerview:recyclerview:1.3.2")

        // Coroutines untuk operasi asynchronous
        implementation("org.jetbrains.kotlinx:kotlinx-coroutines-core:1.7.3")
        implementation("org.jetbrains.kotlinx:kotlinx-coroutines-android:1.7.3")
    }
    ```
3.  Sinkronkan proyek dengan mengklik **Sync Now**.

#### **4.3. Membuat Model Data (`Note.kt`)**

Model data ini akan merepresentasikan objek catatan yang didapat dari API.

1.  Buat package baru `data` di dalam package utama (`com.example.notesapp`).
2.  Buat file Kotlin baru `Note.kt` di dalam package `data`.
3.  Tambahkan kode berikut:

    ```kotlin
    // app/src/main/java/com/example/notesapp/data/Note.kt

    package com.example.notesapp.data

    import com.google.gson.annotations.SerializedName

    data class Note(
        @SerializedName("id")
        val id: Int,

        @SerializedName("title")
        val title: String,

        @SerializedName("body")
        val body: String,

        @SerializedName("created_at")
        val createdAt: String? = null, // Menggunakan ? karena bisa null dari API

        @SerializedName("updated_at")
        val updatedAt: String? = null
    )
    ```

#### **4.4. Membuat Retrofit Service Interface (`ApiService.kt`)**

Interface ini mendefinisikan endpoint-endpoint API yang akan kita akses.

1.  Buat package baru `network` di dalam package utama.
2.  Buat file Kotlin baru `ApiService.kt` di dalam package `network`.
3.  Tambahkan kode berikut:

    ```kotlin
    // app/src/main/java/com/example/notesapp/network/ApiService.kt

    package com.example.notesapp.network

    import com.example.notesapp.data.Note
    import retrofit2.Response
    import retrofit2.http.*

    data class ApiResponse<T>(
        val status: String,
        val data: T? = null,
        val message: String? = null
    )

    interface ApiService {
        @GET("api/notes")
        suspend fun getAllNotes(): Response<ApiResponse<List<Note>>>

        @GET("api/notes/{id}")
        suspend fun getNoteById(@Path("id") id: Int): Response<ApiResponse<Note>>

        @POST("api/notes")
        suspend fun createNote(@Body note: Note): Response<ApiResponse<Map<String, Int>>> // Map untuk {"id": 1}

        @PUT("api/notes/{id}")
        suspend fun updateNote(@Path("id") id: Int, @Body note: Note): Response<ApiResponse<Unit>> // Unit untuk void/no content

        @DELETE("api/notes/{id}")
        suspend fun deleteNote(@Path("id") id: Int): Response<ApiResponse<Unit>>
    }
    ```

#### **4.5. Membuat Retrofit Client (`RetrofitClient.kt`)**

Ini adalah singleton object yang akan menyediakan instance dari Retrofit.

1.  Buat file Kotlin baru `RetrofitClient.kt` di dalam package `network`.
2.  Tambahkan kode berikut:

    ```kotlin
    // app/src/main/java/com/example/notesapp/network/RetrofitClient.kt

    package com.example.notesapp.network

    import okhttp3.Interceptor
    import okhttp3.OkHttpClient
    import okhttp3.logging.HttpLoggingInterceptor
    import retrofit2.Retrofit
    import retrofit2.converter.gson.GsonConverterFactory

    object RetrofitClient {
        private const val BASE_URL = "http://10.0.2.2:8080/" // Gunakan IP ini untuk emulator
        private const val API_KEY = "YOUR_SECRET_API_KEY" // Sama dengan yang di backend

        val instance: ApiService by lazy {
            val logging = HttpLoggingInterceptor()
            logging.setLevel(HttpLoggingInterceptor.Level.BODY)

            val client = OkHttpClient.Builder()
                .addInterceptor(logging) // Tambahkan interceptor untuk logging
                .addInterceptor(Interceptor { chain ->
                    val request = chain.request().newBuilder()
                        .addHeader("X-API-Key", API_KEY) // Tambahkan header API Key
                        .build()
                    chain.proceed(request)
                })
                .build()

            val retrofit = Retrofit.Builder()
                .baseUrl(BASE_URL)
                .client(client)
                .addConverterFactory(GsonConverterFactory.create())
                .build()

            retrofit.create(ApiService::class.java)
        }
    }
    ```
    **Penting:** `10.0.2.2` adalah alamat IP khusus yang digunakan oleh emulator Android untuk mengakses `localhost` pada komputer host. Jika Anda menggunakan perangkat fisik, gunakan IP address komputer Anda (misalnya `192.168.1.10`).

#### **4.6. Membuat Repository (`NoteRepository.kt`)**

Repository akan menyediakan data ke ViewModel. Ini adalah abstraksi dari sumber data (API).

1.  Buat package baru `repository` di dalam package utama.
2.  Buat file Kotlin baru `NoteRepository.kt` di dalam package `repository`.
3.  Tambahkan kode berikut:

    ```kotlin
    // app/src/main/java/com/example/notesapp/repository/NoteRepository.kt

    package com.example.notesapp.repository

    import androidx.lifecycle.LiveData
    import androidx.lifecycle.MutableLiveData
    import com.example.notesapp.data.Note
    import com.example.notesapp.network.ApiResponse
    import com.example.notesapp.network.RetrofitClient
    import retrofit2.Call
    retrofit2.Callback
    import retrofit2.Response

    class NoteRepository {
        private val apiService = RetrofitClient.instance

        // Menggunakan MutableLiveData untuk LiveData yang bisa diubah
        private val _notes = MutableLiveData<List<Note>>()
        val notes: LiveData<List<Note>> = _notes

        private val _isLoading = MutableLiveData<Boolean>()
        val isLoading: LiveData<Boolean> = _isLoading

        private val _errorMessage = MutableLiveData<String>()
        val errorMessage: LiveData<String> = _errorMessage

        suspend fun getAllNotes() {
            try {
                _isLoading.value = true
                val response = apiService.getAllNotes()
                if (response.isSuccessful && response.body()?.status == "success") {
                    _notes.value = response.body()?.data ?: emptyList()
                    _errorMessage.value = null
                } else {
                    _errorMessage.value = "Error fetching notes: ${response.message()}"
                }
            } catch (e: Exception) {
                _errorMessage.value = "Exception: ${e.message}"
            } finally {
                _isLoading.value = false
            }
        }

        suspend fun createNote(note: Note): Boolean {
            return try {
                _isLoading.value = true
                // Catatan baru tidak memiliki ID, server akan memberikannya
                val noteToCreate = note.copy(id = 0) 
                val response = apiService.createNote(noteToCreate)
                if (response.isSuccessful && response.body()?.status == "success") {
                    // Refresh daftar setelah berhasil membuat
                    getAllNotes() 
                    true
                } else {
                    _errorMessage.value = "Error creating note: ${response.message()}"
                    false
                }
            } catch (e: Exception) {
                _errorMessage.value = "Exception: ${e.message}"
                false
            } finally {
                _isLoading.value = false
            }
        }
        
        // Tambahkan fungsi untuk update dan delete di sini jika ingin langsung dari repository
        // Untuk tutorial ini, kita akan memanggilnya langsung dari ViewModel untuk kesederhanaan
    }
    ```

#### **4.7. Membuat ViewModel (`NoteViewModel.kt`)**

ViewModel akan menyimpan dan mengelola data yang terkait dengan UI.

1.  Buat package baru `ui` di dalam package utama, lalu buat sub-package `viewmodel` di dalamnya.
2.  Buat file Kotlin baru `NoteViewModel.kt` di dalam `ui.viewmodel`.
3.  Tambahkan kode berikut:

    ```kotlin
    // app/src/main/java/com/example/notesapp/ui/viewmodel/NoteViewModel.kt

    package com.example.notesapp.ui.viewmodel

    import androidx.lifecycle.LiveData
    import androidx.lifecycle.MutableLiveData
    import androidx.lifecycle.ViewModel
    import androidx.lifecycle.viewModelScope
    import com.example.notesapp.data.Note
    import com.example.notesapp.network.ApiResponse
    import com.example.notesapp.network.RetrofitClient
    import kotlinx.coroutines.launch

    class NoteViewModel : ViewModel() {
        private val repository = NoteRepository() // Bisa juga di-inject menggunakan DI

        val notes: LiveData<List<Note>> = repository.notes
        val isLoading: LiveData<Boolean> = repository.isLoading
        val errorMessage: LiveData<String> = repository.errorMessage

        init {
            // Muat semua catatan saat ViewModel dibuat
            viewModelScope.launch {
                repository.getAllNotes()
            }
        }

        fun createNote(title: String, body: String) {
            viewModelScope.launch {
                // ID tidak diperlukan untuk pembuatan, server akan menanganinya
                val newNote = Note(id = 0, title = title, body = body) 
                repository.createNote(newNote)
            }
        }
        
        // Fungsi untuk update dan delete
        fun updateNote(id: Int, title: String, body: String) {
            viewModelScope.launch {
                try {
                    val updatedNote = Note(id = id, title = title, body = body)
                    val response = RetrofitClient.instance.updateNote(id, updatedNote)
                    if (response.isSuccessful && response.body()?.status == "success") {
                        repository.getAllNotes() // Refresh data
                    } else {
                        // Handle error, bisa diset ke errorMessage di repository
                    }
                } catch (e: Exception) {
                    // Handle exception
                }
            }
        }

        fun deleteNote(id: Int) {
            viewModelScope.launch {
                try {
                    val response = RetrofitClient.instance.deleteNote(id)
                    if (response.isSuccessful && response.body()?.status == "success") {
                        repository.getAllNotes() // Refresh data
                    } else {
                        // Handle error
                    }
                } catch (e: Exception) {
                    // Handle exception
                }
            }
        }
    }
    ```

#### **4.8. Membuat Adapter untuk RecyclerView (`NoteAdapter.kt`)**

Adapter bertugas untuk menghubungkan data (daftar `Note`) dengan `RecyclerView`.

1.  Buat package baru `ui` di dalam package utama, lalu buat sub-package `adapter` di dalamnya.
2.  Buat file Kotlin baru `NoteAdapter.kt` di dalam `ui.adapter`.
3.  Tambahkan kode berikut:

    ```kotlin
    // app/src/main/java/com/example/notesapp/ui/adapter/NoteAdapter.kt

    package com.example.notesapp.ui.adapter

    import android.view.LayoutInflater
    import android.view.View
    import android.view.ViewGroup
    import android.widget.TextView
    import androidx.recyclerview.widget.RecyclerView
    import com.example.notesapp.R
    import com.example.notesapp.data.Note

    class NoteAdapter(
        private var notes: List<Note>,
        private val onItemClick: (Note) -> Unit,
        private val onItemLongClick: (Note) -> Unit
    ) : RecyclerView.Adapter<NoteAdapter.NoteViewHolder>() {

        class NoteViewHolder(itemView: View) : RecyclerView.ViewHolder(itemView) {
            val titleTextView: TextView = itemView.findViewById(R.id.tvTitle)
            val bodyTextView: TextView = itemView.findViewById(R.id.tvBody)
        }

        override fun onCreateViewHolder(parent: ViewGroup, viewType: Int): NoteViewHolder {
            val view = LayoutInflater.from(parent.context)
                .inflate(R.layout.item_note, parent, false)
            return NoteViewHolder(view)
        }

        override fun onBindViewHolder(holder: NoteViewHolder, position: Int) {
            val currentNote = notes[position]
            holder.titleTextView.text = currentNote.title
            holder.bodyTextView.text = currentNote.body

            holder.itemView.setOnClickListener {
                onItemClick(currentNote)
            }

            holder.itemView.setOnLongClickListener {
                onItemLongClick(currentNote)
                true // Menandakan bahwa event telah ditangani
            }
        }

        override fun getItemCount() = notes.size

        fun updateNotes(newNotes: List<Note>) {
            this.notes = newNotes
            notifyDataSetChanged() // Cara sederhana, untuk performa lebih baik gunakan DiffUtil
        }
    }
    ```

#### **4.9. Membuat UI (Layout XMLs)**

1.  **`item_note.xml` (Layout untuk satu item di daftar)**
    *   Buat file layout baru di `res/layout/item_note.xml`.
    *   Tambahkan kode berikut:

    ```xml
    <!-- res/layout/item_note.xml -->
    <?xml version="1.0" encoding="utf-8"?>
    <com.google.android.material.card.MaterialCardView xmlns:android="http://schemas.android.com/apk/res/android"
        xmlns:app="http://schemas.android.com/apk/res-auto"
        xmlns:tools="http://schemas.android.com/tools"
        android:layout_width="match_parent"
        android:layout_height="wrap_content"
        android:layout_margin="8dp"
        app:cardCornerRadius="8dp"
        app:cardElevation="4dp">

        <LinearLayout
            android:layout_width="match_parent"
            android:layout_height="wrap_content"
            android:orientation="vertical"
            android:padding="16dp">

            <TextView
                android:id="@+id/tvTitle"
                android:layout_width="match_parent"
                android:layout_height="wrap_content"
                android:textAppearance="?attr/textAppearanceHeadline6"
                tools:text="Judul Catatan" />

            <TextView
                android:id="@+id/tvBody"
                android:layout_width="match_parent"
                android:layout_height="wrap_content"
                android:layout_marginTop="8dp"
                android:textAppearance="?attr/textAppearanceBody2"
                tools:text="Ini adalah isi dari catatan." />

        </LinearLayout>
    </com.google.android.material.card.MaterialCardView>
    ```

2.  **`activity_main.xml` (Layout utama)**
    *   Buka `res/layout/activity_main.xml`.
    *   Ganti isinya dengan kode berikut:

    ```xml
    <!-- res/layout/activity_main.xml -->
    <?xml version="1.0" encoding="utf-8"?>
    <androidx.coordinatorlayout.widget.CoordinatorLayout xmlns:android="http://schemas.android.com/apk/res/android"
        xmlns:app="http://schemas.android.com/apk/res-auto"
        xmlns:tools="http://schemas.android.com/tools"
        android:layout_width="match_parent"
        android:layout_height="match_parent"
        tools:context=".MainActivity">

        <androidx.recyclerview.widget.RecyclerView
            android:id="@+id/recyclerViewNotes"
            android:layout_width="match_parent"
            android:layout_height="match_parent"
            app:layoutManager="androidx.recyclerview.widget.LinearLayoutManager"
            tools:listitem="@layout/item_note" />

        <ProgressBar
            android:id="@+id/progressBar"
            android:layout_width="wrap_content"
            android:layout_height="wrap_content"
            android:layout_gravity="center"
            android:visibility="gone" />

        <TextView
            android:id="@+id/tvErrorMessage"
            android:layout_width="wrap_content"
            android:layout_height="wrap_content"
            android:layout_gravity="center"
            android:text="Error message here"
            android:visibility="gone" />

        <com.google.android.material.floatingactionbutton.FloatingActionButton
            android:id="@+id/fabAdd"
            android:layout_width="wrap_content"
            android:layout_height="wrap_content"
            android:layout_gravity="bottom|end"
            android:layout_margin="16dp"
            android:contentDescription="Add Note"
            android:src="@drawable/ic_add" />

    </androidx.coordinatorlayout.widget.CoordinatorLayout>
    ```
    *   Anda perlu menambahkan ikon `ic_add`. Klik kanan pada folder `res/drawable` -> New -> Vector Asset, cari ikon "add".

#### **4.10. Menghubungkan Semua di `MainActivity.kt`**

Ini adalah langkah terakhir di mana kita menghubungkan UI dengan ViewModel dan Repository.

1.  Buka `MainActivity.kt`.
2.  Ganti isinya dengan kode berikut:

    ```kotlin
    // app/src/main/java/com/example/notesapp/MainActivity.kt

    package com.example.notesapp

    import android.os.Bundle
    import android.view.View
    import android.widget.ProgressBar
    import android.widget.TextView
    import android.widget.Toast
    import androidx.activity.viewModels
    import androidx.appcompat.app.AlertDialog
    import androidx.appcompat.app.AppCompatActivity
    import androidx.recyclerview.widget.LinearLayoutManager
    import androidx.recyclerview.widget.RecyclerView
    import com.example.notesapp.data.Note
    import com.example.notesapp.ui.adapter.NoteAdapter
    import com.example.notesapp.ui.viewmodel.NoteViewModel
    import com.google.android.material.floatingactionbutton.FloatingActionButton
    import com.google.android.material.textfield.TextInputEditText

    class MainActivity : AppCompatActivity() {

        private val noteViewModel: NoteViewModel by viewModels()
        private lateinit var noteAdapter: NoteAdapter

        override fun onCreate(savedInstanceState: Bundle?) {
            super.onCreate(savedInstanceState)
            setContentView(R.layout.activity_main)

            val recyclerView: RecyclerView = findViewById(R.id.recyclerViewNotes)
            val progressBar: ProgressBar = findViewById(R.id.progressBar)
            val tvErrorMessage: TextView = findViewById(R.id.tvErrorMessage)
            val fabAdd: FloatingActionButton = findViewById(R.id.fabAdd)

            // Setup RecyclerView
            noteAdapter = NoteAdapter(
                notes = emptyList(),
                onItemClick = { note -> showEditDialog(note) },
                onItemLongClick = { note -> showDeleteConfirmationDialog(note) }
            )
            recyclerView.adapter = noteAdapter
            recyclerView.layoutManager = LinearLayoutManager(this)

            // Observe ViewModel
            noteViewModel.notes.observe(this) { notes ->
                noteAdapter.updateNotes(notes)
            }

            noteViewModel.isLoading.observe(this) { isLoading ->
                progressBar.visibility = if (isLoading) View.VISIBLE else View.GONE
            }

            noteViewModel.errorMessage.observe(this) { errorMessage ->
                if (errorMessage != null) {
                    tvErrorMessage.text = errorMessage
                    tvErrorMessage.visibility = View.VISIBLE
                } else {
                    tvErrorMessage.visibility = View.GONE
                }
            }

            // FAB click listener
            fabAdd.setOnClickListener {
                showAddDialog()
            }
        }

        private fun showAddDialog() {
            val dialogView = layoutInflater.inflate(R.layout.dialog_add_edit, null)
            val titleEditText = dialogView.findViewById<TextInputEditText>(R.id.etTitle)
            val bodyEditText = dialogView.findViewById<TextInputEditText>(R.id.etBody)

            AlertDialog.Builder(this)
                .setTitle("Tambah Catatan Baru")
                .setView(dialogView)
                .setPositiveButton("Tambah") { _, _ ->
                    val title = titleEditText.text.toString()
                    val body = bodyEditText.text.toString()
                    if (title.isNotEmpty() && body.isNotEmpty()) {
                        noteViewModel.createNote(title, body)
                    } else {
                        Toast.makeText(this, "Judul dan isi tidak boleh kosong", Toast.LENGTH_SHORT).show()
                    }
                }
                .setNegativeButton("Batal", null)
                .show()
        }

        private fun showEditDialog(note: Note) {
            val dialogView = layoutInflater.inflate(R.layout.dialog_add_edit, null)
            val titleEditText = dialogView.findViewById<TextInputEditText>(R.id.etTitle)
            val bodyEditText = dialogView.findViewById<TextInputEditText>(R.id.etBody)

            titleEditText.setText(note.title)
            bodyEditText.setText(note.body)

            AlertDialog.Builder(this)
                .setTitle("Edit Catatan")
                .setView(dialogView)
                .setPositiveButton("Simpan") { _, _ ->
                    val title = titleEditText.text.toString()
                    val body = bodyEditText.text.toString()
                    if (title.isNotEmpty() && body.isNotEmpty()) {
                        noteViewModel.updateNote(note.id, title, body)
                    } else {
                        Toast.makeText(this, "Judul dan isi tidak boleh kosong", Toast.LENGTH_SHORT).show()
                    }
                }
                .setNegativeButton("Batal", null)
                .show()
        }

        private fun showDeleteConfirmationDialog(note: Note) {
            AlertDialog.Builder(this)
                .setTitle("Hapus Catatan")
                .setMessage("Apakah Anda yakin ingin menghapus '${note.title}'?")
                .setPositiveButton("Hapus") { _, _ ->
                    noteViewModel.deleteNote(note.id)
                }
                .setNegativeButton("Batal", null)
                .show()
        }
    }
    ```

3.  **Buat Layout Dialog (`dialog_add_edit.xml`)**
    *   Buat file layout baru di `res/layout/dialog_add_edit.xml`.
    *   Tambahkan kode berikut:

    ```xml
    <!-- res/layout/dialog_add_edit.xml -->
    <?xml version="1.0" encoding="utf-8"?>
    <LinearLayout xmlns:android="http://schemas.android.com/apk/res/android"
        android:layout_width="match_parent"
        android:layout_height="wrap_content"
        android:orientation="vertical"
        android:padding="24dp">

        <com.google.android.material.textfield.TextInputLayout
            android:layout_width="match_parent"
            android:layout_height="wrap_content"
            android:hint="Judul">

            <com.google.android.material.textfield.TextInputEditText
                android:id="@+id/etTitle"
                android:layout_width="match_parent"
                android:layout_height="wrap_content"
                android:inputType="textCapSentences" />
        </com.google.android.material.textfield.TextInputLayout>

        <com.google.android.material.textfield.TextInputLayout
            android:layout_width="match_parent"
            android:layout_height="wrap_content"
            android:layout_marginTop="16dp"
            android:hint="Isi Catatan">

            <com.google.android.material.textfield.TextInputEditText
                android:id="@+id/etBody"
                android:layout_width="match_parent"
                android:layout_height="wrap_content"
                android:inputType="textMultiLine|textCapSentences"
                android:minLines="3" />
        </com.google.android.material.textfield.TextInputLayout>

    </LinearLayout>
    ```

#### **4.11. Menangani Error dan Debugging**

*   **Debugging Network Calls:** `HttpLoggingInterceptor` yang kita tambahkan di `RetrofitClient.kt` akan secara otomatis mencetak semua request dan response ke Logcat. Ini sangat membantu untuk debugging. Anda bisa memfilter Logcat dengan tag "OkHttp".
*   **Menampilkan Error ke Pengguna:** Di `MainActivity.kt`, kita sudah mengamati `noteViewModel.errorMessage`. Jika ada error dari API (misalnya, server tidak bisa dijangkau atau response error), `errorMessage` akan diupdate dan `TextView` `tvErrorMessage` akan muncul menampilkan pesan error tersebut.

---

### **5. Struktur File & Kode Lengkap**

Berikut adalah ringkasan file yang telah dibuat beserta isinya. Anda bisa menggunakan ini sebagai referensi atau untuk menyalin kode jika ada yang terlewat.

#### **Backend (CodeIgniter 4)**

```
crud-notes-api/
├── app/
│   ├── Config/
│   │   ├── Filters.php         // Diubah untuk menambahkan filter 'api-key'
│   │   └── Routes.php          // Diubah untuk menambahkan route /api/notes
│   ├── Controllers/
│   │   └── Notes.php           // Controller RESTful
│   ├── Database/
│   │   └── Migrations/
│   │       └── 2023-..._CreateNotesTable.php // File migrasi
│   ├── Filters/
│   │   └── ApiKeyFilter.php    // Filter untuk API Key
│   └── Models/
│       └── NoteModel.php       // Model untuk tabel notes
├── .env                        // Konfigurasi database
└── ... (file lainnya)
```

#### **Client (Android Kotlin)**

```
NotesApp/
└── app/
    └── src/
        └── main/
            ├── java/com/example/notesapp/
            │   ├── data/
            │   │   └── Note.kt                 // Model data
            │   ├── network/
            │   │   ├── ApiService.kt           // Interface Retrofit
            │   │   └── RetrofitClient.kt       // Retrofit Singleton
            │   ├── repository/
            │   │   └── NoteRepository.kt       // Repository
            │   ├── ui/
            │   │   ├── adapter/
            │   │   │   └── NoteAdapter.kt      // RecyclerView Adapter
            │   │   └── viewmodel/
            │   │       └── NoteViewModel.kt    // ViewModel
            │   └── MainActivity.kt             // Activity Utama
            ├── res/
            │   ├── layout/
            │   │   ├── activity_main.xml      // Layout utama
            │   │   ├── item_note.xml           // Layout item list
            │   │   └── dialog_add_edit.xml     // Layout dialog tambah/edit
            │   └── drawable/
            │       └── ic_add.xml              // Ikon FAB
            └── build.gradle.kts (Module :app)  // Dependensi
```

---

### **6. Contoh Data JSON (Request & Response)**

*   **GET /api/notes (Response Success)**
    ```json
    {
        "status": "success",
        "data": [
            {
                "id": 1,
                "title": "Belajar Kotlin",
                "body": "Kotlin adalah bahasa pemrograman modern untuk Android.",
                "created_at": "2023-10-27T12:00:00.000Z",
                "updated_at": "2023-10-27T12:00:00.000Z"
            },
            {
                "id": 2,
                "title": "Belajar CodeIgniter 4",
                "body": "CI4 adalah framework PHP yang powerful.",
                "created_at": "2023-10-27T12:05:00.000Z",
                "updated_at": "2023-10-27T12:05:00.000Z"
            }
        ]
    }
    ```

*   **POST /api/notes (Request Body)**
    ```json
    {
        "title": "Judul Baru",
        "body": "Isi dari catatan yang baru dibuat."
    }
    ```

*   **POST /api/notes (Response Success)**
    ```json
    {
        "status": "success",
        "message": "Note created successfully",
        "data": {
            "id": 3
        }
    }
    ```

*   **PUT /api/notes/1 (Request Body)**
    ```json
    {
        "title": "Judul Baru (Diubah)",
        "body": "Isi dari catatan yang sudah diperbarui."
    }
    ```

*   **PUT /api/notes/1 (Response Success)**
    ```json
    {
        "status": "success",
        "message": "Note updated successfully"
    }
    ```

*   **DELETE /api/notes/1 (Response Success)**
    ```json
    {
        "status": "success",
        "message": "Note deleted successfully"
    }
    ```

*   **Response Error (Contoh: Not Found)**
    ```json
    {
        "status": "error",
        "message": "Note not found"
    }
    ```

---

### **7. Langkah Pengujian & Postman Collection**

#### **Unit Test (Sederhana)**

Untuk backend, Anda bisa menggunakan PHPUnit yang sudah terintegrasi dengan CodeIgniter 4.

1.  Buat file test baru di `tests/Controller/NotesTest.php`.
2.  Tambahkan kode berikut untuk menguji endpoint `index`:

    ```php
    // tests/Controller/NotesTest.php

    <?php

    namespace Tests\Controllers;

    use CodeIgniter\Test\CIUnitTestCase;
    use CodeIgniter\Test\DatabaseTestTrait;
    use CodeIgniter\Test\FeatureTestTrait;

    class NotesTest extends CIUnitTestCase
    {
        use DatabaseTestTrait;
        use FeatureTestTrait;

        protected $basePath = APPPATH . 'Database/Migrations';
        protected $namespace = 'App';

        public function testCanGetAllNotes()
        {
            $result = $this->call('get', 'api/notes', [], [], ['X-API-Key' => 'YOUR_SECRET_API_KEY']);
            $result->assertStatus(200);
            $result->assertJSONFragment(['status' => 'success']);
        }
        
        // Tambahkan test case lainnya untuk create, update, delete
    }
    ```
3.  Jalankan test dari terminal:
    ```bash
    php spark test
    ```

#### **Postman Collection**

Anda dapat mengimpor koleksi ini langsung ke Postman untuk mempermudah pengujian.

1.  Buka Postman.
2.  Klik tombol **Import**.
3.  Pilih tab **Raw text** dan tempel kode JSON di bawah ini.
4.  Klik **Continue** dan **Import**.

```json
{
	"info": {
		"_postman_id": "a1b2c3d4-e5f6-7890-abcd-ef1234567890",
		"name": "Notes API CRUD",
		"schema": "https://schema.getpostman.com/json/collection/v2.1.0/collection.json"
	},
	"item": [
		{
			"name": "Get All Notes",
			"request": {
				"method": "GET",
				"header": [
					{
						"key": "X-API-Key",
						"value": "YOUR_SECRET_API_KEY",
						"type": "text"
					}
				],
				"url": {
					"raw": "http://localhost:8080/api/notes",
					"protocol": "http",
					"host": [
						"localhost"
					],
					"port": "8080",
					"path": [
						"api",
						"notes"
					]
				}
			},
			"response": []
		},
		{
			"name": "Create Note",
			"request": {
				"method": "POST",
				"header": [
					{
						"key": "X-API-Key",
						"value": "YOUR_SECRET_API_KEY",
						"type": "text"
					},
					{
						"key": "Content-Type",
						"value": "application/json",
						"type": "text"
					}
				],
				"body": {
					"mode": "raw",
					"raw": "{\n    \"title\": \"Catatan dari Postman\",\n    \"body\": \"Ini adalah isi catatan yang dibuat via Postman.\"\n}"
				},
				"url": {
					"raw": "http://localhost:8080/api/notes",
					"protocol": "http",
					"host": [
						"localhost"
					],
					"port": "8080",
					"path": [
						"api",
						"notes"
					]
				}
			},
			"response": []
		},
		{
			"name": "Get Note by ID",
			"request": {
				"method": "GET",
				"header": [
					{
						"key": "X-API-Key",
						"value": "YOUR_SECRET_API_KEY",
						"type": "text"
					}
				],
				"url": {
					"raw": "http://localhost:8080/api/notes/1",
					"protocol": "http",
					"host": [
						"localhost"
					],
					"port": "8080",
					"path": [
						"api",
						"notes",
						"1"
					]
				}
			},
			"response": []
		},
		{
			"name": "Update Note",
			"request": {
				"method": "PUT",
				"header": [
					{
						"key": "X-API-Key",
						"value": "YOUR_SECRET_API_KEY",
						"type": "text"
					},
					{
						"key": "Content-Type",
						"value": "application/json",
						"type": "text"
					}
				],
				"body": {
					"mode": "raw",
					"raw": "{\n    \"title\": \"Judul Catatan (Sudah Diubah)\",\n    \"body\": \"Isi catatan yang sudah diperbarui.\"\n}"
				},
				"url": {
					"raw": "http://localhost:8080/api/notes/1",
					"protocol": "http",
					"host": [
						"localhost"
					],
					"port": "8080",
					"path": [
						"api",
						"notes",
						"1"
					]
				}
			},
			"response": []
		},
		{
			"name": "Delete Note",
			"request": {
				"method": "DELETE",
				"header": [
					{
						"key": "X-API-Key",
						"value": "YOUR_SECRET_API_KEY",
						"type": "text"
					}
				],
				"url": {
					"raw": "http://localhost:8080/api/notes/1",
					"protocol": "http",
					"host": [
						"localhost"
					],
					"port": "8080",
					"path": [
						"api",
						"notes",
						"1"
					]
				}
			},
			"response": []
		}
	]
}
```

---

### **8. Tambahan untuk Mahasiswa**

#### **Soal Latihan**

1.  **Pagination:** Modifikasi endpoint `GET /api/notes` untuk mendukung pagination (misalnya dengan parameter `?page=1&limit=10`). Ubah juga client Android untuk memuat data per halaman (infinite scroll).
2.  **Searching:** Tambahkan fitur pencarian di backend (misalnya `GET /api/notes?search=keyword`) dan tampilkan hasilnya di Android.
3.  **Error Handling yang Lebih Baik:** Di aplikasi Android, perbaiki penanganan error dengan menampilkan pesan yang lebih spesifik (misalnya "Tidak ada koneksi internet", "Server sedang bermasalah") berdasarkan jenis exception yang terjadi.

#### **Tugas Pengayaan**

1.  **Autentikasi JWT (JSON Web Tokens):**
    *   Ganti API Key statis dengan sistem autentikasi menggunakan JWT.
    *   Buat endpoint `POST /api/login` yang menghasilkan token jika kredensial benar.
    *   Client Android harus menyimpan token (misalnya di `SharedPreferences`) dan mengirimkannya di header `Authorization: Bearer <token>` untuk request yang membutuhkan autentikasi.
    *   Buat middleware di CI4 untuk memvalidasi JWT.
2.  **Upload Gambar:**
    *   Tambahkan kolom `image_path` di tabel `notes`.
    *   Modifikasi endpoint `POST` dan `PUT` untuk menerima file gambar.
    *   Di aplikasi Android, tambahkan fungsi untuk memilih gambar dari galeri/kamera dan mengunggahnya bersama data catatan.
3.  **Cache Lokal dengan Room:**
    *   Implementasikan database Room di aplikasi Android untuk menyimpan catatan secara lokal.
    *   Aplikasi harus menampilkan data dari cache terlebih dahulu untuk pengalaman pengguna yang lebih cepat (offline-first), lalu menyinkronkan data dengan server di background.

#### **Rubrik Penilaian (untuk proyek akhir)**

| Kriteria | Sangat Baik (A) | Baik (B) | Cukup (C) | Kurang (D) |
| :--- | :--- | :--- | :--- | :--- |
| **Fungsi CRUD** | Semua operasi (Create, Read, Update, Delete) berjalan dengan sempurna di backend dan client. | Sebagian besar operasi berjalan dengan baik, ada sedikit bug minor. | Beberapa operasi tidak berfungsi atau memiliki bug yang signifikan. | Sebagian besar operasi tidak berfungsi. |
| **Kualitas Kode** | Kode terstruktur dengan baik (MVC/MVVM), bersih, mudah dibaca, dan menggunakan konvensi yang benar. | Kode cukup terstruktur dan mudah dibaca, tetapi ada beberapa bagian yang bisa diperbaiki. | Kode sulit dibaca, tidak terstruktur, atau tidak mengikuti konvensi. | Kode berantakan dan sulit dipahami. |
| **Keamanan** | Implementasi keamanan dasar (CORS, API Key/JWT, validasi input) sudah benar dan komprehensif. | Keamanan dasar sudah diterapkan tetapi ada celah kecil atau kurang lengkap. | Keamanan dasar tidak diterapkan dengan benar. | Tidak ada upaya keamanan sama sekali. |
| **UI/UX Android** | Antarmuka pengguna menarik, intuitif, responsif, dan memberikan feedback yang jelas (loading, error, success). | Antarmuka pengguna berfungsi dengan baik tetapi kurang menarik atau ada masalah minor pada responsivitas. | Antarmuka pengguna tidak intuitif atau memiliki masalah layout yang jelas. | Antarmuka pengguna sulit digunakan. |
| **Dokumentasi** | Dokumentasi (README, komentar kode) lengkap, jelas, dan membantu orang lain memahami proyek. | Dokumentasi ada tetapi kurang detail atau jelas. | Dokumentasi minimal atau tidak ada. | Tidak ada dokumentasi sama sekali. |