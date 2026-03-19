<?php
namespace App\Controllers\Administrador;
use App\Controllers\BaseController;
use App\Models\EmpresaModel;

class EmpresasController extends BaseController {
    protected $empresaModel;

    public function __construct() {
        $this->empresaModel = new EmpresaModel();
    }

    public function index() {
        $listado = $this->empresaModel->obtenerConStats();
        return view('administrador/empresas/lista', [
            'paginaActual'   => 'todas_empresas',
            'titulo'         => 'EMPRESAS',
            'tituloPagina'  => 'EMPRESAS',
            'empresas'       => $listado,
            'contador_total' => count($listado)
        ]);
    }

}