# Lanjutan FORM TRANSAKSI

## Session Login + JOIN Transaksi + Laporan Sederhana

---

# Tujuan

Pada tahap ini kita akan:

* membuat transaksi mengikuti user login,
* menampilkan nama pelanggan,
* menampilkan nama user,
* tetap menampilkan seluruh data transaksi,
* membuat pencarian transaksi,
* dan menampilkan total pendapatan.

---


# HASIL YANG AKAN DIDAPAT

## Sebelum

| id_pelanggan | id_user |
| ------------ | ------- |
| 1            | 1       |

---

## Sesudah

| Pelanggan | User  |
| --------- | ----- |
| Budi      | admin |

Tetapi:

* berat,
* harga,
* total bayar,
* status

tetap tampil.

---

# LANGKAH 1

# Tambahkan Session Login

---

# Buka

```text id="r702"
ModuleKoneksi.vb
```

---

# Tambahkan Variable Berikut

```vbnet id="r703"
Public SessionIDUser As String
Public SessionUsername As String
Public SessionLevel As String
```

---

# Hasil Lengkap ModuleKoneksi.vb

```vbnet id="r704"
Imports MySql.Data.MySqlClient

Module ModuleKoneksi

    Dim MySQLKonek =
        "Server=localhost;
         Database=db_laundry;
         User=root;
         Password=root"

    Public Koneksi As New MySqlConnection(MySQLKonek)

    Public da As MySqlDataAdapter = Nothing
    Public cmd As MySqlCommand = Nothing
    Public dt As New DataTable
    Public dr As MySqlDataReader

    Public Status As Boolean = False

    Public SessionIDUser As String
    Public SessionUsername As String
    Public SessionLevel As String

    Public Sub Konek()

        Try

            If Koneksi.State =
                ConnectionState.Open Then

                Koneksi.Close()

            End If

            Koneksi.Open()

        Catch ex As Exception

            MsgBox(
                "Koneksi Gagal : " &
                ex.Message
            )

        End Try

    End Sub

    Function Diskonek()

        Koneksi.Close()

        Return Koneksi

    End Function

End Module
```

---

# LANGKAH 2

# Perbaiki Login User

---

# Buka

```text id="r705"
FrmLogin.vb
```

---

# Coding Login Lengkap

```vbnet id="r706"
Private Sub btnLogin_Click(
    sender As Object,
    e As EventArgs
) Handles btnLogin.Click

    Try

        Call Konek()

        Dim query As String =
            "SELECT * FROM users
             WHERE username=@username
             AND password=@password"

        cmd = New MySqlCommand(
            query,
            Koneksi
        )

        cmd.Parameters.AddWithValue(
            "@username",
            txtUsername.Text
        )

        cmd.Parameters.AddWithValue(
            "@password",
            txtPassword.Text
        )

        dr = cmd.ExecuteReader()

        If dr.Read() Then

            SessionIDUser =
                dr("id_user")

            SessionUsername =
                dr("username")

            SessionLevel =
                dr("level_user")

            MsgBox(
                "Login Berhasil"
            )

            FrmMenuUtama.Show()

            Me.Hide()

        Else

            MsgBox(
                "Username atau Password Salah"
            )

        End If

        dr.Close()

        Call Diskonek()

    Catch ex As Exception

        MsgBox(ex.Message)

    End Try

End Sub
```

---

# LANGKAH 3

# Menampilkan User Yang Login

---

# Tambahkan Label di FrmMenuUtama

| Komponen | Name         |
| -------- | ------------ |
| Label    | lblUserLogin |

---

# Coding FrmMenuUtama_Load

```vbnet id="r707"
Private Sub FrmMenuUtama_Load(
    sender As Object,
    e As EventArgs
) Handles MyBase.Load

    lblUserLogin.Text =
        "Login Sebagai : " &
        SessionUsername

End Sub
```

---

# Hasil

```text id="r708"
Login Sebagai : admin
```

---

# LANGKAH 4

# Perbaiki Simpan Transaksi

---

# Buka

```text id="r709"
FrmTransaksi.vb
```

---

# Cari Coding Lama

```vbnet id="r710"
cmd.Parameters.AddWithValue(
    "@user",
    1
)
```

---

# Ganti Menjadi

```vbnet id="r711"
cmd.Parameters.AddWithValue(
    "@user",
    SessionIDUser
)
```

---

# Hasil

Sekarang:

* transaksi otomatis mengikuti user login,
* multi user berjalan dengan benar.

---

# LANGKAH 5

# Perbaiki Tampil Data Transaksi

---

# Cari Procedure Lama

```vbnet id="r712"
Sub TampilData()
```

---

# Ganti Seluruh Procedure Menjadi

```vbnet id="r713"
Sub TampilData()

    Call Konek()

    Dim query As String =
        "SELECT
            transaksi.id_transaksi,
            transaksi.kode_transaksi,
            transaksi.tanggal,
            pelanggan.nama_pelanggan,
            users.nama_user,
            transaksi.berat,
            transaksi.harga_perkg,
            transaksi.total_bayar,
            transaksi.status_laundry
         FROM transaksi
         JOIN pelanggan
         ON transaksi.id_pelanggan =
            pelanggan.id_pelanggan
         JOIN users
         ON transaksi.id_user =
            users.id_user"

    da = New MySqlDataAdapter(
        query,
        Koneksi
    )

    dt = New DataTable

    da.Fill(dt)

    dgvTransaksi.DataSource = dt

    dgvTransaksi.Columns(0).Visible =
        False

    dgvTransaksi.Columns(1).HeaderText =
        "Kode"

    dgvTransaksi.Columns(2).HeaderText =
        "Tanggal"

    dgvTransaksi.Columns(3).HeaderText =
        "Pelanggan"

    dgvTransaksi.Columns(4).HeaderText =
        "User"

    dgvTransaksi.Columns(5).HeaderText =
        "Berat"

    dgvTransaksi.Columns(6).HeaderText =
        "Harga/Kg"

    dgvTransaksi.Columns(7).HeaderText =
        "Total Bayar"

    dgvTransaksi.Columns(8).HeaderText =
        "Status"

    dgvTransaksi.Columns(7).
    DefaultCellStyle.Format = "N0"

    Call Diskonek()

End Sub
```

---

# Hasil DataGridView

| Kode   | Pelanggan | User  | Berat | Harga | Total  | Status |
| ------ | --------- | ----- | ----- | ----- | ------ | ------ |
| TRX001 | Budi      | admin | 3     | 7000  | 21,000 | Proses |

---

# LANGKAH 6

# Tambahkan Pencarian Transaksi

---

# Tambahkan Komponen

| Komponen | Name    |
| -------- | ------- |
| Label    | lblCari |
| TextBox  | txtCari |

---

# Contoh Layout

```text id="r714"
Cari Transaksi :
[________________________]
```

---

# Coding txtCari_TextChanged

```vbnet id="r715"
```vbnet
Private Sub txtCari_TextChanged(
    sender As Object,
    e As EventArgs
) Handles txtCari.TextChanged

    Try

        Call Konek()

        Dim query As String =
            "SELECT
                transaksi.id_transaksi,
                transaksi.kode_transaksi,
                transaksi.tanggal,
                pelanggan.nama_pelanggan,
                users.nama_user,
                transaksi.berat,
                transaksi.harga_perkg,
                transaksi.total_bayar,
                transaksi.status_laundry
             FROM transaksi
             JOIN pelanggan
             ON transaksi.id_pelanggan =
                pelanggan.id_pelanggan
             JOIN users
             ON transaksi.id_user =
                users.id_user
             WHERE pelanggan.nama_pelanggan
             LIKE @cari
             ORDER BY transaksi.id_transaksi DESC"

        cmd = New MySqlCommand(
            query,
            Koneksi
        )

        cmd.Parameters.AddWithValue(
            "@cari",
            "%" & txtCari.Text & "%"
        )

        da = New MySqlDataAdapter(cmd)

        dt = New DataTable

        da.Fill(dt)

        dgvTransaksi.DataSource = dt

        If dgvTransaksi.Columns.Count > 0 Then

            dgvTransaksi.Columns(0).Visible =
                False

            dgvTransaksi.Columns(1).HeaderText =
                "Kode"

            dgvTransaksi.Columns(2).HeaderText =
                "Tanggal"

            dgvTransaksi.Columns(3).HeaderText =
                "Pelanggan"

            dgvTransaksi.Columns(4).HeaderText =
                "User"

            dgvTransaksi.Columns(5).HeaderText =
                "Berat"

            dgvTransaksi.Columns(6).HeaderText =
                "Harga/Kg"

            dgvTransaksi.Columns(7).HeaderText =
                "Total Bayar"

            dgvTransaksi.Columns(8).HeaderText =
                "Status"

            dgvTransaksi.Columns(7).
            DefaultCellStyle.Format = "N0"

            dgvTransaksi.AutoSizeColumnsMode =
                DataGridViewAutoSizeColumnsMode.Fill

        End If

        Call Diskonek()

    Catch ex As Exception

        MsgBox(
            "Error Pencarian : " &
            ex.Message
        )

    End Try

End Sub
```

---

# LANGKAH 7

# Menampilkan Total Pendapatan

---

# Tambahkan Label

| Komponen | Name               |
| -------- | ------------------ |
| Label    | lblTotalPendapatan |

---

# Contoh Tampilan

```text id="r716"
Total Pendapatan :
125,000
```

---

# Coding Total Pendapatan

```vbnet id="r717"
Sub TotalPendapatan()

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
            "0"

    Else

        lblTotalPendapatan.Text =
            Format(total, "N0")

    End If

    Call Diskonek()

End Sub
```

---

# LANGKAH 8

# Perbaiki Form Load

---

# Cari Coding Lama

```vbnet id="r718"
Private Sub FrmTransaksi_Load
```

---

# Pastikan Menjadi

```vbnet id="r719"
Private Sub FrmTransaksi_Load(
    sender As Object,
    e As EventArgs
) Handles MyBase.Load

    TampilData()

    TotalPendapatan()

End Sub
```

---

# HASIL AKHIR

Sekarang aplikasi sudah memiliki:

✅ Login Multi User
✅ Session Login
✅ CRUD Pelanggan
✅ Transaksi Laundry
✅ JOIN Relasi Database
✅ Search Transaksi
✅ Total Pendapatan
✅ Tampilan Data Profesional

---

# Konsep Yang Dipelajari Mahasiswa

## VB.NET

* Session Login
* Global Variable
* JOIN Result
* Search Realtime
* ExecuteScalar()
* DataGridView Formatting

---

## MySQL

* JOIN
* SUM()
* LIKE
* Foreign Key
* Relasi Tabel

---

# Struktur DataGridView Sekarang

| Visible | Kolom          |
| ------- | -------------- |
| Hidden  | id_transaksi   |
| Visible | kode_transaksi |
| Visible | tanggal        |
| Visible | nama_pelanggan |
| Visible | nama_user      |
| Visible | berat          |
| Visible | harga_perkg    |
| Visible | total_bayar    |
| Visible | status_laundry |

---

# Tahap Berikutnya — Cetak Nota Laundry

Karena:

* transaksi sudah lengkap,
* data sudah relasional,
* dan aplikasi mulai terasa seperti software laundry sungguhan.
