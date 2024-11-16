<?php
require_once __DIR__ . '/../models/Prenda.php';
require_once __DIR__ . '/../DB/database.php';

class PrendaController {
    private $prenda;

    public function __construct() {
        $database = new Database();
        $db = $database->getConnection();
        $this->prenda = new Prenda($db);
    }

    // Obtener todas las prendas
    public function getPrendas() {
        $result = $this->prenda->getPrendas();
        header('Content-Type: application/json');
        echo json_encode($result);
    }

    // Crear una nueva prenda
    public function createPrenda() {
        $data = json_decode(file_get_contents("php://input"));
        $this->prenda->nombre = $data->nombre;
        $this->prenda->talla = $data->talla;
        $this->prenda->cantidad_stock = $data->cantidad_stock;
        $this->prenda->marca_id = $data->marca_id;

        if ($this->prenda->create()) {
            echo json_encode(["message" => "Prenda creada."]);
        } else {
            echo json_encode(["message" => "No se pudo crear la prenda."]);
        }
    }

    // Actualizar una prenda
    public function updatePrenda() {
        $data = json_decode(file_get_contents("php://input"));
        $this->prenda->id = $data->id;
        $this->prenda->nombre = $data->nombre;
        $this->prenda->talla = $data->talla;
        $this->prenda->cantidad_stock = $data->cantidad_stock;
        $this->prenda->marca_id = $data->marca_id;

        if ($this->prenda->update()) {
            echo json_encode(["message" => "Prenda actualizada."]);
        } else {
            echo json_encode(["message" => "No se pudo actualizar la prenda."]);
        }
    }

    // Eliminar una prenda
    public function deletePrenda() {
        $data = json_decode(file_get_contents("php://input"));
        $this->prenda->id = $data->id;

        if ($this->prenda->delete()) {
            echo json_encode(["message" => "Prenda eliminada."]);
        } else {
            echo json_encode(["message" => "No se pudo eliminar la prenda."]);
        }
    }
}
?>
