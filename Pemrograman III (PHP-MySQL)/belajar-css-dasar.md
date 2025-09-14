# CSS Dasar
### Pertemuan 3

---

## Slide 1: Apa itu CSS?

### Poin Utama:
- CSS (Cascading Style Sheets) adalah bahasa stylesheet untuk mengatur tampilan elemen HTML
- Memisahkan konten (HTML) dengan presentasi visual (CSS)
- Membuat halaman web lebih menarik dan responsif
- Standard web yang dikembangkan oleh W3C

**Catatan Presenter:**
CSS seperti "baju" untuk HTML. Jika HTML adalah kerangka rumah, maka CSS adalah cat, wallpaper, dan dekorasi yang membuat rumah tersebut indah dipandang.

**Dokumentasi:** [MDN CSS Introduction](https://developer.mozilla.org/en-US/docs/Web/CSS)

---

## Slide 2: Cara Menerapkan CSS

### Tiga Metode Penerapan:
- **Inline CSS:** Langsung di atribut HTML
- **Internal CSS:** Di dalam tag `<style>` pada `<head>`
- **External CSS:** File terpisah dengan ekstensi `.css`
- External CSS adalah praktik terbaik untuk proyek besar

```css
/* External CSS - style.css */
body {
    background-color: #f0f0f0;
    font-family: Arial, sans-serif;
}
```

**Catatan Presenter:**
External CSS memungkinkan satu file CSS digunakan untuk banyak halaman HTML, seperti template yang bisa dipakai berulang-ulang.

---

## Slide 3: Sintaks Dasar CSS

### Struktur Aturan CSS:
- **Selector:** Memilih elemen HTML yang akan diatur
- **Property:** Aspek yang ingin diubah (warna, ukuran, dll)
- **Value:** Nilai untuk property tersebut
- Diakhiri dengan semicolon (;)

```css
h1 {
    color: blue;
    font-size: 24px;
    text-align: center;
}
```

**Catatan Presenter:**
Struktur ini seperti memberikan instruksi: "Untuk semua heading 1, buat warnanya biru, ukurannya 24px, dan posisinya di tengah."

**Dokumentasi:** [MDN CSS Syntax](https://developer.mozilla.org/en-US/docs/Web/CSS/Syntax)

---

## Slide 4: CSS Selectors

### Jenis-jenis Selector:
- **Element Selector:** Memilih berdasarkan tag HTML
- **Class Selector:** Menggunakan titik (.) untuk class
- **ID Selector:** Menggunakan hash (#) untuk ID
- **Universal Selector:** Menggunakan asterisk (*) untuk semua elemen

```css
p { color: black; }        /* Element */
.highlight { color: red; } /* Class */
#header { color: green; }  /* ID */
* { margin: 0; }          /* Universal */
```

**Catatan Presenter:**
Selector seperti alamat rumah - semakin spesifik alamatnya, semakin tepat kita menemukan target yang diinginkan.

---

## Slide 5: Colors dan Backgrounds

### Cara Mengatur Warna:
- **Named colors:** red, blue, green, dll
- **Hexadecimal:** #FF0000 untuk merah
- **RGB:** rgb(255, 0, 0) untuk merah
- **Background properties:** background-color, background-image

```css
.container {
    color: #333333;
    background-color: rgb(240, 240, 240);
    background-image: url('pattern.png');
}
```

**Catatan Presenter:**
Hexadecimal adalah sistem bilangan basis 16 yang sangat presisi untuk warna. RGB seperti mencampur cat merah, hijau, dan biru dengan proporsi tertentu.

**Dokumentasi:** [MDN CSS Colors](https://developer.mozilla.org/en-US/docs/Web/CSS/color_value)

---

## Slide 6: Typography

### Mengatur Teks:
- **font-family:** Jenis font (Arial, serif, sans-serif)
- **font-size:** Ukuran font (px, em, rem, %)
- **font-weight:** Ketebalan (normal, bold, 100-900)
- **text-align:** Perataan teks (left, center, right, justify)
- **line-height:** Jarak antar baris

```css
.article {
    font-family: 'Georgia', serif;
    font-size: 16px;
    font-weight: 400;
    line-height: 1.5;
    text-align: justify;
}
```

**Catatan Presenter:**
Typography adalah seni mengatur teks agar mudah dibaca dan menarik. Line-height 1.5 berarti jarak antar baris 1.5 kali ukuran font.

---

## Slide 7: Box Model

### Konsep Fundamental CSS:
- **Content:** Isi elemen (teks, gambar)
- **Padding:** Ruang di dalam elemen, di sekitar content
- **Border:** Garis pembatas elemen
- **Margin:** Ruang di luar elemen, jarak dengan elemen lain

```css
.box {
    width: 200px;
    height: 100px;
    padding: 20px;
    border: 2px solid black;
    margin: 10px;
}
```

**Catatan Presenter:**
Box model seperti kotak kado: content adalah hadiah, padding adalah bubble wrap, border adalah kotaknya, dan margin adalah jarak dengan kotak lain.

**Dokumentasi:** [MDN Box Model](https://developer.mozilla.org/en-US/docs/Learn/CSS/Building_blocks/The_box_model)

---

## Slide 8: Display Properties

### Jenis Display:
- **block:** Elemen mengambil seluruh lebar (div, h1, p)
- **inline:** Elemen sejajar horizontal (span, a, strong)
- **inline-block:** Gabungan block dan inline
- **none:** Elemen disembunyikan

```css
.nav-item {
    display: inline-block;
    padding: 10px 15px;
    margin: 5px;
}

.hidden {
    display: none;
}
```

**Catatan Presenter:**
Display block seperti rak buku yang mengambil seluruh lebar dinding, inline seperti buku-buku yang berjajar dalam satu rak.

---

## Slide 9: Positioning

### Jenis Position:
- **static:** Posisi normal (default)
- **relative:** Relatif terhadap posisi normal
- **absolute:** Relatif terhadap parent terdekat
- **fixed:** Tetap di layar meski di-scroll
- **sticky:** Kombinasi relative dan fixed

```css
.header {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    z-index: 1000;
}
```

**Catatan Presenter:**
Fixed position seperti stiker yang ditempel di kaca mobil - tetap terlihat meski landscape berubah saat berkendara.

**Dokumentasi:** [MDN CSS Position](https://developer.mozilla.org/en-US/docs/Web/CSS/position)

---

## Slide 10: Flexbox Dasar

### Layout Modern dengan Flexbox:
- **display: flex:** Mengaktifkan flexbox
- **justify-content:** Perataan horizontal
- **align-items:** Perataan vertikal
- **flex-direction:** Arah susunan (row/column)

```css
.container {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}

.item {
    flex: 1;
}
```

**Catatan Presenter:**
Flexbox seperti organizer laci yang fleksibel - item di dalamnya bisa diatur dengan mudah untuk menyesuaikan ruang yang tersedia.

**Dokumentasi:** [MDN Flexbox](https://developer.mozilla.org/en-US/docs/Learn/CSS/CSS_layout/Flexbox)

---

## Slide 11: Responsive Design

### CSS untuk Berbagai Perangkat:
- **Media Queries:** Aturan CSS berdasarkan ukuran layar
- **Viewport units:** vw, vh, vmin, vmax
- **Relative units:** em, rem, %
- **Mobile-first approach:** Desain dari mobile ke desktop

```css
/* Mobile First */
.container {
    width: 100%;
    padding: 10px;
}

/* Tablet and up */
@media (min-width: 768px) {
    .container {
        width: 80%;
        padding: 20px;
    }
}
```

**Catatan Presenter:**
Media queries seperti pakaian yang menyesuaikan cuaca - di mobile menggunakan layout sederhana, di desktop layout lebih kompleks.

---

## Slide 12: Pseudo-classes dan Pseudo-elements

### Selector Lanjutan:
- **Pseudo-classes:** :hover, :focus, :first-child, :nth-child()
- **Pseudo-elements:** ::before, ::after, ::first-letter
- Memberikan interaksi dan styling khusus
- Tidak perlu JavaScript untuk efek sederhana

```css
a:hover {
    color: red;
    text-decoration: underline;
}

p::first-letter {
    font-size: 2em;
    font-weight: bold;
}
```

**Catatan Presenter:**
Pseudo-classes seperti kondisi "jika-maka" dalam CSS - jika mouse hover, maka ubah warna. Pseudo-elements menciptakan elemen virtual untuk styling.

**Dokumentasi:** [MDN Pseudo-classes](https://developer.mozilla.org/en-US/docs/Web/CSS/Pseudo-classes)

---

## Slide 13: CSS Grid Dasar

### Layout 2 Dimensi:
- **display: grid:** Mengaktifkan grid
- **grid-template-columns:** Mengatur kolom
- **grid-template-rows:** Mengatur baris
- **grid-gap:** Jarak antar grid item

```css
.grid-container {
    display: grid;
    grid-template-columns: 1fr 2fr 1fr;
    grid-template-rows: auto;
    grid-gap: 20px;
}
```

**Catatan Presenter:**
CSS Grid seperti tabel Excel yang fleksibel - bisa mengatur baris dan kolom secara bersamaan dengan presisi tinggi.

**Dokumentasi:** [MDN CSS Grid](https://developer.mozilla.org/en-US/docs/Web/CSS/CSS_Grid_Layout)

---

## Slide 14: Best Practices

### Praktik Terbaik CSS:
- **Gunakan class daripada ID** untuk styling
- **Organisir CSS** dengan komentar dan struktur yang jelas
- **Hindari inline styles** untuk maintainability
- **Gunakan reset/normalize CSS** untuk konsistensi browser
- **Optimalkan performance** dengan CSS yang efisien

```css
/* ===================
   LAYOUT COMPONENTS
   =================== */
.header { /* styles */ }
.main-content { /* styles */ }
.footer { /* styles */ }

/* ===================
   UI COMPONENTS
   =================== */
.button { /* styles */ }
.card { /* styles */ }
```

**Catatan Presenter:**
CSS yang baik seperti kode program - mudah dibaca, diorganisir dengan baik, dan dapat dipelihara oleh developer lain.

---

## Slide 15: Tools dan Resources

### Alat Bantu Pengembangan:
- **Browser DevTools:** Inspect dan debug CSS
- **CSS Validators:** W3C CSS Validator
- **Preprocessors:** Sass, Less untuk CSS yang lebih powerful
- **Frameworks:** Bootstrap, Tailwind CSS
- **Online Tools:** CodePen, JSFiddle untuk eksperimen

### Resources Belajar:
- **MDN Web Docs:** Dokumentasi lengkap dan terpercaya
- **Can I Use:** Cek kompatibilitas browser
- **CSS-Tricks:** Tutorial dan tips praktis
- **Flexbox Froggy & Grid Garden:** Game belajar layout

**Catatan Presenter:**
DevTools adalah sahabat terbaik developer - gunakan untuk eksperimen real-time dan debugging. Jangan takut untuk mencoba dan bereksperimen!

**Dokumentasi:** [MDN CSS Reference](https://developer.mozilla.org/en-US/docs/Web/CSS/Reference)

---

## Terima Kasih!
### Pertanyaan dan Diskusi

**Next Steps:**
- Praktik langsung dengan project sederhana
- Eksplorasi CSS frameworks
- Pelajari CSS animations dan transitions
- Ikuti perkembangan CSS terbaru (CSS4 features)

*"The best way to learn CSS is by doing. Start small, be consistent, and don't be afraid to experiment!"*
