<?php

namespace App\Controllers\Administrador;

use CodeIgniter\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        return 'Bienvenido, ' . session()->get('nombre') . ' — Rol: ' . session()->get('rol');
    }
}