<?php
require_once 'config.php';
require_once 'api.php';

// Obtener todas las ventas
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $url = "http://localhost/TiendaRopa/API/public/index.php/ventas";
    $response = callAPI('GET', $url, false);
    echo $response;
}

// Crear una nueva venta
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $prenda_id = $_POST['prenda_id'];
    $cantidad = $_POST['cantidad'];
    $fecha = $_POST['fecha'];

    $data = array(
        "prenda_id" => $prenda_id,
        "cantidad" => $cantidad,
        "fecha" => $fecha
    );
    $url = "http://localhost/TiendaRopa/API/public/index.php/ventas";
    $response = callAPI('POST', $url, json_encode($data));
    echo $response;
}

// Actualizar una venta
if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    parse_str(file_get_contents("php://input"), $_PUT);
    $id = $_PUT['id'];
    $prenda_id = $_PUT['prenda_id'];
    $cantidad = $_PUT['cantidad'];
    $fecha = $_PUT['fecha'];

    $data = array(
        "id" => $id,
        "prenda_id" => $prenda_id,
        "cantidad" => $cantidad,
        "fecha" => $fecha
    );
    $url = "http://localhost/TiendaRopa/API/public/index.php/ventas?id=$id";
    $response = callAPI('PUT', $url, json_encode($data));
    echo $response;
}

// Eliminar una venta
if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    parse_str(file_get_contents("php://input"), $_DELETE);
    $id = $_DELETE['id'];

    $url = "http://localhost/TiendaRopa/API/public/index.php/ventas?id=$id";
    $response = callAPI('DELETE', $url, false);
    echo $response;
}
?>
