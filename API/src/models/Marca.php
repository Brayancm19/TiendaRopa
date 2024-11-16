<?php
require_once '../src/DB/Database.php';

class Marca {
    private $id;
    private $nombre;
    private $conn;

    public function __construct() {
        // Establece la conexión a la base de datos
        $this->conn = (new Database())->getConnection();
    }

    // Getters y setters para las propiedades
    public function setId($id) { $this->id = $id; }
    public function setNombre($nombre) { $this->nombre = $nombre; }

    // Guardar una marca (INSERT)
    public function save() {
        $query = "INSERT INTO marcas (nombre) VALUES (:nombre)";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':nombre', $this->nombre);

        return $stmt->execute();
    }

    // Obtener todas las marcas (SELECT)
    public function getAll() {
        $query = "SELECT * FROM marcas";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
