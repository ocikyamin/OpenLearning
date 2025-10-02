
# **BAB 3: MENGGUNAKAN 5 JENIS LAYOUT DI ANDROID STUDIO**

## **Daftar Isi Bab 3**

3.1 Pendahuluan: Pentingnya Layout dalam Pengembangan Aplikasi Android
3.2 Memahami Layout dan Fungsinya pada Aplikasi Android
    3.2.1 Konsep View dan ViewGroup
    3.2.2 Peran Layout dalam Mengatur Tata Letak Komponen UI
3.3 Langkah Awal Membuat Layout pada IDE Android Studio
    3.3.1 Membuka Project dan Membuat File Layout Baru
    3.3.2 Mengenal Design Editor dan Code Editor
3.4 5 Macam Layout pada Android Studio untuk Membuat Aplikasi
    3.4.1 Linear Layout
        3.4.1.1 Pengertian dan Konsep
        3.4.1.2 Atribut Penting: `orientation` dan `layout_weight`
        3.4.1.3 Kelebihan dan Kekurangan
        3.4.1.4 Contoh Kode dan Hasil Tampilan
        3.4.1.5 Contoh Kasus Praktikum: Membuat Form Login Sederhana
    3.4.2 Relative Layout
        3.4.2.1 Pengertian dan Konsep
        3.4.2.2 Atribut Penting: Posisi Relatif
        3.4.2.3 Kelebihan dan Kekurangan
        3.4.2.4 Contoh Kode dan Hasil Tampilan
        3.4.2.5 Contoh Kasus Praktikum: Membuat Tampilan Item dengan Ikon dan Teks
    3.4.3 Table Layout
        3.4.3.1 Pengertian dan Konsep
        3.4.3.2 Atribut Penting: `TableRow` dan `stretchColumns`
        3.4.3.3 Kelebihan dan Kekurangan
        3.4.3.4 Contoh Kode dan Hasil Tampilan
        3.4.3.5 Contoh Kasus Praktikum: Membuat Tampilan Kalkulator Sederhana
    3.4.4 Frame Layout
        3.4.4.1 Pengertian dan Konsep
        3.4.4.2 Atribut Penting: `layout_gravity`
        3.4.4.3 Kelebihan dan Kekurangan
        3.4.4.4 Contoh Kode dan Hasil Tampilan
        3.4.4.5 Contoh Kasus Praktikum: Membuat Splash Screen dengan Overlay
    3.4.5 Constraint Layout
        3.4.5.1 Pengertian dan Konsep
        3.4.5.2 Atribut Penting: Constraint, Bias, dan Guideline
        3.4.5.3 Kelebihan dan Kekurangan
        3.4.5.4 Contoh Kode dan Hasil Tampilan
        3.4.5.5 Contoh Kasus Praktikum: Membuat Tampilan Profil Pengguna
3.5 Menggabungkan Beberapa Layout (Nested Layout)
    3.5.1 Konsep Nested Layout
    3.5.2 Contoh Penggunaan dan Kapan Waktunya
3.6 Kesimpulan: Ringkasan Perbedaan dan Penggunaan Layout

---

### **3.1 Pendahuluan: Pentingnya Layout dalam Pengembangan Aplikasi Android**

Dalam pengembangan aplikasi mobile, antarmuka pengguna (User Interface - UI) adalah jembatan utama yang menghubungkan logika aplikasi dengan pengguna. Sebuah aplikasi dapat memiliki fitur yang sangat canggih di balik layar, tetapi tanpa UI yang intuitif, terstruktur, dan responsif, pengalaman pengguna (User Experience - UX) akan menjadi buruk dan aplikasi tersebut kemungkinan besar akan ditinggalkan.

Di sinilah peran krusial dari **Layout**. Layout dapat diibaratkan sebagai cetak biru (blueprint) arsitektur untuk UI sebuah aplikasi. Ia bertanggung jawab untuk mengatur bagaimana komponen-komponen visual seperti tombol, teks, gambar, dan input field disusun, diatur ukurannya, dan diposisikan pada layar. Pemilihan jenis layout yang tepat akan menentukan seberapa efisien proses pengembangan berjalan, seberapa fleksibel UI beradaptasi dengan berbagai ukuran layar (responsivitas), dan seberapa mudah kode tersebut dipelihara di masa mendatang.

Pada bab ini, kita akan mempelajari secara mendalam konsep layout di Android, mulai dari fondasi teoritis hingga penerapan praktis dari lima jenis layout fundamental yang sering digunakan: `LinearLayout`, `RelativeLayout`, `TableLayout`, `FrameLayout`, dan `ConstraintLayout`. Pemahaman yang solid terhadap kelima layout ini akan menjadi bekal dasar yang kuat untuk merancang antarmuka yang kompleks dan menarik.

### **3.2 Memahami Layout dan Fungsinya pada Aplikasi Android**

Sebelum kita menyelami jenis-jenis layout secara spesifik, penting untuk memahami dua konsep fundamental dalam sistem UI Android: `View` dan `ViewGroup`.

#### **3.2.1 Konsep View dan ViewGroup**

*   **View**: `View` adalah unit dasar pembangun UI di Android. Setiap elemen yang muncul di layar, seperti tombol (`Button`), label teks (`TextView`), kotak input (`EditText`), gambar (`ImageView`), hingga slider (`SeekBar`), adalah sebuah objek `View`. `View` bertanggung jawab untuk menggambar dirinya sendiri di layar dan menangani event interaksi dari pengguna (misalnya, saat tombol diklik).

*   **ViewGroup**: `ViewGroup` adalah subclass khusus dari `View` yang berfungsi sebagai wadah (container) invisible untuk `View` dan `ViewGroup` lainnya. `ViewGroup` bertanggung jawab untuk mengatur tata letak (layout) dari anak-anak (children) yang ada di dalamnya. Karena `ViewGroup` juga merupakan `View`, sebuah `ViewGroup` dapat berisi `ViewGroup` lain, menciptakan hierarki atau struktur pohon (tree structure) yang kompleks.

**Layout** pada dasarnya adalah sebuah `ViewGroup` yang menyediakan algoritma tertentu untuk mengatur posisi dan ukuran anak-anaknya. Setiap jenis layout memiliki aturan dan logika penempatan yang berbeda-beda.

#### **3.2.2 Peran Layout dalam Mengatur Tata Letak Komponen UI**

Layout berperan sebagai "manajer tata letak" yang menentukan:
1.  **Posisi**: Di mana sebuah komponen (`View`) akan ditempatkan relatif terhadap induknya (`ViewGroup`) atau relatif terhadap komponen saudaranya (sibling `View`).
2.  **Ukuran**: Seberapa besar sebuah komponen akan ditampilkan (lebar dan tinggi). Layout akan memproses atribut seperti `wrap_content` (ukuran mengikuti konten) atau `match_parent` (ukuran mengikuti induk).
3.  **Hierarki**: Layout memungkinkan pengelompokan komponen-komponen yang terkait secara logis ke dalam satu wadah, yang membuat struktur UI lebih terorganisir dan mudah dikelola.

UI di Android umumnya didefinisikan menggunakan file XML (eXtensible Markup Language) yang terletak di folder `res/layout`. Pendekatan deklaratif ini memisahkan antara logika tampilan (XML) dan logika program (Kotlin/Java), sehingga kode menjadi lebih bersih dan mudah dipelihara.

### **3.3 Langkah Awal Membuat Layout pada IDE Android Studio**

Android Studio menyediakan seperangkat alat yang powerful untuk merancang layout. Mari kita mulai dengan langkah-langkah dasar untuk membuat sebuah file layout baru.

#### **3.3.1 Membuka Project dan Membuat File Layout Baru**

1.  Buka project Android Anda di Android Studio.
2.  Pada panel **Project**, navigasikan ke `app -> res -> layout`. Folder ini berisi semua file XML layout untuk project Anda.
3.  Klik kanan pada folder `layout`, lalu pilih **New -> XML -> Layout XML File**.
4.  Akan muncul dialog baru. Berikan nama untuk file layout Anda, misalnya `contoh_layout.xml`. Nama file harus menggunakan huruf kecil dan underscore (`_`) sebagai pemisah.
5.  Pilih elemen **Root tag**. Secara default, ini biasanya `androidx.constraintlayout.widget.ConstraintLayout`. Anda bisa menggantinya dengan layout lain seperti `LinearLayout`, `RelativeLayout`, dll.
6.  Klik **Finish**. Android Studio akan membuat file XML baru dan membukanya di editor.

#### **3.3.2 Mengenal Design Editor dan Code Editor**

Saat file layout terbuka, Anda akan melihat dua mode editor di bagian bawah jendela: **Design** dan **Code**.

*   **Design Editor**: Ini adalah editor visual (WYSIWYG - What You See Is What You Get). Anda dapat langsung menyeret komponen (`View`) dari panel **Palette** ke layar desain, mengatur posisinya dengan mouse, dan mengubah propertinya melalui panel **Attributes**. Mode ini sangat berguna untuk visualisasi cepat dan prototyping.
*   **Code Editor**: Mode ini menampilkan kode XML mentah dari layout Anda. Di sinilah Anda memiliki kontrol penuh dan presisi tertinggi atas struktur dan atribut setiap elemen. Android Studio menyediakan fitur *autocomplete* dan *preview* yang sangat membantu saat menulis kode. Memahami kode XML adalah keterampilan esensial karena tidak semua properti dapat diakses melalui Design Editor, dan bekerja dengan kode seringkali lebih cepat untuk pengembang yang berpengalaman.

Kedua mode ini saling melengkapi. Praktik terbaik adalah menggunakan keduanya: gunakan **Design Editor** untuk perancangan awal dan penyesuaian kasar, lalu gunakan **Code Editor** untuk menyempurnakan detail dan memahami struktur yang dihasilkan.

### **3.4 5 Macam Layout pada Android Studio untuk Membuat Aplikasi**

Kita sekarang akan membahas kelima jenis layout yang paling umum digunakan, lengkap dengan teori, contoh kode, dan studi kasus praktis.

---

#### **3.4.1 Linear Layout**

##### **3.4.1.1 Pengertian dan Konsep**

`LinearLayout` adalah salah satu layout paling sederhana dan paling sering digunakan, terutama oleh pemula. Sesuai namanya, `LinearLayout` mengatur anak-anaknya dalam satu garis lurus, baik secara **vertikal** (atas ke bawah) maupun **horizontal** (kiri ke kanan). Setiap anak akan ditampilkan satu per satu sesuai urutannya di dalam file XML.

##### **3.4.1.2 Atribut Penting: `orientation` dan `layout_weight`**

*   `android:orientation`: Atribut wajib ini menentukan arah susunan. Nilainya bisa `vertical` atau `horizontal`.
   ```xml

    <LinearLayout
        android:orientation="vertical">
        <!-- Anak-anak akan tersusun vertikal -->
    </LinearLayout>
    ```

*   `android:layout_weight`: Atribut ini sangat powerful dan sering membingungkan pemula. Ia menentukan seberapa besar ruang "ekstra" yang harus dialokasikan kepada sebuah `View` dalam `LinearLayout`. Konsepnya mirip dengan rasio atau persentase.
    *   `layout_weight` hanya bekerja jika `View` tersebut memiliki `layout_width` atau `layout_height` (tergantung orientasi) yang diset ke `0dp`. Ini memberi sinyal kepada `LinearLayout` untuk mengabaikan ukuran intrinsik `View` dan hanya fokus pada pembagian ruang berdasarkan `weight`.
    *   Contoh: Jika dua `View` memiliki `layout_weight` masing-masing `1` dan `2`, maka ruang ekstra akan dibagi dengan rasio 1:2. `View` kedua akan mendapatkan dua kali lipat ruang ekstra dibandingkan `View` pertama.

##### **3.4.1.3 Kelebihan dan Kekurangan**

*   **Kelebihan**:
    *   **Sangat Sederhana**: Mudah dipahami dan digunakan untuk membuat tata letak dasar seperti daftar atau form.
    *   **Performa Cepat**: Algoritmanya sederhana, sehingga renderingnya cepat untuk hierarki yang dangkal.
*   **Kekurangan**:
    *   **Kurang Fleksibel**: Sulit untuk membuat tata letak yang kompleks dengan banyak komponen yang saling terkait posisinya.
    *   **Nesting Berlebihan**: Untuk membuat UI yang kompleks, Anda sering perlu menyarangkan (nest) `LinearLayout` di dalam `LinearLayout` lain. Ini disebut "view hierarchy depth" yang dapat menurunkan performa rendering aplikasi.

##### **3.4.1.4 Contoh Kode dan Hasil Tampilan**

**File: `activity_linear_example.xml`**
```xml
<?xml version="1.0" encoding="utf-8"?>
<LinearLayout xmlns:android="http://schemas.android.com/apk/res/android"
    android:layout_width="match_parent"
    android:layout_height="match_parent"
    android:orientation="vertical"
    android:padding="16dp">

    <TextView
        android:layout_width="match_parent"
        android:layout_height="wrap_content"
        android:text="Judul Utama"
        android:textSize="24sp"
        android:textStyle="bold"
        android:gravity="center"
        android:layout_marginBottom="16dp"/>

    <EditText
        android:layout_width="match_parent"
        android:layout_height="wrap_content"
        android:hint="Masukkan nama Anda"
        android:inputType="textPersonName"
        android:layout_marginBottom="8dp"/>

    <Button
        android:layout_width="match_parent"
        android:layout_height="wrap_content"
        android:text="KIRIM"/>

</LinearLayout>
```

**Hasil Tampilan:**
Tampilan akan menunjukkan tiga komponen yang tersusun vertikal dari atas ke bawah:
1.  Sebuah `TextView` dengan teks "Judul Utama" di bagian paling atas, rata tengah.
2.  Di bawahnya, sebuah `EditText` dengan petunjuk "Masukkan nama Anda".
3.  Di bagian paling bawah, sebuah `Button` dengan teks "KIRIM" yang memenuhi lebar layar.

##### **3.4.1.5 Contoh Kasus Praktikum: Membuat Form Login Sederhana**

Kita akan menggunakan `LinearLayout` vertikal untuk membuat form login yang umum.

**File: `activity_login_form.xml`**
```xml
<?xml version="1.0" encoding="utf-8"?>
<LinearLayout xmlns:android="http://schemas.android.com/apk/res/android"
    android:layout_width="match_parent"
    android:layout_height="match_parent"
    android:orientation="vertical"
    android:gravity="center"
    android:padding="24dp">

    <ImageView
        android:layout_width="100dp"
        android:layout_height="100dp"
        android:src="@drawable/ic_launcher_foreground"
        android:layout_marginBottom="32dp"/>

    <EditText
        android:id="@+id/etUsername"
        android:layout_width="match_parent"
        android:layout_height="wrap_content"
        android:hint="Username"
        android:inputType="text"
        android:layout_marginBottom="16dp"/>

    <EditText
        android:id="@+id/etPassword"
        android:layout_width="match_parent"
        android:layout_height="wrap_content"
        android:hint="Password"
        android:inputType="textPassword"
        android:layout_marginBottom="24dp"/>

    <Button
        android:id="@+id/btnLogin"
        android:layout_width="match_parent"
        android:layout_height="wrap_content"
        android:text="Login"/>

</LinearLayout>
```
**Penjelasan:**
*   `android:gravity="center"` pada `LinearLayout` induk membuat semua anaknya berada di tengah-tengah layar secara vertikal dan horizontal.
*   Komponen-komponen (logo, input username, input password, tombol) tersusun rapi ke bawah. `LinearLayout` adalah pilihan yang sangat efisien untuk kasus form seperti ini.

---

#### **3.4.2 Relative Layout**

##### **3.4.2.1 Pengertian dan Konsep**

`RelativeLayout` mengatur posisi anak-anaknya secara relatif. Artinya, posisi sebuah `View` ditentukan relatif terhadap `View` lainnya atau relatif terhadap induk `RelativeLayout` itu sendiri. Misalnya, Anda dapat menempatkan tombol "di sebelah kanan" dari sebuah teks atau "di bagian bawah" dari layar.

##### **3.4.2.2 Atribut Penting: Posisi Relatif**

Atribut dibagi menjadi dua kategori: relatif terhadap induk dan relatif terhadap `View` lain.

*   **Relatif terhadap Induk (`RelativeLayout`)**:
    *   `android:layout_alignParentTop="true"`: Menempel di bagian atas induk.
    *   `android:layout_alignParentBottom="true"`: Menempel di bagian bawah induk.
    *   `android:layout_alignParentLeft="true"` / `android:layout_alignParentStart="true"`: Menempel di kiri induk.
    *   `android:layout_alignParentRight="true"` / `android:layout_alignParentEnd="true"`: Menempel di kanan induk.
    *   `android:layout_centerInParent="true"`: Menengahkan `View` di dalam induk.

*   **Relatif terhadap `View` Lain (sibling)**:
    *   `android:layout_above="@id/id_view_lain"`: Ditempatkan di atas `View` dengan ID `id_view_lain`.
    *   `android:layout_below="@id/id_view_lain"`: Ditempatkan di bawah `View` dengan ID `id_view_lain`.
    *   `android:layout_toLeftOf="@id/id_view_lain"` / `android:layout_toStartOf="@id/id_view_lain"`: Ditempatkan di sebelah kiri `View` lain.
    *   `android:layout_toRightOf="@id/id_view_lain"` / `android:layout_toEndOf="@id/id_view_lain"`: Ditempatkan di sebelah kanan `View` lain.
    *   `android:layout_alignLeft="@id/id_view_lain"`: Menyelaraskan sisi kiri dengan sisi kiri `View` lain.

##### **3.4.2.3 Kelebihan dan Kekurangan**

*   **Kelebihan**:
    *   **Fleksibel**: Sangat berguna untuk membuat UI yang tidak mengikuti alur linear, seperti menempatkan tombol di pojok kanan bawah atau menempatkan teks di samping gambar.
    *   **Mengurangi Nesting**: Dapat menggantikan beberapa tingkat `LinearLayout` bersarang, sehingga hierarki view lebih datar dan performa lebih baik.
*   **Kekurangan**:
    *   **Kompleksitas**: Sulit untuk dipelihara jika jumlah komponen sangat banyak, karena perubahan pada satu `View` bisa berdampak pada banyak `View` lain yang bergantung padanya.
    *   **Performa**: Proses *layout pass* (menghitung posisi) bisa lebih lambat dibanding `LinearLayout` karena setiap `View` perlu diperiksa ketergantungannya dua kali (satu untuk ukuran, satu untuk posisi).

##### **3.4.2.4 Contoh Kode dan Hasil Tampilan**

**File: `activity_relative_example.xml`**
```xml
<?xml version="1.0" encoding="utf-8"?>
<RelativeLayout xmlns:android="http://schemas.android.com/apk/res/android"
    android:layout_width="match_parent"
    android:layout_height="match_parent"
    android:padding="16dp">

    <TextView
        android:id="@+id/labelCenter"
        android:layout_width="wrap_content"
        android:layout_height="wrap_content"
        android:text="Saya di Tengah"
        android:layout_centerInParent="true"
        android:textSize="18sp"/>

    <Button
        android:id="@+id/btnTopLeft"
        android:layout_width="wrap_content"
        android:layout_height="wrap_content"
        android:text="Atas Kiri"
        android:layout_alignParentTop="true"
        android:layout_alignParentLeft="true"/>

    <Button
        android:id="@+id/btnBottomRight"
        android:layout_width="wrap_content"
        android:layout_height="wrap_content"
        android:text="Bawah Kanan"
        android:layout_alignParentBottom="true"
        android:layout_alignParentRight="true"/>

    <Button
        android:id="@+id/btnBelowCenter"
        android:layout_width="wrap_content"
        android:layout_height="wrap_content"
        android:text="Bawah Tengah"
        android:layout_below="@id/labelCenter"
        android:layout_centerHorizontal="true"/>

</RelativeLayout>
```

**Hasil Tampilan:**
*   Sebuah `TextView` dengan teks "Saya di Tengah" akan berada tepat di tengah layar.
*   Tombol "Atas Kiri" berada di pojok kiri atas.
*   Tombol "Bawah Kanan" berada di pojok kanan bawah.
*   Tombol "Bawah Tengah" berada tepat di bawah `TextView` yang di tengah, dengan posisi horizontalnya rata tengah.

##### **3.4.2.5 Contoh Kasus Praktikum: Membuat Tampilan Item dengan Ikon dan Teks**

`RelativeLayout` sangat ideal untuk membuat item daftar yang memiliki ikon di sebelah kiri dan teks (serta sub-teks) di sebelah kanannya.

**File: `list_item_relative.xml`**
```xml
<?xml version="1.0" encoding="utf-8"?>
<RelativeLayout xmlns:android="http://schemas.android.com/apk/res/android"
    android:layout_width="match_parent"
    android:layout_height="wrap_content"
    android:padding="12dp">

    <ImageView
        android:id="@+id/iconItem"
        android:layout_width="48dp"
        android:layout_height="48dp"
        android:src="@drawable/ic_launcher_foreground"
        android:layout_alignParentLeft="true"
        android:layout_centerVertical="true"/>

    <TextView
        android:id="@+id/titleItem"
        android:layout_width="wrap_content"
        android:layout_height="wrap_content"
        android:layout_toRightOf="@id/iconItem"
        android:layout_toEndOf="@id/iconItem"
        android:layout_marginLeft="16dp"
        android:text="Judul Item"
        android:textSize="16sp"
        android:textStyle="bold"/>

    <TextView
        android:id="@+id/subtitleItem"
        android:layout_width="wrap_content"
        android:layout_height="wrap_content"
        android:layout_toRightOf="@id/iconItem"
        android:layout_toEndOf="@id/iconItem"
        android:layout_below="@id/titleItem"
        android:layout_marginLeft="16dp"
        android:text="Ini adalah subjudul atau deskripsi singkat."
        android:textSize="14sp"
        android:textColor="@android:color/darker_gray"/>

</RelativeLayout>
```
**Penjelasan:**
*   `ImageView` (ikon) dijadikan acuan dengan `id="@id/iconItem"`.
*   `titleItem` ditempatkan di sebelah kanan (`toRightOf`) ikon.
*   `subtitleItem` ditempatkan di sebelah kanan ikon dan di bawah (`below`) `titleItem`.
*   `android:layout_centerVertical="true"` pada ikon memastikan ikon berada di tengah vertikal dari seluruh item, terlepas dari tinggi teks.

---

#### **3.4.3 Table Layout**

##### **3.4.3.1 Pengertian dan Konsep**

`TableLayout` mengatur anak-anaknya ke dalam bentuk baris dan kolom, mirip dengan tabel HTML. Layout ini tidak menampilkan garis batas (border) secara default. Strukturnya terdiri dari `TableLayout` sebagai wadah utama dan `TableRow` sebagai wadah untuk setiap baris. Setiap `View` yang Anda tambahkan ke dalam `TableRow` akan menjadi satu sel (cell) pada baris tersebut.

##### **3.4.3.2 Atribut Penting: `TableRow` dan `stretchColumns`**

*   **`TableRow`**: Ini adalah subclass dari `LinearLayout` dengan orientasi horizontal. Ia mendefinisikan sebuah baris dalam tabel. Anda bisa menambahkan `View` langsung ke `TableLayout` (di luar `TableRow`) untuk membuat sebuah baris yang memanjang sepanjang lebar tabel.
*   `android:stretchColumns`: Atribut pada `TableLayout` yang digunakan untuk membuat kolom tertentu "meregang" untuk mengisi ruang ekstra yang tersisa. Nilainya adalah indeks kolom (dimulai dari 0). Anda bisa memberikan beberapa indeks yang dipisahkan koma. `android:shrinkColumns` berfungsi sebaliknya, memungkinkan kolom untuk menyusut.
*   `android:layout_column`: Atribut pada `View` di dalam `TableRow` untuk secara eksplisit menentukan di kolom mana `View` tersebut harus ditempatkan.
*   `android:layout_span`: Atribut pada `View` di dalam `TableRow` untuk membuat `View` tersebut menempati beberapa kolom (mirip dengan `colspan` di HTML).

##### **3.4.3.3 Kelebihan dan Kekurangan**

*   **Kelebihan**:
    *   **Struktur Teratur**: Sangat cocok untuk data yang memang berbentuk tabular, seperti jadwal, daftar harga, atau tampilan kalkulator.
*   **Kekurangan**:
    *   **Kaku**: Strukturnya sangat kaku dan tidak fleksibel untuk desain UI yang modern dan responsif.
    *   **Tidak Direkomendasikan**: Untuk sebagian besar kasus UI, `LinearLayout` atau `ConstraintLayout` lebih fleksibel dan memiliki performa lebih baik. Penggunaannya sekarang sangat terbatas.

##### **3.4.3.4 Contoh Kode dan Hasil Tampilan**

**File: `activity_table_example.xml`**
```xml
<?xml version="1.0" encoding="utf-8"?>
<TableLayout xmlns:android="http://schemas.android.com/apk/res/android"
    android:layout_width="match_parent"
    android:layout_height="match_parent"
    android:stretchColumns="1,2" <!-- Membuat kolom 1 dan 2 meregang -->
    android:padding="16dp">

    <!-- Baris Judul -->
    <TableRow>
        <TextView
            android:text="No."
            android:padding="8dp"
            android:textStyle="bold"/>
        <TextView
            android:text="Nama"
            android:padding="8dp"
            android:textStyle="bold"/>
        <TextView
            android:text="Nilai"
            android:padding="8dp"
            android:textStyle="bold"/>
    </TableRow>

    <!-- Baris Data 1 -->
    <TableRow>
        <TextView android:text="1" android:padding="8dp"/>
        <TextView android:text="Andi" android:padding="8dp"/>
        <TextView android:text="90" android:padding="8dp"/>
    </TableRow>

    <!-- Baris Data 2 -->
    <TableRow>
        <TextView android:text="2" android:padding="8dp"/>
        <TextView android:text="Budi" android:padding="8dp"/>
        <TextView android:text="85" android:padding="8dp"/>
    </TableRow>

    <!-- Baris dengan span -->
    <Button
        android:text="Simpan"
        android:layout_span="3" <!-- Menempati 3 kolom -->
        android:layout_marginTop="16dp"/>

</TableLayout>
```

**Hasil Tampilan:**
Tampilan akan menyerupai tabel sederhana dengan 3 kolom. Kolom "Nama" dan "Nilai" (indeks 1 dan 2) akan melebar untuk mengisi sisa ruang horizontal. Di bagian bawah, ada sebuah tombol "Simpan" yang memanjang menempati ketiga kolom.

##### **3.4.3.5 Contoh Kasus Praktikum: Membuat Tampilan Kalkulator Sederhana**

**File: `activity_calculator.xml`**
```xml
<?xml version="1.0" encoding="utf-8"?>
<LinearLayout xmlns:android="http://schemas.android.com/apk/res/android"
    android:layout_width="match_parent"
    android:layout_height="match_parent"
    android:orientation="vertical"
    android:padding="8dp">

    <EditText
        android:id="@+id/tvDisplay"
        android:layout_width="match_parent"
        android:layout_height="wrap_content"
        android:gravity="end"
        android:text="0"
        android:textSize="32sp"
        android:editable="false"/>

    <TableLayout
        android:layout_width="match_parent"
        android:layout_height="wrap_content"
        android:stretchColumns="*"> <!-- Semua kolom meregang -->

        <TableRow>
            <Button android:text="C" />
            <Button android:text="±" />
            <Button android:text="%" />
            <Button android:text="/" />
        </TableRow>
        <TableRow>
            <Button android:text="7" />
            <Button android:text="8" />
            <Button android:text="9" />
            <Button android:text="*" />
        </TableRow>
        <TableRow>
            <Button android:text="4" />
            <Button android:text="5" />
            <Button android:text="6" />
            <Button android:text="-" />
        </TableRow>
        <TableRow>
            <Button android:text="1" />
            <Button android:text="2" />
            <Button android:text="3" />
            <Button android:text="+" />
        </TableRow>
        <TableRow>
            <Button android:text="0" android:layout_span="2" /> <!-- Tombol 0 lebar 2 kolom -->
            <Button android:text="." />
            <Button android:text="=" />
        </TableRow>
    </TableLayout>

</LinearLayout>
```
**Penjelasan:**
*   `TableLayout` digunakan untuk membuat grid tombol.
*   `android:stretchColumns="*"` adalah cara singkatan untuk mengatakan "semua kolom harus meregang".
*   Tombol "0" menggunakan `android:layout_span="2"` agar lebarnya dua kali lipat tombol lainnya, yang umum pada kalkulator.

---

#### **3.4.4 Frame Layout**

##### **3.4.4.1 Pengertian dan Konsep**

`FrameLayout` adalah layout paling sederhana dari semuanya. Ia dirancang untuk menumpuk (stack) anak-anaknya di atas satu another. Semua `View` di dalam `FrameLayout` akan ditambatkan (anchored) di pojok kiri atas layar. `View` yang ditulis terakhir di file XML akan muncul di paling atas (paling depan) tumpukan.

##### **3.4.4.2 Atribut Penting: `layout_gravity`**

*   `android:layout_gravity`: Atribut ini digunakan untuk mengontrol posisi sebuah `View` di dalam `FrameLayout`. Anda bisa menggunakan nilai seperti `center`, `center_vertical`, `center_horizontal`, `top`, `bottom`, `left`, `right`, atau kombinasinya (misal `bottom|right`). Tanpa atribut ini, semua `View` akan berada di posisi default (kiri atas).

##### **3.4.4.3 Kelebihan dan Kekurangan**

*   **Kelebihan**:
    *   **Sangat Ringan**: Performanya sangat cepat karena logikanya sangat sederhana.
    *   **Ideal untuk Tumpukan**: Sangat berguna untuk kasus di mana Anda perlu menumpuk elemen, seperti menampilkan gambar dengan teks di atasnya, atau membuat efek overlay (misal, layar pemuatan/loading).
*   **Kekurangan**:
    *   **Sangat Terbatas**: Hampir tidak mungkin membuat layout yang kompleks hanya dengan `FrameLayout` karena semua elemen saling menutupi kecuali posisinya diatur secara manual dengan `layout_gravity`.

##### **3.4.4.4 Contoh Kode dan Hasil Tampilan**

**File: `activity_frame_example.xml`**
```xml
<?xml version="1.0" encoding="utf-8"?>
<FrameLayout xmlns:android="http://schemas.android.com/apk/res/android"
    android:layout_width="match_parent"
    android:layout_height="match_parent">

    <!-- Lapisan 1: Gambar Latar -->
    <ImageView
        android:layout_width="match_parent"
        android:layout_height="match_parent"
        android:src="@drawable/ic_launcher_background"
        android:scaleType="centerCrop"/>

    <!-- Lapisan 2: Teks di tengah -->
    <TextView
        android:layout_width="wrap_content"
        android:layout_height="wrap_content"
        android:text="Overlay Teks"
        android:layout_gravity="center"
        android:textSize="32sp"
        android:textColor="@android:color/white"
        android:textStyle="bold"
        android:background="#80000000"/> <!-- Background semi-transparan -->

</FrameLayout>
```

**Hasil Tampilan:**
Sebuah gambar akan mengisi seluruh latar belakang layar. Di tengah-tengah gambar, akan ada sebuah `TextView` dengan teks "Overlay Teks" yang memiliki latar belakang abu-abu semi-transparan, sehingga teks tetap terbaca di atas gambar.

##### **3.4.4.5 Contoh Kasus Praktikum: Membuat Splash Screen dengan Overlay**

`FrameLayout` sempurna untuk membuat *splash screen* yang memiliki gambar latar dan indikator loading di depannya.

**File: `activity_splash.xml`**
```xml
<?xml version="1.0" encoding="utf-8"?>
<FrameLayout xmlns:android="http://schemas.android.com/apk/res/android"
    android:layout_width="match_parent"
    android:layout_height="match_parent"
    android:background="@color/primary_color">

    <!-- Logo Aplikasi -->
    <ImageView
        android:layout_width="150dp"
        android:layout_height="150dp"
        android:src="@drawable/ic_launcher_foreground"
        android:layout_gravity="center"/>

    <!-- Indikator Loading di bagian bawah -->
    <ProgressBar
        android:layout_width="wrap_content"
        android:layout_height="wrap_content"
        android:layout_gravity="bottom|center_horizontal"
        android:layout_marginBottom="48dp"/>

</FrameLayout>
```
**Penjelasan:**
*   `FrameLayout` memiliki warna latar belakang solid.
*   Logo aplikasi (`ImageView`) ditempatkan di tengah dengan `layout_gravity="center"`.
*   Indikator loading (`ProgressBar`) ditempatkan di bagian bawah tengah dengan `layout_gravity="bottom|center_horizontal"`. Kedua elemen ini ditumpuk dengan rapi.

---

#### **3.4.5 Constraint Layout**

##### **3.4.5.1 Pengertian dan Konsep**

`ConstraintLayout` adalah layout yang paling powerful dan fleksibel yang tersedia saat ini. Ia dirancang untuk mengatasi keterbatasan layout sebelumnya dan memungkinkan pembuatan UI yang kompleks dan responsif tanpa perlu menyarangkan layout terlalu dalam (flat view hierarchy). Konsep intinya adalah **constraint** atau **kendala**. Setiap `View` harus memiliki constraint yang mengikat posisinya secara horizontal dan vertikal terhadap elemen lain (induk, `View` lain, atau *guideline*).

##### **3.4.5.2 Atribut Penting: Constraint, Bias, dan Guideline**

*   **Constraint**: Ini adalah inti dari `ConstraintLayout`. Anda mendefinisikan hubungan antara sisi sebuah `View` dengan sisi `View` lain.
    *   `layout_constraintLeft_toLeftOf`: Sisi kiri `View` ini sejajar dengan sisi kiri target.
    *   `layout_constraintTop_toBottomOf`: Sisi atas `View` ini berada di bawah sisi bawah target.
    *   Ada banyak kombinasi: `Left_toRightOf`, `Right_toLeftOf`, `Bottom_toTopOf`, `Baseline_toBaselineOf`, dll.
    *   Target bisa berupa `parent` (untuk mengikat ke induk) atau ID dari `View` lain.

*   **Bias**: Bias digunakan untuk memposisikan `View` di sepanjang sumbu horizontal atau vertikal antara dua constraint. Nilainya berkisar dari 0.0 (posisi awal) hingga 1.0 (posisi akhir).
    *   `layout_constraintHorizontal_bias="0.5"`: Menempatkan `View` tepat di tengah horizontal antara constraint kiri dan kanannya.
    *   `layout_constraintVertical_bias="0.2"`: Menempatkan `View` 20% dari jalan ke bawah antara constraint atas dan bawahnya.

*   **Guideline**: Ini adalah *helper object* invisible yang tidak terlihat di UI runtime. Ia berfungsi sebagai garis bantu virtual untuk membuat constraint. Anda bisa membuat guideline vertikal atau horizontal dengan posisi persentase (`percent`) atau jarak tetap (`dp`) dari tepi induk. Sangat berguna untuk menjaga konsistensi margin atau posisi elemen.

##### **3.4.5.3 Kelebihan dan Kekurangan**

*   **Kelebihan**:
    *   **Sangat Fleksibel**: Dapat membuat hampir semua jenis desain UI.
    *   **Performa Optimal**: Mendorong penggunaan hierarki view yang datar (flat), yang meningkatkan performa rendering secara signifikan.
    *   **Responsif**: Mudah membuat UI yang beradaptasi dengan berbagai ukuran layar menggunakan constraint dan guideline.
    *   **Didukung oleh Visual Editor**: Design Editor Android Studio sangat dioptimalkan untuk `ConstraintLayout`, memungkinkan Anda membuat UI kompleks hanya dengan drag-and-drop.
*   **Kekurangan**:
    *   **Learning Curve**: Konsepnya lebih kompleks dan membutuhkan waktu untuk benar-benar memahaminya, terutama bagi pemula.
    *   **Banyak Atribut**: Jumlah atribut yang bisa digunakan sangat banyak, yang bisa membingungkan di awal.

##### **3.4.5.4 Contoh Kode dan Hasil Tampilan**

**File: `activity_constraint_example.xml`**
```xml
<?xml version="1.0" encoding="utf-8"?>
<androidx.constraintlayout.widget.ConstraintLayout xmlns:android="http://schemas.android.com/apk/res/android"
    xmlns:app="http://schemas.android.com/apk/res-auto"
    android:layout_width="match_parent"
    android:layout_height="match_parent">

    <TextView
        android:id="@+id/tvTitle"
        android:layout_width="wrap_content"
        android:layout_height="wrap_content"
        android:text="Judul di Tengah"
        android:textSize="24sp"
        app:layout_constraintTop_toTopOf="parent"
        app:layout_constraintBottom_toTopOf="@+id/btnBottom"
        app:layout_constraintStart_toStartOf="parent"
        app:layout_constraintEnd_toEndOf="parent"
        app:layout_constraintVertical_bias="0.3" />

    <Button
        android:id="@+id/btnBottom"
        android:layout_width="wrap_content"
        android:layout_height="wrap_content"
        android:text="Tombol Bawah"
        app:layout_constraintBottom_toBottomOf="parent"
        app:layout_constraintStart_toStartOf="parent"
        app:layout_constraintEnd_toEndOf="parent"
        android:layout_marginBottom="32dp"/>

</androidx.constraintlayout.widget.ConstraintLayout>
```
**Hasil Tampilan:**
*   Sebuah `TextView` dengan teks "Judul di Tengah" akan berada di tengah horizontal layar. Posisi vertikalnya diatur oleh `layout_constraintVertical_bias="0.3"`, yang berarti ia berada di 30% dari jarak antara constraint atas (parent) dan constraint bawahnya (tombol).
*   Sebuah tombol berada di tengah horizontal dan menempel di bagian bawah layar dengan margin 32dp.

##### **3.4.5.5 Contoh Kasus Praktikum: Membuat Tampilan Profil Pengguna**

Kita akan membuat tampilan profil yang kompleks dengan mudah menggunakan `ConstraintLayout`.

**File: `activity_profile.xml`**
```xml
<?xml version="1.0" encoding="utf-8"?>
<androidx.constraintlayout.widget.ConstraintLayout xmlns:android="http://schemas.android.com/apk/res/android"
    xmlns:app="http://schemas.android.com/apk/res-auto"
    xmlns:tools="http://schemas.android.com/tools"
    android:layout_width="match_parent"
    android:layout_height="match_parent">

    <!-- Header Background -->
    <View
        android:id="@+id/headerBackground"
        android:layout_width="0dp"
        android:layout_height="150dp"
        android:background="@color/purple_500"
        app:layout_constraintTop_toTopOf="parent"
        app:layout_constraintStart_toStartOf="parent"
        app:layout_constraintEnd_toEndOf="parent" />

    <!-- Profile Picture -->
    <ImageView
        android:id="@+id/ivProfile"
        android:layout_width="100dp"
        android:layout_height="100dp"
        android:src="@drawable/ic_launcher_foreground"
        android:background="@android:color/white"
        android:padding="4dp"
        app:layout_constraintStart_toStartOf="parent"
        app:layout_constraintEnd_toEndOf="parent"
        app:layout_constraintTop_toBottomOf="@id/headerBackground"
        android:layout_marginTop="-50dp" />

    <!-- User Name -->
    <TextView
        android:id="@+id/tvName"
        android:layout_width="wrap_content"
        android:layout_height="wrap_content"
        android:text="John Doe"
        android:textSize="22sp"
        android:textStyle="bold"
        app:layout_constraintTop_toBottomOf="@id/ivProfile"
        app:layout_constraintStart_toStartOf="parent"
        app:layout_constraintEnd_toEndOf="parent"
        android:layout_marginTop="8dp"/>

    <!-- User Bio -->
    <TextView
        android:id="@+id/tvBio"
        android:layout_width="0dp"
        android:layout_height="wrap_content"
        android:text="Android Developer yang sedang belajar membuat layout yang keren."
        android:gravity="center"
        app:layout_constraintTop_toBottomOf="@id/tvName"
        app:layout_constraintStart_toStartOf="parent"
        app:layout_constraintEnd_toEndOf="parent"
        android:layout_marginTop="8dp"
        android:layout_marginHorizontal="16dp"/>

    <!-- Follow Button -->
    <Button
        android:id="@+id/btnFollow"
        android:layout_width="0dp"
        android:layout_height="wrap_content"
        android:text="Follow"
        app:layout_constraintTop_toBottomOf="@id/tvBio"
        app:layout_constraintStart_toStartOf="parent"
        app:layout_constraintEnd_toEndOf="parent"
        android:layout_marginTop="24dp"
        android:layout_marginHorizontal="32dp"/>

</androidx.constraintlayout.widget.ConstraintLayout>
```
**Penjelasan:**
*   `headerBackground` adalah `View` sederhana yang membentuk header berwarna.
*   `ivProfile` (foto profil) diikat ke bagian bawah `headerBackground` dengan margin negatif (`android:layout_marginTop="-50dp"`), sehingga menciptakan efek tumpukan yang menarik.
*   `tvName` dan `tvBio` masing-masing diikat ke bagian bawah elemen di atasnya.
*   `btnFollow` diikat ke bagian bawah `tvBio`.
*   Semua elemen kecuali header diatur ke tengah horizontal dengan constraint `Start_toStartOf="parent"` dan `End_toEndOf="parent"`. Ini semua dicapai tanpa nesting layout sama sekali.

### **3.5 Menggabungkan Beberapa Layout (Nested Layout)**

#### **3.5.1 Konsep Nested Layout**

*Nested Layout* atau *layout bersarang* adalah praktik menempatkan sebuah `ViewGroup` (seperti `LinearLayout`) di dalam `ViewGroup` lain. Meskipun `ConstraintLayout` dirancang untuk meminimalkan kebutuhan akan nesting, terkadang menggabungkan beberapa layout adalah solusi yang paling logis dan mudah dibaca untuk masalah tertentu.

Contohnya, Anda mungkin memiliki `ConstraintLayout` sebagai root, tetapi di dalamnya ada sebuah form yang strukturnya sangat linear. Alih-alih membuat banyak constraint untuk setiap field di form, akan lebih mudah untuk membungkus form tersebut ke dalam sebuah `LinearLayout` vertikal.

#### **3.5.2 Contoh Penggunaan dan Kapan Waktunya**

**Kapan menggunakan Nested Layout?**
1.  **Ketika sebuah bagian dari UI memiliki struktur yang sangat berulang dan teratur**, seperti daftar item dalam `LinearLayout` atau `TableLayout`.
2.  **Untuk meningkatkan keterbacaan kode**. Terkadang, sebuah `LinearLayout` bersarang lebih mudah dipahami daripada puluhan constraint yang saling terkait.
3.  **Saat menggunakan komponen yang sudah memiliki layout sendiri**, seperti `Fragment` atau *custom view* yang root-nya adalah `LinearLayout`.

**Contoh Penggunaan:**
Kita akan membuat layar dengan `ConstraintLayout` sebagai root, yang berisi sebuah `LinearLayout` untuk form dan sebuah tombol di luar form tersebut.

**File: `activity_nested_example.xml`**
```xml
<?xml version="1.0" encoding="utf-8"?>
<androidx.constraintlayout.widget.ConstraintLayout xmlns:android="http://schemas.android.com/apk/res/android"
    xmlns:app="http://schemas.android.com/apk/res-auto"
    android:layout_width="match_parent"
    android:layout_height="match_parent"
    android:padding="16dp">

    <!-- LinearLayout bersarang untuk form login -->
    <LinearLayout
        android:id="@+id/loginForm"
        android:layout_width="0dp"
        android:layout_height="wrap_content"
        android:orientation="vertical"
        app:layout_constraintTop_toTopOf="parent"
        app:layout_constraintStart_toStartOf="parent"
        app:layout_constraintEnd_toEndOf="parent"
        app:layout_constraintBottom_toTopOf="@+id/btnSubmit">

        <EditText
            android:id="@+id/etEmail"
            android:layout_width="match_parent"
            android:layout_height="wrap_content"
            android:hint="Email" />

        <EditText
            android:id="@+id/etPassword"
            android:layout_width="match_parent"
            android:layout_height="wrap_content"
            android:layout_marginTop="8dp"
            android:hint="Password"
            android:inputType="textPassword" />

    </LinearLayout>

    <!-- Tombol di luar LinearLayout, diatur oleh ConstraintLayout -->
    <Button
        android:id="@+id/btnSubmit"
        android:layout_width="0dp"
        android:layout_height="wrap_content"
        android:text="Submit"
        app:layout_constraintBottom_toBottomOf="parent"
        app:layout_constraintStart_toStartOf="parent"
        app:layout_constraintEnd_toEndOf="parent" />

</androidx.constraintlayout.widget.ConstraintLayout>
```
**Penjelasan:**
*   `ConstraintLayout` mengatur posisi dua elemen besar: `loginForm` (yang merupakan `LinearLayout`) dan `btnSubmit`.
*   `loginForm` diatur untuk berada di bagian atas dan menempati seluruh lebar.
*   `btnSubmit` diatur untuk menempel di bagian bawah.
*   Di dalam `loginForm`, `EditText` untuk email dan password tersusun dengan rapi secara vertikal. Pendekatan ini lebih bersih daripada membuat constraint untuk setiap sisi `EditText` ke root `ConstraintLayout`.

**Peringatan:** Hindari nesting yang terlalu dalam (misalnya, `LinearLayout` di dalam `LinearLayout` di dalam `RelativeLayout` di dalam `LinearLayout`). Ini akan menyebabkan performa UI menurun drastis karena Android harus melakukan perhitungan layout yang berulang-ulang untuk setiap tingkatan hierarki.

### **3.6 Kesimpulan: Ringkasan Perbedaan dan Penggunaan Layout**

Setelah mempelajari kelima jenis layout ini, penting untuk memahami karakteristik masing-masing untuk dapat memilih alat yang tepat untuk pekerjaan yang tepat.

| Layout | Karakteristik Utama | Kapan Digunakan | Kelebihan | Kekurangan |
| :--- | :--- | :--- | :--- | :--- |
| **Linear Layout** | Menyusun anak dalam satu baris (vertikal/horizontal). | Form sederhana, daftar item, tampilan linear. | Sangat sederhana, mudah dipahami, performa cepat. | Kurang fleksibel, rentan menyebabkan nesting yang dalam. |
| **Relative Layout** | Menyusun anak relatif terhadap induk atau sibling lainnya. | UI dengan posisi elemen yang saling terkait (misal, tombol di pojok). | Fleksibel, mengurangi kebutuhan nesting. | Rumit untuk dipelihara, performa bisa lebih lambat. |
| **Table Layout** | Menyusun anak dalam baris dan kolom. | Data tabular, jadwal, tampilan grid sederhana (kalkulator). | Struktur teratur untuk data tabular. | Sangat kaku, tidak responsif, sudah jarang digunakan. |
| **Frame Layout** | Menumpuk anak-anaknya di atas satu another. | Overlay, splash screen, animasi sederhana. | Sangat ringan, performa tercepat. | Sangat terbatas, tidak bisa membuat layout kompleks. |
| **Constraint Layout** | Mengatur posisi anak berdasarkan constraint/kendala. | **Hampir semua jenis UI modern.** Standar saat ini. | Sangat fleksibel dan powerful, performa optimal (hierarki datar), responsif. | Learning curve curam, lebih kompleks untuk pemula. |

**Rekomendasi Praktis:**
*   **Untuk project baru**, selalu mulai dengan **`ConstraintLayout`** sebagai root layout. Ini adalah standar industri dan akan memaksa Anda berpikir tentang desain yang responsif dan efisien.
*   **Pelajari `LinearLayout`** dengan baik, terutama penggunaan `layout_weight`, karena masih sangat berguna untuk kasus-kasus sederhana dan untuk memahami konsep dasar tata letak.
*   **Pahami `RelativeLayout`** jika Anda harus memelihara kode lama atau untuk kasus-kasus spesifik di mana positioning relatif lebih sederhana daripada membuat constraint.
*   **Gunakan `TableLayout` dan `FrameLayout`** hanya untuk kasus yang sangat spesifik dan sesuai dengan kekuatan mereka, seperti menampilkan data tabel atau membuat overlay.
