<?php

$route = $_GET['route'] ?? 'login';

switch ($route) {

    case 'login':
        require_once __DIR__ . '/../app/controllers/AuthController.php';
        (new AuthController($pdo))->login();
        break;

    case 'do_login':
        require_once __DIR__ . '/../app/controllers/AuthController.php';
        (new AuthController($pdo))->doLogin();
        break;

    case 'register':
        require_once __DIR__ . '/../app/controllers/AuthController.php';
        (new AuthController($pdo))->register();
        break;

    case 'dashboard':
        require_once __DIR__ . '/../app/controllers/AuthController.php';
        (new AuthController($pdo))->dashboard();
        break;

    case 'logout':
        session_destroy();
        header("Location: index.php?route=login");
        break;

    default:
        echo "404 Not Found";
}