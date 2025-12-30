<?php
include __DIR__ . '/../../config/database.php';
session_start();
header('Content-Type: application/json');

$user_id = $_SESSION['user_id'] ?? 0;
$product_id = $_POST['product_id'] ?? 0;
$quantity = $_POST['quantity'] ?? 1;

if (!$user_id) {
    echo json_encode(['status' => 'login']);
    exit;
}

// Validate input
$product_id = (int)$product_id;
$quantity = (int)$quantity;
if ($product_id <= 0 || $quantity < 1) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid data']);
    exit;
}

// Check if product exists in cart for this user
$stmtCheck = $con->prepare("SELECT id FROM cart WHERE user_id=? AND product_id=?");
$stmtCheck->bind_param("ii", $user_id, $product_id);
$stmtCheck->execute();
$res = $stmtCheck->get_result();

if ($res->num_rows > 0) {
    // Update quantity
    $stmt = $con->prepare("UPDATE cart SET quantity=? WHERE user_id=? AND product_id=?");
    $stmt->bind_param("iii", $quantity, $user_id, $product_id);
    $stmt->execute();
} else {
    // Optionally, insert product if not exist
    $stmt = $con->prepare("INSERT INTO cart (user_id, product_id, quantity) VALUES (?, ?, ?)");
    $stmt->bind_param("iii", $user_id, $product_id, $quantity);
    $stmt->execute();
}

// Return updated cart count
$countRes = $con->query("SELECT SUM(quantity) as cnt FROM cart WHERE user_id=$user_id");
$count = $countRes->fetch_assoc()['cnt'] ?? 0;

echo json_encode(['status' => 'success', 'count' => $count]);
