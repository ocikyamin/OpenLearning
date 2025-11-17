<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UserTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'=> [
                'type'=> 'INT',
                'constraint'=> 11,
                'unsigned'=> true,
                'auto_increment'=> true
            ],
            'email'=> [
                'type'=> 'VARCHAR',
                'constraint'=> 60,
            ],
            'username'=> [
                'type'=> 'VARCHAR',
                'constraint'=> 60,
            ],
            'password'=> [
                'type'=> 'VARCHAR',
                'constraint'=> 255,
            ],
            'role'=> [
                'type'=> 'ENUM',
                'constraint'=> ['admin','pelanggan'],
                'null'=> false
            ],
            'created_at'=> [
                'type'=> 'DATETIME',
                'null'=> true
            ],
            'updated_at'=> [
                'type'=> 'DATETIME',
                'null'=> true
            ],

        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('users', true);

    }

    public function down()
    {
        $this->forge->dropTable('users');
    }
}
