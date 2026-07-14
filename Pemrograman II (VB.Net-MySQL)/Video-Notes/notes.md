## KONEKSI
```vb 

Dim MySQLKonek ="Server=localhost;Database=db_bimbel_4f;User=root;Password=;SslMode = none"
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
    Catch ex As Exception
        MsgBox("Koneksi Gagal: " & ex.Message)
    End Try
End Sub

    Function Diskonek()
        Koneksi.Close()
        Return Koneksi
    End Function
```


## LOGIN

```vb
Try
Konek()
cmd = New MySqlCommand("SELECT * FROM users WHERE email = '" & Email & "' AND password ='" & Password & "' ", Koneksi)
'Dim reader As MySqlDataReader
dr = cmd.ExecuteReader()
dr.Read()

If dr.HasRows Then
' Username dan password ditemukan
MessageBox.Show("Login Sukses, Akses Telah Diberikan", "Success", MessageBoxButtons.OK, MessageBoxIcon.Information)
      'Buka Form Tujuan

      Dim MainMenu As New Form2
      MainMenu.Show()
      Me.Hide()
Else

' Username dan password tidak ditemukan
MessageBox.Show("Login gagal ! Username atau password salah.", "Warning ", MessageBoxButtons.OK, MessageBoxIcon.Warning)
End If
Diskonek()
Catch ex As Exception
MsgBox(ex.Message)
End Try

```

## TAMPILKAN DATA
  ```vb
  ' Fungsi Untuk Menampilkan data
    Sub TampilData()
        Konek()
        da = New MySqlDataAdapter("SELECT * FROM programs", Koneksi)
        dt = New DataTable
        da.Fill(dt)
        DataGridView1.Rows.Clear()
        For i = 0 To dt.Rows.Count - 1
            DataGridView1.Rows.Add(dt.Rows(i).Item(1))
            DataGridView1.Rows(i).Cells(1).Value = dt.Rows(i).Item(2)
        Next
        Diskonek()
End Sub

```

##  INSERT
```vb
 cmd = New MySqlCommand("INSERT INTO programs (kode,program) VALUES ('" & TextKode.Text & "','" & TextProgram.Text & "') ", Koneksi)
                    cmd.ExecuteNonQuery()
                    MsgBox("OK ! Data Program berhasil disimpan ")

```
## UPDATE

```vb
 cmd = New MySqlCommand("UPDATE programs SET program='" & TextProgram.Text & "' WHERE kode='" & TextKode.Text & "' ", Koneksi)
                cmd.ExecuteNonQuery()
                MsgBox("OK ! Data Program berhasil diperbarui ")

```

## DELETE

```vb
If TextKode.Text = "" Then
            MsgBox("Tidak ada data terpilih")
        Else
            Dim result As DialogResult = MessageBox.Show("Apakah Anda yakin ingin menghapus data ini?", "Konfirmasi Penghapusan", MessageBoxButtons.YesNo, MessageBoxIcon.Question)

            If result = DialogResult.Yes Then
                ' Hapus data di sini
                Try
                    Konek()

                    cmd = New MySqlCommand("DELETE FROM programs WHERE kode='" & TextKode.Text & "'  ", Koneksi)
                    cmd.ExecuteNonQuery()
                    MsgBox("Data Berhasil dihapus")
                    Segarkan()
                Catch ex As Exception
                    MsgBox(ex.Message)
                End Try
            End If
        End If

```



## CARI DATA

```vb
 'Fungsi Cari Data 
    Sub CariData()
        Konek()
        da = New MySqlDataAdapter("SELECT * FROM programs WHERE program like '%" & TextCari.Text & "%' ", Koneksi)
        dt = New DataTable
        da.Fill(dt)
        DataGridView1.Rows.Clear()
        For i = 0 To dt.Rows.Count - 1
            DataGridView1.Rows.Add(dt.Rows(i).Item(1))
            DataGridView1.Rows(i).Cells(1).Value = dt.Rows(i).Item(2)
        Next
        Diskonek()
    End Sub

```

 ### File Dialog Utuk gambar guru
 
```vb

   BukaFile.Filter = "Cari gambar (*.jpg; *.jpeg;*.png) | *.jpg;*.jpeg;*.png "
        BukaFile.ShowDialog()
        UrlGambar.Text = BukaFile.FileName
        PictureBox1.ImageLocation = UrlGambar.Text
        PictureBox1.SizeMode = PictureBoxSizeMode.StretchImage

```


  ## Fungsi Cari Data 

    ```vb
    Sub CariData()
        Konek()
        da = New MySqlDataAdapter("SELECT * FROM programs WHERE program like '%" & TextCari.Text & "%' ", Koneksi)
        dt = New DataTable
        da.Fill(dt)
        DataGridView1.Rows.Clear()
        For i = 0 To dt.Rows.Count - 1
            DataGridView1.Rows.Add(dt.Rows(i).Item(1))
            DataGridView1.Rows(i).Cells(1).Value = dt.Rows(i).Item(2)
        Next
        Diskonek()
    End Sub

```

##  GET DATA BY ID 
 
 ```vb
 Dim i As Integer
        i = DataGridView1.CurrentRow.Index
        TextKode.Text = DataGridView1.Item(0, i).Value
        TextProgram.Text = DataGridView1.Item(1, i).Value
```

### insert by non escape

' Gunakan parameter untuk menyimpan nama file yang di-escape
cmd = New MySqlCommand("INSERT INTO teachers (kode, nama_guru, avatar) VALUES (@kode, @nama_guru, @avatar)", Koneksi)

' Tambahkan parameter dan nilainya
cmd.Parameters.AddWithValue("@kode", TextKode.Text)
cmd.Parameters.AddWithValue("@nama_guru", TextNama.Text)
cmd.Parameters.AddWithValue("@avatar", escapedAvatar)

' Jalankan perintah
cmd.ExecuteNonQuery()

MsgBox("Data Guru berhasil ditambahkan")





