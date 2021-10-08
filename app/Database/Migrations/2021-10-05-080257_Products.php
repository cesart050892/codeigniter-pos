<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Products extends Migration
{
    protected $name = 'products';

    public function up()
    {
        $this->forge->addField([
            'id'          => [
                'type'           => 'BIGINT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'code'    => [
                'type'       => 'TEXT'
            ],
            'description'    => [
                'type'       => 'TEXT'
            ],
            'stock'    => [
                'type'           => 'BIGINT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
            'cost'    => [
                'type'           => 'DOUBLE',
                'constraint'     => '11,2',
            ],
            'sale'    => [
                'type'           => 'DOUBLE',
                'constraint'     => '11,2',
            ],
            'quantity'    => [
                'type'           => 'BIGINT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
            'image'    => [
                'type'       => 'VARCHAR',
                'constraint' => '75',
                'default'    => 'assets/img/undraw_product.png'
            ],
            'category_fk'    => [
                'type'           => 'BIGINT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
            'unit_fk'    => [
                'type'           => 'BIGINT',
                'constraint'     => 11,
                'unsigned'       => true,
                'default'        => 1 
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addField("created_at DATETIME NULL DEFAULT NULL");
        $this->forge->addField("updated_at DATETIME NULL DEFAULT NULL");
        $this->forge->addField("deleted_at DATETIME NULL DEFAULT NULL");
        $this->forge->addForeignKey('unit_fk', 'units', 'id', 'cascade', 'cascade');
        $this->forge->addForeignKey('category_fk', 'categories', 'id', 'cascade', 'cascade');
        $this->forge->createTable($this->name);
    }

    public function down()
    {
        $this->forge->dropTable($this->name);
    }
}
