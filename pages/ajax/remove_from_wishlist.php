<?php
include __DIR__ . '/../../config/database.php';
session_start();
header('Content-Type: application/json');

$user_id = $_SESSION['user_id'] ?? 0;
$product_id = $_POST['product_id'] ?? 0;

if (!$user_id) {
    echo json_encode(['status' => 'login']);
    exit;
}

if ($product_id) {
    $stmt = $con->prepare("DELETE FROM wishlist WHERE user_id=? AND product_id=?");
    $stmt->bind_param("ii", $user_id, $product_id);
    if ($stmt->execute()) {
        // Optional: get updated wishlist count
        $res = $con->query("SELECT COUNT(*) as cnt FROM wishlist WHERE user_id=$user_id");
        $count = $res->fetch_assoc()['cnt'] ?? 0;

        echo json_encode(['status' => 'success', 'count' => $count]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Could not remove item']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid product']);
}
