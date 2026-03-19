<?php

namespace App\Controllers\Cliente;

use CodeIgniter\Controller;
use App\Models\NotificacionesModel;

class NotificacionesController extends Controller
{
    /**
     * Muestra el historial de alertas del cliente Autenticado
     * @return string|\CodeIgniter\HTTP\RedirectResponse
     */
    public function index()
    {   
        // Recuperar el Id Usuario Logeado
        $idUsuario = session()->get('id');
        
        // Validar
        if (!$idUsuario) {
            return redirect()->to('/login');
        }

        //Instanciar y Obtener las Notificaciones Cliente (listarPorUsuario)
        $modelo = new NotificacionesModel();
        $notificaciones = $modelo->listarPorUsuario($idUsuario);

        //Retornar la Vista con Datos
        return view('cliente/notificaciones', [
            'titulo' => 'Notificaciones',
            'notificaciones' => $notificaciones ?? [],
            'css_extra' => '<link rel="stylesheet" href="' . base_url('recursos/styles/paginas/notificaciones.css') . '">',
        ]);
    }
}