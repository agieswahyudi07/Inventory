<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Brand extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'brand_id' => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'brand_name' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'brand_code' => [
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
        $this->forge->addKey('brand_id', true);
        $this->forge->createTable('ms_brand');
    }

    public function down()
    {
        $this->forge->dropTable('ms_brand');
    }
}
