<?php
session_start();
require '../config/db.php';
header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(['error' => 'Not logged in']);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);
$id = $data['id'] ?? null;

if (!$id) {
    http_response_code(400);
    echo json_encode(['error' => 'Missing booking id']);
    exit;
}

// Only allow cancelling YOUR OWN booking (authorization check)
$stmt = $pdo->prepare("UPDATE bookings SET status = 'cancelled' WHERE id = :id AND user_id = :user_id");
$stmt->execute(['id' => $id, 'user_id' => $_SESSION['user_id']]);

if ($stmt->rowCount() === 0) {
    http_response_code(403);
    echo json_encode(['error' => 'Booking not found or not yours']);
    exit;
}

echo json_encode(['success' => true]);
