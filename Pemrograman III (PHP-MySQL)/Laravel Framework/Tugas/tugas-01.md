# Tugas 1 — HTTP Dasar & Postman

---

## Tujuan

Mahasiswa mampu memahami konsep HTTP (method, status code, header) dan menggunakan Postman untuk menguji request/response.

---

## Soal

### 1. Eksplorasi HTTP Method

Gunakan Postman untuk melakukan request ke `https://jsonplaceholder.typicode.com/posts` dengan method berikut, lalu catat perbedaan response-nya:

| Method | Endpoint | Response |
|--------|----------|----------|
| GET | `/posts` | ? |
| GET | `/posts/1` | ? |
| POST | `/posts` | ? |
| PUT | `/posts/1` | ? |
| PATCH | `/posts/1` | ? |
| DELETE | `/posts/1` | ? |

Untuk POST, PUT, PATCH, kirim body JSON:
```json
{
  "title": "Contoh Post",
  "body": "Ini adalah isi post",
  "userId": 1
}
```

**Pertanyaan:**
- Apa perbedaan response antara GET `/posts` dan GET `/posts/1`?
- Apa perbedaan antara POST dan PUT?
- Status code apa yang dikembalikan oleh DELETE?
- Header `Content-Type` apa yang harus dikirim untuk request dengan body JSON?

### 2. Response Status Code

Buat request ke URL berikut dan catat status code serta artinya:

| URL | Status Code | Arti |
|-----|-------------|------|
| `https://httpbin.org/status/200` | | |
| `https://httpbin.org/status/301` | | |
| `https://httpbin.org/status/404` | | |
| `https://httpbin.org/status/500` | | |

### 3. Header Request & Response

Lakukan GET ke `https://jsonplaceholder.typicode.com/posts/1`.

**Header Request yang dikirim:**
- `Accept: application/json`
- `User-Agent: Tugas-Pemrograman3/1.0`

**Catat header response berikut:**
- `Content-Type`
- `x-ratelimit-limit` (atau header limit lainnya)
- `Etag` (jika ada)

### 4. Query Parameters

Gunakan Postman untuk GET ke `https://jsonplaceholder.typicode.com/posts` dengan query parameter:
- `userId=1`
- `userId=2`

Apa perbedaan hasilnya?

### 5. Simulasi Webhook

Bayangkan kamu memiliki aplikasi yang menerima data dari layanan eksternal (webhook). Lakukan POST ke `https://httpbin.org/post` dengan body JSON:

```json
{
  "event": "order_created",
  "order_id": "ORD-001",
  "customer": {
    "name": "Budi",
    "email": "budi@example.com"
  },
  "items": [
    { "product": "Laptop", "qty": 1, "price": 12000000 }
  ],
  "total": 12000000
}
```

Catat apa yang dikembalikan oleh `https://httpbin.org/post`. Perhatikan bahwa server mengembalikan data yang kita kirim — fitur ini disebut **echo server** dan berguna untuk debugging webhook.

---

## Ketentuan Pengumpulan

- Kumpulkan dalam format PDF atau dokumen (bisa screenshot Postman + penjelasan)
- Setiap nomor harus menyertakan screenshot hasil request di Postman
- Batas pengumpulan: sebelum BAB berikutnya

---

## Rubrik Penilaian

| Aspek | Bobot |
|-------|-------|
| Eksplorasi HTTP Method (6 method, perbedaan, status code) | 30% |
| Response Status Code (4 URL) | 15% |
| Header Request & Response | 20% |
| Query Parameters | 10% |
| Simulasi Webhook (body JSON, echo server) | 15% |
| Dokumentasi & kerapihan laporan | 10% |
