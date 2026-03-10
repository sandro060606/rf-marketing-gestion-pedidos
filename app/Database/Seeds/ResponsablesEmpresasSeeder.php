<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ResponsablesEmpresasSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'idusuario' => 8,
                'idempresa' => 1,
                'fecha_inicio' => date('Y-m-d H:i:s'),
                'fecha_fin' => null,
                'estado' => 'activo'
            ],
            [
                'idusuario' => 9,
                'idempresa' => 2,
                'fecha_inicio' => date('Y-m-d H:i:s'),
                'fecha_fin' => null,
                'estado' => 'activo'
            ]
        ];
        $this->db->table('responsables_empresa')->insertBatch($data);
    }
}
