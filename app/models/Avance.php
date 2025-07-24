<?php
require_once __DIR__ . '/../../config.php';

class Avance {
    private $db;

    public function __construct() {
        $this->db = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        $this->db->set_charset('utf8mb4');
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
        $sql = "SELECT * FROM avances WHERE compromiso_id = ? ORDER BY fecha_avance DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $compromiso_id);
        $stmt->execute();
        $stmt->store_result();

        $meta = $stmt->result_metadata();
        $fields = [];
        while ($field = $meta->fetch_field()) {
            $fields[] = &$row[$field->name];
        }
        call_user_func_array([$stmt, 'bind_result'], $fields);

        $avances = [];
        while ($stmt->fetch()) {
            $registro = [];
            foreach ($row as $key => $val) {
                $registro[$key] = $val;
            }
            $avances[] = $registro;
        }
        $stmt->close();
        return $avances;
    }

    public function obtenerUltimoPorcentaje($compromiso_id) {
        $sql = "SELECT porcentaje_avance FROM avances WHERE compromiso_id = ? ORDER BY fecha_avance DESC LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $compromiso_id);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($porcentaje);
        $value = 0;
        if ($stmt->fetch()) {
            $value = intval($porcentaje);
        }
        $stmt->close();
        return $value;
    }

    public function existeFinalizacion($compromiso_id) {
        $sql = "SELECT COUNT(*) as total FROM avances WHERE compromiso_id = ? AND es_finalizacion = 1";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $compromiso_id);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($total);
        $value = false;
        if ($stmt->fetch() && $total > 0) {
            $value = true;
        }
        $stmt->close();
        return $value;
    }
}
