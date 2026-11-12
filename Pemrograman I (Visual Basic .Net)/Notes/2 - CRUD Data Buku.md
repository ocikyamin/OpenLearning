# CRUD Data Buku `FormBuku.vb`

## 1.  Tampil Data Buku (READ )
DML : `SELECT * FROM buku`

```vb

   ' Tampil Data Buku
   Private Sub LoadDataBuku()
       Try
           Using conn As MySqlConnection = GetConnection()
               Dim query As String = "SELECT * FROM buku"
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


## 2. Simpan Data Buku (CREATE)
