<?php

namespace App\Controllers\Cliente;

use CodeIgniter\Controller;
use App\Models\PedidoModel;
use App\Models\ArchivoModel;

class MisPedidosController extends Controller
{
    /**
     * Muestra la lista principal de todos los pedidos de la empresa del cliente
     * * @return string Devuelve la vista 'cliente/lista', con el array de pedidos
     * @return string|\CodeIgniter\HTTP\RedirectResponse
     */
    public function index()
    {
        // (Variable) Obtener el id del usuario desde la sesión
        $idUsuario = session()->get('id');

        // Seguridad: si no hay sesión activa, retornar al Login
        if (!$idUsuario) {
            return redirect()->to('/login');
        }
        //Instancia un Objeto
        $modelo = new PedidoModel();
        //Llama al Metodo del Modelo (listarPorCliente)
        $pedidos = $modelo->listarPorCliente($idUsuario);

        //Perpara los Datos para la Vista (Mis Pedidos)
        return view('cliente/lista', [
            'titulo' => 'Mis Pedidos',
            'pedidos' => $pedidos,
            'css_extra' => '<link rel="stylesheet" href="' . base_url('recursos/styles/paginas/mis_pedidos.css') . '">',
        ]);
    }

    /**
     * Método para mostrar Info Completo de un pedido específico
     * @param int $id
     * @return string|\CodeIgniter\HTTP\RedirectResponse
     */
    public function detalle(int $id)
    {
        // (Variable) Obtener el id del usuario desde la sesión
        $idUsuario = session()->get('id');

        // Seguridad: si no hay sesión activa, retornar al Login
        if (!$idUsuario) {
            return redirect()->to('/login');
        }
        //Instacia Modelo y llamada al Metodo (detallePedido)
        $pedidoModel = new PedidoModel();
        $pedido = $pedidoModel->detallePedido($id);

        // Verificar que el pedido exista
        if (!$pedido) {
            return redirect()->to('/cliente/mis-pedidos')
                ->with('error', 'Pedido no encontrado.');
        }

        // Obtiene registro original del pedido (Campos) y gestionar sus archivos adjuntos
        $pedidoRaw = $pedidoModel->find($id);
        $archivoModel = new ArchivoModel();

        // Se agrupan los archivos en dos categorías para la interfaz
        $archivos = [
            'entradas' => $archivoModel->listarEntradas($pedidoRaw['idformpedido']),
            'entregables' => $archivoModel->listarEntregables($id),
        ];

        // Se carga la vista 'cliente/detalle' pasando toda la data recolectada
        return view('cliente/detalle', [
            'titulo' => 'Detalle del Pedido',
            'pedido' => $pedido,
            'archivos' => $archivos,
            'css_extra' => '<link rel="stylesheet" href="' . base_url('recursos/styles/paginas/detalle-pedido.css') . '">',
        ]);
    }

}