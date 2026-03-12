<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class NotificacionesSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                // Admin movió a en_proceso — sistema notifica al cliente UAI
                'idpedido' => 1,
                'idusuario' => 8,   // sistema buscó: pedido→formulario→empresa→usuario
                'asunto' => 'Tu pedido está en proceso',
                'mensaje' => 'Tu pedido Recepción Documentaria Admisión 2025-1 ha sido asignado y está siendo trabajado por nuestro equipo',
                'fechaenvio' => '2025-01-28 09:00:00',
                'tipoalerta' => 'estado',
            ],
            [
                // Empleado subió entregable — sistema notifica al cliente
                'idpedido' => 1,
                'idusuario' => 8,
                'asunto' => 'Tu pedido está en revisión',
                'mensaje' => 'Tu pedido Recepción Documentaria Admisión 2025-1 está siendo revisado por el administrador',
                'fechaenvio' => '2025-01-31 17:01:00',
                'tipoalerta' => 'estado',
            ],
            [
                // Admin aprobó — sistema notifica al cliente
                'idpedido' => 1,
                'idusuario' => 8,
                'asunto' => 'Tu pedido ha sido completado',
                'mensaje' => 'Tu pedido Recepción Documentaria Admisión 2025-1 ha sido aprobado y enviado. Gracias por confiar en RF Agencia de Marketing',
                'fechaenvio' => '2025-01-31 17:30:00',
                'tipoalerta' => 'estado',
            ],
        ];

        $this->db->table('notificaciones')->insertBatch($data);
    }
}
