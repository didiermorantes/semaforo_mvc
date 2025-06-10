<?php
require_once __DIR__ . '/../../config.php';

class LogController {
    public function index() {
        if (session_status() === PHP_SESSION_NONE) session_start();

        // Solo "Administrador" puede acceder al log
        if (!isset($_SESSION['direccion']) || $_SESSION['direccion'] !== 'Administrador') {
            header("Location: " . BASE_URL . "/?route=auth/login");
            exit;
        }

        $logFile = __DIR__ . '/../../logs/error.log';
        $contenido = file_exists($logFile) ? file_get_contents($logFile) : 'No hay errores registrados.';

        require __DIR__ . '/../views/logs/index.php';
    }

    public function limpiar() {
        if (session_status() === PHP_SESSION_NONE) session_start();

        // Solo "Administrador" puede limpiar el log
        if ($_SESSION['direccion'] === 'Administrador') {
            file_put_contents(__DIR__ . '/../../logs/error.log', '');
            $_SESSION['success'] = "El log ha sido limpiado.";
        }

        header("Location: " . BASE_URL . "/?route=log/index");
        exit;
    }
}
