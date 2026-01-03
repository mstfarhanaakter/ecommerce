<!-- includes/sidebar.php -->
<nav id="sidebarMenu" class="sidebar bg-dark sidebar-dark position-fixed top-0 start-0 pt-5 shadow">
    <div class="position-sticky pt-4">
        <ul class="nav flex-column">
            <!-- Dashboard -->
            <li class="nav-item">
                <a class="nav-link <?= $current_page === 'dashboard' ? 'active' : '' ?>" href="dashboard.php">
                    <i class="bi bi-speedometer2 me-2"></i> Dashboard
                </a>
            </li>

            <!-- Products Dropdown -->
            <li class="nav-item">
                <a class="nav-link dropdown-toggle <?= str_contains($current_page ?? '', 'product') ? 'active' : '' ?>" 
                   href="#" data-bs-toggle="collapse" data-bs-target="#productsMenu">
                    <i class="bi bi-box-seam me-2"></i> Products
                </a>
                <ul class="collapse <?= str_contains($current_page ?? '', 'product') ? 'show' : '' ?>" id="productsMenu">
                    <li><a class="nav-link ps-5 <?= $current_page === 'products' ? 'active' : '' ?>" href="products.php">All Products</a></li>
                    <li><a class="nav-link ps-5" href="add_product.php">Add New</a></li>
                    <li><a class="nav-link ps-5" href="#">Categories</a></li>
                </ul>
            </li>

            <!-- Orders -->
            <li class="nav-item">
                <a class="nav-link <?= $current_page === 'orders' ? 'active' : '' ?>" href="orders.php">
                    <i class="bi bi-cart-check me-2"></i> Orders
                </a>
            </li>

            <!-- Users -->
            <li class="nav-item">
                <a class="nav-link <?= $current_page === 'users' ? 'active' : '' ?>" href="users.php">
                    <i class="bi bi-people me-2"></i> Users
                </a>
            </li>

            <!-- Reports -->
            <li class="nav-item">
                <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="collapse" data-bs-target="#reportsMenu">
                    <i class="bi bi-graph-up me-2"></i> Reports
                </a>
                <ul class="collapse" id="reportsMenu">
                    <li><a class="nav-link ps-5" href="#">Sales Report</a></li>
                    <li><a class="nav-link ps-5" href="#">Stock Report</a></li>
                </ul>
            </li>
        </ul>
    </div>
</nav>