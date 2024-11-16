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

// Ajustar la URI para que coincida con la estructura correcta
$uri = str_replace('/TiendaRopa/API/public/index.php', '', $uri);

// Rutas para el controlador Marca
if ($_SERVER['REQUEST_METHOD'] === 'GET' && $uri === '/marcas') {
    $marcaController->getMarcas();
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && $uri === '/marcas') {
    $marcaController->createMarca();
} elseif ($_SERVER['REQUEST_METHOD'] === 'PUT' && $uri === '/marcas') {
    $marcaController->updateMarca();
} elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE' && $uri === '/marcas') {
    $marcaController->deleteMarca();
}

// Rutas para el controlador Prenda
elseif ($_SERVER['REQUEST_METHOD'] === 'GET' && $uri === '/prendas') {
    $prendaController->getPrendas();
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && $uri === '/prendas') {
    $prendaController->createPrenda();
} elseif ($_SERVER['REQUEST_METHOD'] === 'PUT' && $uri === '/prendas') {
    $prendaController->updatePrenda();
} elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE' && $uri === '/prendas') {
    $prendaController->deletePrenda();
}

// Rutas para el controlador Venta
elseif ($_SERVER['REQUEST_METHOD'] === 'GET' && $uri === '/ventas') {
    $ventaController->getVentas();
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && $uri === '/ventas') {
    $ventaController->createVenta();
} elseif ($_SERVER['REQUEST_METHOD'] === 'PUT' && $uri === '/ventas') {
    $ventaController->updateVenta();
} elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE' && $uri === '/ventas') {
    $ventaController->deleteVenta();
}

// Ruta no encontrada
else {
    header("HTTP/1.1 404 Not Found");
    echo json_encode(["message" => "Ruta no encontrada"]);
}
?>
