<?php
include_once 'config.php';  // adjust path

$user_id = $_SESSION['user_id'] ?? 0; // Get logged-in user ID
$wishlist_count = 0;
$cart_count = 0;

if ($user_id) {
    // Wishlist count
    $res = $con->query("SELECT COUNT(*) as cnt FROM wishlist WHERE user_id=$user_id");
    $wishlist_count = $res->fetch_assoc()['cnt'];

    // Cart count (sum of quantities)
    $res = $con->query("SELECT SUM(quantity) as cnt FROM cart WHERE user_id=$user_id");
    $cart_count = $res->fetch_assoc()['cnt'] ?? 0;
}


?>

<nav class="navbar bg-neutral text-neutral-content shadow-sm px-4 lg:px-8">
  <div class="navbar-start flex items-center gap-2">
    <!-- Mobile Hamburger -->
    <div class="dropdown lg:hidden">
      <label tabindex="0" class="btn btn-ghost btn-circle">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
        </svg>
      </label>
      <ul tabindex="0" class="menu menu-compact dropdown-content mt-3 p-2 shadow bg-neutral rounded-box w-52">
        <li><a href="<?= BASE_URL ?>index1.php">Home</a></li>
        <li><a href="<?= BASE_URL ?>index1.php">Women</a></li>
        <li><a href="<?= BASE_URL ?>index1.php">Men</a></li>
        <li><a href="<?= BASE_URL ?>index1.php">Kids</a></li>
        <li><a href="<?= BASE_URL ?>index1.php">Home Décor</a></li>
        <li><a href="<?= BASE_URL ?>index1.php">Jewelery</a></li>
        <li><a href="<?= BASE_URL ?>index1.php">Skin & Hair</a></li>
        <li><a href="<?= BASE_URL ?>index1.php">Gifts & Crafts</a></li>
        <li><a href="<?= BASE_URL ?>index1.php">Winter 25-26</a></li>
        <?php if (isset($_SESSION['user_id'])): ?>
          <li><a href="<?= BASE_URL ?>profile.php">Profile</a></li>
          <li><a href="<?= BASE_URL ?>orders.php">Orders</a></li>
          <li><a href="<?= BASE_URL ?>users/logout.php">Logout</a></li>
        <?php endif; ?>
      </ul>
    </div>

    <!-- Mobile Logo -->
    <div class="lg:hidden">
      <a href="<?= BASE_URL ?>index1.php" class="inline-flex items-center">
        <span class="text-lg font-bold uppercase bg-gray-900 text-yellow-400 px-2">Dora</span>
        <span class="text-lg font-bold uppercase bg-yellow-400 text-gray-900 px-2 -ml-1">Mart</span>
      </a>
    </div>

    <!-- Desktop Logo -->
    <!-- <a href="<?= BASE_URL ?>" class="text-xl font-bold ml-2 hidden lg:block">
      DoraMart
    </a> -->
  </div>

  <!-- Desktop Menu -->
  <div class="navbar-center hidden lg:flex">
    <ul class="menu menu-horizontal px-1 text-base">
      <li><a href="<?= BASE_URL ?>index1.php">Home</a></li>
      <li><a href="<?= BASE_URL ?>index1.php">Women</a></li>
      <li><a href="<?= BASE_URL ?>index1.php">Men</a></li>
      <li><a href="<?= BASE_URL ?>index1.php">Kids</a></li>
      <li><a href="<?= BASE_URL ?>index1.php">Home Décor</a></li>
      <li><a href="<?= BASE_URL ?>index1.php">Jewelery</a></li>
      <li><a href="<?= BASE_URL ?>index1.php">Skin & Hair</a></li>
      <li><a href="<?= BASE_URL ?>index1.php">Gifts & Crafts</a></li>
      <li><a href="<?= BASE_URL ?>index1.php">Winter 25-26</a></li>
    </ul>
  </div>

  <!-- Right Icons + Account -->
  <div class="navbar-end flex items-center gap-4">
    <!-- Wishlist -->
<a href="<?= BASE_URL ?>pages/wishlist.php" class="relative">
  <i class="fas fa-heart text-yellow-400 text-lg"></i>
  <span id="wishlist-count"
        class="absolute -top-2 -right-2 bg-white text-gray-900 text-xs rounded-full px-1">
         <?= $wishlist_count ?>
  </span>
</a>

<!-- Cart -->
<a href="<?= BASE_URL ?>pages/cart.php" class="relative ml-4">
  <i class="fas fa-shopping-cart text-yellow-400 text-lg"></i>
  <span id="cart-count"
        class="absolute -top-2 -right-2 bg-white text-gray-900 text-xs rounded-full px-1">
       <?= $cart_count ?>
  </span>
</a>

    <!-- Desktop Account Section (only if logged in) -->
    <?php if (isset($_SESSION['user_id'])): ?>
      <div class="hidden lg:flex items-center space-x-2">
        <div class="dropdown dropdown-end">
          <label tabindex="0" class="btn btn-sm btn-outline">
            My Account
            <svg class="ml-1 w-4 h-4 inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
            </svg>
          </label>
          <ul tabindex="0" class="dropdown-content menu p-2 shadow bg-neutral rounded-box w-52 mt-1">
            <li><a href="<?= BASE_URL ?>users/profile.php">Profile</a></li>
            <li><a href="<?= BASE_URL ?>orders.php">Orders</a></li>
            <li><a href="<?= BASE_URL ?>users/logout.php">Logout</a></li>
          </ul>
        </div>
      </div>
    <?php endif; ?>
  </div>
</nav>
