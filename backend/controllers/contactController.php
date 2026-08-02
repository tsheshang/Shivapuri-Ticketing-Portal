<?php
require '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../../frontend/pages/contact.html');
    exit;
}

$name = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');
$message = trim($_POST['message'] ?? '');

if (empty($name) || empty($email) || empty($message)) {
    die("All fields are required. <a href='../../frontend/pages/contact.html'>Go back</a>");
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    die("Invalid email address. <a href='../../frontend/pages/contact.html'>Go back</a>");
}

$stmt = $pdo->prepare(
    "INSERT INTO contact_messages (name, email, message) VALUES (:name, :email, :message)"
);
$stmt->execute([
    'name' => $name,
    'email' => $email,
    'message' => $message
]);

header('Location: ../../frontend/pages/contact-success.html');
exit;