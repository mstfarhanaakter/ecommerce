<?php
session_start();
include __DIR__ . '/../../config/database.php';
header('Content-Type: application/json');

$user_id = $_SESSION['user_id'] ?? 0;
$product_id = $_POST['product_id'] ?? 0;
$quantity = $_POST['quantity'] ?? 1;

if (!$user_id) {
    echo json_encode(['status'=>'login']);
    exit;
}

// Check if already in cart
$stmt = $con->prepare("SELECT id, quantity FROM cart WHERE user_id=? AND product_id=? LIMIT 1");
$stmt->bind_param("ii", $user_id, $product_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $newQty = $row['quantity'] + $quantity;
    $stmt = $con->prepare("UPDATE cart SET quantity=? WHERE id=?");
    $stmt->bind_param("ii", $newQty, $row['id']);
    $stmt->execute();
} else {
    $stmt = $con->prepare("INSERT INTO cart (user_id, product_id, quantity) VALUES (?, ?, ?)");
    $stmt->bind_param("iii", $user_id, $product_id, $quantity);
    $stmt->execute();
}

// Return new cart count
$res = $con->query("SELECT SUM(quantity) as cnt FROM cart WHERE user_id=$user_id");
$cart_count = $res->fetch_assoc()['cnt'] ?? 0;

echo json_encode(['status'=>'success','count'=>$cart_count]);
?>
