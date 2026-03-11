<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CrearTablaHistorialAsignaciones extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'BIGINT',
                'auto_increment' => true,
            ],
            // FK → pedidos
            'idpedido' => [
                'type' => 'BIGINT',
                'null' => false,
            ],
            // Empleado anterior — null si es asignación inicial
            'idempleado_anterior' => [
                'type' => 'BIGINT',
                'null' => true,
            ],
            // Empleado nuevo asignado
            'idempleado' => [
                'type' => 'BIGINT',
                'null' => false,
            ],
            // Admin que hizo la asignación
            'idadmin' => [
                'type' => 'BIGINT',
                'null' => false,
            ],
            'fecha_asignacion' => [
                'type' => 'TIMESTAMP',
                'null' => true,
                'default' => new \CodeIgniter\Database\RawSql('CURRENT_TIMESTAMP'),
            ],
            'fecha_fin' => [
                'type' => 'TIMESTAMP',
                'null' => true,
            ],
            'motivo_cambio' => [
                'type' => 'TEXT',
                'null' => true,
            ],  
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('idpedido', 'pedidos', 'id', 'RESTRICT', 'CASCADE');
        $this->forge->addForeignKey('idempleado_anterior', 'usuarios', 'id', 'SET NULL', 'CASCADE');
        $this->forge->addForeignKey('idempleado', 'usuarios', 'id', 'RESTRICT', 'CASCADE');
        $this->forge->addForeignKey('idadmin', 'usuarios', 'id', 'RESTRICT', 'CASCADE');
        $this->forge->createTable('historial_asignaciones');
    }

    public function down()
    {
        $this->forge->dropTable('historial_asignaciones');
    }
}
