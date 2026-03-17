<?php

namespace App\Controllers\Administrador;

use CodeIgniter\Controller;
use App\Models\PedidoModel;
use App\Models\EmpresaModel;
use App\Models\AreaModel;

class DashboardController extends Controller
{
    public function index()
    {
        $pedidoModel  = new PedidoModel();
        $empresaModel = new EmpresaModel();
        $areaModel    = new AreaModel();

        // Métricas generales
        $activos     = $pedidoModel->contarPorEstado('en_proceso');
        $porAprobar  = $pedidoModel->contarPorEstado('por_aprobar');
        $completados = $pedidoModel->contarPorEstado('completado');
        $sinAsignar  = $pedidoModel->contarSinAsignar();


        // Total para el donut
        $total          = max(1, $activos + $porAprobar + $completados);
        $pctActivos     = $total > 0 ? round($activos     / $total * 100) : 0;
        $pctPorAprobar  = $total > 0 ? round($porAprobar  / $total * 100) : 0;
        $pctCompletados = $total > 0 ? round($completados / $total * 100) : 0;

        return view('administrador/panel/index', [
            'titulo'        => 'Dashboard',
            'tituloPagina'  => 'DASHBOARD',
            'paginaActual'  => 'dashboard',
            'activos'       => $activos,
            'porAprobar'    => $porAprobar,
            'completados'   => $completados,
            'sinAsignar'    => $sinAsignar,
            'empresas'      => $empresaModel->obtenerConStats(),
            'areas'         => $areaModel->obtenerActivas(),
            'totalPedidos'  => $total,
            'pctActivos'    => $pctActivos,
            'pctPorAprobar' => $pctPorAprobar,
            'pctCompletados'=> $pctCompletados,
        ]);
    }

}