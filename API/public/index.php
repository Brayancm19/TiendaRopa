<?php
// Incluye los archivos necesarios
require_once '../../src/config/database.php';
require_once '../../src/controllers/PrendaController.php';
require_once '../../src/controllers/MarcaController.php';
require_once '../../src/controllers/ReporteController.php';

// Obtén la URL de la solicitud
$request = $_SERVER['REQUEST_URI'];

// Elimina parámetros de la URL
$request = strtok($request, '?');

// Define el enrutamiento básico
switch ($request) {
    case '/TiendaRopa/api/tienda/public/prendas':
        // Crear una instancia del controlador de prendas y llamar el método adecuado
        $controller = new PrendaController();
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $controller->getPrendas();
        } elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $controller->createPrenda();
        }
        break;
    
    case '/TiendaRopa/api/tienda/public/prendas/':
        $controller = new PrendaController();
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $controller->getPrenda($_GET['id']); // Suponiendo que el ID está en la URL
        } elseif ($_SERVER['REQUEST_METHOD'] == 'PUT') {
            $controller->updatePrenda($_GET['id']);
        } elseif ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
            $controller->deletePrenda($_GET['id']);
        }
        break;

    case '/TiendaRopa/api/tienda/public/reportes/marcas-con-ventas':
        $controller = new ReporteController();
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $controller->marcasConVentas();
        }
        break;

    default:
        // Si la ruta no es válida, retorna un error 404
        header("HTTP/1.0 404 Not Found");
        echo json_encode(["message" => "Ruta no encontrada"]);
        break;
}
