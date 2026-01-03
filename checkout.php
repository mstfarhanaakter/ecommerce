<?php
require 'includes/db.php';
require 'includes/functions.php';

if (!is_logged_in()) {
    redirect('login.php');
}

$items = get_cart_items();

if (empty($items)) {
    $_SESSION['error'] = "Your cart is empty!";
    redirect('cart.php');
}

// কুপন কোড প্রসেসিং + টোটাল ক্যালকুলেট
$grand_total = get_cart_total();
$discount = 0;
$discount_message = '';
$coupon_code = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['apply_coupon'])) {
    $coupon_code = trim($_POST['coupon_code'] ?? '');

    if (!empty($coupon_code)) {
        $stmt = $pdo->prepare("
            SELECT discount_type, discount_value, min_order_amount, max_discount, expiry_date 
            FROM coupons 
            WHERE code = ? AND status = 'active' AND expiry_date >= CURDATE()
        ");
        $stmt->execute([$coupon_code]);
        $coupon = $stmt->fetch();

        if ($coupon) {
            if ($grand_total >= ($coupon['min_order_amount'] ?? 0)) {
                if ($coupon['discount_type'] === 'percentage') {
                    $discount = ($grand_total * $coupon['discount_value']) / 100;
                    if ($coupon['max_discount'] && $discount > $coupon['max_discount']) {
                        $discount = $coupon['max_discount'];
                    }
                } else { // fixed
                    $discount = $coupon['discount_value'];
                }
                $discount_message = "Coupon applied! Discount: ৳" . number_format($discount, 2);
            } else {
                $discount_message = "Order amount too low for this coupon.";
            }
        } else {
            $discount_message = "Invalid or expired coupon code.";
        }
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Normal order placement
    try {
        $pdo->beginTransaction();

        $user_id = $_SESSION['user_id'];
        $shipping_address = trim($_POST['shipping_address'] ?? '');
        $payment_method = $_POST['payment_method'] ?? 'cash_on_delivery';

        if (strlen($shipping_address) < 10) {
            throw new Exception("Please enter a valid full shipping address");
        }

        // Final total after discount
        $final_total = $grand_total - $discount;

        $stmt = $pdo->prepare("
            INSERT INTO orders 
            (user_id, total, discount, final_total, shipping_address, payment_method, status, coupon_code, created_at) 
            VALUES (?, ?, ?, ?, ?, ?, 'pending', ?, NOW())
        ");
        $stmt->execute([$user_id, $grand_total, $discount, $final_total, $shipping_address, $payment_method, $coupon_code]);
        $order_id = $pdo->lastInsertId();

        foreach ($items as $item) {
            $product_id = $item['id'];
            $quantity = $item['quantity'];
            $price = $item['price'];

            $stmt = $pdo->prepare("SELECT stock FROM products WHERE id = ? FOR UPDATE");
            $stmt->execute([$product_id]);
            $stock = $stmt->fetchColumn();

            if ($stock < $quantity) {
                throw new Exception("Not enough stock for " . htmlspecialchars($item['name']));
            }

            $stmt = $pdo->prepare("
                INSERT INTO order_items 
                (order_id, product_id, quantity, price_at_purchase) 
                VALUES (?, ?, ?, ?)
            ");
            $stmt->execute([$order_id, $product_id, $quantity, $price]);

            $stmt = $pdo->prepare("UPDATE products SET stock = stock - ? WHERE id = ?");
            $stmt->execute([$quantity, $product_id]);
        }

        clear_cart();
        $pdo->commit();

        $_SESSION['success_order_id'] = $order_id;
        redirect('invoice.php?order_id=' . $order_id);

    } catch (Exception $e) {
        if ($pdo->inTransaction()) {
            $pdo->rollBack();
        }
        $_SESSION['error'] = "Order failed: " . $e->getMessage();
        redirect('checkout.php');
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout • My Shop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold text-primary" href="index.php">My Shop</a>
        <div class="ms-auto">
            <a href="cart.php" class="btn btn-outline-secondary">← Back to Cart</a>
        </div>
    </div>
</nav>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-lg border-0 rounded-4 overflow-hidden">
                <div class="card-header bg-gradient-primary text-white py-4">
                    <h3 class="mb-0 text-center">Secure Checkout</h3>
                </div>

                <div class="card-body p-4 p-md-5">
                    <?php if (isset($_SESSION['error'])): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            <?= htmlspecialchars($_SESSION['error']) ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                        <?php unset($_SESSION['error']); ?>
                    <?php endif; ?>

                    <div class="row g-5">
                        <!-- Order Summary -->
                        <div class="col-lg-6">
                            <h4 class="mb-4 border-bottom pb-2">Order Summary</h4>
                            <div class="list-group list-group-flush mb-4">
                                <?php foreach ($items as $item): ?>
                                    <div class="list-group-item px-0 py-3 border-bottom">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <h6 class="mb-1"><?= htmlspecialchars($item['name']) ?></h6>
                                                <small class="text-muted">Qty: <?= $item['quantity'] ?></small>
                                            </div>
                                            <strong>৳<?= number_format($item['subtotal'], 2) ?></strong>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>

                            <div class="d-flex justify-content-between mb-2">
                                <span>Subtotal</span>
                                <span>৳<?= number_format($grand_total, 2) ?></span>
                            </div>

                            <?php if ($discount > 0): ?>
                                <div class="d-flex justify-content-between text-success mb-2">
                                    <span>Discount (<?= htmlspecialchars($coupon_code) ?>)</span>
                                    <span>-৳<?= number_format($discount, 2) ?></span>
                                </div>
                            <?php endif; ?>

                            <hr>
                            <div class="d-flex justify-content-between fw-bold fs-4">
                                <span>Total</span>
                                <span>৳<?= number_format($grand_total - $discount, 2) ?></span>
                            </div>
                        </div>

                        <!-- Form + Coupon -->
                        <div class="col-lg-6">
                            <h4 class="mb-4 border-bottom pb-2">Payment & Delivery</h4>

                            <!-- Coupon Section -->
                            <form method="POST" class="mb-4">
                                <div class="input-group">
                                    <input type="text" name="coupon_code" class="form-control" 
                                           placeholder="Enter coupon code" value="<?= htmlspecialchars($coupon_code) ?>">
                                    <button type="submit" name="apply_coupon" class="btn btn-outline-primary">
                                        Apply
                                    </button>
                                </div>
                                <?php if ($discount_message): ?>
                                    <small class="form-text <?= strpos($discount_message, 'applied') !== false ? 'text-success' : 'text-danger' ?>">
                                        <?= $discount_message ?>
                                    </small>
                                <?php endif; ?>
                            </form>

                            <!-- Checkout Form -->
                            <form method="POST" class="needs-validation" novalidate>
                                <input type="hidden" name="coupon_code" value="<?= htmlspecialchars($coupon_code) ?>">

                                <div class="mb-4">
                                    <label class="form-label fw-bold">Full Delivery Address</label>
                                    <textarea name="shipping_address" class="form-control" rows="4" 
                                              placeholder="House no, Road, Area, City - Postal Code, Landmark" required></textarea>
                                    <div class="invalid-feedback">Please provide complete address</div>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label fw-bold">Payment Method</label>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="radio" name="payment_method" id="cod" value="cash_on_delivery" checked>
                                        <label class="form-check-label" for="cod">
                                            <i class="fas fa-money-bill-wave me-2"></i>Cash on Delivery
                                        </label>
                                    </div>
                                    <!-- Add more payment methods later -->
                                </div>

                                <button type="submit" class="btn btn-success btn-lg w-100 rounded-pill">
                                    <i class="fas fa-check-circle me-2"></i>
                                    Confirm & Place Order • ৳<?= number_format($grand_total - $discount, 2) ?>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Bootstrap validation
    (function () {
        'use strict'
        var forms = document.querySelectorAll('.needs-validation')
        Array.prototype.slice.call(forms).forEach(function (form) {
            form.addEventListener('submit', function (event) {
                if (!form.checkValidity()) {
                    event.preventDefault()
                    event.stopPropagation()
                }
                form.classList.add('was-validated')
            }, false)
        })
    })()
</script>
</body>
</html>