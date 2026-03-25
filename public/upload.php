<?php
session_start();
require_once __DIR__ . '/../config/db.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'student') {
    header("Location: login.php");
    exit;
}

$user = $_SESSION['user'];
$message = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (isset($_FILES['zip_file']) && $_FILES['zip_file']['error'] == 0) {

        $file = $_FILES['zip_file'];

        // Validate file type
        $fileExt = pathinfo($file['name'], PATHINFO_EXTENSION);
        if ($fileExt !== 'zip') {
            $message = "Only ZIP files allowed!";
        } else {

            $uploadDir = __DIR__ . '/../uploads/';
            $portfolioDir = __DIR__ . '/../portfolios/' . $user['id'] . '/';

            // Create directories if not exist
            if (!file_exists($uploadDir)) mkdir($uploadDir, 0777, true);
            if (!file_exists($portfolioDir)) mkdir($portfolioDir, 0777, true);

            $zipPath = $uploadDir . time() . "_" . basename($file['name']);

            if (move_uploaded_file($file['tmp_name'], $zipPath)) {

                $zip = new ZipArchive;
                if ($zip->open($zipPath) === TRUE) {
                    $zip->extractTo($portfolioDir);
                    $zip->close();

                    // Save in DB
                    $stmt = $pdo->prepare("INSERT INTO portfolios (user_id, file_name, folder_path) VALUES (?, ?, ?)");
                    $stmt->execute([
                        $user['id'],
                        $file['name'],
                        'portfolios/' . $user['id']
                    ]);

                    $message = "Upload successful!";

                } else {
                    $message = "Failed to extract ZIP.";
                }

            } else {
                $message = "Upload failed.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Upload Portfolio</title>
</head>
<body>

<h2>Upload Your Portfolio</h2>

<?php if($message) echo "<p>$message</p>"; ?>

<form method="post" enctype="multipart/form-data">
    <input type="file" name="zip_file" required>
    <br><br>
    <button type="submit">Upload</button>
</form>

<br>
<a href="dashboard.php">Back to Dashboard</a>

</body>
</html>