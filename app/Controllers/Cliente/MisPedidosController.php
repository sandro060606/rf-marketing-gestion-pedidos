<?php
namespace App\Controllers\Cliente;
use CodeIgniter\Controller;
class MisPedidosController extends Controller
{
    public function index() {
        return 'Panel Cliente — ' . session()->get('nombre');
    }
}