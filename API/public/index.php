<?php
set_include_path(__DIR__ . '/../src');
require_once 'controllers/MarcaController.php';
require_once 'controllers/PrendaController.php';
require_once 'controllers/VentaController.php';

// Inicializar controladores
$marcaController = new MarcaController();
$prendaController = new PrendaController();
$ventaController = new VentaController();

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Rutas para el controlador Marca
if ($_SERVER['REQUEST_METHOD'] === 'GET' && $uri === '/API/public/index.php/marcas') {
    $marcaController->getMarcas();
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && $uri === '/API/public/index.php/marcas') {
    $marcaController->createMarca();
} elseif ($_SERVER['REQUEST_METHOD'] === 'PUT' && $uri === '/API/public/index.php/marcas') {
    $marcaController->updateMarca();
} elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE' && $uri === '/API/public/index.php/marcas') {
    $marcaController->deleteMarca();
}

// Rutas para el controlador Prenda
elseif ($_SERVER['REQUEST_METHOD'] === 'GET' && $uri === '/API/public/index.php/prendas') {
    $prendaController->getPrendas();
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && $uri === '/API/public/index.php/prendas') {
    $prendaController->createPrenda();
} elseif ($_SERVER['REQUEST_METHOD'] === 'PUT' && $uri === '/API/public/index.php/prendas') {
    $prendaController->updatePrenda();
} elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE' && $uri === '/API/public/index.php/prendas') {
    $prendaController->deletePrenda();
}

// Rutas para el controlador Venta
elseif ($_SERVER['REQUEST_METHOD'] === 'GET' && $uri === '/API/public/index.php/ventas') {
    $ventaController->getVentas();
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && $uri === '/API/public/index.php/ventas') {
    $ventaController->createVenta();
} elseif ($_SERVER['REQUEST_METHOD'] === 'PUT' && $uri === '/API/public/index.php/ventas') {
    $ventaController->updateVenta();
} elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE' && $uri === '/API/public/index.php/ventas') {
    $ventaController->deleteVenta();
}

// Ruta no encontrada
else {
    header("HTTP/1.1 404 Not Found");
    echo json_encode(["message" => "Ruta no encontrada"]);
}
?>
