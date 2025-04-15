<?php
// check_session.php
session_start();
header('Content-Type: application/json');

if (isset($_SESSION['username'])) {
    echo json_encode([
        'status' => 'logged_in',
        'username' => $_SESSION['username']
    ]);
} else {
    echo json_encode(['status' => 'not_logged_in']);
}
?>
