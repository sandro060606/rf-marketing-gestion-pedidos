<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class HistorialPedidosSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'idpedido' => 1,
                'idusuario' => 1,  // Admin
                'rol_snapshot' => 'administrador',
                'estadoanterior' => null,
                'estadonuevo' => 'por_aprobar',
                'fechamodificacion' => '2025-01-28 08:30:00',
                'observacion' => 'Pedido creado desde formulario',
            ],
            [
                'idpedido' => 1,
                'idusuario' => 1,  // Admin asigna
                'rol_snapshot' => 'administrador',
                'estadoanterior' => 'por_aprobar',
                'estadonuevo' => 'en_proceso',
                'fechamodificacion' => '2025-01-28 09:00:00',
                'observacion' => 'Pedido asignado a Milena',
            ]
        ];
    }
}
