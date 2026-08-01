<?php
require 'adminGuard.php';
header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);
$id = $data['id'] ?? null;

if (!$id) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid input']);
    exit;
}

$stmt = $pdo->prepare("DELETE FROM ticket_categories WHERE id = :id");
$stmt->execute(['id' => $id]);
echo json_encode(['success' => true]);