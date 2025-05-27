<?php
session_start();
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($username) || empty($password)) {
        $_SESSION['login_error'] = 'Username and password are required.';
        header('Location: ../index.html#login');
        exit;
    }

    // Fetch user by username
    $stmt = $conn->prepare('SELECT id, password FROM users WHERE username = ?');
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows === 1) {
        $stmt->bind_result($userId, $passwordHash);
        $stmt->fetch();
        if (password_verify($password, $passwordHash)) {
            $_SESSION['user_id'] = $userId;
            $_SESSION['username'] = $username;
            header('Location: ../index.html');
            exit;
        } else {
            $_SESSION['login_error'] = 'Invalid password.';
            header('Location: ../index.html#login');
            exit;
        }
    } else {
        $_SESSION['login_error'] = 'User not found.';
        header('Location: ../index.html#login');
        exit;
    }
} else {
    header('Location: ../index.html');
    exit;
}
?>
