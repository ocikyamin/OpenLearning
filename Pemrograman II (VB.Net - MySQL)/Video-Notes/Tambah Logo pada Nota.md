# Menambahkan Logo Nota Dengan Resources Project

---

# Kenapa Menggunakan Resources?

Daripada menggunakan:

```vbnet id="rs1"
Image.FromFile("logo.png")
```

lebih baik menggunakan:

```text id="rs2"
Project Resources
```

Karena:

* logo otomatis ikut saat aplikasi di-build,
* tidak error saat aplikasi dipindahkan,
* lebih profesional,
* dan dipakai di aplikasi desktop nyata.

---

# HASIL YANG AKAN DIDAPAT

```text id="rs3"
[ LOGO ]

LAINDORI LAUNDRY
Laundry Cepat & Bersih
```

---

# LANGKAH 1

# Siapkan Logo

Gunakan:

* PNG transparan (recommended),
* ukuran sekitar:

  ```text
  512x512
  ```

Contoh:

```text id="rs4"
logo.png
```

---

# LANGKAH 2

# Buka Project Properties

Di Visual Studio:

## Klik:

```text id="rs5"
Project
→ LaundryApp Properties
```

atau:

* klik kanan project
* pilih:

  ```text
  Properties
  ```

---

# LANGKAH 3

# Buka Menu Resources

Pilih tab:

```text id="rs6"
Resources
```

---

# LANGKAH 4

# Tambahkan Logo

Klik:

```text id="rs7"
Add Resource
→ Add Existing File
```

---

# LANGKAH 5

# Pilih File Logo

Pilih:

```text id="rs8"
logo.png
```

---

# Hasil

Logo sekarang masuk ke:

```text id="rs9"
My.Resources
```

---

# LANGKAH 6

# Cek Nama Resource

Biasanya otomatis menjadi:

```text id="rs10"
logo
```

atau:

```text id="rs11"
logo_png
```

Lihat di kolom:

```text
Name
```

Karena nama ini nanti dipanggil di coding.

---

# LANGKAH 7

# Import Namespace

Di atas `FormTransaksi.vb`

Tambahkan:

```vbnet id="rs12"
Imports System.Drawing
```

---

# LANGKAH 8

# Buka Event Print Nota

Cari:

```vbnet id="rs13"
PrintDocument1_PrintPage
```

---

# LANGKAH 9

# Tambahkan Coding Logo

## Tambahkan di bagian atas method

```vbnet id="rs14"
Dim logo As Image =
    My.Resources.logo
```

---

# LANGKAH 10

# Tampilkan Logo

Tambahkan:

```vbnet id="rs15"
e.Graphics.DrawImage(
    logo,
    20,
    20,
    60,
    60
)
```

---

# Penjelasan

| Parameter | Fungsi   |
| --------- | -------- |
| 20        | Posisi X |
| 20        | Posisi Y |
| 60        | Lebar    |
| 60        | Tinggi   |

---

# LANGKAH 11

# Geser Posisi Judul

Karena sekarang ada logo,
judul harus digeser ke kanan.

---

# Sebelum

```vbnet id="rs16"
e.Graphics.DrawString(
    "LAINDORI LAUNDRY",
    fontJudul,
    Brushes.Black,
    70,
    y
)
```

---

# Menjadi

```vbnet id="rs17"
e.Graphics.DrawString(
    "LAINDORI LAUNDRY",
    fontJudul,
    Brushes.Black,
    95,
    y
)
```

---

# LANGKAH 12

# Kode Lengkap Print Nota Dengan Logo

```vbnet id="rs18"
Private Sub PrintDocument1_PrintPage(
    sender As Object,
    e As Printing.PrintPageEventArgs
) Handles PrintDocument1.PrintPage

    Dim fontJudul As New Font(
        "Poppins",
        16,
        FontStyle.Bold
    )

    Dim fontIsi As New Font(
        "Consolas",
        11
    )

    Dim y As Integer = 40

    ' =========================
    ' LOAD LOGO RESOURCE
    ' =========================

    Dim logo As Image =
        My.Resources.logo

    ' =========================
    ' TAMPILKAN LOGO
    ' =========================

    e.Graphics.DrawImage(
        logo,
        20,
        20,
        60,
        60
    )

    ' =========================
    ' JUDUL
    ' =========================

    e.Graphics.DrawString(
        "LAINDORI LAUNDRY",
        fontJudul,
        Brushes.Black,
        95,
        y
    )

    y += 35

    e.Graphics.DrawString(
        "Laundry Cepat & Bersih",
        fontIsi,
        Brushes.Black,
        95,
        y
    )

    y += 40

    e.Graphics.DrawString(
        "================================",
        fontIsi,
        Brushes.Black,
        20,
        y
    )

    y += 30

    e.Graphics.DrawString(
        "Kode       : " & kode,
        fontIsi,
        Brushes.Black,
        20,
        y
    )

    y += 25

    e.Graphics.DrawString(
        "Tanggal    : " & tanggal,
        fontIsi,
        Brushes.Black,
        20,
        y
    )

    y += 25

    e.Graphics.DrawString(
        "Pelanggan  : " & pelanggan,
        fontIsi,
        Brushes.Black,
        20,
        y
    )

    y += 25

    e.Graphics.DrawString(
        "Kasir      : " & userLogin,
        fontIsi,
        Brushes.Black,
        20,
        y
    )

    y += 35

    e.Graphics.DrawString(
        "--------------------------------",
        fontIsi,
        Brushes.Black,
        20,
        y
    )

    y += 30

    e.Graphics.DrawString(
        "Berat          : " &
        berat & " Kg",
        fontIsi,
        Brushes.Black,
        20,
        y
    )

    y += 25

    e.Graphics.DrawString(
        "Harga / Kg     : " &
        harga,
        fontIsi,
        Brushes.Black,
        20,
        y
    )

    y += 25

    e.Graphics.DrawString(
        "Total Bayar    : " &
        Format(
            Val(total),
            "N0"
        ),
        fontIsi,
        Brushes.Black,
        20,
        y
    )

    y += 25

    e.Graphics.DrawString(
        "Status         : " &
        status_loundry,
        fontIsi,
        Brushes.Black,
        20,
        y
    )

    y += 35

    e.Graphics.DrawString(
        "--------------------------------",
        fontIsi,
        Brushes.Black,
        20,
        y
    )

    y += 35

    e.Graphics.DrawString(
        "Terima Kasih",
        fontIsi,
        Brushes.Black,
        80,
        y
    )

End Sub
```

---

# HASIL AKHIR

Sekarang nota:
✅ memiliki logo
✅ lebih profesional
✅ lebih menarik
✅ aman saat aplikasi dipindah komputer
