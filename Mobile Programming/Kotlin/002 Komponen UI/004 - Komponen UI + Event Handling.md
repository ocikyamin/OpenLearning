
# 📘 004 - Komponen UI + Event Handling

## 🎯 Tujuan Pembelajaran

Setelah mengikuti praktikum ini, mahasiswa diharapkan mampu:

1. Mengenali komponen UI dasar Android (TextView, EditText, Button, dll).
2. Mengimplementasikan event handling pada komponen UI.
3. Membangun aplikasi sederhana berbasis input/output dengan validasi.

---

## 1. Konsep Dasar Komponen UI

**Komponen UI (User Interface)** adalah elemen grafis yang ditampilkan dalam aplikasi Android untuk berinteraksi dengan pengguna.

Beberapa komponen UI dasar:

* **TextView** → Menampilkan teks statis.
* **EditText** → Input teks dari pengguna.
* **Button** → Menjalankan aksi saat ditekan.
* **ImageView** → Menampilkan gambar.
* **CheckBox** → Pilihan jamak (boleh lebih dari satu).
* **RadioButton (RadioGroup)** → Pilihan tunggal.
* **Spinner** → Dropdown pilihan.

Semua komponen ini ditempatkan di dalam **Layout** (LinearLayout, ConstraintLayout, dll).

---

## 2. Konsep Dasar Event Handling

**Event** adalah aksi yang dilakukan oleh pengguna (misalnya klik tombol, mengetik teks, memilih item).
**Event Handling** adalah cara aplikasi merespons aksi tersebut.

Metode umum di Android:

* `setOnClickListener` → menangani klik pada Button, ImageView, dll.
* `setOnCheckedChangeListener` → menangani perubahan pada CheckBox/RadioButton.
* `setOnItemSelectedListener` → menangani pilihan pada Spinner.
* `addTextChangedListener` → menangani input teks di EditText.

---

## 3. Contoh Implementasi Komponen UI

### 3.1 TextView & Button

#### XML (activity_main.xml)

```xml

<LinearLayout 
    xmlns:android="http://schemas.android.com/apk/res/android"
    android:orientation="vertical"
    android:padding="16dp"
    android:layout_width="match_parent"
    android:layout_height="match_parent">

    <TextView
        android:id="@+id/tvMessage"
        android:text="Halo, Android!"
        android:textSize="18sp"
        android:layout_width="wrap_content"
        android:layout_height="wrap_content"/>

    <Button
        android:id="@+id/btnChange"
        android:text="Ubah Teks"
        android:layout_width="wrap_content"
        android:layout_height="wrap_content"/>

</LinearLayout>
```

#### Kotlin (MainActivity.kt)

```kotlin
class MainActivity : AppCompatActivity() {
    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        setContentView(R.layout.activity_main)

        val tvMessage: TextView = findViewById(R.id.tvMessage)
        val btnChange: Button = findViewById(R.id.btnChange)

        btnChange.setOnClickListener {
            tvMessage.text = "Teks berhasil diubah!"
        }
    }
}
```

---

### 3.2 EditText + Button + TextView (Form Input)

#### XML

```xml

<LinearLayout 
    xmlns:android="http://schemas.android.com/apk/res/android"
    android:orientation="vertical"
    android:padding="16dp"
    android:layout_width="match_parent"
    android:layout_height="match_parent">

    <EditText
        android:id="@+id/etName"
        android:hint="Masukkan nama Anda"
        android:layout_width="match_parent"
        android:layout_height="wrap_content"/>

    <Button
        android:id="@+id/btnSubmit"
        android:text="Tampilkan"
        android:layout_width="wrap_content"
        android:layout_height="wrap_content"/>

    <TextView
        android:id="@+id/tvResult"
        android:text="Hasil input akan tampil di sini"
        android:layout_width="wrap_content"
        android:layout_height="wrap_content"/>

</LinearLayout>
```

#### Kotlin

```kotlin
class MainActivity : AppCompatActivity() {
    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        setContentView(R.layout.activity_main)

        val etName: EditText = findViewById(R.id.etName)
        val btnSubmit: Button = findViewById(R.id.btnSubmit)
        val tvResult: TextView = findViewById(R.id.tvResult)

        btnSubmit.setOnClickListener {
            val name = etName.text.toString()
            if (name.isEmpty()) {
                tvResult.text = "Nama tidak boleh kosong!"
            } else {
                tvResult.text = "Halo, $name!"
            }
        }
    }
}
```

---

### 3.3 RadioButton & CheckBox

#### XML

```xml

<RadioGroup
    android:id="@+id/rgGender"
    android:orientation="horizontal"
    android:layout_width="wrap_content"
    android:layout_height="wrap_content">
    <RadioButton android:id="@+id/rbMale" android:text="Laki-laki"/>
    <RadioButton android:id="@+id/rbFemale" android:text="Perempuan"/>
</RadioGroup>

<CheckBox
    android:id="@+id/cbSport"
    android:text="Olahraga"/>
<CheckBox
    android:id="@+id/cbMusic"
    android:text="Musik"/>
```

#### Kotlin

```kotlin
val rgGender: RadioGroup = findViewById(R.id.rgGender)
val cbSport: CheckBox = findViewById(R.id.cbSport)
val cbMusic: CheckBox = findViewById(R.id.cbMusic)

val btnCheck: Button = findViewById(R.id.btnCheck)
val tvResult: TextView = findViewById(R.id.tvResult)

btnCheck.setOnClickListener {
    val genderId = rgGender.checkedRadioButtonId
    val gender = if (genderId != -1) findViewById<RadioButton>(genderId).text else "Belum memilih"

    val hobbies = mutableListOf<String>()
    if (cbSport.isChecked) hobbies.add("Olahraga")
    if (cbMusic.isChecked) hobbies.add("Musik")

    tvResult.text = "Gender: $gender\nHobi: ${hobbies.joinToString()}"
}
```

---

### 3.4 Spinner (Dropdown)

#### XML

```xml

<Spinner
    android:id="@+id/spCity"
    android:layout_width="wrap_content"
    android:layout_height="wrap_content"/>
```

#### Kotlin

```kotlin
val spCity: Spinner = findViewById(R.id.spCity)
val tvResult: TextView = findViewById(R.id.tvResult)

val cities = arrayOf("Jakarta", "Bandung", "Surabaya")
val adapter = ArrayAdapter(this, android.R.layout.simple_spinner_item, cities)
adapter.setDropDownViewResource(android.R.layout.simple_spinner_dropdown_item)
spCity.adapter = adapter

spCity.onItemSelectedListener = object : AdapterView.OnItemSelectedListener {
    override fun onItemSelected(parent: AdapterView<*>, view: View?, position: Int, id: Long) {
        tvResult.text = "Kota dipilih: ${cities[position]}"
    }
    override fun onNothingSelected(parent: AdapterView<*>) {}
}
```

---

## 4. Studi Kasus Praktikum

### 🚀 Project Mini: Aplikasi Form Biodata

Buat aplikasi dengan komponen berikut:

* Input Nama (EditText).
* Pilih Gender (RadioGroup).
* Pilih Hobi (CheckBox).
* Pilih Kota Asal (Spinner).
* Tombol “Submit”.
* Output ditampilkan di TextView (berisi data biodata).

**Kriteria Praktikum:**

* Jika field nama kosong, tampilkan pesan error.
* Jika user belum memilih gender, tampilkan pesan peringatan.
* Data akhir ditampilkan dalam format yang rapi.

---

## 5. Tugas Individu

1. Buat aplikasi **kalkulator sederhana** dengan:

   * 2 EditText (angka 1, angka 2).
   * 4 Button (Tambah, Kurang, Kali, Bagi).
   * TextView untuk hasil.

2. Buat aplikasi **form login sederhana** dengan:

   * EditText untuk username & password.
   * Tombol Login.
   * Jika username & password benar (misalnya admin/123), tampilkan “Login sukses”.
   * Jika salah, tampilkan “Login gagal”.

---

## 6. Ringkasan

* Komponen UI digunakan untuk membuat tampilan interaktif.
* Event handling memungkinkan aplikasi merespons aksi pengguna.
* Kombinasi komponen + event dapat membangun aplikasi sederhana seperti form, kalkulator, dan biodata.
