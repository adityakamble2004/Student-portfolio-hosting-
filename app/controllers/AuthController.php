<?php
require_once __DIR__ . '/../models/User.php';

class AuthController {

    private $user;

    public function __construct($pdo) {
        $this->user = new User($pdo);
    }

    public function login() {
        require __DIR__ . '/../views/auth/login.php';
    }

    public function register() {
        require __DIR__ . '/../views/auth/register.php';
    }

    public function doLogin() {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
            $password = $_POST['password'];

            $user = $this->user->login($email, $password);

            if ($user) {
                session_regenerate_id(true);
                $_SESSION['user'] = $user;

                header("Location: index.php?route=dashboard");
                exit;
            } else {
                $error = "Invalid credentials";
                require __DIR__ . '/../views/auth/login.php';
            }
        }
    }

    public function dashboard() {

        if (!isset($_SESSION['user'])) {
            header("Location: index.php?route=login");
            exit;
        }

        $user = $_SESSION['user'];
        require __DIR__ . '/../views/dashboard/index.php';
    }
}