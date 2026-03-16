<?php

namespace App\Controllers\Cliente;

use CodeIgniter\Controller;
use App\Models\ServicioModel;
use App\Models\FormularioModel;
use App\Models\EmpresaModel;

class FormularioController extends Controller
{
    // Devuelve los servicios disponibles para que el cliente
    // También devuelve los datos de su empresa.
    public function index()
    {
        $idUsuario = 8/* session()->get('id') */;

        // Obtener empresa del cliente
        $empresaModel = new EmpresaModel();
        $empresa      = $empresaModel->buscarPorUsuario($idUsuario);

        if (!$empresa) {
            return $this->responder(404, 'No tienes una empresa registrada.');
        }

        // Obtener servicios disponibles
        $servicioModel = new ServicioModel();
        $servicios     = $servicioModel->listarActivos();

        return $this->responder(200, 'Datos para nuevo pedido.', [
            'empresa'   => $empresa,
            'servicios' => $servicios,
        ]);
    }

    // Recibe los datos del formulario y crea el pedido.
    public function guardar()
    {
        return $this->responder(200, 'Próximamente.');
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