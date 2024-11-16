<?php
class Marca {
    private $conn;
    private $table_name = "marcas";

    public $id;
    public $nombre;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Obtener todas las marcas
    public function getMarcas() {
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Crear una nueva marca
    public function create() {
        $query = "INSERT INTO " . $this->table_name . " SET nombre=:nombre";
        $stmt = $this->conn->prepare($query);

        // Sanitizar la entrada
        $this->nombre = htmlspecialchars(strip_tags($this->nombre));
        $stmt->bindParam(":nombre", $this->nombre);

        // Ejecutar la consulta
        if ($stmt->execute()) {
            return true;
        }

        // Manejo de errores
        printf("Error: %s.\n", $stmt->error);
        return false;
    }

    // Actualizar una marca
    public function update() {
        $query = "UPDATE " . $this->table_name . " SET nombre=:nombre WHERE id=:id";
        $stmt = $this->conn->prepare($query);

        // Sanitizar la entrada
        $this->nombre = htmlspecialchars(strip_tags($this->nombre));
        $this->id = htmlspecialchars(strip_tags($this->id));
        $stmt->bindParam(":nombre", $this->nombre);
        $stmt->bindParam(":id", $this->id);

        // Ejecutar la consulta
        if ($stmt->execute()) {
            return true;
        }

        // Manejo de errores
        printf("Error: %s.\n", $stmt->error);
        return false;
    }

    // Eliminar una marca
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
