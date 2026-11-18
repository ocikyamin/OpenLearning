
```vb
    ' Menu Dinamis
    Public Sub LoadForm(ByVal form As Form)
        ' Clear Content
        PanelContent.Controls.Clear()
        form.TopLevel = False
        form.FormBorderStyle = FormBorderStyle.None
        form.Dock = DockStyle.Fill
        PanelContent.Controls.Add(form)
        form.Show()
    End Sub


```

```vb
' Contoh Penggunaan Menu
    Private Sub btnMenuBuku_Click(sender As Object, e As EventArgs) Handles btnMenuBuku.Click
        LoadForm(FormBuku)
    End Sub

    ```