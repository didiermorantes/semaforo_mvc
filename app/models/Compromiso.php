<?php
require_once __DIR__ . '/../../config.php';
require_once __DIR__ . '/Bitacora.php';

class Compromiso {
    private $db;
    private $bitacora;

    public function __construct() {
        $this->db = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        $this->bitacora = new Bitacora();
    }

    // Obtiene todos los compromisos de una dirección (usuario responsable)
public function obtenerPorDireccion($direccion) {
    $stmt = $this->db->prepare("SELECT * FROM compromisos WHERE direccion_responsable = ?");
    $stmt->bind_param("s", $direccion);
    $stmt->execute();
    $res = $stmt->get_result();
    return $res ? $res->fetch_all(MYSQLI_ASSOC) : [];
}

    // Obtiene todos los compromisos (para el panel del administrador)
public function obtenerTodos() {
    $res = $this->db->query("SELECT * FROM compromisos");
    return $res ? $res->fetch_all(MYSQLI_ASSOC) : [];
}

    // Obtiene los datos de un compromiso específico
    public function obtenerPorId($id) {
        $stmt = $this->db->prepare("SELECT * FROM compromisos WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        // error_log("DEBUG obtenerPorId - ID: $id - Resultado: " . print_r($res, true)); // debug
        return $stmt->get_result()->fetch_assoc();
    }

    // Crea un nuevo compromiso (por el Administrador)
    public function crear($compromiso, $direccion) {
        $stmt = $this->db->prepare("INSERT INTO compromisos (compromiso_especifico, direccion_responsable) VALUES (?, ?)");
        $stmt->bind_param("ss", $compromiso, $direccion);
        $stmt->execute();
        $idInsertado = $this->db->insert_id;
        $stmt->close();

        // Registrar en la bitácora como "Creado"
        $this->bitacora->registrar($idInsertado, $direccion, "Creado");

        return $idInsertado;
    }

    // Actualiza un compromiso (sólo si la lógica lo requiere; puedes usar para editar texto)
    public function actualizar($id, $compromiso) {
        $registro = $this->obtenerPorId($id);
        $direccion = $registro ? $registro['direccion_responsable'] : '';

        $stmt = $this->db->prepare("UPDATE compromisos SET compromiso_especifico = ? WHERE id = ?");
        $stmt->bind_param("si", $compromiso, $id);
        $stmt->execute();
        $stmt->close();

        // Registrar en la bitácora como "Editado"
        $this->bitacora->registrar($id, $direccion, "Editado");
    }

    // Marca un compromiso como finalizado (se actualizará desde el avance final, si deseas)
    public function marcarFinalizado($id, $pdf_finalizacion) {
        $registro = $this->obtenerPorId($id);
        $direccion = $registro ? $registro['direccion_responsable'] : '';

        $stmt = $this->db->prepare("UPDATE compromisos SET finalizado = 1, pdf_finalizacion = ? WHERE id = ?");
        $stmt->bind_param("si", $pdf_finalizacion, $id);
        $stmt->execute();
        $stmt->close();

        $this->bitacora->registrar($id, $direccion, "Finalizado");
    }
}
