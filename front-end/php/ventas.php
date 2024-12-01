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
    $data = json_decode(file_get_contents('php://input'), true);
    $prenda_id = $data['prenda_id'];
    $cantidad = $data['cantidad'];
    $fecha = $data['fecha'];

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
    $data = json_decode(file_get_contents("php://input"), true);
    $id = $data['id'];
    $prenda_id = $data['prenda_id'];
    $cantidad = $data['cantidad'];
    $fecha = $data['fecha'];

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
    $data = json_decode(file_get_contents("php://input"), true);
    $id = $data['id'];

    $url = "http://localhost/TiendaRopa/API/public/index.php/ventas?id=$id";
    $response = callAPI('DELETE', $url, false);
    echo $response;
}
?>
