<?php
require_once 'config.php';

// Conectar a la base de datos
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Función para obtener marcas con ventas
function getMarcasConVentas($conn) {
    $query = "SELECT * FROM marcasconventas";
    $result = $conn->query($query);
    $data = [];

    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }

    return json_encode($data);
}

// Función para obtener prendas vendidas y su cantidad restante en stock
function getPrendasVendidas($conn) {
    $query = "SELECT * FROM prendasvendidas";
    $result = $conn->query($query);
    $data = [];

    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }

    return json_encode($data);
}

// Función para obtener top 5 marcas más vendidas
function getTop5Marcas($conn) {
    $query = "SELECT * FROM top5marcas";
    $result = $conn->query($query);
    $data = [];

    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }

    return json_encode($data);
}

// Manejo de las rutas
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['tipo'])) {
        switch ($_GET['tipo']) {
            case 'marcasConVentas':
                echo getMarcasConVentas($conn);
                break;
            case 'prendasVendidas':
                echo getPrendasVendidas($conn);
                break;
            case 'top5Marcas':
                echo getTop5Marcas($conn);
                break;
            default:
                echo json_encode(['message' => 'Ruta no encontrada']);
                break;
        }
    } else {
        echo json_encode(['message' => 'Tipo de reporte no especificado']);
    }
}

// Cerrar la conexión
$conn->close();
?>
