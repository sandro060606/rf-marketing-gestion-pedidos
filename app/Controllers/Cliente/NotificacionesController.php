<?php

namespace App\Controllers\Cliente;

use CodeIgniter\Controller;
use App\Models\NotificacionesModel;

class NotificacionesController extends Controller
{
    // Lista todas las notificaciones del cliente autenticado
    // Se generan automáticamente cuando el admin cambia el estado del pedido

    public function index()
    { 
        $idUsuario = 8/* session()->get('id') */;

        $modelo        = new NotificacionesModel();
        $notificaciones = $modelo->listarPorUsuario($idUsuario);

        if (empty($notificaciones)) {
            return $this->responder(200, 'Sin notificaciones.', []);
        }

        return $this->responder(200, 'Notificaciones obtenidas.', $notificaciones);
    }
    
    // PRIVADO: Respuesta JSON estándar
    private function responder(int $status, string $mensaje, mixed $data = null)
    {
        return $this->response
            ->setStatusCode($status)
            ->setJSON([
                'status'  => $status,
                'mensaje' => $mensaje,
                'data'    => $data,
            ]);
    }
}