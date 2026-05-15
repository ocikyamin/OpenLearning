# CRUD Data Pelanggan

## Aplikasi Laundry Desktop VB.NET & MySQL

---

# Tujuan Pembelajaran

Pada tahap ini mahasiswa belajar:

* membuat form CRUD,
* menampilkan data ke DataGridView,
* INSERT data,
* UPDATE data,
* DELETE data,
* SEARCH data,
* dan event DataGridView.

---

# Nama Form

```text id="3a3y5n"
FrmPelanggan
```

---

# Design Layout Form

## Contoh Layout Sederhana

```text id="4o5fll"
========================================================
                DATA PELANGGAN LAUNDRY
========================================================

Nama Pelanggan
[________________________________________]

No HP
[________________________________________]

Alamat
[________________________________________]

[ SIMPAN ] [ UBAH ] [ HAPUS ] [ RESET ]

Cari Pelanggan :
[________________________________________]

========================================================
|                                                      |
|                  DataGridView                        |
|                                                      |
========================================================
```

---

# Komponen Yang Digunakan

| Komponen     | Name         |
| ------------ | ------------ |
| Label        | lblNama      |
| TextBox      | txtNama      |
| Label        | lblHP        |
| TextBox      | txtHP        |
| Label        | lblAlamat    |
| TextBox      | txtAlamat    |
| Button       | btnSimpan    |
| Button       | btnUbah      |
| Button       | btnHapus     |
| Button       | btnReset     |
| Label        | lblCari      |
| TextBox      | txtCari      |
| DataGridView | dgvPelanggan |

---

# Property Yang Disarankan

## dgvPelanggan

| Property            | Value         |
| ------------------- | ------------- |
| AutoSizeColumnsMode | Fill          |
| ReadOnly            | True          |
| SelectionMode       | FullRowSelect |
| MultiSelect         | False         |

---

# Import Library

```vbnet id="2hnz9u"
Imports MySql.Data.MySqlClient
```

---

# Coding FrmPelanggan

---

# Procedure Tampil Data

```vbnet id="44flv7"
Sub TampilData()

    Call Konek()

    da = New MySqlDataAdapter(
        "SELECT * FROM pelanggan",
        Koneksi
    )

    dt = New DataTable

    da.Fill(dt)

    dgvPelanggan.DataSource = dt

    Call Diskonek()

End Sub
```

---

# Procedure Reset Form

```vbnet id="t0i1xe"
Sub ResetForm()

    txtNama.Clear()
    txtHP.Clear()
    txtAlamat.Clear()

    txtNama.Focus()

End Sub
```

---

# Form Load

```vbnet id="jfv1v6"
Private Sub FrmPelanggan_Load(
    sender As Object,
    e As EventArgs
) Handles MyBase.Load

    TampilData()

End Sub
```

---

# Tombol Simpan

```vbnet id="ccxdyf"
Private Sub btnSimpan_Click(
    sender As Object,
    e As EventArgs
) Handles btnSimpan.Click

    Try

        Call Konek()

        Dim query As String =
            "INSERT INTO pelanggan
            (
                nama_pelanggan,
                no_hp,
                alamat
            )
            VALUES
            (
                @nama,
                @hp,
                @alamat
            )"

        cmd = New MySqlCommand(
            query,
            Koneksi
        )

        cmd.Parameters.AddWithValue(
            "@nama",
            txtNama.Text
        )

        cmd.Parameters.AddWithValue(
            "@hp",
            txtHP.Text
        )

        cmd.Parameters.AddWithValue(
            "@alamat",
            txtAlamat.Text
        )

        cmd.ExecuteNonQuery()

        MsgBox(
            "Data Berhasil Disimpan"
        )

        TampilData()

        ResetForm()

        Call Diskonek()

    Catch ex As Exception

        MsgBox(ex.Message)

    End Try

End Sub
```

---

# Menampilkan Data dari Grid ke TextBox

```vbnet id="yvmybn"
Private Sub dgvPelanggan_CellClick(
    sender As Object,
    e As DataGridViewCellEventArgs
) Handles dgvPelanggan.CellClick

    Dim baris As Integer =
        dgvPelanggan.CurrentRow.Index

    txtNama.Text =
        dgvPelanggan.Rows(baris).
        Cells(1).Value

    txtHP.Text =
        dgvPelanggan.Rows(baris).
        Cells(2).Value

    txtAlamat.Text =
        dgvPelanggan.Rows(baris).
        Cells(3).Value

End Sub
```

---

# Tombol Ubah

```vbnet id="jlwmfk"
Private Sub btnUbah_Click(
    sender As Object,
    e As EventArgs
) Handles btnUbah.Click

    Try

        Call Konek()

        Dim id As String =
            dgvPelanggan.CurrentRow.
            Cells(0).Value

        Dim query As String =
            "UPDATE pelanggan SET
            nama_pelanggan=@nama,
            no_hp=@hp,
            alamat=@alamat
            WHERE id_pelanggan=@id"

        cmd = New MySqlCommand(
            query,
            Koneksi
        )

        cmd.Parameters.AddWithValue(
            "@nama",
            txtNama.Text
        )

        cmd.Parameters.AddWithValue(
            "@hp",
            txtHP.Text
        )

        cmd.Parameters.AddWithValue(
            "@alamat",
            txtAlamat.Text
        )

        cmd.Parameters.AddWithValue(
            "@id",
            id
        )

        cmd.ExecuteNonQuery()

        MsgBox(
            "Data Berhasil Diubah"
        )

        TampilData()

        ResetForm()

        Call Diskonek()

    Catch ex As Exception

        MsgBox(ex.Message)

    End Try

End Sub
```

---

# Tombol Hapus

```vbnet id="4jlwm7"
Private Sub btnHapus_Click(
    sender As Object,
    e As EventArgs
) Handles btnHapus.Click

    Try

        Dim jawab As DialogResult

        jawab = MessageBox.Show(
            "Yakin ingin menghapus data?",
            "Konfirmasi",
            MessageBoxButtons.YesNo,
            MessageBoxIcon.Question
        )

        If jawab = DialogResult.Yes Then

            Call Konek()

            Dim id As String =
                dgvPelanggan.CurrentRow.
                Cells(0).Value

            Dim query As String =
                "DELETE FROM pelanggan
                 WHERE id_pelanggan=@id"

            cmd = New MySqlCommand(
                query,
                Koneksi
            )

            cmd.Parameters.AddWithValue(
                "@id",
                id
            )

            cmd.ExecuteNonQuery()

            MsgBox(
                "Data Berhasil Dihapus"
            )

            TampilData()

            ResetForm()

            Call Diskonek()

        End If

    Catch ex As Exception

        MsgBox(ex.Message)

    End Try

End Sub
```

---

# Tombol Cari

```vbnet id="cb3l2l"
Private Sub txtCari_TextChanged(
    sender As Object,
    e As EventArgs
) Handles txtCari.TextChanged

    Call Konek()

    da = New MySqlDataAdapter(
        "SELECT * FROM pelanggan
         WHERE nama_pelanggan
         LIKE '%" &
         txtCari.Text &
         "%'",
        Koneksi
    )

    dt = New DataTable

    da.Fill(dt)

    dgvPelanggan.DataSource = dt

    Call Diskonek()

End Sub
```

---

# Tombol Reset

```vbnet id="kt8b1u"
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

* input data pelanggan,
* edit data,
* hapus data,
* mencari data,
* dan menampilkan data database secara realtime ke DataGridView.

---

# Konsep Yang Dipelajari

## VB.NET

* CRUD
* DataGridView
* Event Click
* Parameter Query
* DataAdapter
* DataTable

---

## MySQL

* INSERT
* UPDATE
* DELETE
* SELECT
* WHERE
* LIKE
