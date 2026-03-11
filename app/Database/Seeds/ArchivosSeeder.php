<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ArchivosSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                // Archivo que adjuntó el cliente en el formulario
                'idpedido' => null,
                'idformulario' => 1,
                'nombre' => 'brief_admision_2025.pdf',
                'ruta' => '/archivos/entrada/brief_admision_2025.pdf',
                'tipo' => 'entrada',
                'tamano' => 204800, // 200 KB
            ],
            [
                // Entregable que subió el empleado al pedido
                'idpedido' => 1,
                'idformulario' => null,
                'nombre' => 'banner_admision_2025.jpg',
                'ruta' => '/archivos/entregable/banner_admision_2025.jpg',
                'tipo' => 'entregable',
                'tamano' => 5242880, // 5 MB
            ],
        ];

        $this->db->table('archivos')->insertBatch($data);
    }
}
