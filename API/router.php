<?php
set_include_path(__DIR__ . '/src');
require_once 'controllers/MarcaController.php';
require_once 'controllers/PrendaController.php';
require_once 'controllers/VentaController.php';

// Inicializar controladores
$marcaController = new MarcaController();
$prendaController = new PrendaController();
$ventaController = new VentaController();

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$query = [];
parse_str(parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY), $query);

// Ajustar la URI para que coincida con la estructura correcta
$uri = str_replace('/TiendaRopa/API/public/index.php', '', $uri);

// Rutas para el controlador Marca
if ($_SERVER['REQUEST_METHOD'] === 'GET' && $uri === '/marcas') {
    $marcaController->getMarcas();
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && $uri === '/marcas') {
    $marcaController->createMarca();
} elseif ($_SERVER['REQUEST_METHOD'] === 'PUT' && $uri === '/marcas' && isset($query['id'])) {
    $marcaController->updateMarca($query['id']);
} elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE' && $uri === '/marcas' && isset($query['id'])) {
    $marcaController->deleteMarca($query['id']);
}

// Rutas para el controlador Prenda
elseif ($_SERVER['REQUEST_METHOD'] === 'GET' && $uri === '/prendas') {
    $prendaController->getPrendas();
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && $uri === '/prendas') {
    $prendaController->createPrenda();
} elseif ($_SERVER['REQUEST_METHOD'] === 'PUT' && $uri === '/prendas' && isset($query['id'])) {
    $prendaController->updatePrenda($query['id']);
} elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE' && $uri === '/prendas' && isset($query['id'])) {
    $prendaController->deletePrenda($query['id']);
}

// Rutas para el controlador Venta
elseif ($_SERVER['REQUEST_METHOD'] === 'GET' && $uri === '/ventas') {
    $ventaController->getVentas();
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && $uri === '/ventas') {
    $ventaController->createVenta();
} elseif ($_SERVER['REQUEST_METHOD'] === 'PUT' && $uri === '/ventas' && isset($query['id'])) {
    $ventaController->updateVenta($query['id']);
} elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE' && $uri === '/ventas' && isset($query['id'])) {
    $ventaController->deleteVenta($query['id']);
}

// Ruta no encontrada
else {
    header("HTTP/1.1 404 Not Found");
    echo json_encode(["message" => "Ruta no encontrada"]);
}
?>
