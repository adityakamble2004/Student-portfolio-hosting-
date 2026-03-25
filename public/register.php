<?php
session_start();
require_once __DIR__ . '/../app/models/User.php';

$userObj = new User($pdo);
$message = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $role = $_POST['role'];

    $result = $userObj->register($name, $email, $password, $role);

    if ($result === true) {
        $_SESSION['success'] = "Registration successful. Please login!";
        header("Location: login.php");
        exit;
    } else {
        $message = $result;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <h2>Register</h2>
    <?php if($message) echo "<p style='color:red;'>$message</p>"; ?>
    <form method="post" action="">
        <input type="text" name="name" placeholder="Full Name" required><br><br>
        <input type="email" name="email" placeholder="Email" required><br><br>
        <input type="password" name="password" placeholder="Password" required><br><br>
        <select name="role" required>
            <option value="">Select Role</option>
            <option value="student">Student</option>
            <option value="recruiter">Recruiter</option>
            <option value="admin">Admin</option>
        </select><br><br>
        <button type="submit">Register</button>
    </form>
</body>
</html>