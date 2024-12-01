<?php
require_once 'config.php';

// Conectar a la base de datos
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Manejar solicitudes
$request_method = $_SERVER["REQUEST_METHOD"];
switch($request_method) {
    case 'GET':
        getMarcas();
        break;
    case 'POST':
        createMarca();
        break;
    case 'PUT':
        $data = json_decode(file_get_contents("php://input"), true);
        updateMarca($data);
        break;
    case 'DELETE':
        $data = json_decode(file_get_contents("php://input"), true);
        deleteMarca($data);
        break;
    default:
        header("HTTP/1.1 405 Method Not Allowed");
        break;
}

// Función para obtener todas las marcas
function getMarcas() {
    global $conn;
    $query = "SELECT * FROM marcas";
    $response = array();
    $result = $conn->query($query);
    while($row = $result->fetch_assoc()) {
        $response[] = $row;
    }
    echo json_encode($response);
}

// Función para crear una nueva marca
function createMarca() {
    global $conn;
    $data = json_decode(file_get_contents('php://input'), true);
    $nombre = $data['nombre'];
    $query = "INSERT INTO marcas (nombre) VALUES ('$nombre')";
    if($conn->query($query) === TRUE) {
        $response = array('status' => 1, 'status_message' =>'Marca creada exitosamente.');
    } else {
        $response = array('status' => 0, 'status_message' =>'Error al crear la marca.');
    }
    echo json_encode($response);
}

// Función para actualizar una marca existente
function updateMarca($data) {
    global $conn;
    $id = $data['id'];
    $nombre = $data['nombre'];
    $query = "UPDATE marcas SET nombre='$nombre' WHERE id=$id";
    if($conn->query($query) === TRUE) {
        $response = array('status' => 1, 'status_message' =>'Marca actualizada exitosamente.');
    } else {
        $response = array('status' => 0, 'status_message' =>'Error al actualizar la marca.');
    }
    echo json_encode($response);
}

// Función para eliminar una marca
function deleteMarca($data) {
    global $conn;
    $id = $data['id'];
    $query = "DELETE FROM marcas WHERE id=$id";
    if($conn->query($query) === TRUE) {
        $response = array('status' => 1, 'status_message' =>'Marca eliminada exitosamente.');
    } else {
        $response = array('status' => 0, 'status_message' =>'Error al eliminar la marca.');
    }
    echo json_encode($response);
}

// Cerrar la conexión
$conn->close();
?>
