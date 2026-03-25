<?php
session_start();
require_once __DIR__ . '/../app/models/User.php';

$userObj = new User($pdo);
$message = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $user = $userObj->login($email, $password);

    if ($user) {
        $_SESSION['user'] = $user;
        // Redirect based on role
        switch ($user['role']) {
            case 'admin':
                header("Location: dashboard.php");
                break;
            case 'student':
                header("Location: dashboard.php");
                break;
            case 'recruiter':
                header("Location: dashboard.php");
                break;
        }
        exit;
    } else {
        $message = "Invalid email or password";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <h2>Login</h2>
    <?php if($message) echo "<p style='color:red;'>$message</p>"; ?>
    <form method="post" action="">
        <input type="email" name="email" placeholder="Email" required><br><br>
        <input type="password" name="password" placeholder="Password" required><br><br>
        <button type="submit">Login</button>
    </form>
</body>
</html>