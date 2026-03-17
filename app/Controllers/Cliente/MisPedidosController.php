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
        $idUsuario = session()->get('id');

        // Seguridad: si no hay sesión activa, rechazar
        if (!$idUsuario) {
            return redirect()->to('/login');
        }

        $modelo = new PedidoModel();
        $pedidos = $modelo->listarPorCliente($idUsuario);

        // Si no tiene pedidos, devolver array vacío
        if (empty($pedidos)) {
            return view('cliente/lista', [
                'titulo' => 'Mis Pedidos',
                'pedidos' => [],
                'css_extra' => '<link rel="stylesheet" href="' . base_url('recursos/styles/paginas/mis-pedidos.css') . '">',
            ]);
        }

        return view('cliente/lista', [
            'titulo' => 'Mis Pedidos',
            'pedidos' => $pedidos,
            'css_extra' => '<link rel="stylesheet" href="' . base_url('recursos/styles/paginas/mis_pedidos.css') . '">',
        ]);
    }
    // Detalle completo de un pedido específico.
    // Incluye datos del formulario original + empleado asignado.
    public function detalle(int $id)
    {
        $idUsuario = session()->get('id');

        if (!$idUsuario) {
            return redirect()->to('/login');
        }

        $modelo = new PedidoModel();
        $pedido = $modelo->detallePedido($id);

        // Verificar que el pedido exista
        if (!$pedido) {
            return $this->response->setStatusCode(404)->setJSON(['status' => 404, 'mensaje' => 'Pedido no encontrado.']);
        }

        return $this->response->setJSON([
            'status' => 200,
            'mensaje' => 'Detalle obtenido.',
            'data' => $pedido,
        ]);
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
            return $this->response->setStatusCode(404)->setJSON([
                'status' => 404,
                'mensaje' => 'Pedido no encontrado.',
            ]);
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

        return $this->response->setJSON([
            'status' => 200,
            'mensaje' => 'Archivos obtenidos.',
            'data' => [
                'entradas' => $archivoModel->listarEntradas($pedidoRaw['idformpedido']),
                'entregables' => $archivoModel->listarEntregables($idPedido),
            ],
        ]);
    }
}