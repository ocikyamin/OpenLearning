# Materi Lengkap: Komponen Vue 3 dengan Ionic + Axios

**Mata Kuliah:** Pemrograman Mobile / Frameworks
**Topik:** Mengambil data dari API dan menampilkan dengan tabel di Ionic Vue 3

---

## DAFTAR ISI

1. [Tujuan](#1-tujuan)
2. [Sekilas tentang Vue 3](#2-sekilas-tentang-vue-3)
3. [Kesalahan Umum: Mencampur Pendekatan](#3-kesalahan-umum-mencampur-pendekatan)
4. [Service EndPointAccess](#4-service-endpointaccess)
5. [Opsi A — Composition API (`<script setup>`)](#5-opsi-a--composition-api-script-setup)
6. [Opsi B — Options API (`defineComponent`)](#6-opsi-b--options-api-definecomponent)
7. [Perbandingan Lengkap Opsi A vs Opsi B](#7-perbandingan-lengkap-opsi-a-vs-opsi-b)
8. [Rekomendasi dan Alasannya](#8-rekomendasi-dan-alasannya)
9. [Konsep Penting](#9-konsep-penting)
10. [Latihan](#10-latihan)
11. [Kesimpulan](#11-kesimpulan)

---

## 1. TUJUAN

Setelah mempelajari materi ini, mahasiswa mampu:

- Memahami dua cara menulis komponen di Vue 3: **Composition API** dan **Options API**
- Membuat komponen yang mengambil data dari REST API menggunakan Axios
- Menampilkan data dalam bentuk tabel HTML dengan binding dinamis
- Memilih pendekatan yang tepat sesuai kebutuhan proyek

---

## 2. SEKILAS TENTANG VUE 3

Vue 3 memperkenalkan **Composition API** sebagai alternatif dari **Options API** (yang sudah ada sejak Vue 2). Keduanya bisa dipakai, tetapi memiliki sintaks dan cara kerja yang berbeda.

### Options API (Cara Lama)

```ts
export default defineComponent({
  data() { return { ... } },
  methods: { ... },
  components: { ... }
})
```

### Composition API (Cara Baru)

```ts
<script setup>
const data = ref(null)
const fungsi = () => { ... }
</script>
```

Keduanya valid dan bisa digunakan. Yang penting: **pilih salah satu, jangan dicampur.**

---

## 3. KESALAHAN UMUM: MENCAMPUR PENDEKATAN

Kesalahan yang sering terjadi adalah menggabungkan `<script setup>` (Composition API) dengan `export default defineComponent()` (Options API) dalam satu file.

### ❌ SALAH

```vue
<script setup lang="ts">
import { defineComponent } from 'vue'

export default defineComponent({
  data() { ... },
  methods: { ... }
})
</script>
```

**Kenapa error?** Compiler Vue mendeteksi atribut `setup` pada tag script, sehingga semua isi script diperlakukan sebagai setup function. `export default defineComponent()` tidak dikenali dan menyebabkan error kompilasi.

### ✅ BENAR

**Opsi A — Composition API:**
```vue
<script setup lang="ts">
// langsung pakai ref(), fungsi, dll — tanpa export default
</script>
```

**Opsi B — Options API:**
```vue
<script lang="ts">
import { defineComponent } from 'vue'
export default defineComponent({ ... })
</script>
```

---

## 4. SERVICE `EndPointAccess`

Sebelum masuk ke komponen, pahami dulu service yang digunakan untuk mengambil data dari API.

**File:** `src/services/EndPointAccess/index.ts`

```ts
import axios from 'axios';

export default class EndPointAccess {
  theUrl: string;

  constructor(url: string) {
    this.theUrl = url;
  }

  async getRes() {
    const response = await axios.get(this.theUrl);
    return response;
  }
}
```

### Penjelasan

| Kode | Penjelasan |
|---|---|
| `import axios from 'axios'` | Library HTTP client untuk request ke API |
| `class EndPointAccess` | Class khusus untuk mengakses endpoint tertentu |
| `constructor(url)` | Menerima URL endpoint saat class dibuat |
| `async getRes()` | Method async yang melakukan GET request dan mengembalikan response |

### Contoh pemakaian

```ts
const access = new EndPointAccess('https://jsonplaceholder.typicode.com/users')
const response = await access.getRes()
console.log(response.data) // array of users
```

---

## 5. OPSI A — Composition API (`<script setup>`)

### Kode Lengkap

```vue
<template>
  <ion-page>
    <ion-header :translucent="true">
      <ion-toolbar>
        <ion-title>User API</ion-title>
      </ion-toolbar>
    </ion-header>

    <ion-content :fullscreen="true">
      <ion-header collapse="condense">
        <ion-toolbar>
          <ion-title size="large">GET Users</ion-title>
        </ion-toolbar>
      </ion-header>

      <div id="container">
        <p><h6>Daftar Users</h6></p>
        <p>
          <ion-button @click="ambilData" class="btn-refresh">Get Data</ion-button>
        </p>

        <table class="center">
          <thead>
            <tr>
              <th>No</th>
              <th>Email</th>
              <th>Company</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(user, index) in dataUsers" :key="user.id">
              <td>{{ index + 1 }}</td>
              <td>{{ user.email }}</td>
              <td>{{ user.company?.name }}</td>
            </tr>
          </tbody>
        </table>
      </div>
    </ion-content>
  </ion-page>
</template>

<script setup lang="ts">
import { ref } from 'vue'
import {
  IonContent, IonHeader, IonPage,
  IonTitle, IonToolbar, IonButton
} from '@ionic/vue'
import EndPointAccess from '@/services/EndPointAccess'

const dataUsers = ref<any>(null)

const ambilData = async () => {
  const access = new EndPointAccess('https://jsonplaceholder.typicode.com/users')
  const response = await access.getRes()
  dataUsers.value = response.data
}
</script>

<style scoped>
#container {
  text-align: center;
  position: absolute;
  left: 0;
  right: 0;
  top: 50%;
  transform: translateY(-50%);
}
#container strong {
  font-size: 20px;
  line-height: 26px;
}
#container p {
  font-size: 16px;
  line-height: 22px;
  color: #8c8c8c;
  margin: 0;
}
#container a {
  text-decoration: none;
}
.center {
  margin-left: auto;
  margin-right: auto;
}
.btn-refresh {
  margin-bottom: 20px;
}
</style>
```

### Analisis Kode

#### Bagian Template
```html
<ion-button @click="ambilData" class="btn-refresh">Get Data</ion-button>
```
- `@click` mendengarkan event klik
- Saat tombol diklik, fungsi `ambilData()` dipanggil

```html
<tr v-for="(user, index) in dataUsers" :key="user.id">
  <td>{{ index + 1 }}</td>
  <td>{{ user.email }}</td>
  <td>{{ user.company?.name }}</td>
</tr>
```
- `v-for` melakukan looping array `dataUsers`
- `(user, index)` — `user` adalah setiap elemen, `index` adalah nomor urut (mulai 0)
- `{{ index + 1 }}` menampilkan nomor urut (1, 2, 3, ...)
- `{{ user.email }}` menampilkan email dari API
- `{{ user.company?.name }}` menampilkan nama perusahaan, `?.` aman jika `company` null
- `:key="user.id"` wajib untuk performa rendering

#### Bagian Script
```ts
import { ref } from 'vue'
```
- `ref` adalah fungsi dari Vue untuk membuat data reaktif

```ts
const dataUsers = ref<any>(null)
```
- Variabel reaktif `dataUsers` dengan nilai awal `null`
- Nanti diisi dengan array users dari API
- Di template dipanggil langsung sebagai `dataUsers` (tanpa `.value`)

```ts
const ambilData = async () => {
  const access = new EndPointAccess('https://jsonplaceholder.typicode.com/users')
  const response = await access.getRes()
  dataUsers.value = response.data
}
```
- `async` — fungsi asynchronous
- `await` — menunggu Promise selesai
- `dataUsers.value = response.data` — mengisi data reaktif

#### Catatan Penting
- `components: {}` **tidak perlu** — komponen yang di-import otomatis terdaftar
- Tidak ada `export default`
- Semua variabel/fungsi di top-level script bisa langsung dipakai di template

---

## 6. OPSI B — Options API (`defineComponent`)

### Kode Lengkap

```vue
<template>
  <ion-page>
    <ion-header :translucent="true">
      <ion-toolbar>
        <ion-title>User API</ion-title>
      </ion-toolbar>
    </ion-header>

    <ion-content :fullscreen="true">
      <ion-header collapse="condense">
        <ion-toolbar>
          <ion-title size="large">GET Users</ion-title>
        </ion-toolbar>
      </ion-header>

      <div id="container">
        <p><h6>Daftar Users</h6></p>
        <p>
          <ion-button @click="ambilData" class="btn-refresh">Get Data</ion-button>
        </p>

        <table class="center">
          <thead>
            <tr>
              <th>No</th>
              <th>Email</th>
              <th>Company</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(user, index) in dataUsers" :key="user.id">
              <td>{{ index + 1 }}</td>
              <td>{{ user.email }}</td>
              <td>{{ user.company?.name }}</td>
            </tr>
          </tbody>
        </table>
      </div>
    </ion-content>
  </ion-page>
</template>

<script lang="ts">
import { defineComponent } from 'vue'
import {
  IonContent, IonHeader, IonPage,
  IonTitle, IonToolbar, IonButton
} from '@ionic/vue'
import EndPointAccess from '@/services/EndPointAccess'

export default defineComponent({
  name: 'Home',
  data() {
    return {
      dataUsers: null as any
    }
  },
  methods: {
    async ambilData() {
      const access = new EndPointAccess('https://jsonplaceholder.typicode.com/users')
      const response = await access.getRes()
      this.dataUsers = response.data
    }
  },
  components: {
    IonContent, IonHeader, IonPage,
    IonTitle, IonToolbar, IonButton
  }
})
</script>

<style scoped>
#container {
  text-align: center;
  position: absolute;
  left: 0;
  right: 0;
  top: 50%;
  transform: translateY(-50%);
}
#container strong {
  font-size: 20px;
  line-height: 26px;
}
#container p {
  font-size: 16px;
  line-height: 22px;
  color: #8c8c8c;
  margin: 0;
}
#container a {
  text-decoration: none;
}
.center {
  margin-left: auto;
  margin-right: auto;
}
.btn-refresh {
  margin-bottom: 20px;
}
</style>
```

### Analisis Kode

#### Bagian Script
```ts
import { defineComponent } from 'vue'
```
- Fungsi utilitas dari Vue untuk mendefinisikan komponen dengan type inference yang baik

```ts
export default defineComponent({
  name: 'Home',
```
- `export default` — mengekspor komponen sebagai default
- `defineComponent()` — membungkus objek konfigurasi
- `name: 'Home'` — nama komponen (berguna untuk debugging)

```ts
data() {
  return {
    dataUsers: null as any
  }
},
```
- `data()` adalah fungsi yang mengembalikan objek berisi data reaktif
- `dataUsers: null as any` — data awal null, `as any` untuk TypeScript
- Data diakses dengan `this.dataUsers`

```ts
methods: {
  async ambilData() {
    const access = new EndPointAccess('https://jsonplaceholder.typicode.com/users')
    const response = await access.getRes()
    this.dataUsers = response.data
  }
},
```
- `methods` — tempat mendefinisikan fungsi-fungsi komponen
- `ambilData()` dipanggil dari template via `@click="ambilData"`
- Data diisi dengan `this.dataUsers = response.data`

```ts
components: {
  IonContent, IonHeader, IonPage,
  IonTitle, IonToolbar, IonButton
}
```
- Semua komponen Ionic harus didaftarkan secara eksplisit di sini
- Jika lupa mendaftarkan, komponen tidak akan dikenali di template

---

## 7. PERBANDINGAN LENGKAP OPSI A VS OPSI B

### 7.1 Perbandingan Sintaks

| Aspek | Opsi A (Composition API) | Opsi B (Options API) |
|---|---|---|
| Tag script | `<script setup lang="ts">` | `<script lang="ts">` |
| Export | Tidak perlu | `export default defineComponent({...})` |
| Deklarasi data | `const data = ref(null)` | `data() { return { data: null } }` |
| Akses data di script | `data.value` | `this.data` |
| Akses data di template | `data` (auto unwrap) | `data` |
| Fungsi | `const fn = () => {}` | `methods: { fn() {} }` |
| Daftar komponen | Tidak perlu (otomatis) | `components: { ... }` |
| Type safety | Baik | Baik (dengan `defineComponent`) |
| Import `ref` | Wajib `import { ref } from 'vue'` | Tidak perlu |

### 7.2 Perbandingan Jumlah Kode

| Bagian | Opsi A | Opsi B |
|---|---|---|
| Import | 6 baris | 7 baris |
| Script (isi) | 7 baris | 20 baris |
| Total script | ~13 baris | ~27 baris |

### 7.3 Perbandingan Konsep

| Konsep | Opsi A | Opsi B |
|---|---|---|
| Reaktivitas | `ref()` / `reactive()` | `data()` otomatis |
| Lifecycle | `onMounted()`, `onUpdated()` | `mounted()`, `updated()` |
| Computed | `computed()` | `computed: {}` |
| Watcher | `watch()` | `watch: {}` |
| Props | `defineProps()` | `props: {}` |
| Emit | `defineEmits()` | `emits: []` + `this.$emit()` |
| Composition | Bisa dibagi ke file terpisah (composable) | Harus dalam satu komponen |

---

## 8. REKOMENDASI DAN ALASANNYA

### 8.1 Kapan Memakai Opsi A (Composition API)?

**✅ Direkomendasikan untuk:**

1. **Proyek baru Vue 3**
   - Alasan: Composition API adalah standar resmi Vue 3. Semua fitur baru dikembangkan untuk pendekatan ini.

2. **Kode yang lebih bersih dan ringkas**
   - Alasan: Tidak perlu `data()`, `methods`, `components` — cukup deklarasi langsung. Script bisa 50% lebih pendek.

3. **Logika kompleks yang perlu dibagi**
   - Alasan: Composition API memungkinkan ekstraksi logika ke file terpisah (composable) dengan mudah, misalnya:
     ```ts
     // useUsers.ts
     export function useUsers() {
       const data = ref(null)
       const ambil = async () => { ... }
       return { data, ambil }
     }
     ```
     ```ts
     // HomePage.vue
     import { useUsers } from './useUsers'
     const { data, ambil } = useUsers()
     ```

4. **TypeScript yang lebih baik**
   - Alasan: Type inference lebih akurat dengan Composition API dibanding Options API.

5. **Masa depan**
   - Alasan: Vue 4 kemungkinan besar hanya mendukung Composition API.

### 8.2 Kapan Memakai Opsi B (Options API)?

**⚠️ Bisa dipakai untuk:**

1. **Migrasi dari Vue 2**
   - Alasan: Familiar bagi developer yang sudah terbiasa dengan Vue 2. Sintaks `data()`, `methods`, `computed` sama persis.

2. **Modul praktikum atau kurikulum yang sudah ada**
   - Alasan: Jika silabus sudah dibuat dengan Options API, konsistensi lebih penting daripada kebaruan.

3. **Tim yang belum siap beralih**
   - Alasan: Options API lebih eksplisit dan terstruktur — setiap bagian (data, methods, computed) ada tempatnya sendiri.

4. **Proyek sederhana**
   - Alasan: Untuk komponen kecil, perbedaan panjang kode tidak signifikan.

### 8.3 Tabel Rekomendasi

| Skenario | Pilihan | Alasan |
|---|---|---|
| Proyek baru | Opsi A | Standar Vue 3, fitur terbaru |
| Migrasi Vue 2 → 3 | Opsi B (sementara) | Transisi bertahap |
| Modul praktikum | Opsi B (jika modul pakai itu) | Konsistensi materi |
| Mahasiswa baru Vue | Opsi A | Belajar yang benar dari awal |
| Aplikasi kompleks | Opsi A | Composable, lebih terkelola |
| Komponen 1 halaman | Opsi A atau B sama | Tidak signifikan |

### 8.4 Saran untuk Pengajaran

Untuk pembelajaran di kelas, saran pendekatan bertahap:

1. **Pertemuan 1-2:** Ajarkan **Opsi B (Options API)** karena lebih eksplisit — mahasiswa bisa melihat dengan jelas mana `data`, `methods`, `components`
2. **Pertemuan 3-4:** Perkenalkan **Opsi A (Composition API)** sebagai penyempurnaan — tunjukkan bagaimana kode yang sebelumnya 27 baris bisa jadi 13 baris
3. **Pertemuan 5+:** Minta mahasiswa memilih sendiri pendekatan yang sesuai untuk tugas mereka

Dengan cara ini, mahasiswa memahami **dua paradigm** dan bisa memilih yang tepat.

---

## 9. KONSEP PENTING

### 9.1 `ref()` — Reaktivitas

```ts
const dataUsers = ref<any>(null)
```

- `ref()` membungkus nilai agar menjadi **reaktif**
- Reactif = jika nilai berubah, Vue otomatis memperbarui template
- Di dalam `<script>`: akses dengan `.value`
- Di dalam `<template>`: **tidak perlu** `.value` (auto-unwrap)

### 9.2 `v-for` dan `:key`

```html
<tr v-for="(user, index) in dataUsers" :key="user.id">
```

- `v-for` melakukan iterasi array
- `(user, index)` = nilai + indeks (mulai 0)
- `:key` harus unik untuk setiap item (pakai `user.id`)

### 9.3 Optional Chaining `?.`

```html
{{ user.company?.name }}
```

- Jika `company` tidak ada (undefined/null), tidak error — hasilnya `undefined` (template diam)
- Tanpa `?.`: `user.company.name` akan error jika `company` null

### 9.4 `async / await`

```ts
const ambilData = async () => {
  const response = await access.getRes()
  dataUsers.value = response.data
}
```

- `async` = fungsi mengembalikan Promise
- `await` = tunggu Promise selesai, baru lanjut ke baris berikutnya
- Alternatif dengan `.then()`:
  ```ts
  const ambilData = () => {
    access.getRes().then(response => {
      dataUsers.value = response.data
    })
  }
  ```
- `async / await` lebih mudah dibaca (seperti kode synchronous)

### 9.5 Binding dengan `{{ }}`

```html
<td>{{ index + 1 }}</td>
```

- `{{ }}` = text interpolation
- Isinya bisa ekspresi JavaScript sederhana
- Bukan hardcode — nilainya diambil dari data Vue

### 9.6 Scoped Style

```vue
<style scoped>
```

- `scoped` = CSS hanya berlaku untuk komponen ini
- Tidak bocor ke komponen lain
- Best practice untuk menghindari konflik styling

---

## 10. LATIHAN

### Latihan 1: Memperbaiki Kode

Kode berikut error. Identifikasi dan perbaiki.

```vue
<script setup lang="ts">
export default defineComponent({
  data() {
    return { message: 'Hello' }
  }
})
</script>
```

**Jawaban:** Campur `<script setup>` dengan `export default`. Pilih salah satu:
- Hapus `setup` → `<script lang="ts">`
- Atau hapus `export default defineComponent` → langsung `const message = ref('Hello')`

### Latihan 2: Menambah Field

Tambahkan kolom **Nama** dan **Telepon** pada tabel (data dari API: `user.name` dan `user.phone`).

### Latihan 3: Ganti Pendekatan

Ambil kode Opsi A, ubah ke Opsi B (atau sebaliknya).

### Latihan 4: Buat Composable

Opsi A: Ekstrak logika `ambilData` ke file terpisah `composables/useUsers.ts`.

---

## 11. KESIMPULAN

1. **Vue 3 punya 2 pendekatan:** Composition API (Opsi A) dan Options API (Opsi B)
2. **Jangan dicampur:** Pilih salah satu dalam satu file
3. **Composition API** lebih ringkas, modern, dan direkomendasikan untuk proyek baru
4. **Options API** lebih eksplisit, cocok untuk migrasi dan pembelajaran awal
5. **`ref()`** membuat data reaktif — di template tanpa `.value`
6. **`v-for` + `:key`** untuk looping array dengan performa optimal
7. **`async / await`** lebih bersih daripada Promise chain
8. **Optional chaining `?.`** mencegah error saat properti tidak ada
9. **Template binding `{{ }}`** menampilkan data dinamis, bukan hardcode
10. **Scoped style** menjaga CSS tetap lokal per komponen

---

*Dokumen ini bisa digunakan sebagai bahan ajar dan referensi mahasiswa.*
