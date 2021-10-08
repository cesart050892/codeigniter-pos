<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class PivotPurchases extends Migration
{
    protected $name = 'pivot_purchases';

    public function up()
    {
        $this->forge->addField([
            'id'          => [
                'type'           => 'BIGINT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'name'    => [
                'type'       => 'VARCHAR',
                'constraint' => '200',
            ],
            'price'    => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
            ],
            'quantity'    => [
                'type'       => 'INT',
                'constraint' => '11',
            ],
            'product_fk'    => [
                'type'           => 'BIGINT',
                'constraint'     => 11,
                'unsigned'       => true,
                'null'           => false
            ],
            'purchase_fk'    => [
                'type'           => 'BIGINT',
                'constraint'     => 11,
                'unsigned'       => true,
                'null'           => false
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addField("created_at DATETIME NULL DEFAULT NULL");
        $this->forge->addField("updated_at DATETIME NULL DEFAULT NULL");
        $this->forge->addField("deleted_at DATETIME NULL DEFAULT NULL");
        $this->forge->addForeignKey('purchase_fk', 'purchases', 'id', 'cascade', 'cascade');
        $this->forge->addForeignKey('product_fk', 'products', 'id', 'cascade', 'cascade');
        $this->forge->addUniqueKey('credential_fk');
        $this->forge->createTable($this->name);
    }

    public function down()
    {
        $this->forge->dropTable($this->name);
    }
}
