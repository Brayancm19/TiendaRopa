<?php
class Database {
    private $host = "localhost";
    private $db_name = "tiendaropa";  // Nombre de la base de datos
    private $username = "root";       // Usuario de la base de datos
    private $password = "";           // Contraseña de la base de datos (dejar vacía si no hay)
    public $conn;

    // Obtener la conexión a la base de datos
    public function getConnection() {
        $this->conn = null;
        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->exec("set names utf8mb4");
        } catch(PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
        }

        return $this->conn;
    }
}
?>
