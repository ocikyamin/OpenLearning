<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('user', 'UserController::index');
$routes->get('user/list', 'UserController::List');
$routes->get('user/form', 'UserController::Form');
$routes->post('user/store', 'UserController::Store');
$routes->post('user/delete', 'UserController::Delete');

// $routes->get('/', 'Home::index');

