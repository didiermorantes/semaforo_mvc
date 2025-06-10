<?php
$route = $_GET['route'] ?? '';

switch ($route) {
    case 'auth/login':
        require_once __DIR__ . '/app/controllers/AuthController.php';
        $controller = new AuthController();
        $controller->login();
        break;
    case 'compromisos/index':
        require_once __DIR__ . '/app/controllers/CompromisoController.php';
        $controller = new CompromisoController();
        $controller->index();
        break;
    case 'compromisos/create':
        require_once __DIR__ . '/app/controllers/CompromisoController.php';
        $controller = new CompromisoController();
        $controller->create();
        break;
    case 'compromisos/edit':
        require_once __DIR__ . '/app/controllers/CompromisoController.php';
        $controller = new CompromisoController();
        $controller->edit();
        break;
    case 'bitacora/index':
        require_once __DIR__ . '/app/controllers/BitacoraController.php';
        $controller = new BitacoraController();
        $controller->index();
        break;
    case 'log/index':
        require_once __DIR__ . '/app/controllers/LogController.php';
        $controller = new LogController();
        $controller->index();
        break;
    case 'log/limpiar':
        require_once __DIR__ . '/app/controllers/LogController.php';
        $controller = new LogController();
        $controller->limpiar();
        break;
    case 'auth/logout':
        require_once __DIR__ . '/public/logout.php';
        break;
    case 'error':
        include __DIR__ . '/app/views/error.php';
        break;
    // Otros casos adicionales aquí...
}
