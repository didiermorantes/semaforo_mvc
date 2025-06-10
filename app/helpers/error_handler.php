<?php
function mostrarErrorPersonalizado($mensaje) {
    if (!is_dir(__DIR__ . '/../../logs')) {
        mkdir(__DIR__ . '/../../logs', 0755, true);
    }

    $log = "[" . date('Y-m-d H:i:s') . "] $mensaje
";
    file_put_contents(__DIR__ . '/../../logs/error.log', $log, FILE_APPEND);

    if (!isset($_SESSION['__error_redirigido'])) {
        $_SESSION['error_global'] = $mensaje;
        $_SESSION['__error_redirigido'] = true;

        if (!isset($_GET['route']) || $_GET['route'] !== 'error') {
            header("Location: " . BASE_URL . "/?route=error");
            exit();
        }
    }
}

set_exception_handler(function($e) {
    mostrarErrorPersonalizado("Excepción no controlada: " . $e->getMessage());
});

set_error_handler(function($errno, $errstr, $errfile, $errline) {
    mostrarErrorPersonalizado("Error: $errstr en $errfile línea $errline");
});

register_shutdown_function(function() {
    $error = error_get_last();
    if ($error && in_array($error['type'], [E_ERROR, E_CORE_ERROR, E_COMPILE_ERROR, E_PARSE])) {
        mostrarErrorPersonalizado("Error fatal: {$error['message']} en {$error['file']} línea {$error['line']}");
    }
});
