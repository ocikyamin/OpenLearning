<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ComplaintTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'=> [
                'type'=> 'INT',
                'constraint'=>11,
                'unsigned'=> true,
                'auto_increment'=> true,
            ],
            'user_id'=> [
                'type'=> 'INT',
                'constraint'=>11,
                'unsigned'=> true,
                'null'=> false
                
            ],
            'title'=> [
                'type'=> 'VARCHAR',
                'constraint'=> 100,
                'null'=> false
            ],
            'description'=> [
                'type'=> 'TEXT',
                'null'=> false
            ],
            'attachment'=> [
                'type'=> 'VARCHAR',
                'constraint'=> 255,
                'null'=> true
            ],
            'status'=> [
                'type'=> 'ENUM',
                'constraint'=> ['baru','proses','selesai'],
                'default'=> 'baru',
                'null'=> false
            ],
            'created_at'=> [
                'type'=>'DATETIME',
                'null'=> true
            ],
            'updated_at'=> [
                'type'=>'DATETIME',
                'null'=> true
            ],

        ]);
        // Primry Key
        $this->forge->addKey('id', true);
        // ForeignKey
        $this->forge->addForeignKey('user_id','users','id','CASCADE','CASCADE');
        $this->forge->createTable('complaints', true);
    }

    public function down()
    {
        $this->forge->dropTable('complaints');
    }
}
