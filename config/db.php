<?php // DB connection ?>
<?php
// config/db.php

$host = "localhost";       // your DB host
$db_name = "portfolio_platform";  // your database name
$username = "root";        // DB username
$password = "";            // DB password

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db_name;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "Connected successfully"; // optional
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}