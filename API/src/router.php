<?php
// router.php
require_once 'src/controllers/MarcasController.php';
require_once 'src/controllers/ReportesController.php';

$marcasController = new MarcasController();
$reportesController = new ReportesController();

// Verificar la URL solicitada y el método HTTP
$request = $_SERVER['REQUEST_URI'];
$request = rtrim($request, '/'); // Eliminar barra final si la hay
$request = str_replace('/api/tienda/', '', $request); // Eliminar la base de la URL

// Dividir la URL en partes para manejar la ruta y los parámetros
$parts = explode('/', $request);

// Manejar las rutas CRUD para Marcas
if ($parts[0] == 'marcas') {
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        $marcasController->obtenerMarcas();
    } elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $data = json_decode(file_get_contents('php://input'), true);
        $marcasController->crearMarca($data);
    } elseif ($_SERVER['REQUEST_METHOD'] == 'PUT' && isset($parts[1])) {
        $id = $parts[1];
        $data = json_decode(file_get_contents('php://input'), true);
        $marcasController->actualizarMarca($id, $data);
    } elseif ($_SERVER['REQUEST_METHOD'] == 'DELETE' && isset($parts[1])) {
        $id = $parts[1];
        $marcasController->eliminarMarca($id);
    }
}

// Manejar las rutas para los reportes
if ($parts[0] == 'reportes') {
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        if ($parts[1] == 'marcas-con-ventas') {
            $reportesController->obtenerMarcasConVentas();
        } elseif ($parts[1] == 'prendas-vendidas') {
            $reportesController->obtenerPrendasVendidas();
        } elseif ($parts[1] == 'top-5-marcas') {
            $reportesController->obtenerTop5Marcas();
        }
    }
}
?>
