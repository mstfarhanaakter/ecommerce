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
    $stmt = $con->prepare("DELETE FROM cart WHERE user_id=? AND product_id=?");
    $stmt->bind_param("ii", $user_id, $product_id);
    if ($stmt->execute()) {
        $countRes = $con->query("SELECT SUM(quantity) as cnt FROM cart WHERE user_id=$user_id");
        $count = $countRes->fetch_assoc()['cnt'] ?? 0;
        echo json_encode(['status' => 'success', 'count' => $count]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Could not remove item']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid product']);
}
