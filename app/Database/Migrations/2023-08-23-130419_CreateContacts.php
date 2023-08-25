<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateContacts extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_contact' => [
                'type'           => 'BIGINT',
                'constraint'     => 20,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'name_contact' => [
                'type'       => 'VARCHAR',
                'constraint' => '60',
            ],
            'name_alias' => [
                'type'       => 'VARCHAR',
                'constraint' => '60',
                'null'       => true,
            ],
            'phone' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
                'null'       => true,
            ],
            'name_contact' => [
                'type'       => 'VARCHAR',
                'constraint' => '20',
            ],
            'email' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
                'null'       => true,
            ],
            'address' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
                'null'       => true,
            ],
            'info_contact' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'id_group' => [
                'type'           => 'BIGINT',
                'constraint'     => 20,
                'unsigned'       => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'deleted_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id_contact', true);
        $this->forge->addForeignKey('id_group', 'group_data', 'id_group');
        $this->forge->createTable('contacts');
    }

    public function down()
    {
        $this->forge->dropForeignKey('contacts', 'contacts_id_group_foreign');
        $this->forge->dropTable('contacts');
    }
}
