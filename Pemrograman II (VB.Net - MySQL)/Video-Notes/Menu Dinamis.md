# Dynamic Form in Panel
# Yang Akan Dipelajari Mahasiswa

Dengan teknik ini mahasiswa belajar:

* multiple form architecture,
* dynamic UI,
* panel container,
* reusable procedure,
* modular desktop app.


# Setting Panel

## Property

```text id="s27d48"
Dock = Fill
```

---

# 1. Membuat Procedure LoadForm

## Pada FrmMenuUtama

Tambahkan coding berikut.

```vbnet id="vhg61o"
Public Sub LoadForm(ByVal form As Form)

    pnlContent.Controls.Clear()

    form.TopLevel = False

    form.FormBorderStyle =
        FormBorderStyle.None

    form.Dock = DockStyle.Fill

    pnlContent.Controls.Add(form)

    form.Show()

End Sub
```

---

# Penjelasan

## pnlContent.Controls.Clear()

Menghapus form sebelumnya.

---

## form.TopLevel = False

Agar form bisa ditanam di panel.

---

## DockStyle.Fill

Form otomatis memenuhi panel.

---

# 2. Menampilkan FrmPelanggan

## Coding Button Pelanggan

```vbnet id="7lyvlt"
Private Sub btnPelanggan_Click(
    sender As Object,
    e As EventArgs
) Handles btnPelanggan.Click

    LoadForm(FrmPelanggan)

End Sub
```

---

# 3. Menampilkan FrmTransaksi

```vbnet id="jlwmzj"
Private Sub btnTransaksi_Click(
    sender As Object,
    e As EventArgs
) Handles btnTransaksi.Click

    LoadForm(FrmTransaksi)

End Sub
```

---

# 4. Menampilkan Dashboard Default

Misalnya:

* Panel dashboard ada di form khusus:
  `FrmDashboard`

---

## Saat Form Utama Dibuka

```vbnet id="k53nki"
Private Sub FrmMenuUtama_Load(
    sender As Object,
    e As EventArgs
) Handles MyBase.Load
    LoadForm(FrmDashboard)

End Sub
```

---

# Struktur Form yang Direkomendasikan

```text id="0vw88z"
Forms
│
├── FrmLogin
├── FrmMenuUtama
├── FrmDashboard
├── FrmPelanggan
└── FrmTransaksi
```

---

# Tambahan Pada Form Child

Set:

```text id="s7r5n8"
StartPosition = Manual
```
