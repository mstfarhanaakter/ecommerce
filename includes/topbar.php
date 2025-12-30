<?php
include_once 'config.php';  // path adjust করো
?>

<!-- Topbar Start -->
<div id="topbar" class="hidden lg:block bg-white py-2 shadow-sm">
  <div class="max-w-7xl mx-auto px-4">
    <div class="grid grid-cols-3 items-center">

      <!-- Left: Links -->
      <div class="flex gap-4 text-gray-600">
        <a href="<?= BASE_URL ?>pages/about.php" class="hover:text-yellow-500">About</a>
        <a href="<?= BASE_URL ?>pages/contact.php"   class="hover:text-yellow-500">Contact</a>
        <a href="<?= BASE_URL ?>pages/help.php" class="hover:text-yellow-500">Help</a>
        <a href="<?= BASE_URL ?>pages/faq.php" class="hover:text-yellow-500">FAQs</a>
      </div>

      <!-- Center: Logo -->
      <div class="text-center">
        <a href="#" class="inline-flex items-center">
          <span class="text-lg font-bold uppercase bg-gray-900 text-yellow-400 px-2">
            Dora
          </span>
          <span class="text-lg font-bold uppercase bg-yellow-400 text-gray-900 px-2 -ml-1">
            Mart
          </span>
        </a>
      </div>

      <!-- Right: Buttons -->
      <div class="flex justify-end gap-2">
        <?php if(!isset($_SESSION['user_id'])): ?>
          <a href="#" class="flex items-center gap-1 bg-yellow-400 text-gray-900 px-3 py-1 rounded text-sm font-semibold hover:bg-yellow-500">
            <i class="fas fa-store"></i> Become A Seller
          </a>
          <a href="<?php echo BASE_URL;?>users/login.php" class="flex items-center gap-1 bg-yellow-400 text-gray-900 px-3 py-1 rounded text-sm font-semibold hover:bg-yellow-500">
            <i class="fas fa-sign-in-alt"></i> Sign In
          </a>
          <a href="<?php echo BASE_URL ;?>users/register.php" class="flex items-center gap-1 bg-yellow-400 text-gray-900 px-3 py-1 rounded text-sm font-semibold hover:bg-yellow-500">
            <i class="fas fa-user-plus"></i> Sign Up
          </a>
        <?php else: ?>
          <!-- Optional: You can show a dropdown with user info here -->
          <span class="text-gray-700 font-medium">Welcome, <?php echo $_SESSION['user_name']; ?>!</span>
        <?php endif; ?>
      </div>

    </div>
  </div>
</div>
<!-- Topbar End -->
