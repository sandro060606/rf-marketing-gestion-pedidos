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


// ADMINISTRADOR
$routes->group('admin', ['filter' => 'sesion'], function($routes) {
    // Panel principal / dashboard
    $routes->get('panel', 'Administrador\DashboardController::index');

    // Empresas
    $routes->get('empresas', 'Administrador\EmpresasController::index');
    // Usuarios
    $routes->get('usuarios', 'Administrador\UsuariosController::index');
});

// RESPONSABLE
$routes->group('responsable', ['filter' => 'sesion'], function($routes) {
    // Pedidos de su área
    $routes->get('pedidos-area',        'Responsable\PedidosAreaController::index');
});

// EMPLEADO
$routes->group('empleado', ['filter' => 'sesion'], function($routes) {
    // Pedidos asignados
    $routes->get('mis-pedidos',         'Empleado\PedidosController::index');
});

/**
 * Grupo de Rutas para el Panel del Cliente
 */
$routes->group('cliente', ['filter' => 'sesion'], function($routes) {

    // Módulo: Historial y Detalles
    // Listado principal de requerimientos del cliente
    $routes->get('mis-pedidos', 'Cliente\MisPedidosController::index');
    // Vista detallada de un pedido específico
    $routes->get('mis-pedidos/(:num)', 'Cliente\MisPedidosController::detalle/$1');

    // Módulo: Generación de Requerimientos
    // Catálogo de servicios disponibles para iniciar un pedido
    $routes->get('nuevo-pedido',  'Cliente\FormularioController::index');
    // Carga del formulario específico según el ID del servicio
    $routes->get('nuevo-pedido/(:num)', 'Cliente\FormularioController::formulario/$1');

    // Módulo: Centro de Notificaciones
    // Alertas de cambios de estado y mensajes de la agencia
    $routes->get('notificaciones', 'Cliente\NotificacionesController::index');
});