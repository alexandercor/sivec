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
$routes->post('/usuario/update', 'Usuario::c_usuario_update');
$routes->post('/usuario/show', 'Usuario::c_usuario_update_habilitado');
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
$routes->post('/esssalud/add', 'Essalud::c_essalud_crud');
$routes->post('/esssalud/del', 'Essalud::c_essalud_del');
$routes->post('/ubigeo/sector', 'Ubigeo::c_ubigeo_sector');
$routes->get('/localidad', 'Localidad::index');
$routes->post('/localidad/list', 'Localidad::c_localidad_list');
$routes->post('/localidad/add', 'Localidad::c_localidad_crud');
$routes->post('/localidad/del', 'Localidad::c_localidad_del');
$routes->get('/sector', 'Sector::index');
$routes->post('/sector/list', 'Sector::c_sector_list');
$routes->post('/sector/add', 'Sector::c_sector_crud');
$routes->post('/sector/del', 'Sector::c_sector_del');
$routes->get('/seguimiento', 'Seguimiento::index');
$routes->post('/seguimiento/coordenadaslist', 'Seguimiento::c_seguimiento_listar_coordenadas');
$routes->get('/seguimiento-sospechosos', 'Seguimiento::csospechoso_index');
$routes->post('/seguimiento/sospechosos', 'Seguimiento::c_seguimiento_sospechosos');
// ---
$routes->get('reportes/prueba', 'Reportes\Reporteprueba::c_reportes_prueba');
$routes->get('reportes-inspeccion', 'Reportes\CoreReport::c_inspeccion_inspeccion_index');
$routes->post('inspecciones/list', 'Reportes\CoreReport::c_inspeccion_inspeccionados_list');
$routes->get('reportes/inspeccion/xls/(:any)', 'Reportes\ReportesInspeccion::c_reportes_inspeccion_xls/$1');
$routes->get('reportes-consolidado-diario', 'Reportes\CoreReport::c_consolidado_diario_index');
$routes->get('reportes/consolidado-diario/xls/(:any)/(:any)', 'Reportes\ReporteConsolidado::c_reportes_consolidado_xls/$1/$2');
