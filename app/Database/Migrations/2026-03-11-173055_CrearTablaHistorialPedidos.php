<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CrearTablaHistorialPedidos extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'BIGINT',
                'auto_increment' => true,
            ],

            // FK → pedidos — qué pedido cambió de estado
            'idpedido' => [
                'type' => 'BIGINT',
                'null' => false,
            ],

            // FK → usuarios — quién hizo el cambio (admin o empleado)
            'idusuario' => [
                'type' => 'BIGINT',
                'null' => false,
            ],

            // Rol del usuario en el momento del cambio — para saber si fue admin o empleado
            'rol_snapshot' => [
                'type' => 'VARCHAR',
                'constraint' => 30,
                'null' => true,
            ],

            // Estado anterior del pedido antes del cambio
            'estadoanterior' => [
                'type' => 'estado_pedido_enum',
                'null' => true,
            ],

            // Estado nuevo después del cambio
            'estadonuevo' => [
                'type' => 'estado_pedido_enum',
                'null' => false,
            ],

            // Fecha y hora exacta del cambio — automática
            'fechamodificacion' => [
                'type' => 'TIMESTAMP',
                'null' => true,
                'default' => new \CodeIgniter\Database\RawSql('CURRENT_TIMESTAMP'),
            ],

            // Observación opcional — útil cuando admin rechaza entregable
            'observacion' => [
                'type' => 'TEXT',
                'null' => true,
            ],
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('idpedido', 'pedidos', 'id', 'RESTRICT', 'CASCADE');
        $this->forge->addForeignKey('idusuario', 'usuarios', 'id', 'RESTRICT', 'CASCADE');
        $this->forge->createTable('historial_pedidos');
    }

    public function down()
    {
        $this->forge->dropTable('historial_pedidos');
    }
}
