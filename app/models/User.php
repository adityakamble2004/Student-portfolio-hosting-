<?php // User model ?>
<?php
// app/models/User.php
require_once __DIR__ . '/../../config/db.php';

class User {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
public function getStudentsWithPortfolio() {

    $stmt = $this->pdo->prepare("
        SELECT users.id, users.name, portfolios.path
        FROM users
        LEFT JOIN portfolios ON users.id = portfolios.user_id
        WHERE users.role = 'student'
    ");

    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
    // Register new user
    public function register($name, $email, $password, $role) {
        // Check if email exists
        $stmt = $this->pdo->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->rowCount() > 0) {
            return "Email already exists";
        }

        // Hash password
        $hash = password_hash($password, PASSWORD_BCRYPT);

        $stmt = $this->pdo->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)");
        if ($stmt->execute([$name, $email, $hash, $role])) {
            return true;
        }
        return false;
    }

    // Login user
    public function login($email, $password) {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        return false;
    }
}