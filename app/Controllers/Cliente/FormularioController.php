<?php

namespace App\Controllers\Cliente;

use CodeIgniter\Controller;
use App\Models\ServicioModel;
use App\Models\FormularioModel;
use App\Models\EmpresaModel;
use App\Models\PedidoModel;
use App\Models\NotificacionesModel;
use App\Models\ArchivoModel;

class FormularioController extends Controller
{
    // GET /cliente/nuevo-pedido
    // Devuelve servicios disponibles + datos de la empresa
    public function index()
    {
        $idUsuario = 8/* session()->get('id') */ ;

        $empresaModel = new EmpresaModel();
        $empresa = $empresaModel->buscarPorUsuario($idUsuario);

        if (!$empresa) {
            return $this->responder(404, 'No tienes una empresa registrada.');
        }

        $servicioModel = new ServicioModel();
        $servicios = $servicioModel->listarActivos();

        return $this->responder(200, 'Datos para nuevo pedido.', [
            'empresa' => $empresa,
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
        $idUsuario = 8/* session()->get('id') */ ;

        // Obtener empresa del cliente
        $empresaModel = new EmpresaModel();
        $empresa = $empresaModel->buscarPorUsuario($idUsuario);

        if (!$empresa) {
            return $this->responder(404, 'No tienes una empresa registrada.');
        }

        // Obtener datos del POST
        $post = $this->request->getPost();

        // Validación de campos obligatorios
        $camposObligatorios = [
            'idservicio',
            'titulo',
            'area',
            'objetivo_comunicacion',
            'descripcion',
            'tipo_requerimiento',
            'fecharequerida',
            'prioridad'
        ];

        foreach ($camposObligatorios as $campo) {
            if (empty($post[$campo])) {
                return $this->responder(422, "El campo '{$campo}' es obligatorio.");
            }
        }

        // Canales y formatos van guardados como JSON
        $canales = is_array($post['canales_difusion'] ?? null)
            ? json_encode($post['canales_difusion'])
            : ($post['canales_difusion'] ?? '[]');

        $formatos = is_array($post['formatos_solicitados'] ?? null)
            ? json_encode($post['formatos_solicitados'])
            : ($post['formatos_solicitados'] ?? '[]');

        // Crear el formulario 
        $datos = [
            'idempresa' => $empresa['id'],
            'idservicio' => (int) $post['idservicio'],
            'titulo' => $post['titulo'],
            'area' => $post['area'],
            'objetivo_comunicacion' => $post['objetivo_comunicacion'],
            'descripcion' => $post['descripcion'],
            'tipo_requerimiento' => $post['tipo_requerimiento'],
            'canales_difusion' => $canales,
            'publico_objetivo' => $post['publico_objetivo'] ?? null,
            'tiene_materiales' => filter_var($post['tiene_materiales'] ?? false, FILTER_VALIDATE_BOOLEAN),
            'formatos_solicitados' => $formatos,
            'formato_otros' => $post['formato_otros'] ?? null,
            'fecharequerida' => $post['fecharequerida'],
            'prioridad' => $post['prioridad'],
        ];

        $formularioModel = new FormularioModel();
        $idFormulario = $formularioModel->crear($datos);

        if (!$idFormulario) {
            return $this->responder(500, 'Error al crear el pedido. Intenta de nuevo.');
        }

        // Crear pedido en estado 'por_aprobar'
        $pedidoModel = new PedidoModel();
        $idPedido = $pedidoModel->crearDesdFormulario($idFormulario, (int) $post['idservicio']);

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
            'idpedido' => $idPedido,
        ]);
    }

    // El cliente sube archivos de referencia adjuntos al formulario de su pedido (logos, briefs, fotos, etc.)
    // Extensiones permitidas: jpg, jpeg, png, pdf, ai, psd, mp4
    // Tamaño máximo: 10MB por archivo
    public function subirArchivo(int $idPedido)
    {
        // Verificar que el pedido exista
        $pedidoModel = new PedidoModel();
        $pedidoRaw = $pedidoModel->find($idPedido);

        if (!$pedidoRaw) {
            return $this->responder(404, 'Pedido no encontrado.');
        }

        // Obtener el archivo del request 
        $archivo = $this->request->getFile('archivo');

        // Verificar que se envió un archivo
        if (!$archivo || !$archivo->isValid()) {
            return $this->responder(422, 'No se recibió ningún archivo válido.');
        }

        // Validar extensión
        $extensionesPermitidas = ['jpg', 'jpeg', 'png', 'gif', 'pdf', 'ai', 'psd', 'mp4', 'zip'];
        $extension = strtolower($archivo->getExtension());

        if (!in_array($extension, $extensionesPermitidas)) {
            return $this->responder(422, "Extensión '.{$extension}' no permitida. Usa: " . implode(', ', $extensionesPermitidas));
        }

        //  Validar tamaño (máx 10MB = 10 * 1024 * 1024) 
        $tamanoMaximo = 50 * 1024 * 1024;
        if ($archivo->getSize() > $tamanoMaximo) {
            return $this->responder(422, 'El archivo supera el tamaño máximo de 10MB.');
        }

        // Generar nombre único para evitar duplicados 
        // Formato: entrada_[idformulario]_[timestamp].[ext]
        $idFormulario = $pedidoRaw['idformpedido'];
        $nombreUnico = "entrada_{$idFormulario}_" . time() . ".{$extension}";

        // Mover el archivo a la carpeta de entradas
        $carpetaDestino = FCPATH . 'archivos-subidos/entradas/';

        if (!$archivo->move($carpetaDestino, $nombreUnico)) {
            return $this->responder(500, 'Error al guardar el archivo. Intenta de nuevo.');
        }

        // Registrar en la BD
        $archivoModel = new ArchivoModel();
        $idArchivo = $archivoModel->subirEntrada(
            $idFormulario,
            $archivo->getClientName(), // Nombre original del archivo
            'archivos-subidos/entradas/' . $nombreUnico, // Ruta relativa
            $archivo->getSize()
        );

        return $this->responder(201, 'Archivo subido correctamente.', [
            'id' => $idArchivo,
            'nombre' => $archivo->getClientName(),
            'ruta' => 'archivos-subidos/entradas/' . $nombreUnico,
            'tamano' => $archivo->getSize(),
        ]);
    }

    // PRIVADO: Respuesta JSON estándar
    private function responder(int $status, string $mensaje, mixed $data = null)
    {
        return $this->response
            ->setStatusCode($status)
            ->setJSON([
                'status' => $status,
                'mensaje' => $mensaje,
                'data' => $data,
            ]);
    }
}