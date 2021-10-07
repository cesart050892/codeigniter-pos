<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Clients extends Migration
{
    protected $name = 'clients';

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
                'constraint' => '75'
            ],
            'identification'    => [
                'type'       => 'VARCHAR',
                'constraint' => '100'
            ],
            'email'    => [
                'type'       => 'VARCHAR',
                'constraint' => '100'
            ],
            'phone'    => [
                'type'       => 'VARCHAR',
                'constraint' => '10'
            ],
            'address'    => [
                'type'       => 'VARCHAR',
                'constraint' => '255'
            ],
            'birthdate'    => [
                'type'           => 'DATETIME',
            ],
            'shopping'    => [
                'type'       => 'INT',
                'constraint' => 11
            ]
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addField("created_at DATETIME NULL DEFAULT NULL");
        $this->forge->addField("updated_at DATETIME NULL DEFAULT NULL");
        $this->forge->addField("deleted_at DATETIME NULL DEFAULT NULL");
        $this->forge->createTable($this->name);
    }

    public function down()
    {
        $this->forge->dropTable($this->name);
    }
}
