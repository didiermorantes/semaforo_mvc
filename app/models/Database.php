<?php
class Database {
    private static $conn;

    public static function conectar() {
        if (!self::$conn) {
            self::$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
            if (self::$conn->connect_error) {
                die("Conexión fallida: " . self::$conn->connect_error);
            }
        }
        return self::$conn;
    }
}
