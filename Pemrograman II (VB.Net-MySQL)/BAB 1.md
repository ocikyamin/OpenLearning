# BAB 1: Fondasi IDE Visual Studio dan Analisis Sistem

## 1. Pendahuluan

Mungkin Anda bertanya, *"Saya calon guru. Mengapa saya harus belajar coding?"* Pertanyaan ini sangat wajar. Di era transformasi digital saat ini, seorang pendidik tidak lagi hanya dituntut menjadi pengguna teknologi (konsumen), tetapi juga diharapkan mampu menjadi kreator solusi teknologi (inovator) untuk masalah-masalah di kelasnya.

> Bayangkan Anda mengalami kesulitan merekap nilai harian siswa karena tumpukan kertas yang sering hilang, atau Anda ingin membuat media interaktif sederhana untuk membantu siswa memahami konsep matematika yang abstrak. Jika Anda bergantung sepenuhnya pada aplikasi jadi, Anda mungkin terbatas pada fitur yang disediakan pengembangnya. Namun, dengan kemampuan memprogram menggunakan **VB.NET** dan **MySQL**, Anda memiliki kuasa untuk menciptakan alat bantu ajar yang *custom*, sesuai dengan kebutuhan spesifik siswa Anda.

Proses penciptaan aplikasi ini dikenal dengan istilah **Software Development Life Cycle (SDLC)** atau Siklus Hidup Pengembangan Perangkat Lunak. SDLC adalah peta jalan yang membimbing kita dari sekadar sebuah "ide" menjadi "aplikasi yang berfungsi". Dalam buku ini, kita akan menelusuri tahap awal SDLC, yaitu perencanaan dan analisis, sebelum masuk ke tahap konstruksi kode.

Tools utama kita dalam pembelajaran ini adalah **Microsoft Visual Studio**. Bayangkan Visual Studio sebagai "bengkel kerja" lengkap bagi seorang *developer*. Di dalamnya terdapat segala peralatan yang dibutuhkan: **tempat menulis kode, tempat mendesain tampilan, alat uji coba, hingga alat untuk merapikan proyek**. Menguasai bengkel ini adalah langkah pertama Anda menjadi guru yang melek teknologi dan mampu menciptakan solusi digital yang dapat dipercaya, aman, dan bertanggung jawab dalam mengelola data khususnya data pendidikan.

---

## 2. Capaian Pembelajaran

Sebelum memulai materi, mari kita tetapkan target kompetensi yang harus Anda capai setelah mempelajari bab ini. Berikut adalah sasaran pembelajaran kita:

*   **Sub-CPMK 1:** Mahasiswa mampu menginstalasi, mengonfigurasi, dan menavigasi lingkungan kerja Integrated Development Environment (IDE) Visual Studio 2022 untuk pengembangan aplikasi desktop (.NET) dengan tepat.
*   **Sub-CPMK 2:** Mahasiswa mampu menganalisis kebutuhan sistem sederhana di lingkungan pendidikan menggunakan pendekatan *Input-Process-Output* (IPO) serta menerapkan etika digital dalam perancangan awal aplikasi.

---

## 3. Materi 1: Instalasi & Konfigurasi Visual Studio 2022

Langkah pertama dalam membangun rumah adalah menyiapkan fondasi dan perkakas. Dalam pemrograman, fondasi tersebut adalah instalasi IDE yang benar. Visual Studio adalah **IDE** *(Integrated Development Environment)* yang sangat powerful buatan Microsoft. Untuk keperluan kita membuat aplikasi desktop dengan VB.NET, kita tidak perlu menginstal semua fiturnya, cukup komponen yang relevan agar komputer tidak berat.

### 3.1. Mengunduh Visual Studio
Pastikan Anda mengunduh versi terbaru, yaitu **Visual Studio 2022** (Community Edition). Versi Community ini gratis untuk pelajar, pengajar, dan pengembangan open-source, sehingga sangat cocok untuk mahasiswa.

*   **Link Resmi Unduhan:** [Download Visual Studio 2022](https://visualstudio.microsoft.com/downloads/)
*   **Panduan Video Instalasi:** Untuk panduan visual langkah demi langkah, Anda dapat menyimak tutorial berikut: [Video Tutorial Instalasi Visual Studio di YouTube](https://www.youtube.com/results?search_query=install+visual+studio+2022+for+vb.net)

![alt text](img/GAMBAR%201.1.png)
> **GAMBAR 1.1: Tampilan Halaman Download Visual Studio**
> Perhatikan tombol "Download Free" untuk versi Community.

### 3.2. Memilih Workload yang Tepat
Saat Anda menjalankan installer Visual Studio, Anda akan dihadapkan pada banyak pilihan kotak centang yang disebut **Workloads**. Ini adalah paket fitur berdasarkan jenis aplikasi yang ingin dibuat. Kesalahan memilih workload bisa berakibat pada instalasi yang gagal berjalan atau fitur yang hilang.

Untuk buku ajar ini, pastikan Anda mencentang satu workload utama:
*   ✅ **.NET Desktop Development**

Workload ini sudah mencakup:
*   Bahasa pemrograman **Visual Basic**.
*   Desainer Form (untuk membuat tampilan aplikasi Windows).
*   Komponen dasar .NET Framework atau .NET 8/9.

![alt text](img/GAMBAR%201.2.png)

> **GAMBAR 1.2: Jendela Visual Studio Installer**
>*Pastikan kotak ".NET Desktop Development" telah dicentang (berwarna biru).*

> *Tips:* Jangan tergiur mencentang semua opsi seperti "Game Development" atau "Mobile Development" jika spesifikasi laptop Anda standar. Itu hanya akan memakan ruang penyimpanan dan memperlambat kinerja IDE. Fokuslah pada apa yang kita butuhkan: Aplikasi Desktop.

### 3.3. Struktur File Proyek
Setelah instalasi selesai dan Anda membuat proyek baru, Visual Studio akan menghasilkan beberapa file penting. Anda harus memahami perbedaan ini agar tidak salah menghapus file vital.

1.  **File Solusi (`.sln`):**
    Bayangkan file ini sebagai "Map Besar" atau wadah utama. Sebuah solusi bisa berisi satu atau lebih proyek. Jika Anda membuka file `.sln`, Visual Studio akan memuat seluruh ekosistem proyek Anda. Nama filenya biasanya mengikuti nama proyek, misalnya `ProyekMediaPembelajaran.sln`.
2.  **File Proyek (`.vbproj`):**
    Ini adalah file konfigurasi khusus untuk proyek VB.NET Anda. File ini mencatat referensi library, pengaturan kompilasi, dan daftar file yang termasuk dalam proyek. Ekstensinya adalah `.vbproj`. Anda jarang perlu mengedit file ini secara manual melalui Notepad, biarkan Visual Studio yang mengelolanya.
3.  **File Form (`.vb` dan `.Designer.vb`):**
    Setiap tampilan jendela (Form) yang Anda buat akan memiliki dua file terkait.
    *   `.vb`: Tempat Anda menulis logika kode (event handling).
    *   `.Designer.vb`: File yang dihasilkan otomatis oleh Visual Studio yang berisi kode untuk menggambar tombol, label, dan textbox yang Anda letakkan di layar.

![alt text](img/GAMBAR%201.3.png)

> **GAMBAR 1.3: Struktur Folder Proyek di Windows Explorer**

**Manajemen File yang baik:**
Biasakan membuat folder khusus untuk setiap proyek dan jangan pernah memindahkan file-file penyusun proyek (seperti `.Designer.vb`) secara manual lewat Windows Explorer, karena dapat merusak link referensi di dalam file `.vbproj`. Selalu pindahkan atau hapus file melalui *Solution Explorer* di dalam Visual Studio.

---

## 4. Materi 2: Eksplorasi Lingkungan Kerja (IDE)

Setelah proyek terbuka, Anda akan disambut oleh antarmuka Visual Studio yang mungkin terlihat rumit bagi pemula. Tenang, mari kita bedah menjadi tiga area utama yang akan menjadi sahabat sehari-hari Anda.

![alt text](img/GAMBAR%201.4.png)

> **GAMBAR 1.4: Tampilan Utama IDE Visual Studio 2022**
<!-- > *Label: Tampilan awal IDE setelah proyek dibuka. Area ini menunjukkan letak Toolbox, Properties Window, Solution Explorer, dan Area Desain Form.* -->

### 4.1. Toolbox
Di sisi kiri layar (biasanya), terdapat panel bernama **Toolbox**. Ini adalah gudang peralatan Anda. Di sinilah tersimpan berbagai komponen siap pakai seperti:
*   **Label:** Untuk menampilkan teks statis (contoh: "Nama Siswa").
*   **TextBox:** Kotak input bagi pengguna untuk mengetik data.
*   **Button:** Tombol perintah untuk menjalankan suatu aksi.
*   **DataGridView:** Tabel untuk menampilkan data dari database.

Cara menggunakannya sangat mudah: Cukup *klik* komponen yang diinginkan, lalu *tarik dan lepas* (drag-and-drop) ke area Form (kanvas putih di tengah).

![alt text](img/GAMBAR%201.5.png)

> **[GAMBAR 1.5: Panel Toolbox dan Komponen Umum]**

### 4.2. Properties Window: Pengatur Sifat Objek
Setiap objek yang Anda ambil dari Toolbox memiliki sifat atau karakteristik. Misalnya, sebuah tombol bisa berwarna merah, bertuliskan "Simpan", dan memiliki font tebal. Panel **Properties Window** (biasanya di kanan bawah) adalah tempat Anda mengubah sifat-sifat ini tanpa perlu menulis kode.

*   **(Name):** Memberi nama unik pada objek agar bisa dipanggil dalam kode (misal: `btnSimpan`).
*   **Text:** Mengubah tulisan yang tampil di layar.
*   **BackColor:** Mengubah warna latar belakang.
*   **Font:** Mengatur jenis dan ukuran huruf.

Sebagai calon guru, ketelitian dalam memberi nama properti `(Name)` sangat penting. Nama yang deskriptif (seperti `txtNamaSiswa` daripada `TextBox1`) akan membuat kode Anda mudah dibaca dan dirawat di masa depan. Ini adalah cerminan dari sikap profesionalisme dan amanah dalam coding.

![alt text](img/GAMBAR%201.6.png)

> **[GAMBAR 1.6: Jendela Properties Window]**

### 4.3. Solution Explorer: Peta Proyek
Panel **Solution Explorer** (biasanya di kanan atas) berfungsi sebagai peta struktur folder proyek Anda. Di sini Anda bisa melihat hierarki file: di mana file Form berada, di mana modul kode disimpan, dan referensi library apa saja yang digunakan. Jika Anda ingin menambahkan file baru, menghapus form, atau melihat kode sumber, semuanya bermula dari sini.
![alt text](img/GAMBAR%201.7.png)

> **GAMBAR 1.7: Panel Solution Explorer**

### 4.4. Konsep Event-Driven Programming
VB.NET bekerja dengan paradigma **Event-Driven** (Berbasis Kejadian). Apa artinya?

Dalam pemrograman prosedural tradisional, program berjalan dari baris 1 sampai baris terakhir secara urut. Namun, dalam aplikasi Windows (Desktop), program menunggu **pengguna** melakukan sesuatu.
*   **Event (Kejadian):** Adalah aksi yang dilakukan user, seperti mengklik mouse, menekan tombol keyboard, atau membuka form.
*   **Response (Respon):** Adalah kode program yang dijalankan sebagai tanggapan atas event tersebut.

**Analogi Sederhana:**
Bayangkan sebuah bel sekolah.
*   **Event:** Tangan penjaga sekolah menekan tombol bel.
*   **Objek:** Tombol bel.
*   **Response:** Bunyi bel berbunyi nyaring di seluruh kelas.

Dalam VB.NET, jika Anda memiliki tombol bernama `btnHalo` di layar, program akan "tidur" menunggu kejadian `Click`. Saat user mengklik tombol itu, Visual Studio akan membuat kode khusus yang bernama `btnHalo_Click` dan menjalankannya. Tanpa event klik tersebut, kode di dalamnya tidak akan pernah berjalan.

---

## 5. Materi 3: Analisis Sistem

Sebelum kita mengetik kode, seorang pengembang harus melakukan **Analisis Sistem**. Banyak proyek gagal bukan karena kodenya salah, tapi karena solusinya tidak menjawab masalah yang sebenarnya.

### 5.1. Identifikasi Masalah
Amati lingkungan sekitar Anda. Masalah apa yang sering berulang?
*   *Kasus 1:* Guru sering lupa siapa siswa yang belum mengumpulkan tugas karena catatan manual tercecer.
*   *Kasus 2:* Perhitungan nilai akhir siswa memakan waktu lama karena harus menghitung bobot nilai harian, UTS, dan UAS secara manual di kalkulator.
*   *Kasus 3:* Perpustakaan mini kelas sulit dikelola karena buku sering hilang tanpa jejak peminjam.

Aplikasi komputer hadir untuk menyelesaikan masalah-masalah ini. Tujuannya adalah efisiensi, akurasi, dan kemudahan akses data.

### 5.2. Teknik IPO (Input - Process - Output)
Untuk merancang solusi, kita gunakan metode **IPO**. Ini adalah kerangka berpikir logis yang memetakan aliran data.

1.  **Input (Masukan):** Data apa yang perlu dimasukkan oleh pengguna?
    *   Contoh: Nama Siswa, Nilai Harian, Kehadiran.
2.  **Process (Proses):** Apa yang harus dilakukan komputer terhadap data tersebut?
    *   Contoh: Menjumlahkan nilai, menghitung rata-rata, menyimpan data ke database, mengecek apakah nilai lulus atau gagal.
3.  **Output (Keluaran):** Apa hasil yang ingin dilihat pengguna?
    *   Contoh: Laporan kartu nilai, pesan "Lulus/Tidak Lulus", grafik absensi.

**Contoh Penerapan IPO pada Aplikasi Kuis Sederhana:**
*   **Input:** Jawaban yang dipilih siswa (A, B, C, atau D).
*   **Proses:** Sistem mencocokkan jawaban siswa dengan kunci jawaban, lalu menambah skor jika benar.
*   **Output:** Menampilkan nilai akhir dan pesan motivasi ("Hebat!" atau "Belajar Lagi ya!").

![alt text](img/GAMBAR%201.8.png)
> **GAMBAR 1.8: Diagram Alur IPO Sederhana**


**Integrasi Etika Digital:**
Jika aplikasi kita nantinya menyimpan data nilai siswa, kita harus merancang sistem yang menjaga kerahasiaan data tersebut. Jangan sampai data nilai siswa bocor atau bisa diubah oleh pihak yang tidak berhak.

---

## 6. Aktivitas Praktikum

Mari kita praktikkan teori di atas. Kita akan membuat aplikasi sederhana bernama **"ProyekMediaPembelajaran"**. Aplikasi ini akan memiliki satu form yang menyapa pengguna ketika tombol ditekan.

### Langkah 1: Membuat Proyek Baru

Ikuti langkah-langkah berikut dengan teliti untuk membuat proyek pertama Anda:

**Step 1: Buka Visual Studio 2022**
Setelah aplikasi Visual Studio 2022 terbuka, Anda akan melihat halaman awal (Start Window). Klik tombol **"Create a new project"** (Buat proyek baru).
![alt text](img/GAMBAR%201.9.png)

> **[GAMBAR 1.9: Halaman Awal Visual Studio 2022]**

**Step 2: Pilih Template Proyek dengan Filter yang Tepat**
Ini adalah langkah **KRUSIAL** yang harus diperhatikan. Di jendela "Create a new project", Anda akan melihat banyak pilihan template. Agar tidak bingung dan memastikan Anda memilih template yang benar untuk VB.NET Desktop, gunakan **3 Filter Wajib** berikut:

| Filter | Pilihan yang Harus Dipilih | Keterangan |
|--------|---------------------------|------------|
| **All Languages** | **Visual Basic** | Memastikan hanya template VB.NET yang muncul |
| **All Platforms** | **Windows** | Memastikan aplikasi berjalan di sistem operasi Windows |
| **All Project Types** | **Desktop** | Memastikan jenis aplikasi adalah Desktop (Windows Forms/WPF) |

![alt text](img/GAMBAR%201.10.png)
> **[GAMBAR 1.10: Jendela Filter Template Proyek]**

**Penjelasan Penting tentang Filter:**

1.  **All Languages (Visual Basic):**
    Visual Studio mendukung banyak bahasa pemrograman seperti C#, C++, Python, dan Visual Basic. Karena buku ini fokus pada **VB.NET**, Anda **WAJIB** memilih "Visual Basic" agar template yang muncul sesuai dengan syntax yang akan kita pelajari. Jika Anda salah memilih C#, kode program tidak akan kompatibel.

2.  **All Platforms (Windows):**
    Filter ini menentukan sistem operasi target aplikasi. Karena kita membuat aplikasi desktop yang berjalan di komputer/laptop dengan sistem operasi Windows, pilihlah "Windows". Ini berbeda dengan "Android", "iOS", atau "Web" yang memerlukan konfigurasi berbeda.

3.  **All Project Types (Desktop):**
    Ini adalah filter jenis aplikasi. "Desktop" berarti aplikasi yang diinstal dan dijalankan langsung di komputer (seperti Microsoft Word, Excel, dll). Ini berbeda dengan "Web" (aplikasi browser) atau "Mobile" (aplikasi smartphone). Untuk kebutuhan administrasi sekolah dan media pembelajaran offline, Desktop adalah pilihan paling stabil.

Setelah ketiga filter diterapkan, cari dan pilih template:
*   **Windows Forms App (.NET Framework)**

![alt text](img/GAMBAR%201.11.png)

> **[GAMBAR 1.11: Template Windows Forms App yang Terpilih]**

**Step 3: Konfigurasi Nama dan Lokasi Proyek**
Klik **Next**. Anda akan dibawa ke jendela konfigurasi proyek. Isi data berikut dengan teliti:

| Kolom | Isi yang Disarankan | Keterangan |
|-------|---------------------|------------|
| **Project name** | `ProyekMediaPembelajaran` | Nama proyek (tanpa spasi) |
| **Location** | `C:\Users\[NamaUser]\Documents\Kuliah\Pemrograman\Bab1` | Folder penyimpanan terorganisir |
| **Solution name** | `ProyekMediaPembelajaran` | Biasanya sama dengan project name |
| **Framework** | `.NET Framework 8.0` | Versi framework yang stabil untuk pembelajaran |

![alt text](img/GAMBAR%201.12.png)

> **[GAMBAR 1.12: Jendela Konfigurasi Nama dan Lokasi Proyek]**

**Tips:**
*   Hindari menggunakan spasi atau karakter khusus (seperti @, #, $) dalam nama proyek. Gunakan huruf kapital di setiap awal kata (CamelCase) seperti `ProyekMediaPembelajaran` agar mudah dibaca.
*   Buatlah folder khusus untuk setiap pertemuan atau bab. Ini mencerminkan sikap **Amanah** dalam mengelola file dan memudahkan Anda menemukan proyek saat diperlukan nanti.

**Step 4: Finalisasi Pembuatan Proyek**
Klik tombol **Create**. Visual Studio akan memproses dan membuka lingkungan kerja IDE dengan proyek baru Anda.

![alt text](img/GAMBAR%201.13.png)

> **[GAMBAR 1.13: Proyek Baru Berhasil Dibuat]**
> *Tampilan IDE setelah proyek berhasil dibuat. Form1 kosong siap untuk didesain.*

---

### Langkah 2: Mendesain UI (Form)

Sekarang Anda melihat sebuah kotak kosong abu-abu. Ini adalah **Form1**, jendela utama aplikasi Anda.

1.  Buka **Toolbox**. Cari komponen **Label**, **TextBox**, dan **Button**.
2.  Tarik (**Drag**) satu **Label** ke Form. Ubah properti `Text`-nya di jendela Properties menjadi: `"Silakan Masukkan Nama Anda:"`.
3.  Tarik satu **TextBox** di sebelah kanan Label. Biarkan namanya `TextBox1` (nanti kita ubah di kode jika perlu, tapi untuk sekarang default saja).
4.  Tarik satu **Button** di bawah TextBox. Ubah properti `Text`-nya menjadi `"Tampilkan Salam"`.
5.  Atur posisi dan warna sesuka hati Anda agar terlihat menarik. Ingat, estetika juga penting dalam media pembelajaran!

![alt text](img/GAMBAR%201.14.png)

> **[GAMBAR 1.14: Hasil Desain Form Sederhana]**

---

### Langkah 3: Menulis Kode Pertama (Event-Driven)

Saatnya memberikan "nyawa" pada tombol tersebut.

1.  Klik dua kali (**Double Click**) pada tombol `"Tampilkan Salam"` yang tadi Anda buat.
2.  Secara otomatis, Visual Studio akan membawa Anda ke halaman kode (`Form1.vb`) dan membuat kerangka event `Button1_Click`.
3.  Ketikkan kode berikut di antara baris `Private Sub` dan `End Sub`:

```vb
Public Class Form1

    ' Ini adalah event handler yang aktif ketika Button1 diklik
    Private Sub Button1_Click(sender As Object, e As EventArgs) Handles Button1.Click
        
        ' Deklarasi variabel untuk menyimpan nama dari TextBox
        ' Variabel adalah tempat menyimpan data sementara di memori
        Dim namaSiswa As String
        
        ' Mengambil teks yang diketik user di TextBox1 dan menyimpannya ke variabel namaSiswa
        namaSiswa = TextBox1.Text
        
        ' Mengecek apakah user memasukkan nama atau tidak (Logika Sederhana)
        If namaSiswa = "" Then
            ' Jika kosong, tampilkan pesan peringatan
            MessageBox.Show("Harap isi nama Anda terlebih dahulu!", "Peringatan", MessageBoxButtons.OK, MessageBoxIcon.Warning)
        Else
            ' Jika ada isinya, tampilkan pesan selamat datang
            ' & adalah operator untuk menggabungkan teks (kongkatensi)
            Dim pesan As String = "Selamat Datang, " & namaSiswa & "! Semoga sukses belajar VB.NET."
            
            MessageBox.Show(pesan, "Salam Pendidik", MessageBoxButtons.OK, MessageBoxIcon.Information)
        End If
        
    End Sub

End Class
```
![alt text](img/GAMBAR%201.15.png)

> **[GAMBAR 1.15: Editor Kode (Code View)]**

---

### Penjelasan Baris per Baris (Code Walkthrough)

Agar Anda paham betul alur logikanya, mari kita bedah kodenya:

| No | Kode | Penjelasan |
|----|------|------------|
| 1 | `Private Sub Button1_Click(...)` | Definisi **Event**. Kode di dalam blok ini hanya akan berjalan jika `Button1` diklik oleh mouse. |
| 2 | `Dim namaSiswa As String` | Memesan tempat di memori bernama `namaSiswa` untuk menyimpan data tipe teks (`String`). |
| 3 | `namaSiswa = TextBox1.Text` | Mengambil teks dari `TextBox1` dan menyimpannya ke variabel `namaSiswa`. |
| 4 | `If namaSiswa = "" Then` | Percabangan logika. Program memeriksa apakah isi `namaSiswa` kosong. |
| 5 | `MessageBox.Show(...)` | Perintah memunculkan jendela pesan pop-up dengan ikon Warning atau Information. |
| 6 | `End If` | Menutup blok percabangan. |
| 7 | `End Sub` | Menutup blok event. |

---

### Langkah 4: Menjalankan Aplikasi

1.  Tekan tombol **F5** pada keyboard atau klik tombol hijau bertanda **Play** (Start) di toolbar atas.
2.  Aplikasi akan berjalan. Coba klik tombol tanpa mengisi nama. Apa yang terjadi? (Seharusnya muncul peringatan).
3.  Isi nama Anda, misal "Ahmad", lalu klik tombol. (Seharusnya muncul salam personalisasi).
4.  Untuk menghentikan aplikasi, klik tanda **X** merah atau tekan **Shift + F5**.
![alt text](img/GAMBAR%201.16.png)
> **[GAMBAR 1.16: Hasil Running Aplikasi (MessageBox)]**

![alt text](img/GAMBAR%201.17.png)

> **[GAMBAR 1.17: MessageBox Peringatan saat Input Kosong]**

Selamat! Anda baru saja membuat aplikasi desktop pertama Anda yang interaktif.

---

## 7. Latihan & Evaluasi

Untuk mengukur pemahaman Anda terhadap Bab 1, kerjakan latihan berikut di buku catatan atau lembar kerja digital Anda.

### A. Soal Esai

1.  Jelaskan perbedaan fungsi antara **Toolbox**, **Properties Window**, dan **Solution Explorer** dalam lingkungan Visual Studio! Mengapa ketiga komponen ini vital bagi seorang pengembang pemula?

2.  Dalam konteks *Event-Driven Programming*, jelaskan apa yang dimaksud dengan "Event" dan "Response". Berikan satu contoh kejadian nyata di sekolah yang bisa dimodelkan dengan konsep ini selain contoh tombol di atas!

3.  Mengapa seorang calon guru perlu memahami struktur file proyek (`.sln` dan `.vbproj`)? Hubungkan jawaban Anda dengan sikap **Amanah** dalam pengelolaan aset digital!

4.  Jelaskan mengapa ketiga filter (All Languages, All Platforms, All Project Types) penting saat membuat proyek baru di Visual Studio! Apa risiko jika salah memilih filter?

### B. Studi Kasus Analisis (IPO)

**Kasus:**
Bapak Budi, seorang guru Matematika, sering kesulitan menghitung rata-rata nilai ujian 30 siswanya karena harus melakukannya satu per satu menggunakan kalkulator. Ia ingin sebuah aplikasi sederhana di mana ia bisa memasukkan 3 nilai (Harian, UTS, UAS), dan aplikasi langsung menampilkan Rata-rata serta Status Kelulusan (Lulus jika rata-rata ≥ 75).

**Tugas:**
Rancanglah alur **Input - Process - Output (IPO)** untuk solusi aplikasi Bapak Budi tersebut!

| Komponen | Rancangan Anda |
|----------|----------------|
| **Input** | (Sebutkan data apa saja yang harus dimasukkan) |
| **Process** | (Jelaskan langkah logika/perhitungan yang harus dilakukan komputer) |
| **Output** | (Apa hasil akhir yang ditampilkan di layar) |

---

## 8. Rangkuman Bab 1

Pada bab ini, kita telah meletakkan batu pertama dalam perjalanan mempelajari pemrograman VB.NET & MySQL. Berikut adalah poin-poin kunci yang harus Anda ingat:

| No | Poin Kunci | Deskripsi Singkat |
|----|------------|-------------------|
| 1 | **Peran Guru Digital** | Guru masa kini tidak hanya konsumen teknologi, tetapi creator solusi melalui pemahaman SDLC. |
| 2 | **Visual Studio 2022** | IDE utama dengan workload **.NET Desktop Development**. |
| 3 | **3 Filter Wajib** | All Languages (Visual Basic), All Platforms (Windows), All Project Types (Desktop). |
| 4 | **Struktur File** | Pahami `.sln` (solusi), `.vbproj` (proyek), dan `.vb` (form/kode). |
| 5 | **Komponen IDE** | Toolbox, Properties Window, Solution Explorer adalah tiga panel utama. |
| 6 | **Event-Driven** | Aplikasi VB.NET bekerja berdasarkan respons terhadap aksi pengguna. |
| 7 | **Analisis IPO** | Input-Proses-Output untuk memastikan aplikasi memecahkan masalah dengan tepat. |


---

Dengan menguasai fondasi ini, Anda siap melangkah ke Bab 2, di mana kita akan mulai mendalami variabel, tipe data, dan logika pemrograman yang lebih kompleks untuk membangun aplikasi yang lebih cerdas.