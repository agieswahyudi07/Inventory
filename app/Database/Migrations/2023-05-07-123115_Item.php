<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Item extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'item_id' => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'item_name' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'item_code' => [
                'type' => 'VARCHAR',
                'constraint' => '25',
                'unsigned' => true,
                'unique' => true,
            ],
            'item_price' => [
                'type' => 'INT',
                'constraint' => '255',
                'unsigned' => true
            ],
            'category_id' => [
                'type' => 'INT',
                'constraint' => '255',
                'unsigned' => true
            ],
            'type_id' => [
                'type' => 'INT',
                'constraint' => '255',
                'unsigned' => true
            ],
            'brand_id' => [
                'type' => 'INT',
                'unsigned' => true,
                'constraint' => '255',
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
        $this->forge->addKey('item_id', true);
        $this->forge->addForeignKey('category_id', 'ms_category', 'item_id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('type_id', 'ms_type', 'item_id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('brand_id', 'ms_brand', 'item_id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('ms_item');
    }

    public function down()
    {
        $this->forge->dropTable('ms_item');
    }
}
