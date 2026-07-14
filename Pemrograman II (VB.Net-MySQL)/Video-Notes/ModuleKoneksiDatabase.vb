   Dim MySQLKonek = "Server=localhost;Database=db_aplikasi_vbnet;User=root;Password=root"
   Public Koneksi As New MySqlConnection(MySQLKonek)

   Public da As MySqlDataAdapter = Nothing
   Public cmd As MySqlCommand = Nothing
   Public dt As New DataTable
   Public dr As MySqlDataReader

   Public Status As Boolean = False
   Public Sub Konek()
       Try
           ' Cek jika koneksi masih terbuka, tutup dulu baru buka lagi
           If Koneksi.State = ConnectionState.Open Then
               Koneksi.Close()
           End If
           Koneksi.Open()
           MessageBox.Show("Koneksi Database Berhasil")
       Catch ex As Exception
           MsgBox("Koneksi Gagal: " & ex.Message)
       End Try
   End Sub

   Function Diskonek()
       Koneksi.Close()
       Return Koneksi
   End Function