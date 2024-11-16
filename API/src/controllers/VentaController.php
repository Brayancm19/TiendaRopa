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
        $this->venta->prenda_id = $data->prenda_id;
        $this->venta->cantidad = $data->cantidad;
        $this->venta->fecha = $data->fecha;

        if ($this->venta->create()) {
            echo json_encode(["message" => "Venta creada."]);
        } else {
            echo json_encode(["message" => "No se pudo crear la venta."]);
        }
    }

    // Actualizar una venta
    public function updateVenta() {
        $data = json_decode(file_get_contents("php://input"));
        $this->venta->id = $data->id;
        $this->venta->prenda_id = $data->prenda_id;
        $this->venta->cantidad = $data->cantidad;
        $this->venta->fecha = $data->fecha;

        if ($this->venta->update()) {
            echo json_encode(["message" => "Venta actualizada."]);
        } else {
            echo json_encode(["message" => "No se pudo actualizar la venta."]);
        }
    }

    // Eliminar una venta
    public function deleteVenta() {
        $data = json_decode(file_get_contents("php://input"));
        $this->venta->id = $data->id;

        if ($this->venta->delete()) {
            echo json_encode(["message" => "Venta eliminada."]);
        } else {
            echo json_encode(["message" => "No se pudo eliminar la venta."]);
        }
    }
}
?>
