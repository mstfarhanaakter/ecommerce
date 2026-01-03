<?php
require 'includes/db.php';
require 'includes/functions.php';

if (!is_logged_in()) {
    redirect('login.php');
}

$user_id = $_SESSION['user_id'];

// ইউজারের সব অর্ডার নেয়া
$stmt = $pdo->prepare("
    SELECT id, total, shipping_address, payment_method, status, created_at 
    FROM orders 
    WHERE user_id = ? 
    ORDER BY created_at DESC
");
$stmt->execute([$user_id]);
$orders = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Orders - My Shop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold" href="index.php">My Shop</a>
        <div class="ms-auto">
            <a href="cart.php" class="btn btn-outline-primary">Cart</a>
            <a href="logout.php" class="btn btn-outline-danger">Logout</a>
        </div>
    </div>
</nav>

<div class="container py-5">
    <h2 class="mb-4 text-center">My Orders</h2>

    <?php if (empty($orders)): ?>
        <div class="alert alert-info text-center">
            <p>Start shopping and get your favorite items delivered!</p>
            <a href="index.php" class="btn btn-primary">Browse Products</a>
        </div>
    <?php else: ?>
        <div class="table-responsive">
            <table class="table table-hover table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>Order ID</th>
                        <th>Date</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Payment</th>
                        <th>Address</th>
                        <th>Details</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orders as $order): ?>
                    <tr>
                        <td>#<?= $order['id'] ?></td>
                        <td><?= date('d M Y, h:i A', strtotime($order['created_at'])) ?></td>
                        <td><strong>৳<?= number_format($order['total'], 2) ?></strong></td>
                        <td>
                            <?php
                            $status = $order['status'];
                            $badge = match($status) {
                                'pending' => 'bg-warning',
                                'processing' => 'bg-info',
                                'shipped' => 'bg-primary',
                                'delivered' => 'bg-success',
                                'cancelled' => 'bg-danger',
                                default => 'bg-secondary'
                            };
                            ?>
                            <span class="badge <?= $badge ?>"><?= ucfirst($status) ?></span>
                        </td>
                        <td><?= ucfirst(str_replace('_', ' ', $order['payment_method'])) ?></td>
                        <td><?= htmlspecialchars(substr($order['shipping_address'], 0, 60)) ?>...</td>
                        <td>
                            <a href="order_details.php?id=<?= $order['id'] ?>" class="btn btn-sm btn-info">View</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>