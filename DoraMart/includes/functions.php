<?php
require_once 'config.php';

// লগইন চেক
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

// অ্যাডমিন চেক
function isAdmin() {
    return isLoggedIn() && isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
}

// লগইন রিকোয়ার করো (না থাকলে login.php এ পাঠাও)
function requireLogin($redirect_url = null) {
    if (!isLoggedIn()) {
        $url = $redirect_url ? "users/login.php?redirect=" . urlencode($redirect_url) : "users/login.php";
        header("Location: $url?msg=" . urlencode("লগইন করুন প্রোডাক্ট কিনতে"));
        exit();
    }
}

// প্রোডাক্ট পেতে হেল্পার (Featured + Active)
function getFeaturedProducts($pdo, $limit = 8) {
    $stmt = $pdo->prepare("
        SELECT p.*, b.name as brand_name, pi.image_path,
               IFNULL(p.discount_price, p.base_price) as display_price
        FROM products p 
        LEFT JOIN brands b ON p.brand_id = b.id
        LEFT JOIN product_images pi ON p.id = pi.product_id AND pi.is_primary = 1
        WHERE p.status = 'active' AND p.stock > 0 AND p.is_featured = 1
        ORDER BY p.created_at DESC LIMIT ?
    ");
    $stmt->execute([$limit]);
    return $stmt->fetchAll();
}

// সিঙ্গেল প্রোডাক্ট
function getProduct($pdo, $slug) {
    $stmt = $pdo->prepare("
        SELECT p.*, b.name as brand_name,
               IFNULL(p.discount_price, p.base_price) as display_price
        FROM products p 
        LEFT JOIN brands b ON p.brand_id = b.id
        WHERE p.slug = ? AND p.status = 'active' AND p.stock > 0
    ");
    $stmt->execute([$slug]);
    return $stmt->fetchOne();
}

// সব প্রোডাক্ট ইমেজ
function getProductImages($pdo, $product_id) {
    $stmt = $pdo->prepare("SELECT * FROM product_images WHERE product_id = ? ORDER BY display_order");
    $stmt->execute([$product_id]);
    return $stmt->fetchAll();
}

// কার্ট যোগ (Session based)
function addToCart($product_id, $quantity = 1) {
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }
    if (isset($_SESSION['cart'][$product_id])) {
        $_SESSION['cart'][$product_id] += $quantity;
    } else {
        $_SESSION['cart'][$product_id] = $quantity;
    }
    setFlash('success', '🛒 প্রোডাক্ট কার্টে যোগ হয়েছে!');
}

// কার্ট টোটাল
function getCartTotal($pdo) {
    if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) return 0;
    
    $ids = array_keys($_SESSION['cart']);
    $placeholders = str_repeat('?,', count($ids) - 1) . '?';
    $stmt = $pdo->prepare("SELECT id, IFNULL(discount_price, base_price) as price, stock FROM products WHERE id IN ($placeholders)");
    $stmt->execute($ids);
    $products = $stmt->fetchAll();
    
    $total = 0;
    foreach ($products as $product) {
        $qty = $_SESSION['cart'][$product['id']] ?? 0;
        if ($qty > $product['stock']) $qty = $product['stock'];
        $total += $product['price'] * $qty;
    }
    return $total;
}
?>