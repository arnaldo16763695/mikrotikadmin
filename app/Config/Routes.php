<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'LoginController::index');
$routes->get('/home', 'HomeController::index');
$routes->get('/home/users/add', 'HomeController::addUser');
$routes->post('/saveUser', 'HomeController::saveUser');
$routes->post('/patchUser', 'HomeController::patchUser');
$routes->get('/home/users/edit/(:any)', 'HomeController::editUser/$1');
$routes->get('/home/users/delete/(:any)', 'HomeController::deleteUser/$1');
