<?php
require_once __DIR__ . '/../../config.php';
require_once __DIR__ . '/Bitacora.php';

class Compromiso {
    private $db;
    private $bitacora;

    public function __construct() {
        $this->db = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        $this->db->set_charset('utf8mb4');
        $this->bitacora = new Bitacora();
    }

    // Obtiene todos los compromisos de una dirección (usuario responsable)
    public function obtenerPorDireccion($direccion) {
        $stmt = $this->db->prepare("SELECT * FROM compromisos WHERE direccion_responsable = ?");
        $stmt->bind_param("s", $direccion);
        $stmt->execute();
        $stmt->store_result();

        $meta = $stmt->result_metadata();
        $fields = [];
        while ($field = $meta->fetch_field()) {
            $fields[] = &$row[$field->name];
        }

        call_user_func_array([$stmt, 'bind_result'], $fields);

        $resultados = [];
        while ($stmt->fetch()) {
            $registro = [];
            foreach ($row as $key => $val) {
                $registro[$key] = $val;
            }
            $resultados[] = $registro;
        }
        $stmt->close();
        return $resultados;
    }

    // Obtiene todos los compromisos (para el panel del administrador)
    public function obtenerTodos() {
        $resultados = [];
        $res = $this->db->query("SELECT * FROM compromisos");
        if ($res) {
            while ($row = $res->fetch_assoc()) {
                $resultados[] = $row;
            }
            $res->free();
        }
        return $resultados;
    }

    // Obtiene los datos de un compromiso específico
    public function obtenerPorId($id) {
        $stmt = $this->db->prepare("SELECT * FROM compromisos WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->store_result();

        $meta = $stmt->result_metadata();
        $fields = [];
        while ($field = $meta->fetch_field()) {
            $fields[] = &$row[$field->name];
        }

        call_user_func_array([$stmt, 'bind_result'], $fields);

        $registro = null;
        if ($stmt->fetch()) {
            $registro = [];
            foreach ($row as $key => $val) {
                $registro[$key] = $val;
            }
        }
        $stmt->close();
        return $registro;
    }

    // Crea un nuevo compromiso (por el Administrador)
// Método para crear un nuevo compromiso con fecha límite
public function crear($compromiso, $direccion, $fecha_limite) {
    $stmt = $this->db->prepare("INSERT INTO compromisos (compromiso_especifico, direccion_responsable, fecha_limite) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $compromiso, $direccion, $fecha_limite);
    $stmt->execute();
    $idInsertado = $this->db->insert_id;
    $stmt->close();

    // Registrar en la bitácora como "Creado"
    $this->bitacora->registrar($idInsertado, $direccion, "Creado");

    return $idInsertado;
}

    // Actualiza un compromiso (sólo si la lógica lo requiere; puedes usar para editar texto)
// Método para actualizar un compromiso (incluyendo fecha límite)
public function actualizar($id, $compromiso, $direccion, $fecha_limite) {
    $registro = $this->obtenerPorId($id);
    $direccion_anterior = $registro ? $registro['direccion_responsable'] : '';

    $stmt = $this->db->prepare("UPDATE compromisos SET compromiso_especifico = ?, direccion_responsable = ?, fecha_limite = ? WHERE id = ?");
    $stmt->bind_param("sssi", $compromiso, $direccion, $fecha_limite, $id);
    $stmt->execute();
    $stmt->close();

    // Registrar en bitácora como "Editado" y con la dirección actualizada
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

    // Método para determinar el estado del compromiso (finalizado, pendiente, vencido)
public function calcularEstado($compromiso) {
    // Recibe un array de la fila del compromiso
    if (!empty($compromiso['finalizado']) && $compromiso['finalizado']) {
        return 'finalizado';
    }
    $hoy = date('Y-m-d');
    if (!empty($compromiso['fecha_limite']) && $hoy > $compromiso['fecha_limite']) {
        return 'vencido';
    }
    return 'pendiente';
}


}
