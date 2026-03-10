<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use PHPUnit\Framework\Constraint\Constraint;

class CrearTablaEmpresas extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'BIGINT',
                'auto_increment' => true
            ],
            'idusuario' => [
                'type' => 'BIGINT',
                'null' => false
            ],
            'nombreempresa' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => false
            ],
            'ruc' => [
                'type' => 'CHAR',
                'constraint' => 11,
                'null' => false
            ],
            'correo' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true
            ],
            'telefono' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'null' => true
            ]
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addUniqueKey('ruc');
        $this->forge->addForeignKey('idusuario', 'usuarios', 'id', 'RESTRICT', 'CASCADE');
        $this->forge->createTable('empresas');
    }

    public function down()
    {
        $this->forge->dropTable('empresas');
    }
}
