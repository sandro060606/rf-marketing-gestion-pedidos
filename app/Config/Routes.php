<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

// AUTENTICACION
// Página de inicio redirige al login
$routes->get('/',       'Autenticacion\AuthController::login');
// Muestra el formulario de login
$routes->get('/login',  'Autenticacion\AuthController::login');
// Recibe y procesa los datos del formulario
$routes->post('/login', 'Autenticacion\AuthController::autenticar');
// Cerrar sesión
$routes->get('/logout', 'Autenticacion\AuthController::logout');


// ── ADMINISTRADOR ─────────────────────────────────────────
$routes->group('admin', ['filter' => 'sesion'], function($routes) {
    // Panel principal / dashboard
    $routes->get('panel', 'Administrador\DashboardController::index');
});

// ── RESPONSABLE ───────────────────────────────────────────
$routes->group('responsable', ['filter' => 'sesion'], function($routes) {
    // Pedidos de su área
    $routes->get('pedidos-area',        'Responsable\PedidosAreaController::index');
});

// ── EMPLEADO ──────────────────────────────────────────────
$routes->group('empleado', ['filter' => 'sesion'], function($routes) {
    // Pedidos asignados
    $routes->get('mis-pedidos',         'Empleado\PedidosController::index');
});
 
 
// ── CLIENTE ───────────────────────────────────────────────
$routes->group('cliente', ['filter' => 'sesion'], function($routes) {

    // Ver sus pedidos
    $routes->get('mis-pedidos', 'Cliente\MisPedidosController::index');
});