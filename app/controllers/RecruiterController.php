<?php
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/Portfolio.php';

class RecruiterController {

    private $user;
    private $portfolio;

    public function __construct($pdo) {
        $this->user = new User($pdo);
        $this->portfolio = new Portfolio($pdo);
    }

    public function index() {

        // 🔐 Only recruiter allowed
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'recruiter') {
            die("Access Denied");
        }

        $students = $this->user->getStudentsWithPortfolio();

        require __DIR__ . '/../views/recruiter/index.php';
    }

    public function viewPortfolio() {

        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'recruiter') {
            die("Access Denied");
        }

        $user_id = $_GET['id'] ?? null;

        if (!$user_id) {
            die("Invalid request");
        }

        $portfolio = $this->portfolio->getByUser($user_id);

        if (!$portfolio) {
            die("Portfolio not found");
        }

        // 🔥 redirect to actual portfolio
        $path = str_replace(__DIR__ . '/../../', '', $portfolio['path']);
        header("Location: " . $path . "/index.html");
    }
}