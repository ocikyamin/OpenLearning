# Form Transaksi Laundry

---

# Tujuan Pembelajaran

Pada tahap ini mahasiswa belajar:

* membuat transaksi laundry,
* menggunakan ComboBox dari database,
* membuat perhitungan otomatis,
* INSERT data transaksi,
* menampilkan data transaksi,
* dan memahami foreign key.

---

# Nama Form

```text id="4jlwm1"
FrmTransaksi
```

---

# Design Layout Form

```text id="jlwm55"
========================================================
                TRANSAKSI LAUNDRY
========================================================

Kode Transaksi
[ TRX001 ]

Tanggal
[ 15/05/2026 ]

Pilih Pelanggan
[ ComboBox Pelanggan ]

Berat Cucian (Kg)
[____________]

Harga Per Kg
[____________]

Total Bayar
[____________]

Status Laundry
[ ComboBox Status ]

[ SIMPAN ] [ RESET ]

========================================================
|                DataGridView                          |
========================================================
```

---

# Komponen Yang Digunakan

| Komponen       | Name         |
| -------------- | ------------ |
| Label          | lblKode      |
| TextBox        | txtKode      |
| Label          | lblTanggal   |
| DateTimePicker | dtTanggal    |
| Label          | lblPelanggan |
| ComboBox       | cbPelanggan  |
| Label          | lblBerat     |
| TextBox        | txtBerat     |
| Label          | lblHarga     |
| TextBox        | txtHarga     |
| Label          | lblTotal     |
| TextBox        | txtTotal     |
| Label          | lblStatus    |
| ComboBox       | cbStatus     |
| Button         | btnSimpan    |
| Button         | btnReset     |
| DataGridView   | dgvTransaksi |

---

# Property Yang Disarankan

## txtKode

```text id="jlwm66"
ReadOnly = True
```

---

## txtTotal

```text id="jlwm67"
ReadOnly = True
```

---

## dgvTransaksi

| Property            | Value         |
| ------------------- | ------------- |
| AutoSizeColumnsMode | Fill          |
| ReadOnly            | True          |
| SelectionMode       | FullRowSelect |

---

# Import Library

```vbnet id="jlwm68"
Imports MySql.Data.MySqlClient
```

---

# Coding FrmTransaksi

---

# 1. Procedure TampilData()

```vbnet id="jlwm69"
Sub TampilData()

    Call Konek()

    da = New MySqlDataAdapter(
        "SELECT * FROM transaksi",
        Koneksi
    )

    dt = New DataTable

    da.Fill(dt)

    dgvTransaksi.DataSource = dt

    Call Diskonek()

End Sub
```

---

# 2. Procedure ResetForm()

```vbnet id="jlwm70"
Sub ResetForm()

    txtBerat.Clear()
    txtHarga.Clear()
    txtTotal.Clear()

    cbPelanggan.SelectedIndex = -1
    cbStatus.SelectedIndex = -1

    txtBerat.Focus()

End Sub
```

---

# 3. Procedure TampilPelanggan()

## Mengisi ComboBox dari Database

```vbnet id="jlwm71"
Sub TampilPelanggan()

    Call Konek()

    Dim query As String =
        "SELECT * FROM pelanggan"

    cmd = New MySqlCommand(
        query,
        Koneksi
    )

    dr = cmd.ExecuteReader()

    cbPelanggan.Items.Clear()

    While dr.Read()

        cbPelanggan.Items.Add(
            dr("nama_pelanggan")
        )

    End While

    dr.Close()

    Call Diskonek()

End Sub
```

---

# 4. Procedure StatusLaundry()

```vbnet id="jlwm72"
Sub StatusLaundry()

    cbStatus.Items.Add("Proses")
    cbStatus.Items.Add("Selesai")
    cbStatus.Items.Add("Diambil")

End Sub
```

---

# 5. Procedure GenerateKode()

```vbnet id="jlwm73"
Sub GenerateKode()

    Call Konek()

    cmd = New MySqlCommand(
        "SELECT * FROM transaksi 
         ORDER BY id_transaksi DESC",
        Koneksi
    )

    dr = cmd.ExecuteReader()

    If dr.Read() Then

        Dim nomor As Integer

        nomor =
            Val(Microsoft.VisualBasic.Right(
            dr.Item("kode_transaksi").ToString,
            3
        )) + 1

        txtKode.Text =
            "TRX" &
            Format(nomor, "000")

    Else

        txtKode.Text = "TRX001"

    End If

    dr.Close()

    Call Diskonek()

End Sub
```

---

# 6. Form Load

```vbnet id="jlwm74"
Private Sub FrmTransaksi_Load(
    sender As Object,
    e As EventArgs
) Handles MyBase.Load

    TampilData()

    TampilPelanggan()

    StatusLaundry()

    GenerateKode()

End Sub
```

---

# 7. Hitung Total Otomatis

## Event TextChanged

```vbnet id="jlwm75"
Private Sub txtBerat_TextChanged(
    sender As Object,
    e As EventArgs
) Handles txtBerat.TextChanged,
          txtHarga.TextChanged

    If txtBerat.Text <> "" And
       txtHarga.Text <> "" Then

        Dim berat As Double
        Dim harga As Double

        berat = Val(txtBerat.Text)
        harga = Val(txtHarga.Text)

        txtTotal.Text =
            berat * harga

    End If

End Sub
```

---

# 8. Tombol Simpan

```vbnet id="jlwm76"
Private Sub btnSimpan_Click(
    sender As Object,
    e As EventArgs
) Handles btnSimpan.Click

    Try

        Call Konek()

        Dim idPelanggan As String = ""

        cmd = New MySqlCommand(
            "SELECT id_pelanggan 
             FROM pelanggan
             WHERE nama_pelanggan=@nama",
            Koneksi
        )

        cmd.Parameters.AddWithValue(
            "@nama",
            cbPelanggan.Text
        )

        dr = cmd.ExecuteReader()

        If dr.Read() Then

            idPelanggan =
                dr("id_pelanggan")

        End If

        dr.Close()

        Dim query As String =
            "INSERT INTO transaksi
            (
                kode_transaksi,
                tanggal,
                id_pelanggan,
                id_user,
                berat,
                harga_perkg,
                total_bayar,
                status_laundry
            )
            VALUES
            (
                @kode,
                @tanggal,
                @pelanggan,
                @user,
                @berat,
                @harga,
                @total,
                @status
            )"

        cmd = New MySqlCommand(
            query,
            Koneksi
        )

        cmd.Parameters.AddWithValue(
            "@kode",
            txtKode.Text
        )

        cmd.Parameters.AddWithValue(
            "@tanggal",
            dtTanggal.Value
        )

        cmd.Parameters.AddWithValue(
            "@pelanggan",
            idPelanggan
        )

        cmd.Parameters.AddWithValue(
            "@user",
            1
        )

        cmd.Parameters.AddWithValue(
            "@berat",
            txtBerat.Text
        )

        cmd.Parameters.AddWithValue(
            "@harga",
            txtHarga.Text
        )

        cmd.Parameters.AddWithValue(
            "@total",
            txtTotal.Text
        )

        cmd.Parameters.AddWithValue(
            "@status",
            cbStatus.Text
        )

        cmd.ExecuteNonQuery()

        MsgBox(
            "Transaksi Berhasil Disimpan"
        )

        TampilData()

        ResetForm()

        GenerateKode()

        Call Diskonek()

    Catch ex As Exception

        MsgBox(ex.Message)

    End Try

End Sub
```

---

# 9. Tombol Reset

```vbnet id="jlwm77"
Private Sub btnReset_Click(
    sender As Object,
    e As EventArgs
) Handles btnReset.Click

    ResetForm()

End Sub
```

---

# Hasil Akhir Form

Mahasiswa sudah dapat:

* memilih pelanggan,
* menghitung total otomatis,
* menyimpan transaksi,
* melihat data transaksi,
* dan memahami relasi tabel.

---

# Konsep Yang Dipelajari

## VB.NET

* ComboBox Database
* TextChanged Event
* Generate Code
* INSERT Transaksi
* DateTimePicker
* DataGridView

---

## MySQL

* Foreign Key
* Relasi Tabel
* SELECT
* INSERT
* ORDER BY

---

# Persiapan Part Berikutnya

Pada part berikutnya:

* menampilkan JOIN transaksi,
* menampilkan nama pelanggan,
* laporan transaksi,
* pencarian transaksi,
* dan filter data transaksi.
