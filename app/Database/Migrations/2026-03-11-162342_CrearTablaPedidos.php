<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CrearTablaPedidos extends Migration
{
    public function up()
    {
        // Estado del pedido en el Kanban — 4 columnas + cancelado
        $this->db->query("CREATE TYPE estado_pedido_enum AS ENUM ('por_aprobar', 'en_proceso', 'en_revision', 'completado', 'cancelado')");

        $this->forge->addField([
            'id' => [
                'type' => 'BIGINT',
                'auto_increment' => true,
            ],
            // FK → formulario original del cliente
            'idformpedido' => [
                'type' => 'BIGINT',
                'null' => false,
            ],
            // FK → admin que procesa el pedido
            'idadmin' => [
                'type' => 'BIGINT',
                'null' => false,
            ],
            // FK → empleado asignado, null hasta que admin asigne
            'idempleado' => [
                'type' => 'BIGINT',
                'null' => true,
            ],
            // FK → servicio, admin puede ajustarlo
            'idservicio' => [
                'type' => 'BIGINT',
                'null' => false,
            ],
            // Título visible en tarjeta Kanban
            'titulo' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
            ],
            // Prioridad que define el admin
            'prioridad' => [
                'type' => 'prioridad_enum',
                'null' => true
            ],
            // Estado actual en el Kanban
            'estado' => [
                'type' => 'estado_pedido_enum',
                'null' => false,
                'default' => 'por_aprobar',
            ],
            // Cuántas veces regresó de en_revision a en_proceso
            'num_modificaciones' => [
                'type' => 'INT',
                'null' => false,
                'default' => 0,
            ],
            // Qué debe corregir el empleado cuando el admin rechaza el entregable
            'observacion_revision' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            // Cuando el empleado empieza a trabajar
            'fechainicio' => [
                'type' => 'DATE',
                'null' => true,
            ],
            // Hora exacta que empezó — para medir tiempo de producción
            'horainicio' => [
                'type' => 'TIME',
                'null' => true,
            ],
            // Cuando el empleado termina y sube el entregable
            'fechafin' => [
                'type' => 'DATE',
                'null' => true,
            ],
            // Hora exacta que terminó — con horainicio calcula tiempo total
            'horafin' => [
                'type' => 'TIME',
                'null' => true,
            ],
            // Fecha que el admin creó el pedido oficial
            'fechacreacion' => [
                'type' => 'TIMESTAMP',
                'null' => true,
                'default' => new \CodeIgniter\Database\RawSql('CURRENT_TIMESTAMP'),
            ],
            // Fecha exacta que pasó a completado
            'fechacompletado' => [
                'type' => 'TIMESTAMP',
                'null' => true,
            ],
            // Motivo de cancelación — solo si el admin canceló
            'cancelacionmotivo' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            // Fecha en que se canceló
            'fechacancelacion' => [
                'type' => 'TIMESTAMP',
                'null' => true,
            ],
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('idformpedido', 'formulario_pedidos', 'id', 'RESTRICT', 'CASCADE');
        $this->forge->addForeignKey('idadmin', 'usuarios', 'id', 'RESTRICT', 'CASCADE');
        $this->forge->addForeignKey('idempleado', 'usuarios', 'id', 'SET NULL', 'CASCADE');
        $this->forge->addForeignKey('idservicio', 'servicios', 'id', 'RESTRICT', 'CASCADE');
        $this->forge->createTable('pedidos');
    }

    public function down()
    {
        $this->forge->dropTable('pedidos');
        // Elimina el tipo ENUM solo si existe, para evitar errores
        $this->db->query("DROP TYPE IF EXISTS estado_pedido_enum");
    }
}
