<?php
require_once __DIR__ . '/../models/Venta.php';
require_once __DIR__ . '/../DB/database.php';

class VentaController {
    private $venta;

    public function __construct() {
        $database = new Database();
        $db = $database->getConnection();
        $this->venta = new Venta($db);
    }

    // Obtener todas las ventas
    public function getVentas() {
        $result = $this->venta->getVentas();
        header('Content-Type: application/json');
        echo json_encode($result);
    }

    // Crear una nueva venta
    public function createVenta() {
        $data = json_decode(file_get_contents("php://input"));

        if ($data === null) {
            header("HTTP/1.1 400 Bad Request");
            echo json_encode(["message" => "No se pudo interpretar el cuerpo de la solicitud."]);
            return;
        }

        if (isset($data->prenda_id, $data->cantidad, $data->fecha)) {
            $this->venta->prenda_id = $data->prenda_id;
            $this->venta->cantidad = $data->cantidad;
            $this->venta->fecha = $data->fecha;

            if ($this->venta->create()) {
                echo json_encode(["message" => "Venta creada."]);
            } else {
                echo json_encode(["message" => "No se pudo crear la venta."]);
            }
        } else {
            header("HTTP/1.1 400 Bad Request");
            echo json_encode(["message" => "Datos inválidos. Asegúrate de que los campos 'prenda_id', 'cantidad' y 'fecha' están presentes."]);
        }
    }

    // Actualizar una venta
    public function updateVenta($id) {
        $data = json_decode(file_get_contents("php://input"));

        if ($data === null) {
            header("HTTP/1.1 400 Bad Request");
            echo json_encode(["message" => "No se pudo interpretar el cuerpo de la solicitud."]);
            return;
        }

        if (isset($data->prenda_id, $data->cantidad, $data->fecha)) {
            $this->venta->id = $id;
            $this->venta->prenda_id = $data->prenda_id;
            $this->venta->cantidad = $data->cantidad;
            $this->venta->fecha = $data->fecha;

            if ($this->venta->update()) {
                echo json_encode(["message" => "Venta actualizada."]);
            } else {
                echo json_encode(["message" => "No se pudo actualizar la venta."]);
            }
        } else {
            header("HTTP/1.1 400 Bad Request");
            echo json_encode(["message" => "Datos inválidos. Asegúrate de que los campos 'prenda_id', 'cantidad' y 'fecha' están presentes."]);
        }
    }

    // Eliminar una venta
    public function deleteVenta($id) {
        $this->venta->id = $id;

        if ($this->venta->delete()) {
            echo json_encode(["message" => "Venta eliminada."]);
        } else {
            echo json_encode(["message" => "No se pudo eliminar la venta."]);
        }
    }
}
?>
