<?php

class Portfolio {

    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function save($user_id, $path) {

        $stmt = $this->pdo->prepare("
            INSERT INTO portfolios (user_id, path)
            VALUES (?, ?)
        ");

        return $stmt->execute([$user_id, $path]);
    }
    public function getByUser($user_id) {

    $stmt = $this->pdo->prepare("
        SELECT * FROM portfolios WHERE user_id = ?
    ");

    $stmt->execute([$user_id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}
}