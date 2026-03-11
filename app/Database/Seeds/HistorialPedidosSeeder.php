<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class HistorialPedidosSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                // Formulario llegó — estado inicial
                'idpedido' => 1,
                'idusuario' => 1,
                'rol_snapshot' => 'administrador',
                'estadoanterior' => null,
                'estadonuevo' => 'por_aprobar',
                'fechamodificacion' => '2025-01-28 08:30:00',
                'observacion' => 'Pedido creado desde formulario',
            ],
            [
                // Admin asignó a Milena
                'idpedido' => 1,
                'idusuario' => 1,
                'rol_snapshot' => 'administrador',
                'estadoanterior' => 'por_aprobar',
                'estadonuevo' => 'en_proceso',
                'fechamodificacion' => '2025-01-28 09:00:00',
                'observacion' => 'Pedido asignado a Milena',
            ],
            [
                // Milena subió entregable
                'idpedido' => 1,
                'idusuario' => 6,
                'rol_snapshot' => 'empleado',
                'estadoanterior' => 'en_proceso',
                'estadonuevo' => 'en_revision',
                'fechamodificacion' => '2025-01-31 17:01:00',
                'observacion' => 'Entregable subido para revision',
            ],
            [
                // Admin rechazó — regresa a Milena
                'idpedido' => 1,
                'idusuario' => 1,
                'rol_snapshot' => 'administrador',
                'estadoanterior' => 'en_revision',
                'estadonuevo' => 'en_proceso',
                'fechamodificacion' => '2025-01-31 17:10:00',
                'observacion' => 'Falta ajustar medidas del banner',
            ],
            [
                // Milena subió corrección
                'idpedido' => 1,
                'idusuario' => 6,
                'rol_snapshot' => 'empleado',
                'estadoanterior' => 'en_proceso',
                'estadonuevo' => 'en_revision',
                'fechamodificacion' => '2025-01-31 17:15:00',
                'observacion' => 'Corrección realizada y subida',
            ],
            [
                // Admin aprobó — completado
                'idpedido' => 1,
                'idusuario' => 1,
                'rol_snapshot' => 'administrador',
                'estadoanterior' => 'en_revision',
                'estadonuevo' => 'completado',
                'fechamodificacion' => '2025-01-31 17:30:00',
                'observacion' => 'Entregable aprobado y enviado al cliente',
            ],
        ];
    }
}
