# Panduan Mengajar: Perbaikan Kode `HomePage.vue`

---

## Kompetensi

Mahasiswa mampu:
- Memahami perbedaan `<script setup>` vs Options API di Vue 3
- Mengidentifikasi kesalahan umum saat mencampur kedua pendekatan
- Memperbaiki kode agar dapat mengambil data dari API dan menampilkannya dengan benar

---

## KODE ASLI (dari Modul) — Mengandung Error

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
            <tr v-for="user in dataUsers" :key="user.id">
              <td>1</td>
              <td>tes@gmail.com</td>
              <td>xxx</td>
            </tr>
          </tbody>
        </table>
      </div>
    </ion-content>
  </ion-page>
</template>

<script setup lang="ts">

import { IonContent, IonHeader, IonPage, IonTitle, IonToolbar, IonButton } from '@ionic/vue';

import { defineComponent } from 'vue';
import EndPointAccess from '@/services/EndPointAccess';

export default defineComponent({
  name: 'Home',
  data() {
    return {
      dataUsers: null
    }
  },
  methods: {
    ambilData() {
      resData = new EndPointAccess('https://jsonplaceholder.typicode.com/users');
      resData.getRes()
        .then((response: any) => (this.dataUsers = response.data))
    }
  },
  components: {
    IonContent, IonHeader, IonPage, IonTitle, IonToolbar, IonButton
  }
});
</script>
```

---

## 1. IDENTIFIKASI ERROR

### Error: Mencampur `<script setup>` dengan `export default defineComponent()`

Di Vue 3 ada **dua cara menulis komponen** yang TIDAK BOLEH dicampur:

| Fitur | `<script setup>` (Composition API) | `defineComponent` (Options API) |
|---|---|---|
| Tag script | `<script setup>` | `<script>` biasa (tanpa `setup`) |
| Data reaktif | `const data = ref(null)` | `data() { return { ... } }` |
| Method | `const fungsi = () => {}` | `methods: { fungsi() {} }` |
| Daftar komponen | Import otomatis terdaftar | `components: { ... }` harus ditulis manual |

**Kenapa error?** Ketika compiler Vue melihat `<script setup>`, ia menganggap seluruh isi script adalah **setup function**. `export default defineComponent({...})` akan **diabaikan atau error** karena Vue tidak mengharapkan export default di dalam `<script setup>`.

---

## 2. KODE YANG DIREKOMENDASIKAN

Gunakan `<script setup>` (Composition API) karena lebih ringkas dan merupakan standar Vue 3 modern.

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

---

## 3. TABEL PERBANDINGAN

| Bagian | Kode Asli (Salah) | Kode Rekomendasi (Benar) |
|---|---|---|
| Tag script | `<script setup>` + `export default defineComponent()` | `<script setup>` SAJA, tanpa export default |
| Data reaktif | `data() { return { dataUsers: null } }` | `const dataUsers = ref<any>(null)` |
| Method | `methods: { ambilData() { ... } }` | `const ambilData = async () => { ... }` |
| Akses data di method | `this.dataUsers = ...` | `dataUsers.value = ...` |
| Daftar komponen | `components: { IonContent, ... }` | Tidak perlu — import otomatis terdaftar |
| Async request | `.then()` callback | `async / await` (lebih bersih) |

---

## 4. PENJELASAN PER KONSEP

### 4.1 `ref()` — Membuat Data Reaktif

```ts
const dataUsers = ref<any>(null)
```

- `ref()` dari Vue 3 membuat variabel menjadi **reaktif** (ubah nilainya → template otomatis update)
- Di dalam `<script>`, nilai diakses/diubah dengan `.value`
- Di dalam `<template>`, `.value` **tidak perlu** ditulis (otomatis di-unwrap)

### 4.2 `v-for` dengan `index`

```html
<tr v-for="(user, index) in dataUsers" :key="user.id">
  <td>{{ index + 1 }}</td>
```

- `(user, index)` mengambil nilai elemen **dan** indeksnya (mulai 0)
- `{{ index + 1 }}` menghasilkan nomor urut 1, 2, 3, ...

### 4.3 Optional Chaining `?.`

```html
{{ user.company?.name }}
```

- `?.` = **optional chaining** — aman jika `company` bernilai `null` / `undefined`
- Tanpa `?.` akan error: `Cannot read properties of null`

### 4.4 `async / await`

```ts
const ambilData = async () => {
  const access = new EndPointAccess('https://jsonplaceholder.typicode.com/users')
  const response = await access.getRes()
  dataUsers.value = response.data
}
```

- `async` menandakan fungsi ini asynchronous (mengembalikan Promise)
- `await` menunggu Promise selesai, lalu melanjutkan eksekusi
- Lebih mudah dibaca dibanding `.then().catch()`

---

## 5. STRUKTUR DATA DARI API

Endpoint: `https://jsonplaceholder.typicode.com/users`

Response (array of object):
```json
[
  {
    "id": 1,
    "name": "Leanne Graham",
    "email": "Sincere@april.biz",
    "company": {
      "name": "Romaguera-Crona"
    }
  },
  ...
]
```

Maka di template:
- `user.email` → `"Sincere@april.biz"`
- `user.company.name` → `"Romaguera-Crona"`
- `user.company?.name` → aman jika `company` tidak ada

---

## 6. KESIMPULAN UNTUK MAHASISWA

1. **Jangan mencampur** `<script setup>` dengan `export default defineComponent()` — pilih salah satu
2. Di `<script setup>`: pakai `ref()` untuk data reaktif, `const fungsi` untuk method
3. `async / await` lebih modern dan mudah dibaca daripada `.then().then()`
