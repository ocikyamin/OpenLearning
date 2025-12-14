## **Tutorial Lengkap: Aplikasi Daftar Harga Cryptocurrency dengan Kotlin**

### **1. Pendahuluan dan Tujuan Pembelajaran**

#### **Tujuan Pembelajaran**
Tutorial ini diperbarui untuk memberikan pengalaman belajar yang lebih mendalam bagi mahasiswa tingkat pemula. Setelah menyelesaikan tutorial ini, diharapkan pembaca dapat:
1.  Membuat aplikasi Android dengan lebih dari satu **Activity** dan melakukan navigasi antar Activity menggunakan **Intent**.
2.  Memahami dan menerapkan **View Binding** sebagai pengganti `findViewById()` yang lebih aman dan efisien.
3.  Mengimplementasikan **Material Design** untuk tampilan UI yang modern dan menarik.
4.  Mengambil data dari REST API publik menggunakan **Retrofit** dan **Gson**.
5.  Menampilkan data dalam daftar yang kompleks menggunakan **RecyclerView**.
6.  Menerapkan fitur **Pagination** (memuat data bertahap saat pengguna scroll ke bawah).
7.  Menggunakan **SwipeRefreshLayout** untuk fitur pull-to-refresh.
8.  Memahami pentingnya **Permission** dalam file `AndroidManifest.xml`.

---

### **2. Gambaran Umum Aplikasi yang Akan Dibuat**

Aplikasi ini akan memiliki dua layar utama:

1.  **MainActivity (Layar Pembuka)**
    *   Menampilkan logo aplikasi, judul, dan deskripsi singkat.
    *   Memiliki satu tombol utama: "Lihat Daftar Harga" yang akan membawa pengguna ke layar daftar kripto.

2.  **CryptoListActivity (Layar Daftar Harga)**
    *   Menampilkan daftar cryptocurrency dalam bentuk kartu yang menarik.
    *   Setiap kartu menampilkan: Rank, Ikon, Nama, Simbol, dan Harga USD.
    *   Menampilkan 10 data pertama saat pertama kali dibuka.
    *   Saat pengguna scroll ke bawah, aplikasi akan otomatis memuat 10 data berikutnya (Pagination).
    *   Memiliki tombol "Refresh" untuk memuat ulang seluruh data dari awal.
    *   Saat ditekan tombol "kembali" di perangkat, pengguna akan kembali ke `MainActivity`.

---

### **3. Persiapan Lingkungan Pengembangan**

#### **Langkah 3.1: Membuat Project Baru**
1.  Buka Android Studio.
2.  Pilih **File > New > New Project**.
3.  Pilih **Empty Views Activity** dan klik **Next**.
4.  Konfigurasi project Anda:
    *   **Name**: `CryptoPriceApp`
    *   **Package name**: `com.example.cryptopriceapp` (atau sesuai keinginan)
    *   **Language**: **Kotlin**
    *   **Minimum SDK**: API 24: Android 7.0 (Nougat) atau lebih tinggi.
5.  Klik **Finish**. Android Studio akan menyiapkan project untuk Anda.

#### **Langkah 3.2: Mengaktifkan View Binding**
View Binding adalah fitur yang memudahkan kita menulis kode yang berinteraksi dengan UI. Ini adalah alternatif yang jauh lebih baik daripada `findViewById()`.

1.  Buka file `build.gradle.kts (Module :app)` atau `build.gradle (Module :app)`.
2.  Di dalam blok `android { ... }`, tambahkan baris berikut:

    ```groovy
    android {
        // ... konfigurasi lainnya
        buildFeatures {
            viewBinding = true
        }
    }
    ```
3.  Klik **Sync Now** yang muncul di bagian atas editor. Android Studio akan mengkonfigurasi project Anda.

---

### **4. Penjelasan Singkat Tentang Konsep Inti**

*   **API (Application Programming Interface)**: Sekumpulan aturan yang memungkinkan aplikasi kita "berbicara" dengan server lain. Kita akan menggunakan API Coinlore untuk meminta data harga kripto.
*   **JSON (JavaScript Object Notation)**: Format data yang ringan dan mudah dibaca yang digunakan untuk bertukar data antara server dan aplikasi. Respons dari API Coinlore akan berformat JSON.
*   **HTTP Request**: Protokol yang digunakan untuk mengambil data (GET), mengirim data (POST), dll. Kita akan menggunakan metode GET untuk mengambil data dari API.
*   **Pagination**: Teknik untuk memuat data dalam beberapa halaman (contoh: 10 data per halaman) daripada memuat semuanya sekaligus. Ini membuat aplikasi lebih cepat dan hemat data.

---

### **5. Menambahkan Dependency yang Diperlukan**

Dependency adalah library eksternal yang akan kita gunakan.

1.  Buka kembali file `build.gradle.kts (Module :app)`.
2.  Di dalam blok `dependencies { ... }`, tambahkan library berikut:

    ```groovy
    dependencies {
        // ... dependency lainnya

        // UI: Material Components untuk desain modern
        implementation("com.google.android.material:material:1.12.0")

        // Networking: Retrofit untuk mengakses API
        implementation("com.squareup.retrofit2:retrofit:2.11.0")
        implementation("com.squareup.retrofit2:converter-gson:2.11.0") // Konverter JSON

        // Asynchronous Operation: Coroutines untuk menjalankan kode di background
        implementation("org.jetbrains.kotlinx:kotlinx-coroutines-android:1.7.3")

        // Image Loading: Coil untuk memuat gambar dari URL dengan mudah
        implementation("io.coil-kt:coil:2.6.0")
    }
    ```
3.  Klik **Sync Now**.

---

### **6. Menambahkan Permission Internet**

Aplikasi kita memerlukan izin untuk mengakses internet agar bisa menghubungi API.

1.  Buka file `app/src/main/AndroidManifest.xml`.
2.  Tambahkan baris berikut tepat sebelum tag `<application>`:

    ```xml
    <uses-permission android:name="android.permission.INTERNET" />
    ```

---

### **7. Desain UI: Layout XML**

#### **Langkah 7.1: Layout untuk MainActivity (Layar Pembuka)**

1.  Buka file `app/src/main/res/layout/activity_main.xml`.
2.  Ganti seluruh isinya dengan kode berikut untuk membuat tampilan pembuka yang sederhana dan menarik:

    ```xml
    <?xml version="1.0" encoding="utf-8"?>
    <androidx.constraintlayout.widget.ConstraintLayout xmlns:android="http://schemas.android.com/apk/res/android"
        xmlns:app="http://schemas.android.com/apk/res-auto"
        xmlns:tools="http://schemas.android.com/tools"
        android:layout_width="match_parent"
        android:layout_height="match_parent"
        android:padding="32dp"
        tools:context=".MainActivity">

        <ImageView
            android:id="@+id/imageViewLogo"
            android:layout_width="150dp"
            android:layout_height="150dp"
            android:src="@drawable/ic_crypto_logo"
            app:layout_constraintBottom_toTopOf="@+id/textViewTitle"
            app:layout_constraintEnd_toEndOf="parent"
            app:layout_constraintStart_toStartOf="parent"
            app:layout_constraintTop_toTopOf="parent"
            app:layout_constraintVertical_chainStyle="packed" />

        <TextView
            android:id="@+id/textViewTitle"
            android:layout_width="wrap_content"
            android:layout_height="wrap_content"
            android:layout_marginTop="24dp"
            android:text="Cek Harga Kripto"
            android:textSize="28sp"
            android:textStyle="bold"
            app:layout_constraintBottom_toTopOf="@+id/textViewDesc"
            app:layout_constraintEnd_toEndOf="parent"
            app:layout_constraintStart_toStartOf="parent"
            app:layout_constraintTop_toBottomOf="@+id/imageViewLogo" />

        <TextView
            android:id="@+id/textViewDesc"
            android:layout_width="0dp"
            android:layout_height="wrap_content"
            android:layout_marginTop="16dp"
            android:gravity="center"
            android:text="Dapatkan informasi terkini tentang harga cryptocurrency dari seluruh dunia."
            android:textSize="16sp"
            app:layout_constraintBottom_toTopOf="@+id/buttonViewList"
            app:layout_constraintEnd_toEndOf="parent"
            app:layout_constraintStart_toStartOf="parent"
            app:layout_constraintTop_toBottomOf="@+id/textViewTitle" />

        <com.google.android.material.button.MaterialButton
            android:id="@+id/buttonViewList"
            android:layout_width="0dp"
            android:layout_height="60dp"
            android:layout_marginTop="32dp"
            android:text="Lihat Daftar Harga"
            android:textSize="18sp"
            app:cornerRadius="16dp"
            app:layout_constraintBottom_toBottomOf="parent"
            app:layout_constraintEnd_toEndOf="parent"
            app:layout_constraintStart_toStartOf="parent"
            app:layout_constraintTop_toBottomOf="@+id/textViewDesc" />

    </androidx.constraintlayout.widget.ConstraintLayout>
    ```

3.  **Menambahkan Gambar Logo**: Klik kanan pada folder `res/drawable`, pilih **New > Vector Asset**. Cari "currency bitcoin" atau ikon serupa, beri nama `ic_crypto_logo`, dan selesaikan.

#### **Langkah 7.2: Layout untuk Item di Daftar Kripto**

1.  Klik kanan pada folder `res/layout`, pilih **New > Layout Resource File**.
2.  Beri nama `item_crypto.xml` dan klik **OK**.
3.  Isi dengan kode berikut untuk membuat desain kartu yang modern:

    ```xml
    <?xml version="1.0" encoding="utf-8"?>
    <com.google.android.material.card.MaterialCardView xmlns:android="http://schemas.android.com/apk/res/android"
        xmlns:app="http://schemas.android.com/apk/res-auto"
        xmlns:tools="http://schemas.android.com/tools"
        android:layout_width="match_parent"
        android:layout_height="wrap_content"
        android:layout_marginHorizontal="16dp"
        android:layout_marginVertical="8dp"
        app:cardCornerRadius="12dp"
        app:cardElevation="4dp">

        <androidx.constraintlayout.widget.ConstraintLayout
            android:layout_width="match_parent"
            android:layout_height="wrap_content"
            android:padding="16dp">

            <TextView
                android:id="@+id/textViewRank"
                android:layout_width="wrap_content"
                android:layout_height="wrap_content"
                android:textColor="?android:attr/textColorSecondary"
                android:textSize="14sp"
                android:textStyle="bold"
                app:layout_constraintStart_toStartOf="parent"
                app:layout_constraintTop_toTopOf="parent"
                tools:text="#1" />

            <ImageView
                android:id="@+id/imageViewIcon"
                android:layout_width="32dp"
                android:layout_height="32dp"
                android:layout_marginStart="16dp"
                android:contentDescription="Icon Crypto"
                app:layout_constraintBottom_toBottomOf="@+id/textViewName"
                app:layout_constraintStart_toEndOf="@id/textViewRank"
                app:layout_constraintTop_toTopOf="@+id/textViewName"
                tools:src="@mipmap/ic_launcher" />

            <TextView
                android:id="@+id/textViewName"
                android:layout_width="0dp"
                android:layout_height="wrap_content"
                android:layout_marginStart="16dp"
                android:ellipsize="end"
                android:maxLines="1"
                android:textColor="?android:attr/textColorPrimary"
                android:textSize="16sp"
                android:textStyle="bold"
                app:layout_constraintEnd_toStartOf="@+id/textViewPrice"
                app:layout_constraintStart_toEndOf="@+id/imageViewIcon"
                app:layout_constraintTop_toTopOf="parent"
                tools:text="Bitcoin" />

            <TextView
                android:id="@+id/textViewSymbol"
                android:layout_width="wrap_content"
                android:layout_height="wrap_content"
                android:textColor="?android:attr/textColorSecondary"
                android:textSize="12sp"
                app:layout_constraintStart_toStartOf="@+id/textViewName"
                app:layout_constraintTop_toBottomOf="@+id/textViewName"
                tools:text="BTC" />

            <TextView
                android:id="@+id/textViewPrice"
                android:layout_width="wrap_content"
                android:layout_height="wrap_content"
                android:textColor="@color/green"
                android:textSize="16sp"
                android:textStyle="bold"
                app:layout_constraintEnd_toEndOf="parent"
                app:layout_constraintTop_toTopOf="parent"
                tools:text="$45,123.45" />

        </androidx.constraintlayout.widget.ConstraintLayout>

    </com.google.android.material.card.MaterialCardView>
    ```

4.  **Menambahkan Warna**: Buka `res/values/colors.xml` dan tambahkan definisi warna hijau:
    ```xml
    <color name="green">#4CAF50</color>
    ```

#### **Langkah 7.3: Layout untuk CryptoListActivity**

1.  Klik kanan pada package `com.example.cryptopriceapp`, pilih **New > Activity > Empty Views Activity**.
2.  Beri nama `CryptoListActivity` dan pastikan **Source Language** adalah **Kotlin**. Klik **Finish**. Ini akan otomatis membuat file `ActivityCryptoListBinding`, `CryptoListActivity.kt`, dan `activity_crypto_list.xml`.
3.  Buka file `activity_crypto_list.xml` yang baru dibuat dan ganti isinya dengan:

    ```xml
    <?xml version="1.0" encoding="utf-8"?>
    <androidx.swiperefreshlayout.widget.SwipeRefreshLayout xmlns:android="http://schemas.android.com/apk/res/android"
        xmlns:app="http://schemas.android.com/apk/res-auto"
        xmlns:tools="http://schemas.android.com/tools"
        android:id="@+id/swipeRefreshLayout"
        android:layout_width="match_parent"
        android:layout_height="match_parent"
        tools:context=".CryptoListActivity">

        <androidx.constraintlayout.widget.ConstraintLayout
            android:layout_width="match_parent"
            android:layout_height="match_parent">

            <androidx.recyclerview.widget.RecyclerView
                android:id="@+id/recyclerViewCrypto"
                android:layout_width="0dp"
                android:layout_height="0dp"
                app:layout_constraintBottom_toBottomOf="parent"
                app:layout_constraintEnd_toEndOf="parent"
                app:layout_constraintStart_toStartOf="parent"
                app:layout_constraintTop_toTopOf="parent" />

            <ProgressBar
                android:id="@+id/progressBarInitial"
                android:layout_width="wrap_content"
                android:layout_height="wrap_content"
                android:visibility="visible"
                app:layout_constraintBottom_toBottomOf="parent"
                app:layout_constraintEnd_toEndOf="parent"
                app:layout_constraintStart_toStartOf="parent"
                app:layout_constraintTop_toTopOf="parent"
                tools:visibility="visible"/>

        </androidx.constraintlayout.widget.ConstraintLayout>

    </androidx.swiperefreshlayout.widget.SwipeRefreshLayout>
    ```

---

### **8. Membuat Model Data (Data Class)**

Kita perlu membuat class yang merepresentasikan struktur JSON dari API.

1.  Klik kanan pada package `com.example.cryptopriceapp`, pilih **New > Kotlin Class/File**.
2.  Beri nama `ApiResponse` dan pilih **Class**.
3.  Isi dengan kode berikut:

    ```kotlin
    import com.google.gson.annotations.SerializedName

    // Class untuk menampung response utama dari API
    data class ApiResponse(
        @SerializedName("data")
        val cryptoData: List<Crypto>
    )

    // Class untuk menampung data setiap cryptocurrency
    data class Crypto(
        @SerializedName("id")
        val id: String,

        @SerializedName("name")
        val name: String,

        @SerializedName("symbol")
        val symbol: String,

        @SerializedName("rank")
        val rank: String,

        @SerializedName("price_usd")
        val priceUsd: String,

        // Tambahkan field untuk URL icon, kita akan gunakan library lain untuk icon
        // Tapi untuk sekarang, kita biarkan dulu
    )
    ```
*   `@SerializedName` digunakan untuk memetakan key dari JSON ke properti di class Kotlin kita.

---

### **9. Membuat Interface API Service**

Ini adalah tempat kita mendefinisikan endpoint API yang akan dipanggil.

1.  Buat file Kotlin baru bernama `ApiService` (pilih **Interface**).
2.  Isi dengan kode berikut:

    ```kotlin
    import retrofit2.Call
    import retrofit2.http.GET
    import retrofit2.http.Query

    interface ApiService {
        // Endpoint untuk mendapatkan data ticker
        // @Query digunakan untuk menambahkan parameter ke URL
        // Contoh: https://api.coinlore.net/api/tickers/?start=0&limit=10
        @GET("api/tickers/")
        fun getTickers(
            @Query("start") start: Int,
            @Query("limit") limit: Int
        ): Call<ApiResponse>
    }
    ```

---

### **10. Membuat Retrofit Client**

Object ini akan menyediakan instance dari Retrofit dan ApiService.

1.  Buat file Kotlin baru bernama `RetrofitClient` (pilih **Object**).
2.  Isi dengan kode berikut:

    ```kotlin
    import retrofit2.Retrofit
    import retrofit2.converter.gson.GsonConverterFactory

    object RetrofitClient {
        private const val BASE_URL = "https://api.coinlore.net/"

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

### **11. Implementasi MainActivity (Layar Pembuka)**

Sekarang kita akan menghubungkan kode dengan layout `activity_main.xml`.

1.  Buka file `MainActivity.kt`.
2.  Ganti seluruh isinya dengan kode berikut:

    ```kotlin
    import android.content.Intent
    import android.os.Bundle
    import androidx.appcompat.app.AppCompatActivity
    import com.example.cryptopriceapp.databinding.ActivityMainBinding

    class MainActivity : AppCompatActivity() {

        // Deklarasi View Binding
        private lateinit var binding: ActivityMainBinding

        override fun onCreate(savedInstanceState: Bundle?) {
            super.onCreate(savedInstanceState)
            // Inisialisasi View Binding
            binding = ActivityMainBinding.inflate(layoutInflater)
            setContentView(binding.root)

            // Set listener untuk tombol
            binding.buttonViewList.setOnClickListener {
                // Pindah ke CryptoListActivity
                val intent = Intent(this, CryptoListActivity::class.java)
                startActivity(intent)
            }
        }
    }
    ```
*   **Penjelasan**:
    *   `private lateinit var binding: ActivityMainBinding`: Mendeklarasikan variabel binding.
    *   `binding = ActivityMainBinding.inflate(layoutInflater)`: Meng-inflate layout dan membuat objek binding.
    *   `setContentView(binding.root)`: Menggunakan binding root sebagai tampilan activity.
    *   `binding.buttonViewList.setOnClickListener`: Mengakses tombol langsung melalui objek binding tanpa `findViewById`.
    *   `Intent`: Objek untuk melakukan navigasi antar Activity.

---

### **12. Implementasi RecyclerView Adapter**

Adapter adalah jembatan antara data kita dan `RecyclerView`.

1.  Buat file Kotlin baru bernama `CryptoAdapter` (pilih **Class**).
2.  Isi dengan kode berikut:

    ```kotlin
    import android.view.LayoutInflater
    import android.view.ViewGroup
    androidx.recyclerview.widget.RecyclerView
    import com.example.cryptopriceapp.databinding.ItemCryptoBinding
    import java.text.NumberFormat
    import java.util.Locale

    class CryptoAdapter(private var cryptoList: List<Crypto>) :
        RecyclerView.Adapter<CryptoAdapter.CryptoViewHolder>() {

        // ViewHolder untuk menyimpan referensi ke view-view di item layout
        class CryptoViewHolder(val binding: ItemCryptoBinding) : RecyclerView.ViewHolder(binding.root)

        // Dipanggil saat RecyclerView butuh ViewHolder baru
        override fun onCreateViewHolder(parent: ViewGroup, viewType: Int): CryptoViewHolder {
            val binding = ItemCryptoBinding.inflate(LayoutInflater.from(parent.context), parent, false)
            return CryptoViewHolder(binding)
        }

        // Dipanggil untuk mengikat data ke ViewHolder pada posisi tertentu
        override fun onBindViewHolder(holder: CryptoViewHolder, position: Int) {
            val crypto = cryptoList[position]
            with(holder.binding) {
                textViewRank.text = "#${crypto.rank}"
                textViewName.text = crypto.name
                textViewSymbol.text = crypto.symbol

                // Format harga menjadi mata uang USD
                val price = crypto.priceUsd.toDoubleOrNull()
                val formattedPrice = if (price != null) {
                    NumberFormat.getCurrencyInstance(Locale.US).format(price)
                } else {
                    "N/A"
                }
                textViewPrice.text = formattedPrice

                // Kita bisa menambahkan logika untuk memuat icon di sini jika ada URL icon
                // Contoh: imageViewIcon.load(crypto.iconUrl)
            }
        }

        // Mengembalikan jumlah total item dalam list
        override fun getItemCount(): Int = cryptoList.size

        // Fungsi untuk memperbarui data di adapter
        fun updateData(newCryptoList: List<Crypto>) {
            cryptoList = newCryptoList
            notifyDataSetChanged() // Memberitahu RecyclerView bahwa data telah berubah
        }
    }
    ```

---

### **13. Implementasi CryptoListActivity (Logika Utama & Pagination)**

Ini adalah bagian yang paling kompleks. Di sini kita akan mengambil data, menampilkannya, dan mengatur pagination.

1.  Buka file `CryptoListActivity.kt`.
2.  Ganti seluruh isinya dengan kode berikut:

    ```kotlin
    import androidx.appcompat.app.AppCompatActivity
    import android.os.Bundle
    import android.widget.AbsListView
    import androidx.core.view.isVisible
    androidx.recyclerview.widget.LinearLayoutManager
    androidx.recyclerview.widget.RecyclerView
    com.example.cryptopriceapp.databinding.ActivityCryptoListBinding
    retrofit2.Call
    import retrofit2.Callback
    import retrofit2.Response

    class CryptoListActivity : AppCompatActivity() {

        private lateinit var binding: ActivityCryptoListBinding
        private lateinit var adapter: CryptoAdapter
        private val cryptoList = mutableListOf<Crypto>()

        // Variabel untuk pagination
        private var currentPage = 0
        private val limit = 10
        private var isLoading = false
        private var isLastPage = false

        override fun onCreate(savedInstanceState: Bundle?) {
            super.onCreate(savedInstanceState)
            binding = ActivityCryptoListBinding.inflate(layoutInflater)
            setContentView(binding.root)

            setupRecyclerView()
            fetchCryptocurrencies(isFirstLoad = true)

            // Setup SwipeRefreshLayout untuk refresh
            binding.swipeRefreshLayout.setOnRefreshListener {
                // Saat refresh, reset state dan muat dari awal
                currentPage = 0
                isLastPage = false
                cryptoList.clear()
                adapter.updateData(cryptoList)
                fetchCryptocurrencies(isFirstLoad = true)
            }
        }

        private fun setupRecyclerView() {
            adapter = CryptoAdapter(cryptoList)
            binding.recyclerViewCrypto.adapter = adapter
            val layoutManager = LinearLayoutManager(this)
            binding.recyclerViewCrypto.layoutManager = layoutManager

            // Tambahkan scroll listener untuk pagination
            binding.recyclerViewCrypto.addOnScrollListener(object : RecyclerView.OnScrollListener() {
                override fun onScrolled(recyclerView: RecyclerView, dx: Int, dy: Int) {
                    super.onScrolled(recyclerView, dx, dy)

                    val visibleItemCount = layoutManager.childCount
                    val totalItemCount = layoutManager.itemCount
                    val firstVisibleItemPosition = layoutManager.findFirstVisibleItemPosition()

                    // Cek apakah sudah di akhir halaman dan tidak sedang loading
                    if (!isLoading && !isLastPage) {
                        if ((visibleItemCount + firstVisibleItemPosition) >= totalItemCount
                            && firstVisibleItemPosition >= 0
                            && totalItemCount >= limit
                        ) {
                            // Load data halaman berikutnya
                            fetchCryptocurrencies(isFirstLoad = false)
                        }
                    }
                }
            })
        }

        private fun fetchCryptocurrencies(isFirstLoad: Boolean) {
            // Tampilkan ProgressBar yang sesuai
            if (isFirstLoad) {
                binding.progressBarInitial.isVisible = true
            } else {
                isLoading = true
                // Untuk pagination, kita bisa menambahkan loading item di adapter
                // Untuk kesederhanaan, kita skip menampilkan loading item di list
            }

            val start = currentPage * limit

            RetrofitClient.instance.getTickers(start, limit)
                .enqueue(object : Callback<ApiResponse> {
                    override fun onResponse(call: Call<ApiResponse>, response: Response<ApiResponse>) {
                        // Sembunyikan ProgressBar
                        binding.progressBarInitial.isVisible = false
                        binding.swipeRefreshLayout.isRefreshing = false
                        isLoading = false

                        if (response.isSuccessful) {
                            val newCryptos = response.body()?.cryptoData ?: emptyList()

                            if (newCryptos.isNotEmpty()) {
                                cryptoList.addAll(newCryptos)
                                adapter.updateData(cryptoList)
                                currentPage++
                            } else {
                                // Jika data kosong, ini adalah halaman terakhir
                                isLastPage = true
                            }

                        } else {
                            // Handle error
                        }
                    }

                    override fun onFailure(call: Call<ApiResponse>, t: Throwable) {
                        // Sembunyikan ProgressBar
                        binding.progressBarInitial.isVisible = false
                        binding.swipeRefreshLayout.isRefreshing = false
                        isLoading = false
                        // Handle failure
                    }
                })
        }
    }
    ```

---

### **14. Mendaftarkan Activity Baru**

Android perlu tahu tentang `CryptoListActivity` yang kita buat. Karena kita menggunakan Android Studio untuk membuat activity, ini seharusnya sudah otomatis terdaftar di `AndroidManifest.xml`. Namun, pastikan file `app/src/main/AndroidManifest.xml` Anda memiliki kedua activity seperti ini:

```xml
<?xml version="1.0" encoding="utf-8"?>
<manifest xmlns:android="http://schemas.android.com/apk/res/android"
    xmlns:tools="http://schemas.android.com/tools">

    <uses-permission android:name="android.permission.INTERNET" />

    <application
        ...>
        <activity
            android:name=".MainActivity"
            android:exported="true">
            <intent-filter>
                <action android:name="android.intent.action.MAIN" />
                <category android:name="android.intent.category.LAUNCHER" />
            </intent-filter>
        </activity>
        <activity
            android:name=".CryptoListActivity"
            android:exported="false"
            android:parentActivityName=".MainActivity" /> <!-- Tambahkan parentActivityName untuk tombol kembali -->
    </application>
</manifest>
```
*   `android:parentActivityName=".MainActivity"` akan secara otomatis memberikan fungsi tombol "kembali" di `CryptoListActivity` untuk kembali ke `MainActivity`.

---

### **15. Pengujian Aplikasi**

1.  **Menjalankan Aplikasi**:
    *   Pilih emulator atau perangkat Android Anda.
    *   Klik tombol **Run 'app'** (ikon segitiga hijau) di Android Studio.

2.  **Test Case**:
    *   **Layar Pembuka**: Pastikan `MainActivity` muncul dengan benar, menampilkan logo, teks, dan tombol.
    *   **Navigasi**: Tekan tombol "Lihat Daftar Harga". Pastikan Anda beralih ke `CryptoListActivity`.
    *   **Loading Awal**: Pastikan `ProgressBar` muncul saat data pertama kali dimuat.
    *   **Tampilan Data**: Setelah loading, pastikan 10 data kripto pertama muncul dalam bentuk kartu yang rapi.
    *   **Pagination**: Scroll perlahan ke bawah hingga mencapai akhir daftar. Aplikasi seharusnya otomatis memuat 10 data berikutnya tanpa interaksi tambahan.
    *   **Pull-to-Refresh**: Tarik daftar ke bawah (saat di posisi paling atas). Lihat ikon refresh muncul dan data dimuat ulang dari awal.
    *   **Tombol Kembali**: Tekan tombol kembali di perangkat atau di bar aksi. Pastikan Anda kembali ke `MainActivity`.

---

### **16. Ringkasan Hasil Pembelajaran**

Selamat! Anda telah berhasil membuat aplikasi Android yang jauh lebih kompleks dan modern. Anda telah mempelajari:
*   **Multi-Activity**: Membuat dan mengelola lebih dari satu layar dalam aplikasi.
*   **Navigasi dengan Intent**: Berpindah antar activity.
*   **View Binding**: Cara modern dan aman untuk mengakses komponen UI.
*   **Material Design**: Membuat UI yang menarik dengan komponen seperti `MaterialCardView` dan `MaterialButton`.
*   **RecyclerView Lanjutan**: Menggunakan adapter yang efisien.
*   **Pagination**: Teknik penting untuk menampilkan data dalam jumlah besar.
*   **SwipeRefreshLayout**: Memberikan pengalaman pengguna yang intuitif untuk refresh data.
*   **Manajemen State**: Mengelola status loading, data, dan error dengan lebih baik.
