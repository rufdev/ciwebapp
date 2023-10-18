<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();

$routes->get('dashboard', 'DashboardController::index', ['filter' => 'auth']);


$routes->post('authors/list', 'AuthorController::getall', ['filter' => 'groupfilter:admin']);

$routes->resource('authors', ['controller' => 'AuthorController', 'filter' => 'groupfilter:admin', 'except' => ['new,edit']]);
$routes->resource('posts', ['controller' => 'PostController', 'filter' => 'auth', 'except' => ['new,edit']]);





service('auth')->routes($routes);
