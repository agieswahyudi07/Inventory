<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Type extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'type_id' => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'type_name' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'type_code' => [
                'type' => 'VARCHAR',
                'constraint' => '25',
                'unsigned'       => true,
                'unique' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('type_id', true);
        $this->forge->createTable('ms_type');
    }

    public function down()
    {
        $this->forge->dropTable('ms_item');
    }
}
