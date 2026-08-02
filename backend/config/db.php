<?php
$host = "127.0.0.1";
$port = "5432";
$dbname = "shivapuri_ticketing";
$user = "user";
$password = "park2026";

try {
    $pdo = new PDO("pgsql:host=$host;port=$port;dbname=$dbname", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
