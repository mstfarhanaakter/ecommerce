<?php
// includes/navbar.php
include_once 'config.php';

// Cart & Wishlist count from session
$cart_count = isset($_SESSION['cart']) ? array_sum($_SESSION['cart']) : 0;
$wishlist_count = isset($_SESSION['wishlist']) ? count($_SESSION['wishlist']) : 0;
?>

<nav class="navbar bg-gray-950 text-gray-200 shadow-lg sticky top-0 z-50 transition-all duration-500" id="main-navbar">
  <div class="navbar-start">
    <!-- Mobile Menu Button -->
    <div class="dropdown lg:hidden">
      <label tabindex="0" class="btn btn-ghost btn-circle hover:bg-gray-800 hover:text-white">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
        </svg>
      </label>
      <ul tabindex="0" class="menu menu-sm dropdown-content mt-3 z-[100] shadow-2xl bg-gray-950 text-gray-200 rounded-box w-64 p-4">
        <li><a href="<?= BASE_URL ?>" class="text-lg hover:text-yellow-400">Home</a></li>
        <li><a href="<?= BASE_URL ?>category.php?type=women" class="hover:text-yellow-400">Women</a></li>
        <li><a href="<?= BASE_URL ?>category.php?type=men" class="hover:text-yellow-400">Men</a></li>
        <li><a href="<?= BASE_URL ?>category.php?type=kids" class="hover:text-yellow-400">Kids</a></li>
        <li><a href="<?= BASE_URL ?>category.php?type=home-decor" class="hover:text-yellow-400">Home Decor</a></li>
        <li><a href="<?= BASE_URL ?>category.php?type=winter" class="hover:text-yellow-400 font-bold">Winter 25-26</a></li>

        <?php if (isset($_SESSION['user_id'])): ?>
          <li class="menu-title mt-6"><span class="text-yellow-400 text-lg">Account</span></li>
          <li><a href="<?= BASE_URL ?>users/profile.php" class="hover:text-yellow-400">Profile</a></li>
          <li><a href="<?= BASE_URL ?>users/orders.php" class="hover:text-yellow-400">My Orders</a></li>
          <li><a href="<?= BASE_URL ?>users/logout.php" class="hover:text-red-400">Logout</a></li>
        <?php endif; ?>
      </ul>
    </div>

    <!-- Logo -->
    <a href="<?= BASE_URL ?>" class="btn btn-ghost hover:bg-black normal-case text-2xl font-black tracking-wider logo-mobile" id="navbar-logo">
      <span class="text-yellow-400">DORA</span><span class="text-white">MART</span>
    </a>
  </div>

  <!-- Desktop Menu -->
  <div class="navbar-center hidden lg:flex">
    <ul class="menu menu-horizontal px-1 gap-8 text-base font-semibold uppercase tracking-wide">
      <li><a href="<?= BASE_URL ?>" class="hover:text-yellow-400 transition duration-300">Home</a></li>
      <li><a href="<?= BASE_URL ?>category.php?type=women" class="hover:text-yellow-400 transition duration-300">Women</a></li>
      <li><a href="<?= BASE_URL ?>category.php?type=men" class="hover:text-yellow-400 transition duration-300">Men</a></li>
      <li><a href="<?= BASE_URL ?>category.php?type=kids" class="hover:text-yellow-400 transition duration-300">Kids</a></li>
      <li><a href="<?= BASE_URL ?>category.php?type=home-decor" class="hover:text-yellow-400 transition duration-300">Home Decor</a></li>
      <li><a href="<?= BASE_URL ?>category.php?type=winter" class="text-yellow-400 hover:text-yellow-300 transition duration-300 font-bold">Winter 25-26</a></li>
    </ul>
  </div>

  <!-- Right Side Icons + User (Only show account dropdown when logged in) -->
  <div class="navbar-end flex items-center gap-4 lg:gap-6">
    <!-- Wishlist -->
    <a href="<?= BASE_URL ?>wishlist.php" class="btn btn-ghost btn-circle relative hover:bg-gray-800 hover:text-white transition duration-300">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
      </svg>
      <?php if ($wishlist_count > 0): ?>
        <span class="badge badge-sm bg-yellow-500 text-black border-none absolute -top-1 -right-1 font-bold"><?= $wishlist_count ?></span>
      <?php endif; ?>
    </a>

    <!-- Cart -->
    <a href="<?= BASE_URL ?>cart.php" class="btn btn-ghost btn-circle relative hover:bg-gray-800 hover:text-white transition duration-300">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z" />
      </svg>
      <?php if ($cart_count > 0): ?>
        <span class="badge badge-sm bg-yellow-500 text-black border-none absolute -top-1 -right-1 font-bold"><?= $cart_count ?></span>
      <?php endif; ?>
    </a>

    <!-- User Account Dropdown (only when logged in) -->
    <?php if (isset($_SESSION['user_id'])): ?>
      <div class="dropdown dropdown-end">
        <label tabindex="0" class="btn btn-ghost hover:text-white normal-case font-medium hover:bg-black transition duration-300 flex items-center gap-2">
          <?= htmlspecialchars($_SESSION['user_name'] ?? 'My Account') ?>
          <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
          </svg>
        </label>
        <ul tabindex="0" class="dropdown-content menu p-4 shadow-2xl bg-gray-950 text-gray-200 rounded-box w-56 z-[100]">
          <li><a href="<?= BASE_URL ?>users/profile.php" class="hover:text-yellow-400">Profile</a></li>
          <li><a href="<?= BASE_URL ?>users/addresses.php" class="hover:text-yellow-400">Delivery Addresse</a></li>
          <li><a href="<?= BASE_URL ?>users/orders.php" class="hover:text-yellow-400">My Orders</a></li>
          <li><a href="<?= BASE_URL ?>users/logout.php" class="hover:text-red-400">Logout</a></li>
        </ul>
      </div>
    <?php endif; ?>
  </div>
</nav>

<!-- Enhanced CSS & JS (same as before) -->
<style>
  /* Logo always visible on mobile */
  @media (max-width: 1023px) {
    #navbar-logo {
      opacity: 1 !important;
      transform: translateY(0) !important;
      pointer-events: auto !important;
    }
  }

  /* Smooth logo appear on scroll (desktop only) */
  #navbar-logo {
    opacity: 0;
    transform: translateY(-20px);
    transition: all 0.5s ease;
    pointer-events: none;
  }

  .navbar.scrolled #navbar-logo {
    opacity: 1;
    transform: translateY(0);
    pointer-events: auto;
  }

  .navbar.scrolled {
    background-color: rgba(17, 17, 17, 0.95) !important;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
  }
</style>

<script>
  window.addEventListener('scroll', function() {
    const navbar = document.getElementById('main-navbar');
    if (window.scrollY > 80) {
      navbar.classList.add('scrolled');
    } else {
      navbar.classList.remove('scrolled');
    }
  });
</script>