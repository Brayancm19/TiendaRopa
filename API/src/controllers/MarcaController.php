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
        $this->marca->nombre = $data->nombre;

        if ($this->marca->create()) {
            echo json_encode(["message" => "Marca creada."]);
        } else {
            echo json_encode(["message" => "No se pudo crear la marca."]);
        }
    }

    // Actualizar una marca
    public function updateMarca() {
        $data = json_decode(file_get_contents("php://input"));
        $this->marca->id = $data->id;
        $this->marca->nombre = $data->nombre;

        if ($this->marca->update()) {
            echo json_encode(["message" => "Marca actualizada."]);
        } else {
            echo json_encode(["message" => "No se pudo actualizar la marca."]);
        }
    }

    // Eliminar una marca
    public function deleteMarca() {
        $data = json_decode(file_get_contents("php://input"));
        $this->marca->id = $data->id;

        if ($this->marca->delete()) {
            echo json_encode(["message" => "Marca eliminada."]);
        } else {
            echo json_encode(["message" => "No se pudo eliminar la marca."]);
        }
    }
}
?>
