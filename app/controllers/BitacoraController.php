<?php
require_once __DIR__ . '/../models/Bitacora.php';

class BitacoraController {
    public function index() {
        if (session_status() === PHP_SESSION_NONE) session_start();

        $modelo = new Bitacora();

        $esAdmin = isset($_SESSION['direccion']) && $_SESSION['direccion'] === 'Administrador';

        $filtro = isset($_GET['filtro']) ? trim($_GET['filtro']) : '';

        if ($esAdmin) {
            if ($filtro !== '') {
                $bitacora = $modelo->filtrarPorDireccion($filtro);
            } else {
                $bitacora = $modelo->obtenerTodas();
            }
        } else {
            $bitacora = $modelo->obtenerPorDireccion($_SESSION['direccion']);
        }

        require __DIR__ . '/../views/bitacora/index.php';
    }
}
