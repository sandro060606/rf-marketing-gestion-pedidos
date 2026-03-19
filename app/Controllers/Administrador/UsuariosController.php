<?php

namespace App\Controllers\Administrador;

use App\Controllers\BaseController;
use App\Models\UsuarioModel;
use App\Models\EmpresaModel;

class UsuariosController extends BaseController
{
    public function index()
{
    $usuarioModel  = new UsuarioModel();
    $empresaModel  = new EmpresaModel();

    $empresas = $empresaModel->obtenerConStats();

    return view('administrador/usuarios/lista', [
        'paginaActual'   => 'usuarios',
        'titulo'         => 'USUARIOS',
        'tituloPagina'  => 'USUARIOS',
        'usuarios'       => $usuarioModel->obtenerTodosConArea(),
        'empresas'       => $empresas,
        'contador_total' => count($empresas),
    ]);
    }
}