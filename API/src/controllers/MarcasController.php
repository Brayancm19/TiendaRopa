<?php
// src/controllers/MarcasController.php
require_once 'src/models/Marca.php';

class MarcasController {

    // Obtener todas las marcas
    public function obtenerMarcas() {
        $marcas = Marca::getAll();
        echo json_encode($marcas);
    }

    // Crear una nueva marca
    public function crearMarca($data) {
        $nombre = $data['nombre'];
        $marca = new Marca(null, $nombre);
        $resultado = $marca->create();
        echo json_encode(["mensaje" => $resultado ? "Marca creada con éxito" : "Error al crear marca"]);
    }

    // Actualizar una marca existente
    public function actualizarMarca($id, $data) {
        $nombre = $data['nombre'];
        $marca = new Marca($id, $nombre);
        $resultado = $marca->update();
        echo json_encode(["mensaje" => $resultado ? "Marca actualizada con éxito" : "Error al actualizar marca"]);
    }

    // Eliminar una marca
    public function eliminarMarca($id) {
        $marca = new Marca($id);
        $resultado = $marca->delete();
        echo json_encode(["mensaje" => $resultado ? "Marca eliminada con éxito" : "Error al eliminar marca"]);
    }
}
?>
