<?php

namespace App\Filters;

// Filtro que protege rutas privadas.
// Se ejecuta ANTES de que el controlador cargue.
// Si el usuario no tiene sesión activa → redirige al login.

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class VerificarSesion implements FilterInterface
{
    // Revisa si existe la clave 'autenticado' en la sesión.
    // Si no existe → corta el flujo y redirige al login.
    public function before(RequestInterface $request, $arguments = null)
    {
        if (!session()->get('autenticado')) {
            // No hay sesión → redirigir al login
            return redirect()->to('/login');
        }
        // Hay sesión → dejar pasar al controlador (no retorna nada)
    }
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Sin acción
    }
}