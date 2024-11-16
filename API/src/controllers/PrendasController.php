<?php
require_once '../../src/models/Prenda.php';

class PrendaController {

    // Obtener todas las prendas
    public function getPrendas() {
        $prenda = new Prenda();
        $data = $prenda->getAll();
        echo json_encode($data);
    }

    // Crear una nueva prenda
    public function createPrenda() {
        $data = json_decode(file_get_contents("php://input"));
        $prenda = new Prenda();
        $result = $prenda->create($data);
        echo json_encode($result);
    }

    // Obtener una prenda por su ID
    public function getPrenda($id) {
        $prenda = new Prenda();
        $data = $prenda->getById($id);
        echo json_encode($data);
    }

    // Actualizar una prenda
    public function updatePrenda($id) {
        $data = json_decode(file_get_contents("php://input"));
        $prenda = new Prenda();
        $result = $prenda->update($id, $data);
        echo json_encode($result);
    }

    // Eliminar una prenda
    public function deletePrenda($id) {
        $prenda = new Prenda();
        $result = $prenda->delete($id);
        echo json_encode($result);
    }
}
