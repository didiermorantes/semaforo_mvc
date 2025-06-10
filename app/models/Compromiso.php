<?php
require_once __DIR__ . '/../../config.php';

class Compromiso {
    private $db;

    public function __construct() {
        $this->db = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    }

    public function obtenerPorDireccion($direccion) {
        $stmt = $this->db->prepare("SELECT * FROM compromisos WHERE direccion_responsable = ?");
        $stmt->bind_param("s", $direccion);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function obtenerPorId($id) {
        $stmt = $this->db->prepare("SELECT * FROM compromisos WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function crear($compromiso, $direccion, $pdf) {
        $stmt = $this->db->prepare("INSERT INTO compromisos (compromiso_especifico, direccion_responsable, evidencia_pdf) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $compromiso, $direccion, $pdf);
        $stmt->execute();
        return $this->db->insert_id;
    }

    public function actualizar($id, $compromiso, $pdf) {
        $stmt = $this->db->prepare("UPDATE compromisos SET compromiso_especifico = ?, evidencia_pdf = ? WHERE id = ?");
        $stmt->bind_param("ssi", $compromiso, $pdf, $id);
        $stmt->execute();
    }
}
