<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/acceso', 'Usuario::index');
$routes->post('/login', 'Usuario::c_login_in');
$routes->get('/logout', 'Usuario::c_logout');
$routes->get('/home', 'Inicio::index');

$routes->get('/persona', 'Persona::index');
$routes->get('/recipientes', 'Recipientes::index');
$routes->get('/actividades', 'Actividades::index');