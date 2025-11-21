

### **Modul Praktikum Android: Aplikasi Prakiraan Cuaca Sederhana**

**Tujuan Pembelajaran:**
Setelah menyelesaikan modul ini, mahasiswa diharapkan mampu:
1.  Membuat proyek Android baru di Android Studio.
2.  Mengimplementasikan arsitektur MVVM (Model-View-ViewModel) yang merupakan best practice dalam pengembangan Android modern.
3.  Menggunakan library Retrofit untuk melakukan permintaan jaringan (network request) ke REST API.
4.  Melakukan parsing data JSON menggunakan library Gson.
5.  Menampilkan data dalam bentuk daftar (list) menggunakan `RecyclerView`.
6.  Menerapkan Coroutines untuk operasi asinkron agar UI tidak hang.
7.  Menambahkan fitur sederhana (filter) dan styling agar tampilan aplikasi menarik.

---

### **Langkah 1: Persiapan Awal dan Pembuatan Proyek**

**Penjelasan:**
Langkah pertama adalah menyiapkan lingkungan kerja. Kita akan membuat proyek Android baru dari awal dengan template yang paling dasar untuk memudahkan pemahaman.

**Yang Dilakukan:**
1.  Buka Android Studio.
2.  Pilih **File > New > New Project...**.
3.  Pilih template **Empty Views Activity** dan klik **Next**.
    *   *Alasan:* Template ini menyediakan file Activity dan layout XML kosong, memungkinkan kita untuk membangun semuanya dari dasar dan memahami setiap komponennya.
4.  Konfigurasi proyek Anda:
    *   **Name:** `CuacaApp` (atau nama yang Anda sukai)
    *   **Package name:** `com.example.cuacaapp` (biasanya sudah terisi otomatis)
    *   **Save location:** Pilih folder untuk menyimpan proyek.
    *   **Language:** Pilih **Kotlin**.
    *   **Minimum SDK:** Pilih API 24: Android 7.0 (Nougat) atau yang lebih tinggi. Ini adalah standar yang cukup aman saat ini.
5.  Klik **Finish**. Android Studio akan menyiapkan proyek untuk Anda.

---

### **Langkah 2: Menambahkan Dependensi yang Diperlukan**

**Penjelasan:**
Untuk berkomunikasi dengan API, mengelola data, dan menyajikannya di UI, kita membutuhkan bantuan library pihak ketiga. Dependensi adalah "paket-paket" kode siap pakai yang kita tambahkan ke proyek. Kita akan menambahkan dependensi untuk:
*   **Retrofit:** Library standar industri untuk melakukan permintaan HTTP ke API.
*   **Gson Converter:** Library yang membantu Retrofit secara otomatis mengubah respons dari server (yang berformat JSON) menjadi objek Kotlin yang bisa kita gunakan.
*   **ViewModel & LiveData:** Komponen dari Android Jetpack untuk mengimplementasikan arsitektur MVVM. `ViewModel` menyimpan logika UI dan data, serta survive dari perubahan konfigurasi (seperti rotasi layar). `LiveData` adalah kelas pemegang data yang dapat diamati (observable), sehingga UI bisa otomatis update ketika data berubah.
*   **Coroutines:** Untuk menjalankan operasi jaringan di luar thread utama (main thread) agar aplikasi tidak lag atau "Application Not Responding" (ANR).

**Yang Dilakukan:**
1.  Buka file `build.gradle.kts` (Module :app).
2.  Di dalam blok `dependencies { ... }`, tambahkan baris-baris berikut:

    ```kotlin
    // Retrofit untuk networking
    implementation("com.squareup.retrofit2:retrofit:2.9.0")
    // Gson Converter untuk parsing JSON
    implementation("com.squareup.retrofit2:converter-gson:2.9.0")

    // ViewModel dan LiveData untuk arsitektur MVVM
    implementation("androidx.lifecycle:lifecycle-viewmodel-ktx:2.7.0")
    implementation("androidx.lifecycle:lifecycle-livedata-ktx:2.7.0")
    implementation("androidx.activity:activity-ktx:1.9.0") // Untuk by viewModels()

    // Coroutines untuk operasi asinkron
    implementation("org.jetbrains.kotlinx:kotlinx-coroutines-core:1.7.3")
    implementation("org.jetbrains.kotlinx:kotlinx-coroutines-android:1.7.3")
    ```
3.  Klik **Sync Now** di bagian atas layar untuk mengunduh dan mengintegrasikan library-library tersebut ke proyek Anda.

---

### **Langkah 3: Mengatur Izin Akses Internet**

**Penjelasan:**
Aplikasi kita perlu mengakses internet untuk mengambil data dari API. Secara default, aplikasi Android tidak diizinkan untuk melakukan ini. Kita harus secara eksplisit meminta izin dalam file manifes.

**Yang Dilakukan:**
1.  Buka file `app/src/main/AndroidManifest.xml`.
2.  Tepat sebelum tag `<application>`, tambahkan baris berikut:

    ```xml
    <uses-permission android:name="android.permission.INTERNET" />
    ```
3.  File `AndroidManifest.xml` Anda akan terlihat seperti ini:

    ```xml
    <?xml version="1.0" encoding="utf-8"?>
    <manifest xmlns:android="http://schemas.android.com/apk/res/android"
        xmlns:tools="http://schemas.android.com/tools">

        <uses-permission android:name="android.permission.INTERNET" />

        <application
            ...>
            ...
        </application>
    </manifest>
    ```

---

### **Langkah 4: Membuat Model Data (Model Layer)**

**Penjelasan:**
"Model" adalah representasi dari data yang kita terima. Kita perlu membuat class Kotlin yang strukturnya sesuai dengan format JSON dari API. Mari kita lihat dulu struktur JSON dari URL yang diberikan:
`https://api.open-meteo.com/v1/forecast?latitude=-6.2&longitude=106.8&hourly=temperature_2m`

Responsnya kira-kira seperti ini (disingkat):
```json
{
  "latitude": -6.2,
  "longitude": 106.8,
  "hourly": {
    "time": ["2023-10-27T00:00", "2023-10-27T01:00", ...],
    "temperature_2m": [25.1, 24.9, ...]
  }
}
```
Kita membutuhkan class yang bisa menampung struktur ini. Karena nama field di JSON (`temperature_2m`) tidak mengikuti konvensi penamaan camelCase Kotlin, kita akan menggunakan anotasi `@SerializedName`.

**Yang Dilakukan:**
1.  Buat package baru untuk model. Klik kanan pada package utama (`com.example.cuacaapp`) > **New > Package**. Beri nama `model`.
2.  Di dalam package `model`, buat file Kotlin baru. Klik kanan package `model` > **New > Kotlin Class/File**. Beri nama `WeatherResponse`.
3.  Buat class-class data seperti berikut:

    ```kotlin
    // File: model/WeatherResponse.kt
    package com.example.cuacaapp.model

    import com.google.gson.annotations.SerializedName

    // Class ini mewakili seluruh respons JSON dari API
    data class WeatherResponse(
        @SerializedName("hourly")
        val hourly: Hourly
    )

    // Class ini mewakili objek "hourly" di dalam JSON
    data class Hourly(
        @SerializedName("time")
        val time: List<String>,

        @SerializedName("temperature_2m")
        val temperature2m: List<Double>
    )

    // Class ini adalah model yang disederhanakan untuk satu item data cuaca
    // Ini akan memudahkan saat menampilkan data di RecyclerView
    data class WeatherItem(
        val time: String,
        val temperature: String
    )
    ```
*   **Penjelasan `@SerializedName`:** Anotasi ini memberi tahu library Gson bahwa field `temperature2m` di class Kotlin kita bersesuaian dengan field `temperature_2m` di JSON.
*   **Penjelasan `WeatherItem`:** Class ini kita buat untuk kemudahan. Daripada mengolah dua list terpisah (`time` dan `temperature2m`), kita akan menggabungkannya menjadi satu list `WeatherItem` yang lebih mudah dikelola oleh adapter `RecyclerView`.

---

### **Langkah 5: Membuat Service API (Networking Layer)**

**Penjelasan:**
Kita akan menggunakan Retrofit untuk mendefinisikan "bagaimana cara" berkomunikasi dengan API. Kita membuat sebuah interface yang mendefinisikan endpoint yang akan kita akses.

**Yang Dilakukan:**
1.  Buat package baru bernama `network`.
2.  Di dalam package `network`, buat file Kotlin baru bernama `ApiService`.
3.  Tulis kode berikut:

    ```kotlin
    // File: network/ApiService.kt
    package com.example.cuacaapp.network

    import com.example.cuacaapp.model.WeatherResponse
    import retrofit2.Response
    import retrofit2.http.GET

    interface ApiService {
        // Anotasi GET menandakan bahwa ini adalah permintaan HTTP GET
        // URL di sini adalah endpoint yang akan ditambahkan ke base URL
        @GET("v1/forecast?latitude=-6.2&longitude=106.8&hourly=temperature_2m")
        suspend fun getWeatherData(): Response<WeatherResponse>
    }
    ```
*   **Penjelasan:**
    *   `@GET(...)`: Mendefinisikan metode HTTP dan endpoint.
    *   `suspend fun`: Fungsi ini ditandai sebagai `suspend` karena akan dipanggil dari dalam sebuah coroutine. Ini adalah cara modern untuk menangani operasi asinkron.
    *   `Response<WeatherResponse>`: Retrofit akan mencoba memparse respons JSON menjadi objek `WeatherResponse`. Menggunakan `Response` memungkinkan kita untuk memeriksa kode status HTTP (misalnya, 200 OK, 404 Not Found).

---

### **Langkah 6: Membuat Retrofit Client**

**Penjelasan:**
Kita需要一个对象来配置和创建实例 Retrofit。这个对象将作为我们网络请求的单一入口点（单例模式）。

**Yang Dilakukan:**
1.  Di dalam package `network`, buat file Kotlin baru bernama `RetrofitClient`.
2.  Tulis kode berikut:

    ```kotlin
    // File: network/RetrofitClient.kt
    package com.example.cuacaapp.network

    import retrofit2.Retrofit
    import retrofit2.converter.gson.GsonConverterFactory

    object RetrofitClient {
        // Base URL untuk API Open-Meteo
        private const val BASE_URL = "https://api.open-meteo.com/"

        // Membuat instance Retrofit menggunakan lazy initialization
        // Ini berarti instance hanya akan dibuat saat pertama kali dibutuhkan
        val instance: ApiService by lazy {
            val retrofit = Retrofit.Builder()
                .baseUrl(BASE_URL)
                .addConverterFactory(GsonConverterFactory.create()) // Menambahkan converter untuk JSON
                .build()

            retrofit.create(ApiService::class.java)
        }
    }
    ```
*   **Penjelasan:**
    *   `object`: Membuat singleton di Kotlin.
    *   `lazy`: Memastikan `Retrofit` hanya dibuat satu kali saat `instance` pertama kali diakses, yang efisien.
    *   `baseUrl`: URL utama dari API. Endpoint yang kita definisikan di `ApiService` akan ditambahkan ke belakang URL ini.
    *   `addConverterFactory(...)`: Memberi tahu Retrofit untuk menggunakan Gson untuk mengkonversi JSON.

---

### **Langkah 7: Merancang Tampilan Pengguna (View Layer - XML)**

**Penjelasan:**
Sekarang kita akan mendesain tampilan aplikasi. Kita membutuhkan dua file layout:
1.  `activity_main.xml`: Tampilan utama yang akan menampilkan `RecyclerView` dan indikator loading.
2.  `item_weather.xml`: Layout untuk setiap baris/item di dalam `RecyclerView`.

**Yang Dilakukan:**
1.  Buka file `res/layout/activity_main.xml`. Ganti isinya dengan kode berikut:

    ```xml
    <?xml version="1.0" encoding="utf-8"?>
    <androidx.constraintlayout.widget.ConstraintLayout xmlns:android="http://schemas.android.com/apk/res/android"
        xmlns:app="http://schemas.android.com/apk/res-auto"
        xmlns:tools="http://schemas.android.com/tools"
        android:layout_width="match_parent"
        android:layout_height="match_parent"
        android:padding="16dp"
        tools:context=".MainActivity">

        <ProgressBar
            android:id="@+id/progress_bar"
            android:layout_width="wrap_content"
            android:layout_height="wrap_content"
            app:layout_constraintTop_toTopOf="parent"
            app:layout_constraintBottom_toBottomOf="parent"
            app:layout_constraintStart_toStartOf="parent"
            app:layout_constraintEnd_toEndOf="parent"
            android:visibility="gone"
            tools:visibility="visible"/>

        <androidx.recyclerview.widget.RecyclerView
            android:id="@+id/recycler_view_weather"
            android:layout_width="0dp"
            android:layout_height="0dp"
            app:layout_constraintTop_toTopOf="parent"
            app:layout_constraintBottom_toBottomOf="parent"
            app:layout_constraintStart_toStartOf="parent"
            app:layout_constraintEnd_toEndOf="parent"
            tools:listitem="@layout/item_weather"/>

        <TextView
            android:id="@+id/text_view_error"
            android:layout_width="wrap_content"
            android:layout_height="wrap_content"
            android:text="Terjadi kesalahan saat memuat data."
            android:textSize="16sp"
            android:visibility="gone"
            app:layout_constraintTop_toTopOf="parent"
            app:layout_constraintBottom_toBottomOf="parent"
            app:layout_constraintStart_toStartOf="parent"
            app:layout_constraintEnd_toEndOf="parent" />

    </androidx.constraintlayout.widget.ConstraintLayout>
    ```

2.  Buat file layout baru. Klik kanan folder `res/layout` > **New > Layout Resource File**. Beri nama `item_weather.xml` dan klik **OK**.
3.  Isi file `item_weather.xml` dengan kode berikut:

    ```xml
    <?xml version="1.0" encoding="utf-8"?>
    <androidx.cardview.widget.CardView xmlns:android="http://schemas.android.com/apk/res/android"
        xmlns:app="http://schemas.android.com/apk/res-auto"
        xmlns:tools="http://schemas.android.com/tools"
        android:layout_width="match_parent"
        android:layout_height="wrap_content"
        android:layout_marginBottom="8dp"
        app:cardCornerRadius="8dp"
        app:cardElevation="4dp">

        <LinearLayout
            android:layout_width="match_parent"
            android:layout_height="wrap_content"
            android:orientation="horizontal"
            android:padding="16dp">

            <TextView
                android:id="@+id/text_view_time"
                android:layout_width="0dp"
                android:layout_height="wrap_content"
                android:layout_weight="1"
                android:textSize="16sp"
                android:textStyle="bold"
                tools:text="Jumat, 27 Okt 12:00" />

            <TextView
                android:id="@+id/text_view_temperature"
                android:layout_width="wrap_content"
                android:layout_height="wrap_content"
                android:textSize="18sp"
                android:textStyle="italic"
                tools:text="25.1 °C" />

        </LinearLayout>
    </androidx.cardview.widget.CardView>
    ```
*   **Penjelasan:**
    *   `CardView` digunakan untuk membuat setiap item terlihat seperti "kartu" dengan sudut melengkung dan bayangan, membuat tampilan lebih menarik.
    *   `tools:text` adalah atribut khusus untuk menampilkan teks contoh di Android Studio Preview tanpa memengaruhi aplikasi saat dijalankan.

---

### **Langkah 8: Membuat RecyclerView Adapter**

**Penjelasan:**
`Adapter` adalah jembatan yang menghubungkan data (list `WeatherItem`) dengan `RecyclerView`. Tugasnya adalah membuat `ViewHolder` untuk setiap item dan mengisi data ke dalam tampilan item tersebut.

**Yang Dilakukan:**
1.  Buat package baru bernama `ui`.
2.  Di dalam `ui`, buat package baru bernama `adapter`.
3.  Di dalam package `adapter`, buat file Kotlin baru bernama `WeatherAdapter`.
4.  Tulis kode berikut:

    ```kotlin
    // File: ui/adapter/WeatherAdapter.kt
    package com.example.cuacaapp.ui.adapter

    import android.view.LayoutInflater
    import android.view.View
    import android.view.ViewGroup
    import android.widget.TextView
    import androidx.recyclerview.widget.RecyclerView
    import com.example.cuacaapp.R
    import com.example.cuacaapp.model.WeatherItem

    class WeatherAdapter(private var weatherList: List<WeatherItem>) :
        RecyclerView.Adapter<WeatherAdapter.WeatherViewHolder>() {

        // ViewHolder: Menyimpan referensi ke view-view dalam satu item layout
        class WeatherViewHolder(itemView: View) : RecyclerView.ViewHolder(itemView) {
            val timeTextView: TextView = itemView.findViewById(R.id.text_view_time)
            val temperatureTextView: TextView = itemView.findViewById(R.id.text_view_temperature)
        }

        // Dipanggil saat RecyclerView butuh membuat ViewHolder baru
        override fun onCreateViewHolder(parent: ViewGroup, viewType: Int): WeatherViewHolder {
            val view = LayoutInflater.from(parent.context)
                .inflate(R.layout.item_weather, parent, false)
            return WeatherViewHolder(view)
        }

        // Dipanggil untuk menghubungkan data ke ViewHolder pada posisi tertentu
        override fun onBindViewHolder(holder: WeatherViewHolder, position: Int) {
            val currentItem = weatherList[position]
            holder.timeTextView.text = currentItem.time
            holder.temperatureTextView.text = currentItem.temperature
        }

        // Mengembalikan jumlah total item dalam list
        override fun getItemCount(): Int {
            return weatherList.size
        }

        // Fungsi untuk memperbarui data di adapter
        fun updateData(newWeatherList: List<WeatherItem>) {
            this.weatherList = newWeatherList
            notifyDataSetChanged() // Memberitahu RecyclerView bahwa data telah berubah
        }
    }
    ```

---

### **Langkah 9: Membuat ViewModel dan Repository**

**Penjelasan:**
Di sinilah logika bisnis aplikasi berada.
*   **Repository:** Bertanggung jawab sebagai *single source of truth* (sumber data tunggal). Ia mengambil data dari API (atau database/cache di aplikasi yang lebih kompleks) dan menyediakannya ke `ViewModel`.
*   **ViewModel:** Mengambil data dari `Repository`, memprosesnya (misalnya, mengubah format waktu), dan menyediakannya ke `Activity`/`Fragment` dalam bentuk `LiveData`. `ViewModel` tidak tahu apa-apa tentang UI (seperti `RecyclerView` atau `TextView`).

**Yang Dilakukan:**
1.  Buat package `repository`. Di dalamnya, buat file Kotlin `WeatherRepository.kt`.
2.  Buat package `ui` dan di dalamnya buat package `viewmodel`. Di dalamnya, buat file Kotlin `MainViewModel.kt`.

3.  Isi `WeatherRepository.kt`:

    ```kotlin
    // File: repository/WeatherRepository.kt
    package com.example.cuacaapp.repository

    import com.example.cuacaapp.model.WeatherItem
    import com.example.cuacaapp.network.ApiService
    import java.text.SimpleDateFormat
    import java.util.*

    class WeatherRepository(private val apiService: ApiService) {

        // Fungsi suspend untuk mengambil data dari API dan mengubahnya menjadi list WeatherItem
        suspend fun getWeatherItems(): List<WeatherItem> {
            val response = apiService.getWeatherData()
            if (response.isSuccessful && response.body() != null) {
                val hourlyData = response.body()!!.hourly
                val times = hourlyData.time
                val temperatures = hourlyData.temperature2m

                val weatherItems = mutableListOf<WeatherItem>()
                val inputFormat = SimpleDateFormat("yyyy-MM-dd'T'HH:mm", Locale.getDefault())
                val outputFormat = SimpleDateFormat("EEEE, dd MMM HH:mm", Locale("id", "ID")) // Format Indonesia

                for (i in times.indices) {
                    val dateTime = inputFormat.parse(times[i])
                    val formattedTime = dateTime?.let { outputFormat.format(it) } ?: times[i]
                    val formattedTemp = "${temperatures[i]} °C"
                    weatherItems.add(WeatherItem(formattedTime, formattedTemp))
                }
                return weatherItems
            } else {
                // Lempar exception jika gagal
                throw Exception("Failed to fetch weather data: ${response.code()}")
            }
        }
    }
    ```

4.  Isi `MainViewModel.kt`:

    ```kotlin
    // File: ui/viewmodel/MainViewModel.kt
    package com.example.cuacaapp.ui.viewmodel

    import androidx.lifecycle.LiveData
    import androidx.lifecycle.MutableLiveData
    import androidx.lifecycle.ViewModel
    import androidx.lifecycle.viewModelScope
    import com.example.cuacaapp.model.WeatherItem
    import com.example.cuacaapp.network.RetrofitClient
    import com.example.cuacaapp.repository.WeatherRepository
    import kotlinx.coroutines.launch

    class MainViewModel : ViewModel() {

        // Private MutableLiveData untuk menyimpan data secara internal
        private val _weatherData = MutableLiveData<List<WeatherItem>>()
        // Public LiveData yang read-only untuk diamati oleh UI
        val weatherData: LiveData<List<WeatherItem>> = _weatherData

        private val _isLoading = MutableLiveData<Boolean>()
        val isLoading: LiveData<Boolean> = _isLoading

        private val _errorMessage = MutableLiveData<String>()
        val errorMessage: LiveData<String> = _errorMessage

        // Inisialisasi Repository
        private val repository = WeatherRepository(RetrofitClient.instance)

        init {
            fetchWeatherData()
        }

        fun fetchWeatherData() {
            _isLoading.value = true
            _errorMessage.value = null

            // viewModelScope memastikan coroutine dibatalkan jika ViewModel dihancurkan
            viewModelScope.launch {
                try {
                    val result = repository.getWeatherItems()
                    _weatherData.postValue(result) // postValue untuk dipanggil dari background thread
                } catch (e: Exception) {
                    _errorMessage.postValue(e.message)
                } finally {
                    _isLoading.postValue(false)
                }
            }
        }
    }
    ```
*   **Penjelasan:**
    *   `viewModelScope.launch`: Menjalankan coroutine di scope ViewModel.
    *   `try-catch-finally`: Menangani keberhasilan, kegagalan, dan menyelesaikan state loading.
    *   `postValue`: Digunakan untuk mengubah nilai `LiveData` dari thread latar belakang.
    *   `_weatherData` (Mutable) vs `weatherData` (Immutable): Ini adalah pola yang baik untuk enkapsulasi. UI hanya bisa membaca data, tidak bisa mengubahnya langsung.

---

### **Langkah 10: Menghubungkan Semua di MainActivity**

**Penjelasan:**
`MainActivity` adalah bagian dari *View*. Tugasnya adalah mengamati `LiveData` dari `ViewModel` dan memperbarui UI (menampilkan data di `RecyclerView`, menampilkan `ProgressBar`, dll.) berdasarkan perubahan data tersebut.

**Yang Dilakukan:**
1.  Buka file `MainActivity.kt`.
2.  Ganti seluruh isinya dengan kode berikut:

    ```kotlin
    // File: MainActivity.kt
    package com.example.cuacaapp

    import android.os.Bundle
    import android.view.View
    import androidx.activity.viewModels
    import androidx.appcompat.app.AppCompatActivity
    import androidx.recyclerview.widget.LinearLayoutManager
    import com.example.cuacaapp.ui.adapter.WeatherAdapter
    import com.example.cuacaapp.databinding.ActivityMainBinding
    import com.example.cuacaapp.ui.viewmodel.MainViewModel

    class MainActivity : AppCompatActivity() {

        // Menggunakan View Binding untuk akses view yang lebih mudah dan aman
        private lateinit var binding: ActivityMainBinding

        // Mendapatkan instance ViewModel menggunakan delegate by viewModels()
        private val viewModel: MainViewModel by viewModels()

        private lateinit var weatherAdapter: WeatherAdapter

        override fun onCreate(savedInstanceState: Bundle?) {
            super.onCreate(savedInstanceState)
            // Inisialisasi View Binding
            binding = ActivityMainBinding.inflate(layoutInflater)
            setContentView(binding.root)

            setupRecyclerView()
            observeViewModel()
        }

        private fun setupRecyclerView() {
            weatherAdapter = WeatherAdapter(emptyList())
            binding.recyclerViewWeather.apply {
                adapter = weatherAdapter
                layoutManager = LinearLayoutManager(this@MainActivity)
            }
        }

        private fun observeViewModel() {
            // Mengamati perubahan data cuaca
            viewModel.weatherData.observe(this) { weatherItems ->
                // Sembunyikan loading dan error jika ada data
                binding.progressBar.visibility = View.GONE
                binding.textViewError.visibility = View.GONE
                // Update data di adapter
                weatherAdapter.updateData(weatherItems)
            }

            // Mengamati status loading
            viewModel.isLoading.observe(this) { isLoading ->
                binding.progressBar.visibility = if (isLoading) View.VISIBLE else View.GONE
            }

            // Mengamati pesan error
            viewModel.errorMessage.observe(this) { errorMessage ->
                if (errorMessage != null) {
                    binding.textViewError.visibility = View.VISIBLE
                    binding.textViewError.text = errorMessage
                    binding.recyclerViewWeather.visibility = View.GONE
                } else {
                    binding.textViewError.visibility = View.GONE
                    binding.recyclerViewWeather.visibility = View.VISIBLE
                }
            }
        }
    }
    ```
3.  Buka kembali `build.gradle.kts (Module :app)` dan aktifkan View Binding di dalam blok `android { ... }`:
    ```kotlin
    android {
        // ...
        buildFeatures {
            viewBinding = true
        }
    }
    ```
4.  Klik **Sync Now**.

---

### **Langkah 11: Menjalankan Aplikasi**

**Penjelasan:**
Sekarang semua komponen telah terhubung. Saatnya menjalankan aplikasi dan melihat hasilnya.

**Yang Dilakukan:**
1.  Pastikan perangkat Android atau emulator sudah terhubung.
2.  Klik tombol **Run 'app'** (ikon segitiga hijau) di Android Studio.
3.  Aplikasi akan terbuka. Pertama, Anda akan melihat `ProgressBar` sebentar. Setelah data berhasil diambil dari API, `ProgressBar` akan menghilang dan `RecyclerView` akan menampilkan daftar waktu dan suhu per jam.

---

### **Langkah 12 (Tambahan): Menambahkan Fitur Filter dan Styling Tambahan**

**Penjelasan:**
Untuk membuat aplikasi lebih interaktif, kita akan menambahkan filter untuk menampilkan data hari ini, besok, atau semua data. Kita juga akan sedikit mempercantik tampilan.

**Yang Dilakukan:**
1.  **Modifikasi `activity_main.xml`:** Tambahkan `Spinner` untuk pilihan filter.

    ```xml
    <!-- Tambahkan Spinner di bagian atas ConstraintLayout -->
    <Spinner
        android:id="@+id/spinner_filter"
        android:layout_width="0dp"
        android:layout_height="wrap_content"
        android:layout_marginBottom="8dp"
        app:layout_constraintTop_toTopOf="parent"
        app:layout_constraintStart_toStartOf="parent"
        app:layout_constraintEnd_toEndOf="parent" />

    <!-- Ubah constraint RecyclerView agar di bawah Spinner -->
    <androidx.recyclerview.widget.RecyclerView
        android:id="@+id/recycler_view_weather"
        ...
        app:layout_constraintTop_toBottomOf="@id/spinner_filter"
        ... />
    ```

2.  **Buat resource string untuk pilihan Spinner.** Buka `res/values/strings.xml` dan tambahkan:
    ```xml
    <string-array name="filter_options">
        <item>Semua Data</item>
        <item>Hari Ini</item>
        <item>Besok</item>
    </string-array>
    ```

3.  **Modifikasi `MainViewModel.kt`:** Tambahkan logika untuk menyimpan data asli dan memfilternya.

    ```kotlin
    // Di dalam class MainViewModel
    private val originalWeatherData = mutableListOf<WeatherItem>()

    // ... di dalam fetchWeatherData, setelah mendapatkan result ...
    val result = repository.getWeatherItems()
    originalWeatherData.clear()
    originalWeatherData.addAll(result)
    _weatherData.postValue(originalWeatherData) // Tampilkan semua data awalnya

    // Tambahkan fungsi baru untuk filter
    fun filterData(filter: String) {
        val today = Calendar.getInstance().get(Calendar.DAY_OF_YEAR)
        val tomorrow = today + 1

        val filteredList = when (filter) {
            "Hari Ini" -> originalWeatherData.filter {
                Calendar.getInstance().apply {
                    time = SimpleDateFormat("EEEE, dd MMM HH:mm", Locale("id", "ID")).parse(it.time)
                }.get(Calendar.DAY_OF_YEAR) == today
            }
            "Besok" -> originalWeatherData.filter {
                Calendar.getInstance().apply {
                    time = SimpleDateFormat("EEEE, dd MMM HH:mm", Locale("id", "ID")).parse(it.time)
                }.get(Calendar.DAY_OF_YEAR) == tomorrow
            }
            else -> originalWeatherData // "Semua Data"
        }
        _weatherData.postValue(filteredList)
    }
    ```

4.  **Modifikasi `MainActivity.kt`:** Atur `Spinner` dan hubungkan dengan `ViewModel`.

    ```kotlin
    // Di dalam onCreate, setelah setupRecyclerView()
    setupSpinner()

    // Tambahkan fungsi baru
    private fun setupSpinner() {
        val filterOptions = resources.getStringArray(R.array.filter_options)
        val spinnerAdapter = android.widget.ArrayAdapter(
            this,
            android.R.layout.simple_spinner_item,
            filterOptions
        )
        spinnerAdapter.setDropDownViewResource(android.R.layout.simple_spinner_dropdown_item)
        binding.spinnerFilter.adapter = spinnerAdapter

        binding.spinnerFilter.onItemSelectedListener = object : AdapterView.OnItemSelectedListener {
            override fun onItemSelected(parent: AdapterView<*>?, view: View?, position: Int, id: Long) {
                val selectedFilter = filterOptions[position]
                viewModel.filterData(selectedFilter)
            }
            override fun onNothingSelected(parent: AdapterView<*>?) {
                // Tidak melakukan apa-apa
            }
        }
    }
    ```

**Penjelasan Tambahan:**
*   Logika filter bekerja dengan membandingkan *hari* (day of year) dari setiap item data dengan hari ini atau besok.
*   `originalWeatherData` berfungsi sebagai master copy, sehingga saat filter berubah, kita selalu memfilter dari sumber data yang lengkap.
*   `Spinner` adalah komponen UI standar Android untuk dropdown.

