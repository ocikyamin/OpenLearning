<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\UserModel;

class UserController extends BaseController
{
    public function index()
    {
        return view('Users/index');
    }
    // Menampilkn Data User
        function List() {
          $userM = New UserModel();
        $data = ['users'=> $userM->findAll()];
        $view = ['user'=> view('Users/list', $data)];
        return $this->response->setJSON($view);
        }

           // Form Tambah dan update User
        function Form() {
        $userM = New UserModel();
        $id = $this->request->getVar('id');
        $data = [
            'id'=> $id,
            'title'=> $this->request->getVar('title'),
            'button'=> $this->request->getVar('button'),
            ];
            $data['user'] = $userM->find($id);
           // jika ada data 
        $view = ['form'=> view('Users/form', $data)];
        return $this->response->setJSON($view); 
        }

public function store()
{
    $id = $this->request->getVar('id');
    
    $userData = [
        'id'    => $id,
        'email' => $this->request->getVar('email'),
        'name'  => $this->request->getVar('name'),
    ];

    $userModel = new UserModel();

    // Validasi dan eksekusi penyimpanan ke database
    if (!$userModel->save($userData)) {
        return $this->response->setJSON([
            'status' => false,
            'errors' => $userModel->errors()
        ])->setStatusCode(400);
    }

    // Penentuan pesan respon 
    $message = empty($id) ? 'Data Berhasil Ditambahkan' : 'Data Berhasil Diperbarui';

    return $this->response->setJSON([
        'status'  => true,
        'message' => $message
    ]);
}

// Hapus Data 

public function Delete() // Gunakan huruf kecil 'delete' sesuai standar PSR-12
{
    $id = $this->request->getVar('id');

    // Validasi jika ID kosong sebelum memproses ke database
    if (empty($id)) {
        return $this->response->setJSON([
            'status'  => false,
            'message' => 'ID data tidak ditemukan.'
        ])->setStatusCode(400);
    }

    $userModel = new UserModel();

    // PERBAIKAN: Masukkan variabel $id secara langsung, bukan array asosiatif
    if (!$userModel->delete($id)) {
        return $this->response->setJSON([
            'status' => false,
            'errors' => $userModel->errors()
        ])->setStatusCode(400);
    }

    // WAJIB: Berikan respon sukses jika berhasil dihapus
    return $this->response->setJSON([
        'status'  => true,
        'message' => 'Data berhasil dihapus.'
    ]);
}


}
