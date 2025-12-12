
# Membuat Aplikasi Daftar User Android dengan Kotlin & JSON API

## Daftar Isi
1.  [Pengenalan dan Prasyarat](#1-pengenalan-dan-prasyarat)
2.  [Modul 1: Setup Proyek Android Studio](#2-modul-1-setup-proyek-android-studio)
3.  [Modul 2: Menambahkan Dependencies & Izin Internet](#3-modul-2-menambahkan-dependencies--izin-internet)
4.  [Modul 3: Membuat Model Data (User)](#4-modul-3-membuat-model-data-user)
5.  [Modul 4: Membuat Lapisan Jaringan (API Service & Repository)](#5-modul-4-membuat-lapisan-jaringan-api-service--repository)
6.  [Modul 5: Membuat ViewModel](#6-modul-5-membuat-viewmodel)
7.  [Modul 6: Membuat Tampilan (Layouts & Adapter)](#7-modul-6-membuat-tampilan-layouts--adapter)
8.  [Modul 7: Menghubungkan Semua Komponen di MainActivity](#8-modul-7-menghubungkan-semua-komponen-di-mainactivity)
9.  [Modul 8: Menjalankan Aplikasi](#9-modul-8-menjalankan-aplikasi)
10. [Kesimpulan dan Langkah Selanjutnya](#10-kesimpulan-dan-langkah-selanjutnya)

---

### 1. Pengenalan dan Prasyarat

#### Apa yang akan kita buat?
Kita akan membangun sebuah aplikasi Android sederhana menggunakan bahasa pemrograman Kotlin. Aplikasi ini akan:
*   Mengambil data daftar pengguna (user) dari sebuah API publik di internet.
*   Menampilkan data tersebut dalam bentuk daftar yang dapat di-scroll.
*   Menampilkan indikator loading saat data sedang diambil.
*   Menampilkan pesan error jika terjadi masalah.

#### Prasyarat
*   **Android Studio**: Pastikan Anda telah menginstal Android Studio versi terbaru.
*   **Pemahaman Dasar Kotlin**: Familiar dengan variabel, fungsi, dan kelas dasar.
*   **Koneksi Internet**: Diperlukan untuk mengunduh dependencies dan mengakses API.

---

### 2. Modul 1: Setup Proyek Android Studio

Langkah pertama adalah membuat proyek baru di Android Studio.

#### Langkah 1: Membuat Proyek Baru
1.  Buka Android Studio Anda.
2.  Klik **New Project**.
3.  Pilih template **Empty Views Activity** lalu klik **Next**.
4.  Konfigurasi proyek Anda:
    *   **Name**: `UserListApp` (atau nama yang Anda suka)
    *   **Package name**: `com.example.userlistapp` (ini adalah identitas unik aplikasi Anda)
    *   **Save location**: Pilih folder di komputer Anda untuk menyimpan proyek.
    *   **Language**: Pilih **Kotlin**.
    *   **Minimum SDK**: Pilih **API 21: Android 5.0 (Lollipop)** atau yang lebih tinggi. Ini menentukan versi Android terendah yang bisa menjalankan aplikasi Anda.
5.  Klik **Finish**.

Android Studio akan memproses dan membangun proyek Anda. Tunggu hingga proses sinkronisasi selesai.

---

### 3. Modul 2: Menambahkan Dependencies & Izin Internet

Kita memerlukan beberapa library tambahan (dependencies) untuk mempermudah pekerjaan kita, seperti mengambil data dari internet (Retrofit) dan menampilkannya di daftar (RecyclerView).

#### Langkah 1: Menambahkan Dependencies
1.  Di panel sebelah kiri, buka file **Gradle Scripts > build.gradle.kts (Module :app)**.
2.  Temukan blok kode `dependencies { ... }`.
3.  Tambahkan library-library berikut di dalam blok tersebut:

```kotlin
// build.gradle.kts (Module: app)

dependencies {
    // ... dependencies lain yang sudah ada

    // TODO 1: TAMBAHKAN DEPENDENCIES YANG DIPERLUKAN
    // Retrofit: Library untuk melakukan permintaan HTTP ke API (mengambil data dari internet).
    implementation("com.squareup.retrofit2:retrofit:2.9.0")
    
    // Gson Converter: "Penerjemah" untuk mengubah data dari format JSON menjadi objek Kotlin yang bisa kita gunakan.
    implementation("com.squareup.retrofit2:converter-gson:2.9.0")

    // ViewModel: Komponen untuk menyimpan dan mengelola data yang terkait dengan UI.
    // Data di ViewModel tidak akan hilang meskipun layar diputar.
    implementation("androidx.lifecycle:lifecycle-viewmodel-ktx:2.6.2")
    implementation("androidx.lifecycle:lifecycle-livedata-ktx:2.6.2")

    // Coroutines: Cara modern untuk menjalankan operasi yang memakan waktu (seperti network request)
    // di latar belakang agar aplikasi tidak macet (freeze).
    implementation("org.jetbrains.kotlinx:kotlinx-coroutines-android:1.7.3")

    // RecyclerView: Komponen UI yang efisien untuk menampilkan data dalam bentuk daftar yang panjang.
    implementation("androidx.recyclerview:recyclerview:1.3.2")

    // CardView: Memberikan "kartu" dengan bayangan dan sudut melengkung pada setiap item di daftar.
    implementation("androidx.cardview:cardview:1.0.0")
}
```

#### Langkah 2: Menambahkan Izin Internet
Aplikasi kita memerlukan izin untuk mengakses internet.
1.  Buka file **app > src > main > AndroidManifest.xml**.
2.  Tambahkan baris berikut tepat sebelum tag `<application>`:

```xml
<!-- AndroidManifest.xml -->
<?xml version="1.0" encoding="utf-8"?>
<manifest xmlns:android="http://schemas.android.com/apk/res/android"
    xmlns:tools="http://schemas.android.com/tools">

    <!-- TODO 2: TAMBAHKAN IZIN INTERNET -->
    <!-- Izin ini WAJIB ditambahkan agar aplikasi diizinkan untuk terhubung ke internet. -->
    <uses-permission android:name="android.permission.INTERNET" />

    <application ...>
        ...
    </application>

</manifest>
```

#### Langkah 3: Sinkronisasi
Setelah menambahkan dependencies, sebuah banner "Sync Now" akan muncul di bagian atas editor. Klik tombol tersebut untuk mengunduh library yang baru ditambahkan.

---

### 4. Modul 3: Membuat Model Data (User)

Model adalah kelas yang menjadi "cetakan" atau "blueprint" untuk data yang kita terima dari API. Struktur kelas ini harus sesuai dengan struktur JSON.

#### Langkah 1: Buat Package `model`
Untuk mengorganisir kode, kita akan membuat package khusus untuk model.
1.  Di panel Project, klik kanan pada package utama Anda (`com.example.userlistapp`).
2.  Pilih **New > Package**.
3.  Ketik `model` lalu tekan Enter.

#### Langkah 2: Buat File `User.kt`
1.  Klik kanan pada package `model` yang baru saja dibuat.
2.  Pilih **New > Kotlin Class/File**.
3.  Beri nama `User` dan pilih **Class**.
4.  Tambahkan kode berikut ke dalam file `User.kt`:

```kotlin
// model/User.kt
package com.example.userlistapp.model

import com.google.gson.annotations.SerializedName

// TODO 3: BUAT DATA CLASS UNTUK USER
// `data class` adalah kelas khusus di Kotlin yang dirancang untuk menyimpan data.
// Secara otomatis menyediakan fungsi seperti equals(), hashCode(), toString(), dll.
data class User(
    val id: Int,
    val name: String,
    val username: String,
    val email: String,
    val phone: String,
    val website: String,

    // TODO 4: GUNAKAN @SerializedName UNTUK MEMETAKAN NAMA FIELD JSON
    // Karena nama field di JSON ("address") berbeda dengan nama variabel yang kita inginkan di Kotlin ("userAddress"),
    // kita gunakan anotasi @SerializedName untuk memberitahu Gson cara memetakan-nya.
    @SerializedName("address")
    val userAddress: Address,

    @SerializedName("company")
    val userCompany: Company
)

// Kelas ini merepresentasikan objek "address" yang ada di dalam JSON.
data class Address(
    val street: String,
    val suite: String,
    val city: String,
    val zipcode: String,
    val geo: Geo
)

// Kelas ini merepresentasikan objek "geo" yang ada di dalam "address".
data class Geo(
    val lat: String,
    val lng: String
)

// Kelas ini merepresentasikan objek "company" yang ada di dalam JSON.
data class Company(
    @SerializedName("name")
    val companyName: String,
    @SerializedName("catchPhrase")
    val catchPhrase: String,
    val bs: String
)
```

**Penjelasan:**
*   `data class`: Mewakili data user. Setiap properti (`val id`, `val name`, dll.) sesuai dengan field di JSON.
*   `@SerializedName`: Sangat penting jika nama field di JSON berbeda dengan nama properti di kelas Kotlin Anda. Ini memastikan Gson bisa mengisi data dengan benar.

---

### 5. Modul 4: Membuat Lapisan Jaringan (API Service & Repository)

Kita akan memisahkan logika pengambilan data dari UI. Ini adalah bagian dari arsitektur yang baik.

#### Langkah 1: Buat Package `api`
1.  Klik kanan pada package utama (`com.example.userlistapp`).
2.  Pilih **New > Package**.
3.  Beri nama `api`.

#### Langkah 2: Buat Interface `ApiService.kt`
Interface ini mendefinisikan "kontrak" API: endpoint mana yang akan kita panggil.
1.  Klik kanan pada package `api`.
2.  Pilih **New > Kotlin Class/File**.
3.  Beri nama `ApiService` dan pilih **Interface**.
4.  Tambahkan kode berikut:

```kotlin
// api/ApiService.kt
package com.example.userlistapp.api

import com.example.userlistapp.model.User
import retrofit2.Call
import retrofit2.http.GET

// TODO 5: BUAT INTERFACE UNTUK LAYANAN API
// Interface ini berfungsi sebagai "kontrak" atau "blueprint" untuk permintaan API.
interface ApiService {

    // TODO 6: DEFINISIKAN ENDPOINT
    // @GET adalah anotasi Retrofit untuk permintaan HTTP GET.
    // "users" adalah path endpoint yang akan ditambahkan ke base URL.
    // URL lengkapnya menjadi: https://jsonplaceholder.typicode.com/users
    @GET("users")
    fun getUsers(): Call<List<User>>
}
```

**Penjelasan:**
*   `@GET("users")`: Memberitahu Retrofit untuk melakukan permintaan GET ke endpoint `/users`.
*   `Call<List<User>>`: Tipe return yang menjanjikan bahwa hasilnya akan berupa daftar (`List`) dari objek `User`.

#### Langkah 3: Buat Package `repository`
1.  Klik kanan pada package utama (`com.example.userlistapp`).
2.  Pilih **New > Package**.
3.  Beri nama `repository`.

#### Langkah 4: Buat Kelas `UserRepository.kt`
Repository adalah "gudang data". Ia bertanggung jawab mengambil data dan menyediakannya bagi bagian lain aplikasi.
1.  Klik kanan pada package `repository`.
2.  Pilih **New > Kotlin Class/File**.
3.  Beri nama `UserRepository` dan pilih **Class**.
4.  Tambahkan kode berikut:

```kotlin
// repository/UserRepository.kt
package com.example.userlistapp.repository

import android.app.Application
import androidx.lifecycle.LiveData
import androidx.lifecycle.MutableLiveData
import com.example.userlistapp.api.ApiService
import com.example.userlistapp.model.User
import retrofit2.Call
import retrofit2.Callback
import retrofit2.Response
import retrofit2.Retrofit
import retrofit2.converter.gson.GsonConverterFactory

class UserRepository(application: Application) {
    private val apiService: ApiService

    // TODO 7: BUAT MUTABLELIVEDATA
    // LiveData adalah kelas yang bisa diamati (observable). UI bisa "mendengarkan" perubahan data di dalamnya.
    // MutableLiveData adalah versi yang bisa diubah nilainya.
    private val _users = MutableLiveData<List<User>>()
    // TODO 8: EKSPOR LIVEADATA YANG TIDAK BISA DIUBAH (READ-ONLY)
    // Ini adalah LiveData yang bersifat publik dan hanya bisa dibaca. UI akan menggunakan ini.
    val users: LiveData<List<User>> = _users

    // LiveData untuk melacak status loading
    private val _isLoading = MutableLiveData<Boolean>()
    val isLoading: LiveData<Boolean> = _isLoading

    // LiveData untuk menyimpan pesan error
    private val _errorMessage = MutableLiveData<String>()
    val errorMessage: LiveData<String> = _errorMessage

    // `init` adalah blok kode yang dijalankan saat objek UserRepository dibuat.
    init {
        // TODO 9: INISIALISASI RETROFIT
        val retrofit = Retrofit.Builder()
            .baseUrl("https://jsonplaceholder.typicode.com/") // Alamat utama API
            .addConverterFactory(GsonConverterFactory.create()) // Gunakan Gson untuk parsing JSON
            .build()
        apiService = retrofit.create(ApiService::class.java)
    }

    // Fungsi untuk memulai pengambilan data user.
    fun fetchUsers() {
        _isLoading.value = true // Set status loading menjadi true

        // TODO 10: LAKUKAN PEMANGGILAN API SECARA ASYNCHRONOUS
        // `enqueue` menjalankan permintaan di background thread agar UI tidak macet.
        apiService.getUsers().enqueue(object : Callback<List<User>> {
            // Dipanggil jika server memberikan respons.
            override fun onResponse(call: Call<List<User>>, response: Response<List<User>>) {
                _isLoading.value = false // Set status loading menjadi false

                if (response.isSuccessful) {
                    // Jika berhasil, simpan data ke LiveData.
                    _users.value = response.body()
                } else {
                    // Jika ada error dari server (misal 404), tampilkan pesan error.
                    _errorMessage.value = "Error: ${response.code()} ${response.message()}"
                }
            }

            // Dipanggil jika terjadi kesalahan jaringan (misal: tidak ada internet).
            override fun onFailure(call: Call<List<User>>, t: Throwable) {
                _isLoading.value = false
                _errorMessage.value = "Failure: ${t.message}"
            }
        })
    }
}
```

---

### 6. Modul 5: Membuat ViewModel

ViewModel adalah "otak" dari UI. Ia mengambil data dari Repository dan menyediakannya untuk Activity/Fragment. Ia juga bertahan dari perubahan konfigurasi (seperti rotasi layar).

#### Langkah 1: Buat Package `viewmodel`
1.  Klik kanan pada package utama (`com.example.userlistapp`).
2.  Pilih **New > Package**.
3.  Beri nama `viewmodel`.

#### Langkah 2: Buat Kelas `UserViewModel.kt`
1.  Klik kanan pada package `viewmodel`.
2.  Pilih **New > Kotlin Class/File**.
3.  Beri nama `UserViewModel` dan pilih **Class**.
4.  Tambahkan kode berikut:

```kotlin
// viewmodel/UserViewModel.kt
package com.example.userlistapp.viewmodel

import android.app.Application
import androidx.lifecycle.AndroidViewModel
import androidx.lifecycle.LiveData
import androidx.lifecycle.viewModelScope
import com.example.userlistapp.model.User
import com.example.userlistapp.repository.UserRepository
import kotlinx.coroutines.launch

// TODO 11: BUAT VIEWMODEL
// `AndroidViewModel` adalah subclass ViewModel yang menerima `Application` context.
class UserViewModel(application: Application) : AndroidViewModel(application) {

    // Membuat instance dari Repository.
    private val repository = UserRepository(application)

    // TODO 12: EKSPOR LIVEADATA DARI REPOSITORY KE UI
    // ViewModel hanya perlu mengekspos LiveData dari Repository. UI akan mengamati LiveData di sini.
    val users: LiveData<List<User>> = repository.users
    val isLoading: LiveData<Boolean> = repository.isLoading
    val errorMessage: LiveData<String> = repository.errorMessage

    // `init` blok dijalankan saat pertama kali UserViewModel dibuat.
    init {
        fetchUsers() // Langsung ambil data saat ViewModel dibuat.
    }

    // Fungsi untuk memanggil repository.
    private fun fetchUsers() {
        // TODO 13: GUNAKAN COROUTINES UNTUK MENJALANKAN FUNGSI REPOSITORY
        // `viewModelScope` adalah scope coroutine yang terikat dengan lifecycle ViewModel.
        // Jika ViewModel dihancurkan, coroutine ini otomatis dibatalkan.
        viewModelScope.launch {
            repository.fetchUsers()
        }
    }
}
```

---

### 7. Modul 6: Membuat Tampilan (Layouts & Adapter)

Sekarang kita akan membuat bagian visual dari aplikasi.

#### Langkah 1: Buat Layout untuk Satu Item (`item_user.xml`)
Ini adalah tampilan untuk setiap kartu user di dalam daftar.
1.  Klik kanan pada folder **res > layout**.
2.  Pilih **New > Layout Resource File**.
3.  Beri nama `item_user.xml`.
4.  Pastikan Root element adalah `androidx.cardview.widget.CardView`.
5.  Tambahkan kode berikut:

```xml
<!-- res/layout/item_user.xml -->
<?xml version="1.0" encoding="utf-8"?>
<!-- TODO 14: GUNAKAN CARDVIEW UNTUK SETIAP ITEM -->
<androidx.cardview.widget.CardView xmlns:android="http://schemas.android.com/apk/res/android"
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
            android:id="@+id/tvName"
            android:layout_width="match_parent"
            android:layout_height="wrap_content"
            android:textSize="18sp"
            android:textStyle="bold"
            tools:text="Leanne Graham" />

        <TextView
            android:id="@+id/tvUsername"
            android:layout_width="match_parent"
            android:layout_height="wrap_content"
            android:layout_marginTop="4dp"
            android:textSize="14sp"
            android:textStyle="italic"
            tools:text="@Bret" />

        <TextView
            android:id="@+id/tvEmail"
            android:layout_width="match_parent"
            android:layout_height="wrap_content"
            android:layout_marginTop="4dp"
            android:textSize="14sp"
            tools:text="Sincere@april.biz" />

        <TextView
            android:id="@+id/tvPhone"
            android:layout_width="match_parent"
            android:layout_height="wrap_content"
            android:layout_marginTop="4dp"
            android:textSize="14sp"
            tools:text="1-770-736-8031 x56442" />

        <TextView
            android:id="@+id/tvWebsite"
            android:layout_width="match_parent"
            android:layout_height="wrap_content"
            android:layout_marginTop="4dp"
            android:textSize="14sp"
            tools:text="hildegard.org" />

        <TextView
            android:id="@+id/tvAddress"
            android:layout_width="match_parent"
            android:layout_height="wrap_content"
            android:layout_marginTop="4dp"
            android:textSize="14sp"
            tools:text="Kulas Light, Apt. 556, Gwenborough, 92998-3874" />

        <TextView
            android:id="@+id/tvCompany"
            android:layout_width="match_parent"
            android:layout_height="wrap_content"
            android:layout_marginTop="4dp"
            android:textSize="14sp"
            tools:text="Romaguera-Crona" />

    </LinearLayout>

</androidx.cardview.widget.CardView>
```

#### Langkah 2: Ubah Layout Utama (`activity_main.xml`)
Ini adalah tampilan utama yang akan menampilkan daftar, loading, dan error.
1.  Buka file **res > layout > activity_main.xml**.
2.  Ganti seluruh isinya dengan kode berikut:

```xml
<!-- res/layout/activity_main.xml -->
<?xml version="1.0" encoding="utf-8"?>
<androidx.constraintlayout.widget.ConstraintLayout xmlns:android="http://schemas.android.com/apk/res/android"
    xmlns:app="http://schemas.android.com/apk/res-auto"
    xmlns:tools="http://schemas.android.com/tools"
    android:layout_width="match_parent"
    android:layout_height="match_parent"
    tools:context=".MainActivity">

    <!-- TODO 15: TAMBAHKAN RECYCLERVIEW, PROGRESSBAR, DAN TEXTVIEW ERROR -->
    <androidx.recyclerview.widget.RecyclerView
        android:id="@+id/recyclerView"
        android:layout_width="0dp"
        android:layout_height="0dp"
        android:padding="8dp"
        app:layout_constraintBottom_toBottomOf="parent"
        app:layout_constraintEnd_toEndOf="parent"
        app:layout_constraintStart_toStartOf="parent"
        app:layout_constraintTop_toTopOf="parent" />

    <ProgressBar
        android:id="@+id/progressBar"
        android:layout_width="wrap_content"
        android:layout_height="wrap_content"
        android:visibility="gone"
        app:layout_constraintBottom_toBottomOf="parent"
        app:layout_constraintEnd_toEndOf="parent"
        app:layout_constraintStart_toStartOf="parent"
        app:layout_constraintTop_toTopOf="parent" />

    <TextView
        android:id="@+id/tvErrorMessage"
        android:layout_width="wrap_content"
        android:layout_height="wrap_content"
        android:padding="16dp"
        android:textColor="@android:color/holo_red_dark"
        android:textSize="16sp"
        android:visibility="gone"
        app:layout_constraintBottom_toBottomOf="parent"
        app:layout_constraintEnd_toEndOf="parent"
        app:layout_constraintStart_toStartOf="parent"
        app:layout_constraintTop_toTopOf="parent"
        tools:text="Error message" />

</androidx.constraintlayout.widget.ConstraintLayout>
```

#### Langkah 3: Buat Package `adapter`
1.  Klik kanan pada package utama (`com.example.userlistapp`).
2.  Pilih **New > Package**.
3.  Beri nama `adapter`.

#### Langkah 4: Buat Kelas `UserAdapter.kt`
Adapter adalah "penghubung" yang mengambil data dari `List<User>` dan menampilkannya di setiap item `RecyclerView`.
1.  Klik kanan pada package `adapter`.
2.  Pilih **New > Kotlin Class/File**.
3.  Beri nama `UserAdapter` dan pilih **Class**.
4.  Tambahkan kode berikut:

```kotlin
// adapter/UserAdapter.kt
package com.example.userlistapp.adapter

import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
import android.widget.TextView
import androidx.recyclerview.widget.RecyclerView
import com.example.userlistapp.R
import com.example.userlistapp.model.User

// TODO 16: BUAT ADAPTER UNTUK RECYCLERVIEW
class UserAdapter(private var userList: List<User>) : RecyclerView.Adapter<UserAdapter.UserViewHolder>() {

    // TODO 17: BUAT VIEWHOLDER
    // ViewHolder menyimpan referensi ke View-view yang ada di layout item_user.xml.
    class UserViewHolder(itemView: View) : RecyclerView.ViewHolder(itemView) {
        val tvName: TextView = itemView.findViewById(R.id.tvName)
        val tvUsername: TextView = itemView.findViewById(R.id.tvUsername)
        val tvEmail: TextView = itemView.findViewById(R.id.tvEmail)
        val tvPhone: TextView = itemView.findViewById(R.id.tvPhone)
        val tvWebsite: TextView = itemView.findViewById(R.id.tvWebsite)
        val tvAddress: TextView = itemView.findViewById(R.id.tvAddress)
        val tvCompany: TextView = itemView.findViewById(R.id.tvCompany)
    }

    // TODO 18: IMPLEMENTASIKAN onCreateVIEWHOLDER
    // Dipanggil saat RecyclerView perlu membuat ViewHolder baru.
    override fun onCreateViewHolder(parent: ViewGroup, viewType: Int): UserViewHolder {
        val view = LayoutInflater.from(parent.context).inflate(R.layout.item_user, parent, false)
        return UserViewHolder(view)
    }

    // TODO 19: IMPLEMENTASIKAN onBINDVIEWHOLDER
    // Dipanggil untuk menghubungkan data dengan View di posisi tertentu.
    override fun onBindViewHolder(holder: UserViewHolder, position: Int) {
        val user = userList[position]

        holder.tvName.text = user.name
        holder.tvUsername.text = "@${user.username}"
        holder.tvEmail.text = user.email
        holder.tvPhone.text = user.phone
        holder.tvWebsite.text = user.website

        val address = "${user.userAddress.street}, ${user.userAddress.suite}, ${user.userAddress.city}, ${user.userAddress.zipcode}"
        holder.tvAddress.text = address

        holder.tvCompany.text = user.userCompany.companyName
    }

    // TODO 20: IMPLEMENTASIKAN getITEMCOUNT
    // Memberi tahu RecyclerView berapa total item yang ada.
    override fun getItemCount(): Int {
        return userList.size
    }

    // TODO 21: BUAT FUNGSI UNTUK MEMPERBARUI DATA
    // Fungsi ini dipanggil dari Activity untuk memberikan data baru.
    fun updateUserList(newUserList: List<User>) {
        userList = newUserList
        notifyDataSetChanged() // Memberi tahu RecyclerView untuk menampilkan ulang data.
    }
}
```

---

### 8. Modul 7: Menghubungkan Semua Komponen di MainActivity

Ini adalah langkah terakhir di mana kita menghubungkan UI (XML), Adapter, dan ViewModel untuk membuat aplikasi berfungsi.

#### Langkah 1: Buka dan Edit `MainActivity.kt`
1.  Buka file `MainActivity.kt` di package utama Anda.
2.  Ganti seluruh isinya dengan kode berikut:

```kotlin
// MainActivity.kt
package com.example.userlistapp

import android.os.Bundle
import android.view.View
import android.widget.ProgressBar
import android.widget.TextView
import androidx.activity.viewModels
import androidx.appcompat.app.AppCompatActivity
import androidx.recyclerview.widget.LinearLayoutManager
import androidx.recyclerview.widget.RecyclerView
import com.example.userlistapp.adapter.UserAdapter
import com.example.userlistapp.viewmodel.UserViewModel

class MainActivity : AppCompatActivity() {

    // TODO 22: DAPATKAN INSTANCE VIEWMODEL
    // `by viewModels()` adalah cara mudah untuk mendapatkan instance ViewModel yang terhubung dengan Activity ini.
    private val userViewModel: UserViewModel by viewModels()

    // Deklarasi variabel untuk komponen UI.
    private lateinit var userAdapter: UserAdapter
    private lateinit var recyclerView: RecyclerView
    private lateinit var progressBar: ProgressBar
    private lateinit var tvErrorMessage: TextView

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        setContentView(R.layout.activity_main)

        // Inisialisasi View dari XML.
        recyclerView = findViewById(R.id.recyclerView)
        progressBar = findViewById(R.id.progressBar)
        tvErrorMessage = findViewById(R.id.tvErrorMessage)

        setupRecyclerView()
        observeViewModel()
    }

    // Fungsi untuk mengatur RecyclerView.
    private fun setupRecyclerView() {
        userAdapter = UserAdapter(emptyList())
        recyclerView.layoutManager = LinearLayoutManager(this)
        recyclerView.adapter = userAdapter
    }

    // Fungsi untuk mengamati perubahan data dari ViewModel.
    private fun observeViewModel() {
        // TODO 23: AMATI PERUBAHAN DATA USER
        userViewModel.users.observe(this) { users ->
            if (users.isNotEmpty()) {
                userAdapter.updateUserList(users)
                recyclerView.visibility = View.VISIBLE
                tvErrorMessage.visibility = View.GONE
            }
        }

        // TODO 24: AMATI STATUS LOADING
        userViewModel.isLoading.observe(this) { isLoading ->
            progressBar.visibility = if (isLoading) View.VISIBLE else View.GONE
            if (isLoading) {
                recyclerView.visibility = View.GONE
                tvErrorMessage.visibility = View.GONE
            }
        }

        // TODO 25: AMATI PESAN ERROR
        userViewModel.errorMessage.observe(this) { errorMessage ->
            if (errorMessage.isNotEmpty()) {
                tvErrorMessage.text = errorMessage
                tvErrorMessage.visibility = View.VISIBLE
                recyclerView.visibility = View.GONE
            }
        }
    }
}
```

---

### 9. Modul 8: Menjalankan Aplikasi

Sekarang, saatnya melihat hasil kerja kita!
1.  Pastikan Anda memiliki emulator Android yang berjalan atau perangkat fisik yang terhubung ke komputer.
2.  Klik tombol **Run 'app'** (ikon segitiga hijau) di toolbar Android Studio.
3.  Tunggu hingga aplikasi selesai dibangun dan diinstal.
4.  Aplikasi akan terbuka dan menampilkan **ProgressBar** sebentar, lalu menampilkan daftar user dalam bentuk kartu-kartu.

---

### 10. Kesimpulan dan Langkah Selanjutnya

#### Apa yang telah kita pelajari?
*   **Struktur Proyek**: Cara mengorganisir kode dengan package (`model`, `api`, `repository`, `viewmodel`, `adapter`).
*   **Arsitektur MVVM**: Memisahkan logika bisnis (Model, ViewModel) dari tampilan (View).
*   **Networking**: Menggunakan Retrofit untuk mengambil data dari REST API.
*   **Parsing JSON**: Menggunakan Gson Converter untuk mengubah JSON menjadi objek Kotlin.
*   **UI Dinamis**: Menggunakan `RecyclerView` dan `Adapter` untuk menampilkan daftar data secara efisien.
*   **Data Management**: Menggunakan `ViewModel` dan `LiveData` untuk mengelola data UI dengan aman.
*   **Asynchronous Task**: Menggunakan `Coroutines` untuk operasi di latar belakang.

#### Langkah Selanjutnya (Tantangan!)
Anda bisa mengembangkan aplikasi ini lebih lanjut:
1.  **Detail Screen**: Ketika salah satu item user diklik, buka halaman baru yang menampilkan detail lengkap user.
2.  **Pull-to-Refresh**: Tambahkan fitur untuk menarik ke bawah daftar untuk memuat ulang data.
3.  **Search Bar**: Tambahkan kolom pencarian untuk menyaring user berdasarkan nama atau username.
4.  **Error Handling**: Tambahkan tombol "Coba Lagi" jika terjadi error.
5.  **Caching**: Simpan data user yang sudah diambil ke database lokal (misalnya Room) agar aplikasi tetap bisa menampilkan data saat offline.
