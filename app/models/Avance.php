<?php
require_once __DIR__ . '/../../config.php';

class Avance {
    private $db;

    public function __construct() {
        $this->db = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    }

public function registrarAvance($compromiso_id, $resumen, $usuario, $es_finalizacion = 0, $pdf_finalizacion = null, $porcentaje_avance = null) {
    $stmt = $this->db->prepare(
        "INSERT INTO avances (compromiso_id, resumen, porcentaje_avance, usuario, es_finalizacion, pdf_finalizacion)
         VALUES (?, ?, ?, ?, ?, ?)"
    );
    $stmt->bind_param("isisis", $compromiso_id, $resumen, $porcentaje_avance, $usuario, $es_finalizacion, $pdf_finalizacion);
    $stmt->execute();
    $stmt->close();
    return $this->db->insert_id;
}


    public function obtenerPorCompromiso($compromiso_id) {
        $stmt = $this->db->prepare(
            "SELECT * FROM avances WHERE compromiso_id = ? ORDER BY fecha_avance DESC"
        );
        $stmt->bind_param("i", $compromiso_id);
        $stmt->execute();
        $res = $stmt->get_result();
        return $res ? $res->fetch_all(MYSQLI_ASSOC) : [];
    }

    public function obtenerUltimoPorcentaje($compromiso_id) {
    $stmt = $this->db->prepare(
        "SELECT porcentaje_avance FROM avances WHERE compromiso_id = ? ORDER BY fecha_avance DESC LIMIT 1"
    );
    $stmt->bind_param("i", $compromiso_id);
    $stmt->execute();
    $res = $stmt->get_result();
    $row = $res ? $res->fetch_assoc() : null;
    return $row ? intval($row['porcentaje_avance']) : 0;
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