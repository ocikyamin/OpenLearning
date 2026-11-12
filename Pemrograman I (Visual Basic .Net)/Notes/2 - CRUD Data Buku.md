# CRUD Data Buku `FormBuku.vb`

## 1.  Tampil Data Buku (READ )
DML : `SELECT * FROM buku`

```vb

    ' Tampil Data Buku
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
## 2. Validasi Stok Buku
```vb
    Private Function StokValid() As Boolean
        Dim stok As Integer
        If Not Integer.TryParse(txtStok.Text.Trim(), stok) OrElse stok < 0 Then
            MessageBox.Show("Stok harus berupa angka 0 atau lebih.",
                            "Validasi", MessageBoxButtons.OK, MessageBoxIcon.Warning)
            txtStok.Focus()
            Return False
        End If
        Return True
    End Function
```
## 3. Bersihkan Form (CLEAR)

```vb
txtKode.Clear()
txtJudul.Clear()
txtPengarang.Clear()
txtTahun.Clear()
txtStok.Clear()
txtKode.ReadOnly = False
dgvBuku.ClearSelection()
txtKode.Focus()

```

## 4. Simpan Data Buku (CREATE)


```vb
 If txtKode.Text.Trim() = "" OrElse txtJudul.Text.Trim() = "" Then
            MessageBox.Show("Kode dan judul buku wajib diisi.",
                            "Validasi", MessageBoxButtons.OK, MessageBoxIcon.Warning)
            Return
        End If
        If Not StokValid() Then Return

        Dim tahun As Object = DBNull.Value
        Dim nilaiTahun As Integer
        If Integer.TryParse(txtTahun.Text.Trim(), nilaiTahun) Then tahun = nilaiTahun

        Try
            Using conn As MySqlConnection = GetConnection()
                conn.Open()

                Dim query As String =
                    "INSERT INTO buku (kode_buku, judul_buku, pengarang, tahun_terbit, stok) " &
                    "VALUES (@kode, @judul, @pengarang, @tahun, @stok)"
                Using cmd As New MySqlCommand(query, conn)
                    cmd.Parameters.AddWithValue("@kode", txtKode.Text.Trim())
                    cmd.Parameters.AddWithValue("@judul", txtJudul.Text.Trim())
                    cmd.Parameters.AddWithValue("@pengarang", txtPengarang.Text.Trim())
                    cmd.Parameters.AddWithValue("@tahun", tahun)
                    cmd.Parameters.AddWithValue("@stok", CInt(txtStok.Text.Trim()))

                    cmd.ExecuteNonQuery()
                End Using

                MessageBox.Show("Data buku berhasil disimpan.", "Sukses",
                                MessageBoxButtons.OK, MessageBoxIcon.Information)
                LoadData()
                ClearForm()
            End Using
        Catch ex As Exception
            MessageBox.Show("Error: " & ex.Message,
                            "Gagal", MessageBoxButtons.OK, MessageBoxIcon.Error)
        End Try

```
