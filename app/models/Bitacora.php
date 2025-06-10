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

    public function obtenerTodas()
    {
        $stmt = $this->conn->prepare("SELECT * FROM bitacora ORDER BY fecha DESC");
        $stmt->execute();
        $result = $stmt->get_result();
        $bitacora = [];
        while ($row = $result->fetch_assoc()) {
            $bitacora[] = $row;
        }
        return $bitacora;
    }

    public function obtenerPorDireccion($direccion)
    {
        $stmt = $this->conn->prepare("SELECT * FROM bitacora WHERE direccion_responsable = ? ORDER BY fecha DESC");
        $stmt->bind_param('s', $direccion);
        $stmt->execute();
        $result = $stmt->get_result();
        $bitacora = [];
        while ($row = $result->fetch_assoc()) {
            $bitacora[] = $row;
        }
        return $bitacora;
    }

    public function filtrarPorDireccion($filtro)
    {
        $stmt = $this->conn->prepare("SELECT * FROM bitacora WHERE direccion_responsable LIKE CONCAT('%', ?, '%') ORDER BY fecha DESC");
        $stmt->bind_param('s', $filtro);
        $stmt->execute();
        $result = $stmt->get_result();
        $bitacora = [];
        while ($row = $result->fetch_assoc()) {
            $bitacora[] = $row;
        }
        return $bitacora;
    }
}
