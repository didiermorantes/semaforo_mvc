<?php

class Bitacora
{
    private $conn;

    public function __construct()
    {
        $this->conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        if ($this->conn->connect_error) {
            die('Error de conexión: ' . $this->conn->connect_error);
        }
    }

    // === 1. Todas las entradas ===
    public function obtenerTodas()
    {
        $sql = "SELECT * FROM bitacora ORDER BY fecha DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $stmt->store_result();

        $meta = $stmt->result_metadata();
        $fields = [];
        while ($field = $meta->fetch_field()) {
            $fields[] = &$row[$field->name];
        }
        call_user_func_array([$stmt, 'bind_result'], $fields);

        $bitacora = [];
        while ($stmt->fetch()) {
            $registro = [];
            foreach ($row as $key => $val) {
                $registro[$key] = $val;
            }
            $bitacora[] = $registro;
        }
        $stmt->close();
        return $bitacora;
    }

    // === 2. Entradas por dirección ===
    public function obtenerPorDireccion($direccion)
    {
        $sql = "SELECT * FROM bitacora WHERE direccion_responsable = ? ORDER BY fecha DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('s', $direccion);
        $stmt->execute();
        $stmt->store_result();

        $meta = $stmt->result_metadata();
        $fields = [];
        while ($field = $meta->fetch_field()) {
            $fields[] = &$row[$field->name];
        }
        call_user_func_array([$stmt, 'bind_result'], $fields);

        $bitacora = [];
        while ($stmt->fetch()) {
            $registro = [];
            foreach ($row as $key => $val) {
                $registro[$key] = $val;
            }
            $bitacora[] = $registro;
        }
        $stmt->close();
        return $bitacora;
    }

    // === 3. Filtro tipo LIKE ===
    public function filtrarPorDireccion($filtro)
    {
        $sql = "SELECT * FROM bitacora WHERE direccion_responsable LIKE CONCAT('%', ?, '%') ORDER BY fecha DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('s', $filtro);
        $stmt->execute();
        $stmt->store_result();

        $meta = $stmt->result_metadata();
        $fields = [];
        while ($field = $meta->fetch_field()) {
            $fields[] = &$row[$field->name];
        }
        call_user_func_array([$stmt, 'bind_result'], $fields);

        $bitacora = [];
        while ($stmt->fetch()) {
            $registro = [];
            foreach ($row as $key => $val) {
                $registro[$key] = $val;
            }
            $bitacora[] = $registro;
        }
        $stmt->close();
        return $bitacora;
    }

    // === 4. Registrar nueva entrada ===
    public function registrar($compromisoId, $direccion, $accion)
    {
        $stmt = $this->conn->prepare("INSERT INTO bitacora (compromiso_id, direccion_responsable, accion, fecha) VALUES (?, ?, ?, NOW())");
        $stmt->bind_param("iss", $compromisoId, $direccion, $accion);
        $stmt->execute();
        $stmt->close();
    }
}
