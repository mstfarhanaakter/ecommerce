<?php
require 'includes/db.php';
require 'includes/functions.php';

$product_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$quantity = isset($_GET['qty']) ? (int)$_GET['qty'] : 1;

if ($product_id > 0) {
    if (add_to_cart($product_id, $quantity)) {
        header("Location: cart.php?added=success");
    } else {
        header("Location: index.php?error=stock");
    }
} else {
    header("Location: index.php?error=invalid");
}
exit;