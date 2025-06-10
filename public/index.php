<?php
require_once '../config.php';
require_once '../app/helpers/error_handler.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$route = $_GET['route'] ?? '';

if ($route) {
    require_once '../routes.php';
    exit;
}

// Si existe sesión y está definida dirección, ir al panel
if (isset($_SESSION['direccion']) && !empty($_SESSION['direccion'])) {
    header("Location: " . BASE_URL . "/?route=compromisos/index");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Bienvenido al Sistema de Compromisos</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light text-center p-5">
  <div class="container">
    <img src="<?= BASE_URL ?>/assets/logo.png" alt="Logo" class="mb-4" style="width: 150px;">
    <h1 class="mb-3">Sistema de Seguimiento de Compromisos</h1>
    <p class="lead mb-4">Bienvenido al sistema de gestión y semaforización de compromisos institucionales.</p>
    <a href="<?= BASE_URL ?>/?route=auth/login" class="btn btn-primary btn-lg">Ingresar al sistema</a>
  </div>
</body>
</html>
