
> # AJAX Simpan Complaint

```javascript

$('#form-complaint').submit(function (e) { 
    e.preventDefault();
    // Reset Error
    $('.form-control').removeClass('is-invalid');
    $('.invalid-feedback').text('');
 
    let formData = new FormData(this);
 
    $.ajax({
        type: "post",
        url: "<?= base_url('user/komplaint/buat') ?>",
        data: formData,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function (response) {
            if (response.status==true) {
                // Tampilkan notifikasi sukses
                Notiflix.Notify.success(response.message);
                $('#form-complaint')[0].reset();
            } else {
                // Tampilkan error per field
                $.each(response, function (field, pesan) { 
                    if (field !== "status") {
                        $('#'+field).addClass('is-invalid');
                        $('#'+field).siblings('.invalid-feedback').text(pesan);
                    }
                });
            }
        },
        error: function(){
            Notiflix.Notify.failure('Terjadi kesalahan server.');
        }
    });
});
```

> # Untuk Simpan Komplaint

```php
// Simpan & Update Complaint
function ComplaintStore()
{
    if ($this->request->isAJAX()) {

        $validation = \Config\Services::validation();

        // ========= PERUBAHAN: Tambah ID untuk deteksi edit =========
        $id = $this->request->getPost('id'); // Jika ada ID berarti edit

        // Atur rules validasi
        $validate = $this->validate([
            'title' => [
                'label' => 'Judul Komplain',
                'rules' => 'required|min_length[5]|max_length[255]',
                'errors' => [
                    'required'   => '{field} Wajib Diisi',
                    'min_length' => '{field} Minimal 5 Karakter',
                    'max_length' => '{field} Maksimal 255 Karakter',
                ],
            ],
            'description' => [
                'label' => 'Deskripsi',
                'rules' => 'required|min_length[10]',
                'errors' => [
                    'required'   => '{field} Wajib Diisi',
                    'min_length' => '{field} Minimal 10 Karakter',
                ],
            ],

            // ========= PERUBAHAN: Lampiran opsional untuk edit =========
            // Jika edit, user boleh tidak upload ulang lampiran
            'attachment' => [
                'label' => 'Lampiran',
                'rules' => 'permit_empty|max_size[attachment,2048]|ext_in[attachment,png,jpg,jpeg,pdf,doc,docx]',
                'errors' => [
                    'max_size' => '{field} Maksimal 2MB',
                    'ext_in'   => 'Format {field} Tidak Didukung',
                ],
            ],
        ]);

        if (!$validate) {
            $response = [
                'status'      => false,
                'title'       => $validation->getError('title'),
                'description' => $validation->getError('description'),
                'attachment'  => $validation->getError('attachment'),
            ];
        } else {

            // ========= PERUBAHAN: Ambil data lama jika edit =========
            $oldData = null;
            if ($id) {
                $oldData = $this->complaintM->find($id);
            }

            // Proses upload lampiran (opsional)
            $attachmentName = $oldData['attachment'] ?? null; // <-- tetap pakai lampiran lama
            $attachment = $this->request->getFile('attachment');

            if ($attachment && $attachment->isValid() && !$attachment->hasMoved()) {

                // Jika edit & ada file lama → hapus file lama
                if ($id && $oldData && !empty($oldData['attachment'])) {
                    $path = ROOTPATH . 'public/uploads/complaints/' . $oldData['attachment'];
                    if (file_exists($path)) unlink($path);
                }

                // Upload file baru
                $attachmentName = $attachment->getRandomName();
                $attachment->move(ROOTPATH . 'public/uploads/complaints', $attachmentName);
            }

            // ========= PERUBAHAN: Gunakan save() untuk insert/update =========
            $this->complaintM->save([
                'id'          => $id, // ID kosong = insert | ada ID = update
                'user_id'     => session()->get('user_id'),
                'title'       => $this->request->getPost('title'),
                'description' => $this->request->getPost('description'),
                'attachment'  => $attachmentName,

                // created_at hanya untuk insert
                'created_at'  => $id ? $oldData['created_at'] : date('Y-m-d H:i:s'),

                // updated_at selalu diperbarui
                'updated_at'  => date('Y-m-d H:i:s'),
            ]);

            $response = [
                'status'  => true,

                // ========= PERUBAHAN: Pesan sukses disesuaikan =========
                'message' => $id ? 'Komplain berhasil diperbarui' : 'Komplain berhasil dibuat',
            ];
        }

        return $this->response->setJSON($response);
    }
}


```
> # Ajax Hapus Data Komplaint (diperbarui)
``` javascript

function HapusComplaint(id) {

    Notiflix.Confirm.show(
        'Konfirmasi Hapus Data',
        'Apakah Anda yakin ingin menghapus data ini?',
        'Ya, Hapus',
        'Batal',

        // ✔ Jika tombol "Ya" ditekan
        function okCb() {

            $.ajax({
                type: "POST",
                url: "<?= base_url('user/komplaint/delete') ?>",
                data: { id: id },
                dataType: "json",

                beforeSend: function() {
                    Notiflix.Loading.circle('Menghapus...');
                },

                success: function(response) {
                    Notiflix.Loading.remove();

                    if (response.status === true) {
                        Notiflix.Notify.success(response.msg);
                        setTimeout(() => {
                            window.location.reload();
                        }, 800);
                    } else {
                        // ✔ Jika gagal
                        Notiflix.Notify.failure(response.msg || 'Gagal menghapus data');
                    }
                },

                error: function(xhr) {
                    Notiflix.Loading.remove();
                    Notiflix.Notify.failure('Terjadi kesalahan pada server');
                }
            });

        },

        // ❌ Jika klik tombol "Batal"
        function cancelCb() {
            Notiflix.Notify.info('Aksi dibatalkan');
        }
    );
}



```

> # Proses Hapus Data (diperbarui)
```php

public function ComplainDelete()
{
    if ($this->request->isAJAX()) {

        $id = $this->request->getPost('id');

        // Pastikan ID tidak kosong
        if (!$id) {
            return $this->response->setJSON([
                'status' => false,
                'msg'    => 'ID tidak ditemukan'
            ]);
        }

        // Cek apakah data benar-benar ada
        $data = $this->complaintM->find($id);
        if (!$data) {
            return $this->response->setJSON([
                'status' => false,
                'msg'    => 'Data tidak ditemukan'
            ]);
        }

        // Jika ada lampiran, hapus fisiknya juga
        if (!empty($data['attachment'])) {
            $path = ROOTPATH . 'public/uploads/complaints/' . $data['attachment'];
            if (file_exists($path)) {
                unlink($path); // hapus file
            }
        }

        // Hapus data di database
        if ($this->complaintM->delete($id)) {
            return $this->response->setJSON([
                'status' => true,
                'msg'    => 'Data berhasil dihapus'
            ]);
        }

        return $this->response->setJSON([
            'status' => false,
            'msg'    => 'Gagal menghapus data'
        ]);
    }
}

```
