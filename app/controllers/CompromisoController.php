<?php
require_once __DIR__ . '/../models/Compromiso.php';
require_once __DIR__ . '/../models/Bitacora.php';

class CompromisoController {
    private $modelo;

    public function __construct() {
        $this->modelo = new Compromiso();
    }

public function index() {
    if (session_status() === PHP_SESSION_NONE) session_start();

    // Validación recomendada:
    if (!isset($_SESSION['direccion']) || empty($_SESSION['direccion'])) {
        $_SESSION['mensaje_error'] = 'Debes iniciar sesión para ver esta sección.';
        header("Location: ?route=auth/login");
        exit;
    }

    $direccion = $_SESSION['direccion'];

    // Si es admin ve todos, si no solo los suyos
    if ($direccion === 'Administrador') {
        $compromisos = $this->modelo->obtenerTodos();
    } else {
        $compromisos = $this->modelo->obtenerPorDireccion($direccion);
    }
    require __DIR__ . '/../views/compromisos/index.php';
}

    public function create() {
        if (session_status() === PHP_SESSION_NONE) session_start();

        $esAdmin = ($_SESSION['direccion'] ?? '') === 'Administrador';

        // --- Procesamiento POST ---
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $compromiso = $_POST['compromiso'] ?? '';
            $direccion = $esAdmin ? ($_POST['direccion'] ?? '') : ($_SESSION['direccion'] ?? '');

            // Ya no se sube PDF al crear el compromiso
            $id = $this->modelo->crear($compromiso, $direccion);
            (new Bitacora())->registrar($id, $direccion, 'crear');

            $_SESSION['success'] = "Compromiso guardado con éxito.";
            header("Location: " . BASE_URL . "/?route=compromisos/index");
            exit;
        }

        // --- Formulario de creación ---
        // Solo el admin ve la lista de direcciones responsables
        $direcciones_responsables = [
            "Administrativa y Financiera", "Buen Gobierno", "Calidad Educativa", "Cobertura Educativa",
            "Despacho", "Educación Superior", "Infraestructura Educativa", "Medios y Nuevas Tecnologías",
            "Oficina Asesora de Planeación", "Oficina Asesora Jurídica", "Personal Docente", "Subsecretaría", "Transporte"
        ];
        require __DIR__ . '/../views/compromisos/create.php';
    }

    public function edit() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        $id = $_GET['id'] ?? null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $compromiso = $_POST['compromiso'] ?? '';
            $direccion = $_SESSION['direccion'] ?? '';

            // Ya no se sube PDF aquí (solo editar texto)
            $this->modelo->actualizar($id, $compromiso);
            (new Bitacora())->registrar($id, $direccion, 'editar');

            $_SESSION['success'] = "Compromiso actualizado.";
            header("Location: " . BASE_URL . "/?route=compromisos/index");
            exit;
        }

        $compromiso = $this->modelo->obtenerPorId($id);
        require __DIR__ . '/../views/compromisos/edit.php';
    }
}
