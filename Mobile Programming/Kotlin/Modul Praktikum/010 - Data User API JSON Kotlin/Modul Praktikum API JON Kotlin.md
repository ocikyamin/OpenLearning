
# Tutorial Lengkap: Aplikasi Daftar User dengan Kotlin dan JSON API

> # Setup Proyek Android Studio
## Langkah 1: Membuat Proyek Baru
 - Buka Android Studio
 - Klik "New Project"
 - Pilih "Empty Views Activity"
 - Klik "Next"

## Konfigurasi proyek:
 - Name: UserListApp (atau nama yang Anda inginkan)
 - Package name: com.example.userlistapp (atau sesuai keinginan)
 - Save location: Pilih lokasi penyimpanan
 - Language: Kotlin
 - Minimum SDK: API 21: Android 5.0 (Lollipop) atau lebih tinggi
 - Klik "Finish"

## Langkah 2: Menunggu Proyek Dibuat
Android Studio akan membuat proyek baru dan mengunduh dependencies yang diperlukan. Tunggu hingga proses selesai.

## Menambahkan Dependencies yang Diperlukan
Kita akan menggunakan beberapa library untuk mempermudah pengembangan aplikasi:

## 1. Menambahkan Dependencies

Buka file `build.gradle.kts (Module: app)` dan tambahkan library yang kita butuhkan.

```kotlin
// build.gradle.kts (Module: app)

plugins {
    id("com.android.application")
    id("org.jetbrains.kotlin.android")
}

android { ... } // Konfigurasi Android lainnya

dependencies {
    // Library standar Android
    implementation("androidx.core:core-ktx:1.12.0")
    implementation("androidx.appcompat:appcompat:1.6.1")
    implementation("com.google.android.material:material:1.11.0")
    implementation("androidx.constraintlayout:constraintlayout:2.1.4")
    testImplementation("junit:junit:4.13.2")
    androidTestImplementation("androidx.test.ext:junit:1.1.5")
    androidTestImplementation("androidx.test.espresso:espresso-core:3.5.1")

    // TODO 1: TAMBAHKAN DEPENDENCIES UNTUK NETWORK, VIEWMODEL, DAN RECYCLERVIEW
    // Retrofit adalah library yang sangat populer untuk melakukan permintaan HTTP ke API.
    // Ini memudahkan kita mengambil data dari internet.
    implementation("com.squareup.retrofit2:retrofit:2.9.0")
    
    // Converter Gson adalah "penerjemah" yang bekerja sama dengan Retrofit.
    // Tugasnya mengubah data dari format JSON (yang didapat dari API) menjadi objek Kotlin yang bisa kita gunakan.
    implementation("com.squareup.retrofit2:converter-gson:2.9.0")

    // ViewModel adalah bagian dari Android Architecture Components.
    // Fungsinya untuk menyimpan dan mengelola data yang terkait dengan UI (tampilan).
    // Data di ViewModel tidak akan hilang meskipun layar diputar (rotasi).
    implementation("androidx.lifecycle:lifecycle-viewmodel-ktx:2.6.2")
    implementation("androidx.lifecycle:lifecycle-livedata-ktx:2.6.2")

    // Coroutines adalah cara modern untuk menjalankan operasi yang memakan waktu (seperti network request)
    // di "latar belakang" (background thread) agar aplikasi tidak macet (freeze).
    implementation("org.jetbrains.kotlinx:kotlinx-coroutines-android:1.7.3")

    // RecyclerView adalah komponen UI yang sangat efisien untuk menampilkan data dalam bentuk daftar yang panjang.
    // Ia hanya menampilkan item yang terlihat di layar, menghemat memori.
    implementation("androidx.recyclerview:recyclerview:1.3.2")

    // CardView memberikan "kartu" dengan bayangan dan sudut melengkung pada setiap item di daftar kita,
    // membuat tampilan lebih rapi dan modern.
    implementation("androidx.cardview:cardview:1.0.0")
}
```

Jangan lupa tambahkan izin internet di `AndroidManifest.xml`.

```xml
<!-- AndroidManifest.xml -->
<?xml version="1.0" encoding="utf-8"?>
<manifest xmlns:android="http://schemas.android.com/apk/res/android"
    xmlns:tools="http://schemas.android.com/tools">

    <!-- TODO 2: TAMBAHKAN IZIN INTERNET -->
    <!-- Izin ini WAJIB ditambahkan agar aplikasi kita diizinkan oleh sistem Android
         untuk melakukan koneksi ke internet. Tanpa ini, permintaan ke API akan gagal. -->
    <uses-permission android:name="android.permission.INTERNET" />

    <application ...>
        ...
    </application>

</manifest>
```

---

## 2. Membuat Model Data (`User.kt`)

Model adalah kelas yang menjadi "cetakan" untuk data JSON yang kita terima.

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
// Struktur ini harus sama persis dengan struktur JSON.
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
    // Kita juga menggunakan @SerializedName di sini karena ada field "name" di dalam "company".
    // Untuk menghindari kebingungan dengan `name` di kelas User, kita beri nama `companyName`.
    @SerializedName("name")
    val companyName: String,
    @SerializedName("catchPhrase")
    val catchPhrase: String,
    val bs: String
)
```

---

## 3. Membuat API Service Interface (`ApiService.kt`)

Interface ini mendefinisikan "kontrak" atau permintaan apa saja yang bisa kita lakukan ke server.

```kotlin
// api/ApiService.kt
package com.example.userlistapp.api

import com.example.userlistapp.model.User
import retrofit2.Call
import retrofit2.http.GET

// TODO 5: BUAT INTERFACE UNTUK LAYANAN API
// `interface` di sini berfungsi sebagai "kontrak" atau "blueprint" untuk permintaan API.
// Retrofit akan menggunakan definisi ini untuk membuat kode aktual yang melakukan permintaan jaringan.
interface ApiService {

    // TODO 6: DEFINISIKAN ENDPOINT
    // @GET adalah anotasi yang memberitahu Retrofit bahwa ini adalah permintaan HTTP GET.
    // "users" adalah path endpoint yang akan ditambahkan ke base URL.
    // Jadi, URL lengkapnya menjadi: https://jsonplaceholder.typicode.com/users
    @GET("users")
    fun getUsers(): Call<List<User>>

    // Fungsi ini mendefinisikan bahwa saat kita memanggil `getUsers()`,
    // Retrofit akan menjalankan permintaan GET dan mengharapkan respons yang berupa daftar (List) dari objek User.
    // `Call<List<User>>` adalah objek yang mewakili permintaan tersebut. Kita bisa menjalankannya secara asynchronous.
}
```

---

## 4. Membuat Repository (`UserRepository.kt`)

Repository adalah lapisan yang bertanggung jawab atas pengambilan data. Ia menyembunyikan detail dari mana data berasal (dari API, database lokal, dll.) dari bagian lain aplikasi.

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
    // MutableLiveData adalah versi yang bisa diubah nilainya (bisa read & write).
    // Kita gunakan `_` sebagai awalan (konvensi) untuk LiveData yang privat dan bisa diubah.
    private val _users = MutableLiveData<List<User>>()
    // TODO 8: EKSPOR LIVEADATA YANG TIDAK BISA DIUBAH (READ-ONLY)
    // Ini adalah LiveData yang bersifat publik dan hanya bisa dibaca (read-only).
    // UI (Activity/Fragment) akan menggunakan ini untuk mengamati perubahan data.
    val users: LiveData<List<User>> = _users

    // LiveData untuk melacak status loading (apakah sedang mengambil data?)
    private val _isLoading = MutableLiveData<Boolean>()
    val isLoading: LiveData<Boolean> = _isLoading

    // LiveData untuk menyimpan pesan error jika terjadi kegagalan
    private val _errorMessage = MutableLiveData<String>()
    val errorMessage: LiveData<String> = _errorMessage

    // `init` adalah blok kode yang akan dijalankan pertama kali saat objek UserRepository dibuat.
    init {
        // TODO 9: INISIALISASI RETROFIT
        // Kita membangun (build) instance Retrofit di sini.
        val retrofit = Retrofit.Builder()
            // `baseUrl` adalah alamat utama dari API. Semua endpoint akan ditambahkan ke belakang alamat ini.
            .baseUrl("https://jsonplaceholder.typicode.com/")
            // `addConverterFactory` memberitahu Retrofit untuk menggunakan Gson converter
            // agar bisa secara otomatis mengubah JSON menjadi objek Kotlin (dan sebaliknya).
            .addConverterFactory(GsonConverterFactory.create())
            .build()

        // Membuat implementasi konkret dari ApiService interface yang telah kita definisikan.
        apiService = retrofit.create(ApiService::class.java)
    }

    // Fungsi ini akan dipanggil oleh ViewModel untuk memulai pengambilan data user.
    fun fetchUsers() {
        // Saat mulai mengambil data, set status loading menjadi true.
        _isLoading.value = true

        // TODO 10: LAKUKAN PEMANGGILAN API SECARA ASYNCHRONOUS
        // `enqueue` adalah metode Retrofit untuk menjalankan permintaan secara asynchronous (di background).
        // Ini tidak akan memblokir thread utama, sehingga UI tetap responsif.
        apiService.getUsers().enqueue(object : Callback<List<User>> {
            // `onResponse` dipanggil jika server memberikan respons (baik berhasil maupun error kode seperti 404).
            override fun onResponse(call: Call<List<User>>, response: Response<List<User>>) {
                // Setelah mendapatkan respons, set status loading menjadi false.
                _isLoading.value = false

                // `isSuccessful` bernilai true jika kode HTTP adalah 2xx (misal: 200 OK).
                if (response.isSuccessful) {
                    // Jika berhasil, ambil body dari respons (yang berisi daftar user) dan simpan ke `_users`.
                    // Perubahan nilai di `_users` akan otomatis memberi tahu UI yang sedang mengamati.
                    _users.value = response.body()
                } else {
                    // Jika server merespons dengan error (misal 404 Not Found), tampilkan pesan error.
                    _errorMessage.value = "Error: ${response.code()} ${response.message()}"
                }
            }

            // `onFailure` dipanggil jika terjadi kesalahan jaringan yang parah (misal: tidak ada koneksi internet).
            override fun onFailure(call: Call<List<User>>, t: Throwable) {
                _isLoading.value = false
                // Tampilkan pesan error dari exception yang terjadi.
                _errorMessage.value = "Failure: ${t.message}"
            }
        })
    }
}
```

---

## 5. Membuat ViewModel (`UserViewModel.kt`)

ViewModel adalah jembatan antara Repository (sumber data) dan Activity (UI). Ia menyimpan data yang diperlukan UI dan bertahan dari perubahan konfigurasi.

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
// `AndroidViewModel` adalah subclass dari ViewModel yang menerima `Application` sebagai context.
// Ini berguna jika ViewModel membutuhkan context, misalnya untuk membuat Repository.
class UserViewModel(application: Application) : AndroidViewModel(application) {

    // Membuat instance dari Repository. ViewModel berinteraksi dengan data melalui Repository.
    private val repository = UserRepository(application)

    // TODO 12: EKSPOR LIVEADATA DARI REPOSITORY KE UI
    // ViewModel hanya perlu mengekspos LiveData dari Repository ke UI.
    // UI tidak perlu tahu dari mana data berasal, cukup mengamati LiveData di sini.
    val users: LiveData<List<User>> = repository.users
    val isLoading: LiveData<Boolean> = repository.isLoading
    val errorMessage: LiveData<String> = repository.errorMessage

    // `init` blok akan dijalankan saat pertama kali instance UserViewModel dibuat.
    init {
        // Saat ViewModel dibuat, langsung panggil fungsi untuk mengambil data user.
        fetchUsers()
    }

    // Fungsi private untuk memanggil repository. Kita menggunakan `viewModelScope`.
    private fun fetchUsers() {
        // TODO 13: GUNAKAN COROUTINES UNTUK MENJALANKAN FUNGSI REPOSITORY
        // `viewModelScope` adalah scope coroutine yang terikat dengan lifecycle ViewModel.
        // Jika ViewModel dihancurkan, semua coroutine yang berjalan di dalamnya akan otomatis dibatalkan.
        // Ini mencegah memory leak dan pekerjaan yang tidak perlu.
        viewModelScope.launch {
            repository.fetchUsers()
        }
    }
}
```

---

## 6. Membuat Layout XML

### Layout untuk satu item (`item_user.xml`)

```xml
<!-- res/layout/item_user.xml -->
<?xml version="1.0" encoding="utf-8"?>
<!-- TODO 14: GUNAKAN CARDVIEW UNTUK SETIAP ITEM -->
<!-- CardView adalah container yang memberikan tampilan kartu dengan bayangan dan sudut melengkung. -->
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

        <!-- TextView untuk menampilkan nama user -->
        <TextView
            android:id="@+id/tvName"
            android:layout_width="match_parent"
            android:layout_height="wrap_content"
            android:textSize="18sp"
            android:textStyle="bold"
            tools:text="Leanne Graham" /> <!-- `tools:text` hanya untuk preview di Android Studio -->

        <!-- TextView untuk menampilkan username -->
        <TextView
            android:id="@+id/tvUsername"
            android:layout_width="match_parent"
            android:layout_height="wrap_content"
            android:layout_marginTop="4dp"
            android:textSize="14sp"
            android:textStyle="italic"
            tools:text="@Bret" />

        <!-- TextView untuk menampilkan email -->
        <TextView
            android:id="@+id/tvEmail"
            android:layout_width="match_parent"
            android:layout_height="wrap_content"
            android:layout_marginTop="4dp"
            android:textSize="14sp"
            tools:text="Sincere@april.biz" />

        <!-- ... TextView lainnya untuk phone, website, address, company ... -->
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

### Layout utama Activity (`activity_main.xml`)

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
    <!-- RecyclerView adalah tempat daftar user akan ditampilkan. -->
    <androidx.recyclerview.widget.RecyclerView
        android:id="@+id/recyclerView"
        android:layout_width="0dp"
        android:layout_height="0dp"
        android:padding="8dp"
        app:layout_constraintBottom_toBottomOf="parent"
        app:layout_constraintEnd_toEndOf="parent"
        app:layout_constraintStart_toStartOf="parent"
        app:layout_constraintTop_toTopOf="parent" />

    <!-- ProgressBar adalah indikator loading yang akan muncul saat data sedang diambil. -->
    <ProgressBar
        android:id="@+id/progressBar"
        android:layout_width="wrap_content"
        android:layout_height="wrap_content"
        android:visibility="gone" <!-- Awalnya disembunyikan -->
        app:layout_constraintBottom_toBottomOf="parent"
        app:layout_constraintEnd_toEndOf="parent"
        app:layout_constraintStart_toStartOf="parent"
        app:layout_constraintTop_toTopOf="parent" />

    <!-- TextView untuk menampilkan pesan error jika terjadi kegagalan. -->
    <TextView
        android:id="@+id/tvErrorMessage"
        android:layout_width="wrap_content"
        android:layout_height="wrap_content"
        android:padding="16dp"
        android:textColor="@android:color/holo_red_dark"
        android:textSize="16sp"
        android:visibility="gone" <!-- Awalnya disembunyikan -->
        app:layout_constraintBottom_toBottomOf="parent"
        app:layout_constraintEnd_toEndOf="parent"
        app:layout_constraintStart_toStartOf="parent"
        app:layout_constraintTop_toTopOf="parent"
        tools:text="Error message" />

</androidx.constraintlayout.widget.ConstraintLayout>
```

---

## 7. Membuat Adapter untuk RecyclerView (`UserAdapter.kt`)

Adapter adalah "otak" dari RecyclerView. Ia bertugas membuat tampilan untuk setiap item dan mengisi data ke dalamnya.

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
// Adapter menerima daftar user sebagai parameter konstruktor.
class UserAdapter(private var userList: List<User>) : RecyclerView.Adapter<UserAdapter.UserViewHolder>() {

    // TODO 17: BUAT VIEWHOLDER
    // ViewHolder adalah kelas yang menyimpan referensi ke View-view (TextView, dll.)
    // yang ada di layout untuk satu item (item_user.xml).
    // Ini adalah optimasi performa penting untuk RecyclerView.
    class UserViewHolder(itemView: View) : RecyclerView.ViewHolder(itemView) {
        // Menghubungkan variabel dengan ID TextView di layout XML.
        val tvName: TextView = itemView.findViewById(R.id.tvName)
        val tvUsername: TextView = itemView.findViewById(R.id.tvUsername)
        val tvEmail: TextView = itemView.findViewById(R.id.tvEmail)
        val tvPhone: TextView = itemView.findViewById(R.id.tvPhone)
        val tvWebsite: TextView = itemView.findViewById(R.id.tvWebsite)
        val tvAddress: TextView = itemView.findViewById(R.id.tvAddress)
        val tvCompany: TextView = itemView.findViewById(R.id.tvCompany)
    }

    // TODO 18: IMPLEMENTASIKAN onCreateVIEWHOLDER
    // Fungsi ini dipanggil oleh RecyclerView saat ia membutuhkan ViewHolder baru.
    // Tugasnya adalah "mengembangkan" (inflate) layout XML menjadi objek View.
    override fun onCreateViewHolder(parent: ViewGroup, viewType: Int): UserViewHolder {
        // LayoutInflater adalah kelas yang bisa membuat View dari file XML layout.
        val view = LayoutInflater.from(parent.context).inflate(R.layout.item_user, parent, false)
        return UserViewHolder(view)
    }

    // TODO 19: IMPLEMENTASIKAN onBINDVIEWHOLDER
    // Fungsi ini dipanggil untuk menghubungkan data dengan View.
    // Ia akan dipanggil untuk setiap item yang terlihat di layar.
    override fun onBindViewHolder(holder: UserViewHolder, position: Int) {
        // Ambil objek User berdasarkan posisi di dalam list.
        val user = userList[position]

        // Set data dari objek User ke TextView yang ada di ViewHolder.
        holder.tvName.text = user.name
        holder.tvUsername.text = "@${user.username}"
        holder.tvEmail.text = user.email
        holder.tvPhone.text = user.phone
        holder.tvWebsite.text = user.website

        // Gabungkan beberapa field dari objek Address untuk ditampilkan.
        val address = "${user.userAddress.street}, ${user.userAddress.suite}, ${user.userAddress.city}, ${user.userAddress.zipcode}"
        holder.tvAddress.text = address

        holder.tvCompany.text = user.userCompany.companyName
    }

    // TODO 20: IMPLEMENTASIKAN getITEMCOUNT
    // Fungsi ini harus memberi tahu RecyclerView berapa total item yang ada di dalam dataset.
    override fun getItemCount(): Int {
        return userList.size
    }

    // TODO 21: BUAT FUNGSI UNTUK MEMPERBARUI DATA
    // Fungsi ini akan kita panggil dari Activity untuk memberikan data baru ke Adapter.
    fun updateUserList(newUserList: List<User>) {
        userList = newUserList
        // `notifyDataSetChanged()` memberi tahu RecyclerView bahwa seluruh data telah berubah
        // dan ia harus menampilkan ulang (redraw) semua item yang terlihat.
        notifyDataSetChanged()
    }
}
```

---

## 8. Menghubungkan Semua Komponen di `MainActivity.kt`

Activity adalah bagian yang mengatur tampilan (UI) dan menangani interaksi pengguna. Di sini kita akan menghubungkan RecyclerView, Adapter, dan ViewModel.

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
    // `by viewModels()` adalah properti delegasi dari KTX yang memudahkan kita mendapatkan instance ViewModel.
    // Android akan secara otomatis membuat atau menyediakan ViewModel yang terhubung dengan Activity ini.
    private val userViewModel: UserViewModel by viewModels()

    // Deklarasi variabel untuk komponen UI.
    private lateinit var userAdapter: UserAdapter
    private lateinit var recyclerView: RecyclerView
    private lateinit var progressBar: ProgressBar
    private lateinit var tvErrorMessage: TextView

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        setContentView(R.layout.activity_main)

        // Inisialisasi komponen UI dengan menghubungkannya ke ID di layout XML.
        recyclerView = findViewById(R.id.recyclerView)
        progressBar = findViewById(R.id.progressBar)
        tvErrorMessage = findViewById(R.id.tvErrorMessage)

        // Panggil fungsi untuk menyiapkan RecyclerView.
        setupRecyclerView()

        // Panggil fungsi untuk mulai mengamati perubahan data dari ViewModel.
        observeViewModel()
    }

    // Fungsi untuk mengatur RecyclerView.
    private fun setupRecyclerView() {
        // Buat instance dari Adapter dengan data awal yang kosong.
        userAdapter = UserAdapter(emptyList())
        // `LinearLayoutManager` adalah manajer tata letak yang menampilkan item dalam daftar vertikal atau horizontal.
        recyclerView.layoutManager = LinearLayoutManager(this)
        // Set adapter untuk RecyclerView.
        recyclerView.adapter = userAdapter
    }

    // Fungsi untuk mengamati LiveData dari ViewModel.
    private fun observeViewModel() {
        // TODO 23: AMATI PERUBAHAN DATA USER
        // `observe` adalah metode utama LiveData. Ia membutuhkan `LifecycleOwner` (this, yaitu Activity)
        // dan sebuah blok kode yang akan dijalankan setiap kali data berubah.
        userViewModel.users.observe(this) { users ->
            // `it` adalah nama default untuk parameter lambda, dalam hal ini adalah `users`.
            if (users.isNotEmpty()) {
                // Jika daftar user tidak kosong, perbarui data di Adapter.
                userAdapter.updateUserList(users)
                // Tampilkan RecyclerView dan sembunyikan pesan error.
                recyclerView.visibility = View.VISIBLE
                tvErrorMessage.visibility = View.GONE
            }
        }

        // TODO 24: AMATI STATUS LOADING
        userViewModel.isLoading.observe(this) { isLoading ->
            // Jika sedang loading, tampilkan ProgressBar.
            progressBar.visibility = if (isLoading) View.VISIBLE else View.GONE
            if (isLoading) {
                // Saat loading, sembunyikan RecyclerView dan pesan error.
                recyclerView.visibility = View.GONE
                tvErrorMessage.visibility = View.GONE
            }
        }

        // TODO 25: AMATI PESAN ERROR
        userViewModel.errorMessage.observe(this) { errorMessage ->
            if (errorMessage.isNotEmpty()) {
                // Jika ada pesan error, tampilkan TextView-nya.
                tvErrorMessage.text = errorMessage
                tvErrorMessage.visibility = View.VISIBLE
                // Sembunyikan RecyclerView.
                recyclerView.visibility = View.GONE
            }
        }
    }
}
```

