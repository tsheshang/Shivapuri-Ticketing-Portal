<?php
require 'adminGuard.php';
header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);
$id = $data['id'] ?? null;
$name = trim($data['name'] ?? '');
$price = floatval($data['price'] ?? 0);

if (!$id || empty($name) || $price <= 0) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid input']);
    exit;
}

$stmt = $pdo->prepare("UPDATE ticket_categories SET name = :name, price = :price WHERE id = :id");
$stmt->execute(['name' => $name, 'price' => $price, 'id' => $id]);
echo json_encode(['success' => true]);