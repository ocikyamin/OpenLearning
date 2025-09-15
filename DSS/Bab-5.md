# BAB 5: METODE SISTEM PENDUKUNG KEPUTUSAN

## 1. PENDAHULUAN

Metode dalam Sistem Pendukung Keputusan (SPK) merupakan inti dari proses pengambilan keputusan yang sistematis dan terstruktur. Dalam konteks pengambilan keputusan yang kompleks, metode berfungsi sebagai alat bantu untuk mengolah data menjadi informasi yang berguna bagi pengambil keputusan. Metode-metode ini diperlukan karena dalam dunia nyata, keputusan jarang diambil berdasarkan satu kriteria saja, melainkan melibatkan banyak faktor yang saling terkait dan terkadang bertentangan.

Hubungan antara metode dengan pemodelan dan analisis dalam SPK sangat erat. Pemodelan merupakan proses representasi masalah keputusan ke dalam bentuk matematis atau logis, sedangkan analisis adalah proses pengolahan model tersebut untuk menghasilkan solusi atau rekomendasi. Metode SPK menjadi jembatan yang menghubungkan kedua proses ini, mengubah data mentah menjadi keputusan yang dapat dipertanggungjawabkan.

Dalam bab ini, akan dibahas tiga metode SPK yang sering digunakan: Simple Additive Weighting (SAW), Multi Attribute Utility Theory (MAUT), dan Naive Bayes. Ketiga metode ini memiliki pendekatan yang berbeda namun saling melengkapi dalam menyelesaikan berbagai masalah keputusan.

## 2. URAIAN MATERI

### 2.1 Konsep Dasar Metode Pengambilan Keputusan Multi-Kriteria (MCDM)

Multi Criteria Decision Making (MCDM) atau pengambilan keputusan multi-kriteria adalah pendekatan sistematis untuk menyelesaikan masalah keputusan yang melibatkan beberapa kriteria yang saling terkait. MCDM membantu pengambil keputusan untuk memilih alternatif terbaik dari beberapa pilihan yang tersedia berdasarkan kriteria yang telah ditentukan.

**Konsep Dasar MCDM:**
- **Alternatif**: Opsi atau pilihan yang akan dievaluasi
- **Kriteria**: Faktor atau aspek yang digunakan untuk mengevaluasi alternatif
- **Bobot**: Tingkat kepentingan relatif dari setiap kriteria
- **Nilai**: Tingkat kepuasan atau performa alternatif terhadap kriteria

MCDM sangat berguna dalam situasi di mana:
- Terdapat beberapa alternatif yang layak dipertimbangkan
- Keputusan harus mempertimbangkan banyak aspek
- Kriteria-kriteria memiliki satuan dan skala pengukuran yang berbeda
- Ada trade-off (pertukaran) antara kriteria yang saling bertentangan

### 2.2 Metode SAW (Simple Additive Weighting)

#### 2.2.1 Konsep Dasar

Simple Additive Weighting (SAW) atau yang dikenal juga sebagai metode penjumlahan terbobot adalah salah satu metode yang paling sederhana dan paling banyak digunakan dalam MCDM. Konsep dasar metode SAW adalah mencari penjumlahan terbobot dari rating kinerja pada setiap alternatif pada semua atribut.

Metode SAW dapat dianggap sebagai cara yang paling mudah dan intuitif untuk menangani masalah MCDM karena fungsi linear additive dapat mewakili preferensi pembuat keputusan. Metode ini membutuhkan proses normalisasi matriks keputusan ke suatu skala yang dapat diperbandingkan dengan semua rating alternatif yang ada.

#### 2.2.2 Rumus Matematis

Rumus utama dalam metode SAW adalah:

**Nilai Preferensi Alternatif:**
```
Vi = Σ (wj × rij)
```
Dimana:
- Vi = Nilai preferensi untuk alternatif ke-i
- wj = Bobot untuk kriteria ke-j
- rij = Rating ternormalisasi untuk alternatif ke-i pada kriteria ke-j

**Rumus Normalisasi:**
Untuk kriteria benefit (lebih besar lebih baik):
```
rij = xij / max(xij)
```

Untuk kriteria cost (lebih kecil lebih baik):
```
rij = min(xij) / xij
```
Dimana:
- xij = Nilai asli alternatif ke-i pada kriteria ke-j
- max(xij) = Nilai maksimum pada kriteria ke-j
- min(xij) = Nilai minimum pada kriteria ke-j

#### 2.2.3 Langkah Penyelesaian

Langkah-langkah penyelesaian dengan metode SAW adalah sebagai berikut:

1. **Menentukan kriteria** yang akan dijadikan acuan dalam pengambilan keputusan
2. **Menentukan rating kecocokan** setiap alternatif pada setiap kriteria
3. **Membuat matriks keputusan** berdasarkan kriteria
4. **Melakukan normalisasi matriks** berdasarkan persamaan yang disesuaikan dengan jenis atribut (benefit atau cost)
5. **Menghitung nilai preferensi** dengan menjumlahkan perkalian antara matriks ternormalisasi dengan vektor bobot
6. **Melakukan perankingan** alternatif berdasarkan nilai preferensi tertinggi

#### 2.2.4 Contoh Kasus: Seleksi Mahasiswa Berprestasi

**Studi Kasus:** Sebuah universitas ingin memilih mahasiswa berprestasi dari 5 calon berdasarkan 4 kriteria.

**Tabel 1: Data Mahasiswa dan Kriteria**
| Alternatif | IPK (C1) | Prestasi (C2) | Organisasi (C3) | Kehadiran (C4) |
|------------|----------|---------------|-----------------|----------------|
| A1 (Andi)  | 3.75     | 3             | 2               | 95%            |
| A2 (Budi)  | 3.50     | 2             | 3               | 90%            |
| A3 (Citra) | 3.90     | 4             | 1               | 85%            |
| A4 (Dina)  | 3.60     | 3             | 2               | 92%            |
| A5 (Eko)   | 3.80     | 2             | 3               | 88%            |

**Bobot Kriteria:**
- C1 (IPK): 0.4
- C2 (Prestasi): 0.3
- C3 (Organisasi): 0.2
- C4 (Kehadiran): 0.1

**Jenis Kriteria:**
- C1, C2, C3, C4 = Benefit (semakin tinggi semakin baik)

**Langkah 1: Normalisasi Matriks**

Untuk kriteria benefit: rij = xij / max(xij)

**Tabel 2: Matriks Ternormalisasi**
| Alternatif | C1 | C2 | C3 | C4 |
|------------|----|----|----|----|
| A1 | 3.75/3.90 = 0.962 | 3/4 = 0.750 | 2/3 = 0.667 | 95/95 = 1.000 |
| A2 | 3.50/3.90 = 0.897 | 2/4 = 0.500 | 3/3 = 1.000 | 90/95 = 0.947 |
| A3 | 3.90/3.90 = 1.000 | 4/4 = 1.000 | 1/3 = 0.333 | 85/95 = 0.895 |
| A4 | 3.60/3.90 = 0.923 | 3/4 = 0.750 | 2/3 = 0.667 | 92/95 = 0.968 |
| A5 | 3.80/3.90 = 0.974 | 2/4 = 0.500 | 3/3 = 1.000 | 88/95 = 0.926 |

**Langkah 2: Perhitungan Nilai Preferensi**

Vi = Σ (wj × rij)

**Tabel 3: Perhitungan Nilai Preferensi**
| Alternatif | C1×0.4 | C2×0.3 | C3×0.2 | C4×0.1 | Total (Vi) |
|------------|--------|--------|--------|--------|------------|
| A1 | 0.962×0.4 = 0.385 | 0.750×0.3 = 0.225 | 0.667×0.2 = 0.133 | 1.000×0.1 = 0.100 | **0.843** |
| A2 | 0.897×0.4 = 0.359 | 0.500×0.3 = 0.150 | 1.000×0.2 = 0.200 | 0.947×0.1 = 0.095 | **0.804** |
| A3 | 1.000×0.4 = 0.400 | 1.000×0.3 = 0.300 | 0.333×0.2 = 0.067 | 0.895×0.1 = 0.090 | **0.857** |
| A4 | 0.923×0.4 = 0.369 | 0.750×0.3 = 0.225 | 0.667×0.2 = 0.133 | 0.968×0.1 = 0.097 | **0.824** |
| A5 | 0.974×0.4 = 0.390 | 0.500×0.3 = 0.150 | 1.000×0.2 = 0.200 | 0.926×0.1 = 0.093 | **0.833** |

**Hasil Perankingan:**
1. A3 (Citra) = 0.857
2. A1 (Andi) = 0.843
3. A5 (Eko) = 0.833
4. A4 (Dina) = 0.824
5. A2 (Budi) = 0.804

**Kesimpulan:** Mahasiswa berprestasi yang terpilih adalah Citra (A3) dengan nilai preferensi tertinggi 0.857.

### 2.3 Metode MAUT (Multi Attribute Utility Theory)

#### 2.3.1 Konsep Dasar

Multi Attribute Utility Theory (MAUT) adalah metode untuk secara efektif mengintegrasikan data subjektif dan objektif ke skala umum atau indeks yang dapat digunakan untuk pengambilan keputusan. MAUT digunakan untuk mengubah dari beberapa kepentingan ke dalam nilai numerik dengan skala 0-1, dengan 0 mewakili pilihan terburuk dan 1 terbaik.

MAUT merupakan suatu metode perbandingan kuantitatif yang biasanya mengkombinasikan pengukuran atas biaya, resiko, dan keuntungan yang berbeda. Setiap kriteria yang ada memiliki beberapa alternatif yang mampu memberikan solusi. Untuk mencari alternatif yang mendekati dengan keinginan user, dilakukan perkalian terhadap skala prioritas yang sudah ditentukan.

#### 2.3.2 Proses Normalisasi & Pembobotan

**Rumus Normalisasi MAUT:**
```
U(x) = (x - xi-) / (xi+ - xi-)
```
Dimana:
- U(x) = Nilai normalisasi
- x = Bobot alternatif
- xi- = Bobot terburuk (minimum) dari kriteria ke-x
- xi+ = Bobot terbaik (maksimum) dari kriteria ke-x

**Rumus Perhitungan Akhir:**
```
v(x) = Σ (wi × ui(x))
```
Dimana:
- v(x) = Nilai evaluasi alternatif
- wi = Bobot kriteria ke-i
- ui(x) = Nilai normalisasi alternatif pada kriteria ke-i

**Syarat Pembobotan:**
```
Σ wi = 1
```

#### 2.3.3 Contoh Penerapan

**Studi Kasus:** Pemilihan lokasi perumahan berdasarkan 4 kriteria.

**Tabel 4: Data Lokasi Perumahan**
| Alternatif | Harga (juta) | Jarak (km) | Fasilitas | Keamanan |
|------------|--------------|------------|----------|----------|
| A1 (Lokasi 1) | 500 | 5 | 8 | 7 |
| A2 (Lokasi 2) | 450 | 8 | 6 | 8 |
| A3 (Lokasi 3) | 600 | 3 | 9 | 6 |
| A4 (Lokasi 4) | 400 | 10 | 5 | 7 |

**Bobot Kriteria:**
- Harga: 0.35 (Cost)
- Jarak: 0.25 (Cost)
- Fasilitas: 0.25 (Benefit)
- Keamanan: 0.15 (Benefit)

**Langkah 1: Normalisasi Data**

Untuk kriteria cost (Harga dan Jarak):
```
U(x) = (xi- - x) / (xi- - xi+)
```

Untuk kriteria benefit (Fasilitas dan Keamanan):
```
U(x) = (x - xi-) / (xi+ - xi-)
```

**Tabel 5: Matriks Ternormalisasi**
| Alternatif | Harga | Jarak | Fasilitas | Keamanan |
|------------|-------|-------|-----------|----------|
| A1 | (600-500)/(600-400) = 0.500 | (10-5)/(10-3) = 0.714 | (8-5)/(9-5) = 0.750 | (7-6)/(8-6) = 0.500 |
| A2 | (600-450)/(600-400) = 0.750 | (10-8)/(10-3) = 0.286 | (6-5)/(9-5) = 0.250 | (8-6)/(8-6) = 1.000 |
| A3 | (600-600)/(600-400) = 0.000 | (10-3)/(10-3) = 1.000 | (9-5)/(9-5) = 1.000 | (6-6)/(8-6) = 0.000 |
| A4 | (600-400)/(600-400) = 1.000 | (10-10)/(10-3) = 0.000 | (5-5)/(9-5) = 0.000 | (7-6)/(8-6) = 0.500 |

**Langkah 2: Perhitungan Nilai Akhir**

v(x) = Σ (wi × ui(x))

**Tabel 6: Perhitungan Nilai Akhir MAUT**
| Alternatif | Harga×0.35 | Jarak×0.25 | Fasilitas×0.25 | Keamanan×0.15 | Total v(x) |
|------------|------------|------------|---------------|---------------|------------|
| A1 | 0.500×0.35 = 0.175 | 0.714×0.25 = 0.179 | 0.750×0.25 = 0.188 | 0.500×0.15 = 0.075 | **0.617** |
| A2 | 0.750×0.35 = 0.263 | 0.286×0.25 = 0.072 | 0.250×0.25 = 0.063 | 1.000×0.15 = 0.150 | **0.548** |
| A3 | 0.000×0.35 = 0.000 | 1.000×0.25 = 0.250 | 1.000×0.25 = 0.250 | 0.000×0.15 = 0.000 | **0.500** |
| A4 | 1.000×0.35 = 0.350 | 0.000×0.25 = 0.000 | 0.000×0.25 = 0.000 | 0.500×0.15 = 0.075 | **0.425** |

**Hasil Perankingan:**
1. A1 (Lokasi 1) = 0.617
2. A2 (Lokasi 2) = 0.548
3. A3 (Lokasi 3) = 0.500
4. A4 (Lokasi 4) = 0.425

**Kesimpulan:** Lokasi perumahan terbaik adalah Lokasi 1 (A1) dengan nilai 0.617.

### 2.4 Metode Naive Bayes

#### 2.4.1 Konsep Probabilistik

Naive Bayes adalah metode klasifikasi data berdasarkan faktor-faktor probabilitas. Algoritma ini merupakan pengklasifikasian dengan metode probabilitas dan statistik yang ditemukan oleh Thomas Bayes. Metode ini didasarkan pada Teorema Bayes yang menggabungkan probabilitas kejadian sebelumnya dengan bukti baru untuk membuat prediksi.

Naive Bayes disebut "naive" (sederhana) karena mengasumsikan bahwa semua fitur atau atribut saling bebas satu sama lain, meskipun dalam kenyataannya fitur-fitur tersebut mungkin saling bergantung. Asumsi ini menyederhanakan perhitungan namun tetap memberikan hasil yang akurat dalam banyak kasus.

#### 2.4.2 Rumus Bayes

**Rumus Teorema Bayes:**
```
P(C|X) = [P(X|C) × P(C)] / P(X)
```
Dimana:
- P(C|X) = Probabilitas posterior (probabilitas kelas C diberikan fitur X)
- P(X|C) = Probabilitas likelihood (probabilitas fitur X diberikan kelas C)
- P(C) = Probabilitas prior (probabilitas awal kelas C)
- P(X) = Probabilitas evidence (probabilitas fitur X)

**Untuk multiple fitur:**
```
P(C|X1, X2, ..., Xn) = [P(X1|C) × P(X2|C) × ... × P(Xn|C) × P(C)] / P(X1, X2, ..., Xn)
```

Karena P(X1, X2, ..., Xn) konstan untuk semua kelas, maka dapat disederhanakan:
```
P(C|X) ∝ P(C) × Π P(Xi|C)
```

#### 2.4.3 Contoh Penerapan dalam Prediksi Pemilihan Lokasi Perumahan

**Studi Kasus:** Prediksi apakah suatu lokasi akan dipilih untuk perumahan berdasarkan data historis.

**Tabel 7: Data Historis Lokasi Perumahan**
| No | Harga Tanah | Jarak dari Pusat Kota | Angkutan Umum | Dipilih |
|----|--------------|----------------------|---------------|---------|
| 1 | Murah | Dekat | Tidak | Ya |
| 2 | Sedang | Dekat | Tidak | Ya |
| 3 | Mahal | Dekat | Tidak | Ya |
| 4 | Mahal | Jauh | Tidak | Tidak |
| 5 | Mahal | Sedang | Tidak | Tidak |
| 6 | Sedang | Jauh | Ada | Tidak |
| 7 | Murah | Jauh | Ada | Tidak |
| 8 | Murah | Sedang | Tidak | Ya |
| 9 | Mahal | Jauh | Ada | Tidak |
| 10 | Sedang | Sedang | Ada | Ya |

**Kasus Baru:** Harga tanah mahal, jarak sedang, ada angkutan umum. Apakah lokasi ini akan dipilih?

**Langkah 1: Hitung Probabilitas Prior**

P(Dipilih = Ya) = 5/10 = 0.5
P(Dipilih = Tidak) = 5/10 = 0.5

**Langkah 2: Hitung Probabilitas Likelihood**

**Untuk kelas "Ya":**
- P(Harga = Mahal | Ya) = 1/5 = 0.2
- P(Jarak = Sedang | Ya) = 2/5 = 0.4
- P(Angkutan = Ada | Ya) = 1/5 = 0.2

**Untuk kelas "Tidak":**
- P(Harga = Mahal | Tidak) = 3/5 = 0.6
- P(Jarak = Sedang | Tidak) = 1/5 = 0.2
- P(Angkutan = Ada | Tidak) = 3/5 = 0.6

**Langkah 3: Hitung Probabilitas Posterior**

P(Ya | X) ∝ P(Ya) × P(Harga=Mahal|Ya) × P(Jarak=Sedang|Ya) × P(Angkutan=Ada|Ya)
= 0.5 × 0.2 × 0.4 × 0.2 = 0.008

P(Tidak | X) ∝ P(Tidak) × P(Harga=Mahal|Tidak) × P(Jarak=Sedang|Tidak) × P(Angkutan=Ada|Tidak)
= 0.5 × 0.6 × 0.2 × 0.6 = 0.036

**Langkah 4: Normalisasi**

Total = 0.008 + 0.036 = 0.044

P(Ya | X) = 0.008 / 0.044 = 0.182
P(Tidak | X) = 0.036 / 0.044 = 0.818

**Kesimpulan:** Probabilitas lokasi tidak dipilih adalah 0.818, sehingga lokasi ini TIDAK direkomendasikan untuk perumahan.

### 2.5 Perbandingan Metode

Berikut adalah perbandingan ketiga metode berdasarkan berbagai aspek:

**Tabel 8: Perbandingan Metode SAW, MAUT, dan Naive Bayes**

| Aspek | SAW | MAUT | Naive Bayes |
|-------|-----|------|-------------|
| **Pendekatan** | Deterministik | Utilitas | Probabilistik |
| **Kompleksitas** | Rendah | Sedang | Sedang |
| **Kecepatan Proses** | Cepat | Sedang | Cepat untuk training, lambat untuk prediction |
| **Tipe Data** | Kuantitatif | Kuantitatif | Kualitatif & Kuantitatif |
| **Normalisasi** | Diperlukan | Diperlukan | Tidak diperlukan |
| **Pembobotan** | Subyektif | Subyektif | Otomatis dari data |
| **Output** | Ranking | Nilai utilitas | Probabilitas kelas |
| **Keakuratan** | Sedang | Tinggi | Tinggi untuk data besar |
| **Interpretasi** | Mudah | Sedang | Memerlukan pemahaman statistik |
| **Stabilitas** | Rendah | Tinggi | Sedang |

#### 2.5.1 Kelebihan dan Keterbatasan

**Metode SAW:**
- *Kelebihan:*
  - Sederhana dan mudah diimplementasikan
  - Proses perhitungan cepat
  - Hasil mudah diinterpretasikan
  - Cocok untuk masalah dengan kriteria yang jelas
- *Keterbatasan:*
  - Memerlukan normalisasi data
  - Pembobotan subyektif
  - Sensitif terhadap perubahan bobot
  - Tidak dapat menangani ketidakpastian

**Metode MAUT:**
- *Kelebihan:*
  - Dapat menggabungkan berbagai tipe kriteria
  - Hasil evaluasi bersifat objektif
  - Stabil terhadap perubahan bobot
  - Dapat menangani trade-off antar kriteria
- *Keterbatasan:*
  - Kompleksitas perhitungan lebih tinggi
  - Memerlukan pemahaman utilitas theory
  - Pembobotan masih subyektif
  - Rentan terhadap kesalahan normalisasi

**Metode Naive Bayes:**
- *Kelebihan:*
  - Dapat bekerja dengan data yang tidak lengkap
  - Efisien untuk dataset besar
  - Pembelajaran otomatis dari data historis
  - Dapat menangani ketidakpastian
- *Keterbatasan:*
  - Asumsi independensi fitur sering tidak realistis
  - Memerlukan data training yang cukup
  - Kurang efektif untuk kategori yang jarang muncul
  - Interpretasi hasil memerlukan pengetahuan statistik

#### 2.5.2 Konteks Penggunaan

**Gunakan SAW jika:**
- Masalah keputusan relatif sederhana
- Kriteria sudah terdefinisi dengan jelas
- Memerlukan solusi cepat
- Pengambil keputusan ingin kontrol penuh terhadap pembobotan
- Contoh: Seleksi karyawan, pemilihan supplier sederhana

**Gunakan MAUT jika:**
- Terdapat banyak kriteria dengan satuan berbeda
- Perlu menangani trade-off antar kriteria
- Menginginkan hasil yang stabil dan objektif
- Memerlukan evaluasi utilitas yang detail
- Contoh: Pemilihan lokasi bisnis, evaluasi proyek investasi

**Gunakan Naive Bayes jika:**
- Memiliki data historis yang cukup
- Ingin memprediksi berdasarkan pola masa lalu
- Terdapat ketidakpastian dalam data
- Menginginkan pembelajaran otomatis
- Contoh: Prediksi churn pelanggan, klasifikasi email spam, diagnosa medis

## 3. STUDI KASUS TERPADU

### 3.1 Deskripsi Masalah

Sebuah perusahaan teknologi ingin memilih kandidat terbaik untuk posisi "Data Scientist" dari 5 pelamar. Perusahaan menggunakan 4 kriteria untuk evaluasi:
1. IPK (C1) - Benefit
2. Pengalaman Kerja (tahun) (C2) - Benefit
3. Skill Programming (skala 1-10) (C3) - Benefit
4. Usia (tahun) (C4) - Cost (semakin muda semakin baik)

### 3.2 Dataset

**Tabel 9: Data Kandidat Data Scientist**
| Kandidat | IPK (C1) | Pengalaman (C2) | Skill (C3) | Usia (C4) | Status Historis |
|----------|----------|-----------------|------------|-----------|----------------|
| A1 (Ali) | 3.8 | 2 | 8 | 25 | Diterima |
| A2 (Budi) | 3.5 | 4 | 7 | 28 | Diterima |
| A3 (Cici) | 3.9 | 1 | 9 | 24 | Diterima |
| A4 (Doni) | 3.6 | 3 | 6 | 30 | Ditolak |
| A5 (Eka) | 3.7 | 5 | 8 | 32 | Diterima |

**Bobot untuk SAW dan MAUT:**
- C1: 0.3
- C2: 0.3
- C3: 0.25
- C4: 0.15

### 3.3 Perhitungan dengan Metode SAW

**Normalisasi:**
- C1, C2, C3 (Benefit): rij = xij / max(xij)
- C4 (Cost): rij = min(xij) / xij

**Tabel 10: Normalisasi SAW**
| Kandidat | C1 | C2 | C3 | C4 |
|----------|----|----|----|----|
| A1 | 3.8/3.9 = 0.974 | 2/5 = 0.400 | 8/9 = 0.889 | 24/25 = 0.960 |
| A2 | 3.5/3.9 = 0.897 | 4/5 = 0.800 | 7/9 = 0.778 | 24/28 = 0.857 |
| A3 | 3.9/3.9 = 1.000 | 1/5 = 0.200 | 9/9 = 1.000 | 24/24 = 1.000 |
| A4 | 3.6/3.9 = 0.923 | 3/5 = 0.600 | 6/9 = 0.667 | 24/30 = 0.800 |
| A5 | 3.7/3.9 = 0.949 | 5/5 = 1.000 | 8/9 = 0.889 | 24/32 = 0.750 |

**Perhitungan Nilai SAW:**
- A1: (0.974×0.3) + (0.400×0.3) + (0.889×0.25) + (0.960×0.15) = 0.802
- A2: (0.897×0.3) + (0.800×0.3) + (0.778×0.25) + (0.857×0.15) = 0.833
- A3: (1.000×0.3) + (0.200×0.3) + (1.000×0.25) + (1.000×0.15) = 0.710
- A4: (0.923×0.3) + (0.600×0.3) + (0.667×0.25) + (0.800×0.15) = 0.755
- A5: (0.949×0.3) + (1.000×0.3) + (0.889×0.25) + (0.750×0.15) = 0.912

**Ranking SAW:** A5 > A2 > A1 > A4 > A3

### 3.4 Perhitungan dengan Metode MAUT

**Normalisasi MAUT:**
- C1, C2, C3 (Benefit): U(x) = (x - min) / (max - min)
- C4 (Cost): U(x) = (max - x) / (max - min)

**Tabel 11: Normalisasi MAUT**
| Kandidat | C1 | C2 | C3 | C4 |
|----------|----|----|----|----|
| A1 | (3.8-3.5)/(3.9-3.5) = 0.750 | (2-1)/(5-1) = 0.250 | (8-6)/(9-6) = 0.667 | (32-25)/(32-24) = 0.875 |
| A2 | (3.5-3.5)/(3.9-3.5) = 0.000 | (4-1)/(5-1) = 0.750 | (7-6)/(9-6) = 0.333 | (32-28)/(32-24) = 0.500 |
| A3 | (3.9-3.5)/(3.9-3.5) = 1.000 | (1-1)/(5-1) = 0.000 | (9-6)/(9-6) = 1.000 | (32-24)/(32-24) = 1.000 |
| A4 | (3.6-3.5)/(3.9-3.5) = 0.250 | (3-1)/(5-1) = 0.500 | (6-6)/(9-6) = 0.000 | (32-30)/(32-24) = 0.250 |
| A5 | (3.7-3.5)/(3.9-3.5) = 0.500 | (5-1)/(5-1) = 1.000 | (8-6)/(9-6) = 0.667 | (32-32)/(32-24) = 0.000 |

**Perhitungan Nilai MAUT:**
- A1: (0.750×0.3) + (0.250×0.3) + (0.667×0.25) + (0.875×0.15) = 0.621
- A2: (0.000×0.3) + (0.750×0.3) + (0.333×0.25) + (0.500×0.15) = 0.358
- A3: (1.000×0.3) + (0.000×0.3) + (1.000×0.25) + (1.000×0.15) = 0.700
- A4: (0.250×0.3) + (0.500×0.3) + (0.000×0.25) + (0.250×0.15) = 0.263
- A5: (0.500×0.3) + (1.000×0.3) + (0.667×0.25) + (0.000×0.15) = 0.617

**Ranking MAUT:** A3 > A1 > A5 > A2 > A4

### 3.5 Perhitungan dengan Metode Naive Bayes

**Data Training:** A1, A2, A3, A5 (Diterima)
**Data Test:** A4 (Doni)

**Probabilitas Prior:**
P(Diterima) = 4/5 = 0.8
P(Ditolak) = 1/5 = 0.2

**Probabilitas Likelihood untuk "Diterima":**
- P(IPK=3.6|Diterima) = 0 (tidak ada dalam training)
- P(Pengalaman=3|Diterima) = 0 (tidak ada dalam training)
- P(Skill=6|Diterima) = 0 (tidak ada dalam training)
- P(Usia=30|Diterima) = 0 (tidak ada dalam training)

**Penanganan Zero Probability dengan Laplace Smoothing:**
P(X|C) = (count(X,C) + 1) / (count(C) + n)

**Probabilitas Likelihood (dengan smoothing):**
- P(IPK=3.6|Diterima) = (0 + 1) / (4 + 4) = 0.125
- P(Pengalaman=3|Diterima) = (0 + 1) / (4 + 4) = 0.125
- P(Skill=6|Diterima) = (0 + 1) / (4 + 4) = 0.125
- P(Usia=30|Diterima) = (0 + 1) / (4 + 4) = 0.125

**Probabilitas Posterior:**
P(Diterima|A4) ∝ 0.8 × 0.125 × 0.125 × 0.125 × 0.125 = 0.000244
P(Ditolak|A4) ∝ 0.2 × 1 × 1 × 1 × 1 = 0.2

**Normalisasi:**
Total = 0.000244 + 0.2 = 0.200244
P(Diterima|A4) = 0.000244 / 0.200244 = 0.0012
P(Ditolak|A4) = 0.2 / 0.200244 = 0.9988

**Prediksi Naive Bayes:** A4 (Doni) DITOLAK (sesuai data historis)

### 3.6 Perbandingan Hasil

**Tabel 12: Perbandingan Hasil Ketiga Metode**
| Kandidat | SAW | MAUT | Naive Bayes | Status Aktual |
|----------|-----|------|-------------|---------------|
| A1 (Ali) | 3 | 2 | Diterima | Diterima |
| A2 (Budi) | 2 | 4 | Diterima | Diterima |
| A3 (Cici) | 5 | 1 | Diterima | Diterima |
| A4 (Doni) | 4 | 5 | Ditolak | Ditolak |
| A5 (Eka) | 1 | 3 | Diterima | Diterima |

**Analisis:**
- SAW memilih A5 (Eka) sebagai kandidat terbaik
- MAUT memilih A3 (Cici) sebagai kandidat terbaik
- Naive Bayes berhasil memprediksi dengan akurasi 100% untuk data test
- Ketiga metode memberikan hasil yang konsisten dengan status aktual
- Perbedaan ranking disebabkan oleh pendekatan yang berbeda dalam penilaian

## 4. RINGKASAN BAB

Bab ini telah membahas tiga metode utama dalam Sistem Pendukung Keputusan: Simple Additive Weighting (SAW), Multi Attribute Utility Theory (MAUT), dan Naive Bayes. Ketiga metode ini menawarkan pendekatan yang berbeda dalam menyelesaikan masalah keputusan multi-kriteria.

**SAW** merupakan metode yang paling sederhana dan intuitif, menggunakan pendekatan penjumlahan terbobot untuk menghasilkan ranking alternatif. Metode ini cocok untuk masalah keputusan yang relatif sederhana dan memerlukan solusi cepat.

**MAUT** menawarkan pendekatan yang lebih canggih dengan konsep utilitas theory, memungkinkan evaluasi yang lebih mendalam terhadap trade-off antar kriteria. Metode ini memberikan hasil yang lebih stabil dan objektif.

**Naive Bayes** menggunakan pendekatan probabilistik berbasis Teorema Bayes, sangat berguna untuk prediksi berdasarkan data historis. Metode ini dapat menangani ketidakpastian dan belajar otomatis dari data.

Pemilihan metode yang tepat sangat tergantung pada karakteristik masalah, jenis data yang tersedia, dan tujuan pengambilan keputusan. Studi kasus terpadu menunjukkan bahwa ketiga metode dapat memberikan hasil yang konsisten meskipun dengan pendekatan yang berbeda.

Pemahaman yang mendalam tentang berbagai metode SPK memungkinkan pengambil keputusan untuk memilih pendekatan yang paling sesuai dengan kebutuhan spesifik mereka, sehingga menghasilkan keputusan yang lebih baik dan dapat dipertanggungjawabkan.

## 5. LATIHAN/TUGAS MAHASISWA

### 5.1 Soal Latihan Teori

1. Jelaskan perbedaan konsep dasar antara metode SAW, MAUT, dan Naive Bayes!
2. Mengapa normalisasi data diperlukan dalam metode SAW dan MAUT? Jelaskan dengan contoh!
3. Apa yang dimaksud dengan asumsi "naive" dalam Naive Bayes? Bagaimana pengaruhnya terhadap hasil klasifikasi?
4. Bandingkan kelebihan dan kekurangan metode deterministik (SAW, MAUT) dengan metode probabilistik (Naive Bayes)!
5. Dalam situasi apa metode SAW lebih cocok digunakan dibandingkan MAUT? Berikan contoh kasus!
6. Jelaskan konsep benefit dan cost dalam metode SAW! Bagaimana pengaruhnya terhadap rumus normalisasi?
7. Apa yang dimaksud dengan likelihood, prior, dan posterior dalam Teorema Bayes?
8. Bagaimana cara menangani masalah zero probability dalam Naive Bayes?
9. Jelaskan perbedaan antara pembobotan subyektif (SAW, MAUT) dengan pembobotan otomatis (Naive Bayes)!
10. Dalam konteks bisnis, metode mana yang paling cocok untuk prediksi churn pelanggan? Jelaskan alasan Anda!

### 5.2 Mini Project

**Judul: Sistem Pendukung Keputusan Pemilihan Laptop Mahasiswa**

**Deskripsi:**
Buatlah sistem pendukung keputusan sederhana untuk membantu mahasiswa memilih laptop yang sesuai dengan kebutuhan dan anggaran mereka menggunakan salah satu metode yang telah dipelajari (SAW, MAUT, atau Naive Bayes).

**Data:**
- 5 alternatif laptop dengan spesifikasi berbeda
- 4 kriteria: Harga (cost), RAM (benefit), Processor (benefit), Storage (benefit)
- Bobot kriteria sesuai preferensi pribadi

**Tugas:**
1. Tentukan metode yang akan digunakan dan jelaskan alasan pemilihannya
2. Kumpulkan data spesifikasi laptop dari toko online atau situs review
3. Tentukan bobot kriteria berdasarkan prioritas kebutuhan
4. Lakukan perhitungan manual sesuai langkah-langkah metode yang dipilih
5. Presentasikan hasil dalam bentuk:
   - Tabel data awal
   - Tabel normalisasi (jika diperlukan)
   - Tabel perhitungan akhir
   - Ranking alternatif
   - Rekomendasi laptop terbaik
6. Analisis hasil dan berikan justifikasi atas rekomendasi yang diberikan

**Format Pengumpulan:**
- Laporan dalam format PDF (maksimal 5 halaman)
- Sertakan file spreadsheet (Excel/Google Sheets) untuk perhitungan
- Presentasi 5 menit (jika diminta)

**Kriteria Penilaian:**
- Kelengkapan data dan perhitungan (40%)
- Ketepatan penggunaan metode (30%)
- Analisis dan justifikasi hasil (20%)
- Kreativitas dan presentasi (10%)

**Deadline:** 2 minggu dari tanggal penugasan
