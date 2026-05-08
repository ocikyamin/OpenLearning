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
