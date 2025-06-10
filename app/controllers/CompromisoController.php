<?php
require_once __DIR__ . '/../models/Compromiso.php';
require_once __DIR__ . '/../models/Bitacora.php';

class CompromisoController {
    private $modelo;

    public function __construct() {
        $this->modelo = new Compromiso();
    }

    public function index() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $direccion = $_SESSION['direccion'] ?? '';
        $compromisos = $this->modelo->obtenerPorDireccion($direccion);
        require __DIR__ . '/../views/compromisos/index.php';
    }

    public function create() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $compromiso = $_POST['compromiso'];
            $direccion = $_SESSION['direccion'];
            $archivo = $_FILES['pdf'];
            $archivoNombre = '';

            if ($archivo['error'] === UPLOAD_ERR_OK) {
                $archivoNombre = time() . "_" . basename($archivo['name']);
                move_uploaded_file($archivo['tmp_name'], __DIR__ . '/../../public/uploads/' . $archivoNombre);
            }

            $id = $this->modelo->crear($compromiso, $direccion, $archivoNombre);
            (new Bitacora())->registrar($id, $direccion, 'crear');

            $_SESSION['success'] = "Compromiso guardado con éxito.";
            header("Location: " . BASE_URL . "/?route=compromisos/index");
            exit;
        }

        require __DIR__ . '/../views/compromisos/create.php';
    }

    public function edit() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $id = $_GET['id'] ?? null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $compromiso = $_POST['compromiso'];
            $direccion = $_SESSION['direccion'];
            $archivo = $_FILES['pdf'];
            $archivoNombre = $_POST['pdf_actual'] ?? '';

            if ($archivo['error'] === UPLOAD_ERR_OK) {
                $archivoNombre = time() . "_" . basename($archivo['name']);
                move_uploaded_file($archivo['tmp_name'], __DIR__ . '/../../public/uploads/' . $archivoNombre);
            }

            $this->modelo->actualizar($id, $compromiso, $archivoNombre);
            (new Bitacora())->registrar($id, $direccion, 'editar');

            $_SESSION['success'] = "Compromiso actualizado.";
            header("Location: " . BASE_URL . "/?route=compromisos/index");
            exit;
        }

        $compromiso = $this->modelo->obtenerPorId($id);
        require __DIR__ . '/../views/compromisos/edit.php';
    }
}
