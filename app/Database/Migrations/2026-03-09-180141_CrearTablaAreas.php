<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CrearTablaAreas extends Migration
{
    public function up()
    {
        $this->forge->addfield([
            'id' => [
                'type'=> 'BIGINT',
                'auto_increment'=> true
            ],
            'nombre' => [
                'type'=> 'VARCHAR',
                'constraint' => 50,
                'null' => false
            ],
            'descripcion' => [
                'type' => 'TEXT',
                'null' => true
            ],
            'activo' => [
                'type' => 'BOOLEAN',
                'default' => true
            ]
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('areas');
    }

    public function down()
    {
        $this->forge->dropTable('areas');
    }
}
