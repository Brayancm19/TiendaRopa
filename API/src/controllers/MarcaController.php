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
        $data = json_decode(file_get_contents("php://input"));


        if ($data === null) {
            header("HTTP/1.1 400 Bad Request");
            echo json_encode(["message" => "No se pudo interpretar el cuerpo de la solicitud."]);
            return;
        }

        if (property_exists($data, 'nombre')) {
            $this->marca->nombre = $data->nombre;

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
    public function updateMarca($id) {
        $data = json_decode(file_get_contents("php://input"));

        if ($data === null) {
            header("HTTP/1.1 400 Bad Request");
            echo json_encode(["message" => "No se pudo interpretar el cuerpo de la solicitud."]);
            return;
        }

        if (property_exists($data, 'nombre')) {
            $this->marca->id = $id;
            $this->marca->nombre = $data->nombre;

            if ($this->marca->update()) {
                echo json_encode(["message" => "Marca actualizada."]);
            } else {
                echo json_encode(["message" => "No se pudo actualizar la marca."]);
            }
        } else {
            header("HTTP/1.1 400 Bad Request");
            echo json_encode(["message" => "Datos inválidos. Asegúrate de que el campo 'nombre' está presente."]);
        }
    }

    // Eliminar una marca
    public function deleteMarca($id) {
        $this->marca->id = $id;

        if ($this->marca->delete()) {
            echo json_encode(["message" => "Marca eliminada."]);
        } else {
            echo json_encode(["message" => "No se pudo eliminar la marca."]);
        }
    }
}
?>
