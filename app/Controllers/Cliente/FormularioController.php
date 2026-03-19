<?php

namespace App\Controllers\Cliente;

use CodeIgniter\Controller;
use App\Models\ServicioModel;

class FormularioController extends Controller
{
    /**
     * Renderizar la Vista con los servicios disponibles
     * @return string
     */
    public function index()
    {
        // Instancia y Obtenemos los Servicios Activos
        $servicioModel = new ServicioModel();
        $servicios = $servicioModel->listarActivos();

        // Enviamos Datos y Renderizamos la Vista
        return view('cliente/nuevo-pedido', [
            'titulo' => 'Nuevo Pedido',
            'servicios' => $servicios,
            'css_extra' => '<link rel="stylesheet" href="' . base_url('recursos/styles/paginas/nuevo-pedido.css') . '">',
        ]);
    }

    /**
     * Carga el formulario detallado basado en el ID del servicio seleccionad
     * @param int $idServicio
     * @return string|\CodeIgniter\HTTP\RedirectResponse
     */
    public function formulario(int $idServicio)
    {
        $servicioModel = new ServicioModel();
        $servicio = $servicioModel->find($idServicio);

        if (!$servicio) {
            return redirect()->to('/cliente/nuevo-pedido');
        }

        return view('cliente/formulario-pedido', [
            'titulo' => 'Nuevo Pedido',
            'servicio' => $servicio,
            'css_extra' => '<link rel="stylesheet" href="' . base_url('recursos/styles/paginas/nuevo-pedido.css') . '">',
        ]);
    }

}