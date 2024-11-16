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

        if ($data === null) {
            header("HTTP/1.1 400 Bad Request");
            echo json_encode(["message" => "No se pudo interpretar el cuerpo de la solicitud."]);
            return;
        }

        if (isset($data->nombre, $data->talla, $data->cantidad_stock, $data->marca_id)) {
            $this->prenda->nombre = $data->nombre;
            $this->prenda->talla = $data->talla;
            $this->prenda->cantidad_stock = $data->cantidad_stock;
            $this->prenda->marca_id = $data->marca_id;

            if ($this->prenda->create()) {
                echo json_encode(["message" => "Prenda creada."]);
            } else {
                echo json_encode(["message" => "No se pudo crear la prenda."]);
            }
        } else {
            header("HTTP/1.1 400 Bad Request");
            echo json_encode(["message" => "Datos inválidos. Asegúrate de que los campos 'nombre', 'talla', 'cantidad_stock' y 'marca_id' están presentes."]);
        }
    }

    // Actualizar una prenda
    public function updatePrenda($id) {
        $data = json_decode(file_get_contents("php://input"));

        if ($data === null) {
            header("HTTP/1.1 400 Bad Request");
            echo json_encode(["message" => "No se pudo interpretar el cuerpo de la solicitud."]);
            return;
        }

        if (isset($data->nombre, $data->talla, $data->cantidad_stock, $data->marca_id)) {
            $this->prenda->id = $id;
            $this->prenda->nombre = $data->nombre;
            $this->prenda->talla = $data->talla;
            $this->prenda->cantidad_stock = $data->cantidad_stock;
            $this->prenda->marca_id = $data->marca_id;

            if ($this->prenda->update()) {
                echo json_encode(["message" => "Prenda actualizada."]);
            } else {
                echo json_encode(["message" => "No se pudo actualizar la prenda."]);
            }
        } else {
            header("HTTP/1.1 400 Bad Request");
            echo json_encode(["message" => "Datos inválidos. Asegúrate de que los campos 'nombre', 'talla', 'cantidad_stock' y 'marca_id' están presentes."]);
        }
    }

    // Eliminar una prenda
    public function deletePrenda($id) {
        $this->prenda->id = $id;

        if ($this->prenda->delete()) {
            echo json_encode(["message" => "Prenda eliminada."]);
        } else {
            echo json_encode(["message" => "No se pudo eliminar la prenda."]);
        }
    }
}
?>
