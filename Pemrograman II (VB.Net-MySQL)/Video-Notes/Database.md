# Rancangan Database

## Aplikasi Laundry Desktop VB.NET & MySQL

---

# 1. Membuat Database

```sql
CREATE DATABASE db_laundry;
USE db_laundry;
```

---

# 2. Tabel Users

## Fungsi

Menyimpan data akun login aplikasi.

```sql
CREATE TABLE users (
    id_user INT AUTO_INCREMENT PRIMARY KEY,
    nama_user VARCHAR(100) NOT NULL,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(100) NOT NULL,
    level_user ENUM('admin','kasir') NOT NULL
);
```

---

# 3. Tabel Pelanggan

## Fungsi

Menyimpan data customer laundry.

```sql
CREATE TABLE pelanggan (
    id_pelanggan INT AUTO_INCREMENT PRIMARY KEY,
    nama_pelanggan VARCHAR(100) NOT NULL,
    no_hp VARCHAR(20),
    alamat TEXT
);
```

---

# 4. Tabel Transaksi

## Fungsi

Menyimpan data transaksi laundry.

```sql
CREATE TABLE transaksi (
    id_transaksi INT AUTO_INCREMENT PRIMARY KEY,
    kode_transaksi VARCHAR(20) NOT NULL,
    tanggal DATE NOT NULL,
    
    id_pelanggan INT NOT NULL,
    id_user INT NOT NULL,

    berat DECIMAL(5,2) NOT NULL,
    harga_perkg INT NOT NULL,
    total_bayar INT NOT NULL,

    status_laundry ENUM('Proses','Selesai','Diambil') 
    DEFAULT 'Proses',

    FOREIGN KEY (id_pelanggan)
    REFERENCES pelanggan(id_pelanggan),

    FOREIGN KEY (id_user)
    REFERENCES users(id_user)
);
```

---

# 5. Menambahkan User Awal

```sql
INSERT INTO users
(nama_user, username, password, level_user)
VALUES
('Administrator', 'admin', 'admin123', 'admin');
```

---

# 6. Menambahkan Data Pelanggan

```sql
INSERT INTO pelanggan
(nama_pelanggan, no_hp, alamat)
VALUES
('Budi Saputra', '081234567890', 'Padang'),
('Siti Aisyah', '082345678901', 'Bukittinggi'),
('Andi Pratama', '083456789012', 'Payakumbuh');
```

---

# 7. Menambahkan Data Transaksi

```sql
INSERT INTO transaksi
(
    kode_transaksi,
    tanggal,
    id_pelanggan,
    id_user,
    berat,
    harga_perkg,
    total_bayar,
    status_laundry
)
VALUES
(
    'TRX001',
    CURDATE(),
    1,
    1,
    3.5,
    7000,
    24500,
    'Proses'
);
```

---

# 8. Menampilkan Data Users

```sql
SELECT * FROM users;
```

---

# 9. Menampilkan Data Pelanggan

```sql
SELECT * FROM pelanggan;
```

---

# 10. Menampilkan Data Transaksi

```sql
SELECT * FROM transaksi;
```

---

# 11. Menampilkan Relasi Transaksi (JOIN)

```sql
SELECT
    transaksi.kode_transaksi,
    transaksi.tanggal,
    pelanggan.nama_pelanggan,
    users.nama_user,
    transaksi.berat,
    transaksi.total_bayar,
    transaksi.status_laundry
FROM transaksi
JOIN pelanggan
ON transaksi.id_pelanggan = pelanggan.id_pelanggan
JOIN users
ON transaksi.id_user = users.id_user;
```

---

# Relasi Database

```text
users
   |
   |----< transaksi >----|
                         |
                    pelanggan
```
