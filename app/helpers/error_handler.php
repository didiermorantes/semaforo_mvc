<?php
function mostrarErrorPersonalizado($mensaje) {
    if (!is_dir(__DIR__ . '/../../logs')) {
        mkdir(__DIR__ . '/../../logs', 0755, true);
    }

    // Stacktrace personalizado
    $traceStr = '';
    $backtrace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);

    // Saltar los dos primeros frames (función actual y manejador)
    array_shift($backtrace);
    array_shift($backtrace);

    foreach ($backtrace as $i => $frame) {
        $archivo = isset($frame['file']) ? $frame['file'] : '[desconocido]';
        $linea = isset($frame['line']) ? $frame['line'] : '[?]';
        $funcion = isset($frame['function']) ? $frame['function'] : '[?]';
        $traceStr .= "#$i $archivo($linea): $funcion()\n";
    }

    $log = "[" . date('Y-m-d H:i:s') . "] $mensaje\nStacktrace:\n$traceStr\n";
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
    // Incluye el stacktrace nativo de la excepción (más detallado)
    $mensaje = "Excepción no controlada: " . $e->getMessage();
    $stack = $e->getTraceAsString();
    mostrarErrorPersonalizado("$mensaje\nStacktrace (Exception):\n$stack");
});

set_error_handler(function($errno, $errstr, $errfile, $errline) {
    $mensaje = "Error: $errstr en $errfile línea $errline";
    mostrarErrorPersonalizado($mensaje);
});

register_shutdown_function(function() {
    $error = error_get_last();
    if ($error && in_array($error['type'], [E_ERROR, E_CORE_ERROR, E_COMPILE_ERROR, E_PARSE])) {
        $mensaje = "Error fatal: {$error['message']} en {$error['file']} línea {$error['line']}";
        mostrarErrorPersonalizado($mensaje);
    }
});
