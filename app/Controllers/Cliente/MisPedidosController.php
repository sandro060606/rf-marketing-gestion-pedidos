<?php

namespace App\Controllers\Cliente;

use CodeIgniter\Controller;
use App\Models\PedidoModel;

class MisPedidosController extends Controller
{
    // Lista todos los pedidos asociados a la empresa
    // del cliente autenticado.
    public function index()
    {
        // Obtener el id del usuario desde la sesión
        $idUsuario = 8/* session()->get('id') */;

        // Seguridad: si no hay sesión activa, rechazar
        if (!$idUsuario) {
            return $this->responder(401, 'No autorizado.');
        }

        $modelo  = new PedidoModel();
        $pedidos = $modelo->listarPorCliente($idUsuario);

        // Si no tiene pedidos, devolver array vacío
        if (empty($pedidos)) {
            return $this->responder(200, 'Sin pedidos registrados.', []);
        }

        return $this->responder(200, 'Pedidos obtenidos.', $pedidos);
    }
    // Detalle completo de un pedido específico.
    // Incluye datos del formulario original + empleado asignado.
    public function detalle(int $id)
    {
        $idUsuario = 8 /* session()->get('id') */;

        if (!$idUsuario) {
            return $this->responder(401, 'No autorizado.');
        }

        $modelo = new PedidoModel();
        $pedido = $modelo->detallePedido($id);

        // Verificar que el pedido exista
        if (!$pedido) {
            return $this->responder(404, 'Pedido no encontrado.');
        }

        return $this->responder(200, 'Detalle obtenido.', $pedido);
    }

    // PRIVADO: Formatea todas las respuestas JSON igual
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