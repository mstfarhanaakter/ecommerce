<?php
// includes/topbar.php
include_once 'config.php';
?>

<!-- Topbar Start - Clean & Professional White + Yellow Warning Buttons -->
<div id="topbar" class="hidden lg:block bg-white text-gray-800 py-2.5 border-b border-gray-100 shadow-sm">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex items-center justify-between text-sm font-medium">

      <!-- Left: Quick Links -->
      <div class="flex items-center gap-8">
       <a href="<?= BASE_URL ?>pages/about.php" 
   class="text-gray-600 hover:text-yellow-600 transition-all duration-300 
          relative after:absolute after:bottom-[-2px] after:left-0 
          after:w-0 after:h-[2px] after:bg-yellow-400 
          hover:after:w-full after:transition-all after:duration-300">
    About Us
</a>
        <a href="<?= BASE_URL ?>pages/contact.php" 
           class="text-gray-600 hover:text-yellow-600 transition-all duration-300 
          relative after:absolute after:bottom-[-2px] after:left-0 
          after:w-0 after:h-[2px] after:bg-yellow-400 
          hover:after:w-full after:transition-all after:duration-300">
          Contact
        </a>
        <a href="<?= BASE_URL ?>pages/help.php" 
           class="text-gray-600 hover:text-yellow-600 transition-all duration-300 
          relative after:absolute after:bottom-[-2px] after:left-0 
          after:w-0 after:h-[2px] after:bg-yellow-400 
          hover:after:w-full after:transition-all after:duration-300">
          Help
        </a>
        <a href="<?= BASE_URL ?>pages/faq.php" 
           class="text-gray-600 hover:text-yellow-600 transition-all duration-300 
          relative after:absolute after:bottom-[-2px] after:left-0 
          after:w-0 after:h-[2px] after:bg-yellow-400 
          hover:after:w-full after:transition-all after:duration-300">
          FAQs
        </a>
      </div>

      <!-- Center: Sharp & Modern Logo -->
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

      <!-- Right: All Warning Buttons + Black Text -->
      <div class="flex items-center gap-4">
        <!-- Become a Seller -->
        <a href="<?= BASE_URL ?>seller/register.php"
           class="flex items-center gap-1 bg-yellow-400 text-gray-900 px-3 py-1 rounded text-sm font-semibold hover:bg-yellow-500 tracking-wider transition-all duration-300 shadow-md hover:shadow-lg hover:-translate-y-0.5">
          <i class="fas fa-store"></i>
          Become Seller
        </a>

        <?php if (!isset($_SESSION['user_id'])): ?>
          

          <!-- Sign Up -->
          <a href="<?= BASE_URL ?>users/register.php"
             class="flex items-center gap-1 bg-yellow-400 text-gray-900 px-3 py-1 rounded text-sm font-semibold hover:bg-yellow-500 tracking-wider transition-all duration-300 shadow-md hover:shadow-lg hover:-translate-y-0.5">
            <i class="fas fa-user-plus"></i>
            Sign Up
          </a>

          <!-- Sign In -->
          <a href="<?= BASE_URL ?>users/login.php"
             class="flex items-center gap-1 bg-yellow-400 text-gray-900 px-3 py-1 rounded text-sm font-semibold hover:bg-yellow-500 tracking-wider transition-all duration-300 shadow-md hover:shadow-lg hover:-translate-y-0.5">
            <i class="fas fa-sign-in-alt"></i>
            Sign In
          </a>
        <?php else: ?>
          <!-- Logged-in User -->
          <!-- <div class="dropdown dropdown-end">
            <label tabindex="0" class="flex items-center gap-3 cursor-pointer group">
              <span class="text-gray-800 font-semibold group-hover:text-yellow-600 transition-colors">
                <?= htmlspecialchars($_SESSION['user_name'] ?? 'User') ?>
              </span>
              <div class="w-8 h-8 rounded-full bg-yellow-100 flex items-center justify-center text-yellow-700 font-bold text-sm border border-yellow-300 shadow-sm">
                <?= strtoupper(substr($_SESSION['user_name'] ?? 'U', 0, 1)) ?>
              </div>
            </label>
            <ul tabindex="0" class="dropdown-content menu p-3 shadow-xl bg-white rounded-xl w-64 mt-2 border border-gray-200">
              <li><a href="<?= BASE_URL ?>profile.php" class="py-2.5 px-4 hover:bg-yellow-50 hover:text-yellow-700 rounded-lg transition-colors">My Profile</a></li>
              <li><a href="<?= BASE_URL ?>orders.php" class="py-2.5 px-4 hover:bg-yellow-50 hover:text-yellow-700 rounded-lg transition-colors">My Orders</a></li>
              <li><a href="<?= BASE_URL ?>users/logout.php" class="py-2.5 px-4 text-red-600 hover:bg-red-50 hover:text-red-700 rounded-lg transition-colors">Logout</a></li>
            </ul>
          </div> -->
        <?php endif; ?>
      </div>

    </div>
  </div>
</div>
<!-- Topbar End -->