<?php
require 'adminGuard.php';
header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);
$name = trim($data['name'] ?? '');
$code = trim($data['code'] ?? '');
$price = floatval($data['price'] ?? 0);

if (empty($name) || empty($code) || $price <= 0) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid input']);
    exit;
}

$stmt = $pdo->prepare("INSERT INTO ticket_categories (name, code, price) VALUES (:name, :code, :price)");
$stmt->execute(['name' => $name, 'code' => $code, 'price' => $price]);
echo json_encode(['success' => true]);
