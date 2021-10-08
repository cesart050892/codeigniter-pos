<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Purchases extends Migration
{
    protected $name = 'purchases';

    public function up()
    {
        $this->forge->addField([
            'id'          => [
                'type'           => 'BIGINT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'folio'    => [
                'type'       => 'VARCHAR',
                'constraint' => '15',
            ],
            'total'    => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
            ],
            'state'    => [
                'type'       => 'TINYINT',
                'constraint' => '2',
            ],
            'user_fk'    => [
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
        $this->forge->addForeignKey('user_fk', 'users', 'id', 'cascade', 'cascade');
        $this->forge->addUniqueKey('credential_fk');
        $this->forge->createTable($this->name);
    }

    public function down()
    {
        $this->forge->dropTable($this->name);
    }
}
