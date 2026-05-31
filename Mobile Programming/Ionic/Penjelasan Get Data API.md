# Perbaikan `HomePage.vue` — Penjelasan

## Masalah Utama: Mencampur `<script setup>` dengan Options API

Di Vue 3, ada **dua cara** menulis komponen:

| Pendekatan | Cara |
|---|---|
| **Composition API** (`<script setup>`) | Deklarasi langsung variabel/fungsi di top-level, **tanpa** `export default` |
| **Options API** (`defineComponent`) | Pakai `data()`, `methods`, `computed` dll. di dalam `export default` |

Kode awal kamu mencampur keduanya: menggunakan `<script setup>` **sekaligus** `export default defineComponent({...})`. Ini menyebabkan error/kegagalan kompilasi.

---

## Pendekatan A — Composition API (`<script setup>`) ✅ Direkomendasikan

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
/* ... style tetap sama ... */
</style>
```

### Penjelasan kode:

| Baris | Penjelasan |
|---|---|
| `import { ref } from 'vue'` | `ref()` membuat variabel reaktif. Nilainya diakses/diubah lewat `.value` (tapi di template otomatis di-unwrap) |
| `const dataUsers = ref<any>(null)` | Data reaktif untuk menyimpan array users dari API |
| `const ambilData = async () => { ... }` | Fungsi async (menggantikan `methods`) — langsung bisa dipanggil di template via `@click` |
| `dataUsers.value = response.data` | Mengisi data reaktif dengan hasil dari API |
| Component imports | Semua komponen Ionic yang di-import langsung tersedia di template (tidak perlu `components: {}`) |

### Kenapa data di tabel masih statis?

Di `<tbody>` kita pakai `v-for` dan `{{ }}` untuk menampilkan data **dinamis** dari `dataUsers`:

```html
<td>{{ index + 1 }}</td>       <!-- nomor urut otomatis -->
<td>{{ user.email }}</td>      <!-- email dari API -->
<td>{{ user.company?.name }}</td>  <!-- nama company, pakai ?. kalau null -->
```

---

## Pendekatan B — Options API (tanpa `<script setup>`)

```vue
<template>
  <!-- template SAMA seperti di atas -->
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
/* ... style tetap sama ... */
</style>
```

### Perbedaan dengan `<script setup>`:

| Options API | `<script setup>` |
|---|---|
| `data()` return objek → `this.dataUsers` | `const dataUsers = ref()` → `dataUsers.value` |
| `methods: { ambilData() { ... } }` → `this.ambilData()` | `const ambilData = () => {}` → langsung `ambilData` |
| `components: { ... }` harus di-declare | Import otomatis jadi komponen |
| `defineComponent` memberi type inference lebih baik | Lebih ringkas, kurang boilerplate |

---

## Ringkasan

1. Hapus `// <4>` dan `// <5>` — itu bukan kode, sepertinya penanda saja
2. Hapus `let resData: any;` — variabel ini tidak perlu, buat instance `EndPointAccess` langsung di dalam fungsi
3. Pilih **satu** pendekatan: Composition API (`<script setup>`) **atau** Options API — jangan campur
4. Gunakan `v-for` dengan `{{ }}` untuk menampilkan data dari API, bukan hardcode
