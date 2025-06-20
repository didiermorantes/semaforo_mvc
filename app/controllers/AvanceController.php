<?php
require_once __DIR__ . '/../models/Avance.php';
require_once __DIR__ . '/../models/Compromiso.php';

class AvanceController {
    private $modelo;
    private $modeloCompromiso;

    public function __construct() {
        $this->modelo = new Avance();
        $this->modeloCompromiso = new Compromiso();
    }

    // Muestra el formulario de avance para un compromiso
    public function mostrarFormulario($compromiso_id) {
        if (session_status() === PHP_SESSION_NONE) session_start();
        $usuario = $_SESSION['direccion'] ?? '';

        $compromiso = $this->modeloCompromiso->obtenerPorId($compromiso_id);

        // ¿Ya está finalizado?
        $finalizado = $this->modelo->existeFinalizacion($compromiso_id);

$ultimoPorcentaje = $this->modelo->obtenerUltimoPorcentaje($compromiso_id);
require __DIR__ . '/../views/avances/formulario.php';

    }

    // Guarda el avance
public function guardarAvance($compromiso_id, $usuario, $resumen, $es_finalizacion, $pdf_finalizacion) {
    if (session_status() === PHP_SESSION_NONE) session_start();

    $porcentaje_avance = isset($_POST['porcentaje_avance']) ? intval($_POST['porcentaje_avance']) : null;
    if ($es_finalizacion) {
        $porcentaje_avance = 100;
    }


    $archivoNombre = null;
    if ($es_finalizacion && $pdf_finalizacion && $pdf_finalizacion['error'] === UPLOAD_ERR_OK) {
        $archivoNombre = time() . "_" . basename($pdf_finalizacion['name']);
        move_uploaded_file($pdf_finalizacion['tmp_name'], __DIR__ . '/../../public/uploads/' . $archivoNombre);
    }

    $this->modelo->registrarAvance($compromiso_id, $resumen, $usuario, $es_finalizacion, $archivoNombre, $porcentaje_avance);

        // Si es finalización, actualizar estado del compromiso a finalizado
        if ($es_finalizacion) {
            $this->modeloCompromiso->marcarFinalizado($compromiso_id, $archivoNombre);
        }

        $_SESSION['success'] = $es_finalizacion
            ? "¡Compromiso finalizado y avance guardado exitosamente!"
            : "Avance registrado correctamente.";

        header("Location: " . BASE_URL . "/?route=compromisos/index");
        exit;
    }

    public function verHistorial($compromiso_id) {
    if (session_status() === PHP_SESSION_NONE) session_start();
    // echo "<pre>DEBUG AvanceController: compromiso_id recibido = "; var_dump($compromiso_id); echo "</pre>"; // debug
    $usuario = $_SESSION['direccion'] ?? '';
    $avances = $this->modelo->obtenerPorCompromiso($compromiso_id);

    // Obtener datos del compromiso para mostrar en el encabezado
    $compromiso = $this->modeloCompromiso->obtenerPorId($compromiso_id);

    require __DIR__ . '/../views/avances/timeline.php';
}


}
