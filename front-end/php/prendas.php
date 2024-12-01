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
        getPrendas();
        break;
    case 'POST':
        createPrenda();
        break;
    case 'PUT':
        $data = json_decode(file_get_contents("php://input"), true);
        updatePrenda($data);
        break;
    case 'DELETE':
        $data = json_decode(file_get_contents("php://input"), true);
        deletePrenda($data);
        break;
    default:
        header("HTTP/1.1 405 Method Not Allowed");
        break;
}

// Función para obtener todas las prendas
function getPrendas() {
    global $conn;
    $query = "SELECT * FROM prendas";
    $response = array();
    $result = $conn->query($query);
    while($row = $result->fetch_assoc()) {
        $response[] = $row;
    }
    echo json_encode($response);
}

// Función para crear una nueva prenda
function createPrenda() {
    global $conn;
    $data = json_decode(file_get_contents('php://input'), true);
    $nombre = $data['nombre'];
    $talla = $data['talla'];
    $cantidad_stock = $data['cantidad_stock'];
    $marca_id = $data['marca_id'];

    // Verificar si el marca_id existe en la tabla marcas
    $stmt = $conn->prepare("SELECT id FROM marcas WHERE id = ?");
    $stmt->bind_param("i", $marca_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 0) {
        // Si no existe, lanzar una excepción
        $response = array('status' => 0, 'status_message' =>'El marca_id proporcionado no existe.');
        echo json_encode($response);
        $stmt->close();
        return;
    }
    $stmt->close();

    $query = "INSERT INTO prendas (nombre, talla, cantidad_stock, marca_id) VALUES ('$nombre', '$talla', $cantidad_stock, $marca_id)";
    if($conn->query($query) === TRUE) {
        $response = array('status' => 1, 'status_message' =>'Prenda creada exitosamente.');
    } else {
        $response = array('status' => 0, 'status_message' =>'Error al crear la prenda.');
    }
    echo json_encode($response);
}

// Función para actualizar una prenda existente
function updatePrenda($data) {
    global $conn;
    $id = $data['id'];
    $nombre = $data['nombre'];
    $talla = $data['talla'];
    $cantidad_stock = $data['cantidad_stock'];
    $marca_id = $data['marca_id'];

    // Verificar si el marca_id existe en la tabla marcas
    $stmt = $conn->prepare("SELECT id FROM marcas WHERE id = ?");
    $stmt->bind_param("i", $marca_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 0) {
        // Si no existe, lanzar una excepción
        $response = array('status' => 0, 'status_message' =>'El marca_id proporcionado no existe.');
        echo json_encode($response);
        $stmt->close();
        return;
    }
    $stmt->close();

    $query = "UPDATE prendas SET nombre='$nombre', talla='$talla', cantidad_stock=$cantidad_stock, marca_id=$marca_id WHERE id=$id";
    if($conn->query($query) === TRUE) {
        $response = array('status' => 1, 'status_message' =>'Prenda actualizada exitosamente.');
    } else {
        $response = array('status' => 0, 'status_message' =>'Error al actualizar la prenda.');
    }
    echo json_encode($response);
}

// Función para eliminar una prenda
function deletePrenda($data) {
    global $conn;
    $id = $data['id'];
    $query = "DELETE FROM prendas WHERE id=$id";
    if($conn->query($query) === TRUE) {
        $response = array('status' => 1, 'status_message' =>'Prenda eliminada exitosamente.');
    } else {
        $response = array('status' => 0, 'status_message' =>'Error al eliminar la prenda.');
    }
    echo json_encode($response);
}

// Cerrar la conexión
$conn->close();
?>
