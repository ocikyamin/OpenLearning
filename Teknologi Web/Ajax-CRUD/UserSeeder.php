<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
            // Define users
        $users = [
            [
                'name'     => 'Abdul Yamin',
                'email' => 'ysmin@gmail.com',
            ],
            [
                'name'     => 'Budi Santoso',
                'email' => 'budi@gmail.com',
            ],
        ];

        $this->db->table('users')->insertBatch($users);
    }
}
