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
        $idUsuario = session()->get('id');

        if (!$idUsuario) {
            return redirect()->to('/login');
        }

        $modelo = new NotificacionesModel();
        $notificaciones = $modelo->listarPorUsuario($idUsuario);

        return view('cliente/notificaciones', [
            'titulo' => 'Notificaciones',
            'notificaciones' => $notificaciones ?? [],
            'css_extra' => '<link rel="stylesheet" href="' . base_url('recursos/styles/paginas/notificaciones.css') . '">',
        ]);
    }
}