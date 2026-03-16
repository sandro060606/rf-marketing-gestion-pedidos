<?php
namespace App\Controllers\Empleado;
use CodeIgniter\Controller;
class PedidosController extends Controller
{
    public function index() {
        return 'Panel Empleado — ' . session()->get('nombre');
    }
}