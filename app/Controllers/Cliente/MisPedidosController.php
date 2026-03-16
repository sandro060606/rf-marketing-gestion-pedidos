<?php

namespace App\Controllers\Cliente;

use CodeIgniter\Controller;
use App\Models\PedidoModel;
use App\Models\ArchivoModel;

class MisPedidosController extends Controller
{
    // Lista todos los pedidos asociados a la empresa
    // del cliente autenticado.
    public function index()
    {
        // Obtener el id del usuario desde la sesión
        $idUsuario = 8/* session()->get('id') */ ;

        // Seguridad: si no hay sesión activa, rechazar
        if (!$idUsuario) {
            return $this->responder(401, 'No autorizado.');
        }

        $modelo = new PedidoModel();
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
        $idUsuario = session()->get('id');

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

    // Devuelve todos los archivos relacionados al pedido:
    // - 'entradas'    → archivos que el cliente adjuntó al crear el formulario
    // - 'entregables' → archivos que el empleado subió como resultado del trabajo
    public function archivos(int $idPedido)
    {
        // Verificar que el pedido exista
        $pedidoModel = new PedidoModel();
        $pedido = $pedidoModel->detallePedido($idPedido);

        if (!$pedido) {
            return $this->responder(404, 'Pedido no encontrado.');
        }

        $archivoModel = new ArchivoModel();

        // Archivos de entrada → se buscan por idformulario del pedido
        $pedidoRaw = $pedidoModel->find($idPedido); // Obtiene el registro completo
        $entradas = [];

        if ($pedidoRaw && $pedidoRaw['idformpedido']) {
            $entradas = $archivoModel->listarEntradas($pedidoRaw['idformpedido']);
        }

        // Entregables → se buscan directamente por idpedido
        $entregables = $archivoModel->listarEntregables($idPedido);

        return $this->responder(200, 'Archivos obtenidos.', [
            'entradas' => $entradas,    // Archivos del cliente (referencias)
            'entregables' => $entregables, // Archivos del empleado (resultados)
        ]);
    }

    // PRIVADO: Formatea todas las respuestas JSON igual
    private function responder(int $status, string $mensaje, mixed $data = null)
    {
        return $this->response
            ->setStatusCode($status)
            ->setJSON([
                'status' => $status,
                'mensaje' => $mensaje,
                'data' => $data,
            ]);
    }
}