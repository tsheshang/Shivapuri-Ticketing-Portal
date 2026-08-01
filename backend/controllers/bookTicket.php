<?php
session_start();
require '../config/db.php';

// Must be logged in to book
if (!isset($_SESSION['user_id'])) {
    header('Location: ../../frontend/pages/login.html');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../../frontend/pages/tickets.html');
    exit;
}

$user_id = $_SESSION['user_id'];
$category_code = trim($_POST['category'] ?? '');
$visit_date = trim($_POST['visit_date'] ?? '');
$quantity = intval($_POST['quantity'] ?? 0);
$full_name = trim($_POST['full_name'] ?? '');
$email = trim($_POST['email'] ?? '');
$phone = trim($_POST['phone'] ?? '');

// Validation
if (empty($category_code) || empty($visit_date) || $quantity < 1 || empty($full_name) || empty($email) || empty($phone)) {
    die("All fields are required. <a href='../../frontend/pages/tickets.html'>Go back</a>");
}

// Visit date must be today or in the future
if (strtotime($visit_date) < strtotime(date('Y-m-d'))) {
    die("Visit date cannot be in the past. <a href='../../frontend/pages/tickets.html'>Go back</a>");
}

// Look up the category to get its real price (never trust price from the form)
$catStmt = $pdo->prepare("SELECT id, price FROM ticket_categories WHERE code = :code");
$catStmt->execute(['code' => $category_code]);
$category = $catStmt->fetch(PDO::FETCH_ASSOC);

if (!$category) {
    die("Invalid ticket category. <a href='../../frontend/pages/tickets.html'>Go back</a>");
}

$total_price = $category['price'] * $quantity;

// Generate a unique booking reference, e.g. SHV-2026-0001
$year = date('Y');
$countStmt = $pdo->query("SELECT COUNT(*) FROM bookings WHERE booking_ref LIKE 'SHV-$year-%'");
$countThisYear = $countStmt->fetchColumn() + 1;
$booking_ref = "SHV-$year-" . str_pad($countThisYear, 4, '0', STR_PAD_LEFT);

// Insert the booking
$insertStmt = $pdo->prepare(
    "INSERT INTO bookings (user_id, category_id, visit_date, quantity, total_price, phone, booking_ref)
     VALUES (:user_id, :category_id, :visit_date, :quantity, :total_price, :phone, :booking_ref)"
);
$insertStmt->execute([
    'user_id' => $user_id,
    'category_id' => $category['id'],
    'visit_date' => $visit_date,
    'quantity' => $quantity,
    'total_price' => $total_price,
    'phone' => $phone,
    'booking_ref' => $booking_ref
]);

// Redirect to a confirmation page with the booking reference
header('Location: ../../frontend/pages/booking-confirmation.html?ref=' . urlencode($booking_ref));
exit;