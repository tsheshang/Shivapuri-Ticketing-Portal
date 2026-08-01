<?php
session_start();
require '../config/db.php';

// Only allow POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../../frontend/pages/login.html');
    exit;
}

$full_name = trim($_POST['full_name'] ?? '');
$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';
$confirm_password = $_POST['confirm_password'] ?? '';

// Basic validation
if (empty($full_name) || empty($email) || empty($password) || empty($confirm_password)) {
    die("All fields are required. <a href='../../frontend/pages/login.html'>Go back</a>");
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    die("Invalid email address. <a href='../../frontend/pages/login.html'>Go back</a>");
}

if (strlen($password) < 6) {
    die("Password must be at least 6 characters. <a href='../../frontend/pages/login.html'>Go back</a>");
}

if ($password !== $confirm_password) {
    die("Passwords do not match. <a href='../../frontend/pages/login.html'>Go back</a>");
}

// Check if email already exists
$checkStmt = $pdo->prepare("SELECT id FROM users WHERE email = :email");
$checkStmt->execute(['email' => $email]);

if ($checkStmt->fetch()) {
    die("An account with this email already exists. <a href='../../frontend/pages/login.html'>Go back and login</a>");
}

// Hash the password securely (never store plain text passwords)
$password_hash = password_hash($password, PASSWORD_DEFAULT);

// Insert the new user
$insertStmt = $pdo->prepare(
    "INSERT INTO users (full_name, email, password_hash, role) VALUES (:full_name, :email, :password_hash, 'visitor')"
);
$insertStmt->execute([
    'full_name' => $full_name,
    'email' => $email,
    'password_hash' => $password_hash
]);

// Log them in immediately after registering
$newUserId = $pdo->lastInsertId('users_id_seq');
$_SESSION['user_id'] = $newUserId;
$_SESSION['full_name'] = $full_name;
$_SESSION['role'] = 'visitor';

header('Location: ../../frontend/pages/index.html');
exit;
