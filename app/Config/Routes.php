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

$routes->get('authors/list', 'AuthorController::getall');

$routes->resource('authors', ['controller' => 'AuthorController']);
$routes->resource('posts', ['controller' => 'PostController']);





service('auth')->routes($routes);
