<?php
// app/Controllers/Administrador/EmpresasController.php

namespace App\Controllers\Administrador;
use App\Controllers\BaseController;
use App\Models\EmpresaModel; // Importa el modelo

class EmpresasController extends BaseController {
    
    protected $empresaModel;

    public function __construct() {
        // Inicializa el modelo en el constructor para usarlo en todos los métodos
        $this->empresaModel = new EmpresaModel();
    }

    public function index() {
        // 1. Obtiene todas las empresas de la base de datos
        $empresas = $this->empresaModel->obtenerTodas();
        
        // Puedes añadir lógica aquí para obtener contadores globales (opcional)
        // Ejemplo: contar todas las activas, completadas, etc.

        // 2. Prepara los datos para la vista
        $data = [
            'paginaActual' => 'todas_empresas', // Estado para la barra lateral
            'titulo'       => 'Todas las Empresas',
            'empresas'     => $empresas, // Lista dinámica de empresas
            'contador_total' => count($empresas) // Contador para la barra lateral
        ];

        // 3. Renderiza la vista principal (con tu diseño de tarjetas, como la imagen)
        return view('administrador/empresas/lista', $data);
    }

    // Método para la vista individual de una empresa
    public function detalle($idEmpresa) {
        // Lógica para obtener solo UNA empresa por su ID y pasarla a otra vista
        // (Esto lo veremos luego, como mencionaste).
        $data['paginaActual'] = 'empresa_'.$idEmpresa; // Estado activo específico
        $data['titulo'] = 'Empresa ' . $idEmpresa;
        return view('administrador/empresas/detalle', $data); 
    }
}