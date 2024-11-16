<?php
require_once '../src/DB/Database.php';

class Prenda {
    private $id;
    private $nombre;
    private $talla;
    private $cantidad_stock;
    private $marca_id;
    private $conn;

    public function __construct() {
        // Establece la conexión a la base de datos
        $this->conn = (new Database())->getConnection();
    }

    // Getters y setters para cada propiedad
    public function setId($id) { $this->id = $id; }
    public function setNombre($nombre) { $this->nombre = $nombre; }
    public function setTalla($talla) { $this->talla = $talla; }
    public function setCantidadStock($cantidad_stock) { $this->cantidad_stock = $cantidad_stock; }
    public function setMarcaId($marca_id) { $this->marca_id = $marca_id; }

    // Guardar una prenda (INSERT)
    public function save() {
        $query = "INSERT INTO prendas (nombre, talla, cantidad_stock, marca_id) VALUES (:nombre, :talla, :cantidad_stock, :marca_id)";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':nombre', $this->nombre);
        $stmt->bindParam(':talla', $this->talla);
        $stmt->bindParam(':cantidad_stock', $this->cantidad_stock);
        $stmt->bindParam(':marca_id', $this->marca_id);

        return $stmt->execute();
    }

    // Obtener todas las prendas (SELECT)
    public function getAll() {
        $query = "SELECT * FROM prendas";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Actualizar una prenda (UPDATE)
    public function update() {
        $query = "UPDATE prendas SET nombre = :nombre, talla = :talla, cantidad_stock = :cantidad_stock, marca_id = :marca_id WHERE id = :id";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':nombre', $this->nombre);
        $stmt->bindParam(':talla', $this->talla);
        $stmt->bindParam(':cantidad_stock', $this->cantidad_stock);
        $stmt->bindParam(':marca_id', $this->marca_id);

        return $stmt->execute();
    }

    // Eliminar una prenda (DELETE)
    public function delete() {
        $query = "DELETE FROM prendas WHERE id = :id";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->id);
        
        return $stmt->execute();
    }
}
?>
