<?php
// register.php
session_start();
header('Content-Type: application/json');
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // 1) Check if user exists
    $stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        echo json_encode(['status' => 'error', 'message' => 'Vartotojas jau egzistuoja.']);
        exit;
    }
    $stmt->close();

    // 2) Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // 3) Insert new user
    $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
    $stmt->bind_param("ss", $username, $hashed_password);
    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Registracija sėkminga.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Įvyko klaida: '.$stmt->error]);
    }
    $stmt->close();
    $conn->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Neteisingas užklausos tipas.']);
}
?>
