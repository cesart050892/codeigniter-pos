<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Users extends Migration
{
    protected $name = 'users';

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
                'constraint' => '75',
            ],
            'surname'    => [
                'type'       => 'VARCHAR',
                'constraint' => '75',
            ],
            'photo'    => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'default'    => 'assets/img/undraw_profile_2.svg'
            ],
            'address'    => [
                'type'       => 'VARCHAR',
                'constraint' => '75',
                'null'             => false
            ],
            'phone'    => [
                'type'       => 'VARCHAR',
                'constraint' => '75',
                'null'             => false
            ],
            'state'    => [
                'type'       => 'TINYINT',
                'constraint' => '2',
            ],
            'last_login'    => [
                'type'       => 'DATETIME'
            ],
            'credential_fk'    => [
                'type'           => 'BIGINT',
                'constraint'     => 11,
                'unsigned'       => true,
                'null'           => false
            ],
            'rol_fk'    => [
                'type'           => 'BIGINT',
                'constraint'     => 11,
                'unsigned'       => true,
                'default'        => '2'
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addField("created_at DATETIME NULL DEFAULT NULL");
        $this->forge->addField("updated_at DATETIME NULL DEFAULT NULL");
        $this->forge->addField("deleted_at DATETIME NULL DEFAULT NULL");
        $this->forge->addForeignKey('rol_fk', 'rols', 'id', 'cascade', 'cascade');
        $this->forge->addForeignKey('credential_fk', 'credentials', 'id', 'cascade', 'cascade');
        $this->forge->addUniqueKey('credential_fk');
        $this->forge->createTable($this->name);
    }

    public function down()
    {
        $this->forge->dropTable($this->name);
    }
}
