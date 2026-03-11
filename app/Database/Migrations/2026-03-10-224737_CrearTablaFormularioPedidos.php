<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateFormularioPedidosTable extends Migration
{
    public function up()
    {
        // ENUM solo para prioridad
        $this->db->query("CREATE TYPE prioridad_enum AS ENUM ('alta', 'media', 'baja')");

        $this->forge->addField([
            'id' => [
                'type' => 'BIGINT',
                'auto_increment' => true,
            ],
            // FK → empresas(id)
            'idempresa' => [
                'type' => 'BIGINT',
                'null' => false,
            ],
            // FK → servicios(id)
            'idservicio' => [
                'type' => 'BIGINT',
                'null' => false,
            ],
            // Título del pedido — nombre corto para identificarlo en el Kanban
            'titulo' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => false,
            ],
            // Pregunta 2 — área de la empresa que solicita
            'area' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => true,
            ],
            // Pregunta 6 — objetivo de comunicación y a quién va dirigido
            'objetivo_comunicacion' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            // Pregunta 7 — descripción detallada, texto exacto, fechas, logos, etc.
            'descripcion' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            // Pregunta 8 — tipo de requerimiento según servicio, viene del frontend
            'tipo_requerimiento' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
            ],
            // Pregunta 10 — canales de difusión guardados como JSON (máx 3 opciones)
            'canales_difusion' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            // Pregunta 11 — perfil del público objetivo y tono de comunicación
            'publico_objetivo' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            // Pregunta 12 — indica si el cliente adjunta materiales de referencia
            'tiene_materiales' => [
                'type' => 'BOOLEAN',
                'default' => false,
            ],
            // Pregunta 13 — formatos solicitados guardados como JSON
            'formatos_solicitados' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            // Pregunta 14/15 — solo si marcó "Otros"
            'formato_otros' => [
                'type' => 'VARCHAR',
                'constraint' => 200,
                'null' => true,
            ],
            // Pregunta 9 — fecha requerida de entrega
            'fecharequerida' => [
                'type' => 'TIMESTAMP',
                'null' => true,
            ],
            // Prioridad — la asigna el admin al procesar
            'prioridad' => [
                'type' => 'prioridad_enum',
                'null' => false,
                'default' => 'media',
            ],
            // Fecha envío del formulario — automática
            'fechacreacion' => [
                'type' => 'TIMESTAMP',
                'null' => true,
                'default' => new \CodeIgniter\Database\RawSql('CURRENT_TIMESTAMP'),
            ],
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('idempresa', 'empresas', 'id', 'RESTRICT', 'CASCADE');
        $this->forge->addForeignKey('idservicio', 'servicios', 'id', 'RESTRICT', 'CASCADE');
        $this->forge->createTable('formulario_pedidos');

    }

    public function down()
    {
        $this->forge->dropTable('formulario_pedidos');
        // Elimina el tipo ENUM solo si existe, para evitar errores
        $this->db->query("DROP TYPE IF EXISTS prioridad_enum");
    }
}