<?php
require 'adminGuard.php';
header('Content-Type: application/json');

$stmt = $pdo->query("SELECT id, name, code, price FROM ticket_categories ORDER BY id");
echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));