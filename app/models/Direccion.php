<?php
require_once __DIR__ . '/../../config.php';

class Direccion {
    private $db;

    public function __construct() {
        $this->db = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        $this->db->set_charset('utf8mb4');
    }

    // Obtiene todas las direcciones (ordenadas alfabéticamente)
    public function obtenerTodas() {
        $direcciones = [];
$stmt = $this->db->prepare("SELECT id, nombre FROM direcciones");
$stmt->execute();
$stmt->bind_result($id, $nombre);
$direcciones = [];
while ($stmt->fetch()) {
    $direcciones[] = ['id' => $id, 'nombre' => $nombre];
}
$stmt->close();
return $direcciones;
    }
}
