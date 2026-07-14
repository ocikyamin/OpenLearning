# DASHBOARD APLIKASI LAUNDRY

## Membuat Dashboard Statistik VB.NET + MySQL

---

# Tujuan

Pada part ini kita akan membuat:

* Dashboard modern
* Statistik transaksi
* Total pelanggan
* Total transaksi
* Total pendapatan
* Transaksi selesai

Dashboard ini akan membuat aplikasi terasa lebih profesional.

---

# HASIL AKHIR

```text
=====================================
 TOTAL PELANGGAN   : 12
 TOTAL TRANSAKSI   : 30
 TOTAL PENDAPATAN  : 1.250.000
 TRANSAKSI SELESAI : 20
=====================================
```

---

# FORM YANG DIGUNAKAN

Gunakan:

```text
FormDashboard
```

Jika belum ada:

## Tambahkan Form Baru

```text
Project
→ Add Windows Form
→ FormDashboard.vb
```

---

# DESIGN DASHBOARD

Gunakan:

| Komponen    | Jumlah |
| ----------- | ------ |
| Panel       | 4      |
| Label Judul | 4      |
| Label Angka | 4      |

---

# SUSUNAN PANEL

```text
-------------------------------------------------
| TOTAL PELANGGAN | TOTAL TRANSAKSI |
-------------------------------------------------
| TOTAL PENDAPATAN| TRANSAKSI SELESAI |
-------------------------------------------------
```

---

# WARNA PANEL (REKOMENDASI)

| Panel      | Warna  |
| ---------- | ------ |
| Pelanggan  | Biru   |
| Transaksi  | Hijau  |
| Pendapatan | Orange |
| Selesai    | Ungu   |

---

# KOMPONEN DAN NAME

| Komponen | Name                |
| -------- | ------------------- |
| Label    | lblTotalPelanggan   |
| Label    | lblTotalTransaksi   |
| Label    | lblTotalPendapatan  |
| Label    | lblTransaksiSelesai |

---

# LANGKAH 1

# Import MySQL

Di atas FormDashboard.vb

```vbnet
Imports MySql.Data.MySqlClient
```

---

# LANGKAH 2

# Function Total Pelanggan

Tambahkan:

```vbnet
Sub TotalPelanggan()

    Try

        Call Konek()

        cmd = New MySqlCommand(
            "SELECT COUNT(*)
             FROM pelanggan",
            Koneksi
        )

        Dim total As Integer

        total = Convert.ToInt32(
            cmd.ExecuteScalar()
        )

        lblTotalPelanggan.Text =
            total.ToString()

        Call Diskonek()

    Catch ex As Exception

        MsgBox(ex.Message)

    End Try

End Sub
```

---

# LANGKAH 3

# Function Total Transaksi

```vbnet
Sub TotalTransaksi()

    Try

        Call Konek()

        cmd = New MySqlCommand(
            "SELECT COUNT(*)
             FROM transaksi",
            Koneksi
        )

        Dim total As Integer

        total = Convert.ToInt32(
            cmd.ExecuteScalar()
        )

        lblTotalTransaksi.Text =
            total.ToString()

        Call Diskonek()

    Catch ex As Exception

        MsgBox(ex.Message)

    End Try

End Sub
```

---

# LANGKAH 4

# Function Total Pendapatan

```vbnet
Sub TotalPendapatan()

    Try

        Call Konek()

        cmd = New MySqlCommand(
            "SELECT SUM(total_bayar)
             FROM transaksi",
            Koneksi
        )

        Dim total As Object

        total = cmd.ExecuteScalar()

        If IsDBNull(total) Then

            lblTotalPendapatan.Text =
                "Rp 0"

        Else

            lblTotalPendapatan.Text =
                "Rp " &
                Format(
                    total,
                    "N0"
                )

        End If

        Call Diskonek()

    Catch ex As Exception

        MsgBox(ex.Message)

    End Try

End Sub
```

---

# LANGKAH 5

# Function Transaksi Selesai

```vbnet
Sub TotalSelesai()

    Try

        Call Konek()

        cmd = New MySqlCommand(
            "SELECT COUNT(*)
             FROM transaksi
             WHERE status_laundry='Selesai'",
            Koneksi
        )

        Dim total As Integer

        total = Convert.ToInt32(
            cmd.ExecuteScalar()
        )

        lblTransaksiSelesai.Text =
            total.ToString()

        Call Diskonek()

    Catch ex As Exception

        MsgBox(ex.Message)

    End Try

End Sub
```

---

# LANGKAH 6

# Form Load Dashboard

```vbnet
Private Sub FormDashboard_Load(
    sender As Object,
    e As EventArgs
) Handles MyBase.Load

    TotalPelanggan()

    TotalTransaksi()

    TotalPendapatan()

    TotalSelesai()

End Sub
```

---

# HASIL

Sekarang dashboard otomatis menampilkan:

✅ Total pelanggan
✅ Total transaksi
✅ Total pendapatan
✅ Total laundry selesai

---

# LANGKAH 7

# Membuka Dashboard Dari Menu Utama

## Pada Form Menu Utama

```vbnet
Private Sub MenuDashboard_Click(
    sender As Object,
    e As EventArgs
) Handles MenuDashboard.Click

    LoadForm(FormDashboard)

End Sub
```

---

# BONUS

# Dashboard Auto Refresh

Agar dashboard otomatis update.

---

# Tambahkan Timer

| Komponen | Name   |
| -------- | ------ |
| Timer    | Timer1 |

---

# Setting Timer

| Property | Value |
| -------- | ----- |
| Enabled  | True  |
| Interval | 3000  |

---

# Event Timer

```vbnet
Private Sub Timer1_Tick(
    sender As Object,
    e As EventArgs
) Handles Timer1.Tick

    TotalPelanggan()

    TotalTransaksi()

    TotalPendapatan()

    TotalSelesai()

End Sub
```

---

# BONUS 2

# Dashboard Hari Ini

Contoh query:

```sql
SELECT COUNT(*)
FROM transaksi
WHERE tanggal = CURDATE()
```

Mahasiswa mulai belajar:

* filter tanggal,
* statistik realtime,
* dashboard monitoring.

---

# BONUS 3

# Chart Statistik

Bisa dikembangkan menggunakan:

```text
Chart Control
```

Contoh:

* transaksi per hari,
* pendapatan bulanan,
* status laundry.
