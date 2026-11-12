# Database (db_perpustakaan)

```sql
-- Membuat database bila belum ada
CREATE DATABASE IF NOT EXISTS db_perpustakaan
 CHARACTER SET utf8mb4
 COLLATE utf8mb4_general_ci;
-- Memilih database yang akan digunakan
USE db_perpustakaan;
-- Membuat tabel induk (parent)
CREATE TABLE buku (
 kode_buku VARCHAR(10) NOT NULL,
 judul_buku VARCHAR(100) NOT NULL,
 pengarang VARCHAR(50) NOT NULL,
 tahun_terbit YEAR NULL,
 stok INT NOT NULL DEFAULT 0,
 PRIMARY KEY (kode_buku),
 CONSTRAINT chk_stok_buku CHECK (stok >= 0)
) ENGINE=InnoDB;
CREATE TABLE anggota (
 id_anggota VARCHAR(10) NOT NULL,
 nama_anggota VARCHAR(50) NOT NULL,
 alamat TEXT NULL,
 telepon VARCHAR(15) NULL,
 PRIMARY KEY (id_anggota)
) ENGINE=InnoDB;
-- Membuat tabel anak (child) yang memiliki Foreign Key
CREATE TABLE peminjaman (
 id_pinjam INT NOT NULL AUTO_INCREMENT,
 id_anggota VARCHAR(10) NOT NULL,
 kode_buku VARCHAR(10) NOT NULL,
 tanggal_pinjam DATE NOT NULL,
 tanggal_kembali DATE NULL,
 PRIMARY KEY (id_pinjam),
 CONSTRAINT fk_pinjam_anggota
 FOREIGN KEY (id_anggota) REFERENCES anggota(id_anggota)
 ON UPDATE CASCADE ON DELETE RESTRICT,
 CONSTRAINT fk_pinjam_buku
 FOREIGN KEY (kode_buku) REFERENCES buku(kode_buku)
 ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB;

```