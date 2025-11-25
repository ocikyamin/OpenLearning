
> # Coding AJAX Simpan Complaint

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

> # Coding Untuk Simpan Komplaint

```php

if ($this->request->isAJAX()) {
    $validation = \Config\Services::validation();
 
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
        // Lampiran opsional, validasi hanya jika ada file
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
        $attachmentName = null;
        $attachment = $this->request->getFile('attachment');
        if ($attachment && $attachment->isValid() && !$attachment->hasMoved()) {
            $attachmentName = $attachment->getRandomName();
            $attachment->move(ROOTPATH . 'public/uploads/complaints', $attachmentName);
        }
 
        $this->complaintModel->save([
            'user_id'     => session()->get('user_id'),
            'title'       => $this->request->getPost('title'),
            'description' => $this->request->getPost('description'),
            'attachment'  => $attachmentName,
            'status'      => 'baru',
            'created_at'  => date('Y-m-d H:i:s'),
            'updated_at'  => date('Y-m-d H:i:s'),
        ]);
 
        $response = [
            'status'  => true,
            'message' => 'Komplain berhasil dibuat',
        ];
    }
 
    return $this->response->setJSON($response);

```