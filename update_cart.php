<?php
require 'includes/db.php';
require 'includes/functions.php';

if (!is_logged_in()) {
    redirect('login.php');
}

$product_id = isset($_POST['product_id']) ? (int)$_POST['product_id'] : 0;
$quantity   = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 0;
$action     = $_POST['action'] ?? '';

if ($product_id <= 0 || $quantity < 0) {
    redirect('cart.php?error=invalid');
}

global $pdo;

// প্রোডাক্টের স্টক চেক করা
$stmt = $pdo->prepare("SELECT stock FROM products WHERE id = ?");
$stmt->execute([$product_id]);
$stock = $stmt->fetchColumn();

if ($action === 'increase') {
    $new_qty = ($_SESSION['cart'][$product_id] ?? 0) + 1;
    if ($new_qty > $stock) {
        $_SESSION['error'] = "পর্যাপ্ত স্টক নেই!";
        redirect('cart.php');
    }
    $_SESSION['cart'][$product_id] = $new_qty;
    
} elseif ($action === 'decrease') {
    $current = $_SESSION['cart'][$product_id] ?? 0;
    if ($current > 1) {
        $_SESSION['cart'][$product_id] = $current - 1;
    } else {
        unset($_SESSION['cart'][$product_id]); // ১ এর নিচে গেলে রিমুভ
    }
    
} elseif ($action === 'update' && $quantity >= 0) {
    if ($quantity === 0) {
        unset($_SESSION['cart'][$product_id]);
    } elseif ($quantity <= $stock) {
        $_SESSION['cart'][$product_id] = $quantity;
    } else {
        $_SESSION['error'] = "স্টকের চেয়ে বেশি পরিমাণ চেয়েছেন!";
    }
} else {
    // ডিরেক্ট remove
    unset($_SESSION['cart'][$product_id]);
}

redirect('cart.php');