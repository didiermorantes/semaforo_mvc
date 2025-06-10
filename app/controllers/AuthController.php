<?php
class AuthController {
    public function login() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $direccion = $_POST['direccion'] ?? '';
            if ($direccion !== '') {
                $_SESSION['direccion'] = $direccion;
                header("Location: " . BASE_URL . "/?route=compromisos/index");
                exit;
            } else {
                $_SESSION['error'] = "Debe seleccionar una dirección.";
            }
        }

        require __DIR__ . '/../views/auth/login.php';
    }

    public function logout() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        session_destroy();
        header("Location: " . BASE_URL . "/?route=auth/login");
        exit;
    }
}
