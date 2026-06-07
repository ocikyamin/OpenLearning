# CATATAN TUTORIAL WEBINAR 4 - Kelas 182

## Integrasi API pada Aplikasi Mobile Ionic Vue

---

| **Mata Kuliah** | Pemrograman Berbasis Perangkat Bergerak |
|---|---|
| **Pemateri / Tutor** | Abdul Yamin, S.Pd., M.Kom|
| **Tanggal Pelaksanaan** | 07 Juni 2026 |
| **Tools** | Ionic 8 + Vue 3 + TypeScript + Axios |


---

## Daftar Isi

- [A. Pendahuluan](#a-pendahuluan)
- [B. Hasil Tutorial: Aplikasi Belajar API](#b-hasil-tutorial-aplikasi-belajar-api)
- [C. Panduan Mengerjakan Tugas](#c-panduan-mengerjakan-tugas)
- [D. Ringkasan](#d-ringkasan)

---

## A. Pendahuluan

### A.1 Tentang Tutorial Ini

Tutorial ini membahas cara membangun aplikasi mobile berbasis **Ionic Vue** yang dapat mengambil dan menampilkan data dari API eksternal. Selama sesi webinar, peserta diajak untuk mempraktikkan langsung pembuatan project dari awal hingga berhasil menampilkan data dari **JSONPlaceholder API**.

Catatan ini disusun sebagai bahan referensi bagi mahasiswa untuk mengerjakan tugas mandiri, yaitu membangun aplikasi serupa yang menampilkan data **cryptocurrency** dari **CoinLore API**.

### A.2 Tujuan Pembelajaran

Setelah mengikuti tutorial ini, mahasiswa diharapkan mampu:

1. Membuat project Ionic Vue dari awal menggunakan CLI.
2. Memahami struktur folder project Ionic Vue.
3. Menginstal dan menggunakan library **Axios** untuk HTTP request.
4. Membuat _service layer_ untuk memisahkan logika API dari komponen tampilan.
5. Menampilkan data dari API eksternal ke dalam antarmuka aplikasi.
6. Mengganti endpoint API dengan API lain secara mandiri.

### A.3 API yang Digunakan

#### JSONPlaceholder (untuk tutorial)

```
https://jsonplaceholder.typicode.com/todos
```

Layanan API palsu (_fake API_) gratis untuk prototyping dan pembelajaran. Menyediakan endpoint seperti `/todos`, `/posts`, `/users`, `/comments`, dan lain-lain.

#### CoinLore API (untuk tugas)

```
https://api.coinlore.net/api/tickers/
```

API publik yang menyediakan data cryptocurrency secara _real-time_ meliputi rank, nama, simbol, harga, market cap, dan lain-lain.

---

## B. Hasil Tutorial: Aplikasi Belajar API

### B.1 Gambaran Aplikasi

Aplikasi yang berhasil dibuat selama tutorial adalah aplikasi sederhana dengan fitur:

| Fitur | Keterangan |
|---|---|
| Tombol Refresh | Memicu pengambilan data dari server |
| Loading Spinner | Indikator visual selama proses pengambilan data |
| Daftar Todos | Menampilkan data dari API dalam bentuk daftar |

### B.2 Tampilan Aplikasi

![alt text](image.png)


### B.3 Struktur Project

```
belajar-api/
├── src/
│   ├── Api/
│   │   └── index.ts           ← Service API (class EndPoint)
│   ├── router/
│   │   └── index.ts           ← Konfigurasi routing
│   ├── views/
│   │   └── HomePage.vue       ← Halaman utama
│   ├── App.vue                ← Komponen akar
│   ├── main.ts                ← Entry point
│   └── theme/
│       └── variables.css      ← Tema CSS
├── package.json               ← Manifes project
├── vite.config.ts             ← Konfigurasi Vite
├── tsconfig.json              ← Konfigurasi TypeScript
└── ionic.config.json          ← Konfigurasi Ionic
```

### B.4 Penjelasan per File

#### 1. `src/Api/index.ts` — Service Layer API

```typescript
import axios from "axios";

export default class EndPoint {
    theUrl: string

    constructor(url: any) {
        this.theUrl = url
    }

    async getRes() {
        const response = await axios.get(this.theUrl);
        return response;
    }
}
```

**Peran:** Class ini bertanggung jawab untuk berkomunikasi dengan server API. Dengan memisahkan logika API ke file terpisah, kita menerapkan prinsip _Separation of Concerns_ — jika endpoint berubah, cukup edit satu file saja.

| Method | Fungsi |
|---|---|
| `constructor(url)` | Menerima dan menyimpan URL endpoint |
| `getRes()` | Melakukan HTTP GET request dan mengembalikan response |

#### 2. `src/views/HomePage.vue` — Halaman Utama

```vue
<template>
  <ion-page>
    <ion-header :translucent="true">
      <ion-toolbar>
        <ion-title>AplikasiKu</ion-title>
      </ion-toolbar>
    </ion-header>

    <ion-content :fullscreen="true">
      <div id="container">
        <ion-button @click="ambilData">
          <ion-icon :icon="refresh"></ion-icon>
          Refresh
        </ion-button>

        <ion-item v-for="todo in dataTodos" :key="todo.id">
          <ion-label>{{ todo.title }}</ion-label>
        </ion-item>

        <ion-loading
          :is-open="isLoading"
          message="Sedang Ambil Data.."
          spinner="circles"
        ></ion-loading>
      </div>
    </ion-content>
  </ion-page>
</template>

<script setup lang="ts">
import { refresh } from 'ionicons/icons'
</script>

<script lang="ts">
import { IonContent, IonHeader, IonPage, IonTitle, IonToolbar,
        IonButton, IonLoading, IonIcon, IonItem, IonLabel } from '@ionic/vue';
import { defineComponent } from 'vue';
import EndPointAccess from '@/Api';

let resData: any;

export default defineComponent({
  name: 'Home',
  data() {
    return {
      dataTodos: [],
      isLoading: false
    }
  },
  methods: {
    ambilData() {
      this.isLoading = true
      resData = new EndPointAccess('https://jsonplaceholder.typicode.com/todos');
      resData.getRes().then((response: any) => {
        this.dataTodos = response.data;
        console.log(response.data);
      }).finally(() => {
        this.isLoading = false
      });
    }
  }
});
</script>
```

**Peran:** Halaman ini adalah antarmuka pengguna. Komponen Ionic digunakan untuk membangun tampilan, dan logika pemanggilan API ada di method `ambilData()`.

| Komponen | Fungsi |
|---|---|
| `<ion-page>` | Pembungkus setiap halaman |
| `<ion-header>` | Bagian header dengan toolbar |
| `<ion-content>` | Area konten utama (dapat di-scroll) |
| `<ion-button>` | Tombol untuk trigger pengambilan data |
| `<ion-icon>` | Menampilkan icon dari ionicons |
| `<ion-item>` | Baris dalam daftar data |
| `<ion-label>` | Teks label dalam item |
| `<ion-loading>` | Indikator loading overlay |

#### 3. `src/router/index.ts` — Router

```typescript
import { createRouter, createWebHistory } from '@ionic/vue-router';
import { RouteRecordRaw } from 'vue-router';
import HomePage from '../views/HomePage.vue'

const routes: Array<RouteRecordRaw> = [
  { path: '/', redirect: '/home' },
  { path: '/home', name: 'Home', component: HomePage }
]

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes
})

export default router
```

**Peran:** Mengatur navigasi. Saat ini hanya satu halaman (`/home`), dan akses ke `/` akan diarahkan ke `/home`.

### B.5 Alur Kerja Aplikasi

```
1. Pengguna membuka aplikasi
         ↓
2. Tampilan awal: tombol Refresh + (daftar kosong)
         ↓
3. Pengguna menekan tombol Refresh
         ↓
4. isLoading = true         → spinner loading muncul
         ↓
5. new EndPointAccess(url)   → buat objek dengan URL target
         ↓
6. .getRes()                 → axios GET request ke server
         ↓
7. Server merespon           → data JSON diterima
         ↓
8. response.data             → disimpan ke dataTodos
         ↓
9. Vue mere-render ulang    → v-for menampilkan semua item
         ↓
10. isLoading = false        → spinner loading hilang
```

### B.6 Hal Penting yang Dipelajari

| Konsep | Penjelasan |
|---|---|
| **Axios GET** | Melakukan HTTP request ke server |
| **Promise .then().finally()** | Menangani response async dan cleanup |
| **data reaktif** | `data()` di Options API Vue |
| **v-for** | Looping untuk merender daftar item |
| **Komponen Ionic** | ion-button, ion-item, ion-loading, dll |
| **Separation of Concerns** | Memisahkan logika API dari tampilan |

---

## C. Soal Tugas 3

### C.1 Soal Tugas

Buatlah proyek baru untuk menampilkan data API nama-nama **cryptocurrency** yang diambil dari:

```
https://api.coinlore.net/api/tickers/
```

Tampilkan atribut berikut pada layar aplikasi:

| No | Field | Contoh Data |
|---|---|---|
| 1 | `rank` | 1 |
| 2 | `name` | Bitcoin |
| 3 | `symbol` | BTC |
| 4 | `price_usd` | 67432.12 |

### C.2 Analisis Response API CoinLore

Sebelum membuat kode, pahami terlebih dahulu struktur data yang dikembalikan oleh server. Response dari `https://api.coinlore.net/api/tickers/` berbentuk JSON seperti berikut:

```json
{
  "data": [
    {
      "id": "90",
      "symbol": "BTC",
      "name": "Bitcoin",
      "nameid": "bitcoin",
      "rank": 1,
      "price_usd": "67432.12",
      "percent_change_24h": "2.45",
      "market_cap_usd": "1324567890123.45",
      "volume24": "28912345678.90",
      "csupply": "19654321.00",
      "tsupply": "21000000.00",
      "msupply": "21000000.00"
    }
  ],
  "info": {
    "coins_num": 100,
    "time": 1723456789
  }
}
```

**Catatan penting:** Data cryptocurrency berada di dalam properti **`data`**, sehingga untuk mengaksesnya di kode perlu menggunakan `response.data.data`.

## D. Ringkasan

Dalam tutorial ini, kita telah mempelajari:

1. ✅ Membuat project Ionic Vue dengan template blank.
2. ✅ Menginstal dan menggunakan Axios untuk HTTP request.
3. ✅ Membuat _service layer_ API menggunakan class `EndPoint`.
4. ✅ Menampilkan data dari JSONPlaceholder API ke dalam tampilan aplikasi.
### E. Referensi

| Sumber | Link |
|---|---|
| Dokumentasi Ionic Vue | https://ionicframework.com/docs/vue/overview |
| Dokumentasi Axios | https://axios-http.com/docs/intro |
| JSONPlaceholder | https://jsonplaceholder.typicode.com |

---

> _Catatan ini disusun sebagai dokumentasi hasil Tutorial Webinar dan panduan pengerjaan tugas. Jika ada pertanyaan, silakan menghubungi saya melalui kelas atau forum diskusi yang telah disediakan._

> **Selamat mengerjakan Tugas 3 Ya!**
