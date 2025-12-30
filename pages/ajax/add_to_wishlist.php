<?php
session_start();
include __DIR__ . '/../../config/database.php';
header('Content-Type: application/json');

$user_id = $_SESSION['user_id'] ?? 0;
$product_id = $_POST['product_id'] ?? 0;

if (!$user_id) {
    echo json_encode(['status'=>'login']);
    exit;
}

// Check if already in wishlist
$stmt = $con->prepare("SELECT id FROM wishlist WHERE user_id=? AND product_id=? LIMIT 1");
$stmt->bind_param("ii", $user_id, $product_id);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    echo json_encode(['status'=>'exists']);
    exit;
}

// Insert
$stmt = $con->prepare("INSERT INTO wishlist (user_id, product_id) VALUES (?, ?)");
$stmt->bind_param("ii", $user_id, $product_id);
$stmt->execute();

// Return new wishlist count
$res = $con->query("SELECT COUNT(*) as cnt FROM wishlist WHERE user_id=$user_id");
$wishlist_count = $res->fetch_assoc()['cnt'];

echo json_encode(['status'=>'success','count'=>$wishlist_count]);
?>
