<?php

namespace App\Controllers\Cliente;

use CodeIgniter\Controller;
use App\Models\ServicioModel;
use App\Models\FormularioModel;
use App\Models\EmpresaModel;
use App\Models\PedidoModel;
use App\Models\NotificacionesModel;

class FormularioController extends Controller
{
    // GET /cliente/nuevo-pedido
    // Devuelve servicios disponibles + datos de la empresa
    public function index()
    {
        $idUsuario = 8/* session()->get('id') */;

        $empresaModel = new EmpresaModel();
        $empresa      = $empresaModel->buscarPorUsuario($idUsuario);

        if (!$empresa) {
            return $this->responder(404, 'No tienes una empresa registrada.');
        }

        $servicioModel = new ServicioModel();
        $servicios     = $servicioModel->listarActivos();

        return $this->responder(200, 'Datos para nuevo pedido.', [
            'empresa'   => $empresa,
            'servicios' => $servicios,
        ]);
    }

    // Flujo completo:
    // 1. Valida campos obligatorios
    // 2. Crea el formulario en formulario_pedidos
    // 3. Crea el pedido en estado 'por_aprobar'
    // 4. Notifica al administrador del nuevo pedido
    public function guardar()
    {
        $idUsuario = 8/* session()->get('id') */;

        // Obtener empresa del cliente
        $empresaModel = new EmpresaModel();
        $empresa      = $empresaModel->buscarPorUsuario($idUsuario);

        if (!$empresa) {
            return $this->responder(404, 'No tienes una empresa registrada.');
        }

        // Obtener datos del POST
        $post = $this->request->getPost();

        // Validación de campos obligatorios
        $camposObligatorios = [
            'idservicio', 'titulo', 'area',
            'objetivo_comunicacion', 'descripcion',
            'tipo_requerimiento', 'fecharequerida', 'prioridad'
        ];

        foreach ($camposObligatorios as $campo) {
            if (empty($post[$campo])) {
                return $this->responder(422, "El campo '{$campo}' es obligatorio.");
            }
        }

        // Canales y formatos van guardados como JSON
        $canales  = is_array($post['canales_difusion'] ?? null)
            ? json_encode($post['canales_difusion'])
            : ($post['canales_difusion'] ?? '[]');

        $formatos = is_array($post['formatos_solicitados'] ?? null)
            ? json_encode($post['formatos_solicitados'])
            : ($post['formatos_solicitados'] ?? '[]');

        // Crear el formulario 
        $datos = [
            'idempresa'             => $empresa['id'],
            'idservicio'            => (int) $post['idservicio'],
            'titulo'                => $post['titulo'],
            'area'                  => $post['area'],
            'objetivo_comunicacion' => $post['objetivo_comunicacion'],
            'descripcion'           => $post['descripcion'],
            'tipo_requerimiento'    => $post['tipo_requerimiento'],
            'canales_difusion'      => $canales,
            'publico_objetivo'      => $post['publico_objetivo'] ?? null,
            'tiene_materiales'      => filter_var($post['tiene_materiales'] ?? false, FILTER_VALIDATE_BOOLEAN),
            'formatos_solicitados'  => $formatos,
            'formato_otros'         => $post['formato_otros'] ?? null,
            'fecharequerida'        => $post['fecharequerida'],
            'prioridad'             => $post['prioridad'],
        ];

        $formularioModel = new FormularioModel();
        $idFormulario    = $formularioModel->crear($datos);

        if (!$idFormulario) {
            return $this->responder(500, 'Error al crear el pedido. Intenta de nuevo.');
        }

        // Crear pedido en estado 'por_aprobar'
        $pedidoModel = new PedidoModel();
        $idPedido    = $pedidoModel->crearDesdFormulario($idFormulario, (int) $post['idservicio']);

        // Notificar al administrador (id=1) 
        // El admin verá esta notificación en su panel
        $notificacionesModel = new NotificacionesModel();
        $notificacionesModel->crear(
            $idPedido,
            1, // id del administrador (ntorres_rf)
            'Nuevo pedido recibido',
            "La empresa {$empresa['nombreempresa']} ha enviado un nuevo pedido: \"{$post['titulo']}\" — pendiente de revisión.",
            'estado'
        );

        return $this->responder(201, 'Pedido creado correctamente.', [
            'idformulario' => $idFormulario,
            'idpedido'     => $idPedido,
        ]);
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