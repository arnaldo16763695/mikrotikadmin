<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'LoginController::index');

$routes->group('', ['filter' => 'auth'], function ($routes) {

    $routes->get('/home', 'HomeController::index');
    $routes->get('/home/users/add', 'HomeController::addUser');
    $routes->post('/saveUser', 'HomeController::saveUser');
    $routes->post('/patchUser', 'HomeController::patchUser');
    $routes->get('/home/users/edit/(:any)', 'HomeController::editUser/$1');
    $routes->get('/home/users/delete/(:any)', 'HomeController::deleteUser/$1');


    //user routes
    $routes->get('/users', 'UsersController::index');
    $routes->get('/users/add', 'UsersController::addUser');
    $routes->post('/saveUserSystem', 'UsersController::saveUser');
    $routes->get('/users/edit/(:any)', 'UsersController::editUser/$1');
    $routes->post('/patchUserSystem', 'UsersController::patchUser');
    $routes->get('/users/delete/(:any)', 'UsersController::deleteUser/$1');
});
$routes->get('/logout', 'LoginController::logout');

$routes->post('/auth', 'LoginController::auth');
