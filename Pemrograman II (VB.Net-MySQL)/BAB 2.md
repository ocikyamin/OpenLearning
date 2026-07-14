# BAB 2: Variabel, Tipe Data, dan Operasi Aritmatika

## 1. Pendahuluan

Pada bab sebelumnya, Anda telah berhasil membuat aplikasi pertama yang dapat menyapa pengguna. Sekarang, mari kita melangkah lebih dalam ke "dapur" pemrograman. Jika diibaratkan sebuah restoran, aplikasi Anda adalah ruang makan, sedangkan **variabel** dan **tipe data** adalah dapur tempat bahan-bahan diolah sebelum disajikan.

**Apa itu Variabel?**
Bayangkan Anda memiliki sebuah lemari arsip di ruang guru. Setiap laci memiliki label berbeda:
*   Laci 1: "Data Nilai Siswa"
*   Laci 2: "Daftar Hadir"
*   Laci 3: "Kalender Akademik"

Dalam pemrograman, **variabel adalah laci-laci tersebut**. Setiap laci (variabel) memiliki nama unik dan hanya bisa menyimpan jenis tertentu. Anda tidak mungkin menyimpan nilai angka di laci yang khusus untuk teks, sama seperti Anda tidak menyimpan buku di laci yang khusus untuk pulpen.

**Mengapa Tipe Data Penting?**
Pemilihan tipe data yang tepat bukan hanya soal teknis, tetapi juga soal **efisiensi**. Setiap tipe data menggunakan sejumlah memori komputer. Jika Anda menggunakan tipe data yang "terlalu besar" untuk menyimpan data kecil, Anda membuang-buang memori. Sebaliknya, jika tipe data "terlalu kecil", data bisa rusak atau tidak akurat.

>**Analogi Manajemen Memori:**
Bayangkan Anda ingin menyimpan sebutir beras (angka kecil). Jika Anda menggunakan truk kontainer (tipe data besar), itu tidak efisien. Namun, jika Anda ingin menyimpan satu karung beras (angka besar) menggunakan kotak korek api (tipe data kecil), beras akan tumpah (overflow error).



## 2. Capaian Pembelajaran


| Kode | Sub-CPMK |
|------|--------------------------------|
| **Sub-CPMK 3** | Mahasiswa mampu menerapkan konsep variabel, konstanta, dan tipe data serta mengimplementasikan operator aritmatika dalam logika perhitungan aplikasi pendidikan menggunakan VB.NET secara tepat. |

**Indikator Pencapaian:**
1.  Mahasiswa dapat mendeklarasikan variabel dan konstanta dengan *naming convention* yang benar.
2.  Mahasiswa dapat memilih tipe data yang sesuai dengan karakteristik data yang akan disimpan.
3.  Mahasiswa dapat mengimplementasikan operator aritmatika untuk menyelesaikan masalah perhitungan sederhana.
4.  Mahasiswa memahami konsep konversi tipe data untuk menghindari error.

---

## 3. Materi 1: Anatomi Variabel dan Konstanta

### 3.1. Deklarasi Variabel dengan `Dim`

Dalam VB.NET, untuk membuat variabel kita menggunakan kata kunci **`Dim`** (singkatan dari *Dimension*). Ini seperti memberi label pada laci sebelum kita menyimpan sesuatu di dalamnya.

**Sintaks Dasar:**
```vb
Dim namaVariabel As TipeData
```

**Contoh:**
```vb
Dim namaSiswa As String
Dim nilaiUjian As Integer
Dim tinggiBadan As Double
```

![alt text](img/GAMBAR%202.1.png)
> **[GAMBAR 2.1: Deklarasi Variabel di Editor Kode]**

### 3.2. Aturan Penamaan Variabel (Naming Convention)

Sebagai calon pendidik yang profesional, Anda harus membiasakan diri menulis kode yang rapi dan mudah dibaca. Ini adalah bagian dari **etika digital** seorang programmer. Berikut adalah aturan penamaan variabel yang baik:

| Aturan | Penjelasan | Contoh Benar | Contoh Salah |
|--------|------------|--------------|--------------|
| **Tidak boleh spasi** | Gunakan underscore atau gabungkan kata | `namaSiswa` | `nama Siswa` |
| **Huruf depan huruf** | Tidak boleh dimulai dengan angka | `siswa1` | `1siswa` |
| **Case Sensitive** | VB.NET tidak membedakan huruf besar/kecil | `NamaSiswa` = `namasiswa` | - |
| **Gunakan CamelCase** | Huruf kapital di setiap awal kata (kecuali pertama) | `nilaiAkhirSiswa` | `NILAIakhirSISWA` |
| **Deskriptif** | Nama harus menjelaskan isi variabel | `totalNilai` | `x` |

**Mengapa CamelCase?**
Penulisan `nilaiAkhirSiswa` lebih mudah dibaca daripada `nilaiakhirsiswa`. Ini membantu Anda dan orang lain yang membaca kode Anda untuk memahami maksud variabel tersebut dengan cepat.

![alt text](img/GAMBAR%202.2.png)
> **[GAMBAR 2.2: Perbandingan Penamaan Variabel yang Baik dan Buruk]**

### 3.3. Konstanta dengan `Const`

Berbeda dengan variabel yang nilainya bisa berubah-ubah, **konstanta** adalah variabel khusus yang nilainya **tetap** sepanjang program berjalan.

**Kapan Menggunakan Konstanta?**
Gunakan konstanta untuk nilai-nilai yang tidak berubah, seperti:
*   Nilai π (Phi) = 3.14159
*   KKM (Kriteria Ketuntasan Minimal) = 75
*   Jumlah hari dalam seminggu = 7

**Sintaks:**
```vb
Const NAMA_KONSTANTA As TipeData = Nilai
```

**Contoh:**
```vb
Const KKM_SEKOLAH As Integer = 75
Const PHI As Double = 3.14159
Const NAMA_SEKOLAH As String = "SMAN 1 Pendidikan"
```

**Perbedaan Variabel vs Konstanta:**

| Aspek | Variabel (`Dim`) | Konstanta (`Const`) |
|-------|------------------|---------------------|
| **Nilai** | Dapat diubah selama program berjalan | Tetap, tidak bisa diubah |
| **Kata Kunci** | `Dim` | `Const` |
| **Penggunaan** | Data dinamis (input user, hasil hitungan) | Data statis (aturan, konfigurasi) |
| **Contoh** | `nilaiSiswa = 85` (bisa jadi 90 nanti) | `KKM = 75` (selalu 75) |



![alt text](img/GAMBAR%202.3.png)
> **[GAMBAR 2.3: Perbandingan Penggunaan Dim dan Const]**

---

## 4. Materi 2: Klasifikasi Tipe Data Populer

Memilih tipe data yang tepat adalah kunci aplikasi yang efisien. Berikut adalah tipe data yang paling sering digunakan dalam pengembangan aplikasi pendidikan.

### 4.1. Tabel Perbandingan Tipe Data

| Tipe Data | Ukuran Memori | Rentang Nilai | Contoh Penggunaan di Sekolah |
|-----------|---------------|---------------|------------------------------|
| **String** | Variabel (±50 byte + panjang teks) | Teks apa saja (0-2 miliar karakter) | Nama siswa, NISN, Alamat, Mata Pelajaran |
| **Integer** | 4 Byte | -2.147.483.648 sampai 2.147.483.647 | Jumlah siswa, Nilai ujian (bulat), Kelas |
| **Double** | 8 Byte | ±5.0 × 10^-324 sampai ±1.7 × 10^308 | Rata-rata nilai, Tinggi badan, Persentase |
| **Decimal** | 16 Byte | ±1.0 × 10^-28 sampai ±7.9 × 10^28 | Nilai uang (SPP), Nilai dengan presisi tinggi |
| **Boolean** | 2 Byte | `True` atau `False` | Status kelulusan, Kehadiran (Hadir/Alpha) |
| **Date** | 8 Byte | 1 Januari 0001 sampai 31 Desember 9999 | Tanggal lahir, Tanggal ujian, Waktu masuk |

![alt text](img/GAMBAR%202.4.png)
> **[GAMBAR 2.4: Tabel Tipe Data dalam Dokumentasi Visual Studio]**

### 4.2. Contoh Kasus Penggunaan Tipe Data

Mari kita terapkan dalam konteks aplikasi sekolah:

**Kasus 1: Form Biodata Siswa**
```vb
Dim namaLengkap As String      ' "Ahmad Fauzi"
Dim nisn As String             ' "0012345678" (String karena tidak dihitung)
Dim tanggalLahir As Date       ' #15/03/2010#
Dim tinggiBadan As Double      ' 165.5 (cm)
Dim beratBadan As Decimal      ' 55.75 (kg)
Dim aktifBerorganisasi As Boolean ' True
```

**Kasus 2: Sistem Penilaian**
```vb
Dim nilaiHarian As Integer     ' 85
Dim nilaiUTS As Integer        ' 90
Dim nilaiUAS As Integer        ' 88
Dim rataRata As Double         ' 87.67 (hasil perhitungan desimal)
Dim statusLulus As Boolean     ' True (jika rata-rata >= KKM)
```

**Mengapa NISN adalah String?**
Meskipun NISN terdiri dari angka, kita tidak pernah melakukan operasi matematika pada NISN (tidak pernah menjumlahkan atau mengalikan NISN). Oleh karena itu, lebih aman menyimpannya sebagai `String` untuk menghindari error dan mempertahankan angka nol di depan (misal: "001234567").

**Tips Efisiensi:**
*   Gunakan `Integer` untuk bilangan bulat, bukan `Double`. Ini menghemat memori.
*   Gunakan `Decimal` untuk nilai uang karena lebih presisi daripada `Double`.
*   Gunakan `Boolean` untuk kondisi ya/tidak, jangan gunakan `String` ("Ya"/"Tidak") karena lebih boros memori.

![alt text](img/GAMBAR%202.5.png)

> **[GAMBAR 2.5: Form Input Biodata Siswa dengan Tipe Data Berbeda]**
<!-- > *Label: Tampilan form dengan berbagai TextBox yang akan menyimpan tipe data berbeda.* -->

---

## 5. Materi 3: Logika Operasi Aritmatika

Aplikasi pendidikan sering kali memerlukan perhitungan, seperti menghitung nilai akhir, rata-rata, atau luas bangun datar untuk media pembelajaran Matematika. VB.NET menyediakan operator aritmatika untuk keperluan ini.

### 5.1. Operator Aritmatika Dasar

| Operator | Fungsi | Contoh Kode | Hasil |
|----------|--------|-------------|-------|
| **`+`** | Penjumlahan | `5 + 3` | 8 |
| **`-`** | Pengurangan | `10 - 4` | 6 |
| **`*`** | Perkalian | `6 * 7` | 42 |
| **`/`** | Pembagian (Desimal) | `10 / 4` | 2.5 |
| **`\`** | Pembagian (Bulat) | `10 \ 4` | 2 |
| **`^`** | Pangkat | `5 ^ 2` | 25 |
| **`Mod`** | Sisa Bagi | `10 Mod 3` | 1 |

![alt text](img/GAMBAR%202.6.png)
> **[GAMBAR 2.6: Tabel Operator Aritmatika VB.NET]**

### 5.2. Prioritas Operator (Order of Operations)

VB.NET mengikuti aturan matematika standar dalam mengeksekusi operasi. Urutan prioritas adalah:

1.  **Tanda Kurung `()`** - Paling tinggi prioritasnya
2.  **Pangkat `^`**
3.  **Perkalian `*` dan Pembagian `/`, `\`**
4.  **Sisa Bagi `Mod`**
5.  **Penjumlahan `+` dan Pengurangan `-`** - Paling rendah

**Contoh:**
```vb
Dim hasil1 As Integer = 5 + 3 * 2        ' Hasil: 11 (perkalian dulu)
Dim hasil2 As Integer = (5 + 3) * 2      ' Hasil: 16 (kurung dulu)
Dim hasil3 As Double = 10 + 20 / 4 - 2   ' Hasil: 13 (20/4=5, 10+5=15, 15-2=13)
```

> **Tips:**
Selalu gunakan tanda kurung untuk memperjelas logika perhitungan, bahkan jika secara teknis tidak diperlukan. Ini membuat kode Anda lebih mudah dibaca oleh orang lain.

```vb
' Lebih jelas dengan kurung
Dim nilaiAkhir As Double = (nilaiHarian * 0.3) + (nilaiUTS * 0.3) + (nilaiUAS * 0.4)
```

### 5.3. Konversi Tipe Data: `Val()`, `CInt()`, `CDbl()`

**Masalah Umum:**
Data yang masuk dari `TextBox` selalu bertipe **String**, meskipun user mengetik angka. Jika Anda mencoba menjumlahkan dua TextBox secara langsung, VB.NET akan **menggabungkan teks**, bukan menjumlahkan angka!

**Contoh Error Logika:**
```vb
' SALAH!
Dim hasil As String = TextBox1.Text + TextBox2.Text
' Jika TextBox1 = "5" dan TextBox2 = "3", hasil = "53" (bukan 8!)
```

**Solusi: Konversi Tipe Data**
Anda harus mengonversi teks menjadi angka sebelum melakukan perhitungan.

| Fungsi | Deskripsi | Contoh |
|--------|-----------|--------|
| **`Val()`** | Mengubah string menjadi angka (sederhana) | `Val("85")` = 85 |
| **`CInt()`** | Convert to Integer (pembulatan) | `CInt("85.7")` = 86 |
| **`CDbl()`** | Convert to Double | `CDbl("85.5")` = 85.5 |
| **`CDec()`** | Convert to Decimal | `CDec("100.50")` = 100.50 |

> **Rekomendasi:**
Gunakan `CInt()`, `CDbl()`, atau `CDec()` karena lebih ketat dan aman daripada `Val()`. Fungsi-fungsi ini akan memberikan error jika teks tidak bisa dikonversi, sehingga Anda bisa menangani error tersebut.

![alt text](img/GAMBAR%202.7.png)
> **[GAMBAR 2.7: Demonstrasi Error Konkatensi vs Penjumlahan]**

---

## 6. Implementasi Kode: Kalkulator Skor Sederhana

Mari kita terapkan semua konsep di atas dengan membuat aplikasi **"Kalkulator Skor Sederhana"**. Aplikasi ini akan menghitung nilai akhir siswa berdasarkan bobot nilai Harian, UTS, dan UAS.

### Langkah 1: Desain Form

Buat proyek baru bernama `KalkulatorSkor`. Desain form dengan komponen berikut:

| Komponen | Nama (Name) | Text | Keterangan |
|----------|-------------|------|------------|
| Label | `lblJudul` | "Kalkulator Nilai Siswa" | Judul aplikasi |
| Label | `lblHarian` | "Nilai Harian:" | Label input |
| TextBox | `txtHarian` | - | Input nilai harian |
| Label | `lblUTS` | "Nilai UTS:" | Label input |
| TextBox | `txtUTS` | - | Input nilai UTS |
| Label | `lblUAS` | "Nilai UAS:" | Label input |
| TextBox | `txtUAS` | - | Input nilai UAS |
| Button | `btnHitung` | "Hitung Nilai Akhir" | Tombol proses |
| Button | `btnReset` | "Reset" | Tombol|
| Label | `lblHasil` | "Nilai Akhir: -" | Output hasil |
| Label | `lblStatus` | "Status: -" | Output kelulusan |

![alt text](img/GAMBAR%202.8.png)

> **[GAMBAR 2.8: Desain Form Kalkulator Skor]**

### Langkah 2: Menulis Kode Program

Klik dua kali tombol `btnHitung` dan masukkan kode berikut:

```vb
Public Class Form1

    ' Deklarasi Konstanta untuk bobot dan KKM
    Const BOBOT_HARIAN As Double = 0.3
    Const BOBOT_UTS As Double = 0.3
    Const BOBOT_UAS As Double = 0.4
    Const KKM As Integer = 75

    Private Sub btnHitung_Click(sender As Object, e As EventArgs) Handles btnHitung.Click
        
        ' Deklarasi variabel untuk menyimpan nilai
        Dim nilaiHarian As Double
        Dim nilaiUTS As Double
        Dim nilaiUAS As Double
        Dim nilaiAkhir As Double
        Dim status As String

        ' Konversi input dari TextBox menjadi angka
        ' CDbl digunakan karena nilai bisa desimal
        nilaiHarian = CDbl(txtHarian.Text)
        nilaiUTS = CDbl(txtUTS.Text)
        nilaiUAS = CDbl(txtUAS.Text)

        ' Perhitungan nilai akhir dengan bobot
        nilaiAkhir = (nilaiHarian * BOBOT_HARIAN) + _
                     (nilaiUTS * BOBOT_UTS) + _
                     (nilaiUAS * BOBOT_UAS)

        ' Menampilkan nilai akhir dengan 2 angka desimal
        lblHasil.Text = "Nilai Akhir: " & nilaiAkhir.ToString("F2")

        ' Menentukan status kelulusan
        If nilaiAkhir >= KKM Then
            status = "Lulus"
            lblStatus.ForeColor = Color.Green
        Else
            status = "Remedial"
            lblStatus.ForeColor = Color.Red
        End If

        lblStatus.Text = "Status: " & status

    End Sub

End Class
```

![alt text](img/GAMBAR%202.9.png)
> **[GAMBAR 2.9: Kode Program btnHitung_Click]**

### Penjelasan Baris per Baris

| No | Kode | Penjelasan |
|----|------|------------|
| 1-4 | `Const BOBOT_...` | Deklarasi konstanta untuk bobot penilaian. Nilai tetap tidak berubah. |
| 5 | `Const KKM As Integer = 75` | Konstanta KKM sebagai standar kelulusan. |
| 6 | `Private Sub btnHitung_Click...` | Event handler yang aktif saat tombol Hitung diklik. |
| 7-11 | `Dim ... As Double` | Deklarasi variabel untuk menyimpan nilai sementara. |
| 12-14 | `nilaiHarian = CDbl(txtHarian.Text)` | **Konversi tipe data** dari String (TextBox) ke Double (angka). |
| 15-18 | `nilaiAkhir = ...` | Rumus perhitungan nilai akhir dengan bobot. Tanda `_` untuk lanjut baris. |
| 19 | `ToString("F2")` | Format angka menjadi 2 digit desimal (contoh: 85.67). |
| 20-27 | `If nilaiAkhir >= KKM Then...` | Percabangan untuk menentukan status Lulus atau Remedial. |
| 21, 24 | `ForeColor = Color.Green/Red` | Mengubah warna teks berdasarkan status (visual feedback). |

### Langkah 3: Tombol Reset

Klik dua kali tombol `btnReset` dan masukkan kode:

```vb
Private Sub btnReset_Click(sender As Object, e As EventArgs) Handles btnReset.Click
    ' Kosongkan semua TextBox
    txtHarian.Text = ""
    txtUTS.Text = ""
    txtUAS.Text = ""
    
    ' Reset label hasil
    lblHasil.Text = "Nilai Akhir: -"
    lblStatus.Text = "Status: -"
    
    ' Fokus ke TextBox pertama
    txtHarian.Focus()
End Sub
```

![alt text](img/GAMBAR%202.10.png)

> **[GAMBAR 2.10: Hasil Running Aplikasi Kalkulator Skor]**

---

## 7. Latihan Praktikum Mandiri

### Tugas: Aplikasi Penghitung Luas Bangun Datar

**Deskripsi:**
Buatlah sebuah aplikasi media pembelajaran untuk siswa SD yang dapat menghitung **Luas Segitiga**. Aplikasi ini akan membantu siswa memverifikasi jawaban mereka saat belajar Matematika.

**Rumus Luas Segitiga:**
```
Luas = (alas × tinggi) ÷ 2
```

**Spesifikasi Aplikasi:**

| Komponen | Nama (Name) | Text/Properties |
|----------|-------------|-----------------|
| Form | `Form1` | Text = "Penghitung Luas Segitiga" |
| Label | `lblAlas` | "Panjang Alas (cm):" |
| TextBox | `txtAlas` | - |
| Label | `lblTinggi` | "Tinggi (cm):" |
| TextBox | `txtTinggi` | - |
| Button | `btnHitungLuas` | "Hitung Luas" |
| Button | `btnKeluar` | "Keluar" |
| Label | `lblHasilLuas` | "Luas: - cm²" |

**Langkah Pengerjaan:**

1.  Buat proyek baru bernama `LuasSegitiga`.
2.  Desain form sesuai spesifikasi di atas.
3.  Tulis kode untuk tombol `btnHitungLuas`:
    *   Gunakan konstanta untuk nilai pembagi (2).
    *   Konversi input TextBox menjadi `Double`.
    *   Hitung luas menggunakan rumus.
    *   Tampilkan hasil dengan format 2 desimal.
4.  Tulis kode untuk tombol `btnKeluar`:
    *   Gunakan `Application.Exit()` untuk menutup aplikasi.
5.  Tambahkan validasi: Jika input kosong, tampilkan MessageBox peringatan.

**Contoh Kode yang Diharapkan:**

```vb
Const PEMBAGI As Integer = 2

Private Sub btnHitungLuas_Click(...) Handles btnHitungLuas.Click
    Dim alas As Double
    Dim tinggi As Double
    Dim luas As Double

    If txtAlas.Text = "" Or txtTinggi.Text = "" Then
        MessageBox.Show("Harap isi alas dan tinggi!", "Peringatan")
        Exit Sub
    End If

    alas = CDbl(txtAlas.Text)
    tinggi = CDbl(txtTinggi.Text)
    luas = (alas * tinggi) / PEMBAGI

    lblHasilLuas.Text = "Luas: " & luas.ToString("F2") & " cm²"
End Sub

Private Sub btnKeluar_Click(...) Handles btnKeluar.Click
    Application.Exit()
End Sub
```

![alt text](img/GAMBAR%202.11.png)
> **[GAMBAR 2.11: Desain Form Penghitung Luas Segitiga]**

![alt text](img/GAMBAR%202.12.png)
> **[GAMBAR 2.12: Hasil Running Aplikasi Luas Segitiga]**

**Nilai Karakter:**
Aplikasi ini bukan hanya latihan coding, tetapi juga bentuk **pengabdian** Anda sebagai calon guru dalam menciptakan media pembelajaran yang membantu siswa memahami konsep Matematika dengan lebih interaktif.

---

## 8. Evaluasi & Rangkuman

### A. Soal Pilihan Ganda

**1.** Seorang programmer ingin menyimpan data NISN siswa yang terdiri dari 10 digit angka. Tipe data yang PALING TEPAT adalah:
*   A. Integer
*   B. Double
*   C. String
*   D. Boolean

**2.** Manakah deklarasi konstanta yang BENAR untuk menyimpan nilai Phi (3.14)?
*   A. `Dim PHI As Double = 3.14`
*   B. `Const PHI As Double = 3.14`
*   C. `Const PHI = 3.14`
*   D. `Constant PHI As Double = 3.14`

**3.** Jika `TextBox1.Text = "10"` dan `TextBox2.Text = "5"`, apa hasil dari kode berikut?
   ```vb
   Dim hasil As Integer = CInt(TextBox1.Text) + CInt(TextBox2.Text)
   ```
*   A. 105
*   B. 15 
*   C. Error
*   D. "105"

### B. Soal Analisis

**Kasus:**
Apa yang terjadi jika variabel String dijumlahkan dengan variabel Integer dalam VB.NET? Jelaskan solusinya!

### C. Rangkuman Bab 2

| No | Poin Kunci | Deskripsi Singkat |
|----|------------|-------------------|
| 1 | **Variabel** | Tempat penyimpanan data dengan nama unik menggunakan `Dim`. |
| 2 | **Konstanta** | Nilai tetap yang tidak berubah menggunakan `Const`. |
| 3 | **Naming Convention** | Gunakan CamelCase untuk nama variabel yang mudah dibaca. |
| 4 | **Tipe Data** | Pilih sesuai kebutuhan: String (teks), Integer (bulat), Double/Decimal (desimal), Boolean (logika). |
| 5 | **Operator Aritmatika** | `+`, `-`, `*`, `/`, `^`, `Mod` dengan prioritas operasi yang jelas. |
| 6 | **Konversi Tipe Data** | Gunakan `CInt()`, `CDbl()`, `CDec()` untuk mengonversi String dari TextBox menjadi angka. |
| 7 | **Efisiensi Memori** | Pilih tipe data yang tepat untuk aplikasi yang ringan dan cepat. |
| 8 | **Etika Coding** | Kode yang rapi dan terstruktur adalah bentuk amanah terhadap pengguna dan maintainer. |

---


## Penutup

Selamat! Anda telah menyelesaikan Bab 2. Sekarang Anda memahami cara menyimpan data, memilih tipe data yang tepat, dan melakukan perhitungan dalam VB.NET. Ini adalah fondasi penting sebelum kita melangkah ke bab berikutnya yang akan membahas **Struktur Percabangan (If-Else)** dan **Perulangan (Looping)** untuk membuat aplikasi yang lebih cerdas dan dinamis.

> *"Kode yang baik adalah kode yang tidak hanya berjalan, tetapi juga mudah dipahami oleh orang lain."* — Teruslah berlatih dan berkarya!

