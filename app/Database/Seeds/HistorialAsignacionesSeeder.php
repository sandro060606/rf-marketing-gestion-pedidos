<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class HistorialAsignacionesSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                // Asignación inicial
                'idpedido' => 1,
                'idempleado_anterior' => null,
                'idempleado' => 6,
                'idadmin' => 1,
                'fecha_asignacion' => '2026-02-21 09:00:00',
                'fecha_fin' => '2026-02-27 17:30:00', // terminó al completarse
                'motivo_cambio' => null,
            ],
        ];

        $this->db->table('historial_asignaciones')->insertBatch($data);
    }
}
