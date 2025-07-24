<?php
require_once __DIR__ . '/../models/Compromiso.php';
require_once __DIR__ . '/../models/Bitacora.php';
require_once __DIR__ . '/../models/Direccion.php';

class CompromisoController {
    private $modelo;

    public function __construct() {
        $this->modelo = new Compromiso();
    }

public function index() {
    if (session_status() === PHP_SESSION_NONE) session_start();

    if (!isset($_SESSION['direccion']) || empty($_SESSION['direccion'])) {
        $_SESSION['mensaje_error'] = 'Debes iniciar sesión para ver esta sección.';
        header("Location: ?route=auth/login");
        exit;
    }

    $direccion = $_SESSION['direccion'];
    $direccionesModel = new Direccion();
    $direcciones_responsables = $direccionesModel->obtenerTodas();

    // Captura filtros
    $filtro_dir = isset($_GET['filtro_direccion']) ? trim($_GET['filtro_direccion']) : '';
    $filtro_estado = isset($_GET['filtro_estado']) ? trim($_GET['filtro_estado']) : '';

    if ($direccion === 'Administrador') {
        $compromisos = ($filtro_dir) 
            ? $this->modelo->obtenerPorDireccion($filtro_dir)
            : $this->modelo->obtenerTodos();

        // Determina el estado para cada compromiso
        foreach ($compromisos as &$c) {
            if (!empty($c['finalizado']) && $c['finalizado']) {
                $c['estado'] = 'Finalizado';
            } elseif (!empty($c['fecha_limite']) && date('Y-m-d') > $c['fecha_limite']) {
                $c['estado'] = 'Vencido';
            } else {
                $c['estado'] = 'Pendiente';
            }
        }
        unset($c);

        // Filtra por estado si corresponde
        if ($filtro_estado && $filtro_estado !== 'Todos') {
            $compromisos = array_filter($compromisos, function($c) use ($filtro_estado) {
                return $c['estado'] === $filtro_estado;
            });
        }

    } else {
        // Usuario normal
        $compromisos = $this->modelo->obtenerPorDireccion($direccion);
        foreach ($compromisos as &$c) {
            if (!empty($c['finalizado']) && $c['finalizado']) {
                $c['estado'] = 'Finalizado';
            } elseif (!empty($c['fecha_limite']) && date('Y-m-d') > $c['fecha_limite']) {
                $c['estado'] = 'Vencido';
            } else {
                $c['estado'] = 'Pendiente';
            }
        }
        unset($c);
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

            $fecha_limite = $_POST['fecha_limite'] ?? '';
            
            // Ya no se sube PDF al crear el compromiso
            $id = $this->modelo->crear($compromiso, $direccion, $fecha_limite);
            (new Bitacora())->registrar($id, $direccion, 'crear');

            $_SESSION['success'] = "Compromiso guardado con éxito.";
            header("Location: " . BASE_URL . "/?route=compromisos/index");
            exit;
        }

        // --- Formulario de creación ---
        // Solo el admin ve la lista de direcciones responsables
        // antigua forma con las direcciones desde el controlador
/*
        $direcciones_responsables = [
            "Administrativa y Financiera", "Buen Gobierno", "Calidad Educativa", "Cobertura Educativa",
            "Despacho", "Educación Superior", "Infraestructura Educativa", "Medios y Nuevas Tecnologías",
            "Oficina Asesora de Planeación", "Oficina Asesora Jurídica", "Personal Docente", "Subsecretaría", "Transporte"
        ];

*/

    // ↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓
    // Nueva forma: cargar direcciones desde la base de datos
    $direccionesModel = new Direccion();
    $direcciones_responsables = $direccionesModel->obtenerTodas();
    // ↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑


        require __DIR__ . '/../views/compromisos/create.php';
    }

public function edit() {
    if (session_status() === PHP_SESSION_NONE) session_start();
    $id = $_GET['id'] ?? null;

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $compromiso = $_POST['compromiso'] ?? '';
        $direccion = $_POST['direccion'] ?? '';
        $fecha_limite = $_POST['fecha_limite'] ?? '';


        // Adaptado para incluir fecha_limite
        $this->modelo->actualizar($id, $compromiso, $direccion, $fecha_limite);
        (new Bitacora())->registrar($id, $direccion, 'editar');

        $_SESSION['success'] = "Compromiso actualizado.";
        header("Location: " . BASE_URL . "/?route=compromisos/index");
        exit;
    }

    $compromiso = $this->modelo->obtenerPorId($id);

    // <--- Agrega este array aquí:
    // antigua forma de agregar las direcciones responsables mediante el controlador
/*
    $direcciones_responsables = [
        "Administrador",
        "Administrativa y Financiera",
        "Buen Gobierno",
        "Calidad Educativa",
        "Cobertura Educativa",
        "Despacho",
        "Educación Superior",
        "Infraestructura Educativa",
        "Medios y Nuevas Tecnologías",
        "Oficina Asesora de Planeación",
        "Oficina Asesora Jurídica",
        "Personal Docente",
        "Subsecretaría",
        "Transporte"
    ];
*/
    // --->


        // ↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓
    // Nueva forma: cargar direcciones desde la base de datos
    $direccionesModel = new Direccion();
    $direcciones_responsables = $direccionesModel->obtenerTodas();
    // ↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑


    require __DIR__ . '/../views/compromisos/edit.php';
}

}
