# CETAK NOTA LAUNDRY

## Print Preview + Nota Transaksi

---

# Tujuan PART 8

Pada tahap ini mahasiswa akan belajar:

* membuat nota transaksi,
* menampilkan Print Preview,
* mencetak transaksi laundry,
* mengambil data dari DataGridView,
* dan membuat layout nota sederhana.

---

# Hasil Akhir

Mahasiswa dapat:
✅ Klik transaksi
✅ Klik tombol Cetak
✅ Muncul nota laundry
✅ Bisa print atau save PDF

---

# FITUR YANG AKAN DIBUAT

```text id="pt801"
==================================
         LAINDORI LAUNDRY
==================================

Kode     : TRX001
Tanggal  : 15 Mei 2026
Pelanggan: Budi

----------------------------------
Berat          : 3 Kg
Harga / Kg     : 7000
Total Bayar    : 21000
Status         : Proses
----------------------------------

Terima Kasih
==================================
```

---

# KOMPONEN YANG DIBUTUHKAN

## Tambahkan Ke FormTransaksi

| Komponen           | Name                |
| ------------------ | ------------------- |
| Button             | btnCetak            |
| PrintDocument      | PrintDocument1      |
| PrintPreviewDialog | PrintPreviewDialog1 |

---

# DESIGN SEDERHANA

```text id="pt802"
[ DataGridView ]

                [ CETAK NOTA ]
```

---

# LANGKAH 1

# Buat Variable Global

## Di FormTransaksi.vb

Tambahkan:

```vbnet id="pt803"
Dim kode As String
Dim tanggal As String
Dim pelanggan As String
Dim userLogin As String
Dim berat As String
Dim harga As String
Dim total As String
Dim status_loundry As String
```

---

# LANGKAH 2

# Ambil Data Dari DataGridView

## Klik DoubleClick DataGridView

```vbnet id="pt804"
Private Sub dgvTransaksi_CellClick(
    sender As Object,
    e As DataGridViewCellEventArgs
) Handles dgvTransaksi.CellClick

    If e.RowIndex >= 0 Then

        Dim row As DataGridViewRow =
            dgvTransaksi.Rows(e.RowIndex)

        kode =
            row.Cells(1).Value.ToString()

        tanggal =
            row.Cells(2).Value.ToString()

        pelanggan =
            row.Cells(3).Value.ToString()

        userLogin =
            row.Cells(4).Value.ToString()

        berat =
            row.Cells(5).Value.ToString()

        harga =
            row.Cells(6).Value.ToString()

        total =
            row.Cells(7).Value.ToString()

        status_loundry =
            row.Cells(8).Value.ToString()

    End If

End Sub
```

---

# Penjelasan

struktur DataGridView sekarang:

| Index | Kolom          |
| ----- | -------------- |
| 0     | id_transaksi   |
| 1     | kode_transaksi |
| 2     | tanggal        |
| 3     | pelanggan      |
| 4     | user           |
| 5     | berat          |
| 6     | harga          |
| 7     | total          |
| 8     | status         |

---

# LANGKAH 3

# Tombol Cetak

## Double Click btnCetak

```vbnet id="pt805"
Private Sub btnCetak_Click(
    sender As Object,
    e As EventArgs
) Handles btnCetak.Click

    PrintPreviewDialog1.Document =
        PrintDocument1

    PrintPreviewDialog1.ShowDialog()

End Sub
```

---

# LANGKAH 4

# Coding PrintDocument

## Double Click PrintDocument1

Tambahkan:

```vbnet id="pt806"
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

    e.Graphics.DrawString(
        "LAINDORI LAUNDRY",
        fontJudul,
        Brushes.Black,
        70,
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

    y += 35

    e.Graphics.DrawString(
        "Laundry Cepat & Bersih",
        fontIsi,
        Brushes.Black,
        40,
        y
    )

End Sub
```

---

# HASIL

Sekarang:

* klik transaksi,
* klik cetak,
* muncul nota laundry.

---

# BONUS

# Agar Lebih Keren

Tambahkan:

* logo laundry,
* QRIS,
* barcode transaksi,
* tanggal ambil,
* estimasi selesai.

---

# BONUS 2

# Tombol Save PDF

Karena PrintPreview bawaan Windows:

* bisa langsung:

  ```text id="pt807"
  Microsoft Print to PDF
  ```

Jadi mahasiswa bisa:

* export nota PDF,
* tanpa library tambahan.

---

# Konsep Yang Dipelajari

## VB.NET

* PrintDocument
* PrintPreviewDialog
* Graphics Drawing
* Event Printing
* DataGridView Row Selection

---

## Konsep Software

* Nota Transaksi
* Reporting
* Receipt Printing
* Mini POS System

---

# Kondisi Aplikasi Sekarang

Aplikasi sudah memiliki:

✅ Login Multi User
✅ CRUD Pelanggan
✅ Transaksi Laundry
✅ JOIN Relasi
✅ Search
✅ Total Pendapatan
✅ Cetak Nota Laundry
