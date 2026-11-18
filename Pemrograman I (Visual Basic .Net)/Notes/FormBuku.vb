Imports Google.Protobuf
Imports MySql.Data.MySqlClient

Public Class FormBuku
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

    Private Sub FormBuku_Load(sender As Object, e As EventArgs) Handles MyBase.Load
        loadData()
    End Sub

    ' CLEAR (Bersihkan Form)
    Sub ResetForm()
        txtKode.Clear()
        txtJudul.Clear()
        txtPengarang.Clear()
        txtTahun.Clear()
        txtStok.Clear()
        txtKode.Focus()
        txtKode.ReadOnly = False
    End Sub


    Private Sub btnSimpan_Click(sender As Object, e As EventArgs) Handles btnSimpan.Click
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


    End Sub

    Private Sub btnReset_Click(sender As Object, e As EventArgs) Handles btnReset.Click
        ResetForm()
    End Sub


    Private Sub dgvBuku_CellClick(sender As Object, e As DataGridViewCellEventArgs) Handles dgvBuku.CellClick
        If e.RowIndex < 0 Then Return
        Dim row As DataGridViewRow = dgvBuku.Rows(e.RowIndex)
        txtKode.Text = row.Cells("kode_buku").Value.ToString
        txtJudul.Text = row.Cells("judul_buku").Value.ToString
        txtPengarang.Text = row.Cells("pengarang").Value.ToString
        txtTahun.Text = row.Cells("tahun_terbit").Value.ToString
        txtStok.Text = row.Cells("stok").Value.ToString
        txtKode.ReadOnly = True
    End Sub

    Private Sub btnUpdate_Click(sender As Object, e As EventArgs) Handles btnUpdate.Click
        If txtKode.ReadOnly = False Then
            MessageBox.Show("Belum ada data yang dipilih.", "Pilih Data", MessageBoxButtons.OK, MessageBoxIcon.Warning)
            Return
        End If

        ' Fungsi Ubah Data
        Try
            Using conn As MySqlConnection = GetConnection()
                conn.Open()
                Dim query As String = "UPDATE buku set judul_buku=@judul,pengarang=@pengarang,tahun_terbit=@tahun, stok=@stok " &
                                       "WHERE kode_buku=@kode"
                Dim baris As Integer
                Using cmd As New MySqlCommand(query, conn)
                    cmd.Parameters.AddWithValue("@kode", txtKode.Text)
                    cmd.Parameters.AddWithValue("@judul", txtJudul.Text)
                    cmd.Parameters.AddWithValue("@pengarang", txtPengarang.Text)
                    cmd.Parameters.AddWithValue("@tahun", txtTahun.Text)
                    cmd.Parameters.AddWithValue("@stok", txtStok.Text)
                    baris = cmd.ExecuteNonQuery()
                End Using
                If baris = 0 Then
                    MessageBox.Show("Tidak ada data yang diubah. Pastikan Kode Buku Benar", "Data Tidak ditemukan", MessageBoxButtons.OK, MessageBoxIcon.Warning)
                Else
                    MessageBox.Show("Data Buku Berhasil diubah", "Sukses", MessageBoxButtons.OK, MessageBoxIcon.Information)
                End If
                loadData()
                ResetForm()
            End Using

        Catch ex As Exception
            MsgBox(ex.Message)
        End Try


    End Sub

    Private Sub btnDelete_Click(sender As Object, e As EventArgs) Handles btnDelete.Click
        If txtKode.ReadOnly = False Then
            MessageBox.Show("Belum ada data yang dipilih.", "Pilih Data", MessageBoxButtons.OK, MessageBoxIcon.Warning)
            Return
        End If

        Dim jawab As DialogResult = MessageBox.Show(
            "Hapus Buku " & txtKode.Text & ": " & txtJudul.Text & "? " & vbCrLf &
            "Tindakan ini tidak dapat dibatalkan",
            "Konfirmasi Hapus", MessageBoxButtons.YesNo,
            MessageBoxIcon.Warning
            )
        If jawab <> DialogResult.Yes Then Return
        Try
            Using conn As MySqlConnection = GetConnection()
                conn.Open()
                Dim baris As Integer
                Dim query As String = "DELETE FROM buku WHERE kode_buku= @kode"
                Using cmd As New MySqlCommand(query, conn)
                    cmd.Parameters.AddWithValue("@kode", txtKode.Text)
                    baris = cmd.ExecuteNonQuery()
                End Using
                If baris > 0 Then
                    MessageBox.Show("Data Buku Berhasil Dihapus.", "Sukses", MessageBoxButtons.OK, MessageBoxIcon.Information)
                Else
                    MessageBox.Show("Data Tidak ditemukan. atau dihapus", "Tidak Ditemukan", MessageBoxButtons.OK, MessageBoxIcon.Warning)
                End If
                loadData()
                ResetForm()

            End Using

        Catch ex As Exception
            MsgBox(ex.Message)
        End Try


    End Sub

    Private Sub Button5_Click(sender As Object, e As EventArgs) Handles Button5.Click
        loadData()
    End Sub
End Class