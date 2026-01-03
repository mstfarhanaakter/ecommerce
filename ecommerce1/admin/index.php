<?php
// admin/index.php (or dashboard.php)

session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: ../login.php");
    exit();
}

$page_title = "Dashboard";
$current_page = "dashboard";

require 'includes/header.php';
require 'includes/sidebar.php';
require '../includes/db.php';

// ড্যাশবোর্ডের জন্য কিছু স্যাম্পল স্ট্যাটিসটিক্স (পরে তোমার ডেটা দিয়ে রিপ্লেস করবে)
$product_count = $pdo->query("SELECT COUNT(*) FROM products")->fetchColumn();
$order_count   = $pdo->query("SELECT COUNT(*) FROM orders")->fetchColumn();
$user_count    = $pdo->query("SELECT COUNT(*) FROM users")->fetchColumn();
$pending_orders = $pdo->query("SELECT COUNT(*) FROM orders WHERE status = 'pending'")->fetchColumn();
?>

<main class="container-fluid py-4" style="margin-left: var(--sidebar-width);">
    
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
        <h2 class="mb-0">Admin Dashboard</h2>
        <div>
            <button class="btn btn-outline-secondary btn-sm" id="refreshStats">
                <i class="bi bi-arrow-repeat"></i> Refresh
            </button>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row g-4 mb-5">
        <div class="col-xl-3 col-md-6">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-1">Total Products</h6>
                            <h3 class="mb-0"><?= number_format($product_count) ?></h3>
                        </div>
                        <div class="bg-primary bg-opacity-10 p-3 rounded">
                            <i class="bi bi-box-seam fs-3 text-primary"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-1">Total Orders</h6>
                            <h3 class="mb-0"><?= number_format($order_count) ?></h3>
                        </div>
                        <div class="bg-success bg-opacity-10 p-3 rounded">
                            <i class="bi bi-cart-check fs-3 text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-1">Registered Users</h6>
                            <h3 class="mb-0"><?= number_format($user_count) ?></h3>
                        </div>
                        <div class="bg-info bg-opacity-10 p-3 rounded">
                            <i class="bi bi-people fs-3 text-info"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-1">Pending Orders</h6>
                            <h3 class="mb-0 text-danger"><?= number_format($pending_orders) ?></h3>
                        </div>
                        <div class="bg-danger bg-opacity-10 p-3 rounded">
                            <i class="bi bi-hourglass-split fs-3 text-danger"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-white">
            <h5 class="mb-0">Quick Actions</h5>
        </div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-4 col-sm-6">
                    <a href="products.php" class="btn btn-outline-primary w-100 py-4">
                        <i class="bi bi-box-seam fs-4 d-block mb-2"></i>
                        Manage Products
                    </a>
                </div>
                <div class="col-md-4 col-sm-6">
                    <a href="orders.php" class="btn btn-outline-success w-100 py-4">
                        <i class="bi bi-cart-check fs-4 d-block mb-2"></i>
                        View Orders
                    </a>
                </div>
                <div class="col-md-4 col-sm-6">
                    <a href="add_product.php" class="btn btn-outline-info w-100 py-4">
                        <i class="bi bi-plus-circle fs-4 d-block mb-2"></i>
                        Add New Product
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- আরো কন্টেন্ট যোগ করতে পারো যেমন: Recent Orders Table, Charts ইত্যাদি -->

</main>

<?php require 'includes/footer.php'; ?>