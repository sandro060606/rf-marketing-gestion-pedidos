<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PedidosSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'idformpedido' => 1,
                'idadmin' => 1,    // admin que recibió el formulario
                'idempleado' => null, // aún sin asignar
                'idservicio' => 1,
                'titulo' => null, // admin aún no lo define
                'prioridad' => null, // admin aún no la define
                'estado' => 'por_aprobar',
                'num_modificaciones' => 0,    // recién llegó, sin modificaciones
                'observacion_revision' => null,
                'fechainicio' => null, // nadie ha empezado
                'horainicio' => null,
                'fechafin' => null,
                'horafin' => null,
                'fechacreacion' => '2025-01-28 08:30:00', // cuando llegó el formulario
                'fechacompletado' => null,
                'cancelacionmotivo' => null,
                'fechacancelacion' => null,
            ]
        ];
        $this->db->table('pedidos')->insertBatch($data);
    }
}
