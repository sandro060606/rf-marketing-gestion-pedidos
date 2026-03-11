<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PedidosSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'idformpedido'         => 1,
                'idadmin'              => 1,
                'idempleado'           => 6, // MILENA = empleado responsable
                'idservicio'           => 1, // Diseño
                'titulo'               => null,
                'prioridad'            => null,
                'estado'               => 'por_aprobar', // Entregado
                'num_modificaciones'   => 1,
                'observacion_revision' => null,
                // Fechas — null hasta que se registran
                'fechainicio'          => null, // se llenó cuando empezó
                'horainicio'           => null,   // se llenó cuando empezó
                'fechafin'             => null, // se llenó cuando terminó
                'horafin'              => null,   // se llenó cuando terminó
                'fechacreacion'        => '2025-01-28 00:00:00',
                'fechacompletado'      => null,
                'cancelacionmotivo'    => null,
                'fechacancelacion'     => null,
            ]
        ];
        $this->db->table('pedidos')->insertBatch($data);
    }
}
