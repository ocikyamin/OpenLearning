
# **BAB 1: Pengenalan Pemrograman Mobile (Android, Kotlin, Android Studio)**

## **1.1 Pendahuluan**

### **1.1.1 Latar Belakang dan Perkembangan Pemrograman Mobile**

Dewasa ini, sulit untuk membayangkan kehidupan tanpa perangkat mobile. Dari telapak tangan kita, kita dapat mengakses informasi global, berkomunikasi dengan orang di seluruh dunia, bekerja, berbelanja, dan menikmati hiburan. Transformasi ini tidak terjadi secara instan; ia adalah hasil dari evolusi teknologi yang pesat, dengan pemrograman mobile sebagai tulang punggungnya.

Pemrograman mobile adalah seni dan ilmu dalam membuat aplikasi perangkat lunak yang berjalan pada perangkat bergerak seperti smartphone dan tablet. Perjalanannya dimulai dari aplikasi yang sangat sederhana dengan fungsi terbatas pada ponsel awal, hingga aplikasi kompleks saat ini yang setara dengan program desktop. Awal tahun 2000an, platform seperti Symbian (Nokia), BlackBerry OS, dan Java ME (J2ME) mendominasi. Aplikasi pada era ini seringkali terbatas oleh kapasitas perangkat, antarmuka yang tidak intuitif, dan mekanisme distribusi yang sulit.

Titik balik monumental terjadi pada tahun 2007 dengan peluncuran iPhone dan App Store oleh Apple, yang diikuti pada tahun 2008 oleh Android dengan Android Market (sekarang Google Play). Kedua ekosistem ini mempopulerkan konsep "aplikasi" yang mudah diunduh, dipasang, dan digunakan oleh pengguna biasa. Ini menciptakan sebuah "ekonomi aplikasi" (app economy) yang berkembang pesat, membuka peluang baru bagi pengembang, pengusaha, dan perusahaan untuk mencapai miliaran pengguna secara langsung. Sejak saat itu, pemrograman mobile menjadi salah satu bidang pengembangan perangkat lunak yang paling diminati dan terus berkembang dengan inovasi pada perangkat keras (sensor, AI chip) dan perangkat lunak (sistem operasi, bahasa pemrograman, framework).

### **1.1.2 Tren Penggunaan Android**

Di antara berbagai platform mobile, Android menonjol sebagai sistem operasi mobile paling dominan di dunia. Menurut data dari berbagai lembaga riset seperti Statista dan Gartner, per kuartal ketiga 2023, Android menguasai lebih dari 70% pangsa pasar sistem operasi global. Dominasi ini disebabkan oleh beberapa faktor kunci:

1.  **Sumber Terbuka (Open Source):** Android bersifat open source, yang memungkinkan berbagai produsen perangkat (seperti Samsung, Xiaomi, Oppo, Vivo) untuk mengadopsi, memodifikasi, dan menggunakannya pada perangkat mereka dengan biaya yang lebih rendah. Hal ini menciptakan ekosistem perangkat yang sangat beragam dengan berbagai harga dan spesifikasi.
2.  **Ketersediaan Aplikasi:** Google Play Store menawarkan jutaan aplikasi yang mencakup hampir semua aspek kehidupan, memberikan nilai tambah yang besar bagi pengguna.
3.  **Kustomisasi:** Android menawarkan tingkat kustomisasi yang tinggi bagi pengguna dan produsen, memungkinkan pengalaman pengguna yang disesuaikan.
4.  **Harga Perangkat yang Bervariasi:** Pengguna dapat memilih dari berbagai perangkat Android, mulai dari yang paling terjangkau hingga flagship premium, membuat teknologi ini lebih mudah diakses oleh berbagai lapisan masyarakat.

Bagi seorang calon pengembang mobile, tren ini berarti bahwa mempelajari pengembangan Android membuka peluang untuk menjangkau audiens global yang sangat besar. Memahami ekosistem Android bukan lagi sekadar pilihan, melainkan sebuah keharusan dalam industri pengembangan perangkat lunak mobile.

## **1.2 Konsep Pemrograman Mobile**

### **1.2.1 Definisi Pemrograman Mobile**

Secara formal, pemrograman mobile adalah proses perancangan, pembuatan, penerapan, dan pemeliharaan aplikasi perangkat lunak yang dirancang khusus untuk berjalan pada perangkat mobile seperti smartphone, tablet, dan smartwatch. Proses ini tidak hanya melibatkan penulisan kode, tetapi juga pertimbangan mendalam tentang konteks penggunaan perangkat mobile.

Berbeda dengan pemrograman desktop atau web, aplikasi mobile harus dirancang dengan mempertimbangkan keterbatasan dan kelebihan unik dari perangkat bergerak. Ini termasuk ukuran layar yang kecil, metode input berbasis sentuhan (touch), keterbatasan daya baterai, koneksi internet yang tidak selalu stabil, serta akses ke berbagai sensor dan fitur perangkat keras seperti GPS, kamera, dan akselerometer.

### **1.2.2 Karakteristik Aplikasi Mobile**

Aplikasi mobile yang baik memiliki beberapa karakteristik fundamental yang membedakannya dari aplikasi pada platform lain:

*   **Antarmuka Pengguna (UI) yang Responsif dan Intuitif:** UI harus dirancang untuk layar kecil dengan elemen-elemen yang mudah disentuh menggunakan jari. Prinsip "touch-friendly" adalah kunci.
*   **Performa yang Optimal:** Aplikasi harus ringan dan cepat. Pengguna mobile cenderung tidak sabar; aplikasi yang lambat akan segera ditinggalkan. Manajemen memori dan penggunaan CPU yang efisien sangat penting untuk menghemat baterai.
*   **Manajemen Daya Baterai:** Aplikasi harus dirancang untuk tidak menguras baterai secara berlebihan. Ini melibatkan penggunaan API yang efisien dan menghindari proses yang berjalan di latar belakang secara tidak perlu.
*   **Konektivitas yang Adaptif:** Aplikasi harus dapat menangani berbagai kondisi jaringan, mulai dari Wi-Fi koneksi cepat hingga jaringan seluler yang lambat atau tidak stabil. Sering kali, aplikasi perlu memiliki fitur offline.
*   **Akses ke Fitur Perangkat:** Aplikasi mobile dapat memanfaatkan fitur bawaan perangkat seperti GPS untuk layanan berbasis lokasi, kamera untuk augmented reality, atau sensor untuk aplikasi kebugaran.

### **1.2.3 Perbedaan dengan Aplikasi Desktop dan Web**

Untuk memahami pemrograman mobile secara lebih baik, penting untuk membandingkannya dengan pemrograman desktop dan web.

| Aspek | Aplikasi Mobile | Aplikasi Desktop | Aplikasi Web |
| :--- | :--- | :--- | :--- |
| **Metode Input** | Sentuhan (touch), gerakan (gesture), suara, sensor | Keyboard, mouse, touchpad | Keyboard, mouse, touchpad |
| **Ukuran Layar** | Kecil hingga sedang, berbagai aspek rasio | Sedang hingga besar, aspek rasio standar | Bervariasi, namun umumnya diakses di layar sedang/besar |
| **Konteks Penggunaan** | "On-the-go", seringkali dengan perhatian terpecah | Stasioner, fokus penuh | Bervariasi, bisa di desktop atau mobile |
| **Distribusi** | Melalui App Store (Google Play, App Store) | Langsung (installer file) atau toko aplikasi | Melalui browser, tidak perlu instalasi |
| **Akses Perangkat Keras** | Penuh (kamera, GPS, sensor, dll) | Terbatas (webcam, mikrofon) | Sangat terbatas (melalui API web) |
| **Pembaruan** | Terpusat melalui App Store | Manual oleh pengguna atau otomatis | Server-side, pengguna selalu dapatkan versi terbaru |

## **1.3 Pengenalan Android**

### **1.3.1 Sejarah Singkat Android dan Ekosistemnya**

Android bukanlah lahir dari tangan Google. Perusahaan ini awalnya didirikan pada tahun 2003 di Palo Alto, California oleh Andy Rubin, Rich Miner, Nick Sears, dan Chris White. Visi awal mereka adalah menciptakan sistem operasi cerdas untuk kamera digital. Namun, mereka segera menyadari bahwa pasar untuk kamera digital tidak sebesar pasar ponsel pintar. Pada tahun 2005, Google mengakuisisi Android Inc., sebuah langkah strategis untuk memasuki pasar mobile.

Pada tahun 2007, Open Handset Alliance (OHA) dibentuk. Ini adalah konsorsium dari perusahaan-perusahaan teknologi termasuk Google, produsen perangkat keras (HTC, Samsung, Motorola), dan operator seluler (T-Mobile), dengan tujuan mengembangkan standar terbuka untuk perangkat mobile. Android adalah produk pertama dari aliansi ini. Ponsel komersial pertama yang menjalankan Android adalah HTC Dream (juga dikenal sebagai T-Mobile G1), yang diluncurkan pada tahun 2008.

Ekosistem Android berkembang dengan pesat. Kunci kesuksesannya adalah kombinasi dari sistem operasi open source (Android Open Source Project - AOSP) yang memungkinkan inovasi dari berbagai pihak, dan layanan Google (Google Play Services, Gmail, Google Maps) yang menyediakan nilai tambah dan pengalaman yang konsisten bagi pengguna. Ekosistem ini mencakup jutaan pengembang, miliaran pengguna aktif, dan ribuan jenis perangkat yang berbeda.

### **1.3.2 Arsitektur Android**

Untuk memahami cara kerja aplikasi Android, kita perlu memahami arsitektur sistem operasinya. Android dirancang dalam bentuk tumpukan perangkat lunak (software stack) yang terdiri dari beberapa lapisan, dimana setiap lapisan menyediakan layanan untuk lapisan di atasnya.

![Arsitektur Android](https://developer.android.com/static/images/topic/architecture/architecture-components.svg)
*(Sumber: developer.android.com)*

1.  **Linux Kernel:** Ini adalah fondasi dari Android. Kernel Linux bertanggung jawab untuk mengelola perangkat keras tingkat rendah seperti driver (display, camera, Bluetooth, Wi-Fi), manajemen daya, memori, dan keamanan. Dengan menggunakan kernel Linux, Android mewarisi stabilitas dan keamanan dari sistem operasi yang telah matang.

2.  **Hardware Abstraction Layer (HAL):** Lapisan ini menyediakan antarmuka standar untuk komponen perangkat keras, sehingga kode tingkat atas tidak perlu tahu detail driver dari produsen perangkat tertentu.

3.  **Native C/C++ Libraries:** Lapisan ini berisi sekumpulan pustaka (libraries) yang ditulis dalam C atau C++ yang digunakan oleh berbagai komponen sistem. Contohnya termasuk:
    *   **Media Framework:** Untuk pemutaran dan perekaman audio/video.
    *   **SQLite:** Mesin database ringan untuk penyimpanan data.
    *   **OpenGL/ES:** Pustaka untuk rendering grafis 2D dan 3D.
    *   **WebKit:** Mesin browser untuk rendering halaman web.

4.  **Android Runtime (ART):** Setiap aplikasi Android berjalan di dalam prosesnya sendiri dengan instance ART-nya sendiri. ART adalah lingkungan runtime yang mengeksekusi kode aplikasi. Sebelum Android 5.0 Lollipop, runtime yang digunakan adalah Dalvik. ART menggunakan teknik Ahead-Of-Time (AOT) compilation, yang menerjemahkan kode aplikasi menjadi kode mesin native saat aplikasi diinstal. Ini meningkatkan performa aplikasi secara signifikan dibandingkan Dalvik yang menggunakan Just-In-Time (JIT) compilation.

5.  **Java API Framework:** Lapisan ini adalah "jembatan" bagi para pengembang. Ini adalah kumpulan API tingkat tinggi yang ditulis dalam bahasa Java (dan sekarang Kotlin) yang menyediakan berbagai layanan sistem. Contoh komponen dalam framework ini adalah:
    *   **Activity Manager:** Mengelola siklus hidup aplikasi.
    *   **Window Manager:** Mengelola jendela dan antarmuka pengguna.
    *   **Content Providers:** Memungkinkan aplikasi untuk berbagi data.
    *   **View System:** Membangun antarmuka pengguna dengan komponen seperti tombol dan teks.

6.  **System Apps & Apps:** Di lapisan teratas terdapat aplikasi sistem (seperti Telepon, Kontak, Browser) dan aplikasi yang kita kembangkan sebagai pengembang. Aplikasi-aplikasi ini menggunakan API yang disediakan oleh Java API Framework untuk berinteraksi dengan sistem Android.

### **1.3.3 Komponen Dasar Aplikasi Android**

Aplikasi Android tidak dibangun sebagai satu blok kode monolitik. Sebaliknya, ia terdiri dari beberapa komponen yang berbeda, masing-masing dengan peran spesifik. Sistem Android memulai kode aplikasi dalam komponen-komponen ini melalui instance dari kelas-kelas dasarnya. Ada empat jenis komponen utama:

1.  **Activities:** Sebuah `Activity` merepresentasikan satu layar dengan antarmuka pengguna (UI). Aplikasi email, misalnya, mungkin memiliki satu `Activity` untuk menampilkan daftar email, `Activity` lain untuk menulis email, dan `Activity` lain lagi untuk membaca email. Setiap `Activity` independen, namun bekerja sama untuk membentuk pengalaman pengguna yang kohesif. `Activity` adalah titik masuk utama bagi interaksi pengguna.

2.  **Services:** Sebuah `Service` adalah komponen yang berjalan di latar belakang untuk melakukan operasi jangka panjang atau yang membutuhkan waktu lama tanpa memerlukan interaksi pengguna. `Service` tidak memiliki antarmuka pengguna. Contohnya adalah `Service` yang memutar musik di latar belakang saat pengguna menggunakan aplikasi lain, atau `Service` yang mengunduh data dari internet tanpa menghalangi UI.

3.  **Broadcast Receivers:** Komponen ini merespon pesan siaran (broadcast messages) dari seluruh sistem atau dari aplikasi lain. Pesan siaran seringkali disebut sebagai "events" atau "intents". Misalnya, sistem akan mengirimkan siaran saat perangkat selesai mengisi daya, saat baterai lemah, atau saat sebuah foto diambil. Aplikasi dapat membuat `BroadcastReceiver` untuk "mendengarkan" dan merespons siaran ini, misalnya dengan memunculkan notifikasi.

4.  **Content Providers:** Sebuah `Content Provider` mengelola sekumpulan data aplikasi yang dapat dibagikan dengan aplikasi lain. Data dapat disimpan dalam sistem file, database SQLite, di web, atau lokasi permanen lainnya. Melalui `Content Provider`, aplikasi lain dapat mengquery atau bahkan memodifikasi data (dengan izin yang sesuai). Contohnya adalah `Content Provider` untuk kontak, yang memungkinkan aplikasi apa pun (dengan izin) untuk mengakses daftar kontak pengguna.

## **1.4 Pengenalan Kotlin**

### **1.4.1 Mengapa Kotlin Dipilih sebagai Bahasa Utama Android?**

Selama lebih dari satu dekade, Java adalah bahasa resmi untuk pengembangan Android. Namun, pada tahun 2017, Google mengumumkan Kotlin sebagai bahasa pemrograman resmi kedua untuk Android. Kemudian, pada Google I/O 2019, Google mengumumkan bahwa pengembangan Android akan menjadi "Kotlin-first". Artinya, Google akan lebih memprioritaskan fitur dan alat baru untuk Kotlin.

Keputusan ini didasari oleh beberapa keunggulan Kotlin yang menjawab banyak "masalah" atau kekurangan Java:

*   **Lebih Ringkas dan Aman:** Kotlin mengurangi kode "boilerplate" (kode yang berulang dan harus ada) yang umum di Java, sehingga kode menjadi lebih pendek, lebih mudah dibaca, dan lebih sedikit potensi bug.
*   **Null Safety:** Salah satu sumber bug paling umum di Java adalah `NullPointerException`. Kotlin dirancang untuk menghilangkan bahaya ini dari tipe sistemnya.
*   **Interoperabilitas Penuh dengan Java:** Kotlin 100% dapat dioperasikan dengan Java. Artinya, Anda dapat memanggil kode Java dari Kotlin dan sebaliknya dalam proyek yang sama tanpa masalah. Ini memungkinkan migrasi bertahap dari proyek Java yang sudah ada.
*   **Fitur-Fitur Modern:** Kotlin memiliki fitur-fitur bahasa modern seperti extension functions, coroutines, dan smart casts yang membuat pengembangan menjadi lebih cepat dan lebih menyenangkan.

### **1.4.2 Perbandingan Singkat Kotlin vs. Java**

Mari kita lihat perbandingan sederhana untuk menampilkan "Hello, World!" di layar.

**Java:**
```java
// MainActivity.java
import android.os.Bundle;
import android.widget.TextView;
import androidx.appcompat.app.AppCompatActivity;

public class MainActivity extends AppCompatActivity {
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);
        
        TextView textView = findViewById(R.id.textView);
        textView.setText("Hello, World!");
    }
}
```

**Kotlin:**
```kotlin
// MainActivity.kt
import android.os.Bundle
import android.widget.TextView
import androidx.appcompat.app.AppCompatActivity

class MainActivity : AppCompatActivity() {
    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        setContentView(R.layout.activity_main)
        
        val textView: TextView = findViewById(R.id.textView)
        textView.text = "Hello, World!"
    }
}
```
Perbedaan kecil terlihat:
*   Tidak perlu titik koma (`;`) di Kotlin.
*   Deklarasi variabel menggunakan `val` (immutable) atau `var` (mutable).
*   Menggunakan `text` sebagai *property accessor* bukan `setText()` method (Kotlin menyediakan *getter* dan *setter* otomatis untuk properti Java).
*   `Bundle?` menunjukkan bahwa `Bundle` bisa bernilai `null`.

### **1.4.3 Fitur Utama Kotlin**

Beberapa fitur unggulan Kotlin yang sangat bermanfaat dalam pengembangan Android:

*   **Null Safety:** Kotlin membedakan antara tipe yang bisa null (`String?`) dan yang tidak bisa null (`String`). Kompiler akan memaksa Anda untuk menangani kemungkinan nilai null sebelum Anda bisa mengakses properti atau metode dari sebuah objek. Ini secara drastis mengurangi `NullPointerException`.
    ```kotlin
    var name: String = "Android" // Tidak boleh null
    // name = null // Ini akan menyebabkan error kompilasi

    var nickname: String? = "Dev" // Boleh null
    nickname = null // Ini diperbolehkan

    // Untuk mengakses panjang nickname, kita harus periksa null terlebih dahulu
    val length = nickname?.length // Aman, akan menghasilkan null jika nickname null
    // atau
    val length2 = nickname!!.length // Berbahaya, akan thrown NPE jika nickname null
    ```

*   **Extension Functions:** Fitur ini memungkinkan Anda untuk menambahkan fungsi baru ke kelas yang sudah ada tanpa harus mewarisi (inherit) dari kelas tersebut. Ini sangat berguna untuk membuat kode yang lebih bersih dan mudah dibaca.
    ```kotlin
    // Menambahkan fungsi showToast ke kelas Context
    fun Context.showToast(message: String) {
        Toast.makeText(this, message, Toast.LENGTH_SHORT).show()
    }

    // Di dalam Activity, kita bisa langsung memanggilnya
    showToast("Hello from extension function!")
    ```

*   **Coroutines:** Coroutines adalah cara Kotlin untuk menangani pemrograman asinkron dengan mudah. Mereka memungkinkan Anda untuk menulis kode asinkron yang terlihat seperti kode sinkron, menghindari "callback hell". Coroutines sangat efisien untuk tugas-tugas jangka panjang seperti panggilan jaringan atau operasi database tanpa memblokir *thread* UI, sehingga aplikasi tetap responsif.
    ```kotlin
    // Contoh sederhana menggunakan coroutine
    lifecycleScope.launch {
        // Kode ini berjalan di background thread
        val result = withContext(Dispatchers.IO) {
            // Lakukan operasi jaringan atau database di sini
            fetchDataFromNetwork()
        }
        // Kembali ke UI thread untuk memperbarui UI
        textView.text = result
    }
    ```

## **1.5 Pengenalan Android Studio**

### **1.5.1 Android Studio sebagai IDE Resmi**

Android Studio adalah Integrated Development Environment (IDE) resmi yang dikembangkan oleh Google secara khusus untuk pengembangan aplikasi Android. IDE ini berbasis pada IntelliJ IDEA, sebuah IDE Java yang populer dan kuat dari JetBrains. Android Studio menyediakan semua alat yang diperlukan untuk mulai mengembangkan, men-debug, menguji, dan mendistribusikan aplikasi Android dalam satu paket terintegrasi.

Menggunakan IDE resmi sangat penting karena Android Studio dioptimalkan untuk alur kerja pengembangan Android. Ia hadir dengan template proyek, sistem build yang canggih (Gradle), emulator yang cepat, dan alat-alat analisis performa yang mendalam.

### **1.5.2 Fitur Utama Android Studio**

Beberapa fitur kunci yang menjadikan Android Studio sebagai IDE yang powerful:

*   **Layout Editor:** Sebuah editor visual WYSIWYG (What You See Is What You Get) yang memungkinkan Anda untuk merancang antarmuka pengguna dengan cara *drag-and-drop* komponen-komponen UI. Anda juga dapat langsung mengedit XML-nya dan melihat perubahannya secara real-time.
*   **Emulator:** Android Virtual Device (AVD) atau Emulator memungkinkan Anda untuk menjalankan dan menguji aplikasi Anda pada berbagai konfigurasi perangkat Android (ukuran layar, versi OS, hardware) langsung dari komputer Anda, tanpa perlu perangkat fisik.
*   **Logcat:** Ini adalah jendela log sistem Android. Logcat sangat penting untuk *debugging* karena menampilkan pesan log dari sistem dan aplikasi Anda, termasuk error, warning, dan informasi yang Anda cetak sendiri.
*   **Intelligent Code Editor:** Editor kode Android Studio mendukung penulisan kode Kotlin dan Java dengan fitur seperti *code completion* (saran kode), analisis kode secara real-time, dan refactoring yang canggih.
*   **APK Analyzer:** Alat untuk memeriksa file APK (hasil build aplikasi) Anda. Anda dapat melihat ukuran setiap komponen (kode, resources, library) untuk mengidentifikasi apa yang membuat ukuran aplikasi Anda besar.
*   **Firebase Integration:** Integrasi yang mudah dengan layanan backend Google, Firebase, untuk fitur seperti autentikasi, database real-time, analitik, dan lainnya.

### **1.5.3 Struktur Proyek Android**

Saat Anda membuat proyek baru di Android Studio, Anda akan dihadapkan pada struktur file dan folder yang terorganisir. Memahami struktur ini adalah langkah pertama yang penting. Dalam tampilan "Project" > "Android", struktur utamanya adalah sebagai berikut:

*   **`manifests/`**: Folder ini berisi file `AndroidManifest.xml`. File ini adalah "kartu identitas" aplikasi Anda. Ia mendeklarasikan nama paket, komponen aplikasi (Activities, Services, dll), izin (permissions) yang dibutuhkan (misalnya akses internet), dan metadata lainnya.
*   **`java/`**: Folder ini berisi semua kode sumber Kotlin atau Java Anda. Struktur foldernya mengikuti nama paket yang Anda tentukan saat membuat proyek (misalnya `com.example.myapp`). Di sinilah Anda akan menulis logika aplikasi, seperti kelas `MainActivity.kt`.
*   **`res/`**: Folder ini berisi semua *resource* non-kode aplikasi Anda.
    *   `drawable/`: Berisi file gambar (PNG, JPG, XML) yang digunakan dalam aplikasi.
    *   `layout/`: Berisi file XML yang mendefinisikan antarmuka pengguna untuk setiap Activity.
    *   `mipmap/`: Berbagai versi ikon aplikasi Anda untuk berbagai kepadatan layar.
    *   `values/`: Berisi file XML untuk berbagai nilai, seperti `strings.xml` (untuk teks), `colors.xml` (untuk warna), dan `themes.xml` (untuk tema aplikasi).
*   **`Gradle Scripts/`:** Menampilkan file konfigurasi build sistem Gradle. File `build.gradle (Module: app)` adalah yang paling sering Anda edit untuk menambahkan *dependencies* (library eksternal), mengatur versi SDK, dan mengkonfigurasi opsi build lainnya.

## **1.6 Membuat Project Android Pertama**

Mari kita buat aplikasi "Hello World" pertama kita. Ini adalah langkah-langkah fundamental yang akan Anda lakukan di awal setiap proyek.

1.  **Buka Android Studio** dan pilih **"New Project"**.
2.  **Pilih Template**: Anda akan diminta untuk memilih template. Untuk pemula, pilih **"Empty Views Activity"** dan klik **Next**.
3.  **Konfigurasi Proyek**: Isi detail proyek Anda:
    *   **Name**: Nama aplikasi Anda, misalnya `HelloWorldApp`.
    *   **Package name**: Pengidentifikasi unik untuk aplikasi Anda, biasanya dalam format `com.nama_perusahaan.nama_aplikasi`. Misalnya `com.example.helloworldapp`.
    *   **Save location**: Folder di mana proyek Anda akan disimpan.
    *   **Language**: Pilih **Kotlin**.
    *   **Minimum SDK**: Pilih tingkat API Android minimum yang dapat dijalankan oleh aplikasi Anda. Android Studio akan menunjukkan persentase perangkat yang akan didukung. Untuk saat ini, Anda bisa menggunakan rekomendasi default.
    *   Klik **Finish**.
4.  **Tunggu Proses Sinkronisasi**: Android Studio akan menyiapkan proyek Anda dan mengunduh dependensi yang diperlukan. Proses ini mungkin memakan waktu beberapa menik. Tunggu hingga proses selesai.
5.  **Jelajahi Kode**: Setelah selesai, Anda akan melihat beberapa file terbuka. Fokus pada dua file utama:
    *   `MainActivity.kt` (di dalam folder `java`): Ini adalah file Kotlin untuk Activity utama Anda.
    *   `activity_main.xml` (di dalam folder `res/layout`): Ini adalah file XML untuk layout Activity utama Anda.

Secara default, template "Empty Views Activity" sudah menyertakan sebuah `TextView` dengan teks "Hello World!". Mari kita lihat bagaimana cara memodifikasinya.

**File `activity_main.xml`:**
```xml
<?xml version="1.0" encoding="utf-8"?>
<androidx.constraintlayout.widget.ConstraintLayout xmlns:android="http://schemas.android.com/apk/res/android"
    xmlns:app="http://schemas.android.com/apk/res-auto"
    xmlns:tools="http://schemas.android.com/tools"
    android:layout_width="match_parent"
    android:layout_height="match_parent"
    tools:context=".MainActivity">

    <TextView
        android:id="@+id/textView"
        android:layout_width="wrap_content"
        android:layout_height="wrap_content"
        android:text="Hello World!"
        app:layout_constraintBottom_toBottomOf="parent"
        app:layout_constraintEnd_toEndOf="parent"
        app:layout_constraintStart_toStartOf="parent"
        app:layout_constraintTop_toTopOf="parent" />

</androidx.constraintlayout.widget.ConstraintLayout>
```
Perhatikan atribut `android:id="@+id/textView"`. Ini adalah ID unik yang memungkinkan kita merujuk ke `TextView` ini dari kode Kotlin.

**File `MainActivity.kt`:**
```kotlin
package com.example.helloworldapp

import androidx.appcompat.app.AppCompatActivity
import android.os.Bundle

class MainActivity : AppCompatActivity() {
    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        setContentView(R.layout.activity_main)
    }
}
```
Sekarang, mari kita ubah teksnya secara dinamis dari kode Kotlin. Tambahkan baris berikut di dalam fungsi `onCreate`:

```kotlin
package com.example.helloworldapp

import androidx.appcompat.app.AppCompatActivity
import android.os.Bundle
import android.widget.TextView // Impor kelas TextView

class MainActivity : AppCompatActivity() {
    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        setContentView(R.layout.activity_main)

        // Temukan TextView berdasarkan ID-nya
        val helloTextView: TextView = findViewById(R.id.textView)
        
        // Ubah teksnya
        helloTextView.text = "Selamat Datang di Pemrograman Android!"
    }
}
```

6.  **Jalankan Aplikasi**: Klik tombol hijau **Run 'app'** di toolbar, atau tekan `Shift + F10`. Pilih emulator yang telah Anda buat atau hubungkan perangkat Android fisik Anda (dengan USB Debugging diaktifkan). Aplikasi akan di-*build*, diinstal, dan dijalankan. Anda akan melihat teks "Selamat Datang di Pemrograman Android!" di tengah layar.

## **1.7 Kesimpulan**

Bab ini telah memberikan fondasi dasar untuk memulai perjalanan Anda dalam dunia pemrograman mobile Android. Kita telah mempelajari tentang sejarah dan dominasi Android di pasar global, memahami konsep dasar dan karakteristik unik dari aplikasi mobile, dan menyelami arsitektur serta komponen-komponen inti yang membentuk sebuah aplikasi Android.

Kita juga diperkenalkan pada Kotlin, bahasa pemrograman modern yang kini menjadi standar dalam pengembangan Android, serta fitur-fitur unggulannya seperti *null safety* dan *coroutines* yang membuat pengembangan lebih aman dan efisien. Terakhir, kita menyiapkan lingkungan pengembangan kita dengan Android Studio dan berhasil membuat, memodifikasi, serta menjalankan aplikasi "Hello World" pertama kita.

Pemahaman konseptual ini adalah batu loncatan yang sangat penting. Dengan fondasi yang kuat ini, Anda siap untuk melangkah ke bab-bab selanjutnya, di mana kita akan mendalami sintaks dasar Kotlin, mempelajari cara membuat tata letak (layout) yang lebih kompleks dan interaktif, dan mulai membangun aplikasi yang lebih bermakna.

---

## **Latihan**

**Tujuan:** Menerapkan langkah-langkah yang telah dipelajari untuk membuat aplikasi Android sederhana.

**Instruksi:**

1.  Buat proyek Android baru di Android Studio dengan nama **"LatihanKu"**.
2.  Pilih template **"Empty Views Activity"** dan pastikan bahasa yang dipilih adalah **Kotlin**.
3.  Pada file layout `activity_main.xml`, ubah ID dari `TextView` default menjadi `@+id/greetingTextView`.
4.  Pada file `MainActivity.kt`, di dalam fungsi `onCreate`, tulis kode Kotlin untuk:
    *   Mendapatkan referensi ke `greetingTextView`.
    *   Mengubah teks pada `greetingTextView` menjadi: **"Halo, [Nama Lengkap Anda]! Selamat belajar Android."** (Ganti `[Nama Lengkap Anda]` dengan nama Anda sendiri).
5.  Jalankan aplikasi pada emulator atau perangkat fisik Anda.
6.  **Tantangan Tambahan (Opsional):** Coba ubah warna teks dan ukuran font dari `TextView` tersebut melalui file `activity_main.xml` menggunakan atribut `android:textColor` dan `android:textSize`.