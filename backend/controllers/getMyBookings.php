<?php
session_start();
require '../config/db.php';
header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(['error' => 'Not logged in']);
    exit;
}

$stmt = $pdo->prepare("
    SELECT b.id, b.booking_ref, tc.name AS category_name, b.visit_date,
           b.quantity, b.total_price, b.phone, b.status, b.created_at
    FROM bookings b
    JOIN ticket_categories tc ON b.category_id = tc.id
    WHERE b.user_id = :user_id
    ORDER BY b.created_at DESC
");
$stmt->execute(['user_id' => $_SESSION['user_id']]);
echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
