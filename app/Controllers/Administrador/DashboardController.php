<?php

namespace App\Controllers\Administrador;

use CodeIgniter\Controller;
use App\Models\PedidoModel;
use App\Models\EmpresaModel;

class DashboardController extends Controller
{
    public function index()
    {
        $pedidoModel  = new PedidoModel();
        $empresaModel = new EmpresaModel();

        $datos = [
            'titulo'       => 'Dashboard',
            'tituloPagina' => 'DASHBOARD',
            'paginaActual' => 'dashboard',

            // Métricas desde la BD
        'activos'     => $pedidoModel->contarPorEstado('en_proceso'),
        'porAprobar'  => $pedidoModel->contarPorEstado('por_aprobar'),
        'completados' => $pedidoModel->contarPorEstado('completado'),
        'sinAsignar'  => $pedidoModel->contarSinAsignar(),

            // Lista de empresas
            'empresas'    => $empresaModel->obtenerTodas(),
        ];

        return view('administrador/panel/index', $datos);
    }
}