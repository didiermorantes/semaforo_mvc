<?php
require_once __DIR__ . '/../../config.php';

class Avance {
    private $db;

    public function __construct() {
        $this->db = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    }

    public function registrarAvance($compromiso_id, $resumen, $usuario, $es_finalizacion = 0, $pdf_finalizacion = null) {
        $stmt = $this->db->prepare(
            "INSERT INTO avances (compromiso_id, resumen, usuario, es_finalizacion, pdf_finalizacion)
             VALUES (?, ?, ?, ?, ?)"
        );
        $stmt->bind_param("issis", $compromiso_id, $resumen, $usuario, $es_finalizacion, $pdf_finalizacion);
        $stmt->execute();
        $stmt->close();
        return $this->db->insert_id;
    }

    public function obtenerPorCompromiso($compromiso_id) {
        $stmt = $this->db->prepare(
            "SELECT * FROM avances WHERE compromiso_id = ? ORDER BY fecha DESC"
        );
        $stmt->bind_param("i", $compromiso_id);
        $stmt->execute();
        $res = $stmt->get_result();
        return $res ? $res->fetch_all(MYSQLI_ASSOC) : [];
    }

    public function existeFinalizacion($compromiso_id) {
        $stmt = $this->db->prepare(
            "SELECT COUNT(*) as total FROM avances WHERE compromiso_id = ? AND es_finalizacion = 1"
        );
        $stmt->bind_param("i", $compromiso_id);
        $stmt->execute();
        $res = $stmt->get_result();
        $row = $res ? $res->fetch_assoc() : null;
        return $row && $row['total'] > 0;
    }
}