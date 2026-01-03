<?php
require 'includes/db.php';
require 'includes/functions.php';

// সেশন চেক (যদি db.php তে না থাকে)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Shop - Home</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm mb-4">
    <div class="container">
        <a class="navbar-brand fw-bold" href="index.php">My Shop</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav align-items-center">
                <?php if (is_logged_in()): ?>
                    <?php if (is_admin()): ?>
                        <li class="nav-item">
                            <a href="admin/" class="btn btn-warning btn-sm me-2">Admin Panel</a>
                        </li>
                    <?php endif; ?>

                    <!-- My Profile Button (নতুন যোগ করা) -->
                    <li class="nav-item">
                        <a href="user-profile.php" class="btn btn-outline-info btn-sm me-2">
                            <i class="fas fa-user me-1"></i> My Profile
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="cart.php" class="btn btn-primary btn-sm me-2 position-relative">
                            Cart
                            <?php
                            $cart_count = 0;
                            if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
                                $cart_count = array_sum($_SESSION['cart']);
                            }
                            if ($cart_count > 0):
                            ?>
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                    <?= $cart_count ?>
                                </span>
                            <?php endif; ?>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="my_orders.php" class="btn btn-outline-info btn-sm me-2">My Orders</a>
                    </li>

                    <li class="nav-item">
                        <a href="logout.php" class="btn btn-outline-danger btn-sm">Logout</a>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a href="login.php" class="btn btn-outline-primary btn-sm me-2">Login</a>
                    </li>
                    <li class="nav-item">
                        <a href="register.php" class="btn btn-outline-success btn-sm">Register</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<!-- Products Section -->
<div class="container">
    <h2 class="mb-4 text-center">All Products</h2>

    <?php
    $stmt = $pdo->query("
        SELECT p.*, c.name as category_name 
        FROM products p 
        LEFT JOIN categories c ON p.category_id = c.id 
        ORDER BY p.id DESC
    ");

    if ($stmt->rowCount() === 0):
    ?>
        <div class="alert alert-info text-center">
            কোনো প্রোডাক্ট পাওয়া যায়নি।
        </div>
    <?php else: ?>
        <div class="row row-cols-1 row-cols-md-3 g-4">
            <?php while ($product = $stmt->fetch()): ?>
                <div class="col">
                    <div class="card h-100 shadow-sm product-card">
                        <?php if (!empty($product['image'])): ?>
                            <img src="uploads/<?= htmlspecialchars($product['image']) ?>" 
                                 class="card-img-top" 
                                 alt="<?= htmlspecialchars($product['name']) ?>" 
                                 style="height: 220px; object-fit: cover;">
                        <?php else: ?>
                            <div class="card-img-top bg-secondary text-white d-flex align-items-center justify-content-center" style="height: 220px;">
                                No Image
                            </div>
                        <?php endif; ?>

                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title"><?= htmlspecialchars($product['name']) ?></h5>
                            <p class="card-text text-muted small">
                                Category: <?= htmlspecialchars($product['category_name'] ?? 'Uncategorized') ?>
                            </p>
                            <p class="card-text fw-bold text-success fs-5">
                                ৳<?= number_format($product['price'], 2) ?>
                            </p>
                            <p class="card-text">
                                Stock: 
                                <?php if ($product['stock'] > 0): ?>
                                    <span class="badge bg-success"><?= $product['stock'] ?></span>
                                <?php else: ?>
                                    <span class="badge bg-danger">Out of Stock</span>
                                <?php endif; ?>
                            </p>

                            <div class="mt-auto d-flex gap-2">
                                <a href="product.php?id=<?= $product['id'] ?>" 
                                   class="btn btn-outline-info btn-sm flex-grow-1">View Details</a>
                                
                                <?php if ($product['stock'] > 0): ?>
                                    <a href="add_to_cart.php?id=<?= $product['id'] ?>" 
                                       class="btn btn-success btn-sm">Add to Cart</a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    <?php endif; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- Optional: Hover effect for cards -->
<style>
    .product-card:hover {
        transform: translateY(-5px);
        transition: all 0.3s ease;
        box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
    }
</style>

</body>
</html>