# CRUD USER MANAGEMENT

## VB.NET + MySQL (Melanjutkan Sistem Login Yang Sudah Ada)

---

# Tujuan

Pada part ini kita akan melanjutkan aplikasi laundry dengan membuat:

✅ Tambah User
✅ Edit User
✅ Hapus User
✅ Pencarian User
✅ Level User
✅ DataGridView User

---

# HASIL AKHIR

```text id="u1"
=========================================
NAMA        : [______________]

USERNAME    : [______________]

PASSWORD    : [______________]

LEVEL USER  : [ Admin ▼ ]

-----------------------------------------

[CARI USER : _____________ ]

-----------------------------------------

| DATAGRIDVIEW USER |

-----------------------------------------

[SIMPAN] [EDIT] [HAPUS] [BATAL]

=========================================
```

---

# PASTIKAN TABEL USERS SUDAH ADA

Minimal field:

| Field      | Type           |
| ---------- | -------------- |
| id_user    | INT            |
| nama_user  | VARCHAR        |
| username   | VARCHAR        |
| password   | VARCHAR        |
| level_user | VARCHAR / ENUM |

---

# LANGKAH 1

# Membuat Form User

## Tambahkan Form Baru

```text id="u2"
Project
→ Add Windows Form
→ FormUser.vb
```

---

# LANGKAH 2

# Design Form

## Tambahkan Komponen

| Komponen     | Name        |
| ------------ | ----------- |
| TextBox      | txtNama     |
| TextBox      | txtUsername |
| TextBox      | txtPassword |
| ComboBox     | cmbLevel    |
| TextBox      | txtCari     |
| DataGridView | dgvUser     |
| Button       | btnSimpan   |
| Button       | btnEdit     |
| Button       | btnHapus    |
| Button       | btnBatal    |

---

# LANGKAH 3

# Import MySQL

## Di atas FormUser.vb

```vbnet id="u3"
Imports MySql.Data.MySqlClient
```

---

# LANGKAH 4

# Variable Global

Tambahkan:

```vbnet id="u4"
Dim idUser As String
```

---

# LANGKAH 5

# Form Load

```vbnet id="u5"
Private Sub FormUser_Load(
    sender As Object,
    e As EventArgs
) Handles MyBase.Load

    cmbLevel.Items.Add("Admin")
    cmbLevel.Items.Add("Kasir")

    txtPassword.PasswordChar = "*"

    TampilUser()

    KondisiAwal()

End Sub
```

---

# LANGKAH 6

# Procedure Kondisi Awal

```vbnet id="u6"
Sub KondisiAwal()

    txtNama.Clear()

    txtUsername.Clear()

    txtPassword.Clear()

    txtCari.Clear()

    cmbLevel.SelectedIndex = -1

    txtNama.Focus()

    btnSimpan.Enabled = True

    btnEdit.Enabled = False

    btnHapus.Enabled = False

End Sub
```

---

# LANGKAH 7

# Procedure Tampil User

```vbnet id="u7"
Sub TampilUser()

    Try

        Call Konek()

        da = New MySqlDataAdapter(
            "SELECT * FROM users",
            Koneksi
        )

        dt = New DataTable

        da.Fill(dt)

        dgvUser.DataSource = dt

        dgvUser.Columns(0).HeaderText =
            "ID USER"

        dgvUser.Columns(1).HeaderText =
            "NAMA USER"

        dgvUser.Columns(2).HeaderText =
            "USERNAME"

        dgvUser.Columns(3).HeaderText =
            "PASSWORD"

        dgvUser.Columns(4).HeaderText =
            "LEVEL USER"

        dgvUser.AutoSizeColumnsMode =
            DataGridViewAutoSizeColumnsMode.Fill

        Call Diskonek()

    Catch ex As Exception

        MsgBox(ex.Message)

    End Try

End Sub
```

---

# LANGKAH 8

# Tombol Simpan User

```vbnet id="u8"
Private Sub btnSimpan_Click(
    sender As Object,
    e As EventArgs
) Handles btnSimpan.Click

    If txtNama.Text = "" Or
       txtUsername.Text = "" Or
       txtPassword.Text = "" Or
       cmbLevel.Text = "" Then

        MsgBox(
            "Data Belum Lengkap"
        )

        Exit Sub

    End If

    Try

        Call Konek()

        ' =====================
        ' CEK USERNAME
        ' =====================

        cmd = New MySqlCommand(
            "SELECT * FROM users
             WHERE username=@username",
            Koneksi
        )

        cmd.Parameters.AddWithValue(
            "@username",
            txtUsername.Text
        )

        dr = cmd.ExecuteReader()

        If dr.HasRows Then

            MsgBox(
                "Username Sudah Digunakan"
            )

            dr.Close()

            Exit Sub

        End If

        dr.Close()

        ' =====================
        ' INSERT USER
        ' =====================

        Dim query As String =
            "INSERT INTO users
            (
                nama_user,
                username,
                password,
                level_user
            )
            VALUES
            (
                @nama,
                @username,
                @password,
                @level
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
            "@username",
            txtUsername.Text
        )

        cmd.Parameters.AddWithValue(
            "@password",
            txtPassword.Text
        )

        cmd.Parameters.AddWithValue(
            "@level",
            cmbLevel.Text
        )

        cmd.ExecuteNonQuery()

        MsgBox(
            "User Berhasil Disimpan"
        )

        TampilUser()

        KondisiAwal()

        Call Diskonek()

    Catch ex As Exception

        MsgBox(ex.Message)

    End Try

End Sub
```

---

# LANGKAH 9

# Klik DataGridView

```vbnet id="u9"
Private Sub dgvUser_CellClick(
    sender As Object,
    e As DataGridViewCellEventArgs
) Handles dgvUser.CellClick

    If e.RowIndex >= 0 Then

        Dim row As DataGridViewRow =
            dgvUser.Rows(e.RowIndex)

        idUser =
            row.Cells(0).Value.ToString()

        txtNama.Text =
            row.Cells(1).Value.ToString()

        txtUsername.Text =
            row.Cells(2).Value.ToString()

        txtPassword.Text =
            row.Cells(3).Value.ToString()

        cmbLevel.Text =
            row.Cells(4).Value.ToString()

        btnSimpan.Enabled = False

        btnEdit.Enabled = True

        btnHapus.Enabled = True

    End If

End Sub
```

---

# LANGKAH 10

# Tombol Edit

```vbnet id="u10"
Private Sub btnEdit_Click(
    sender As Object,
    e As EventArgs
) Handles btnEdit.Click

    Try

        Call Konek()

        Dim query As String =
            "UPDATE users SET
                nama_user=@nama,
                username=@username,
                password=@password,
                level_user=@level
             WHERE id_user=@id"

        cmd = New MySqlCommand(
            query,
            Koneksi
        )

        cmd.Parameters.AddWithValue(
            "@nama",
            txtNama.Text
        )

        cmd.Parameters.AddWithValue(
            "@username",
            txtUsername.Text
        )

        cmd.Parameters.AddWithValue(
            "@password",
            txtPassword.Text
        )

        cmd.Parameters.AddWithValue(
            "@level",
            cmbLevel.Text
        )

        cmd.Parameters.AddWithValue(
            "@id",
            idUser
        )

        cmd.ExecuteNonQuery()

        MsgBox(
            "User Berhasil Diupdate"
        )

        TampilUser()

        KondisiAwal()

        Call Diskonek()

    Catch ex As Exception

        MsgBox(ex.Message)

    End Try

End Sub
```

---

# LANGKAH 11

# Tombol Hapus

```vbnet id="u11"
Private Sub btnHapus_Click(
    sender As Object,
    e As EventArgs
) Handles btnHapus.Click

    If idUser = "" Then

        MsgBox(
            "Pilih User Terlebih Dahulu"
        )

        Exit Sub

    End If

    Dim jawab As DialogResult

    jawab = MessageBox.Show(
        "Hapus Data User ?",
        "Konfirmasi",
        MessageBoxButtons.YesNo,
        MessageBoxIcon.Question
    )

    If jawab = DialogResult.Yes Then

        Try

            Call Konek()

            Dim query As String =
                "DELETE FROM users
                 WHERE id_user=@id"

            cmd = New MySqlCommand(
                query,
                Koneksi
            )

            cmd.Parameters.AddWithValue(
                "@id",
                idUser
            )

            cmd.ExecuteNonQuery()

            MsgBox(
                "User Berhasil Dihapus"
            )

            TampilUser()

            KondisiAwal()

            Call Diskonek()

        Catch ex As Exception

            MsgBox(ex.Message)

        End Try

    End If

End Sub
```

---

# LANGKAH 12

# Tombol Batal

```vbnet id="u12"
Private Sub btnBatal_Click(
    sender As Object,
    e As EventArgs
) Handles btnBatal.Click

    KondisiAwal()

End Sub
```

---

# LANGKAH 13

# Pencarian User

```vbnet id="u13"
Private Sub txtCari_TextChanged(
    sender As Object,
    e As EventArgs
) Handles txtCari.TextChanged

    Try

        Call Konek()

        Dim query As String =
            "SELECT * FROM users
             WHERE
             nama_user LIKE '%" &
             txtCari.Text &
             "%'
             OR
             username LIKE '%" &
             txtCari.Text &
             "%'"

        da = New MySqlDataAdapter(
            query,
            Koneksi
        )

        dt = New DataTable

        da.Fill(dt)

        dgvUser.DataSource = dt

        Call Diskonek()

    Catch ex As Exception

        MsgBox(ex.Message)

    End Try

End Sub
```

---

# LANGKAH 14

# Membuka Form User Dari Menu

## Pada Form Menu Utama

```vbnet id="u14"
Private Sub MenuUser_Click(
    sender As Object,
    e As EventArgs
) Handles MenuUser.Click

    LoadForm(FormUser)

End Sub
```

---

# HASIL AKHIR

Sekarang aplikasi sudah memiliki:

✅ CRUD User
✅ Multi User
✅ Level User
✅ Search User
✅ Management Account

---

# FITUR YANG SUDAH SELESAI DI APLIKASI

✅ Login
✅ Dashboard
✅ CRUD Pelanggan
✅ CRUD User
✅ Transaksi Laundry
✅ Search
✅ Print Nota
✅ Statistik Dashboard

