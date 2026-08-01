<?php
require 'adminGuard.php';
header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);
$id = $data['id'] ?? null;
$status = $data['status'] ?? null;

if (!$id || !in_array($status, ['confirmed', 'cancelled'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid input']);
    exit;
}

$stmt = $pdo->prepare("UPDATE bookings SET status = :status WHERE id = :id");
$stmt->execute(['status' => $status, 'id' => $id]);
echo json_encode(['success' => true]);