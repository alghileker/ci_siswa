<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'Home::index');
$routes->post('home/tambah', 'Home::tambah', ['filter' => 'csrf']);
$routes->post('home/update/(:num)', 'Home::update/$1', ['filter' => 'csrf']);
$routes->get('home/hapus/(:num)', 'Home::hapus/$1');
