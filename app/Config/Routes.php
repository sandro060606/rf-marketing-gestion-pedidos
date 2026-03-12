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

// Destruye la sesión y regresa al login
$routes->get('/logout', 'Autenticacion\AuthController::logout');