<?php
// login.php
session_start();
header('Content-Type: application/json');
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // 1) Find user row
    $stmt = $conn->prepare("SELECT id, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($id, $hashed_password);
    $stmt->fetch();
    $stmt->close();

    if (!$id) {
        echo json_encode(['status' => 'error', 'message' => 'Vartotojas nerastas.']);
        exit;
    }

    // 2) Verify password
    if (password_verify($password, $hashed_password)) {
        $_SESSION['user_id'] = $id;
        $_SESSION['username'] = $username;
        echo json_encode(['status' => 'success', 'message' => 'Prisijungimas sėkmingas.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Neteisingas slaptažodis.']);
    }
    $conn->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Neteisingas užklausos tipas.']);
}
?>
