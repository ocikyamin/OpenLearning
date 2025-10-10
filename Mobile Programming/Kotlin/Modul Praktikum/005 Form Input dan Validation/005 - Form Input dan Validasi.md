
## **BAB 5: FORM INPUT & VALIDASI**

### **Tujuan Pembelajaran**

Setelah mempelajari bab ini, mahasiswa diharapkan mampu:
1.  Mendesain dan membangun form input yang kompleks dengan berbagai komponen UI.
2.  Memahami pentingnya validasi input dalam aplikasi.
3.  Mengimplementasikan berbagai jenis validasi (wajib isi, format, panjang karakter).
4.  Memberikan feedback visual yang jelas kepada pengguna saat input tidak valid menggunakan `setError()`.

---

### **5.1 Konsep Form Input dan Validasi**

**Form Input** adalah kumpulan komponen UI yang dirancang untuk mengumpulkan data dari pengguna. Contohnya adalah form registrasi, form login, atau form biodata. Dalam pengembangan aplikasi, form adalah elemen krusial untuk interaksi data.

**Validasi Input** adalah proses memeriksa data yang dimasukkan pengguna untuk memastikan data tersebut sesuai dengan aturan yang telah ditentukan sebelum data diproses lebih lanjut (misalnya, dikirim ke server atau disimpan di database).

**Mengapa Validasi Penting?**
*   **Integritas Data**: Memastikan data yang tersimpan atau dikirim adalah benar dan konsisten.
*   **Keamanan**: Mencegah input berbahaya (seperti SQL injection atau XSS).
*   **User Experience (UX)**: Memberikan panduan yang jelas kepada pengguna tentang bagaimana mengisi form dengan benar, mengurangi frustrasi.

### **5.2 Metode Validasi di Android**

Ada beberapa cara untuk memberikan feedback hasil validasi:
1.  **`Toast`**: Pesan singkat yang muncul sebentar di layar. Cocok untuk notifikasi umum.
2.  **`Snackbar`**: Mirip Toast, tetapi dapat ditampilkan di bagian bawah layar dan bisa memiliki aksi (seperti tombol "Tutup").
3.  **`setError()` pada `EditText`/`TextInputLayout`**: Cara yang paling direkomendasikan untuk validasi form. Metode ini akan menampilkan pesan error tepat di bawah komponen input yang bermasalah, memberikan konteks yang sangat jelas kepada pengguna. Penggunaan `TextInputLayout` dari Material Design library lebih disarankan karena memberikan tampilan error yang lebih baik dan fitur floating label.

### **5.3 Implementasi Praktik: Form Registrasi**

Kita akan membuat form registrasi dengan validasi untuk nama, email, password, dan konfirmasi password. Kita akan menggunakan `TextInputLayout` untuk mencapai hasil terbaik.

**Langkah 1: Tambahkan Dependensi Material Design**

Pastikan file `build.gradle.kts` (Module :app) Anda sudah memiliki dependensi berikut:
```kotlin

dependencies {
    // ... dependensi lainnya
    implementation("com.google.android.material:material:1.12.0") // Gunakan versi terbaru
}
```
Dan pastikan tema aplikasi Anda di `res/values/themes.xml` mewarisi dari tema Material Components, misalnya `Theme.Material3.DayNight`.

**Langkah 2: Membuat Layout (`activity_registration.xml`)**

```xml

<?xml version="1.0" encoding="utf-8"?>
<androidx.constraintlayout.widget.ConstraintLayout xmlns:android="http://schemas.android.com/apk/res/android"
    xmlns:app="http://schemas.android.com/apk/res-auto"
    xmlns:tools="http://schemas.android.com/tools"
    android:layout_width="match_parent"
    android:layout_height="match_parent"
    android:padding="16dp"
    tools:context=".RegistrationActivity">

    <TextView
        android:id="@+id/tvTitle"
        android:layout_width="wrap_content"
        android:layout_height="wrap_content"
        android:text="Buat Akun Baru"
        android:textSize="24sp"
        android:textStyle="bold"
        app:layout_constraintEnd_toEndOf="parent"
        app:layout_constraintStart_toStartOf="parent"
        app:layout_constraintTop_toTopOf="parent" />

    <com.google.android.material.textfield.TextInputLayout
        android:id="@+id/tilNama"
        android:layout_width="0dp"
        android:layout_height="wrap_content"
        android:layout_marginTop="24dp"
        android:hint="Nama Lengkap"
        app:layout_constraintEnd_toEndOf="parent"
        app:layout_constraintStart_toStartOf="parent"
        app:layout_constraintTop_toBottomOf="@id/tvTitle">

        <com.google.android.material.textfield.TextInputEditText
            android:id="@+id/etNama"
            android:layout_width="match_parent"
            android:layout_height="wrap_content"
            android:inputType="textPersonName" />
    </com.google.android.material.textfield.TextInputLayout>

    <com.google.android.material.textfield.TextInputLayout
        android:id="@+id/tilEmail"
        android:layout_width="0dp"
        android:layout_height="wrap_content"
        android:layout_marginTop="16dp"
        android:hint="Email"
        app:layout_constraintEnd_toEndOf="parent"
        app:layout_constraintStart_toStartOf="parent"
        app:layout_constraintTop_toBottomOf="@id/tilNama">

        <com.google.android.material.textfield.TextInputEditText
            android:id="@+id/etEmail"
            android:layout_width="match_parent"
            android:layout_height="wrap_content"
            android:inputType="textEmailAddress" />
    </com.google.android.material.textfield.TextInputLayout>

    <com.google.android.material.textfield.TextInputLayout
        android:id="@+id/tilPassword"
        android:layout_width="0dp"
        android:layout_height="wrap_content"
        android:layout_marginTop="16dp"
        android:hint="Password"
        app:passwordToggleEnabled="true"
        app:layout_constraintEnd_toEndOf="parent"
        app:layout_constraintStart_toStartOf="parent"
        app:layout_constraintTop_toBottomOf="@id/tilEmail">

        <com.google.android.material.textfield.TextInputEditText
            android:id="@+id/etPassword"
            android:layout_width="match_parent"
            android:layout_height="wrap_content"
            android:inputType="textPassword" />
    </com.google.android.material.textfield.TextInputLayout>

    <Button
        android:id="@+id/btnDaftar"
        android:layout_width="0dp"
        android:layout_height="wrap_content"
        android:layout_marginTop="32dp"
        android:text="DAFTAR"
        app:layout_constraintEnd_toEndOf="parent"
        app:layout_constraintStart_toStartOf="parent"
        app:layout_constraintTop_toBottomOf="@id/tilPassword" />

</androidx.constraintlayout.widget.ConstraintLayout>
```

**Langkah 3: Menulis Logika Validasi di Kotlin (`RegistrationActivity.kt`)**

```kotlin

package com.example.formvalidasi // Ganti dengan package name Anda

import androidx.appcompat.app.AppCompatActivity
import android.os.Bundle
import android.widget.Button
import android.widget.Toast
import com.google.android.material.textfield.TextInputEditText
import com.google.android.material.textfield.TextInputLayout

class RegistrationActivity : AppCompatActivity() {
    private lateinit var tilNama: TextInputLayout
    private lateinit var tilEmail: TextInputLayout
    private lateinit var tilPassword: TextInputLayout
    private lateinit var etNama: TextInputEditText
    private lateinit var etEmail: TextInputEditText
    private lateinit var etPassword: TextInputEditText
    private lateinit var btnDaftar: Button

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        setContentView(R.layout.activity_registration)

        // Inisialisasi View
        tilNama = findViewById(R.id.tilNama)
        tilEmail = findViewById(R.id.tilEmail)
        tilPassword = findViewById(R.id.tilPassword)
        etNama = findViewById(R.id.etNama)
        etEmail = findViewById(R.id.etEmail)
        etPassword = findViewById(R.id.etPassword)
        btnDaftar = findViewById(R.id.btnDaftar)

        btnDaftar.setOnClickListener {
            if (validateForm()) {
                // Jika semua validasi berhasil
                Toast.makeText(this, "Registrasi Berhasil!", Toast.LENGTH_SHORT).show()
                // Di sini biasanya akan ada proses lanjutan, seperti mengirim data ke server
            }
        }
    }

    private fun validateForm(): Boolean {
        val name = etNama.text.toString().trim()
        val email = etEmail.text.toString().trim()
        val password = etPassword.text.toString().trim()

        // Reset error
        tilNama.error = null
        tilEmail.error = null
        tilPassword.error = null

        var isValid = true

        // Validasi Nama
        if (name.isEmpty()) {
            tilNama.error = "Nama tidak boleh kosong"
            isValid = false
        }

        // Validasi Email
        if (email.isEmpty()) {
            tilEmail.error = "Email tidak boleh kosong"
            isValid = false
        } else if (!android.util.Patterns.EMAIL_ADDRESS.matcher(email).matches()) {
            tilEmail.error = "Format email tidak valid"
            isValid = false
        }

        // Validasi Password
        if (password.isEmpty()) {
            tilPassword.error = "Password tidak boleh kosong"
            isValid = false
        } else if (password.length < 8) {
            tilPassword.error = "Password minimal 8 karakter"
            isValid = false
        }

        return isValid
    }
}
```

### **5.4 Studi Kasus Latihan Praktikum**

**Studi Kasus: Form Login dengan Validasi**

Buatlah sebuah Activity baru untuk form login dengan ketentuan berikut:
1.  **Input**: Email dan Password.
2.  **Validasi**:
    *   Email tidak boleh kosong dan harus format email yang valid.
    *   Password tidak boleh kosong.
3.  **Logika**:
    *   Jika email = "admin@example.com" dan password = "password123", tampilkan `Toast` "Login Berhasil!".
    *   Jika salah, tampilkan `Toast` "Email atau Password salah!".
4.  Gunakan `TextInputLayout` untuk menampilkan pesan error.

---
