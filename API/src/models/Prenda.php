<?php
// src/models/Prenda.php
require_once 'src/DB/Database.php';

class Prenda {

    private $id;
    private $nombre;
    private $talla;
    private $cantidad_stock;
    private $marca_id;

    public function __construct($id, $nombre = null, $talla = null, $cantidad_stock = null, $marca_id = null) {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->talla = $talla;
        $this->cantidad_stock = $cantidad_stock;
        $this->marca_id = $marca_id;
    }

    // Obtener prendas vendidas y cantidad restante en stock
    public static function getPrendasVendidas() {
        $conn = Database::getConnection();
        $sql = "SELECT prendas.nombre, SUM(ventas.cantidad) AS cantidad_vendida, prendas.cantidad_stock 
                FROM prendas
                JOIN ventas ON prendas.id = ventas.prenda_id
                GROUP BY prendas.id";
        $result = $conn->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}
?>
