<?php
session_start();
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirmPassword = $_POST['confirmPassword'] ?? '';

    if (empty($username) || empty($email) || empty($password) || empty($confirmPassword)) {
        $_SESSION['signup_error'] = 'All fields are required.';
        header('Location: ../index.html#signup');
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['signup_error'] = 'Invalid email format.';
        header('Location: ../index.html#signup');
        exit;
    }

    if ($password !== $confirmPassword) {
        $_SESSION['signup_error'] = 'Passwords do not match.';
        header('Location: ../index.html#signup');
        exit;
    }

    // Check if username or email already exists
    $stmt = $conn->prepare('SELECT id FROM users WHERE username = ? OR email = ?');
    $stmt->bind_param('ss', $username, $email);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        $_SESSION['signup_error'] = 'Username or email already exists.';
        $stmt->close();
        header('Location: ../index.html#signup');
        exit;
    }
    $stmt->close();

    // Hash password
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    // Insert new user
    $stmt = $conn->prepare('INSERT INTO users (username, email, password) VALUES (?, ?, ?)');
    $stmt->bind_param('sss', $username, $email, $passwordHash);
    if ($stmt->execute()) {
        $_SESSION['signup_success'] = 'Registration successful. Please login.';
        $stmt->close();
        header('Location: ../index.html#login');
        exit;
    } else {
        $_SESSION['signup_error'] = 'Registration failed. Please try again.';
        $stmt->close();
        header('Location: ../index.html#signup');
        exit;
    }
} else {
    header('Location: ../index.html');
    exit;
}
?>
