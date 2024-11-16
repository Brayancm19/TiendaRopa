<?php

// Autoload de clases (si no estás usando Composer)
require_once '../src/controllers/PrendasController.php';
require_once '../src/controllers/MarcasController.php';
require_once '../src/controllers/ReportesController.php';

// Rutas para operaciones CRUD de Prendas
$router->get('/api/tienda/public/prendas', 'PrendasController@getAll');  // Obtener todas las prendas
$router->post('/api/tienda/public/prendas', 'PrendasController@create');  // Crear una prenda
$router->put('/api/tienda/public/prendas/{id}', 'PrendasController@update');  // Actualizar una prenda
$router->delete('/api/tienda/public/prendas/{id}', 'PrendasController@delete');  // Eliminar una prenda

// Rutas para operaciones CRUD de Marcas
$router->get('/api/tienda/public/marcas', 'MarcasController@getAll');  // Obtener todas las marcas
$router->post('/api/tienda/public/marcas', 'MarcasController@create');  // Crear una marca

// Rutas para los reportes
$router->get('/api/tienda/public/reportes/marcas-con-ventas', 'ReportesController@marcasConVentas');  // Listar marcas con al menos una venta
$router->get('/api/tienda/public/reportes/prendas-vendidas', 'ReportesController@prendasVendidas');  // Mostrar prendas vendidas
$router->get('/api/tienda/public/reportes/top5-marcas', 'ReportesController@top5Marcas');  // Listar las 5 marcas más vendidas
?>
