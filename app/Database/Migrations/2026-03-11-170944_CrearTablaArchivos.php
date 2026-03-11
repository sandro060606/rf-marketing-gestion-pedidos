<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CrearTablaArchivos extends Migration
{
    public function up()
    {
        // Distingue si el archivo lo subió el cliente o el empleado
        $this->db->query("CREATE TYPE tipoarchivo_enum AS ENUM ('entrada', 'entregable')");

        $this->forge->addField([
            'id' => [
                'type' => 'BIGINT',
                'auto_increment' => true,
            ],

            // FK → pedidos — null si el archivo es del formulario aún sin procesar
            'idpedido' => [
                'type' => 'BIGINT',
                'null' => true,
            ],

            // FK → formulario_pedidos — null si el archivo es entregable del empleado
            'idformulario' => [
                'type' => 'BIGINT',
                'null' => true,
            ],

            // Nombre original del archivo
            'nombre' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => false,
            ],

            // Ruta donde está guardado en el servidor
            'ruta' => [
                'type' => 'TEXT',
                'null' => false,
            ],

            // entrada = cliente adjuntó al formulario
            // entregable = empleado subió el trabajo terminado
            'tipo' => [
                'type' => 'tipoarchivo_enum',
                'null' => false,
            ],

            // Tamaño en bytes — máximo 1GB según formulario real
            'tamano' => [
                'type' => 'BIGINT',
                'null' => true,
            ],

            // Fecha y hora exacta que se subió el archivo
            'fechasubida' => [
                'type' => 'TIMESTAMP',
                'null' => true,
                'default' => new \CodeIgniter\Database\RawSql('CURRENT_TIMESTAMP'),
            ],
        ]);
        $this->forge->addPrimaryKey('id');
        // nullable FK porque el archivo puede ser del formulario o del pedido
        $this->forge->addForeignKey('idpedido', 'pedidos', 'id', 'SET NULL', 'CASCADE');
        $this->forge->addForeignKey('idformulario', 'formulario_pedidos', 'id', 'SET NULL', 'CASCADE');
        $this->forge->createTable('archivos');
    }

    public function down()
    {
        $this->forge->dropTable('archivos');
        // Elimina el tipo ENUM solo si existe, para evitar errores
        $this->db->query("DROP TYPE IF EXISTS tipoarchivo_enum");
    }
}

