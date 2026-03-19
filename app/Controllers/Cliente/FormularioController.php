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
        $servicioModel = new ServicioModel();
        $servicios = $servicioModel->listarActivos();

        return view('cliente/nuevo-pedido', [
            'titulo' => 'Nuevo Pedido',
            'servicios' => $servicios,
            'css_extra' => '<link rel="stylesheet" href="' . base_url('recursos/styles/paginas/nuevo-pedido.css') . '">',
        ]);
    }

    public function formulario(int $idServicio)
{
    $servicioModel = new ServicioModel();
    $servicio      = $servicioModel->find($idServicio);
 
    if (!$servicio) {
        return redirect()->to('/cliente/nuevo-pedido');
    }
 
    $esAudiovisual = (int) $servicio['id'] === 2;
 
    $empresaModel = new EmpresaModel();
    $empresa      = $empresaModel->buscarPorUsuario(session()->get('id'));
 
    return view('cliente/formulario-pedido', [
        'titulo'    => 'Nuevo Pedido',
        'servicio'  => $servicio,
        'empresa'   => $empresa,
        'tipos'     => $esAudiovisual ? [
            'Adaptación de Arte', 'Creación de Arte', 'Creación de Videos',
            'Creación de Editorial', 'Adaptación de Editorial', 'Modificación Web',
        ] : [
            'Adaptación de Arte', 'Creación de Arte', 'Creación de Editorial',
            'Adaptación de Editorial', 'Modificación Pagina Web',
        ],
        'canales'   => [
            'Por correo', 'Página web', 'Redes sociales',
            'SIGU o Aula Virtual Estudiantes', 'SIGU o Aula Virtual Docentes',
            'Impresión física de folletos', 'Banner físico', 'Letreros',
            'Merch para eventos específicos',
        ],
        'formatos'  => $esAudiovisual ? [
            'Reels de Facebook/Instagram', 'Historia Facebook/Instagram',
            'Reel/Historia TikTok', 'Reels de LinkedIn', 'Historia de Whatsapp',
            'Video para Youtube', 'SIGU (comunicado)', 'Aula Virtual (Pop up)',
            'Pantallas LED publicitarias', 'Spot publicitario para TV',
            'Videos para proyección de eventos', 'Reels para Pauta', 'Otros',
        ] : [
            'Emailing', 'Post de Facebook/Instagram', 'Historia Facebook/Instagram',
            'Historia de Whatsapp', 'Post de LinkedIn', 'SIGU (comunicado)',
            'Aula Virtual (Pop up)', 'Wallpaper – Computadoras', 'Banner Web Portada',
            'Volante A5', 'Afiche A4', 'Afiche A3', 'Credenciales', 'Banner 2x1',
            'Tarjeta Personal', 'Tríptico', 'Díptico', 'Folder A4', 'Brochure',
            'Cartilla', 'Banderola', 'Módulos', 'SMS', 'IVR', 'Marcos Selfie',
            'Boletín', 'Guías', 'Imagen JPG - PNG', 'Otros',
        ],
        'css_extra' => '<link rel="stylesheet" href="' . base_url('recursos/styles/paginas/nuevo-pedido.css') . '">',
    ]);
}

    // Flujo completo:
    // 1. Valida campos obligatorios
    // 2. Crea el formulario en formulario_pedidos
    // 3. Crea el pedido en estado 'por_aprobar'
    // 4. Sube archivos adjuntos si los hay
    // 5. Notifica al administrador del nuevo pedido
    public function guardar() {
        $idUsuario = session()->get('id');

        // Obtener empresa del cliente
        $empresaModel = new EmpresaModel();
        $empresa = $empresaModel->buscarPorUsuario($idUsuario);

        if (!$empresa) {
            return redirect()->back()
                ->with('error', 'No tienes una empresa registrada.');
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
                return redirect()->back()
                    ->withInput()
                    ->with('error', "El campo '{$campo}' es obligatorio.");
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
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error al crear el pedido. Intenta de nuevo.');
        }

        // Crear pedido en estado 'por_aprobar'
        $pedidoModel = new PedidoModel();
        $idPedido = $pedidoModel->crearDesdFormulario($idFormulario, (int) $post['idservicio']);

        //Subir Archivos Adjuntos
        // Registrar archivos subidos via AJAX (vienen como JSON en campo oculto)
        $rutasArchivos = json_decode($post['archivos_rutas'] ?? '[]', true);

        if (!empty($rutasArchivos)) {
            $archivoModel = new ArchivoModel();
            foreach ($rutasArchivos as $ruta) {
                $nombre = basename($ruta); // extrae solo el nombre del archivo
                $archivoModel->subirEntrada($idFormulario, $nombre, $ruta, 0);
            }
        }

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
        // Éxito → redirigir a mis-pedidos con mensaje
        return redirect()->to('/cliente/mis-pedidos')
            ->with('exito', '¡Pedido enviado correctamente! Te notificaremos cuando sea revisado.');
    }

    // Subida temporal de archivos antes de crear el pedido
    // Los archivos se vinculan al formulario después de enviarlo
    public function subirArchivoTemp()
    {
        $archivo = $this->request->getFile('archivo');
        if (!$archivo || !$archivo->isValid()) {
            return $this->response->setStatusCode(422)->setJSON(['status' => 422, 'mensaje' => 'Archivo no válido.']);
        }

        $resultado = $this->procesarArchivo($archivo, 'temp');
        if (!$resultado) {
            return $this->response->setStatusCode(422)->setJSON(['status' => 422, 'mensaje' => 'Error al procesar archivo.']);
        }

        return $this->response->setStatusCode(201)->setJSON(['status' => 201, 'mensaje' => 'Archivo subido.', 'data' => $resultado]);
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
            return $this->response->setStatusCode(404)->setJSON([
                'status' => 404,
                'mensaje' => 'Pedido no encontrado.',
            ]);
        }

        // Obtener el archivo del request 
        $archivo = $this->request->getFile('archivo');

        // Verificar que se envió un archivo
        if (!$archivo || !$archivo->isValid()) {
            return $this->response->setStatusCode(422)->setJSON([
                'status' => 422,
                'mensaje' => 'No se recibió ningún archivo válido.',
            ]);
        }

        // Validar extensión
        $extensionesPermitidas = ['jpg', 'jpeg', 'png', 'gif', 'pdf', 'ai', 'psd', 'mp4', 'zip'];
        $extension = strtolower($archivo->getExtension());

        if (!in_array($extension, $extensionesPermitidas)) {
            return $this->response->setStatusCode(422)->setJSON([
                'status' => 422,
                'mensaje' => "Extensión '.{$extension}' no permitida.",
            ]);
        }

        //  Validar tamaño (máx 10MB = 10 * 1024 * 1024) 
        $tamanoMaximo = 50 * 1024 * 1024;
        if ($archivo->getSize() > $tamanoMaximo) {
            return $this->response->setStatusCode(422)->setJSON([
                'status' => 422,
                'mensaje' => 'El archivo supera el tamaño máximo de 50MB.',
            ]);
        }

        // Generar nombre único para evitar duplicados 
        // Formato: entrada_[idformulario]_[timestamp].[ext]
        $idFormulario = $pedidoRaw['idformpedido'];
        $nombreUnico = "entrada_{$idFormulario}_" . time() . ".{$extension}";

        // Mover el archivo a la carpeta de entradas
        $carpetaDestino = FCPATH . 'archivos-subidos/entradas/';

        if (!$archivo->move($carpetaDestino, $nombreUnico)) {
            return $this->response->setStatusCode(500)->setJSON([
                'status' => 500,
                'mensaje' => 'Error al guardar el archivo.',
            ]);
        }

        // Registrar en la BD
        $archivoModel = new ArchivoModel();
        $idArchivo = $archivoModel->subirEntrada(
            $idFormulario,
            $archivo->getClientName(), // Nombre original del archivo
            'archivos-subidos/entradas/' . $nombreUnico, // Ruta relativa
            $archivo->getSize()
        );

        return $this->response->setStatusCode(201)->setJSON([
            'status' => 201,
            'mensaje' => 'Archivo subido correctamente.',
            'data' => [
                'id' => $idArchivo,
                'nombre' => $archivo->getClientName(),
                'ruta' => 'archivos-subidos/entradas/' . $nombreUnico,
                'tamano' => $archivo->getSize(),
            ],
        ]);
    }   
    // Método privado reutilizable para validar y mover archivos
    private function procesarArchivo($archivo, string $prefijo = 'entrada'): array|false
    {
        $extensionesPermitidas = ['jpg', 'jpeg', 'png', 'gif', 'pdf', 'ai', 'psd', 'mp4', 'zip'];
        $extension = strtolower($archivo->getExtension());

        if (!in_array($extension, $extensionesPermitidas))
            return false;
        if ($archivo->getSize() > 50 * 1024 * 1024)
            return false;

        $nombreUnico = "{$prefijo}_" . time() . rand(100, 999) . ".{$extension}";
        $carpetaDestino = FCPATH . 'archivos-subidos/entradas/';

        if (!$archivo->move($carpetaDestino, $nombreUnico))
            return false;

        return [
            'nombre' => $archivo->getClientName(),
            'ruta' => 'archivos-subidos/entradas/' . $nombreUnico,
            'tamano' => $archivo->getSize(),
        ];
    }
}