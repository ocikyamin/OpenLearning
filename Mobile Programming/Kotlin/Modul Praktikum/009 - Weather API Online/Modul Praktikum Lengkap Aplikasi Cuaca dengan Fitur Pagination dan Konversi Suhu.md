### **Modul Praktikum: Aplikasi Cuaca dengan Fitur Pagination dan Konversi Suhu**

**Tujuan Pembelajaran:**
Setelah menyelesaikan modul ini, mahasiswa diharapkan mampu:
1.  Membangun aplikasi Android dengan arsitektur **MVVM (Model-View-ViewModel)** yang solid.
2.  Mengimplementasikan **Retrofit** dan **Gson** untuk konsumsi REST API.
3.  Menggunakan **Coroutines** dan **LiveData** untuk operasi asinkron dan manajemen siklus hidup UI yang reaktif.
4.  Merancang tampilan yang menarik dan modern dengan komponen **Material Design 3** (`MaterialToolbar`, `MaterialCardView`).
5.  Mengimplementasikan **pagination** (pemuatan data bertahap) untuk performa yang optimal.
6.  Menambahkan fitur interaktif seperti **konversi unit suhu (°C ↔ °F)** dan **penampilan ikon cuaca**.
7.  Menerapkan **View Binding** untuk akses UI yang aman dan efisien.

---

### **Langkah 1: Persiapan Proyek dan Dependensi**

**Penjelasan:**
Langkah ini adalah fondasi dari aplikasi kita. Kita akan membuat proyek baru dan menambahkan semua library pihak ketiga yang diperlukan sekaligus. Ini lebih efisien daripada menambahkannya satu per satu. Library-library ini mencakup networking (Retrofit), parsing JSON (Gson), arsitektur (ViewModel, LiveData), dan pemrosesan asinkron (Coroutines).

**Yang Dilakukan:**
1.  Buat proyek baru di Android Studio dengan template **Empty Views Activity**. Pilih **Kotlin** sebagai bahasa pemrograman.
2.  Buka file `build.gradle.kts` (Module :app) dan tambahkan dependensi berikut di dalam blok `dependencies`:

    ```kotlin
    // Networking
    implementation("com.squareup.retrofit2:retrofit:2.9.0")
    implementation("com.squareup.retrofit2:converter-gson:2.9.0")

    // Architecture Components (MVVM)
    implementation("androidx.lifecycle:lifecycle-viewmodel-ktx:2.7.0")
    implementation("androidx.lifecycle:lifecycle-livedata-ktx:2.7.0")
    implementation("androidx.activity:activity-ktx:1.9.0") // Untuk by viewModels()

    // Coroutines
    implementation("org.jetbrains.kotlinx:kotlinx-coroutines-core:1.7.3")
    implementation("org.jetbrains.kotlinx:kotlinx-coroutines-android:1.7.3")
    ```
3.  Di dalam blok `android` pada file yang sama, aktifkan **View Binding**:

    ```kotlin
    android {
        // ...
        buildFeatures {
            viewBinding = true
        }
    }
    ```
4.  Buka `AndroidManifest.xml` dan tambahkan izin internet sebelum tag `<application>`:

    ```xml
    <uses-permission android:name="android.permission.INTERNET" />
    ```
5.  Klik **Sync Now** untuk mengintegrasikan semua perubahan.

---

### **Langkah 2: Mendefinisikan Model Data dan Kontrak API**

**Penjelasan:**
Sebelum membangun logika, kita perlu mendefinisikan "strukturnya". Kita akan membuat class Kotlin yang merepresentasikan data dari API (Model) dan interface yang mendefinisikan cara kita meminta data tersebut (API Service). Kita akan meminta data `temperature_2m` dan `weathercode` (untuk ikon).

**Yang Dilakukan:**
1.  Buat package baru bernama `model`. Di dalamnya, buat file Kotlin `WeatherResponse.kt` dan tambahkan kode berikut:

    ```kotlin
    // File: model/WeatherResponse.kt
    package com.example.cuacaapp.model

    import com.google.gson.annotations.SerializedName

    data class WeatherResponse(
        @SerializedName("hourly")
        val hourly: Hourly
    )

    data class Hourly(
        @SerializedName("time")
        val time: List<String>,
        @SerializedName("temperature_2m")
        val temperature2m: List<Double>,
        @SerializedName("weathercode")
        val weathercode: List<Int>
    )

    // Model yang disederhanakan untuk setiap item di RecyclerView
    data class WeatherItem(
        val time: String,
        val temperature: String,
        val iconRes: Int // ID resource untuk ikon cuaca
    )
    ```

2.  Buat package `network`. Di dalamnya, buat file `ApiService.kt`:

    ```kotlin
    // File: network/ApiService.kt
    package com.example.cuacaapp.network

    import com.example.cuacaapp.model.WeatherResponse
    import retrofit2.Response
    import retrofit2.http.GET

    interface ApiService {
        @GET("v1/forecast?latitude=-6.2&longitude=106.8&hourly=temperature_2m,weathercode")
        suspend fun getWeatherData(): Response<WeatherResponse>
    }
    ```

3.  Di package `network` yang sama, buat file `RetrofitClient.kt`:

    ```kotlin
    // File: network/RetrofitClient.kt
    package com.example.cuacaapp.network

    import retrofit2.Retrofit
    import retrofit2.converter.gson.GsonConverterFactory

    object RetrofitClient {
        private const val BASE_URL = "https://api.open-meteo.com/"

        val instance: ApiService by lazy {
            val retrofit = Retrofit.Builder()
                .baseUrl(BASE_URL)
                .addConverterFactory(GsonConverterFactory.create())
                .build()
            retrofit.create(ApiService::class.java)
        }
    }
    ```

---

### **Langkah 3: Membuat Pemeta Ikon Cuaca**

**Penjelasan:**
API memberikan `weathercode` (angka). Kita perlu menerjemahkan angka ini menjadi gambar ikon yang bisa dimengerti pengguna. Kita akan membuat sebuah "mapper" untuk ini.

**Yang Dilakukan:**
1.  **Unduh Ikon:** Unduh set ikon cuaca (format `.xml` atau `.png`). Sumber yang bagus adalah [Weather Icons by Erik Flowers](https://github.com/erikflowers/weather-icons).
2.  **Tambahkan Ikon ke Proyek:** Salin file-file ikon ke folder `res/drawable` di proyek Anda.
3.  Buat package `utils`. Di dalamnya, buat object `WeatherIconMapper.kt`:

    ```kotlin
    // File: utils/WeatherIconMapper.kt
    package com.example.cuacaapp.utils

    import com.example.cuacaapp.R // Sesuaikan dengan package name Anda

    object WeatherIconMapper {
        fun getWeatherIcon(weathercode: Int): Int {
            return when (weathercode) {
                0 -> R.drawable.ic_clear_day // Ganti dengan nama file ikon Anda
                1, 2, 3 -> R.drawable.ic_partly_cloudy
                45, 48 -> R.drawable.ic_fog
                51, 53, 55, 56, 57 -> R.drawable.ic_drizzle
                61, 63, 65, 66, 67 -> R.drawable.ic_rain
                71, 73, 75, 77 -> R.drawable.ic_snow
                80, 81, 82 -> R.drawable.ic_showers
                85, 86 -> R.drawable.ic_snow
                95 -> R.drawable.ic_thunderstorm
                96, 99 -> R.drawable.ic_thunderstorm
                else -> R.drawable.ic_clear_day // Ikon default
            }
        }
    }
    ```
    *   **Penting:** Anda **harus** menyesuaikan `R.drawable.ic_...` dengan nama file ikon yang Anda tambahkan.

---

### **Langkah 4: Merancang Tampilan Pengguna (UI)**

**Penjelasan:**
Sekarang kita akan membuat antarmuka pengguna. Kita akan menggunakan `MaterialToolbar` untuk aksi global, `RecyclerView` untuk daftar, `MaterialCardView` untuk item yang menarik, dan sebuah tombol untuk pagination.

**Yang Dilakukan:**
1.  **Buat Menu Toolbar:** Klik kanan `res` > **New > Android Resource File**. Beri nama `menu_toolbar` dengan tipe `Menu`. Tambahkan kode ini:

    ```xml
    <!-- File: res/menu/menu_toolbar.xml -->
    <menu xmlns:android="http://schemas.android.com/apk/res/android"
        xmlns:app="http://schemas.android.com/apk/res-auto">
        <item
            android:id="@+id/action_toggle_unit"
            android:title="Ubah ke °F"
            app:showAsAction="ifRoom" />
    </menu>
    ```

2.  **Desain Layout Item:** Buka `res/layout/item_weather.xml` dan ganti isinya:

    ```xml
    <!-- File: res/layout/item_weather.xml -->
    <com.google.android.material.card.MaterialCardView xmlns:android="http://schemas.android.com/apk/res/android"
        xmlns:app="http://schemas.android.com/apk/res-auto"
        xmlns:tools="http://schemas.android.com/tools"
        android:layout_width="match_parent"
        android:layout_height="wrap_content"
        android:layout_marginHorizontal="8dp"
        android:layout_marginVertical="4dp"
        app:cardCornerRadius="12dp"
        app:cardElevation="4dp">

        <LinearLayout
            android:layout_width="match_parent"
            android:layout_height="wrap_content"
            android:gravity="center_vertical"
            android:orientation="horizontal"
            android:padding="16dp">

            <ImageView
                android:id="@+id/image_view_weather_icon"
                android:layout_width="48dp"
                android:layout_height="48dp"
                android:layout_marginEnd="16dp"
                tools:src="@drawable/ic_clear_day" />

            <LinearLayout
                android:layout_width="0dp"
                android:layout_height="wrap_content"
                android:layout_weight="1"
                android:orientation="vertical">

                <TextView
                    android:id="@+id/text_view_time"
                    android:layout_width="wrap_content"
                    android:layout_height="wrap_content"
                    android:textAppearance="?attr/textAppearanceBodyLarge"
                    android:textStyle="bold"
                    tools:text="Jumat, 27 Okt 12:00" />

                <TextView
                    android:id="@+id/text_view_temperature"
                    android:layout_width="wrap_content"
                    android:layout_height="wrap_content"
                    android:layout_marginTop="4dp"
                    android:textAppearance="?attr/textAppearanceBodyMedium"
                    tools:text="25.1 °C" />

            </LinearLayout>
        </LinearLayout>
    </com.google.android.material.card.MaterialCardView>
    ```

3.  **Desain Layout Utama:** Buka `res/layout/activity_main.xml` dan ganti isinya:

    ```xml
    <!-- File: res/layout/activity_main.xml -->
    <androidx.constraintlayout.widget.ConstraintLayout xmlns:android="http://schemas.android.com/apk/res/android"
        xmlns:app="http://schemas.android.com/apk/res-auto"
        xmlns:tools="http://schemas.android.com/tools"
        android:layout_width="match_parent"
        android:layout_height="match_parent"
        tools:context=".MainActivity">

        <com.google.android.material.appbar.AppBarLayout
            android:id="@+id/app_bar_layout"
            android:layout_width="match_parent"
            android:layout_height="wrap_content"
            app:layout_constraintTop_toTopOf="parent">

            <com.google.android.material.appbar.MaterialToolbar
                android:id="@+id/toolbar"
                android:layout_width="match_parent"
                android:layout_height="?attr/actionBarSize"
                app:title="Prakiraan Cuaca Jakarta" />

        </com.google.android.material.appbar.AppBarLayout>

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
            app:layout_constraintTop_toBottomOf="@id/app_bar_layout"
            app:layout_constraintBottom_toTopOf="@id/button_load_more"
            app:layout_constraintStart_toStartOf="parent"
            app:layout_constraintEnd_toEndOf="parent"
            tools:listitem="@layout/item_weather"/>

        <Button
            android:id="@+id/button_load_more"
            android:layout_width="wrap_content"
            android:layout_height="wrap_content"
            android:text="Muat Lebih Banyak"
            android:visibility="gone"
            app:layout_constraintBottom_toBottomOf="parent"
            app:layout_constraintStart_toStartOf="parent"
            app:layout_constraintEnd_toEndOf="parent"
            android:layout_marginBottom="16dp"
            style="@style/Widget.Material3.Button.OutlinedButton"/>

        <TextView
            android:id="@+id/text_view_error"
            android:layout_width="wrap_content"
            android:layout_height="wrap_content"
            android:text="Terjadi kesalahan."
            android:textSize="16sp"
            android:visibility="gone"
            app:layout_constraintTop_toTopOf="parent"
            app:layout_constraintBottom_toBottomOf="parent"
            app:layout_constraintStart_toStartOf="parent"
            app:layout_constraintEnd_toEndOf="parent" />

    </androidx.constraintlayout.widget.ConstraintLayout>
    ```

---

### **Langkah 5: Membangun Logika Bisnis (Repository & ViewModel)**

**Penjelasan:**
Ini adalah inti dari aplikasi. `Repository` akan mengambil dan memproses data mentah dari API, sementara `ViewModel` akan mengelola state UI (data yang ditampilkan, status loading, unit suhu, dll.) dan menyediakannya kepada `Activity`.

**Yang Dilakukan:**
1.  Buat package `repository`. Di dalamnya, buat file `WeatherRepository.kt`:

    ```kotlin
    // File: repository/WeatherRepository.kt
    package com.example.cuacaapp.repository

    import com.example.cuacaapp.model.WeatherItem
    import com.example.cuacaapp.network.ApiService
    import com.example.cuacaapp.utils.WeatherIconMapper
    import java.text.SimpleDateFormat
    import java.util.*

    class WeatherRepository(private val apiService: ApiService) {

        suspend fun getWeatherItems(): List<WeatherItem> {
            val response = apiService.getWeatherData()
            if (response.isSuccessful && response.body() != null) {
                val hourlyData = response.body()!!.hourly
                val times = hourlyData.time
                val temperatures = hourlyData.temperature2m
                val weathercodes = hourlyData.weathercode

                val weatherItems = mutableListOf<WeatherItem>()
                val inputFormat = SimpleDateFormat("yyyy-MM-dd'T'HH:mm", Locale.getDefault())
                val outputFormat = SimpleDateFormat("EEEE, dd MMM HH:mm", Locale("id", "ID"))

                for (i in times.indices) {
                    val dateTime = inputFormat.parse(times[i])
                    val formattedTime = dateTime?.let { outputFormat.format(it) } ?: times[i]
                    val iconRes = WeatherIconMapper.getWeatherIcon(weathercodes[i])
                    // Suhu akan dikonversi di ViewModel
                    val formattedTemp = "${temperatures[i]} °C"

                    weatherItems.add(WeatherItem(formattedTime, formattedTemp, iconRes))
                }
                return weatherItems
            } else {
                throw Exception("Gagal memuat data: ${response.code()}")
            }
        }
    }
    ```

2.  Buat package `ui` lalu sub-package `viewmodel`. Di dalamnya, buat file `MainViewModel.kt`:

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
    import kotlin.math.roundToInt

    class MainViewModel : ViewModel() {

        private val repository = WeatherRepository(RetrofitClient.instance)

        // Data master dari API (168 jam)
        private val allWeatherData = mutableListOf<WeatherItem>()

        // Data yang akan ditampilkan di UI (bisa dipotong karena pagination)
        private val _displayedWeatherData = MutableLiveData<List<WeatherItem>>()
        val displayedWeatherData: LiveData<List<WeatherItem>> = _displayedWeatherData

        private val _isLoading = MutableLiveData<Boolean>()
        val isLoading: LiveData<Boolean> = _isLoading

        private val _errorMessage = MutableLiveData<String>()
        val errorMessage: LiveData<String> = _errorMessage

        // State untuk pagination
        private var currentPage = 1
        private val itemsPerPage = 24

        // State untuk unit suhu
        private val _isCelsius = MutableLiveData<Boolean>(true)
        val isCelsius: LiveData<Boolean> = _isCelsius

        init {
            fetchWeatherData()
        }

        private fun fetchWeatherData() {
            _isLoading.value = true
            _errorMessage.value = null
            viewModelScope.launch {
                try {
                    allWeatherData.clear()
                    allWeatherData.addAll(repository.getWeatherItems())
                    currentPage = 1 // Reset ke halaman pertama
                    updateDisplayedData()
                } catch (e: Exception) {
                    _errorMessage.postValue(e.message)
                } finally {
                    _isLoading.postValue(false)
                }
            }
        }

        fun loadMore() {
            currentPage++
            updateDisplayedData()
        }

        fun toggleUnit() {
            _isCelsius.value = _isCelsius.value?.not()
            currentPage = 1 // Reset ke halaman pertama saat unit berubah
            updateDisplayedData()
        }

        private fun updateDisplayedData() {
            val endIndex = (currentPage * itemsPerPage).coerceAtMost(allWeatherData.size)
            val sublist = allWeatherData.take(endIndex)

            val convertedList = sublist.map { item ->
                val tempValue = item.temperature.substringBefore(" ").toDoubleOrNull() ?: 0.0
                val convertedTemp = if (_isCelsius.value == true) {
                    tempValue
                } else {
                    (tempValue * 9 / 5) + 32
                }
                val unitSymbol = if (_isCelsius.value == true) "°C" else "°F"
                item.copy(temperature = "${convertedTemp.roundToInt()} $unitSymbol")
            }

            _displayedWeatherData.postValue(convertedList)
        }
    }
    ```

---

### **Langkah 6: Menghubungkan UI dengan Logika (Adapter & MainActivity)**

**Penjelasan:**
Langkah terakhir adalah merangkai semuanya. `Adapter` akan mengisi setiap baris di `RecyclerView` dengan data, dan `MainActivity` akan mengamati perubahan dari `ViewModel` untuk memperbarui tampilan, serta menangani aksi pengguna (klik tombol, menu).

**Yang Dilakukan:**
1.  Buat package `ui` lalu sub-package `adapter`. Di dalamnya, buat file `WeatherAdapter.kt`:

    ```kotlin
    // File: ui/adapter/WeatherAdapter.kt
    package com.example.cuacaapp.ui.adapter

    import android.view.LayoutInflater
    import android.view.View
    import android.view.ViewGroup
    import android.widget.ImageView
    import android.widget.TextView
    import androidx.recyclerview.widget.RecyclerView
    import com.example.cuacaapp.R
    import com.example.cuacaapp.model.WeatherItem

    class WeatherAdapter(private var weatherList: List<WeatherItem>) :
        RecyclerView.Adapter<WeatherAdapter.WeatherViewHolder>() {

        class WeatherViewHolder(itemView: View) : RecyclerView.ViewHolder(itemView) {
            val timeTextView: TextView = itemView.findViewById(R.id.text_view_time)
            val temperatureTextView: TextView = itemView.findViewById(R.id.text_view_temperature)
            val iconImageView: ImageView = itemView.findViewById(R.id.image_view_weather_icon)
        }

        override fun onCreateViewHolder(parent: ViewGroup, viewType: Int): WeatherViewHolder {
            val view = LayoutInflater.from(parent.context)
                .inflate(R.layout.item_weather, parent, false)
            return WeatherViewHolder(view)
        }

        override fun onBindViewHolder(holder: WeatherViewHolder, position: Int) {
            val currentItem = weatherList[position]
            holder.timeTextView.text = currentItem.time
            holder.temperatureTextView.text = currentItem.temperature
            holder.iconImageView.setImageResource(currentItem.iconRes)
        }

        override fun getItemCount(): Int = weatherList.size

        fun updateData(newWeatherList: List<WeatherItem>) {
            this.weatherList = newWeatherList
            notifyDataSetChanged()
        }
    }
    ```

2.  Buka `MainActivity.kt` dan ganti seluruh isinya:

    ```kotlin
    // File: MainActivity.kt
    package com.example.cuacaapp

    import android.os.Bundle
    import android.view.View
    import androidx.activity.viewModels
    import androidx.appcompat.app.AppCompatActivity
    import androidx.recyclerview.widget.LinearLayoutManager
    import com.example.cuacaapp.databinding.ActivityMainBinding
    import com.example.cuacaapp.ui.adapter.WeatherAdapter
    import com.example.cuacaapp.ui.viewmodel.MainViewModel

    class MainActivity : AppCompatActivity() {

        private lateinit var binding: ActivityMainBinding
        private val viewModel: MainViewModel by viewModels()
        private lateinit var weatherAdapter: WeatherAdapter

        override fun onCreate(savedInstanceState: Bundle?) {
            super.onCreate(savedInstanceState)
            binding = ActivityMainBinding.inflate(layoutInflater)
            setContentView(binding.root)

            setupToolbar()
            setupRecyclerView()
            setupLoadMoreButton()
            observeViewModel()
        }

        private fun setupToolbar() {
            setSupportActionBar(binding.toolbar)
        }

        override fun onCreateOptionsMenu(menu: android.view.Menu?): Boolean {
            menuInflater.inflate(R.menu.menu_toolbar, menu)
            return true
        }

        override fun onOptionsItemSelected(item: android.view.MenuItem): Boolean {
            return when (item.itemId) {
                R.id.action_toggle_unit -> {
                    viewModel.toggleUnit()
                    true
                }
                else -> super.onOptionsItemSelected(item)
            }
        }

        private fun setupRecyclerView() {
            weatherAdapter = WeatherAdapter(emptyList())
            binding.recyclerViewWeather.apply {
                adapter = weatherAdapter
                layoutManager = LinearLayoutManager(this@MainActivity)
            }
        }

        private fun setupLoadMoreButton() {
            binding.buttonLoadMore.setOnClickListener {
                viewModel.loadMore()
            }
        }

        private fun observeViewModel() {
            viewModel.displayedWeatherData.observe(this) { weatherItems ->
                weatherAdapter.updateData(weatherItems)
                // Sembunyikan tombol jika semua data sudah ditampilkan
                binding.buttonLoadMore.visibility = if (weatherItems.size >= 168) View.GONE else View.VISIBLE
            }

            viewModel.isLoading.observe(this) { isLoading ->
                binding.progressBar.visibility = if (isLoading) View.VISIBLE else View.GONE
            }

            viewModel.errorMessage.observe(this) { errorMessage ->
                if (errorMessage != null) {
                    binding.textViewError.visibility = View.VISIBLE
                    binding.textViewError.text = errorMessage
                    binding.recyclerViewWeather.visibility = View.GONE
                    binding.buttonLoadMore.visibility = View.GONE
                } else {
                    binding.textViewError.visibility = View.GONE
                    binding.recyclerViewWeather.visibility = View.VISIBLE
                }
            }

            viewModel.isCelsius.observe(this) { isCelsius ->
                // Perbarui judul menu
                binding.toolbar.menu?.findItem(R.id.action_toggle_unit)?.title =
                    if (isCelsius) "Ubah ke °F" else "Ubah ke °C"
            }
        }
    }
    ```

---

### **Langkah 7: Menjalankan Aplikasi**

**Penjelasan:**
Semua komponen telah terpasang. Saatnya untuk melihat hasil kerja kita.

**Yang Dilakukan:**
1.  Pastikan perangkat/emulator Android terhubung.
2.  Klik tombol **Run 'app'** di Android Studio.
3.  Aplikasi akan terbuka, menampilkan 24 data cuaca pertama dengan ikon yang sesuai.
4.  Tombol **"Muat Lebih Banyak"** akan muncul. Klik untuk menampilkan data berikutnya.
5.  Klik menu di `Toolbar` untuk beralih antara °C dan °F. Semua suhu di layar akan berubah secara instan.
