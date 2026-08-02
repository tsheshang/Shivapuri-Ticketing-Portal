<?php
require 'adminGuard.php';
header('Content-Type: application/json');

$stmt = $pdo->query("SELECT id, name, email, message, created_at FROM contact_messages ORDER BY created_at DESC");
echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
