<?php
class Venta {
    private $conn;
    private $table_name = "ventas";

    public $id;
    public $prenda_id;
    public $cantidad;
    public $fecha;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Obtener todas las ventas
    public function getVentas() {
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Crear una nueva venta
    public function create() {
        $query = "INSERT INTO " . $this->table_name . " SET prenda_id=:prenda_id, cantidad=:cantidad, fecha=:fecha";
        $stmt = $this->conn->prepare($query);

        // Sanitizar la entrada
        $this->prenda_id = htmlspecialchars(strip_tags($this->prenda_id));
        $this->cantidad = htmlspecialchars(strip_tags($this->cantidad));
        $this->fecha = htmlspecialchars(strip_tags($this->fecha));

        // Enlazar parámetros
        $stmt->bindParam(":prenda_id", $this->prenda_id);
        $stmt->bindParam(":cantidad", $this->cantidad);
        $stmt->bindParam(":fecha", $this->fecha);

        // Ejecutar la consulta
        if ($stmt->execute()) {
            return true;
        }

        // Manejo de errores
        printf("Error: %s.\n", $stmt->error);
        return false;
    }

    // Actualizar una venta
    public function update() {
        $query = "UPDATE " . $this->table_name . " SET prenda_id=:prenda_id, cantidad=:cantidad, fecha=:fecha WHERE id=:id";
        $stmt = $this->conn->prepare($query);

        // Sanitizar la entrada
        $this->prenda_id = htmlspecialchars(strip_tags($this->prenda_id));
        $this->cantidad = htmlspecialchars(strip_tags($this->cantidad));
        $this->fecha = htmlspecialchars(strip_tags($this->fecha));
        $this->id = htmlspecialchars(strip_tags($this->id));

        // Enlazar parámetros
        $stmt->bindParam(":prenda_id", $this->prenda_id);
        $stmt->bindParam(":cantidad", $this->cantidad);
        $stmt->bindParam(":fecha", $this->fecha);
        $stmt->bindParam(":id", $this->id);

        // Ejecutar la consulta
        if ($stmt->execute()) {
            return true;
        }

        // Manejo de errores
        printf("Error: %s.\n", $stmt->error);
        return false;
    }

    // Eliminar una venta
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
