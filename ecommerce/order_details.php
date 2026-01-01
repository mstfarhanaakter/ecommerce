<?php
require 'includes/db.php';
require 'includes/functions.php';

if (!is_logged_in()) {
    redirect('login.php');
}

$order_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$user_id = $_SESSION['user_id'];

if ($order_id <= 0) {
    redirect('my_orders.php');
}

// অর্ডার চেক (শুধু নিজের অর্ডার দেখতে পারবে)
$stmt = $pdo->prepare("
    SELECT * FROM orders 
    WHERE id = ? AND user_id = ?
");
$stmt->execute([$order_id, $user_id]);
$order = $stmt->fetch();

if (!$order) {
    $_SESSION['error'] = "Invalid order!";
    redirect('my_orders.php');
}

// অর্ডারের আইটেমগুলো
$stmt = $pdo->prepare("
    SELECT oi.*, p.name, p.image 
    FROM order_items oi 
    JOIN products p ON oi.product_id = p.id 
    WHERE oi.order_id = ?
");
$stmt->execute([$order_id]);
$items = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order #<?= $order_id ?> Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-5">
    <h2>Order #<?= $order['id'] ?></h2>
    <p><strong>Date:</strong> <?= date('d M Y, h:i A', strtotime($order['created_at'])) ?></p>
    <p><strong>Status:</strong> 
        <span class="badge bg-<?= $order['status'] === 'delivered' ? 'success' : 'warning' ?>">
            <?= ucfirst($order['status']) ?>
        </span>
    </p>
    <p><strong>Total:</strong> ৳<?= number_format($order['total'], 2) ?></p>
    <p><strong>Payment:</strong> <?= ucfirst(str_replace('_', ' ', $order['payment_method'])) ?></p>
    <p><strong>Address:</strong> <?= htmlspecialchars($order['shipping_address']) ?></p>

    <h4 class="mt-4">Items</h4>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Image</th>
                <th>Product</th>
                <th>Price</th>
                <th>Qty</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($items as $item): ?>
            <tr>
                <td>
                    <?php if ($item['image']): ?>
                        <img src="uploads/<?= htmlspecialchars($item['image']) ?>" width="60" alt="">
                    <?php else: ?>
                        No Image
                    <?php endif; ?>
                </td>
                <td><?= htmlspecialchars($item['name']) ?></td>
                <td>৳<?= number_format($item['price_at_purchase'], 2) ?></td>
                <td><?= $item['quantity'] ?></td>
                <td><strong>৳<?= number_format($item['price_at_purchase'] * $item['quantity'], 2) ?></strong></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <a href="my_orders.php" class="btn btn-secondary mt-3">Back to Orders</a>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>