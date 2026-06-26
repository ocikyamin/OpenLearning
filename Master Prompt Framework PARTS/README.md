# Master Prompt Framework — Petunjuk Penggunaan

Framework ini terdiri dari 6 stage berantai untuk menyusun dan mengimplementasikan aplikasi berbasis AI. Setiap stage menggunakan output stage sebelumnya sebagai input.

---

## Alur Stage

```mermaid
graph LR
    CS[Case Study] --> S1[Stage 1<br/>PRD]
    S1 --> S2[Stage 2<br/>Tech Spec]
    S2 --> S3[Stage 3<br/>Task Breakdown]
    S3 --> S4[Stage 4<br/>Implementasi]
    S4 --> S5[Stage 5<br/>Verifikasi]
    S1 -.-> S6[Stage 6<br/>UI Design]

    S1 -.-> |Stage1_PRD.md| S2
    S2 -.-> |Stage2_TechSpec.md| S3
    S3 -.-> |Stage3_TaskList.md| S4
    S4 -.-> |Kode| S5
    S1 -.-> |Stage1_PRD.md| S6
```

```mermaid
graph TD
    subgraph Input
        CS[Case Study Bisnis]
    end
    subgraph Proses
        S1[Stage 1: PRD]
        S2[Stage 2: Tech Spec]
        S3[Stage 3: Task Breakdown]
        S4[Stage 4: Implementasi]
        S5[Stage 5: Verifikasi]
        S6[Stage 6: UI Design]
    end
    subgraph Output
        O1[Stage1_PRD.md]
        O2[Stage2_TechSpec.md]
        O3[Stage3_TaskList.md]
        O4[Kode Program]
        O5[Stage5_Verifikasi.md]
        O6[DESIGN.md]
    end

    CS --> S1
    S1 --> O1 --> S2
    S2 --> O2 --> S3
    S3 --> O3 --> S4
    S4 --> O4 --> S5
    S5 --> O5
    O1 -.-> S6
    S6 --> O6
```

---

## Cara Penggunaan

**Stage 1 — PRD**
Copy prompt `1. Master Prompt - Menyiapkan Dokumen PRD.md` ke LLM, paste case study di bagian `### Input`, simpan output sebagai `Stage1_PRD.md`

**Stage 2 — Tech Spec**
Copy prompt `2. Master Prompt - Menyiapkan Tech Specification.md`, paste `Stage1_PRD.md` di bagian `### Input`, simpan output sebagai `Stage2_TechSpec.md`

**Stage 3 — Task Breakdown**
Copy prompt `3. Master Prompt - Menyusun Task.md`, paste `Stage2_TechSpec.md`, simpan output sebagai `Stage3_TaskList.md`

**Stage 4 — Implementasi**
Buka OpenCode, gunakan template `4. Master Template - Implementasi Task.md`, kerjakan 1 task per prompt sesuai urutan di Task List

**Stage 5 — Verifikasi**
Copy prompt `5. Master Prompt - Verifikasi.md`, paste kode yang dihasilkan + bagian Tech Spec relevan

**Stage 6 — UI Design**
Copy prompt `6. Master Prompt - Menyiapkan Dokumen Spesifikasi Desain UI.md`, paste PRD atau deskripsi fitur

---

## Aturan

- Kerjakan stage **berurutan**, jangan melompat
- Setiap stage bergantung pada output stage sebelumnya
- Stage 4 berbeda — template untuk OpenCode, bukan prompt untuk chat LLM
- Jika output LLM tidak sesuai, ulangi dengan instruksi lebih spesifik, jangan lanjut ke stage berikutnya

---

## Struktur Folder

```mermaid
graph LR
    R[Master Prompt Framework PARTS] --> R1[README.md]
    R --> R2[1. Master Prompt ... PRD.md]
    R --> R3[2. Master Prompt ... Tech Spec.md]
    R --> R4[3. Master Prompt ... Task.md]
    R --> R5[4. Master Template ... Coding.md]
    R --> R6[5. Master Prompt ... Verifikasi.md]
    R --> R7[6. Master Prompt ... UI Design.md]
    R --> C[Case_Sistem_Pengaduan]
    C --> C1[Flow_Bisnis_Sistem_Pengaduan.md]
```
