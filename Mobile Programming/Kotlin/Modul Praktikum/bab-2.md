
# **BAB 2**
# **Dasar Pemrograman Kotlin (Variabel, Tipe Data, Operator, Kontrol Alur, Fungsi)**

## **Pendahuluan**

Sebelum memasuki dunia pengembangan aplikasi Android yang kompleks, sangat fundamental untuk memahami dasar-dasar bahasa pemrograman yang akan digunakan, yaitu Kotlin. Mengapa? Karena Kotlin bukan sekadar bahasa, melainkan alat yang akan kita gunakan untuk "berbicara" dengan perangkat Android. Tanpa pemahaman yang kuat tentang tata bahasa (grammar) dan kosakatanya, kita akan kesulitan untuk memberikan instruksi yang jelas dan efektif.

Kotlin dirancang untuk menjadi bahasa yang modern, ringkas, dan aman (safe). Dengan memahami konsep variabel, tipe data, operator, kontrol alur, dan fungsi, Anda akan memiliki fondasi yang kokoh untuk:

1.  **Menulis Kode yang Bersih dan Efisien:** Kotlin memungkinkan penulisan kode yang lebih singkat dibandingkan pendahulunya, Java. Pemahaman dasar akan memungkinkan Anda memanfaatkan fitur ini secara maksimal.
2.  **Menghindari Kesalahan Umum:** Fitur seperti *Null Safety* di Kotlin secara drastis mengurangi kesalahan paling umum dalam pemrograman, yaitu `NullPointerException`.
3.  **Memahami Komponen Android dengan Lebih Mudah:** Setiap elemen di Android, mulai dari menampilkan teks di layar hingga menangani klik tombol, pada dasarnya adalah penerapan dari konsep pemrograman dasar seperti variabel dan fungsi.

Bab ini akan memandu Anda langkah demi langkah untuk menguasai fondasi tersebut, yang akan menjadi bekal utama Anda sebelum melangkah ke topik-topik spesifik Android development.

---

## **2.1 Variabel dan Konstanta**

Dalam pemrograman, variabel adalah wadah untuk menyimpan data. Bayangkan variabel sebagai sebuah kotak berlabel yang bisa kita isi dengan sebuah nilai. Di Kotlin, ada dua cara utama untuk mendeklarasikan sebuah wadah: menggunakan `var` dan `val`.

### **2.1.1 Deklarasi variabel dengan `var` dan `val`**

*   **`var` (Mutable):** Digunakan untuk mendeklarasikan variabel yang nilainya dapat diubah (mutable) setelah dideklarasikan. Ini adalah pilihan yang tepat ketika Anda membutuhkan nilai yang akan berubah seiring berjalannya program.
*   **`val` (Immutable):** Digunakan untuk mendeklarasikan variabel yang nilainya tidak dapat diubah (immutable atau read-only) setelah pertama kali diberi nilai. Menggunakan `val` adalah praktik terbaik karena membuat kode lebih aman dan mudah diprediksi. Ini setara dengan konstanta di beberapa bahasa lain.

**Contoh Kode:**

```kotlin
fun main() {
    // Menggunakan 'var' untuk variabel yang bisa berubah
    var skor: Int = 10
    println("Skor awal: $skor")

    // Mengubah nilai variabel 'var'
    skor = 15
    println("Skor setelah diubah: $skor")

    // Menggunakan 'val' untuk variabel yang tidak bisa berubah
    val namaPemain: String = "Alex"
    println("Nama pemain: $namaPemain")

    // Mencoba mengubah nilai 'val' akan menyebabkan error saat kompilasi
    // namaPemain = "Budi" // <-- Baris ini akan error
    // println("Nama pemain baru: $namaPemain")
}
```

**Output:**

```
Skor awal: 10
Skor setelah diubah: 15
Nama pemain: Alex
```

**Latihan Praktikum:**

1.  Buat sebuah variabel `var` dengan nama `jumlahBuku` dan beri nilai awal 5.
2.  Cetak nilai `jumlahBuku` ke konsol.
3.  Tambah 3 ke nilai `jumlahBuku` dan cetak lagi nilainya.
4.  Buat sebuah variabel `val` dengan nama `namaPerpustakaan` dan beri nilai "Perpustakaan Kota".
5.  Cetak nilai `namaPerpustakaan`.

---

### **2.1.2 Tipe variabel mutable vs immutable**

Seperti yang telah dijelaskan, perbedaan utama antara `var` (mutable) dan `val` (immutable) terletak pada kemampuannya untuk berubah.

*   **Mutable (`var`):** Fleksibel, tetapi bisa menjadi sumber kesalahan jika nilainya diubah secara tidak sengaja di bagian lain program. Gunakan `var` hanya jika Anda benar-benar yakin nilainya perlu berubah.
*   **Immutable (`val`):** Lebih aman. Setelah nilai ditetapkan, Anda dapat yakin bahwa nilainya tidak akan berubah di mana pun dalam kode. Ini membuat kode lebih mudah dibaca, di-debug, dan dioptimalkan oleh kompilator.

**Praktik Terbaik:** **Selalu gunakan `val` terlebih dahulu.** Jika selama pengembangan Anda menemukan bahwa variabel tersebut perlu diubah, ubahlah menjadi `var`. Pendekatan ini akan mendorong Anda untuk menulis kode yang lebih aman.

**Latihan Praktikum:**

1.  Jelaskan dengan kata-kata Anda sendiri, kapan sebaiknya kita menggunakan `val` daripada `var`? Berikan satu contoh kasus di dunia nyata (misalnya, data pengguna vs total keranjang belanja).

---

## **2.2 Tipe Data di Kotlin**

Setiap variabel memiliki tipe data yang menentukan jenis nilai apa yang dapat disimpannya. Kotlin mendukung berbagai tipe data, mulai dari yang paling sederhana hingga yang lebih kompleks.

### **2.2.1 Tipe data dasar**

Tipe data dasar adalah tipe data primitif yang sering digunakan.

| Tipe Data | Deskripsi | Contoh |
| :--- | :--- | :--- |
| `Int` | Bilangan bulat (32-bit) | `10`, `-5`, `0` |
| `Long` | Bilangan bulat (64-bit) | `10000000000L` |
| `Double` | Bilangan desimal (64-bit) | `3.14`, `-0.01` |
| `Float` | Bilangan desimal (32-bit) | `2.5f` |
| `Boolean` | Nilai kebenaran, hanya `true` atau `false` | `true`, `false` |
| `Char` | Karakter tunggal, diapit tanda petik satu | `'A'`, `'@'` |
| `String` | Rangkaian karakter (teks), diapit tanda petik dua | `"Hello, Kotlin"` |

**Type Inference:** Kotlin memiliki fitur *type inference*, artinya kompilator dapat menebak tipe data variabel secara otomatis berdasarkan nilai yang diberikan.

```kotlin
fun main() {
    // Kompilator akan menebak bahwa umur adalah Int
    var umur = 20 
    println("Umur: $umur (Tipe: ${umur::class.simpleName})")

    // Kompilator akan menebak bahwa pi adalah Double
    val pi = 3.14159
    println("Nilai Pi: $pi (Tipe: ${pi::class.simpleName})")

    // Kompilator akan menebak bahwa isActive adalah Boolean
    val isActive = true
    println("Status aktif: $isActive (Tipe: ${isActive::class.simpleName})")

    // Kita juga bisa mendeklarasikan tipe data secara eksplisit
    var saldo: Long = 1000000000
    println("Saldo: $saldo (Tipe: ${saldo::class.simpleName})")
}
```

**Output:**

```
Umur: 20 (Tipe: Int)
Nilai Pi: 3.14159 (Tipe: Double)
Status aktif: true (Tipe: Boolean)
Saldo: 1000000000 (Tipe: Long)
```

**Latihan Praktikum:**

1.  Buat variabel untuk menyimpan data diri Anda:
    *   `nama` (String)
    *   `tinggiBadan` (Double, dalam meter)
    *   `beratBadan` (Int, dalam kg)
    *   `statusMenikah` (Boolean)
2.  Cetak semua variabel tersebut beserta tipe datanya menggunakan `${variabel::class.simpleName}`.

---

### **2.2.2 Tipe data koleksi**

Koleksi digunakan untuk menyimpan sekelompok objek yang terkait.

*   **Array:** Koleksi elemen dengan ukuran tetap. Elemen diakses menggunakan indeks (dimulai dari 0).
*   **List:** Koleksi elemen yang terurut dan bisa berisi duplikat. Ada dua jenis: `List` (immutable, read-only) dan `MutableList` (bisa diubah).
*   **Set:** Koleksi elemen unik (tidak ada duplikasi) dan tidak terurut.
*   **Map:** Koleksi pasangan *key-value* (kunci-nilai). Setiap kunci harus unik.

**Contoh Kode:**

```kotlin
fun main() {
    // List (immutable)
    val buah = listOf("Apel", "Jeruk", "Mangga")
    println("Daftar buah: $buah")
    println("Buah kedua: ${buah[1]}")

    // MutableList (mutable)
    val kendaraan = mutableListOf("Mobil", "Motor")
    println("\nKendaraan awal: $kendaraan")
    kendaraan.add("Sepeda") // Menambah elemen
    println("Kendaraan setelah ditambah: $kendaraan")

    // Set
    val angkaUnik = setOf(1, 2, 3, 2, 4, 1)
    println("\nAngka unik: $angkaUnik") // Duplikasi (1 dan 2) akan dihapus

    // Map
    val user = mapOf("nama" to "Budi", "umur" to 25)
    println("\nData user: $user")
    println("Nama user: ${user["nama"]}")
}
```

**Output:**

```
Daftar buah: [Apel, Jeruk, Mangga]
Buah kedua: Jeruk

Kendaraan awal: [Mobil, Motor]
Kendaraan setelah ditambah: [Mobil, Motor, Sepeda]

Angka unik: [1, 2, 3, 4]

Data user: {nama=Budi, umur=25}
Nama user: Budi
```

**Latihan Praktikum:**

1.  Buat sebuah `MutableList` untuk daftar belanjaan Anda (misalnya: "Susu", "Roti", "Telur").
2.  Cetak daftar belanjaan awal.
3.  Tambahkan "Keju" ke dalam daftar.
4.  Hapus "Roti" dari daftar.
5.  Cetak daftar belanjaan akhir.

---

### **2.2.3 Null safety di Kotlin**

Salah satu sumber kesalahan paling umum dalam pemrograman adalah `NullPointerException`, yang terjadi saat kita mencoba mengakses properti atau fungsi dari sebuah variabel yang bernilai `null`. Kotlin dirancang untuk menghilangkan kesalahan ini dari kode kita.

Secara default, variabel di Kotlin tidak boleh bernilai `null`.

```kotlin
var nama: String = "Rina"
// nama = null // <-- Ini akan menyebabkan error kompilasi
```

Untuk mengizinkan sebuah variabel bisa bernilai `null`, kita harus menambahkan tanda tanya `?` pada tipe datanya.

```kotlin
// Tipe String? berarti variabel ini bisa menampung String atau null
var alamat: String? = "Jl. Merdeka No. 10"
alamat = null // Ini diperbolehkan
```

Untuk mengakses variabel yang *nullable* dengan aman, Kotlin menyediakan beberapa operator:

*   **Safe Call Operator (`?.`):** Mengakses properti hanya jika variabel tidak null. Jika null, maka ekspresi akan mengembalikan `null` tanpa menyebabkan error.
*   **Elvis Operator (`?:`):** Memberikan nilai default jika variabel di sebelah kirinya bernilai `null`.

**Contoh Kode:**

```kotlin
fun main() {
    var panjangNama: Int? = null

    // Menggunakan safe call operator
    // Jika panjangNama tidak null, maka toInt() akan dipanggil
    // Jika null, maka hasilnya adalah null
    println("Panjang nama (dengan safe call): ${panjangNama?.toInt()}")

    panjangNama = 7
    println("Panjang nama (dengan safe call): ${panjangNama?.toInt()}")

    // Menggunakan Elvis operator
    // Jika panjangNama null, gunakan nilai 0 sebagai default
    val panjangFinal = panjangNama ?: 0
    println("\nPanjang final (dengan Elvis): $panjangFinal")

    var teks: String? = null
    val jumlahKarakter = teks?.length ?: 0
    println("Jumlah karakter teks: $jumlahKarakter") // Output: 0
}
```

**Output:**

```
Panjang nama (dengan safe call): null
Panjang nama (dengan safe call): 7

Panjang final (dengan Elvis): 7
Jumlah karakter teks: 0
```

**Latihan Praktikum:**

1.  Buat sebuah variabel `String?` bernama `namaTengah` dan beri nilai `null`.
2.  Cetak "Nama tengah tidak ada" jika `namaTengah` null, atau cetak nilai `namaTengah` jika tidak null. Gunakan Elvis operator untuk ini.

---

## **2.3 Operator di Kotlin**

Operator adalah simbol khusus yang melakukan operasi pada variabel dan nilai. Kotlin menyediakan berbagai macam operator.

### **2.3.1 Operator aritmatika**

Digunakan untuk melakukan operasi matematika dasar.

| Operator | Deskripsi | Contoh |
| :--- | :--- | :--- |
| `+` | Penjumlahan | `5 + 2` hasilnya `7` |
| `-` | Pengurangan | `5 - 2` hasilnya `3` |
| `*` | Perkalian | `5 * 2` hasilnya `10` |
| `/` | Pembagian | `5 / 2` hasilnya `2` |
| `%` | Modulo (sisa bagi) | `5 % 2` hasilnya `1` |

**Contoh Kode:**

```kotlin
fun main() {
    val a = 10
    val b = 3

    println("Penjumlahan: ${a + b}") // 13
    println("Pengurangan: ${a - b}") // 7
    println("Perkalian: ${a * b}") // 30
    println("Pembagian: ${a / b}") // 3 (karena a dan b adalah Int)
    println("Modulo: ${a % b}") // 1
}
```

**Output:**

```
Penjumlahan: 13
Pengurangan: 7
Perkalian: 30
Pembagian: 3
Modulo: 1
```

**Latihan Praktikum:**

1.  Buat program untuk menghitung luas dan keliling sebuah persegi panjang. Deklarasikan variabel `panjang` dan `lebar`, lalu hitung dan cetak hasilnya.

---

### **2.3.2 Operator logika**

Digunakan untuk menggabungkan atau memodifikasi ekspresi Boolean. Sering digunakan dalam kontrol alur (`if`, `when`).

| Operator | Deskripsi | Contoh |
| :--- | :--- | :--- |
| `&&` | Logika AND (dan) | `true && false` hasilnya `false` |
| `||` | Logika OR (atau) | `true || false` hasilnya `true` |
| `!` | Logika NOT (negasi) | `!true` hasilnya `false` |

**Contoh Kode:**

```kotlin
fun main() {
    val punyaSIM = true
    val usiaDiatas17 = true

    // Bisa mengemudi jika punya SIM DAN usia diatas 17
    val bisaMengemudi = punyaSIM && usiaDiatas17
    println("Bisa mengemudi? $bisaMengemudi") // true

    val hariHujan = false
    val membawaPayung = true

    // Akan basah jika hari hujan DAN tidak membawa payung
    val akanBasah = hariHujan && !membawaPayung
    println("Akan basah? $akanBasah") // false
}
```

**Output:**

```
Bisa mengemudi? true
Akan basah? false
```

**Latihan Praktikum:**

1.  Buat variabel Boolean `isStudent` (true) dan `hasDiscountCard` (false).
2.  Seseorang mendapat diskon jika dia adalah mahasiswa ATAU memiliki kartu diskon.
3.  Cetak "Mendapat diskon" atau "Tidak mendapat diskon" berdasarkan kondisi tersebut.

---

### **2.3.3 Operator perbandingan**

Digunakan untuk membandingkan dua nilai dan selalu menghasilkan nilai Boolean (`true` atau `false`).

| Operator | Deskripsi | Contoh |
| :--- | :--- | :--- |
| `==` | Sama dengan | `5 == 5` hasilnya `true` |
| `!=` | Tidak sama dengan | `5 != 2` hasilnya `true` |
| `>` | Lebih besar dari | `5 > 2` hasilnya `true` |
| `<` | Lebih kecil dari | `5 < 2` hasilnya `false` |
| `>=` | Lebih besar atau sama dengan | `5 >= 5` hasilnya `true` |
| `<=` | Lebih kecil atau sama dengan | `5 <= 2` hasilnya `false` |

**Contoh Kode:**

```kotlin
fun main() {
    val x = 10
    val y = 20

    println("Apakah x sama dengan y? ${x == y}") // false
    println("Apakah x tidak sama dengan y? ${x != y}") // true
    println("Apakah x lebih kecil dari y? ${x < y}") // true
}
```

**Output:**

```
Apakah x sama dengan y? false
Apakah x tidak sama dengan y? true
Apakah x lebih kecil dari y? true
```

**Latihan Praktikum:**

1.  Buat dua variabel, `angka1` dan `angka2`. Beri nilai apa saja.
2.  Gunakan operator perbandingan untuk menentukan mana yang lebih besar, lalu cetak hasilnya dalam bentuk kalimat, misalnya: "Angka1 lebih besar dari Angka2".

---

### **2.3.4 Operator assignment dan increment/decrement**

Operator assignment digunakan untuk memberikan nilai ke variabel. Operator increment/decrement digunakan untuk menambah atau mengurangi nilai variabel sebanyak satu.

| Operator | Deskripsi | Contoh |
| :--- | :--- | :--- |
| `=` | Assignment | `x = 5` |
| `+=` | Tambah dan assignment | `x += 3` (sama dengan `x = x + 3`) |
| `-=` | Kurang dan assignment | `x -= 3` (sama dengan `x = x - 3`) |
| `*=` | Kali dan assignment | `x *= 3` (sama dengan `x = x * 3`) |
| `/=` | Bagi dan assignment | `x /= 3` (sama dengan `x = x / 3`) |
| `++` | Increment (naik 1) | `x++` (sama dengan `x = x + 1`) |
| `--` | Decrement (turun 1) | `x--` (sama dengan `x = x - 1`) |

**Contoh Kode:**

```kotlin
fun main() {
    var skor = 100
    println("Skor awal: $skor")

    skor += 10
    println("Skor setelah += 10: $skor") // 110

    skor -= 5
    println("Skor setelah -= 5: $skor") // 105

    var lives = 3
    println("\nNyawa awal: $lives")
    lives-- // decrement
    println("Nyawa setelah --: $lives") // 2
}
```

**Output:**

```
Skor awal: 100
Skor setelah += 10: 110
Skor setelah -= 5: 105

Nyawa awal: 3
Nyawa setelah --: 2
```

**Latihan Praktikum:**

1.  Buat variabel `counter` dengan nilai 0.
2.  Gunakan loop `for` (yang akan kita pelajari sebentar lagi) atau increment manual 5 kali untuk menaikkan nilai `counter`.
3.  Cetak nilai `counter` akhir.

---

## **2.4 Kontrol Alur Program**

Kontrol alur memungkinkan program untuk membuat keputusan dan mengulang eksekusi kode berdasarkan kondisi tertentu.

### **2.4.1 Percabangan (`if`, `when`)**

Percabangan digunakan untuk menjalankan blok kode tertentu hanya jika sebuah kondisi terpenuhi.

*   **`if-else`:** Struktur yang paling umum. Di Kotlin, `if` bisa juga digunakan sebagai ekspresi yang mengembalikan nilai.

```kotlin
fun main() {
    val nilai = 85

    // if sebagai pernyataan (statement)
    if (nilai >= 75) {
        println("Anda lulus.")
    } else {
        println("Anda tidak lulus.")
    }

    // if sebagai ekspresi (expression)
    val grade = if (nilai >= 90) "A"
                else if (nilai >= 80) "B"
                else if (nilai >= 70) "C"
                else "D"
    
    println("\nGrade Anda: $grade")
}
```

**Output:**

```
Anda lulus.

Grade Anda: B
```

*   **`when`:** Alternatif yang lebih ringkas dan kuat dari `if-else if-else` yang panjang. `when` memeriksa nilai terhadap sejumlah kondisi.

```kotlin
fun main() {
    val hari = 3

    val namaHari = when (hari) {
        1 -> "Senin"
        2 -> "Selasa"
        3 -> "Rabu"
        4 -> "Kamis"
        5 -> "Jumat"
        6 -> "Sabtu"
        7 -> "Minggu"
        else -> "Hari tidak valid"
    }

    println("Hari ke-$hari adalah $namaHari")

    // when dengan rentang (range)
    val skor = 75
    val predikat = when (skor) {
        in 90..100 -> "Sangat Baik"
        in 75..89 -> "Baik"
        in 60..74 -> "Cukup"
        else -> "Kurang"
    }
    println("\nPredikat: $predikat")
}
```

**Output:**

```
Hari ke-3 adalah Rabu

Predikat: Baik
```

**Latihan Praktikum:**

1.  Buat program untuk menentukan apakah sebuah bilangan (simpan dalam variabel) adalah bilangan genap atau ganjil. Gunakan `if-else`.
2.  Gunakan `when` untuk mengkonversi angka 1-12 menjadi nama bulan (Januari, Februari, dst.). Jika angka di luar rentang tersebut, cetak "Bulan tidak valid".

---

### **2.4.2 Perulangan (`for`, `while`, `do…while`)**

Perulangan digunakan untuk mengeksekusi blok kode berulang kali.

*   **`for`:** Sering digunakan untuk iterasi melalui rentang (range) atau koleksi (seperti List).

```kotlin
fun main() {
    // Perulangan dengan rentang
    println("Menghitung 1 sampai 5:")
    for (i in 1..5) {
        println(i)
    }

    // Perulangan dengan koleksi (List)
    val buah = listOf("Apel", "Jeruk", "Mangga")
    println("\nDaftar buah:")
    for (item in buah) {
        println("- $item")
    }

    // Perulangan dengan indeks
    println("\nDaftar buah dengan indeks:")
    for (index in buah.indices) {
        println("${index + 1}. ${buah[index]}")
    }
}
```

**Output:**

```
Menghitung 1 sampai 5:
1
2
3
4
5

Daftar buah:
- Apel
- Jeruk
- Mangga

Daftar buah dengan indeks:
1. Apel
2. Jeruk
3. Mangga
```

*   **`while`:** Perulangan akan terus berjalan selama kondisinya bernilai `true`. Kondisi diperiksa *sebelum* setiap iterasi.

```kotlin
fun main() {
    var hitungMundur = 5
    println("Hitung mundur:")
    while (hitungMundur > 0) {
        println(hitungMundur)
        hitungMundur--
    }
    println("Mulai!")
}
```

**Output:**

```
Hitung mundur:
5
4
3
2
1
Mulai!
```

*   **`do...while`:** Mirip dengan `while`, tetapi blok kode akan dieksekusi *setidaknya sekali* sebelum kondisi diperiksa.

```kotlin
fun main() {
    var angka = 10
    do {
        println("Ini akan dicetak sekali, meskipun kondisi salah.")
    } while (angka < 5)
}
```

**Output:**

```
Ini akan dicetak sekali, meskipun kondisi salah.
```

**Latihan Praktikum:**

1.  Gunakan perulangan `for` untuk mencetak bilangan genap dari 2 hingga 20.
2.  Buat perulangan `while` yang terus meminta input (simulasikan dengan variabel) hingga pengguna memasukkan angka 0. Setiap iterasi, cetak "Masukkan angka (0 untuk keluar):".

---

### **2.4.3 Break dan Continue**

*   **`break`:** Menghentikan seluruh perulangan secara tiba-tiba.
*   **`continue`:** Menghentikan iterasi saat ini dan melanjutkan ke iterasi berikutnya.

**Contoh Kode:**

```kotlin
fun main() {
    println("Contoh 'break':")
    for (i in 1..10) {
        if (i == 5) {
            break // Hentikan perulangan saat i mencapai 5
        }
        println(i)
    }

    println("\nContoh 'continue':")
    for (i in 1..10) {
        if (i % 2 == 0) {
            continue // Lewati iterasi jika i adalah bilangan genap
        }
        println(i) // Hanya akan mencetak bilangan ganjil
    }
}
```

**Output:**

```
Contoh 'break':
1
2
3
4

Contoh 'continue':
1
3
5
7
9
```

**Latihan Praktikum:**

1.  Buat perulangan dari 1 hingga 100. Gunakan `break` untuk menghentikan perulangan ketika Anda menemukan bilangan pertama yang habis dibagi 7.
2.  Buat perulangan dari 1 hingga 20. Gunakan `continue` untuk melewati semua bilangan yang merupakan kelipatan 3.

---

## **2.5 Fungsi (Function)**

Fungsi adalah blok kode yang dapat digunakan kembali (reusable) untuk melakukan tugas tertentu. Membuat fungsi membantu mengorganisir kode menjadi bagian-bagian yang lebih kecil dan mudah dikelola.

### **2.5.1 Konsep fungsi di Kotlin**

Fungsi dideklarasikan dengan kata kunci `fun`, diikuti dengan nama fungsi, parameter (masukan), dan tipe nilai kembalian (output).

```kotlin
fun namaFungsi(parameter1: Tipe1, parameter2: Tipe2): TipeKembalian {
    // Blok kode fungsi
    return nilaiKembalian
}
```

Jika fungsi tidak mengembalikan nilai apa pun, tipe kembaliannya adalah `Unit` (bisa tidak dituliskan).

**Contoh Kode:**

```kotlin
// Fungsi tanpa parameter dan tanpa nilai kembalian (Unit)
fun sapa() {
    println("Halo, selamat datang!")
}

// Fungsi dengan parameter dan nilai kembalian
fun jumlahkan(a: Int, b: Int): Int {
    return a + b
}

fun main() {
    // Memanggil fungsi sapa()
    sapa()

    val hasil = jumlahkan(10, 5)
    println("Hasil penjumlahan 10 + 5 adalah $hasil")
}
```

**Output:**

```
Halo, selamat datang!
Hasil penjumlahan 10 + 5 adalah 15
```

**Latihan Praktikum:**

1.  Buat fungsi bernama `kalikan` yang menerima dua parameter `Int` dan mengembalikan hasil perkaliannya.
2.  Panggil fungsi `kalikan` dari `main` dan cetak hasilnya.

---

### **2.5.2 Parameter dan nilai kembalian**

Parameter adalah masukan untuk fungsi, sedangkan nilai kembalian adalah keluaran dari fungsi. Kotlin mendukung *single-expression function*, yaitu fungsi yang hanya terdiri dari satu baris ekspresi.

```kotlin
// Fungsi standar
fun kuadrat(x: Int): Int {
    return x * x
}

// Single-expression function (lebih ringkas)
fun pangkatTiga(x: Int): Int = x * x * x

fun main() {
    println("Kuadrat dari 4 adalah ${kuadrat(4)}")
    println("Pangkat tiga dari 3 adalah ${pangkatTiga(3)}")
}
```

**Output:**

```
Kuadrat dari 4 adalah 16
Pangkat tiga dari 3 adalah 27
```

**Latihan Praktikum:**

1.  Buat fungsi `volumeBalok` dengan parameter `panjang`, `lebar`, dan `tinggi` (semua `Int`). Fungsi ini harus mengembalikan volume balok. Gunakan gaya *single-expression function*.

---

### **2.5.3 Fungsi dengan default argument dan named argument**

*   **Default Argument:** Anda dapat memberikan nilai default pada parameter fungsi. Jika parameter tidak disertakan saat pemanggilan, nilai default akan digunakan.
*   **Named Argument:** Saat memanggil fungsi, Anda dapat menyebutkan nama parameter secara eksplisit. Ini membuat kode lebih mudah dibaca dan memungkinkan Anda mengabaikan urutan parameter.

**Contoh Kode:**

```kotlin
// fungsi dengan default argument untuk role
fun buatProfil(nama: String, usia: Int, role: String = "User") {
    println("Nama: $nama, Usia: $usia, Role: $role")
}

fun main() {
    // Pemanggilan tanpa named argument (harus urut)
    buatProfil("Citra", 22)
    buatProfil("Budi", 30, "Admin")

    // Pemanggilan dengan named argument (bisa acak)
    buatProfil(usia = 25, nama = "Diana")
    buatProfil(role = "Editor", nama = "Eko", usia = 28)
}
```

**Output:**

```
Nama: Citra, Usia: 22, Role: User
Nama: Budi, Usia: 30, Role: Admin
Nama: Diana, Usia: 25, Role: User
Nama: Eko, Usia: 28, Role: Editor
```

**Latihan Praktikum:**

1.  Buat fungsi `hitungTotalHarga` dengan parameter `harga` (Int) dan `jumlah` (Int). Tambahkan parameter `diskon` (Int) dengan nilai default 0. Fungsi ini mengembalikan total harga setelah diskon.
2.  Panggil fungsi tersebut tiga kali:
    *   Tanpa `diskon`.
    *   Dengan `diskon` 10.
    *   Dengan `diskon` 15 menggunakan named argument.

---

### **2.5.4 Fungsi lambda (pengantar)**

Lambda adalah fungsi tanpa nama (anonymous function) yang bisa kita buat dengan singkat. Sering digunakan sebagai argumen untuk fungsi lain. Sintaks dasarnya adalah `{ parameter -> ekspresi }`.

**Contoh Kode:**

```kotlin
fun main() {
    // Lambda yang disimpan dalam variabel
    val kuadrat: (Int) -> Int = { x -> x * x }
    println("Kuadrat dari 9 adalah ${kuadrat(9)}")

    // Lambda sebagai argumen untuk fungsi 'forEach'
    val nama = listOf("Ana", "Budi", "Cici")
    println("\nDaftar nama:")
    nama.forEach { item -> // 'item' adalah parameter lambda
        println("- $item")
    }

    // Jika lambda hanya memiliki satu parameter, kita bisa menggunakan 'it'
    println("\nPanjang nama:")
    nama.forEach {
        println("Panjang nama '$it' adalah ${it.length}")
    }
}
```

**Output:**

```
Kuadrat dari 9 adalah 81

Daftar nama:
- Ana
- Budi
- Cici

Panjang nama:
Panjang nama 'Ana' adalah 3
Panjang nama 'Budi' adalah 4
Panjang nama 'Cici' adalah 4
```

**Latihan Praktikum:**

1.  Buat sebuah `List` of `Int` yang berisi angka 1, 2, 3, 4, 5.
2.  Gunakan fungsi `map` dengan lambda untuk mengubah setiap angka dalam list menjadi kuadratnya.
3.  Cetak list hasilnya.

---

## **2.6 Latihan Praktikum Integratif**

Berikut adalah beberapa latihan yang menggabungkan konsep-konsep yang telah dipelajari.

### **2.6.1 Membuat program kalkulator sederhana**

Buat program yang dapat melakukan operasi aritmatika dasar (+, -, *, /). Program harus memiliki:
1.  Dua variabel `angka1` dan `angka2`.
2.  Sebuah variabel `operator` (berisi String: "+", "-", "*", atau "/").
3.  Gunakan `when` untuk memilih operasi yang sesuai berdasarkan nilai `operator`.
4.  Buat fungsi terpisah untuk setiap operasi (misal: `tambah(a, b)`, `kurang(a, b)`, dll.).
5.  Cetak hasil perhitungan.

**Contoh Kode Solusi:**

```kotlin
fun tambah(a: Double, b: Double): Double = a + b
fun kurang(a: Double, b: Double): Double = a - b
fun kali(a: Double, b: Double): Double = a * b
fun bagi(a: Double, b: Double): Double = a / b

fun main() {
    val angka1 = 20.0
    val angka2 = 4.0
    val operator = "/"

    val hasil = when (operator) {
        "+" -> tambah(angka1, angka2)
        "-" -> kurang(angka1, angka2)
        "*" -> kali(angka1, angka2)
        "/" -> bagi(angka1, angka2)
        else -> {
            println("Operator tidak valid!")
            0.0
        }
    }

    if (operator in listOf("+", "-", "*", "/")) {
        println("Hasil dari $angka1 $operator $angka2 adalah $hasil")
    }
}
```

### **2.6.2 Membuat program validasi usia dengan `if` dan `when`**

Buat program untuk memvalidasi usia dan memberikan respons yang berbeda.
1.  Deklarasikan variabel `usia`.
2.  Gunakan `if-else` untuk menentukan apakah `usia` valid (misalnya, di atas 0).
3.  Jika valid, gunakan `when` untuk mengkategorikan usia:
    *   `0..12`: "Anak-anak"
    *   `13..17`: "Remaja"
    *   `18..60`: "Dewasa"
    *   `> 60`: "Lansia"
4.  Cetak kategori usia. Jika tidak valid, cetak "Usia tidak valid."

**Contoh Kode Solusi:**

```kotlin
fun main() {
    val usia = 25

    if (usia > 0) {
        val kategori = when (usia) {
            in 0..12 -> "Anak-anak"
            in 13..17 -> "Remaja"
            in 18..60 -> "Dewasa"
            else -> "Lansia"
        }
        println("Usia $usia tahun termasuk kategori: $kategori")
    } else {
        println("Usia tidak valid!")
    }
}
```

### **2.6.3 Membuat program daftar belanja dengan `List`**

Buat program untuk mengelola daftar belanja.
1.  Buat sebuah `MutableList<String>` untuk daftar belanja awal (misalnya: "Susu", "Telur").
2.  Cetak daftar belanja awal.
3.  Gunakan perulangan `for` untuk menambahkan 3 item baru ke dalam list (misalnya: "Roti", "Mentega", "Keju").
4.  Hapus satu item dari list (misalnya: "Telur").
5.  Cetak daftar belanja akhir dengan format nomor urut.
6.  Gunakan `when` untuk memberikan komentar: jika list memiliki lebih dari 4 item, cetak "Belanjaan banyak!", jika tidak, cetak "Belanjaan sedikit."

**Contoh Kode Solusi:**

```kotlin
fun main() {
    val daftarBelanja = mutableListOf("Susu", "Telur")
    println("Daftar belanja awal: $daftarBelanja")

    val itemBaru = listOf("Roti", "Mentega", "Keju")
    for (item in itemBaru) {
        daftarBelanja.add(item)
    }
    println("\nSetelah menambah item: $daftarBelanja")

    daftarBelanja.remove("Telur")
    println("\nSetelah menghapus 'Telur': $daftarBelanja")

    println("\nDaftar Belanja Akhir:")
    for ((index, item) in daftarBelanja.withIndex()) {
        println("${index + 1}. $item")
    }

    val komentar = when {
        daftarBelanja.size > 4 -> "Belanjaan banyak!"
        else -> "Belanjaan sedikit."
    }
    println("\n$komentar")
}
```

---

## **Kesimpulan**

Pada bab ini, kita telah mempelajari fondasi dasar dari bahasa pemrograman Kotlin. Semua konsep—mulai dari cara mendeklarasikan variabel dengan `var` dan `val`, memahami berbagai tipe data, menggunakan operator untuk memanipulasi data, mengontrol alur program dengan percabangan dan perulangan, hingga mengorganisir kode ke dalam fungsi—adalah batu bata esensial untuk membangun sebuah aplikasi Android.

