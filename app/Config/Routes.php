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

$routes->post('/departamentos', 'Infocore::c_departamentos_list');
$routes->post('/provincias', 'Infocore::c_provincias_list');
$routes->post('/distritos', 'Infocore::c_distritos_list');
$routes->post('/localidad', 'Infocore::c_localidad_list');
$routes->post('/sector', 'Infocore::c_sector_list');

$routes->get('/usuarios', 'Usuario::c_usuarios_index');
$routes->post('/usuarios/list', 'Usuario::c_usuario_list');
$routes->post('usuario/update', 'Usuario::c_usuario_update');
$routes->get('/persona', 'Persona::index');
$routes->post('/persona/list', 'Persona::c_persona_list');
$routes->post('/persona/add', 'Persona::c_persona_crud');
$routes->post('/persona/del', 'Persona::c_persona_del');
$routes->get('/recipientes', 'Recipientes::index');
$routes->post('/recipiente/list', 'Recipientes::c_recipiente_list');
$routes->post('/recipiente/add', 'Recipientes::c_recipiente_crud');
$routes->post('/recipiente/del', 'Recipientes::c_recipiente_del');
$routes->get('/actividades', 'Actividades::index');
$routes->post('/actividadeslist', 'Actividades::c_actividades_list');
$routes->post('/actividades/add', 'Actividades::c_actividades_crud');
$routes->post('/actividades/del', 'Actividades::c_actividad_del');
$routes->get('/control', 'Control::index');
$routes->get('/essalud', 'Essalud::index');
$routes->post('/esssalud/list', 'Essalud::c_essalud_list');
