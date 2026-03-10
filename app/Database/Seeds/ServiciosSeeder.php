<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ServiciosSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'nombre' => 'Diseño',
                'descripcion' => 'Creacion de piezas graficas y material publicitario para campañas digitales',
                'activo' => true
            ],
            [
                'nombre' => 'AudioVisual',
                'descripcion' => 'Produccion y edicion de videos institucionales, publicitarios y contenido multimedia',
                'activo' => true
            ],
        ];
         $this->db->table('servicios')->insertBatch($data);
    }
}
