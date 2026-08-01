<?php
session_start();
require '../config/db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Content-Type: application/json');
    http_response_code(403);
    echo json_encode(['error' => 'Unauthorized']);
    exit;
}
