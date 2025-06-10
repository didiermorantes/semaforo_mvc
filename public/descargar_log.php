<?php
require_once '../config.php';
if (session_status() === PHP_SESSION_NONE) session_start();

if (!isset($_SESSION['direccion']) || $_SESSION['direccion'] !== 'Administrador') {
    header("Location: " . BASE_URL . "/?route=auth/login");
    exit;
}

$logFile = __DIR__ . '/../logs/error.log';
if (file_exists($logFile)) {
    header('Content-Type: text/plain');
    header('Content-Disposition: attachment; filename="LOG_ERRORES_' . date("Ymd_His") . '.txt"');
    readfile($logFile);
    exit;
} else {
    echo "No hay log de errores disponible.";
}
