<?php
session_start();
require '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../../frontend/pages/login.html');
    exit;
}

$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';

if (empty($email) || empty($password)) {
    die("Email and password are required. <a href='../../frontend/pages/login.html'>Go back</a>");
}

$stmt = $pdo->prepare("SELECT id, full_name, password_hash, role FROM users WHERE email = :email");
$stmt->execute(['email' => $email]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user || !password_verify($password, $user['password_hash'])) {
    die("Invalid email or password. <a href='../../frontend/pages/login.html'>Go back</a>");
}

// Login successful — start session
$_SESSION['user_id'] = $user['id'];
$_SESSION['full_name'] = $user['full_name'];
$_SESSION['role'] = $user['role'];

// Redirect admin and visitors differently
if ($user['role'] === 'admin') {
    header('Location: ../../frontend/pages/admin-dashboard.html'); // we'll build this later
} else {
    header('Location: ../../frontend/pages/index.html');
}
exit;
