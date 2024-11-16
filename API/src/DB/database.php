<?php
// src/DB/Database.php
class Database {
    private static $conn;

    public static function getConnection() {
        if (!self::$conn) {
            self::$conn = new mysqli('localhost', 'root', '', 'tiendaropa');
            if (self::$conn->connect_error) {
                die("Connection failed: " . self::$conn->connect_error);
            }
        }
        return self::$conn;
    }
}
?>
