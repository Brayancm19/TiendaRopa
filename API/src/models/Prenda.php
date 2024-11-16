<?php
class Prenda {
    private $conn;
    private $table_name = "prendas";

    public $id;
    public $nombre;
    public $talla;
    public $cantidad_stock;
    public $marca_id;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Obtener todas las prendas
    public function getPrendas() {
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Crear una nueva prenda
    public function create() {
        $query = "INSERT INTO " . $this->table_name . " SET nombre=:nombre, talla=:talla, cantidad_stock=:cantidad_stock, marca_id=:marca_id";
        $stmt = $this->conn->prepare($query);

        // Sanitizar la entrada
        $this->nombre = htmlspecialchars(strip_tags($this->nombre));
        $this->talla = htmlspecialchars(strip_tags($this->talla));
        $this->cantidad_stock = htmlspecialchars(strip_tags($this->cantidad_stock));
        $this->marca_id = htmlspecialchars(strip_tags($this->marca_id));

        // Enlazar parámetros
        $stmt->bindParam(":nombre", $this->nombre);
        $stmt->bindParam(":talla", $this->talla);
        $stmt->bindParam(":cantidad_stock", $this->cantidad_stock);
        $stmt->bindParam(":marca_id", $this->marca_id);

        // Ejecutar la consulta
        if ($stmt->execute()) {
            return true;
        }

        // Manejo de errores
        printf("Error: %s.\n", $stmt->error);
        return false;
    }

    // Actualizar una prenda
    public function update() {
        $query = "UPDATE " . $this->table_name . " SET nombre=:nombre, talla=:talla, cantidad_stock=:cantidad_stock, marca_id=:marca_id WHERE id=:id";
        $stmt = $this->conn->prepare($query);

        // Sanitizar la entrada
        $this->nombre = htmlspecialchars(strip_tags($this->nombre));
        $this->talla = htmlspecialchars(strip_tags($this->talla));
        $this->cantidad_stock = htmlspecialchars(strip_tags($this->cantidad_stock));
        $this->marca_id = htmlspecialchars(strip_tags($this->marca_id));
        $this->id = htmlspecialchars(strip_tags($this->id));

        // Enlazar parámetros
        $stmt->bindParam(":nombre", $this->nombre);
        $stmt->bindParam(":talla", $this->talla);
        $stmt->bindParam(":cantidad_stock", $this->cantidad_stock);
        $stmt->bindParam(":marca_id", $this->marca_id);
        $stmt->bindParam(":id", $this->id);

        // Ejecutar la consulta
        if ($stmt->execute()) {
            return true;
        }

        // Manejo de errores
        printf("Error: %s.\n", $stmt->error);
        return false;
    }

    // Eliminar una prenda
    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE id=:id";
        $stmt = $this->conn->prepare($query);

        // Sanitizar la entrada
        $this->id = htmlspecialchars(strip_tags($this->id));
        $stmt->bindParam(":id", $this->id);

        // Ejecutar la consulta
        if ($stmt->execute()) {
            return true;
        }

        // Manejo de errores
        printf("Error: %s.\n", $stmt->error);
        return false;
    }
}
?>
