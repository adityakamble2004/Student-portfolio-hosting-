<?php
session_start();

// Check if user logged in
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

$user = $_SESSION['user'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<h2>Welcome, <?php echo htmlspecialchars($user['name']); ?> 👋</h2>
<p>Role: <?php echo $user['role']; ?></p>

<hr>

<?php if ($user['role'] == 'student'): ?>

    <h3>🎓 Student Dashboard</h3>
    <ul>
        <li><a href="upload.php">Upload Portfolio</a></li>
        <li><a href="#">View My Portfolio</a></li>
        <li><a href="#">Edit Profile</a></li>
    </ul>

<?php elseif ($user['role'] == 'admin'): ?>

    <h3>🛠 Admin Dashboard</h3>
    <ul>
        <li><a href="#">Manage Users</a></li>
        <li><a href="#">Approve Portfolios</a></li>
        <li><a href="#">View Reports</a></li>
    </ul>

<?php elseif ($user['role'] == 'recruiter'): ?>

    <h3>💼 Recruiter Dashboard</h3>
    <ul>
        <li><a href="recruiter.php">Browse Students</a></li>
        <li><a href="#">Top Ranked Candidates</a></li>
    </ul>

<?php endif; ?>

<hr>

<a href="logout.php">Logout</a>

</body>
</html>