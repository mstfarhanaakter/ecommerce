<?php
require 'includes/db.php';
require 'includes/functions.php';

if (!is_logged_in()) {
    redirect('login.php');
}

$items = get_cart_items();

// এরর/সাকসেস মেসেজ দেখানোর জন্য
$success_msg = $_SESSION['success'] ?? null;
$error_msg   = $_SESSION['error'] ?? null;
unset($_SESSION['success'], $_SESSION['error']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Cart - My Shop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .quantity-control input[type="number"] {
            max-width: 70px;
            text-align: center;
        }
        .quantity-control button {
            width: 38px;
        }
    </style>
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm mb-4">
    <div class="container">
        <a class="navbar-brand fw-bold" href="index.php">My Shop</a>
        <div class="ms-auto">
            <a href="index.php" class="btn btn-outline-primary me-2">Continue Shopping</a>
            <a href="my_orders.php" class="btn btn-outline-info">My Orders</a>
        </div>
    </div>
</nav>

<div class="container" style="max-width: 1100px;">
    <h2 class="mb-4 text-center">Your Shopping Cart</h2>

    <?php if ($success_msg): ?>
        <div class="alert alert-success alert-dismissible fade show">
            <?= htmlspecialchars($success_msg) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if ($error_msg): ?>
        <div class="alert alert-danger alert-dismissible fade show">
            <?= htmlspecialchars($error_msg) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if (empty($items)): ?>
        <div class="alert alert-info text-center py-5">
            <h4>Your cart is empty</h4>
            <p>Start adding some products!</p>
            <a href="index.php" class="btn btn-primary btn-lg mt-3">Browse Products</a>
        </div>
    <?php else: ?>
        <div class="table-responsive">
            <table class="table table-hover table-bordered align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>Image</th>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Subtotal</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($items as $item): ?>
                    <tr>
                        <td width="90">
                            <?php if (!empty($item['image'])): ?>
                                <img src="uploads/<?= htmlspecialchars($item['image']) ?>" 
                                     class="img-thumbnail" width="80" alt="">
                            <?php else: ?>
                                No Image
                            <?php endif; ?>
                        </td>
                        <td><?= htmlspecialchars($item['name']) ?></td>
                        <td>৳<?= number_format($item['price'], 2) ?></td>

                        <!-- Quantity Controls -->
                        <td width="280">
                            <form action="update_cart.php" method="POST" class="quantity-control d-flex align-items-center gap-1">
                                <input type="hidden" name="product_id" value="<?= $item['id'] ?>">

                                <button type="submit" name="action" value="decrease" 
                                        class="btn btn-outline-secondary btn-sm <?= $item['quantity'] <= 1 ? 'disabled' : '' ?>">
                                    -
                                </button>

                                <input type="number" name="quantity" value="<?= $item['quantity'] ?>" 
                                       class="form-control form-control-sm text-center" min="0" max="999">

                                <button type="submit" name="action" value="increase" 
                                        class="btn btn-outline-secondary btn-sm">
                                    +
                                </button>

                                <!-- <button type="submit" name="action" value="update" 
                                        class="btn btn-outline-primary btn-sm px-3">
                                    Update
                                </button> -->
                            </form>
                        </td>

                        <td><strong>৳<?= number_format($item['subtotal'], 2) ?></strong></td>

                        <td>
                            <a href="remove_cart.php?id=<?= $item['id'] ?>" 
                               class="btn btn-danger btn-sm"
                               onclick="return confirm('Remove this item?')">
                                Remove
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>

                    <!-- Grand Total -->
                    <tr class="table-active fw-bold">
                        <td colspan="3" class="text-end">Grand Total</td>
                        <td colspan="2">
                            ৳<?= number_format(get_cart_total(), 2) ?>
                        </td>
                        <td>
                            <a href="checkout.php" class="btn btn-success">
                                Proceed to Checkout →
                            </a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>