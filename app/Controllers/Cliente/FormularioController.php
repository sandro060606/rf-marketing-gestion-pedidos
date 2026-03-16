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

    // Recibe los datos del formulario, los valida y crea el registro en formulario_pedidos.
    // Crea automáticamente el pedido en estado 'por_aprobar' para que el administrador lo vea en el panel.
    public function guardar()
    {
        $idUsuario = 8/* session()->get('id') */;
 
        //Obtener empresa del cliente
        $empresaModel = new EmpresaModel();
        $empresa      = $empresaModel->buscarPorUsuario($idUsuario);
 
        if (!$empresa) {
            return $this->responder(404, 'No tienes una empresa registrada.');
        }
 
        //Obtener datos del POST
        $post = $this->request->getPost();
 
        //Validación de campos obligatorios
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
        // Si vienen como string se guardan tal cual (ya es JSON)
        // Si vienen como array se convierten a JSON
        $canales  = is_array($post['canales_difusion'] ?? null)
            ? json_encode($post['canales_difusion'])
            : ($post['canales_difusion'] ?? '[]');
 
        $formatos = is_array($post['formatos_solicitados'] ?? null)
            ? json_encode($post['formatos_solicitados'])
            : ($post['formatos_solicitados'] ?? '[]');
 
        // Preparar datos para insertar
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
 
        // Crear el formulario
        $formularioModel = new FormularioModel();
        $idFormulario    = $formularioModel->crear($datos);
 
        if (!$idFormulario) {
            return $this->responder(500, 'Error al crear el pedido. Intenta de nuevo.');
        }
 
        //Crear el pedido automáticamente en 'por_aprobar' (Admin)
        $pedidoModel = new \App\Models\PedidoModel();
        $pedidoModel->crearDesdFormulario($idFormulario, (int) $post['idservicio']);
 
        return $this->responder(201, 'Pedido creado correctamente.', [
            'idformulario' => $idFormulario,
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