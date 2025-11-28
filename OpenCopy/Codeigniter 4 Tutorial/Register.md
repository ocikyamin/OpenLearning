> # Ajax Register
```javascript

   $('#form-register').submit(function (e) { 
        e.preventDefault();
        // Reset Error
        $('.form-control').removeClass('is-invalid')
        $('.invalid-feedback').text('');

        $.ajax({
          type: "post",
          url: "<?=base_url('register/proses')?>",
          data: $(this).serialize(),
          dataType: "json",
          success: function (response) {
            if (response.status==true) {
              Notiflix.Notify.success(response.msg);
              // alert('Pendaftaran Akun berhasil')
            }else{
              $.each(response, function (field, pesan) { 
                 if (field !=="status") {
                  // Tambahkan Error ke inputan
                  $('#'+field).addClass('is-invalid');
                  // Tampilkan pesan invalid-feedback
                  $('#'+field).siblings('.invalid-feedback').text(pesan)
                 }
              });

              // alert('Pendaftaran Akun Gagal')

            }
            // console.log(response)
          }
        });
        
        
      });
```

> # Kode Proses Register
  
  ```php
  // Proses Registrasi
    function RegisterProses() {
        if ($this->request->isAJAX()) {
            // Panggil fungsi validasi
            $this->validate = \Config\Services::validation();
            // Atur Rules 
            $validate = $this->validate(
                [
                    'username'=>[
                    'label'=> 'Username',
                    'rules'=> 'required|max_length[60]',
                    'errors'=> [
                        'required'=> '{field} Wajib Diisi',
                        'max_length'=> '{field} Maksimal 60 Karakter',
                    ]
                    ],
                    'email'=>[
                    'label'=> 'Email',
                    'rules'=> 'required|valid_email|max_length[60]|is_unique[users.email]',
                    'errors'=> [
                        'required'=> '{field} Wajib Diisi',
                        'valid_email'=> 'Format {field} Tidak sesuai',
                        'max_length'=> '{field} Maksimal 60 Karakter',
                        'is_unique'=> '{field} Telah Digunakan',
                    ]
                    ],
                    'new_password'=>[
                    'label'=> 'Password Baru',
                    'rules'=> 'required|max_length[30]',
                    'errors'=> [
                        'required'=> '{field} Wajib Diisi',
                        'max_length'=> '{field} Maksimal 30 Karakter',
                    ]
                    ],
                    'conf_password'=>[
                    'label'=> 'Konfirmasi Password ',
                    'rules'=> 'required|max_length[30]|matches[new_password]',
                    'errors'=> [
                        'required'=> '{field} Wajib Diisi',
                        'max_length'=> '{field} Maksimal 30 Karakter',
                        'matches'=> '{field} Tidak Sesuai',
                    ]
                    ],
                 ]

            );

            // Cek Validasi
            if (!$validate) {
                $response = [
                    'status'=> false,
                    'username'=> $this->validate->getError('username'),
                    'email'=> $this->validate->getError('email'),
                    'new_password'=> $this->validate->getError('new_password'),
                    'conf_password'=> $this->validate->getError('conf_password'),
                ];
            }else{
                $data = [
                    'email'=> $this->request->getPost('email'),
                    'username'=> $this->request->getPost('username'),
                    'password'=> Hash::make($this->request->getPost('conf_password')),
                    'role'=> 'pelanggan'
                ];
                // simpan data ke tabel users
                $this->userM->save($data);


                $response = [
                    'status'=> true,
                    'msg'=> 'Pendaftaran Akun Berhasil. Silahkan Login',
                    'url'=> base_url('login')
                ];
            }

            return $this->response->setJSON($response);
          
        }
        
    }

    ```