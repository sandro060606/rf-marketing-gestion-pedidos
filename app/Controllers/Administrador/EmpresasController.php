<?php
namespace App\Controllers\Administrador;
use App\Controllers\BaseController;
use App\Models\EmpresaModel;

class EmpresasController extends BaseController {
    protected $empresaModel;

    /**
     * Inicializa el modelo de empresas.
     */

    public function __construct() {
        $this->empresaModel = new EmpresaModel();
    }


    /**
     *  Muestra el listado de todas las empresas con sus estadísticas de pedidos.
     *
     * @return void Vista con la lista de empresas
     */
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