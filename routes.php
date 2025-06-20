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
case 'avances/formulario':
    require_once __DIR__ . '/app/controllers/AvanceController.php';
    $controller = new AvanceController();
    $compromiso_id = $_GET['compromiso_id'] ?? null;
    if ($compromiso_id) {
        $controller->mostrarFormulario($compromiso_id);
    } else {
        header('Location: ?route=error');
    }
    break;

case 'avances/guardar':
    require_once __DIR__ . '/app/controllers/AvanceController.php';
    $controller = new AvanceController();
    $compromiso_id = $_POST['compromiso_id'] ?? null;
    $usuario = $_SESSION['direccion'] ?? null;
    $resumen = $_POST['resumen'] ?? '';
    $es_finalizacion = isset($_POST['finalizar']) && $_POST['finalizar'] == '1' ? 1 : 0;
    $pdf_finalizacion = $_FILES['pdf_finalizacion'] ?? null;
    if ($compromiso_id && $usuario && $resumen) {
        $controller->guardarAvance($compromiso_id, $usuario, $resumen, $es_finalizacion, $pdf_finalizacion);
    } else {
        $_SESSION['mensaje_error'] = 'Datos incompletos para el avance.';
        header('Location: ?route=error');
    }
    break;

    case 'avances/timeline':
    require_once __DIR__ . '/app/controllers/AvanceController.php';
    $controller = new AvanceController();
    $compromiso_id = $_GET['compromiso_id'] ?? null;
    if ($compromiso_id) {
        $controller->verHistorial($compromiso_id);
    } else {
        header('Location: ?route=error');
    }
    break;
    

    case 'error':
        include __DIR__ . '/app/views/error.php';
        break;
    // Otros casos adicionales aquí...
}
