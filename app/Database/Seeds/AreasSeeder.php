<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AreasSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'nombre' => 'Diseño Grafico',
                'descripcion' => 'Diseño de piezas gráficas, flyers y material publicitario',
                'activo' => true,
            ],
            [
                'nombre' => 'Edicion y Video',
                'descripcion' => 'Edición y producción de videos institucionales y publicitarios',
                'activo' => true,
            ]
        ];
        $this->db->table("areas")->insertBatch($data);
    }
}
