<?php
// includes/functions.php

require_once 'db.php';  // $pdo এখান থেকে আসবে

// সেশন সেফলি শুরু করা (যদি db.php-তে না করা থাকে)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function is_logged_in() {
    return isset($_SESSION['user_id']);
}

function is_admin() {
    return isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1;
}

function redirect($url) {
    header("Location: $url");
    exit();
}

function add_to_cart($product_id, $quantity = 1) {
    $product_id = (int)$product_id;
    $quantity = max(1, (int)$quantity);

    global $pdo;

    $stmt = $pdo->prepare("SELECT stock FROM products WHERE id = ?");
    $stmt->execute([$product_id]);
    $product = $stmt->fetch();

    if (!$product || $product['stock'] < $quantity) {
        return false;
    }

    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    $current_qty = isset($_SESSION['cart'][$product_id]) 
        ? $_SESSION['cart'][$product_id] 
        : 0;

    $new_qty = $current_qty + $quantity;

    if ($new_qty > $product['stock']) {
        return false;
    }

    $_SESSION['cart'][$product_id] = $new_qty;
    return true;
}

function remove_from_cart($product_id) {
    $product_id = (int)$product_id;
    if (isset($_SESSION['cart'][$product_id])) {
        unset($_SESSION['cart'][$product_id]);
        return true;
    }
    return false;
}

function get_cart_items() {
    $items = [];

    if (empty($_SESSION['cart'])) {
        return $items;
    }

    global $pdo;

    foreach ($_SESSION['cart'] as $product_id => $quantity) {
        $stmt = $pdo->prepare("
            SELECT id, name, price, image 
            FROM products 
            WHERE id = ?
        ");
        $stmt->execute([$product_id]);
        $product = $stmt->fetch();

        if ($product) {
            $product['quantity'] = $quantity;
            $product['subtotal'] = $product['price'] * $quantity;
            $items[] = $product;
        }
    }

    return $items;
}

function get_cart_total() {
    $total = 0;
    foreach (get_cart_items() as $item) {
        $total += $item['subtotal'];
    }
    return $total;
}

// এই ফাংশনটা যোগ করলেই সমস্যা সমাধান হবে
function clear_cart() {
    unset($_SESSION['cart']);
}