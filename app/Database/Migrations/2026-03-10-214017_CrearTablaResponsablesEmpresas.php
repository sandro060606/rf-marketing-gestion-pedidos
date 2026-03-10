<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CrearTablaResponsablesEmpresas extends Migration
{
    public function up()
    {
        $this->db->query(" CREATE TYPE estado_responsable_enum AS ENUM ('activo', 'inactivo')");

        $this->forge->addField([
            'id' => [
                'type' => 'BIGINT',
                'auto_increment' => true
            ],
            'idusuario' => [
                'type' => 'BIGINT',
                'null' => false
            ],
            'idempresa' => [
                'type' => 'BIGINT',
                'null' => false
            ],
            'fecha_inicio' => [
                'type' => 'TIMESTAMP',
                'null' => true,
                'default' => new \CodeIgniter\Database\RawSql('CURRENT_TIMESTAMP'),
            ],
            'fecha_fin' => [
                'type' => 'TIMESTAMP',
                'null' => true
            ],
            'estado' => [
                'type'    => 'estado_responsable_enum',
                'null'    => false,
                'default' => 'activo'
            ]
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('idempresa', 'empresas', 'id', 'RESTRICT', 'CASCADE');
        $this->forge->addForeignKey('idusuario', 'usuarios', 'id', 'RESTRICT', 'CASCADE');
        $this->forge->createTable('responsables_empresa');
    }

    public function down()
    {
        $this->forge->dropTable('responsables_empresa');
        // Elimina el tipo ENUM solo si existe, para evitar errores
        $this->db->query("DROP TYPE IF EXISTS estado_responsable_enum");
    }
}
