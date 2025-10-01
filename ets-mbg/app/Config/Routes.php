<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/login', 'AuthController::login');
$routes->post('/login/process', 'AuthController::processLogin');
$routes->get('/logout', 'AuthController::logout');
$routes->resource('bahan_baku', ['controller' => 'BahanBakuController']);