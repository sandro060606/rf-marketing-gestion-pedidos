<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CrearTablaNotificaciones extends Migration
{
    public function up()
    {
        // Tipo de alerta que dispara la notificación
        $this->db->query("CREATE TYPE tipoalerta_enum AS ENUM ('estado', 'cancelacion', 'vencimiento')");

        $this->forge->addField([
            'id' => [
                'type' => 'BIGINT',
                'auto_increment' => true,
            ],

            // FK → pedidos — a qué pedido corresponde la notificación
            'idpedido' => [
                'type' => 'BIGINT',
                'null' => false,
            ],

            // FK → usuarios — a quién se le envió el correo
            'idusuario' => [
                'type' => 'BIGINT',
                'null' => false,
            ],

            // Asunto del correo
            'asunto' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => false,
            ],

            // Cuerpo del mensaje
            'mensaje' => [
                'type' => 'TEXT',
                'null' => false,
            ],

            // Fecha y hora exacta que se envió
            'fechaenvio' => [
                'type' => 'TIMESTAMP',
                'null' => true,
                'default' => new \CodeIgniter\Database\RawSql('CURRENT_TIMESTAMP'),
            ],

            // estado = cambio de estado
            // cancelacion = pedido cancelado
            // vencimiento = alerta fecha límite
            'tipoalerta' => [
                'type' => 'tipoalerta_enum',
                'null' => false,
            ],
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('idpedido', 'pedidos', 'id', 'RESTRICT', 'CASCADE');
        $this->forge->addForeignKey('idusuario', 'usuarios', 'id', 'RESTRICT', 'CASCADE');
        $this->forge->createTable('notificaciones');
    }

    public function down()
    {
        $this->forge->dropTable('notificaciones');
        // Elimina el tipo ENUM solo si existe, para evitar errores
        $this->db->query("DROP TYPE IF EXISTS tipoalerta_enum");
    }
}
