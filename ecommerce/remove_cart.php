<?php
// remove_cart.php
require 'includes/db.php';
require 'includes/functions.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id > 0) {
    unset($_SESSION['cart'][$id]);
}

redirect('cart.php');