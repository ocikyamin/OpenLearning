
# BAB 4
# PENGEMBANGAN SISTEM PENDUKUNG KEPUTUSAN (SPK)

## 4.1 Pendahuluan

Pengembangan Sistem Pendukung Keputusan (SPK) merupakan proses yang sistematis dan terencana untuk menciptakan sistem yang mampu membantu manajer dan pengambil keputusan dalam memecahkan masalah semi-terstruktur dan tidak terstruktur. Pentingnya pengembangan SPK yang baik tidak dapat dipisahkan dari kebutuhan organisasi akan dukungan pengambilan keputusan yang cepat, akurat, dan relevan dengan kondisi dinamis yang dihadapi.

Pengembangan SPK memiliki keterkaitan erat dengan siklus hidup sistem informasi (System Development Life Cycle/SDLC) pada umumnya, namun dengan karakteristik khusus yang menyesuaikan dengan kebutuhan pendukungan keputusan. Siklus hidup pengembangan SPK mencakup tahapan perencanaan, analisis, desain, implementasi, hingga evaluasi dan pemeliharaan. Setiap tahapan ini dirancang untuk memastikan bahwa SPK yang dihasilkan benar-benar dapat memenuhi kebutuhan pengguna dan memberikan nilai tambah bagi organisasi.

Dalam konteks organisasi modern, SPK bukan lagi menjadi pilihan melainkan kebutuhan strategis. Kemampuan SPK dalam mengintegrasikan data, model analitis, dan pengetahuan ahli menjadikannya alat yang powerful untuk meningkatkan kualitas keputusan. Oleh karena itu, pemahaman tentang proses pengembangan SPK menjadi kompetensi penting bagi para profesional sistem informasi dan calon praktisi IT.

## 4.2 Uraian Materi

### 4.2.1 Siklus Hidup Pengembangan SPK

Siklus hidup pengembangan SPK mengikuti pola yang terstruktur namun fleksibel, yang terdiri dari lima tahapan utama:

#### a. Perencanaan (Planning)

Tahap perencanaan merupakan fondasi dari pengembangan SPK. Pada tahap ini, dilakukan identifikasi kebutuhan organisasi terhadap sistem pendukung keputusan, penentuan ruang lingkup proyek, analisis kelayakan (feasibility study), serta penyusunan jadwal dan anggaran. Perencanaan yang baik akan meminimalkan risiko kegagalan dan memastikan kesesuaian antara sistem yang akan dikembangkan dengan tujuan strategis organisasi.

Kegiatan utama pada tahap perencanaan meliputi:
- Identifikasi masalah keputusan yang akan didukung
- Analisis stakeholder dan pengguna sistem
- Penentuan sumber daya yang dibutuhkan
- Penyusunan rencana proyek yang komprehensif

#### b. Analisis (Analysis)

Tahap analisis berfokus pada pemahaman mendalam tentang kebutuhan pengguna dan karakteristik masalah keputusan yang akan diatasi. Pada tahap ini, analis sistem mengumpulkan informasi tentang proses pengambilan keputusan yang ada, data yang diperlukan, model analitis yang sesuai, serta kebutuhan antarmuka pengguna.

Output utama dari tahap analisis adalah dokumen spesifikasi kebutuhan yang meliputi:
- Kebutuhan fungsional (apa yang harus dilakukan sistem)
- Kebutuhan non-fungsional (kinerja, keamanan, dll.)
- Spesifikasi data dan model yang dibutuhkan
- Kriteria keberhasilan sistem

#### c. Desain (Design)

Tahap desain merupakan proses perancangan arsitektur dan komponen-komponen SPK berdasarkan spesifikasi kebutuhan yang telah ditetapkan. Desain SPK mencakup perancangan database, model base, knowledge base, serta antarmuka pengguna yang akan memudahkan interaksi antara sistem dengan pengambil keputusan.

Komponen desain yang perlu dipertimbangkan:
- Desain database dan struktur data
- Pemilihan dan desain model analitis
- Perancangan basis pengetahuan (jika diperlukan)
- Desain antarmuka pengguna yang intuitif
- Arsitektur sistem secara keseluruhan

#### d. Implementasi (Implementation)

Tahap implementasi adalah proses mewujudkan desain SPK menjadi sistem yang dapat dioperasikan. Kegiatan pada tahap ini meliputi pemrograman, pengujian, instalasi, dan pelatihan pengguna. Implementasi SPK seringkali menggunakan pendekatan prototyping untuk memastikan sistem sesuai dengan kebutuhan dan ekspektasi pengguna.

Aktivitas implementasi meliputi:
- Pengembangan komponen sistem
- Integrasi antar komponen
- Pengujian fungsional dan performansi
- Instalasi sistem
- Pelatihan pengguna dan dokumentasi

#### e. Evaluasi dan Pemeliharaan (Evaluation and Maintenance)

Setelah SPK diimplementasikan, tahap evaluasi dan pemeliharaan menjadi kritis untuk memastikan sistem terus berfungsi secara optimal dan relevan dengan kebutuhan organisasi yang terus berubah. Evaluasi dilakukan secara berkala untuk mengukur efektivitas sistem, sedangkan pemeliharaan mencakup perbaikan, peningkatan, dan adaptasi sistem.

Kegiatan evaluasi dan pemeliharaan:
- Monitoring kinerja sistem
- Pengumpulan feedback dari pengguna
- Analisis efektivitas sistem dalam mendukung keputusan
- Perbaikan bug dan peningkatan fitur
- Adaptasi sistem terhadap perubahan kebutuhan

### 4.2.2 Arsitektur SPK

Arsitektur Sistem Pendukung Keputusan menggambarkan struktur dan komponen-komponen utama yang membentuk sistem serta hubungan antar komponen tersebut. Arsitektur SPK yang baik dirancang untuk memfasilitasi integrasi data, model, dan pengetahuan dalam mendukung proses pengambilan keputusan. Secara umum, arsitektur SPK terdiri dari empat komponen utama:

#### a. Database (Basis Data)

Database merupakan komponen fundamental dalam SPK yang berfungsi sebagai penyimpan dan pengelola data yang diperlukan untuk proses pengambilan keputusan. Database dalam SPK tidak hanya menyimpan data operasional, tetapi juga data historis, data eksternal, dan data yang telah diolah untuk keperluan analisis.

Karakteristik database SPK:
- **Data Integration**: Kemampuan mengintegrasikan data dari berbagai sumber (internal dan eksternal)
- **Multi-dimensional**: Struktur data yang mendukung analisis multidimensi
- **Time-variant**: Kemampuan menyimpan data historis untuk analisis tren
- **Subject-oriented**: Pengorganisasian data berdasarkan subjek bisnis tertentu

Komponen pendukung database:
- **Database Management System (DBMS)**: Software untuk mengelola database
- **Data Warehouse**: Repositori data terintegrasi untuk analisis
- **Data Marts**: Subset data warehouse yang fokus pada area bisnis tertentu
- **Extraction, Transformation, Loading (ETL)**: Proses pengambilan, transformasi, dan pemuatan data

#### b. Model Base (Basis Model)

Model Base merupakan komponen SPK yang berisi kumpulan model analitis dan matematis yang digunakan untuk menganalisis data dan menghasilkan alternatif keputusan. Model base memungkinkan pengguna untuk melakukan simulasi, optimasi, dan prediksi berdasarkan data yang tersedia.

Jenis-jenis model dalam SPK:
- **Statistical Models**: Model statistik untuk analisis data (regresi, korelasi, dll.)
- **Optimization Models**: Model optimasi untuk mencari solusi terbaik (linear programming, integer programming)
- **Simulation Models**: Model simulasi untuk memprediksi perilaku sistem
- **Financial Models**: Model keuangan untuk analisis investasi dan keuangan
- **Predictive Models**: Model prediksi untuk peramalan

Komponen Model Base Management System (MBMS):
- **Model Directory**: Katalog model yang tersedia
- **Model Execution**: Engine untuk menjalankan model
- **Model Integration**: Fasilitas untuk mengintegrasikan beberapa model
- **Model Storage**: Penyimpanan model dan parameter

#### c. Knowledge Base (Basis Pengetahuan)

Knowledge Base adalah komponen SPK yang menyimpan pengetahuan ahli, aturan-aturan, dan heuristik yang digunakan untuk membimbing proses pengambilan keputusan. Knowledge base memungkinkan SPK tidak hanya mengolah data secara numerik, tetapi juga memberikan rekomendasi berdasarkan pengetahuan domain.

Komponen Knowledge Base:
- **Facts**: Fakta-fakta dasar tentang domain masalah
- **Rules**: Aturan-aturan inferensi untuk menarik kesimpulan
- **Heuristics**: Pengetahuan praktis dari para ahli
- **Procedures**: Prosedur untuk menyelesaikan masalah tertentu

Knowledge Base Management System (KBMS) menyediakan fasilitas untuk:
- **Knowledge Acquisition**: Pengumpulan pengetahuan dari ahli
- **Knowledge Representation**: Representasi pengetahuan dalam bentuk yang dapat diproses
- **Knowledge Inference**: Inferensi untuk menghasilkan kesimpulan
- **Knowledge Update**: Pembaruan pengetahuan secara berkala

#### d. User Interface (Antarmuka Pengguna)

User Interface merupakan komponen yang memfasilitasi interaksi antara pengguna dengan SPK. Antarmuka yang baik harus intuitif, mudah digunakan, dan mampu menyajikan informasi dengan cara yang efektif untuk mendukung pengambilan keputusan.

Karakteristik User Interface SPK yang baik:
- **User-friendly**: Mudah digunakan oleh pengguna dengan berbagai latar belakang
- **Interactive**: Memungkinkan interaksi dua arah antara pengguna dan sistem
- **Flexible**: Dapat menyesuaikan dengan kebutuhan dan preferensi pengguna
- **Informative**: Menyajikan informasi dengan jelas dan relevan

Fitur-fitur User Interface SPK:
- **Dashboard**: Tampilan ringkas metrik-metrik kunci
- **Reporting**: Fasilitas pembuatan laporan
- **Visualization**: Grafik dan visualisasi data
- **Query Interface**: Fasilitas untuk melakukan query data
- **What-if Analysis**: Fasilitas untuk analisis skenario

### 4.2.3 Peran Pengguna dan Manajer dalam Pengembangan SPK

Keberhasilan pengembangan SPK sangat bergantung pada keterlibatan aktif pengguna dan manajer sepanjang siklus hidup pengembangan sistem. Peran mereka tidak hanya sebagai penerima akhir sistem, tetapi juga sebagai partisipan kritis dalam setiap tahap pengembangan.

#### Peran Pengguna (Users)

Pengguna SPK adalah individu yang secara langsung menggunakan sistem untuk mendukung keputusan mereka. Peran pengguna meliputi:

1. **Sebagai Sumber Informasi**
   - Memberikan informasi tentang kebutuhan fungsional sistem
   - Menjelaskan proses pengambilan keputusan yang ada
   - Mendefinisikan kriteria keberhasilan sistem

2. **Sebagai Validator**
   - Memvalidasi kebenaran analisis kebutuhan
   - Mengevaluasi prototype dan desain sistem
   - Memberikan feedback selama proses pengembangan

3. **Sebagai Penerima Manfaat**
   - Menggunakan sistem untuk mendukung keputusan sehari-hari
   - Memberikan masukan untuk perbaikan sistem
   - Menjadi agen perubahan dalam organisasi

#### Peran Manajer (Managers)

Manajer, khususnya manajer tingkat menengah dan atas, memiliki peran strategis dalam pengembangan SPK:

1. **Sebagai Sponsor**
   - Memberikan dukungan politik dan anggaran
   - Memastikan ketersediaan sumber daya
   - Mengatasi hambatan organisasional

2. **Sebagai Decision Maker**
   - Menentukan prioritas pengembangan sistem
   - Memutuskan arah strategis pengembangan SPK
   - Menyetujui perubahan ruang lingkup proyek

3. **Sebagai Change Agent**
   - Mempromosikan adopsi sistem dalam organisasi
   - Mendorong budaya pengambilan keputusan berbasis data
   - Memfasilitasi perubahan proses bisnis

#### Prinsip Keterlibatan Pengguna dan Manajer

Untuk memastikan keberhasilan pengembangan SPK, beberapa prinsip keterlibatan perlu diperhatikan:

1. **Early Involvement**: Keterlibatan sejak tahap awal pengembangan
2. **Continuous Participation**: Partisipasi berkelanjutan sepanjang siklus hidup
3. **Active Engagement**: Keterlibatan aktif, bukan hanya pasif
4. **Empowerment**: Pemberian wewenang untuk membuat keputusan terkait sistem
5. **Ownership**: Rasa memiliki terhadap sistem yang dikembangkan

### 4.2.4 Metodologi Pengembangan SPK

Metodologi pengembangan SPK adalah pendekatan sistematis yang digunakan untuk mengelola proses pengembangan sistem dari awal hingga akhir. Pemilihan metodologi yang tepat sangat penting untuk memastikan keberhasilan pengembangan SPK, mengingat karakteristik SPK yang seringkali memerlukan fleksibilitas dan adaptasi terhadap kebutuhan pengguna yang dinamis.

#### a. Waterfall Model

Waterfall Model adalah metodologi pengembangan sistem yang bersifat linier dan sekuensial. Setiap tahap pengembangan harus diselesaikan sepenuhnya sebelum melanjutkan ke tahap berikutnya, seperti air yang mengalir dari atas ke bawah melalui undakan-undakan.

**Karakteristik Waterfall Model:**
- Bersifat linier dan sekuensial
- Setiap fase memiliki deliverables yang jelas
- Dokumentasi yang komprehensif
- Perencanaan yang detail di awal proyek

**Tahapan Waterfall Model:**
1. **Requirements**: Pengumpulan dan spesifikasi kebutuhan
2. **Design**: Perancangan sistem dan arsitektur
3. **Implementation**: Implementasi dan pengkodean
4. **Verification**: Verifikasi dan pengujian
5. **Maintenance**: Pemeliharaan dan evolusi sistem

**Keunggulan Waterfall Model untuk SPK:**
- Terstruktur dan terorganisir dengan baik
- Dokumentasi yang lengkap
- Mudah dikelola dan dipantau
- Cocok untuk proyek dengan kebutuhan yang stabil dan jelas

**Keterbatasan Waterfall Model untuk SPK:**
- Kurang fleksibel terhadap perubahan kebutuhan
- Pengguna melihat hasil hanya di akhir proyek
- Sulit mengakomodasi evolusi kebutuhan pengguna
- Risiko tinggi jika kebutuhan tidak dipahami dengan benar di awal

#### b. Prototyping

Prototyping adalah metodologi pengembangan yang berfokus pada pembuatan prototype (model awal) sistem yang dapat dievaluasi oleh pengguna sebelum sistem final dikembangkan. Prototype memungkinkan pengguna untuk melihat dan merasakan sistem sejak dini, sehingga feedback dapat dikumpulkan secara iteratif.

**Karakteristik Prototyping:**
- Iteratif dan interaktif
- Fokus pada visualisasi dan fungsi utama
- Penglibatan aktif pengguna
- Fleksibel terhadap perubahan

**Jenis-jenis Prototyping:**
1. **Throwaway Prototyping**: Prototype dibuat untuk keperluan eksplorasi kebutuhan saja, kemudian dibuang
2. **Evolutionary Prototyping**: Prototype terus dikembangkan menjadi sistem final
3. **Incremental Prototyping**: Pengembangan sistem secara bertahap dengan prototype untuk setiap increment

**Proses Prototyping:**
1. **Identifikasi kebutuhan dasar**
2. **Develop prototype**: Pengembangan prototype awal
3. **Use prototype**: Pengguna menggunakan prototype
4. **Evaluate**: Evaluasi oleh pengguna
5. **Refine**: Perbaikan prototype berdasarkan feedback
6. **Repeat**: Iterasi hingga memenuhi kepuasan pengguna

**Keunggulan Prototyping untuk SPK:**
- Pengguna terlibat aktif dalam proses pengembangan
- Kebutuhan dapat dieksplorasi dan disempurnakan secara bertahap
- Mengurangi risiko ketidaksesuaian dengan kebutuhan pengguna
- Cocok untuk kebutuhan yang tidak jelas atau sering berubah

**Keterbatasan Prototyping untuk SPK:**
- Cenderung kurang terstruktur
- Dokumentasi seringkali terabaikan
- Sulit memperkirakan waktu dan biaya secara akurat
- Potensi "scope creep" (perluasan ruang lingkup yang tidak terkendali)

#### c. Agile/Adaptive Methodology

Agile methodology adalah pendekatan pengembangan yang adaptif dan iteratif, yang menekankan pada fleksibilitas, kolaborasi, dan respons cepat terhadap perubahan. Agile menganggap bahwa kebutuhan pengguna akan terus berevolusi, sehingga proses pengembangan harus mampu beradaptasi dengan perubahan tersebut.

**Karakteristik Agile Methodology:**
- Iteratif dan increment
- Fokus pada kolaborasi tim dan pengguna
- Responsif terhadap perubahan
- Deliverables yang sering dan dalam siklus pendek

**Prinsip-prinsip Agile (dari Agile Manifesto):**
1. **Individuals and interactions** lebih penting daripada processes and tools
2. **Working software** lebih penting daripada comprehensive documentation
3. **Customer collaboration** lebih penting daripada contract negotiation
4. **Responding to change** lebih penting daripada following a plan

**Framework Agile yang umum untuk SPK:**
1. **Scrum**: Framework dengan sprint pendek (2-4 minggu)
2. **Kanban**: Pendekatan visual dengan alur kerja yang kontinu
3. **Extreme Programming (XP)**: Fokus pada praktik engineering yang excellent
4. **Feature-Driven Development (FDD)**: Pengembangan berbasis fitur

**Keunggulan Agile untuk SPK:**
- Sangat adaptif terhadap perubahan kebutuhan
- Pengguna melihat hasil berkala dalam siklus singkat
- Kolaborasi yang kuat antara tim dan pengguna
- Mengurangi risiko pengembangan sistem yang tidak sesuai

**Keterbatasan Agile untuk SPK:**
- Memerlukan budaya organisasi yang mendukung
- Sulit diterapkan untuk proyek dengan regulasi ketat
- Dokumentasi seringkali minim
- Memerlukan keterlibatan pengguna yang intensif

#### Pemilihan Metodologi yang Tepat untuk SPK

Pemilihan metodologi pengembangan SPK harus mempertimbangkan beberapa faktor:

1. **Klaritas Kebutuhan**: Seberapa jelas kebutuhan sistem di awal proyek
2. **Stabilitas Kebutuhan**: Seberapa stabil kebutuhan selama proyek
3. **Ukuran dan Kompleksitas Proyek**: Skala dan kompleksitas sistem yang akan dikembangkan
4. **Keterlibatan Pengguna**: Seberapa intensif pengguna dapat terlibat
5. **Budaya Organisasi**: Kesesuaian dengan budaya organisasi
6. **Kendala Waktu dan Biaya**: Batasan waktu dan anggaran yang tersedia

### 4.2.5 Faktor Keberhasilan dan Kegagalan dalam Pengembangan SPK

Pengembangan SPK adalah investasi signifikan bagi organisasi, dan keberhasilannya dipengaruhi oleh berbagai faktor. Memahami faktor-faktor kritis keberhasilan dan penyebab kegagalan dapat membantu organisasi meningkatkan peluang sukses dalam pengembangan SPK.

#### Faktor Keberhasilan Pengembangan SPK

1. **Dukungan Manajemen Puncak (Top Management Support)**
   - Dukungan politik dan anggaran yang memadai
   - Komitmen untuk mengalokasikan sumber daya yang diperlukan
   - Kemampuan untuk mengatasi hambatan organisasional
   - Visi strategis tentang peran SPK dalam organisasi

2. **Keterlibatan Pengguna (User Involvement)**
   - Partisipasi aktif pengguna sejak tahap awal
   - Keterlibatan dalam proses pengambilan keputusan desain
   - Feedback yang konstruktif selama pengembangan
   - Rasa memiliki (ownership) terhadap sistem

3. **Klaritas Tujuan dan Ruang Lingkup (Clear Goals and Scope)**
   - Tujuan sistem yang jelas dan terukur
   - Ruang lingkup yang realistis dan terdefinisi dengan baik
   - Fokus pada masalah keputusan yang spesifik
   - Kesesuaian dengan strategi organisasi

4. **Kualitas Tim Pengembangan (Development Team Quality)**
   - Kompetensi teknis yang memadai
   - Pemahaman tentang domain bisnis
   - Kemampuan komunikasi yang baik
   - Pengalaman dalam pengembangan sistem sejenis

5. **Kualitas Data dan Informasi (Data and Information Quality)**
   - Ketersediaan data yang akurat dan relevan
   - Proses pengelolaan data yang baik
   - Integrasi data dari berbagai sumber
   - Keamanan dan privasi data yang terjamin

6. **Teknologi yang Tepat (Appropriate Technology)**
   - Pilihan teknologi yang sesuai dengan kebutuhan
   - Arsitektur sistem yang skalabel
   - Kompatibilitas dengan sistem yang ada
   - Kemudahan penggunaan dan pemeliharaan

7. **Perencanaan dan Manajemen Proyek (Planning and Project Management)**
   - Perencanaan yang realistis dan komprehensif
   - Manajemen risiko yang baik
   - Monitoring dan kontrol proyek yang efektif
   - Fleksibilitas dalam menangani perubahan

8. **Faktor Organisasi dan Budaya (Organizational and Cultural Factors)**
   - Budaya organisasi yang mendukung inovasi
   - Kesiapan untuk perubahan proses bisnis
   - Struktur organisasi yang mendukung implementasi SPK
   - Kemampuan belajar dan beradaptasi

#### Faktor Kegagalan Pengembangan SPK

1. **Kurangnya Dukungan Manajemen**
   - Tidak adanya dukungan politik yang cukup
   - Keterbatasan anggaran dan sumber daya
   - Prioritas yang rendah dalam agenda organisasi
   - Ketidakmampuan mengatasi resistensi perubahan

2. **Keterlibatan Pengguna yang Minim**
   - Pengguna hanya terlibat di tahap akhir
   - Kurangnya pemahaman tentang kebutuhan pengguna
   - Komunikasi yang tidak efektif dengan pengguna
   - Resistensi terhadap penggunaan sistem baru

3. **Tujuan dan Ruang Lingkup yang Tidak Jelas**
   - Tujuan yang terlalu ambisius atau tidak realistis
   - Ruang lingkup yang terus berubah (scope creep)
   - Kurangnya fokus pada masalah bisnis inti
   - Ketidaksesuaian dengan kebutuhan organisasi

4. **Masalah Teknis dan Teknologi**
   - Pilihan teknologi yang tidak tepat
   - Kinerja sistem yang tidak memadai
   - Masalah integrasi dengan sistem lain
   - Kualitas data yang buruk

5. **Manajemen Proyek yang Buruk**
   - Perencanaan yang tidak realistis
   - Estimasi waktu dan biaya yang tidak akurat
   - Kurangnya kontrol terhadap proyek
   - Ketidakmampuan mengelola risiko

6. **Faktor Sumber Daya Manusia**
   - Kurangnya kompetensi tim pengembangan
   - Turnover anggota tim yang tinggi
   - Kurangnya pelatihan untuk pengguna
   - Konflik dalam tim pengembangan

7. **Faktor Eksternal**
   - Perubahan lingkungan bisnis yang drastis
   - Perubahan regulasi atau kebijakan
   - Teknologi yang menjadi usang dengan cepat
   - Persaingan atau tekanan pasar

#### Strategi Mitigasi Risiko

Untuk meningkatkan peluang keberhasilan pengembangan SPK, organisasi dapat mengimplementasikan strategi mitigasi risiko berikut:

1. **Conduct Feasibility Study**: Melakukan studi kelayakan sebelum memulai proyek
2. **Stakeholder Analysis**: Menganalisis dan mengelola stakeholder secara efektif
3. **Risk Management**: Mengidentifikasi, mengukur, dan mengelola risiko proyek
4. **Change Management**: Mengelola perubahan organisasi secara sistematis
5. **Quality Assurance**: Menerapkan proses quality assurance yang ketat
6. **Continuous Monitoring**: Memantau kemajuan proyek secara berkala
7. **Post-Implementation Review**: Melakukan evaluasi setelah implementasi

## 4.3 Studi Kasus Pengembangan SPK

Untuk memberikan pemahaman yang lebih konkret tentang pengembangan SPK, berikut disajikan studi kasus pengembangan SPK untuk seleksi beasiswa di sebuah perguruan tinggi.

### Studi Kasus: Pengembangan SPK untuk Seleksi Beasiswa

#### Latar Belakang Masalah

Sebuah perguruan tinggi swasta menghadapi tantangan dalam proses seleksi beasiswa yang semakin kompleks. Setiap tahun, perguruan tinggi ini menerima sekitar 2.000 pendaftar beasiswa dari berbagai fakultas dan program studi, namun hanya tersedia 200 kuota beasiswa. Proses seleksi yang dilakukan secara manual menggunakan spreadsheet memakan waktu 3-4 minggu dan seringkali menghasilkan keputusan yang kurang objektif karena tergantung pada penilaian subjektif dari panitia seleksi.

#### Tujuan Pengembangan SPK

Pengembangan SPK untuk seleksi beasiswa bertujuan untuk:
1. Mempercepat proses seleksi dari 3-4 minggu menjadi 3-5 hari
2. Meningkatkan objektivitas keputusan melalui kriteria yang terstandar
3. Memudahkan tracking dan monitoring proses seleksi
4. Memberikan transparansi kepada pemangku kepentingan
5. Menghasilkan laporan evaluasi yang komprehensif

#### Siklus Hidup Pengembangan

**1. Tahap Perencanaan**
- **Identifikasi Masalah**: Proses seleksi manual yang lambat dan kurang objektif
- **Stakeholder Analysis**: Identifikasi pemangku kepentingan (rektorat, fakultas, panitia, mahasiswa)
- **Feasibility Study**: Analisis kelayakan teknis, ekonomis, dan operasional
- **Scope Definition**: Menentukan batasan sistem (hanya untuk beasiswa reguler)

**2. Tahap Analisis**
- **Requirement Gathering**: Wawancara dengan panitia seleksi dan fakultas
- **Process Analysis**: Pemetaan proses seleksi yang ada
- **Data Analysis**: Identifikasi data yang diperlukan (nilai akademik, prestasi, ekonomi)
- **Criteria Definition**: Penentuan kriteria seleksi (IPK, prestasi, kondisi ekonomi)

**3. Tahap Desain**
- **Arsitektur Sistem**: Desain arsitektur tiga lapis (presentation, logic, data)
- **Database Design**: Perancangan database mahasiswa, kriteria, dan hasil seleksi
- **Model Design**: Pemilihan model AHP (Analytic Hierarchy Process) untuk perhitungan bobot
- **Interface Design**: Desain dashboard untuk panitia dan laporan untuk manajemen

**4. Tahap Implementasi**
- **Technology Selection**: Pemilihan teknologi (PHP, MySQL, Bootstrap)
- **Prototyping**: Pengembangan prototype untuk validasi dengan pengguna
- **Development**: Pengembangan sistem berdasarkan desain
- **Testing**: Pengujian fungsional dan performansi

**5. Tahap Evaluasi dan Pemeliharaan**
- **User Acceptance Test**: Pengujian oleh panitia seleksi
- **Training**: Pelatihan penggunaan sistem
- **Deployment**: Implementasi sistem di lingkungan produksi
- **Monitoring**: Monitoring kinerja sistem dan kepuasan pengguna

#### Arsitektur SPK yang Dikembangkan

**1. Database Layer**
- **Mahasiswa Database**: Data pribadi, akademik, dan ekonomi mahasiswa
- **Criteria Database**: Kriteria seleksi dan bobotnya
- **History Database**: Riwayat seleksi tahun-tahun sebelumnya
- **User Database**: Data pengguna sistem dan hak akses

**2. Model Base Layer**
- **AHP Model**: Model Analytic Hierarchy Process untuk perhitungan bobot kriteria
- **Scoring Model**: Model perhitungan skor akhir setiap pendaftar
- **Ranking Model**: Model perangkingan pendaftar berdasarkan skor
- **Simulation Model**: Model simulasi untuk analisis "what-if"

**3. Knowledge Base Layer**
- **Rules Base**: Aturan-aturan kelayakan beasiswa
- **Expert Knowledge**: Pengetahuan dari panitia seleksi berpengalaman
- **Historical Patterns**: Pola dari seleksi tahun-tahun sebelumnya
- **Exception Handling**: Penanganan kasus-kasus khusus

**4. User Interface Layer**
- **Admin Dashboard**: Interface untuk administrasi sistem
- **Selection Dashboard**: Interface untuk panitia seleksi
- **Management Dashboard**: Interface untuk manajemen (rektorat, dekanat)
- **Reporting Interface**: Interface untuk generating laporan

#### Metodologi Pengembangan yang Digunakan

Pengembangan SPK ini menggunakan metodologi **Evolutionary Prototyping** dengan pendekatan **Agile**. Alasan pemilihan metodologi ini:
1. Kebutuhan pengguna belum sepenuhnya jelas di awal
2. Perlu iterasi cepat untuk mendapatkan feedback dari panitia seleksi
3. Kemampuan untuk beradaptasi dengan perubahan kebutuhan
4. Pengguna dapat melihat dan menggunakan sistem sejak dini

**Proses Agile yang diterapkan:**
- **Sprint Planning**: Perencanaan setiap sprint (2 minggu)
- **Daily Stand-up**: Koordinasi harian tim pengembangan
- **Sprint Review**: Demonstrasi hasil sprint kepada panitia
- **Sprint Retrospective**: Evaluasi proses pengembangan
- **Continuous Integration**: Integrasi kode secara kontinu

#### Faktor Keberhasilan Implementasi

1. **Dukungan Manajemen Puncak**: Rektor dan wakil rektor memberikan dukungan penuh
2. **Keterlibatan Pengguna**: Panitia seleksi terlibat aktif sejak awal
3. **Klarifikasi Kebutuhan**: Kebutuhan didefinisikan dengan jelas dan terukur
4. **Tim yang Kompeten**: Tim pengembangan memiliki pengalaman di bidang SPK
5. **Pendekatan Iteratif**: Prototype divalidasi berkala dengan pengguna
6. **Pelatihan yang Memadai**: Pengguna diberikan pelatihan intensif
7. **Perencanaan Perubahan**: Perubahan proses bisnis dikelola dengan baik

#### Hasil dan Dampak Implementasi

**Hasil Kuantitatif:**
- Waktu proses seleksi berkurang dari 3-4 minggu menjadi 3-5 hari
- Akurasi seleksi meningkat 90% berdasarkan evaluasi tahun berikutnya
- Efisiensi biaya operasional seleksi meningkat 40%
- Kepuasan pengguna mencapai 85% berdasarkan survei

**Hasil Kualitatif:**
- Proses seleksi menjadi lebih transparan dan objektif
- Kemudahan dalam tracking dan monitoring proses seleksi
- Peningkatan kepercayaan stakeholders terhadap proses seleksi
- Kemampuan untuk melakukan analisis historis dan prediksi

**Pelajaran yang Dipelajari:**
1. Pentingnya keterlibatan pengguna sejak tahap awal
2. Perlu fleksibilitas dalam menyesuaikan sistem dengan kebutuhan
3. Data yang berkualitas adalah kunci keberhasilan SPK
4. Perubahan proses bisnis harus dikelola dengan hati-hati
5. Pelatihan dan dukungan pasca-implementasi sangat krusial

## 4.4 Ringkasan Bab

Bab 4 telah membahas secara komprehensif tentang pengembangan Sistem Pendukung Keputusan (SPK). Beberapa poin penting yang dapat disimpulkan adalah:

### Poin Inti tentang Tahapan Pengembangan SPK

1. **Siklus Hidup Pengembangan SPK** terdiri dari lima tahapan utama:
   - **Perencanaan**: Identifikasi kebutuhan, kelayakan, dan penyusunan rencana
   - **Analisis**: Pemahaman mendalam tentang kebutuhan dan masalah keputusan
   - **Desain**: Perancangan arsitektur dan komponen-komponen sistem
   - **Implementasi**: Pengembangan, pengujian, dan instalasi sistem
   - **Evaluasi dan Pemeliharaan**: Monitoring, perbaikan, dan adaptasi sistem

2. **Arsitektur SPK** terdiri dari empat komponen utama yang saling terintegrasi:
   - **Database**: Penyimpan dan pengelola data untuk analisis keputusan
   - **Model Base**: Kumpulan model analitis untuk mengolah data
   - **Knowledge Base**: Penyimpan pengetahuan ahli dan aturan-aturan
   - **User Interface**: Antarmuka untuk interaksi pengguna dengan sistem

3. **Peran Pengguna dan Manajer** sangat krusial dalam pengembangan SPK:
   - Pengguna sebagai sumber informasi, validator, dan penerima manfaat
   - Manajer sebagai sponsor, decision maker, dan change agent
   - Prinsip keterlibatan early, continuous, active, empowerment, dan ownership

### Poin Inti tentang Metodologi Pengembangan SPK

1. **Waterfall Model**: Pendekatan linier dan sekuensial yang cocok untuk kebutuhan stabil
2. **Prototyping**: Pendekatan iteratif dengan prototype untuk eksplorasi kebutuhan
3. **Agile/Adaptive**: Pendekatan fleksibel dan adaptif untuk kebutuhan yang dinamis

### Faktor Keberhasilan dan Kegagalan

1. **Faktor Keberhasilan**: Dukungan manajemen, keterlibatan pengguna, klarifikasi tujuan, kualitas tim, kualitas data, teknologi tepat, perencanaan baik, dan faktor organisasi
2. **Faktor Kegagalan**: Kurang dukungan, keterlibatan minim, tujuan tidak jelas, masalah teknis, manajemen buruk, masalah SDM, dan faktor eksternal

### Studi Kasus

Studi kasus pengembangan SPK untuk seleksi beasiswa menunjukkan penerapan konsep-konsep pengembangan SPK dalam konteks nyata, termasuk penerapan siklus hidup pengembangan, arsitektur SPK, metodologi yang sesuai, dan faktor-faktor keberhasilan implementasi.

Pengembangan SPK bukan hanya tentang teknologi, tetapi juga tentang people, process, dan organizational factors. Keberhasilan SPK ditentukan oleh kemampuan mengintegrasikan aspek teknis dengan pemahaman bisnis dan manajemen perubahan yang efektif.

## 4.5 Latihan/Tugas Mahasiswa

Untuk menguji pemahaman dan aplikasi konsep-konsep yang telah dipelajari dalam Bab 4, berikut adalah latihan dan tugas untuk mahasiswa:

### Soal Teori

1. **Jelaskan perbedaan antara siklus hidup pengembangan SPK dengan siklus hidup pengembangan sistem informasi pada umumnya! Berikan contoh spesifik pada setiap tahapannya.**

2. **Bandingkan ketiga metodologi pengembangan SPK (Waterfall, Prototyping, dan Agile) dari berbagai aspek: fleksibilitas, dokumentasi, keterlibatan pengguna, risiko, dan cocok tidaknya untuk proyek SPK. Buatlah tabel perbandingan!**

3. **Sebutkan dan jelaskan secara rinci keempat komponen utama arsitektur SPK! Untuk setiap komponen, berikan contoh teknologi atau tools yang biasa digunakan dalam implementasinya.**

4. **Analisislah faktor-faktor kritis keberhasilan pengembangan SPK! Pilih 3 faktor yang menurut Anda paling penting dan jelaskan mengapa faktor tersebut krusial untuk keberhasilan SPK.**

5. **Jelaskan perbedaan peran antara pengguna (users) dan manajer (managers) dalam pengembangan SPK! Berikan contoh spesifik aktivitas yang dilakukan oleh masing-masing pihak pada setiap tahap pengembangan.**

### Tugas Praktik

6. **Rancanglah diagram arsitektur SPK untuk salah satu skenario berikut:**
   - SPK untuk pemilihan supplier di perusahaan manufaktur
   - SPK untuk penilaian kinerja karyawan
   - SPK untuk perencanaan produksi
   Diagram harus menunjukkan keempat komponen utama (database, model base, knowledge base, user interface) dan hubungan antar komponen tersebut.

7. **Buatlah rencana proyek pengembangan SPK menggunakan metodologi Waterfall untuk kasus "SPK untuk manajemen risiko proyek". Rencana harus mencakup:**
   - Tujuan proyek
   - Stakeholder analysis
   - WBS (Work Breakdown Structure)
   - Jadwal proyek (Gantt chart sederhana)
   - Rencana sumber daya
   - Rencana risiko

8. **Develop a prototype SPK interface** untuk salah satu fungsi berikut (dapat menggunakan tools seperti Figma, Mockplus, atau PowerPoint):
   - Dashboard monitoring kinerja akademik mahasiswa
   - Interface analisis penjualan produk
   - Interface evaluasi risiko investasi
   Prototype harus menunjukkan kemampuan interaksi dan visualisasi data.

### Mini Project

9. **Mini Project: Analisis Kelayakan Pengembangan SPK**
   Pilih satu organisasi (perusahaan, institusi pendidikan, rumah sakit, dll.) dan lakukan analisis kelayakan pengembangan SPK untuk satu masalah keputusan spesifik. Analisis harus mencakup:
   - Identifikasi masalah keputusan
   - Analisis stakeholder
   - Analisis kelayakan teknis, ekonomis, dan operasional
   - Rekomendasi metodologi pengembangan yang paling sesuai
   - Rencana implementasi tingkat tinggi
   Presentasikan hasilnya dalam bentuk laporan (3-5 halaman).

10. **Mini Project: Case Study Analysis**
    Cari satu artikel kasus nyata tentang pengembangan SPK (dari jurnal, konferensi, atau laporan industri). Analisis kasus tersebut berdasarkan framework yang telah dipelajari:
    - Bagaimana siklus hidup pengembangan diterapkan?
    - Apa arsitektur SPK yang digunakan?
    - Metodologi apa yang dipilih dan mengapa?
    - Faktor keberhasilan apa yang muncul?
    - Pelajaran apa yang dapat dipetik?
    Presentasikan analisis Anda dalam bentuk presentasi (10-15 slide).

### Tugas Kelompok

11. **Kelompok (3-4 orang): SPK Development Simulation**
    Simulasikan pengembangan SPK untuk kasus "SPK untuk seleksi calon karyawan baru". Lakukan role-play dengan anggota kelompok sebagai:
    - Project Manager
    - System Analyst
    - User Representative
    - Development Team
    Lakukan simulasi untuk 3 tahap: perencanaan, analisis kebutuhan, dan desain. Dokumentasikan hasil simulasi dan presentasikan proses serta hasilnya.

12. **Kelompok (3-4 orang): SPK Evaluation Framework**
    Rancang framework evaluasi untuk mengukur keberhasilan implementasi SPK. Framework harus mencakup:
    - Kriteria evaluasi (teknis, operasional, strategis)
    - Metrik pengukuran untuk setiap kriteria
    - Metode pengumpulan data
    - Prosedur evaluasi
    - Mekanisme feedback dan improvement
    Uji framework yang Anda rancang dengan kasus studi SPK yang ada di industri.

---

**Catatan untuk Dosen:**
- Latihan 1-5 cocok untuk tugas individu dengan bobot 10-15%
- Tugas praktik 6-8 cocok untuk tugas individu/kelompok kecil dengan bobot 20-25%
- Mini project 9-10 cocok untuk tugas kelompok dengan bobot 25-30%
- Tugas kelompok 11-12 cocok untuk project akhir bab dengan bobot 30-40%
- Durasi pengerjaan dapat disesuaikan dengan kebutuhan mata kuliah (1-3 minggu)