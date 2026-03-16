<?php
namespace App\Controllers\Responsable;
use CodeIgniter\Controller;
class PedidosAreaController extends Controller
{
    public function index() {
        return 'Panel Responsable — ' . session()->get('nombre');
    }
}