<?php
require 'adminGuard.php';
header('Content-Type: application/json');

$stmt = $pdo->query("
    SELECT b.id, b.booking_ref, u.full_name, u.email, tc.name AS category_name,
           b.visit_date, b.quantity, b.total_price, b.phone, b.status, b.created_at
    FROM bookings b
    JOIN users u ON b.user_id = u.id
    JOIN ticket_categories tc ON b.category_id = tc.id
    ORDER BY b.created_at DESC
");
echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
