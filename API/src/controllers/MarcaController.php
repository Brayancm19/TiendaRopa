<?php
require_once __DIR__ . '/../models/Marca.php';
require_once __DIR__ . '/../DB/database.php';

class MarcaController {
    private $marca;

    public function __construct() {
        $database = new Database();
        $db = $database->getConnection();
        $this->marca = new Marca($db);
    }

    // Obtener todas las marcas
    public function getMarcas() {
        $result = $this->marca->getMarcas();
        header('Content-Type: application/json');
        echo json_encode($result);
    }

    // Crear una nueva marca
    public function createMarca() {
        // Captura de datos JSON
        $data = file_get_contents("php://input");
        $json_data = json_decode($data, true);  // Decodificar a array asociativo

        // Verificación adicional para depuración
        if ($json_data === null) {
            header("HTTP/1.1 400 Bad Request");
            echo json_encode([
                "message" => "No se pudo interpretar el cuerpo de la solicitud.",
                "raw_data" => $data,
                "error" => json_last_error_msg()
            ]);
            return;
        }

        if (isset($json_data['nombre'])) {
            $this->marca->nombre = $json_data['nombre'];

            if ($this->marca->create()) {
                echo json_encode(["message" => "Marca creada."]);
            } else {
                echo json_encode(["message" => "No se pudo crear la marca."]);
            }
        } else {
            header("HTTP/1.1 400 Bad Request");
            echo json_encode(["message" => "Datos inválidos. Asegúrate de que el campo 'nombre' está presente."]);
        }
    }

    // Actualizar una marca
    public function updateMarca() {
        $data = file_get_contents("php://input");
        $json_data = json_decode($data, true);

        if ($json_data === null) {
            header("HTTP/1.1 400 Bad Request");
            echo json_encode([
                "message" => "No se pudo interpretar el cuerpo de la solicitud.",
                "raw_data" => $data,
                "error" => json_last_error_msg()
            ]);
            return;
        }

        if (isset($json_data['id']) && isset($json_data['nombre'])) {
            $this->marca->id = $json_data['id'];
            $this->marca->nombre = $json_data['nombre'];

            if ($this->marca->update()) {
                echo json_encode(["message" => "Marca actualizada."]);
            } else {
                echo json_encode(["message" => "No se pudo actualizar la marca."]);
            }
        } else {
            header("HTTP/1.1 400 Bad Request");
            echo json_encode(["message" => "Datos inválidos. Asegúrate de que los campos 'id' y 'nombre' están presentes."]);
        }
    }

    // Eliminar una marca
    public function deleteMarca() {
        $data = file_get_contents("php://input");
        $json_data = json_decode($data, true);

        if ($json_data === null) {
            header("HTTP/1.1 400 Bad Request");
            echo json_encode([
                "message" => "No se pudo interpretar el cuerpo de la solicitud.",
                "raw_data" => $data,
                "error" => json_last_error_msg()
            ]);
            return;
        }

        if (isset($json_data['id'])) {
            $this->marca->id = $json_data['id'];

            if ($this->marca->delete()) {
                echo json_encode(["message" => "Marca eliminada."]);
            } else {
                echo json_encode(["message" => "No se pudo eliminar la marca."]);
            }
        } else {
            header("HTTP/1.1 400 Bad Request");
            echo json_encode(["message" => "Datos inválidos. Asegúrate de que el campo 'id' está presente."]);
        }
    }
}
?>
