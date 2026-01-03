<!-- partial:partials/_sidebar.html -->
<nav class="sidebar sidebar-offcanvas" id="sidebar">
  <div class="user-profile">
    <div class="user-image">
      <img src="<?= ADMIN_URL; ?>/assets/images/faces/face6.jpg">
    </div>
    <div class="user-name">
      Farhana Shetu
    </div>
    <div class="user-designation">
      Admin
    </div>
  </div>

  <ul class="nav">

    <!-- Dashboard -->
    <li class="nav-item">
      <a class="nav-link" href="index.html">
        <i class="icon-grid menu-icon"></i>
        <span class="menu-title">Dashboard</span>
      </a>
    </li>

    <!-- Products -->
    <li class="nav-item">
      <a class="nav-link" data-toggle="collapse" href="#products" aria-expanded="false">
        <i class="icon-bag menu-icon"></i>
        <span class="menu-title">Products</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse" id="products">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item"><a class="nav-link" href="<?= ADMIN_URL; ?>/pages/products/all-products.php">Manage Product</a></li>
          <li class="nav-item"><a class="nav-link" href="<?= ADMIN_URL; ?>/pages/products/add-product.php">Add Product</a></li>
          <li class="nav-item"><a class="nav-link" href="<?= ADMIN_URL; ?>/pages/categories/categories.php">Categories</a></li>
          <li class="nav-item"><a class="nav-link" href="pages/products/brands.html">Brands</a></li>
          <li class="nav-item"><a class="nav-link" href="pages/products/attributes.html">Attributes</a></li>
          <li class="nav-item"><a class="nav-link" href="pages/products/reviews.html">Reviews</a></li>
        </ul>
      </div>
    </li>

    <!-- Orders -->
    <li class="nav-item">
      <a class="nav-link" data-toggle="collapse" href="#orders" aria-expanded="false">
        <i class="icon-disc menu-icon"></i>
        <span class="menu-title">Orders</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse" id="orders">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item"><a class="nav-link" href="<?= ADMIN_URL ; ?>/pages/orders/orders.php">All Orders</a></li>
          <li class="nav-item"><a class="nav-link" href="pages/orders/pending.html">Pending Orders</a></li>
          <li class="nav-item"><a class="nav-link" href="pages/orders/processing.html">Processing</a></li>
          <li class="nav-item"><a class="nav-link" href="pages/orders/completed.html">Completed</a></li>
          <li class="nav-item"><a class="nav-link" href="pages/orders/cancelled.html">Cancelled/Returned</a></li>
        </ul>
      </div>
    </li>

    <!-- Customers -->
    <li class="nav-item">
      <a class="nav-link" data-toggle="collapse" href="#customers" aria-expanded="false">
        <i class="icon-head menu-icon"></i>
        <span class="menu-title">Customers</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse" id="customers">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item"><a class="nav-link" href="<?= ADMIN_URL?>/pages/customers/customers.php">Manage Customer</a></li>
          <li class="nav-item"><a class="nav-link" href="pages/customers/reviews.html">Reviews</a></li>
        </ul>
      </div>
    </li>

    <!-- Payments -->
    <li class="nav-item">
      <a class="nav-link" data-toggle="collapse" href="#payments" aria-expanded="false">
        <i class="icon-paper menu-icon"></i>
        <span class="menu-title">Payments</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse" id="payments">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item"><a class="nav-link" href="pages/payments/methods.html">Payment Methods</a></li>
          <li class="nav-item"><a class="nav-link" href="pages/payments/transactions.html">Transactions</a></li>
          <li class="nav-item"><a class="nav-link" href="pages/payments/refunds.html">Refunds</a></li>
        </ul>
      </div>
    </li>

    <!-- Reports -->
    <li class="nav-item">
      <a class="nav-link" data-toggle="collapse" href="#reports" aria-expanded="false">
        <i class="icon-pie-graph menu-icon"></i>
        <span class="menu-title">Reports</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse" id="reports">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item"><a class="nav-link" href="pages/reports/sales.html">Sales Report</a></li>
          <li class="nav-item"><a class="nav-link" href="pages/reports/orders.html">Order Report</a></li>
          <li class="nav-item"><a class="nav-link" href="pages/reports/customers.html">Customer Report</a></li>
          <li class="nav-item"><a class="nav-link" href="pages/reports/products.html">Product Report</a></li>
        </ul>
      </div>
    </li>

    <!-- Marketing -->
    <li class="nav-item">
      <a class="nav-link" data-toggle="collapse" href="#marketing" aria-expanded="false">
        <i class="icon-command menu-icon"></i>
        <span class="menu-title">Marketing</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse" id="marketing">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item"><a class="nav-link" href="pages/marketing/coupons.html">Coupons</a></li>
          <li class="nav-item"><a class="nav-link" href="pages/marketing/discounts.html">Discounts</a></li>
          <li class="nav-item"><a class="nav-link" href="pages/marketing/banners.html">Banners</a></li>
        </ul>
      </div>
    </li>

    <!-- Settings -->
    <li class="nav-item">
      <a class="nav-link" data-toggle="collapse" href="#settings" aria-expanded="false">
        <i class="icon-cog menu-icon"></i>
        <span class="menu-title">Settings</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse" id="settings">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item"><a class="nav-link" href="pages/settings/store.html">Store Settings</a></li>
          <li class="nav-item"><a class="nav-link" href="pages/settings/shipping.html">Shipping</a></li>
          <li class="nav-item"><a class="nav-link" href="pages/settings/tax.html">Tax</a></li>
          <li class="nav-item"><a class="nav-link" href="pages/settings/payment.html">Payment Gateway</a></li>
        </ul>
      </div>
    </li>

    <!-- Admin Users -->
    <li class="nav-item">
      <a class="nav-link" data-toggle="collapse" href="#adminUsers" aria-expanded="false">
        <i class="icon-play menu-icon"></i>
        <span class="menu-title">Admin Users</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse" id="adminUsers">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item"><a class="nav-link" href="pages/users/list.html">User List</a></li>
          <li class="nav-item"><a class="nav-link" href="pages/users/roles.html">Roles</a></li>
          <li class="nav-item"><a class="nav-link" href="pages/users/logs.html">Activity Logs</a></li>
        </ul>
      </div>
    </li>

  </ul>
</nav>
<!-- partial -->
