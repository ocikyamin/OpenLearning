# CRUD Data Buku `FormBuku.vb`

## 1.  Tampil Data Buku (READ )
DML : `SELECT * FROM buku`

```vb
    ' --- READ (Tampil Data Buku)
       Private Sub loadData()
        Try
            Using conn As MySqlConnection = GetConnection()
                Dim query As String = "SELECT kode_buku, judul_buku, pengarang, tahun_terbit, stok FROM buku ORDER BY kode_buku ASC"
                Using adapter As New MySqlDataAdapter(query, conn)
                    Dim dt As New DataTable()
                    adapter.Fill(dt)
                    dgvBuku.DataSource = dt
                End Using
            End Using
        Catch ex As Exception
            MsgBox(ex.Message)
        End Try
    End Sub

```

## 2. Bersihkan Form (CLEAR)

```vb
    Sub ResetForm()
        txtKode.Clear()
        txtJudul.Clear()
        txtPengarang.Clear()
        txtTahun.Clear()
        txtStok.Clear()
        txtKode.Focus()
        txtKode.ReadOnly = False
    End Sub

```

## 3. Simpan Data Buku (CREATE)


```vb
  ' -- CREATE (Simpan Data)
  If txtKode.Text.Trim() = "" OrElse txtJudul.Text.Trim() = "" Then
      MessageBox.Show("Kode dan Judul buku wajib di isi.", "Validasi", MessageBoxButtons.OK, MessageBoxIcon.Warning)
      Return
  End If

  Try
      Using conn As MySqlConnection = GetConnection()
          conn.Open()
          Dim query As String =
              "INSERT INTO buku (kode_buku, judul_buku, pengarang, tahun_terbit, stok)" &
              "VALUES (@kode, @judul, @pengarang,@tahun, @stok)"
          Using cmd As New MySqlCommand(query, conn)
              cmd.Parameters.AddWithValue("@kode", txtKode.Text)
              cmd.Parameters.AddWithValue("@judul", txtJudul.Text)
              cmd.Parameters.AddWithValue("@pengarang", txtPengarang.Text)
              cmd.Parameters.AddWithValue("@tahun", txtTahun.Text)
              cmd.Parameters.AddWithValue("@stok", txtStok.Text)
              cmd.ExecuteNonQuery()
          End Using
          MessageBox.Show("Data Buku Berhasil Disimpan.", "Sukses", MessageBoxButtons.OK, MessageBoxIcon.Information)
          ResetForm()
          loadData()
      End Using

  Catch ex As Exception
      MessageBox.Show(ex.Message, "Error", MessageBoxButtons.OK, MessageBoxIcon.Error)
  End Try

```
## 4. Update Data Buku

```vb
 If txtKode.ReadOnly = False Then
            MessageBox.Show("Pilih dulu baris pada tabel sebelum mengubah data.",
                            "Pilih Data", MessageBoxButtons.OK, MessageBoxIcon.Information)
            Return
        End If

        Try
            Using conn As MySqlConnection = GetConnection()
                conn.Open()

                Dim query As String =
                    "UPDATE buku SET judul_buku = @judul, pengarang = @pengarang, " &
                    "tahun_terbit = @tahun, stok = @stok WHERE kode_buku = @kode"
                Dim baris As Integer
                Using cmd As New MySqlCommand(query, conn)
                    cmd.Parameters.AddWithValue("@judul", txtJudul.Text.Trim())
                    cmd.Parameters.AddWithValue("@pengarang", txtPengarang.Text.Trim())
                    cmd.Parameters.AddWithValue("@tahun", tahun)
                    cmd.Parameters.AddWithValue("@stok", CInt(txtStok.Text.Trim()))
                    cmd.Parameters.AddWithValue("@kode", txtKode.Text.Trim())

                    baris = cmd.ExecuteNonQuery()
                End Using

                If baris = 0 Then
                    MessageBox.Show("Tidak ada data yang berubah. Pastikan kode buku benar.",
                                    "Tidak Ditemukan", MessageBoxButtons.OK, MessageBoxIcon.Warning)
                Else
                    MessageBox.Show(baris & " baris berhasil diperbarui.", "Sukses",
                                    MessageBoxButtons.OK, MessageBoxIcon.Information)
                End If

                LoadData()
                ClearForm()
            End Using
        Catch ex As Exception
            MessageBox.Show("Error: " & ex.Message,
                            "Gagal", MessageBoxButtons.OK, MessageBoxIcon.Error)
        End Try

```

## 5. Delete Data Buku

``` vb
 If txtKode.ReadOnly = False Then
            MessageBox.Show("Pilih dulu baris pada tabel yang akan dihapus.",
                            "Pilih Data", MessageBoxButtons.OK, MessageBoxIcon.Information)
            Return
        End If

        Dim jawab As DialogResult = MessageBox.Show(
            "Hapus buku " & txtKode.Text & ": " & txtJudul.Text & "?" & vbCrLf &
            "Tindakan ini tidak dapat dibatalkan.",
            "Konfirmasi Hapus", MessageBoxButtons.YesNo, MessageBoxIcon.Warning)
        If jawab <> DialogResult.Yes Then Return

        Try
            Using conn As MySqlConnection = GetConnection()
                conn.Open()

                Dim baris As Integer
                Using cmd As New MySqlCommand("DELETE FROM buku WHERE kode_buku = @kode", conn)
                    cmd.Parameters.AddWithValue("@kode", txtKode.Text.Trim())
                    baris = cmd.ExecuteNonQuery()
                End Using

                If baris > 0 Then
                    MessageBox.Show("Data buku berhasil dihapus.", "Sukses",
                                    MessageBoxButtons.OK, MessageBoxIcon.Information)
                Else
                    MessageBox.Show("Data tidak ditemukan atau sudah dihapus.",
                                    "Tidak Ditemukan", MessageBoxButtons.OK, MessageBoxIcon.Warning)
                End If

                LoadData()
                ClearForm()
            End Using
        Catch ex As Exception
            MessageBox.Show("Error: " & ex.Message,
                            "Gagal", MessageBoxButtons.OK, MessageBoxIcon.Error)
        End Try
    End Sub

```


## Pilih Baris

```vb
If e.RowIndex < 0 Then Return

Dim row As DataGridViewRow = dgvBuku.Rows(e.RowIndex)
txtKode.Text = row.Cells("kode_buku").Value.ToString()
txtJudul.Text = row.Cells("judul_buku").Value.ToString()
txtPengarang.Text = row.Cells("pengarang").Value.ToString()

If IsDBNull(row.Cells("tahun_terbit").Value) Then
txtTahun.Clear()
Else
txtTahun.Text = row.Cells("tahun_terbit").Value.ToString()
End If

txtStok.Text = row.Cells("stok").Value.ToString()
txtKode.ReadOnly = True

```

