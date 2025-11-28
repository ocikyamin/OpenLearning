> # Login AJAX

``` javascript
$('.auth-form').submit(function (e) { 
        e.preventDefault();
        // Reset Pesan Error
        $('#email').removeClass('is-invalid');
        $('#password').removeClass('is-invalid');
        $('.invalid-feedback').remove();
       $.ajax({
        type: "post",
        url: "<?=base_url('login/proses')?>",
        data: $(this).serialize(),
        dataType: "json",
        beforeSend : function(){
            $('#btn-login').prop('disabled', true)
            Notiflix.Loading.standard('Harap Tunggu Sebentar...');
        },
        complete : function(){
            $('#btn-login').prop('disabled', false)
            Notiflix.Loading.remove();
        },
        success: function (response) {
           // Jika gagal 
           if (response.status==false) {
            // Error Email
            if (response.email) {
                $('#email').addClass('is-invalid')
                $('#email').after('<div class="invalid-feedback">'+response.email+'</div>')
            }
            // Error Password
            if (response.password) {
                $('#password').addClass('is-invalid')
                $('#password').after('<div class="invalid-feedback">'+response.password+'</div>')
            }   
            
            return;

           }

           // Jika Berhasil

           if (response.status == true) {
              Notiflix.Notify.success('Login Berhasil...');
              window.location.href = response.redirect
           }


        }
       });
        
    });

```

> # Login Proses
```php
if ($this->request->isAJAX()) {
            // service validasi
            $this->validate = \Config\Services::validation();
            // def rules
            $validate = $this->validate([
                'email'=> [
                    'label'=> 'Email Adress',
                    'rules'=> 'required|valid_email|max_length[60]',
                    'errors'=> [
                        'required'=> '{field} Harus di isi', 
                        'valid_email'=> '{field} Tidak Valid', 
                        'max_length'=> '{field} Maksimal 60 Karakter', 
                    ]
                ],
                'password'=> [
                    'label'=> 'Password',
                    'rules'=> 'required',
                    'errors'=> [
                        'required'=> '{field} Harus di isi', 
                    ]
                ],
            ]);
           // Jika Gagal
            if (!$validate) {
                $response = [
                    'status'=> false,
                    'email'=> $this->validate->getError('email'),
                    'password'=> $this->validate->getError('password'),
                ];
            }else{
                // jika lolos validasi
                $email = $this->request->getPost('email');
                $password = $this->request->getPost('password');
                $isRole = $this->request->getPost('is_role');

                // === CEK ROLE LOGIN ===
                if ($isRole==1) {
                    // jika centang chebox admin
                    $user = $this->userM
                    ->where('email', $email)
                    ->where('role','admin')
                    ->first();
                    if (!$user) {
                        return $this->response->setJSON([
                            'status'=> false,
                            'email'=> 'Akun admin tidak Terdaftar',
                            'password'=> ''

                        ]);
                    }
                }else{
                    // login user / pelanggan
                         $user = $this->userM
                    ->where('email', $email)
                    ->where('role','pelanggan')
                    ->first();
                    if (!$user) {
                        return $this->response->setJSON([
                            'status'=> false,
                            'email'=> 'Akun User tidak Terdaftar',
                            'password'=> ''

                        ]);
                    }
                
                }

                // === CEK PASSWORD

                if (!Hash::verify($password, $user['password'])) {
                    return $this->response->setJSON([
                    'status'=> false,
                    'password'=> 'Password Salah',
                    'email'=> ''
                    ]);
                }

                // == SET SESSION
                session()->set([
                    'user_id'=> $user['id'],
                    'username'=> $user['username'],
                    'email'=> $user['email'],
                    'role'=> $user['role'],
                    'logged_in'=> true,
                ]);

                // Redirect ke halaman masing role user
                $redirectURL = ($user['role']=='admin') ? base_url('admin/dashboard'):base_url('user/home');

                $response = [
                    'status'=> true,
                    'redirect'=> $redirectURL
                ];
            }
            return $this->response->setJSON($response);
        
        }

```