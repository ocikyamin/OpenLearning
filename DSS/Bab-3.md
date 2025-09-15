

# BAB 3: PEMODELAN DAN ANALISIS SISTEM PENDUKUNG KEPUTUSAN (SPK)

## 3.1 Pendahuluan

Pengambilan keputusan merupakan inti dari setiap aktivitas manajerial. Dalam lingkungan bisnis yang semakin kompleks dan kompetitif, para pengambil keputusan dihadapkan pada berbagai pilihan yang harus dipilih secara optimal. Namun, seringkali keputusan yang diambil hanya berdasarkan pada intuisi atau pengalaman pribadi tanpa didukung oleh analisis yang sistematis. Hal ini dapat menyebabkan keputusan yang kurang tepat dan berdampak pada kinerja organisasi.

Di sinilah peran penting dari pemodelan dalam pengambilan keputusan. Pemodelan memungkinkan pengambil keputusan untuk memahami masalah secara lebih mendalam, mengidentifikasi berbagai alternatif solusi, serta mengevaluasi dampak dari setiap alternatif sebelum keputusan final diambil. Dengan menggunakan model, proses pengambilan keputusan menjadi lebih terstruktur, objektif, dan dapat dipertanggungjawabkan.

Dalam konteks Sistem Pendukung Keputusan (SPK), pemodelan menjadi komponen kritis yang menghubungkan data dengan keputusan. Model berfungsi sebagai representasi abstrak dari masalah dunia nyata yang memungkinkan analisis dan eksperimen tanpa harus menghadapi risiko langsung dari implementasi di lapangan. Melalui pemodelan, para pengambil keputusan dapat menjelajahi berbagai skenario "what-if" (bagaimana-jika) untuk memahami konsekuensi dari setiap pilihan sebelum mengimplementasikannya.

Bab ini akan membahas secara komprehensif tentang pemodelan dan analisis dalam SPK, mulai dari definisi model, jenis-jenis model, komponen utama dalam pemodelan keputusan, proses analisis model, hingga hubungan antara model, data, dan pengguna. Pembahasan akan dilengkapi dengan contoh kasus konkret untuk memudahkan pemahaman mahasiswa.

## 3.2 Uraian Materi

### 3.2.1 Definisi Model dalam Konteks SPK

Dalam konteks Sistem Pendukung Keputusan (SPK), model dapat didefinisikan sebagai representasi sederhana dari masalah atau situasi dunia nyata yang dirancang untuk memahami, menganalisis, dan memprediksi perilaku sistem. Model berfungsi sebagai jembatan antara masalah kompleks dengan solusi yang dapat diimplementasikan.

Model dalam SPK dapat diklasifikasikan berdasarkan pendekatan yang digunakan dalam membangunnya. Beberapa jenis model yang umum digunakan dalam SPK antara lain:

#### a. Model Matematis

Model matematis (mathematical models) adalah model yang menggunakan notasi matematika untuk menggambarkan hubungan antar variabel dalam masalah keputusan. Model ini seringkali berupa persamaan, pertidaksamaan, atau fungsi yang menghubungkan input dengan output. Contoh model matematis yang umum digunakan dalam SPK adalah:

- **Model Linear Programming**: Digunakan untuk memaksimalkan atau meminimalkan fungsi tujuan dengan kendala tertentu. Contoh: memaksimalkan keuntungan dengan kendala sumber daya terbatas.
  
  Contoh formulasi:
  ```
  Maksimalkan Z = 3x₁ + 5x₂
  Dengan kendala:
  2x₁ + x₂ ≤ 100
  x₁ + 3x₂ ≤ 90
  x₁, x₂ ≥ 0
  ```

- **Model Nonlinear Programming**: Mirip dengan linear programming, tetapi fungsi tujuan atau kendalanya bersifat nonlinear.

- **Model Dinamis**: Model yang mempertimbangkan perubahan sistem sepanjang waktu, seperti model pertumbuhan populasi atau model penyebaran epidemi.

#### b. Model Statistik

Model statistik (statistical models) adalah model yang menggunakan pendekatan statistik untuk menganalisis data dan memprediksi hasil. Model ini sangat berguna ketika terdapat ketidakpastian atau variabilitas dalam data. Contoh model statistik yang umum digunakan dalam SPK antara lain:

- **Model Regresi**: Digunakan untuk memahami hubungan antara variabel dependen dan independen. Contoh: memprediksi penjualan berdasarkan biaya iklan dan harga produk.
  
  Contoh formulasi regresi linear sederhana:
  ```
  Y = β₀ + β₁X + ε
  ```
  Dimana Y adalah variabel dependen, X adalah variabel independen, β₀ adalah intercept, β₁ adalah koefisien regresi, dan ε adalah error term.

- **Model Time Series**: Digunakan untuk memprediksi nilai di masa depan berdasarkan data historis. Contoh: memprediksi permintaan produk untuk periode mendatang.

- **Model Probabilistik**: Model yang mempertimbangkan probabilitas terjadinya suatu kejadian. Contoh: analisis risiko dengan menggunakan distribusi probabilitas.

#### c. Model Simulasi

Model simulasi (simulation models) adalah model yang meniru perilaku sistem sepanjang waktu untuk memahami bagaimana sistem beroperasi dan merespons perubahan. Simulasi sangat berguna ketika masalah terlalu kompleks untuk diselesaikan secara analitis. Contoh model simulasi yang umum digunakan dalam SPK antara lain:

- **Simulasi Diskrit**: Simulasi yang memodelkan perubahan sistem pada titik waktu tertentu. Contoh: simulasi antrian di bank atau rumah sakit.

- **Simulasi Kontinu**: Simulasi yang memodelkan perubahan sistem secara terus-menerus. Contoh: simulasi perubahan suhu dalam ruangan.

- **Simulasi Monte Carlo**: Simulasi yang menggunakan sampling acak untuk memperkirakan hasil dari proses yang tidak dapat diprediksi secara deterministik. Contoh: simulasi proyeksi keuangan dengan mempertimbangkan berbagai skenario.

#### d. Model Kualitatif

Model kualitatif (qualitative models) adalah model yang tidak menggunakan angka atau persamaan matematika, tetapi lebih mengandalkan deskripsi verbal, diagram, atau representasi grafis. Model ini sering digunakan ketika masalah sulit dikuantifikasi atau ketika data numerik tidak tersedia. Contoh model kualitatif yang umum digunakan dalam SPK antara lain:

- **Model Diagram Alur (Flowchart)**: Digunakan untuk menggambarkan urutan proses atau keputusan dalam suatu sistem.

- **Model Pohon Keputusan (Decision Tree)**: Digunakan untuk memvisualisasikan berbagai alternatif keputusan dan konsekuensinya.

- **Model Diagram Sebab-Akibat (Cause-Effect Diagram)**: Digunakan untuk mengidentifikasi penyebab potensial dari suatu masalah.

### 3.2.2 Jenis-jenis Model

Berdasarkan sifat dan cara penyelesaiannya, model dalam SPK dapat diklasifikasikan menjadi tiga jenis utama: deterministik, probabilistik, dan heuristik.

#### a. Model Deterministik

Model deterministik (deterministic models) adalah model yang mengasumsikan bahwa semua variabel dan parameter dalam sistem dapat diketahui dengan pasti dan tidak mengandung unsur ketidakpastian. Dalam model ini, input yang sama akan selalu menghasilkan output yang sama. Model ini cocok untuk masalah yang dapat diukur dengan pasti dan tidak melibatkan risiko atau ketidakpastian.

Ciri-ciri model deterministik:
- Semua parameter diketahui dengan pasti
- Tidak ada unsur acak atau probabilistik
- Hubungan antar variabel bersifat pasti
- Solusi dapat dihitung secara langsung

Contoh model deterministik:
- **Model Linear Programming**: Untuk menentukan kombinasi produk yang optimal dengan memaksimalkan keuntungan, dengan asumsi semua parameter (biaya, permintaan, kapasitas) diketahui pasti.
- **Model Jaringan Kerja (Network Models)**: Untuk menentukan rute terpendek dalam distribusi produk, dengan asumsi jarak dan waktu tempuh antar lokasi diketahui pasti.
- **Model Persediaan Deterministik**: Untuk menentukan jumlah pesanan optimal dengan asumsi permintaan dan waktu pengiriman diketahui pasti.

Keunggulan model deterministik:
- Sederhana dan mudah dipahami
- Solusi dapat dihitung secara eksak
- Membutuhkan data yang relatif sedikit

Keterbatasan model deterministik:
- Tidak dapat mengakomodasi ketidakpastian
- Kurang realistis untuk banyak masalah bisnis yang kompleks
- Solusi mungkin tidak robust terhadap perubahan parameter

#### b. Model Probabilistik

Model probabilistik (probabilistic models) atau model stokastik adalah model yang secara eksplisit mempertimbangkan ketidakpastian dan risiko dalam sistem. Dalam model ini, beberapa variabel atau parameter dinyatakan dalam bentuk distribusi probabilitas, bukan nilai tunggal yang pasti. Model ini cocok untuk masalah yang melibatkan ketidakpastian, seperti permintaan produk yang fluktuatif, risiko investasi, atau waktu pelayanan yang bervariasi.

Ciri-ciri model probabilistik:
- Beberapa parameter dinyatakan dalam bentuk distribusi probabilitas
- Mengandung unsur acak atau ketidakpastian
- Hubungan antar variabel bersifat probabilistik
- Solusi seringkali berupa distribusi probabilitas atau nilai harapan

Contoh model probabilistik:
- **Model Antrian (Queuing Models)**: Untuk menganalisis sistem antrian dengan mempertimbangkan kedatangan dan pelayanan yang bersifat acak.
- **Model Persediaan Probabilistik**: Untuk menentukan tingkat persediaan optimal dengan mempertimbangkan permintaan yang tidak pasti.
- **Model Pohon Keputusan dengan Probabilitas**: Untuk mengevaluasi berbagai alternatif keputusan dengan mempertimbangkan probabilitas terjadinya berbagai skenario.
- **Model Simulasi Monte Carlo**: Untuk mengevaluasi kinerja sistem dengan mensimulasikan berbagai skenario acak.

Keunggulan model probabilistik:
- Dapat mengakomodasi ketidakpastian dan risiko
- Lebih realistis untuk banyak masalah bisnis
- Dapat memberikan distribusi hasil, bukan hanya nilai tunggal

Keterbatasan model probabilistik:
- Lebih kompleks dan sulit dipahami
- Membutuhkan lebih banyak data, termasuk data historis untuk memperkirakan distribusi probabilitas
- Solusi seringkali membutuhkan komputasi yang intensif

#### c. Model Heuristik

Model heuristik (heuristic models) adalah model yang menggunakan aturan praktis atau pendekatan intuitif untuk menemukan solusi yang baik (meskipun tidak selalu optimal) untuk masalah yang kompleks. Heuristik sering digunakan ketika masalah terlalu sulit untuk diselesaikan secara optimal dalam waktu yang wajar, atau ketika model yang lebih presisi tidak tersedia atau terlalu mahal untuk dikembangkan.

Ciri-ciri model heuristik:
- Menggunakan aturan praktis atau pendekatan intuitif
- Tidak menjamin solusi optimal
- Dikembangkan berdasarkan pengalaman atau pengetahuan ahli
- Cepat dan mudah diimplementasikan

Contoh model heuristik:
- **Aturan Penjualan Musiman**: "Tingkatkan produksi 20% menjelang hari raya" berdasarkan pengalaman historis.
- **Aturan Pemesanan Persediaan**: "Pesan kembali barang ketika sisa 20% dari tingkat persediaan maksimum".
- **Aturan Penjadwalan**: "Prioritaskan pekerjaan dengan waktu tenggat terdekat".
- **Aturan Lokasi Fasilitas**: "Pilih lokasi yang terdekat dengan pelanggan terbanyak".

Keunggulan model heuristik:
- Cepat dan mudah diimplementasikan
- Membutuhkan data yang relatif sedikit
- Diterapkan untuk masalah yang sangat kompleks
- Mudah dipahami oleh pengambil keputusan

Keterbatasan model heuristik:
- Tidak menjamin solusi optimal
- Kualitas solusi sulit dievaluasi
- Mungkin tidak robust untuk semua kondisi
- Dapat bersifat subyektif tergantung pada pengembangnya

### 3.2.3 Komponen Utama dalam Pemodelan Keputusan

Dalam membangun model untuk Sistem Pendukung Keputusan, terdapat beberapa komponen utama yang perlu dipertimbangkan. Pemahaman yang baik tentang komponen-komponen ini akan membantu dalam merancang model yang efektif dan relevan dengan masalah yang dihadapi. Komponen utama dalam pemodelan keputusan meliputi: variabel keputusan, variabel tak terkendali, kriteria, dan alternatif.

#### a. Variabel Keputusan

Variabel keputusan (decision variables) adalah variabel yang dapat dikendalikan atau diatur oleh pengambil keputusan. Variabel ini mewakili pilihan atau tindakan yang tersedia bagi pengambil keputusan untuk mempengaruhi hasil akhir. Dalam model matematis, variabel keputusan seringkali dilambangkan dengan simbol seperti x, y, atau z.

Contoh variabel keputusan:
- **Dalam masalah produksi**: Jumlah produk A dan B yang harus diproduksi.
- **Dalam masalah lokasi**: Lokasi fasilitas baru yang akan dipilih.
- **Dalam masalah investasi**: Jumlah dana yang diinvestasikan pada setiap opsi investasi.
- **Dalam masalah penjadwalan**: Urutan pengerjaan tugas atau penugasan sumber daya.

Variabel keputusan dapat bersifat:
- **Diskrit**: Variabel yang hanya dapat mengambil nilai tertentu, biasanya bilangan bulat. Contoh: jumlah mesin yang dibeli (tidak mungkin membeli 0,5 mesin).
- **Kontinu**: Variabel yang dapat mengambil nilai apa pun dalam suatu rentang. Contoh: jumlah bahan baku yang digunakan (dapat berupa pecahan).

Dalam menentukan variabel keputusan, penting untuk memastikan bahwa variabel tersebut benar-benar dapat dikendalikan oleh pengambil keputusan dan relevan dengan masalah yang dihadapi.

#### b. Variabel Tak Terkendali

Variabel tak terkendali (uncontrollable variables) atau parameter adalah variabel yang tidak dapat dikendalikan oleh pengambil keputusan, tetapi mempengaruhi hasil keputusan. Variabel ini seringkali berasal dari lingkungan eksternal dan dapat bersifat pasti (deterministik) atau tidak pasti (probabilistik).

Contoh variabel tak terkendali:
- **Dalam masalah produksi**: Harga bahan baku, permintaan pasar, kapasitas mesin.
- **Dalam masalah lokasi**: Biaya tanah, tarif pajak, regulasi pemerintah.
- **Dalam masalah investasi**: Tingkat inflasi, suku bunga, kondisi ekonomi.
- **Dalam masalah penjadwalan**: Waktu penyelesaian tugas, ketersediaan sumber daya.

Variabel tak terkendali dapat diklasifikasikan menjadi:
- **Deterministik**: Variabel yang nilainya dapat diketahui dengan pasti. Contoh: tarif pajak yang ditetapkan pemerintah.
- **Probabilistik**: Variabel yang nilainya tidak pasti dan hanya dapat diperkirakan. Contoh: permintaan produk di masa depan.

Dalam pemodelan, penting untuk mengidentifikasi variabel tak terkendali dan menentukan bagaimana variabel ini akan dimasukkan ke dalam model, apakah sebagai nilai tunggal (jika deterministik) atau sebagai distribusi probabilitas (jika probabilistik).

#### c. Kriteria

Kriteria (criteria) adalah ukuran atau standar yang digunakan untuk mengevaluasi seberapa baik setiap alternatif keputusan memenuhi tujuan yang diinginkan. Kriteria membantu pengambil keputusan untuk membandingkan berbagai alternatif dan memilih yang terbaik.

Dalam konteks SPK, kriteria dapat dibagi menjadi beberapa jenis:

1. **Berdasarkan arah preferensi**:
   - **Kriteria Benefit**: Kriteria di mana semakin besar nilainya, semakin baik. Contoh: keuntungan, pangsa pasar, kepuasan pelanggan.
   - **Kriteria Cost**: Kriteria di mana semakin kecil nilainya, semakin baik. Contoh: biaya, waktu, risiko.

2. **Berdasakan sifat pengukuran**:
   - **Kriteria Kuantitatif**: Kriteria yang dapat diukur secara numerik. Contoh: keuntungan dalam rupiah, waktu dalam jam.
   - **Kriteria Kualitatif**: Kriteria yang sulit diukur secara numerik. Contoh: citra perusahaan, kepuasan karyawan.

3. **Berdasarkan struktur**:
   - **Kriteria Tunggal**: Hanya ada satu kriteria yang dipertimbangkan. Contoh: memaksimalkan keuntungan.
   - **Kriteria Ganda (Multi-Kriteria)**: Terdapat beberapa kriteria yang dipertimbangkan. Contoh: memaksimalkan keuntungan sekaligus meminimalkan risiko.

Dalam menentukan kriteria, penting untuk memastikan bahwa kriteria tersebut relevan dengan tujuan keputusan, dapat diukur, dan saling bebas (tidak tumpang tindih).

#### d. Alternatif

Alternatif (alternatives) adalah pilihan atau opsi yang tersedia bagi pengambil keputusan. Setiap alternatif mewakili solusi potensial untuk masalah yang dihadapi. Dalam model keputusan, alternatif dievaluasi berdasarkan kriteria yang telah ditetapkan untuk menentukan alternatif terbaik.

Sumber alternatif dapat berasal dari:
- **Pengalaman masa lalu**: Solusi yang telah berhasil diterapkan sebelumnya.
- **Penelitian dan analisis**: Solusi yang dihasilkan melalui analisis sistematis.
- **Kreativitas dan inovasi**: Solusi baru yang belum pernah dicoba sebelumnya.
- **Praktik terbaik (best practices)**: Solusi yang telah terbukti berhasil di organisasi lain.

Dalam menentukan alternatif, penting untuk memastikan bahwa:
- Alternatif-replikatif: Setiap alternatif harus berbeda dan saling menutupi.
- Alternatif feasible: Setiap alternatif harus dapat diimplementasikan dalam batasan yang ada.
- Alternatif lengkap: Himpunan alternatif harus mencakup semua kemungkinan solusi yang relevan.

Contoh alternatif:
- **Dalam masalah produksi**: Meningkatkan kapasitas mesin, outsourcing produksi, atau mengurangi variasi produk.
- **Dalam masalah lokasi**: Membangun fasilitas di lokasi A, B, atau C.
- **Dalam masalah investasi**: Menginvestasikan dana di saham, obligasi, atau properti.

Hubungan antar komponen pemodelan keputusan dapat digambarkan sebagai berikut: Pengambil keputusan memilih nilai untuk variabel keputusan (dengan mempertimbangkan kendala dari variabel tak terkendali) untuk mencapai alternatif terbaik berdasarkan kriteria yang telah ditetapkan.

### 3.2.4 Proses Analisis Model

Proses analisis model merupakan tahap kritis dalam pengembangan Sistem Pendukung Keputusan (SPK) yang melibatkan serangkaian kegiatan sistematis untuk mengubah masalah nyata menjadi representasi matematis atau logis, menyelesaikannya, dan menafsirkan hasilnya. Proses ini memungkinkan pengambil keputusan untuk memahami masalah secara mendalam, mengevaluasi berbagai alternatif, dan memilih solusi terbaik. Secara umum, proses analisis model terdiri dari empat tahap utama: formulasi masalah, representasi model, solusi, dan interpretasi hasil.

#### a. Formulasi Masalah

Formulasi masalah (problem formulation) adalah tahap awal dalam proses analisis model yang bertujuan untuk memahami dan mendefinisikan masalah dengan jelas. Tahap ini sangat penting karena kesalahan dalam formulasi masalah akan mengakibatkan model yang tidak relevan atau solusi yang tidak tepat.

Langkah-langkah dalam formulasi masalah:

1. **Identifikasi Masalah**
   - Mengenali adanya masalah atau kesenjangan antara kondisi saat ini dengan kondisi yang diinginkan.
   - Contoh: Perusahaan mengalami penurunan keuntungan dalam beberapa kuartal terakhir.

2. **Analisis Akar Masalah**
   - Menyelidiki penyebab utama dari masalah yang diidentifikasi.
   - Contoh: Penurunan keuntungan disebabkan oleh biaya produksi yang tinggi dan penurunan penjualan.

3. **Penentuan Tujuan**
   - Menetapkan tujuan yang ingin dicapai melalui pengambilan keputusan.
   - Contoh: Meningkatkan keuntungan sebesar 15% dalam satu tahun ke depan.

4. **Identifikasi Batasan**
   - Menentukan batasan atau kendala yang mempengaruhi solusi yang mungkin.
   - Contoh: Kapasitas produksi terbatas, anggaran terbatas, regulasi pemerintah.

5. **Definisi Lingkup Masalah**
   - Menentukan batasan masalah yang akan dimodelkan untuk menghindari kompleksitas yang tidak perlu.
   - Contoh: Fokus pada optimasi produk yang memberikan kontribusi terbesar terhadap keuntungan.

Dalam formulasi masalah, penting untuk melibatkan berbagai pihak terkait (stakeholders) untuk memastikan bahwa masalah dipahami dengan benar dan semua aspek relevan telah dipertimbangkan.

#### b. Representasi Model

Setelah masalah diformulasikan dengan jelas, langkah berikutnya adalah membuat representasi model (model representation) yang merupakan abstraksi dari masalah nyata. Representasi model dapat berupa model matematis, statistik, simulasi, atau kualitatif, tergantung pada sifat masalah dan data yang tersedia.

Langkah-langkah dalam representasi model:

1. **Pemilihan Jenis Model**
   - Memilih jenis model yang sesuai dengan masalah, seperti model matematis, statistik, simulasi, atau kualitatif.
   - Contoh: Untuk masalah optimasi produksi, model linear programming dapat dipilih.

2. **Identifikasi Variabel dan Parameter**
   - Menentukan variabel keputusan, variabel tak terkendali, dan parameter yang relevan.
   - Contoh: Variabel keputusan = jumlah produk A dan B yang diproduksi; Parameter = biaya produksi per unit, harga jual per unit.

3. **Pembentukan Struktur Model**
   - Membangun hubungan antar variabel dan parameter dalam bentuk persamaan, pertidaksamaan, atau aturan.
   - Contoh: Fungsi tujuan = Maksimalkan keuntungan = (Harga A - Biaya A) × Jumlah A + (Harga B - Biaya B) × Jumlah B.

4. **Validasi Struktur Model**
   - Memeriksa apakah struktur model telah mewakili masalah dengan benar.
   - Contoh: Memastikan bahwa semua kendala produksi telah dimasukkan ke dalam model.

5. **Pengumpulan Data**
   - Mengumpulkan data yang diperlukan untuk mengisi parameter dalam model.
   - Contoh: Mengumpulkan data biaya produksi, harga jual, dan kapasitas mesin.

Dalam representasi model, penting untuk menyeimbangkan antara kesederhanaan dan kelengkapan model. Model yang terlalu sederhana mungkin tidak mewakili masalah dengan akurat, sementara model yang terlalu kompleks akan sulit dipecahkan dan diinterpretasikan.

#### c. Solusi

Setelah model direpresentasikan dengan baik, langkah berikutnya adalah mencari solusi (solution) dari model. Solusi dapat berupa nilai optimal dari variabel keputusan, urutan alternatif berdasarkan preferensi, atau rekomendasi keputusan lainnya, tergantung pada jenis model yang digunakan.

Metode penyelesaian model berdasarkan jenis model:

1. **Model Matematis**
   - **Metode Analitis**: Menggunakan pendekatan matematis untuk menemukan solusi eksak. Contoh: Metode simpleks untuk linear programming.
   - **Metode Numerik**: Menggunakan algoritma iteratif untuk mendekati solusi. Contoh: Algoritma gradient descent untuk optimasi nonlinear.
   - **Software Khusus**: Menggunakan perangkat lunak optimasi seperti LINDO, CPLEX, atau solver dalam Excel.

2. **Model Statistik**
   - **Metode Estimasi**: Menggunakan teknik seperti ordinary least squares (OLS) untuk regresi.
   - **Metode Inferensi**: Menggunakan uji hipotesis untuk menarik kesimpulan tentang populasi.
   - **Software Statistik**: Menggunakan perangkat lunak seperti SPSS, R, atau Python dengan library statistik.

3. **Model Simulasi**
   - **Simulasi Diskrit**: Menggunakan software seperti Arena, Simul8, atau AnyLogic.
   - **Simulasi Kontinu**: Menggunakan software seperti MATLAB atau Simulink.
   - **Simulasi Monte Carlo**: Menggunakan software seperti @RISK atau Crystal Ball.

4. **Model Kualitatif**
   - **Metode Kualitatif**: Menggunakan pendekatan seperti analisis konten atau interpretatif.
   - **Software Kualitatif**: Menggunakan perangkat lunak seperti NVivo atau ATLAS.ti.

Dalam mencari solusi, penting untuk mempertimbangkan:
- **Kualitas Solusi**: Apakah solusi yang diperoleh optimal atau cukup baik (good enough)?
- **Waktu Komputasi**: Berapa lama waktu yang dibutuhkan untuk mendapatkan solusi?
- **Ketersediaan Sumber Daya**: Apakah sumber daya (perangkat keras, perangkat lunak, keahlian) yang diperlukan tersedia?
- **Sensitivitas Solusi**: Seberapa robust solusi terhadap perubahan parameter?

#### d. Interpretasi Hasil

Tahap terakhir dalam proses analisis model adalah interpretasi hasil (result interpretation), yang bertujuan untuk menerjemahkan solusi model menjadi rekomendasi keputusan yang dapat dimengerti dan diterapkan oleh pengambil keputusan. Tahap ini sangat penting karena solusi model yang tidak diinterpretasikan dengan baik tidak akan memberikan nilai tambah bagi organisasi.

Langkah-langkah dalam interpretasi hasil:

1. **Analisis Solusi**
   - Memahami makna solusi dalam konteks masalah asli.
   - Contoh: Solusi model menunjukkan bahwa perusahaan harus memproduksi 100 unit produk A dan 150 unit produk B untuk memaksimalkan keuntungan.

2. **Analisis Sensitivitas**
   - Mengevaluasi bagaimana perubahan parameter mempengaruhi solusi.
   - Contoh: Bagaimana perubahan harga bahan baku mempengaruhi kombinasi produk optimal?

3. **Validasi Hasil**
   - Memeriksa apakah hasil model masuk akal dan konsisten dengan pengetahuan existing.
   - Contoh: Membandingkan hasil model dengan data historis atau opini ahli.

4. **Formulasi Rekomendasi**
   - Menerjemahkan solusi model menjadi rekomendasi keputusan yang spesifik dan dapat ditindaklanjuti.
   - Contoh: Disarankan untuk meningkatkan produksi produk B sebesar 20% dan mengurangi produksi produk A sebesar 10%.

5. **Komunikasi Hasil**
   - Menyajikan hasil dan rekomendasi kepada pengambil keputusan dengan cara yang mudah dipahami.
   - Contoh: Menggunakan visualisasi seperti grafik, tabel, atau dashboard untuk menyajikan hasil.

Dalam interpretasi hasil, penting untuk:
- **Menghindari Jargon Teknis**: Menyajikan hasil dengan bahasa yang mudah dipahami oleh non-teknisi.
- **Menyajikan Informasi Relevan**: Fokus pada informasi yang penting bagi pengambil keputusan.
- **Menyertakan Batasan Model**: Menjelaskan keterbatasan model dan asumsi yang digunakan.
- **Menyediakan Konteks**: Menempatkan hasil dalam konteks bisnis yang lebih luas.

Proses analisis model bersifat iteratif, artinya seringkali perlu kembali ke tahap sebelumnya untuk memperbaiki model berdasarkan hasil interpretasi. Siklus ini berlanjut hingga diperoleh model yang memadai dan solusi yang dapat diterima.

### 3.2.5 Hubungan Antara Model, Data, dan Pengguna

Dalam Sistem Pendukung Keputusan (SPK), terdapat hubungan yang saling terkait antara tiga komponen utama: model, data, dan pengguna. Memahami hubungan ini sangat penting untuk mengembangkan SPK yang efektif dan efisien. Ketiga komponen ini saling mempengaruhi dan menentukan kualitas keputusan yang dihasilkan.

#### a. Peran Model dalam SPK

Model merupakan inti dari SPK yang berfungsi sebagai representasi abstrak dari masalah dunia nyata. Dalam SPK, model berperan untuk:

1. **Mengintegrasikan Pengetahuan**
   - Model mengintegrasikan pengetahuan tentang masalah, termasuk hubungan antar variabel, kendala, dan tujuan.
   - Contoh: Model persediaan mengintegrasikan pengetahuan tentang permintaan, biaya pemesanan, dan biaya penyimpanan.

2. **Mengolah Data Menjadi Informasi**
   - Model mengubah data mentah menjadi informasi yang berguna untuk pengambilan keputusan.
   - Contoh: Model regresi mengubah data penjualan historis menjadi prediksi penjualan masa depan.

3. **Menghasilkan Rekomendasi Keputusan**
   - Model menghasilkan solusi atau rekomendasi berdasarkan data yang dimasukkan.
   - Contoh: Model optimasi menghasilkan rekomendasi kombinasi produk yang optimal.

4. **Mendukung Eksperimen dan Analisis "What-If"**
   - Model memungkinkan pengguna untuk melakukan eksperimen dengan berbagai skenario tanpa risiko nyata.
   - Contoh: Model keuangan memungkinkan analisis dampak perubahan suku bunga terhadap laba perusahaan.

Kualitas model sangat menentukan kualitas keputusan yang dihasilkan. Model yang baik harus akurat, valid, reliable, dan relevan dengan masalah yang dihadapi.

#### b. Peran Data dalam SPK

Data merupakan bahan baku bagi SPK yang digunakan oleh model untuk menghasilkan informasi dan rekomendasi. Tanpa data yang berkualitas, model sebaik apapun tidak akan menghasilkan keputusan yang baik. Dalam SPK, data berperan untuk:

1. **Mengisi Parameter Model**
   - Data digunakan untuk mengisi parameter dalam model, seperti koefisien dalam persamaan matematika.
   - Contoh: Data biaya produksi per unit digunakan dalam model optimasi produksi.

2. **Mengestimasi Hubungan Antar Variabel**
   - Data digunakan untuk mengestimasi hubungan antar variabel dalam model statistik.
   - Contoh: Data historis penjualan dan biaya iklan digunakan untuk mengestimasi pengaruh iklan terhadap penjualan.

3. **Mengvalidasi Model**
   - Data digunakan untuk memvalidasi apakah model telah merepresentasikan masalah dengan baik.
   - Contoh: Data aktual dibandingkan dengan hasil prediksi model untuk menguji akurasi model.

4. **Memperbarui Model**
   - Data baru digunakan untuk memperbarui model agar tetap relevan dengan kondisi terkini.
   - Contoh: Data permintaan terbaru digunakan untuk memperbarui model peramalan.

Kualitas data sangat mempengaruhi kinerja SPK. Data yang baik harus akurat, lengkap, konsisten, tepat waktu, dan relevan dengan masalah yang dihadapi. Prinsip "garbage in, garbage out" sangat berlaku dalam SPK, artinya data yang buruk akan menghasilkan keputusan yang buruk.

#### c. Peran Pengguna dalam SPK

Pengguna (decision maker) merupakan komponen kritis dalam SPK yang berinteraksi dengan model dan data untuk menghasilkan keputusan. Dalam SPK, pengguna berperan untuk:

1. **Menentukan Masalah dan Tujuan**
   - Pengguna membantu mendefinisikan masalah dan menetapkan tujuan yang ingin dicapai.
   - Contoh: Manajer produksi mendefinisikan masalah inefisiensi produksi dan menetapkan tujuan mengurangi biaya produksi.

2. **Menyediakan Pengetahuan Domain**
   - Pengguna menyediakan pengetahuan tentang domain masalah yang tidak tersedia dalam data.
   - Contoh: Manajer pemasaran memberikan pengetahuan tentang perilaku konsumen yang tidak tercermin dalam data penjualan.

3. **Memvalidasi Asumsi dan Hasil**
   - Pengguna memvalidasi asumsi yang digunakan dalam model dan hasil yang dihasilkan.
   - Contoh: Manajer keuangan memvalidasi asumsi tentang pertumbuhan ekonomi dalam model investasi.

4. **Mengambil Keputusan Akhir**
   - Pengguna menggunakan rekomendasi dari SPK sebagai masukan untuk mengambil keputusan akhir.
   - Contoh: Direktur operasi menggunakan rekomendasi lokasi fasilitas dari SPK untuk memutuskan lokasi yang akan dipilih.

Kualitas interaksi pengguna dengan SPK sangat mempengaruhi keefektifan sistem. Pengguna yang baik harus memiliki pengetahuan yang memadai tentang domain masalah, pemahaman tentang keterbatasan model, dan kemampuan untuk menafsirkan hasil dengan benar.

#### d. Hubungan Timbal Balik Antara Model, Data, dan Pengguna

Ketiga komponen dalam SPK (model, data, dan pengguna) memiliki hubungan timbal balik yang saling mempengaruhi:

1. **Pengguna → Model**
   - Pengguna mendefinisikan masalah dan tujuan yang menjadi dasar pengembangan model.
   - Pengguna menyediakan pengetahuan domain yang memperkaya model.
   - Pengguna memvalidasi model untuk memastikan relevansinya dengan masalah nyata.

2. **Pengguna → Data**
   - Pengguna menentukan data apa yang relevan untuk masalah yang dihadapi.
   - Pengguna menafsirkan data dan memberikan konteks yang tidak tersedia dalam data mentah.
   - Pengguna mengevaluasi kualitas data dan menentukan apakah data cukup baik untuk digunakan.

3. **Model → Data**
   - Model menentukan jenis data apa yang dibutuhkan.
   - Model mengolah data menjadi informasi yang berguna.
   - Model dapat mengidentifikasi kesenjangan data yang perlu diisi.

4. **Data → Model**
   - Data digunakan untuk mengestimasi parameter dalam model.
   - Data digunakan untuk mengvalidasi dan menguji model.
   - Data yang baru dapat memicu perubahan atau pembaruan model.

5. **Model → Pengguna**
   - Model menghasilkan rekomendasi keputusan untuk pengguna.
   - Model mendukung analisis "what-if" yang membantu pengguna memahami konsekuensi dari berbagai alternatif.
   - Model menyediakan wawasan tentang masalah yang mungkin tidak disadari oleh pengguna.

6. **Data → Pengguna**
   - Data menyediakan bukti objektif yang mendukung atau menentang intuisi pengguna.
   - Data membantu pengguna memahami masalah secara lebih mendalam.
   - Data memungkinkan pengguna untuk melacak kinerja dan mengukur dampak keputusan.

Hubungan timbal balik ini menunjukkan bahwa SPK yang efektif membutuhkan integrasi yang baik antara model yang kuat, data yang berkualitas, dan pengguna yang terlibat. Ketiga komponen ini harus saling melengkapi dan mendukung untuk menghasilkan keputusan yang optimal.

#### e. Tantangan dalam Mengintegrasikan Model, Data, dan Pengguna

Meskipun hubungan antara model, data, dan pengguna sangat penting, terdapat beberapa tantangan dalam mengintegrasikan ketiga komponen ini:

1. **Tantangan Teknis**
   - Kompleksitas model yang tinggi mempersulit pengguna non-teknis untuk memahaminya.
   - Volume data yang besar mempersulit pengolahan dan analisis.
   - Keterbatasan perangkat keras dan perangkat lunak untuk mengembangkan dan menjalankan model yang kompleks.

2. **Tantangan Data**
   - Kualitas data yang buruk (tidak akurat, tidak lengkap, tidak konsisten).
   - Ketersediaan data yang terbatas untuk masalah yang dihadapi.
   - Integrasi data dari berbagai sumber yang memiliki format dan standar berbeda.

3. **Tantangan Pengguna**
   - Resistensi terhadap penggunaan SPK karena lebih percaya pada intuisi atau pengalaman pribadi.
   - Kurangnya pemahaman tentang kemampuan dan keterbatasan SPK.
   - Kesulitan dalam menafsirkan hasil model dan menerapkannya dalam keputusan nyata.

4. **Tantangan Organisasional**
   - Kurangnya dukungan manajemen untuk pengembangan dan implementasi SPK.
   - Silo organisasi yang mempersulit berbagi data dan pengetahuan.
   - Perubahan organisasi yang mempengaruhi relevansi model dan data.

Untuk mengatasi tantangan ini, diperlukan pendekatan holistik yang mempertimbangkan aspek teknis, data, manusia, dan organisasi dalam pengembangan dan implementasi SPK.

## 3.3 Contoh Kasus Pemodelan

Untuk memperdalam pemahaman tentang pemodelan dalam Sistem Pendukung Keputusan (SPK), berikut disajikan beberapa contoh kasus pemodelan yang sering dijumpai dalam dunia bisnis. Setiap contoh kasus akan mencakup formulasi masalah, pengembangan model, solusi, dan interpretasi hasil.

### 3.3.1 Kasus 1: Model Pemilihan Lokasi

#### a. Formulasi Masalah

Sebuah perusahaan retail berencana untuk membuka toko baru di kota X. Perusahaan telah mengidentifikasi 5 lokasi potensial (A, B, C, D, E) dan perlu memilih lokasi yang paling optimal. Tujuan pemilihan lokasi adalah untuk memaksimalkan potensi keuntungan dengan mempertimbangkan beberapa faktor, seperti biaya sewa, potensi pasar, aksesibilitas, dan tingkat persaingan.

#### b. Pengembangan Model

Untuk memecahkan masalah ini, dapat digunakan model Multi-Criteria Decision Making (MCDM) dengan metode Analytic Hierarchy Process (AHP). Model ini akan membantu perusahaan untuk mengevaluasi dan membandingkan kelima lokasi berdasarkan beberapa kriteria yang telah ditentukan.

**Langkah-langkah pengembangan model:**

1. **Identifikasi Kriteria**
   Berdasarkan tujuan pemilihan lokasi, ditetapkan 4 kriteria utama:
   - Biaya sewa (C1): Semakin rendah biaya sewa, semakin baik (kriteria cost).
   - Potensi pasar (C2): Semakin tinggi potensi pasar, semakin baik (kriteria benefit).
   - Aksesibilitas (C3): Semakin tinggi aksesibilitas, semakin baik (kriteria benefit).
   - Tingkat persaingan (C4): Semakin rendah tingkat persaingan, semakin baik (kriteria cost).

2. **Penentuan Bobot Kriteria**
   Pengambil keputusan (manajer perusahaan) memberikan bobot pentingnya setiap kriteria dengan menggunakan perbandingan berpasangan. Berikut adalah matriks perbandingan berpasangan dan bobot akhir setiap kriteria:

   | Kriteria | C1 | C2 | C3 | C4 | Bobot |
   |----------|----|----|----|----|-------|
   | C1       | 1  | 1/3| 1/2| 2  | 0.18  |
   | C2       | 3  | 1  | 2  | 4  | 0.49  |
   | C3       | 2  | 1/2| 1  | 3  | 0.26  |
   | C4       | 1/2| 1/4| 1/3| 1  | 0.07  |

   Dari matriks di atas, dapat dilihat bahwa kriteria Potensi Pasar (C2) memiliki bobot tertinggi (0.49), diikuti oleh Aksesibilitas (C3) dengan bobot 0.26, Biaya Sewa (C1) dengan bobot 0.18, dan Tingkat Persaingan (C4) dengan bobot 0.07.

3. **Evaluasi Alternatif Lokasi**
   Setiap lokasi dievaluasi berdasarkan keempat kriteria dengan skala 1-10, di mana 10 adalah nilai terbaik. Berikut adalah matriks evaluasi alternatif:

   | Lokasi | C1 | C2 | C3 | C4 |
   |--------|----|----|----|----|
   | A      | 7  | 8  | 6  | 5  |
   | B      | 5  | 9  | 8  | 4  |
   | C      | 8  | 6  | 7  | 7  |
   | D      | 6  | 7  | 9  | 6  |
   | E      | 9  | 5  | 5  | 8  |

4. **Normalisasi Matriks Evaluasi**
   Matriks evaluasi dinormalisasi dengan membagi setiap nilai dengan jumlah nilai pada kolom yang bersangkutan:

   | Lokasi | C1 | C2 | C3 | C4 |
   |--------|----|----|----|----|
   | A      | 0.21| 0.22| 0.17| 0.16|
   | B      | 0.15| 0.25| 0.23| 0.13|
   | C      | 0.24| 0.17| 0.20| 0.23|
   | D      | 0.18| 0.19| 0.26| 0.19|
   | E      | 0.26| 0.14| 0.14| 0.26|

5. **Perhitungan Nilai Preferensi**
   Nilai preferensi setiap alternatif dihitung dengan mengalikan matriks normalisasi dengan bobot kriteria:

   | Lokasi | Nilai Preferensi | Peringkat |
   |--------|-----------------|-----------|
   | A      | 0.20            | 3         |
   | B      | 0.24            | 1         |
   | C      | 0.20            | 3         |
   | D      | 0.21            | 2         |
   | E      | 0.17            | 5         |

#### c. Solusi

Berdasarkan perhitungan di atas, diperoleh hasil bahwa lokasi B memiliki nilai preferensi tertinggi (0.24), diikuti oleh lokasi D (0.21), lokasi A dan C (0.20), dan lokasi E (0.17). Oleh karena itu, lokasi B direkomendasikan sebagai lokasi yang paling optimal untuk pembukaan toko baru.

#### d. Interpretasi Hasil

Hasil analisis menunjukkan bahwa lokasi B adalah pilihan terbaik untuk pembukaan toko baru. Hal ini terutama disebabkan oleh lokasi B memiliki nilai tertinggi pada kriteria Potensi Pasar (C2) yang memiliki bobot terbesar (0.49). Meskipun lokasi B memiliki biaya sewa yang relatif tinggi (nilai 5 dari skala 1-10), namun hal ini diimbangi oleh potensi pasar yang sangat baik dan aksesibilitas yang tinggi.

Untuk memastikan keputusan ini robust, dapat dilakukan analisis sensitivitas dengan mengubah bobot kriteria. Misalnya, jika bobot kriteria Biaya Sewa (C1) ditingkatkan, apakah lokasi B tetap menjadi pilihan terbaik? Analisis sensitivitas akan membantu pengambil keputusan untuk memahami seberapa stabil rekomendasi ini terhadap perubahan preferensi.

### 3.3.2 Kasus 2: Model Pemilihan Supplier

#### a. Formulasi Masalah

Sebuah perusahaan manufaktur perlu memilih supplier untuk komponen penting dalam produknya. Perusahaan telah mengidentifikasi 4 supplier potensial (S1, S2, S3, S4) dan perlu memilih supplier yang paling sesuai dengan kebutuhan perusahaan. Tujuan pemilihan supplier adalah untuk memastikan pasokan komponen yang berkualitas, tepat waktu, dan dengan biaya yang optimal.

#### b. Pengembangan Model

Untuk memecahkan masalah ini, dapat digunakan model Multi-Attribute Decision Making (MADM) dengan metode Technique for Order of Preference by Similarity to Ideal Solution (TOPSIS). Model ini akan membantu perusahaan untuk mengevaluasi dan membandingkan keempat supplier berdasarkan beberapa kriteria yang telah ditentukan.

**Langkah-langkah pengembangan model:**

1. **Identifikasi Kriteria**
   Berdasarkan tujuan pemilihan supplier, ditetapkan 5 kriteria utama:
   - Kualitas produk (C1): Semakin tinggi kualitas, semakin baik (kriteria benefit).
   - Harga (C2): Semakin rendah harga, semakin baik (kriteria cost).
   - Ketepatan waktu pengiriman (C3): Semakin tinggi ketepatan waktu, semakin baik (kriteria benefit).
   - Kapasitas produksi (C4): Semakin tinggi kapasitas, semakin baik (kriteria benefit).
   - Pelayanan purna jual (C5): Semakin baik pelayanan, semakin baik (kriteria benefit).

2. **Penentuan Bobot Kriteria**
   Pengambil keputusan (manajer procurement) memberikan bobot pentingnya setiap kriteria:
   - Kualitas produk (C1): 0.30
   - Harga (C2): 0.25
   - Ketepatan waktu pengiriman (C3): 0.20
   - Kapasitas produksi (C4): 0.15
   - Pelayanan purna jual (C5): 0.10

3. **Evaluasi Alternatif Supplier**
   Setiap supplier dievaluasi berdasarkan kelima kriteria. Berikut adalah matriks evaluasi alternatif:

   | Supplier | C1 | C2 | C3 | C4 | C5 |
   |----------|----|----|----|----|----|
   | S1       | 8  | 7  | 6  | 7  | 8  |
   | S2       | 7  | 9  | 8  | 6  | 7  |
   | S3       | 9  | 5  | 7  | 8  | 6  |
   | S4       | 6  | 8  | 9  | 7  | 9  |

4. **Normalisasi Matriks Evaluasi**
   Matriks evaluasi dinormalisasi dengan menggunakan rumus:
   ```
   r_ij = x_ij / √(∑x_ij²)
   ```
   Dimana x_ij adalah nilai alternatif i pada kriteria j.

   Hasil normalisasi:

   | Supplier | C1    | C2    | C3    | C4    | C5    |
   |----------|-------|-------|-------|-------|-------|
   | S1       | 0.54  | 0.46  | 0.40  | 0.47  | 0.53  |
   | S2       | 0.47  | 0.60  | 0.53  | 0.40  | 0.47  |
   | S3       | 0.60  | 0.33  | 0.47  | 0.53  | 0.40  |
   | S4       | 0.40  | 0.53  | 0.60  | 0.47  | 0.60  |

5. **Pembobotan Matriks Normalisasi**
   Matriks normalisasi dibobotkan dengan mengalikan setiap nilai dengan bobot kriteria:

   | Supplier | C1    | C2    | C3    | C4    | C5    |
   |----------|-------|-------|-------|-------|-------|
   | S1       | 0.16  | 0.12  | 0.08  | 0.07  | 0.05  |
   | S2       | 0.14  | 0.15  | 0.11  | 0.06  | 0.05  |
   | S3       | 0.18  | 0.08  | 0.09  | 0.08  | 0.04  |
   | S4       | 0.12  | 0.13  | 0.12  | 0.07  | 0.06  |

6. **Menentukan Solusi Ideal Positif dan Negatif**
   Solusi ideal positif (A+) adalah nilai terbaik untuk setiap kriteria, sedangkan solusi ideal negatif (A-) adalah nilai terburuk untuk setiap kriteria:

   | Kriteria | A+   | A-   |
   |----------|------|------|
   | C1       | 0.18 | 0.12 |
   | C2       | 0.08 | 0.15 |
   | C3       | 0.12 | 0.08 |
   | C4       | 0.08 | 0.06 |
   | C5       | 0.06 | 0.04 |

7. **Menghitung Jarak ke Solusi Ideal**
   Jarak setiap alternatif ke solusi ideal positif (D+) dan solusi ideal negatif (D-) dihitung dengan menggunakan rumus Euclidean distance:

   | Supplier | D+   | D-   |
   |----------|------|------|
   | S1       | 0.07 | 0.07 |
   | S2       | 0.09 | 0.05 |
   | S3       | 0.07 | 0.09 |
   | S4       | 0.05 | 0.09 |

8. **Menghitung Nilai Preferensi**
   Nilai preferensi setiap alternatif dihitung dengan rumus:
   ```
   V_i = D- / (D+ + D-)
   ```

   | Supplier | Nilai Preferensi | Peringkat |
   |----------|-----------------|-----------|
   | S1       | 0.50            | 2         |
   | S2       | 0.36            | 4         |
   | S3       | 0.56            | 1         |
   | S4       | 0.64            | 3         |

#### c. Solusi

Berdasarkan perhitungan di atas, diperoleh hasil bahwa supplier S3 memiliki nilai preferensi tertinggi (0.56), diikuti oleh supplier S1 (0.50), supplier S4 (0.64), dan supplier S2 (0.36). Oleh karena itu, supplier S3 direkomendasikan sebagai supplier yang paling sesuai untuk kebutuhan perusahaan.

#### d. Interpretasi Hasil

Hasil analisis menunjukkan bahwa supplier S3 adalah pilihan terbaik untuk memasok komponen penting. Hal ini terutama disebabkan oleh supplier S3 memiliki nilai tertinggi pada kriteria Kualitas Produk (C1) yang memiliki bobot terbesar (0.30). Meskipun supplier S3 memiliki harga yang relatif tinggi (nilai 5 dari skala 1-10), namun hal ini diimbangi oleh kualitas produk yang sangat baik dan kapasitas produksi yang tinggi.

Untuk memastikan keputusan ini robust, dapat dilakukan analisis sensitivitas dengan mengubah bobot kriteria. Misalnya, jika bobot kriteria Harga (C2) ditingkatkan, apakah supplier S3 tetap menjadi pilihan terbaik? Analisis sensitivitas akan membantu pengambil keputusan untuk memahami seberapa stabil rekomendasi ini terhadap perubahan preferensi.

### 3.3.3 Kasus 3: Model Analisis Risiko Investasi

#### a. Formulasi Masalah

Seorang investor ingin mengevaluasi risiko dari tiga opsi investasi (I1, I2, I3) yang berbeda. Investor perlu memahami profil risiko dan return dari setiap opsi investasi untuk membuat keputusan yang sesuai dengan tujuan investasinya. Tujuan analisis ini adalah untuk menentukan opsi investasi yang memberikan return optimal dengan risiko yang dapat diterima.

#### b. Pengembangan Model

Untuk memecahkan masalah ini, dapat digunakan model analisis risiko dengan pendekatan Value at Risk (VaR) dan simulasi Monte Carlo. Model ini akan membantu investor untuk mengestimasi potensi kerugian maksimum yang mungkin terjadi pada setiap opsi investasi dengan tingkat kepercayaan tertentu.

**Langkah-langkah pengembangan model:**

1. **Identifikasi Variabel dan Parameter**
   - Variabel input: Return historis setiap opsi investasi.
   - Parameter: Tingkat kepercayaan (confidence level) yang diinginkan, misalnya 95%.
   - Variabel output: Value at Risk (VaR) dan Expected Return.

2. **Pengumpulan Data**
   Mengumpulkan data return historis (misalnya 5 tahun terakhir) untuk setiap opsi investasi:

   | Tahun | I1   | I2   | I3   |
   |-------|------|------|------|
   | 1     | 12%  | 8%   | 15%  |
   | 2     | 10%  | 9%   | 5%   |
   | 3     | 8%   | 10%  | 20%  |
   | 4     | 15%  | 7%   | -10% |
   | 5     | 7%   | 11%  | 25%  |

3. **Estimasi Parameter Distribusi**
   Mengestimasi parameter distribusi probabilitas untuk setiap opsi investasi berdasarkan data historis. Dalam contoh ini, diasumsikan return mengikuti distribusi normal:

   | Opsi Investasi | Mean Return | Standar Deviasi |
   |---------------|-------------|-----------------|
   | I1            | 10.4%       | 3.0%            |
   | I2            | 9.0%        | 1.6%            |
   | I3            | 11.0%       | 13.7%           |

4. **Simulasi Monte Carlo**
   Melakukan simulasi Monte Carlo dengan menghasilkan 10.000 skenario return untuk setiap opsi investasi berdasarkan distribusi normal yang telah diestimasi.

5. **Perhitungan Value at Risk (VaR)**
   Menghitung VaR pada tingkat kepercayaan 95% untuk setiap opsi investasi. VaR 95% adalah nilai kerugian maksimum yang mungkin terjadi dengan tingkat kepercayaan 95%.

   | Opsi Investasi | Expected Return | VaR 95% |
   |---------------|-----------------|---------|
   | I1            | 10.4%           | 5.4%    |
   | I2            | 9.0%            | 3.4%    |
   | I3            | 11.0%           | 21.5%   |

6. **Perhitungan Risk-Adjusted Return**
   Menghitung risk-adjusted return dengan menggunakan rasio Sharpe, yang mengukur return per unit risiko:

   ```
   Sharpe Ratio = (Expected Return - Risk-Free Rate) / Standard Deviation
   ```

   Dengan asumsi risk-free rate sebesar 5%:

   | Opsi Investasi | Sharpe Ratio |
   |---------------|--------------|
   | I1            | 1.80         |
   | I2            | 2.50         |
   | I3            | 0.44         |

#### c. Solusi

Berdasarkan perhitungan di atas, diperoleh hasil bahwa:
- Opsi investasi I3 memiliki expected return tertinggi (11.0%), tetapi juga memiliki risiko tertinggi (VaR 95% = 21.5%) dan Sharpe Ratio terendah (0.44).
- Opsi investasi I1 memiliki expected return sedang (10.4%) dengan risiko sedang (VaR 95% = 5.4%) dan Sharpe Ratio yang baik (1.80).
- Opsi investasi I2 memiliki expected return terendah (9.0%), tetapi juga memiliki risiko terendah (VaR 95% = 3.4%) dan Sharpe Ratio tertinggi (2.50).

#### d. Interpretasi Hasil

Hasil analisis menunjukkan bahwa tidak ada satu opsi investasi yang jelas unggul di semua aspek. Pilihan investasi yang optimal akan tergantung pada toleransi risiko investor:

1. **Untuk investor yang konservatif (risk-averse)**: Opsi I2 adalah pilihan terbaik karena memiliki risiko terendah (VaR 95% = 3.4%) dan Sharpe Ratio tertinggi (2.50), meskipun expected return-nya paling rendah.

2. **Untuk investor yang moderat**: Opsi I1 adalah pilihan yang seimbang antara return dan risiko, dengan expected return yang baik (10.4%) dan risiko yang dapat diterima (VaR 95% = 5.4%).

3. **Untuk investor yang agresif (risk-seeking)**: Opsi I3 mungkin menarik karena menawarkan expected return tertinggi (11.0%), tetapi investor harus siap menghadapi risiko yang sangat tinggi (VaR 95% = 21.5%).

Untuk memperkaya analisis, investor juga dapat mempertimbangkan diversifikasi dengan mengalokasikan dana ke ketiga opsi investasi dengan proporsi yang berbeda. Selain itu, investor dapat melakukan analisis skenario (scenario analysis) dengan mengubah asumsi tentang distribusi return atau mempertimbangkan faktor eksternal yang mungkin mempengaruhi kinerja investasi.

## 3.4 Ringkasan Bab

Bab 3 telah membahas secara komprehensif tentang pemodelan dan analisis dalam Sistem Pendukung Keputusan (SPK). Berikut adalah poin-poin penting yang telah dibahas:

1. **Pentingnya Pemodelan dalam Pengambilan Keputusan**
   - Pemodelan memungkinkan pengambil keputusan untuk memahami masalah secara lebih mendalam, mengidentifikasi berbagai alternatif solusi, serta mengevaluasi dampak dari setiap alternatif sebelum keputusan final diambil.
   - Dalam konteks SPK, pemodelan menjadi komponen kritis yang menghubungkan data dengan keputusan.

2. **Definisi Model dalam Konteks SPK**
   - Model adalah representasi sederhana dari masalah atau situasi dunia nyata yang dirancang untuk memahami, menganalisis, dan memprediksi perilaku sistem.
   - Jenis-jenis model yang umum digunakan dalam SPK antara lain: model matematis, model statistik, model simulasi, dan model kualitatif.

3. **Jenis-jenis Model Berdasarkan Sifat dan Cara Penyelesaian**
   - **Model Deterministik**: Model yang mengasumsikan bahwa semua variabel dan parameter dalam sistem dapat diketahui dengan pasti dan tidak mengandung unsur ketidakpastian.
   - **Model Probabilistik**: Model yang secara eksplisit mempertimbangkan ketidakpastian dan risiko dalam sistem.
   - **Model Heuristik**: Model yang menggunakan aturan praktis atau pendekatan intuitif untuk menemukan solusi yang baik (meskipun tidak selalu optimal) untuk masalah yang kompleks.

4. **Komponen Utama dalam Pemodelan Keputusan**
   - **Variabel Keputusan**: Variabel yang dapat dikendalikan atau diatur oleh pengambil keputusan.
   - **Variabel Tak Terkendali**: Variabel yang tidak dapat dikendalikan oleh pengambil keputusan, tetapi mempengaruhi hasil keputusan.
   - **Kriteria**: Ukuran atau standar yang digunakan untuk mengevaluasi seberapa baik setiap alternatif keputusan memenuhi tujuan yang diinginkan.
   - **Alternatif**: Pilihan atau opsi yang tersedia bagi pengambil keputusan.

5. **Proses Analisis Model**
   - **Formulasi Masalah**: Tahap awal dalam proses analisis model yang bertujuan untuk memahami dan mendefinisikan masalah dengan jelas.
   - **Representasi Model**: Tahap membuat representasi model yang merupakan abstraksi dari masalah nyata.
   - **Solusi**: Tahap mencari solusi dari model, yang dapat berupa nilai optimal dari variabel keputusan, urutan alternatif berdasarkan preferensi, atau rekomendasi keputusan lainnya.
   - **Interpretasi Hasil**: Tahap menerjemahkan solusi model menjadi rekomendasi keputusan yang dapat dimengerti dan diterapkan oleh pengambil keputusan.

6. **Hubungan Antara Model, Data, dan Pengguna**
   - Ketiga komponen ini (model, data, dan pengguna) memiliki hubungan timbal balik yang saling mempengaruhi dalam SPK.
   - Model mengintegrasikan pengetahuan dan mengolah data menjadi informasi berguna untuk pengambilan keputusan.
   - Data merupakan bahan baku bagi SPK yang digunakan oleh model untuk menghasilkan informasi dan rekomendasi.
   - Pengguna berperan dalam menentukan masalah dan tujuan, menyediakan pengetahuan domain, memvalidasi asumsi dan hasil, serta mengambil keputusan akhir.

7. **Contoh Kasus Pemodelan**
   - **Model Pemilihan Lokasi**: Menggunakan metode AHP untuk memilih lokasi optimal untuk pembukaan toko baru.
   - **Model Pemilihan Supplier**: Menggunakan metode TOPSIS untuk memilih supplier yang paling sesuai dengan kebutuhan perusahaan.
   - **Model Analisis Risiko Investasi**: Menggunakan pendekatan VaR dan simulasi Monte Carlo untuk mengevaluasi risiko dari berbagai opsi investasi.

Dengan pemahaman yang baik tentang pemodelan dan analisis dalam SPK, diharapkan mahasiswa dapat mengembangkan dan menerapkan model-model keputusan yang sesuai dengan masalah yang dihadapi dalam dunia nyata.

## 3.5 Latihan/Tugas Mahasiswa

Berikut adalah beberapa latihan dan tugas yang dapat diberikan kepada mahasiswa untuk menguji pemahaman mereka tentang pemodelan dan analisis dalam Sistem Pendukung Keputusan (SPK):

### Tugas 1: Identifikasi Komponen Pemodelan Keputusan

**Soal:**
Sebuah perusahaan ingin memutuskan apakah akan memproduksi sendiri komponen X atau membelinya dari supplier. Jika memproduksi sendiri, perusahaan perlu menginvestasikan pada mesin baru dan melatih karyawan. Jika membeli dari supplier, perusahaan tergantung pada ketersediaan dan kualitas dari supplier.

Identifikasi komponen-komponen berikut dalam masalah ini:
1. Variabel keputusan
2. Variabel tak terkendali
3. Kriteria yang relevan
4. Alternatif yang tersedia

**Petunjuk:**
- Jelaskan setiap komponen dengan jelas dan berikan contoh spesifik untuk kasus ini.
- Klasifikasikan kriteria berdasarkan arah preferensi (benefit atau cost).

### Tugas 2: Formulasi Model Matematis Sederhana

**Soal:**
Sebuah perusahaan memproduksi dua jenis produk, P1 dan P2. Setiap unit P1 memberikan keuntungan Rp 50.000, sedangkan setiap unit P2 memberikan keuntungan Rp 75.000. Proses produksi memerlukan dua sumber daya: mesin dan tenaga kerja. Setiap unit P1 memerlukan 2 jam mesin dan 3 jam tenaga kerja. Setiap unit P2 memerlukan 4 jam mesin dan 2 jam tenaga kerja. Kapasitas tersedia untuk mesin adalah 100 jam per minggu, sedangkan untuk tenaga kerja adalah 90 jam per minggu.

Formulasikan masalah ini sebagai model linear programming untuk memaksimalkan keuntungan!

**Petunjuk:**
- Tentukan variabel keputusan.
- Tuliskan fungsi tujuan.
- Tuliskan semua kendala yang relevan.
- Pastikan model telah lengkap dan siap untuk dipecahkan.

### Tugas 3: Analisis Model Pemilihan Lokasi

**Soal:**
Sebuah perusahaan ingin memilih lokasi untuk gudang baru di antara tiga lokasi kandidat (L1, L2, L3). Perusahaan telah menetapkan empat kriteria untuk evaluasi:
1. Biaya tanah (C1): Semakin rendah, semakin baik (bobot: 0.25)
2. Aksesibilitas (C2): Semakin tinggi, semakin baik (bobot: 0.35)
3. Potensi ekspansi (C3): Semakin tinggi, semakin baik (bobot: 0.20)
4. Ketersediaan tenaga kerja (C4): Semakin tinggi, semakin baik (bobot: 0.20)

Berikut adalah matriks evaluasi untuk ketiga lokasi (skala 1-10, di mana 10 adalah nilai terbaik):

| Lokasi | C1 | C2 | C3 | C4 |
|--------|----|----|----|----|
| L1     | 8  | 6  | 7  | 5  |
| L2     | 5  | 9  | 8  | 7  |
| L3     | 7  | 7  | 6  | 9  |

Gunakan metode Simple Additive Weighting (SAW) untuk menentukan lokasi terbaik!

**Petunjuk:**
- Normalisasi matriks evaluasi.
- Hitung nilai preferensi untuk setiap lokasi.
- Berikan rekomendasi lokasi terbaik beserta alasannya.

### Tugas 4: Analisis Sensitivitas Model

**Soal:**
Berdasarkan hasil Tugas 3, lakukan analisis sensitivitas dengan mengubah bobot kriteria sebagai berikut:
- Skenario 1: Bobot C1 dinaikkan menjadi 0.35, bobot C2 diturunkan menjadi 0.25.
- Skenario 2: Bobot C3 dinaikkan menjadi 0.30, bobot C4 diturunkan menjadi 0.10.

Hitung ulang nilai preferensi untuk setiap lokasi dalam kedua skenario tersebut dan analisis perubahan peringkat lokasi!

**Petunjuk:**
- Hitung nilai preferensi untuk setiap lokasi dalam setiap skenario.
- Bandingkan hasil dengan hasil asli (Tugas 3).
- Jelaskan bagaimana perubahan bobot mempengaruhi pilihan lokasi terbaik.
- Berikan kesimpulan tentang robustness dari keputusan.

### Tugas 5: Pengembangan Model Simulasi Sederhana

**Soal:**
Sebuah supermarket memiliki satu kasir yang melayani pelanggan. Berdasarkan data historis, diketahui bahwa:
- Kedatangan pelanggan mengikuti distribusi Poisson dengan rata-rata 10 pelanggan per jam.
- Waktu pelayanan mengikuti distribusi eksponensial dengan rata-rata 4 menit per pelanggan.

Kembangkan model simulasi sederhana untuk mengevaluasi kinerja sistem antrian ini dengan mengestimasi:
1. Rata-rata jumlah pelanggan dalam sistem (antrian + sedang dilayani)
2. Rata-rata waktu yang dihabiskan pelanggan dalam sistem
3. Probabilitas kasir dalam keadaan sibuk

**Petunjuk:**
- Gunakan pendekatan teori antrian (queuing theory) untuk menghitung metrik kinerja.
- Model ini dapat diklasifikasikan sebagai model M/M/1 (kedatangan Poisson, pelayanan eksponensial, 1 server).
- Rumus yang relevan:
  - λ = tingkat kedatangan rata-rata (pelanggan per satuan waktu)
  - μ = tingkat pelayanan rata-rata (pelanggan per satuan waktu)
  - ρ = λ/μ (utilitas sistem)
  - L = ρ/(1-ρ) (rata-rata jumlah pelanggan dalam sistem)
  - W = 1/(μ-λ) (rata-rata waktu dalam sistem)
  - P(sibuk) = ρ

### Tugas 6: Studi Kasus Pemodelan Keputusan Investasi

**Soal:**
Seorang investor ingin mengevaluasi dua opsi investasi:
- Investasi A: Saham perusahaan teknologi dengan expected return 15% dan standar deviasi 25%.
- Investasi B: Obligasi pemerintah dengan expected return 7% dan standar deviasi 5%.

Dengan asumsi risk-free rate sebesar 5%, hitung:
1. Sharpe Ratio untuk setiap opsi investasi.
2. Value at Risk (VaR) 95% untuk setiap opsi investasi (asumsikan return mengikuti distribusi normal).
3. Berikan rekomendasi investasi untuk investor dengan profil risiko yang berbeda:
   - Konservatif
   - Moderat
   - Agresif

**Petunjuk:**
- Sharpe Ratio = (Expected Return - Risk-Free Rate) / Standard Deviation
- VaR 95% = Expected Return - 1.645 × Standard Deviation (untuk distribusi normal)
- Jelaskan alasan rekomendasi untuk setiap profil risiko.

### Tugas 7: Pengembangan Model Heuristik

**Soal:**
Sebuah perusahaan distribusi memiliki 5 pelanggan yang harus dikunjungi oleh satu kendaraan dari depot. Koordinat lokasi depot dan pelanggan (dalam km) adalah sebagai berikut:
- Depot: (0, 0)
- Pelanggan 1: (5, 10)
- Pelanggan 2: (8, 15)
- Pelanggan 3: (10, 8)
- Pelanggan 4: (12, 12)
- Pelanggan 5: (15, 5)

Kembangkan model heuristik sederhana (misalnya: Nearest Neighbor) untuk menentukan rute terpendek yang mengunjungi semua pelanggan dan kembali ke depot!

**Petunjuk:**
- Hitung jarak Euclidean antar semua titik.
- Terapkan algoritma Nearest Neighbor:
  1. Mulai dari depot.
  2. Pergi ke pelanggan terdekat yang belum dikunjungi.
  3. Ulangi langkah 2 sampai semua pelanggan dikunjungi.
  4. Kembali ke depot.
- Hitung total jarak tempuh untuk rute yang dihasilkan.
- Bandingkan dengan solusi optimal (jika memungkinkan).

### Tugas 8: Analisis Model Probabilistik

**Soal:**
Sebuah perusahaan memproduksi produk musiman. Permintaan produk mengikuti distribusi normal dengan mean 1.000 unit dan standar deviasi 200 unit. Setiap unit yang terjual memberikan keuntungan Rp 50.000, sedangkan setiap unit yang tidak terjual akan menyebabkan kerugian Rp 20.000.

1. Tentukan jumlah produksi optimal yang memaksimalkan expected profit!
2. Hitung expected profit pada jumlah produksi optimal!
3. Berapa probabilitas terjadi stockout (kehabisan stok) pada jumlah produksi optimal?

**Petunjuk:**
- Expected profit = (Harga × Jual Terjual) - (Biaya × Jumlah Produksi) + (Nilai Sisa × Sisa Stok)
- Dimana:
  - Jual Terjual = min(Permintaan, Jumlah Produksi)
  - Sisa Stok = max(0, Jumlah Produksi - Permintaan)
- Jumlah produksi optimal (Q*) dapat dihitung dengan rumus:
  ```
  Q* = μ + z × σ
  ```
  Dimana z adalah nilai z dari distribusi normal standar yang memenuhi:
  ```
  Φ(z) = Cu / (Cu + Co)
  ```
  Dimana Cu = keuntungan per unit jika terjual, Co = kerugian per unit jika tidak terjual.
- Probabilitas stockout = 1 - Φ((Q* - μ) / σ)

### Tugas 9: Evaluasi Model Kualitatif

**Soal:**
Sebuah perusahaan sedang mempertimbangkan untuk mengadopsi sistem ERP (Enterprise Resource Planning) baru. Perusahaan telah mengidentifikasi beberapa faktor yang perlu dipertimbangkan dalam pengambilan keputusan:
1. Biaya implementasi
2. Waktu implementasi
3. Dampak pada efisiensi operasional
4. Kemudahan penggunaan
5. Dukungan vendor
6. Kesesuaian dengan proses bisnis yang ada

Kembangkan model kualitatif (misalnya: diagram alur keputusan atau pohon keputusan) untuk membantu perusahaan dalam mengevaluasi apakah akan mengadopsi sistem ERP baru tersebut!

**Petunjuk:**
- Identifikasi pertanyaan kunci yang perlu dijawab.
- Kembangkan diagram alur atau pohon keputusan yang menggambarkan proses pengambilan keputusan.
- Sertakan kriteria evaluasi untuk setiap titik keputusan.
- Berikan contoh bagaimana model ini dapat digunakan dalam pengambilan keputusan nyata.

### Tugas 10: Studi Kasus Terintegrasi

**Soal:**
Sebuah rumah sakit ingin meningkatkan kualitas pelayanannya dengan mengoptimalkan penjadwalan dokter. Saat ini, rumah sakit menghadapi beberapa masalah:
1. Waktu tunggu pasien yang terlalu lama.
2. Pemanfaatan ruang praktik dokter yang tidak optimal.
3. Kesenjangan antara jumlah pasien dengan kapasitas pelayanan.

Kembangkan konsep model Sistem Pendukung Keputusan (SPK) untuk membantu rumah sakit dalam mengoptimalkan penjadwalan dokter. Model ini harus mencakup:

1. Identifikasi variabel keputusan, variabel tak terkendali, kriteria, dan alternatif.
2. Pemilihan jenis model yang sesuai (deterministik, probabilistik, heuristik, atau kombinasi).
3. Pengembangan model konseptual (bisa berupa diagram alir, persamaan matematika, atau deskripsi verbal).
4. Metode analisis yang akan digunakan untuk mengevaluasi kinerja model.
5. Cara implementasi model dalam pengambilan keputusan nyata.

**Petunjuk:**
- Lakukan analisis masalah secara mendalam sebelum mengembangkan model.
- Pertimbangkan berbagai aspek, seperti: jenis poliklinik, jam operasional, jumlah dokter, preferensi pasien, dll.
- Model yang dikembangkan harus realistis dan dapat diimplementasikan.
- Jelaskan bagaimana model ini akan memberikan nilai tambah bagi rumah sakit.

