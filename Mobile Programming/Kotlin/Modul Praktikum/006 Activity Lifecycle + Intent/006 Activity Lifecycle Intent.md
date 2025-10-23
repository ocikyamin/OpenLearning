## **BAB 6: ACTIVITY LIFECYCLE + INTENT**

### **Tujuan Pembelajaran**

Setelah mempelajari bab ini, mahasiswa diharapkan mampu:
1.  Memahami siklus hidup (lifecycle) dari sebuah Activity dan setiap tahapannya.
2.  Menjelaskan kapan setiap metode callback lifecycle dipanggil.
3.  Memahami konsep Intent untuk navigasi antar Activity.
4.  Mengimplementasikan Intent Explicit untuk berpindah Activity dan mengirim data.
5.  Mengimplementasikan Intent Implicit untuk memanfaatkan aplikasi lain di perangkat.

---

### **6.1 Konsep Activity Lifecycle**

**Activity** adalah salah satu komponen fundamental dalam aplikasi Android yang menyajikan satu layar dengan antarmuka pengguna. Selama hidupnya, sebuah Activity akan melalui beberapa keadaan (states). Transisi antar keadaan ini diatur oleh **Activity Lifecycle**, yang dikelola oleh sistem operasi Android.

Memahami lifecycle sangat penting untuk mengelola sumber daya dengan baik dan mencegah crash (misalnya, mencoba mengakses komponen yang sudah tidak ada).

**Diagram Activity Lifecycle:**
<img src="activity_lifecycle.png">

**Penjelasan Metode Callback:**

*   `onCreate()`: Dipanggil saat Activity pertama kali dibuat. Di sinilah kita melakukan inisialisasi satu kali, seperti `setContentView()`, membuat daftar data, dan menghubungkan variabel dengan View di layout.
*   `onStart()`: Dipanggil ketika Activity akan terlihat oleh pengguna, tetapi belum interaktif.
*   `onResume()`: Dipanggil ketika Activity berada di latar depan (foreground) dan siap menerima input dari pengguna. Activity berada di state "Running".
*   `onPause()`: Dipanggil ketika Activity akan digantikan oleh Activity lain (misalnya dialog muncul atau Activity lain masuk ke latar depan). Di sini kita harus menyimpan data atau state yang belum disimpan, dan menghentikan animasi atau proses yang memakan CPU.
*   `onStop()`: Dipanggil ketika Activity tidak lagi terlihat oleh pengguna. Ini terjadi jika pengguna beralih ke Activity lain atau menekan tombol home.
*   `onDestroy()`: Dipanggil sebelum Activity dihancurkan oleh sistem. Ini adalah panggilan terakhir yang diterima Activity. Gunakan untuk membersihkan semua sumber daya yang belum dibersihkan.
*   `onRestart()`: Dipanggil sebelum `onStart()` ketika Activity yang sudah dihentikan (`onStop`) akan ditampilkan kembali kepada pengguna.

### **6.2 Konsep Intent**

**Intent** adalah objek pesan yang dapat digunakan untuk meminta aksi dari komponen aplikasi lain. Meskipun Intent memfasilitasi komunikasi antar komponen dengan berbagai cara, ada tiga kasus penggunaan utamanya:

1.  **Memulai sebuah Activity**: Untuk memulai layar baru.
2.  **Memulai sebuah Service**: Untuk memulai operasi di latar belakang.
3.  **Mengirimkan Broadcast**: Untuk mengkomunikasikan bahwa suatu peristiwa telah terjadi.

Ada dua jenis Intent:

*   **Intent Explicit**: Menentukan komponen target secara spesifik (misalnya, `com.example.DetailActivity`). Digunakan untuk komunikasi internal dalam aplikasi Anda sendiri.
*   **Intent Implicit**: Tidak menentukan komponen target, tetapi mendeskripsikan aksi umum yang akan dilakukan (misalnya, "buka halaman web" atau "tampilkan peta"). Sistem Android akan menemukan aplikasi yang dapat menangani aksi tersebut.

### **6.3 Implementasi Praktik: Mengirim Data Antar Activity**

Kita akan membuat dua Activity:
1.  `FormActivity`: Berisi form untuk memasukkan nama dan umur.
2.  `ResultActivity`: Menampilkan data yang dikirim dari `FormActivity`.

**Langkah 0: Buat Project Baru**
pada layout `main_form.xml`, tambahkan 2 button dengan text `Intent Explicit` dan `Intent Implicit` 
```xml

    <Button
        android:layout_marginTop="120dp"
        android:id="@+id/btn_mulai"
        android:layout_width="match_parent"
        android:layout_height="wrap_content"
        android:text="Intent Explicit"
        android:textSize="30dp"
        app:layout_constraintTop_toTopOf="@+id/main"
        />
    <Button
        android:layout_marginTop="120dp"
        android:id="@+id/btn_browser"
        android:layout_width="match_parent"
        android:layout_height="wrap_content"
        android:text="Intent Implicit"
        android:textSize="30dp"
       android:backgroundTint="@color/black"
        app:layout_constraintTop_toTopOf="@+id/btn_mulai"
        />

```
**Langkah 1: Buat Layout `FormActivity` (`activity_form.xml`)**

```xml

<!-- activity_form.xml -->
    <TextView
        android:layout_width="match_parent"
        android:layout_height="wrap_content"
        android:text="Form Biodata"
        android:textAlignment="center"
        android:layout_marginTop="30dp"
        android:textSize="30dp"
        android:id="@+id/judul"
        app:layout_constraintTop_toTopOf="@+id/main"
        />

    <com.google.android.material.textfield.TextInputLayout
        android:layout_width="match_parent"
        android:layout_height="wrap_content"
        app:layout_constraintTop_toBottomOf="@id/judul"
        android:id="@+id/l_nama"
        >
        <EditText
            android:layout_width="match_parent"
            android:layout_height="wrap_content"
            android:hint="Nama"
            android:id="@+id/etNama"
            android:inputType="text"
            />
    </com.google.android.material.textfield.TextInputLayout>
    <com.google.android.material.textfield.TextInputLayout
        android:layout_width="match_parent"
        android:layout_height="wrap_content"
        app:layout_constraintTop_toBottomOf="@id/l_nama"
        android:id="@+id/l_umur"
        >
        <EditText
            android:layout_width="match_parent"
            android:layout_height="wrap_content"
            android:hint="Umur"
            android:inputType="number"
            android:id="@+id/etUmur"
            />
    </com.google.android.material.textfield.TextInputLayout>
    <com.google.android.material.textfield.TextInputLayout
        android:layout_width="match_parent"
        android:layout_height="wrap_content"
        app:layout_constraintTop_toBottomOf="@id/l_umur"
        android:id="@+id/l_agama"
        >
        <Spinner
            android:id="@+id/spAgama"
            android:layout_width="match_parent"
            android:layout_height="wrap_content"
            />

    </com.google.android.material.textfield.TextInputLayout>
    <Button
        android:layout_width="match_parent"
        android:layout_height="wrap_content"
        android:text="Kirim Data"
        android:id="@+id/btnKirim"
        app:layout_constraintTop_toBottomOf="@id/l_agama"
        />
    

```

**Langkah 2: Buat Layout `ResultActivity` (`activity_result.xml`)**

```xml

<!-- activity_result.xml -->

    <TextView
        android:layout_marginTop="40dp"
        app:layout_constraintTop_toTopOf="@id/main"
        android:layout_width="match_parent"
        android:layout_height="wrap_content"
        android:textSize="30dp"
        android:text="Data Diterima"
        android:id="@+id/tvResult"/>

```

**Langkah 3: Buat Activity Baru**

Klik kanan pada package -> New -> Activity -> Empty Views Activity, beri nama `ResultActivity`.

**Langkah 4: Logika di `FormActivity.kt` (Mengirim data)**

```kotlin

// FormActivity.kt
class FormActivity : AppCompatActivity() {
    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        enableEdgeToEdge()
        setContentView(R.layout.activity_form)
        // dapatka komponen inputan
        val etNama = findViewById<EditText>(R.id.etNama)
        val etUmur = findViewById<EditText>(R.id.etUmur)
        val spAgama = findViewById<Spinner>(R.id.spAgama)
        val btnKirim = findViewById<Button>(R.id.btnKirim)
        // Daftar agama untuk Spinner
        val daftarAgama = arrayOf("Islam", "Kristen", "Katolik", "Hindu", "Buddha", "Konghucu")

        val adapter = ArrayAdapter(
            this,
            android.R.layout.simple_spinner_item,
            daftarAgama
        )
        adapter.setDropDownViewResource(android.R.layout.simple_spinner_dropdown_item)
        spAgama.adapter = adapter

        btnKirim.setOnClickListener {
            // tampung inputan
            val nama = etNama.text.toString()
            val umur = etUmur.text.toString()
            val agama = spAgama.selectedItem.toString()
            // Membuat Explicit Intent

            val intent = Intent(this, ResultActivity::class.java)
            // Menambhakan data ke Intent
            intent.putExtra("EX_NAMA", nama)
            intent.putExtra("EX_UMUR", umur)
            intent.putExtra("EX_AGAMA", agama)
        //mulai activity /**/
            startActivity(intent)

        }
    }
}
```

**Langkah 5: Logika di `ResultActivity.kt` (Menerima data)**

```kotlin

// ResultActivity.kt
class ResultActivity : AppCompatActivity() {
    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        enableEdgeToEdge()
        setContentView(R.layout.activity_result)
        val tvResult = findViewById<TextView>(R.id.tvResult)
        // Menerima data dari intent
        val nama = intent.getStringExtra("EX_NAMA")
        val umur = intent.getStringExtra("EX_UMUR")
        val agama = intent.getStringExtra("EX_AGAMA")
        // Tampilkan hasil
        val hasil = """
            Nama  : $nama
            Umur  : $umur Tahun
            Agama : $agama
        """.trimIndent()
        tvResult.text = hasil
        
    }
}
```

**Langkah 6: Contoh Intent Implicit**

Tambahkan tombol di `MainAtivity` untuk membuka URL.

```kotlin

class MainActivity : AppCompatActivity() {
    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        enableEdgeToEdge()
        setContentView(R.layout.activity_main)
        val btnMulai = findViewById<Button>(R.id.btn_mulai)
        btnMulai.setOnClickListener {
            val inten = Intent(this, FormActivity::class.java)
            startActivity(inten)
        }

        // Open Browser
        val btnBrowser = findViewById<Button>(R.id.btn_browser)
        btnBrowser.setOnClickListener {
            val webpage = Uri.parse("https://github.com/ocikyamin/")
            val intent = Intent(Intent.ACTION_VIEW, webpage)
            try {
                startActivity(intent)
            } catch (e: ActivityNotFoundException) {
                Toast.makeText(this, "Tidak ada aplikasi untuk membuka web", Toast.LENGTH_SHORT).show()
            }

        }


    }
}
```

### **6.4 Studi Kasus Latihan Praktikum**

**Studi Kasus: Aplikasi Data Mahasiswa**

1.  Buat sebuah aplikasi dengan dua Activity: `InputMhsActivity` dan `ProfileMhsActivity`.
2.  Di `InputMhsActivity`, buat form dengan input: NIM, Nama, dan Jurusan (gunakan `Spinner` untuk pilihan: Teknik Informatika, Sistem Informasi, Manajemen).
3.  Saat tombol "Lihat Profile" ditekan, kirim semua data tersebut ke `ProfileMhsActivity`.
4.  Di `ProfileMhsActivity`, tampilkan semua data yang diterima dengan format yang rapi.
5.  Tambahkan juga sebuah tombol di `ProfileMhsActivity` yang menggunakan Intent Implicit untuk memanggil aplikasi telepon dengan nomor yang sudah ditentukan (misalnya nomor universitas).

---
