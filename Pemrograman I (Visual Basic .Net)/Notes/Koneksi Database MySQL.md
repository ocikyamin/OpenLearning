# Koneksi Database MySQL

## App.Config

``` xml
	<appSettings>
		<add key="koneksiDB" value="Server=localhost;Database=db_perpustakaan_tutorial;Uid=root;Pwd=root" />
	</appSettings>
```

## ConfigDB.vb
```vb
Imports System.Configuration
Imports MySql.Data.MySqlClient

Module ConfigDB
    Private ReadOnly ConnectionString As String = ConfigurationManager.AppSettings("koneksiDB")
    Public Function GetConnection()
        Return New MySqlConnection(ConnectionString)
    End Function

    ' Tes Koneksi Database
    Public Sub UjiKoneksi()
        Try
            Using conn As MySqlConnection = GetConnection()
                conn.Open()
                MsgBox("Koneksi MySQL Berhasil..")
            End Using
        Catch ex As Exception
            MsgBox(ex.Message)
        End Try
    End Sub


End Module

```