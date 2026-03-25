<?php
session_start();
require_once __DIR__ . '/../config/db.php';

// Only recruiter allowed
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'recruiter') {
    header("Location: login.php");
    exit;
}

// Fetch all student portfolios
$stmt = $pdo->prepare("
    SELECT users.id, users.name, users.email, portfolios.folder_path
    FROM users
    JOIN portfolios ON users.id = portfolios.user_id
    WHERE users.role = 'student'
    ORDER BY portfolios.created_at DESC
");

$stmt->execute();
$students = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Recruiter Dashboard</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<h2>💼 Recruiter Dashboard</h2>
<a href="dashboard.php">← Back</a>

<hr>

<h3>All Student Portfolios</h3>

<?php if (count($students) > 0): ?>

    <?php foreach ($students as $student): ?>

        <div style="border:1px solid #ccc; padding:10px; margin:10px 0;">
            <h4><?php echo htmlspecialchars($student['name']); ?></h4>
            <p>Email: <?php echo htmlspecialchars($student['email']); ?></p>

            <a href="../<?php echo $student['folder_path']; ?>/"
               target="_blank">
               🌐 View Portfolio
            </a>
        </div>

    <?php endforeach; ?>

<?php else: ?>
    <p>No portfolios available.</p>
<?php endif; ?>

</body>
</html>