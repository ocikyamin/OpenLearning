# Master Prompt Framework — Petunjuk Penggunaan

Framework ini terdiri dari 6 stage berantai untuk menyusun dan mengimplementasikan aplikasi berbasis AI. Setiap stage menggunakan output stage sebelumnya sebagai input.

---

## Alur Stage

```
Stage 1: PRD            ← Input: Case Study Bisnis
  ↓ Output: Stage1_PRD.md
Stage 2: Tech Spec      ← Input: Stage1_PRD.md
  ↓ Output: Stage2_TechSpec.md
Stage 3: Task Breakdown ← Input: Stage2_TechSpec.md
  ↓ Output: Stage3_TaskList.md
Stage 4: Implementasi   ← Input: 1 task dari Stage3_TaskList.md (via OpenCode)
  ↓ Output: Kode program
Stage 5: Verifikasi     ← Input: Kode + Tech Spec
  ↓ Output: Stage5_Verifikasi.md
Stage 6: UI Design      ← Input: PRD / Deskripsi Fitur
  ↓ Output: DESIGN.md
```

---

## Cara Penggunaan

1. **Pilih Case Study** — Buka folder `Case_{Nama}/` dan baca dokumen bisnisnya
2. **Stage 1** — Copy prompt `1. Master Prompt - Menyiapkan Dokumen PRD.md` ke LLM, paste case study di bagian `### Input`, simpan output sebagai `Stage1_PRD.md`
3. **Stage 2** — Copy prompt `2. Master Prompt - Menyiapkan Tech Spec...`, paste `Stage1_PRD.md` di bagian `### Input`, simpan output sebagai `Stage2_TechSpec.md`
4. **Stage 3** — Copy prompt `3. Master Prompt - Menyusun Task...`, paste `Stage2_TechSpec.md`, simpan output sebagai `Stage3_TaskList.md`
5. **Stage 4** — Buka OpenCode, gunakan template `4. Master Template - Implementasi Task.md`, kerjakan 1 task per prompt sesuai urutan di Task List
6. **Stage 5** — Copy prompt `5. Master Prompt - Verifikasi...`, paste kode yang dihasilkan + bagian Tech Spec relevan
7. **Stage 6** — Copy prompt `6. Master Prompt - Menyiapkan Dokumen Spesifikasi Desain UI...`, paste PRD atau deskripsi fitur

---

## Aturan

- Kerjakan stage **berurutan**, jangan melompat
- Setiap stage bergantung pada output stage sebelumnya
- Stage 4 berbeda dari yang lain — ini template untuk OpenCode, bukan prompt untuk chat LLM
- Jika output LLM tidak sesuai, ulangi dengan instruksi yang lebih spesifik, jangan lanjutkan ke stage berikutnya

---

## Struktur Folder

```
Master Prompt Framework PARTS/
├── README.md
├── 1. Master Prompt - Menyiapkan Dokumen PRD.md
├── 2. Master Prompt - Menyiapkan Tech Specification.md
├── 3. Master Prompt - Menyusun Task (Breakdown Task).md
├── 4. Master Template - Implementasi Task (Eksekusi Coding).md
├── 5. Master Prompt - Verifikasi (Code Review & Testing).md
├── 6. Master Prompt - Menyiapkan Dokumen Spesifikasi Desain UI.md
└── Case_Nama/
    └── Flow_Bisnis_Nama.md
```
