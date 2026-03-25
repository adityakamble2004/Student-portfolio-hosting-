<?php
require_once __DIR__ . '/../models/Portfolio.php';

class PortfolioController {

    private $portfolio;

    public function __construct($pdo) {
        $this->portfolio = new Portfolio($pdo);
    }

    public function showUpload() {

        if (!isset($_SESSION['user'])) {
            header("Location: index.php?route=login");
            exit;
        }

        require __DIR__ . '/../views/portfolio/upload.php';
    }

    public function upload() {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            if (!isset($_SESSION['user'])) {
                die("Unauthorized");
            }

            $user_id = $_SESSION['user']['id'];

            if (!isset($_FILES['zip'])) {
                die("No file uploaded");
            }

            $file = $_FILES['zip'];

            // 🔐 VALIDATION
            if ($file['type'] !== 'application/zip') {
                die("Only ZIP files allowed");
            }

            if ($file['size'] > 5 * 1024 * 1024) {
                die("File too large (Max 5MB)");
            }

            // 🔥 SAFE FILE NAME
            $zipName = uniqid() . '.zip';
            $zipPath = __DIR__ . '/../../storage/uploads/' . $zipName;

            move_uploaded_file($file['tmp_name'], $zipPath);

            // 📦 EXTRACT ZIP
            $extractPath = __DIR__ . '/../../portfolios/user_' . $user_id;

            if (!file_exists($extractPath)) {
                mkdir($extractPath, 0777, true);
            }

            $zip = new ZipArchive;
            if ($zip->open($zipPath) === TRUE) {
                $zip->extractTo($extractPath);
                $zip->close();
            } else {
                die("Failed to extract ZIP");
            }

            // 💾 SAVE TO DB
            $this->portfolio->save($user_id, $extractPath);

            header("Location: index.php?route=dashboard");
        }
    }
}