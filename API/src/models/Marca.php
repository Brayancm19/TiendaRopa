<?php
// src/models/Marca.php
require_once 'src/DB/Database.php';

class Marca {

    private $id;
    private $nombre;

    public function __construct($id, $nombre = null) {
        $this->id = $id;
        $this->nombre = $nombre;
    }

    // Obtener todas las marcas
    public static function getAll() {
        $conn = Database::getConnection();
        $sql = "SELECT * FROM marcas";
        $result = $conn->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Crear una nueva marca
    public function create() {
        $conn = Database::getConnection();
        $sql = "INSERT INTO marcas (nombre) VALUES ('$this->nombre')";
        return $conn->query($sql);
    }

    // Actualizar una marca existente
    public function update() {
        $conn = Database::getConnection();
        $sql = "UPDATE marcas SET nombre = '$this->nombre' WHERE id = $this->id";
        return $conn->query($sql);
    }

    // Eliminar una marca
    public function delete() {
        $conn = Database::getConnection();
        $sql = "DELETE FROM marcas WHERE id = $this->id";
        return $conn->query($sql);
    }

    // Obtener marcas con al menos una venta
    public static function getMarcasConVentas() {
        $conn = Database::getConnection();
        $sql = "SELECT DISTINCT marcas.nombre 
                FROM marcas
                JOIN prendas ON marcas.id = prendas.marca_id
                JOIN ventas ON prendas.id = ventas.prenda_id";
        $result = $conn->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Obtener las 5 marcas más vendidas
    public static function getTop5Marcas() {
        $conn = Database::getConnection();
        $sql = "SELECT marcas.nombre, SUM(ventas.cantidad) AS total_ventas 
                FROM marcas
                JOIN prendas ON marcas.id = prendas.marca_id
                JOIN ventas ON prendas.id = ventas.prenda_id
                GROUP BY marcas.id
                ORDER BY total_ventas DESC LIMIT 5";
        $result = $conn->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}
?>
