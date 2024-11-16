<?php
// src/controllers/ReportesController.php
require_once 'src/models/Marca.php';
require_once 'src/models/Prenda.php';

class ReportesController {

    // Obtener marcas con al menos una venta
    public function obtenerMarcasConVentas() {
        $marcasConVentas = Marca::getMarcasConVentas();
        echo json_encode($marcasConVentas);
    }

    // Obtener prendas vendidas y cantidad restante en stock
    public function obtenerPrendasVendidas() {
        $prendasVendidas = Prenda::getPrendasVendidas();
        echo json_encode($prendasVendidas);
    }

    // Obtener las 5 marcas más vendidas
    public function obtenerTop5Marcas() {
        $top5Marcas = Marca::getTop5Marcas();
        echo json_encode($top5Marcas);
    }
}
?>
