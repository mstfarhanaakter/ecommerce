<?php
$page = 'help';
include __DIR__ . '/../includes/header.php';
include __DIR__ . '/../includes/topbar.php';
include __DIR__ . '/../includes/navbar.php';
?>

<!-- Hero Section - Premium Gradient -->
<section class="relative pt-16 pb-32 bg-gradient-to-br from-gray-50 via-white to-yellow-50 overflow-hidden">
    <!-- Subtle Animated Pattern -->
    <div class="absolute inset-0 opacity-10 pointer-events-none">
        <div class="w-full h-full bg-[radial-gradient(circle_at_20%_80%,rgba(251,191,36,0.12)_0%,transparent_50%),radial-gradient(circle_at_80%_20%,rgba(251,191,36,0.12)_0%,transparent_50%)]"></div>
    </div>

    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
        <div class="inline-flex items-center gap-3 bg-yellow-400/10 border border-yellow-400/30 px-7 py-3.5 rounded-full mb-8 backdrop-blur-sm shadow-sm">
            <div class="w-3 h-3 bg-yellow-500 rounded-full animate-ping"></div>
            <span class="text-yellow-700 font-semibold uppercase tracking-widest text-sm">We're Here 24/7</span>
        </div>

        <h1 class="text-5xl md:text-6xl lg:text-7xl font-black bg-gradient-to-r from-gray-900 via-gray-800 to-black bg-clip-text text-transparent mb-6 leading-tight">
            Help & <span class="text-yellow-500">Support</span>
        </h1>

        <p class="text-xl md:text-2xl text-gray-600 leading-relaxed max-w-3xl mx-auto">
            Got questions? Facing any issue? Our dedicated team is ready to assist you anytime.
        </p>
    </div>
</section>

<!-- Main Help Section -->
<section class="py-24 bg-white">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Quick Contact Cards -->
        <div class="grid md:grid-cols-3 gap-8 mb-20">
            <!-- Email Card -->
            <div class="group bg-gradient-to-b from-white to-yellow-50/30 p-10 rounded-3xl shadow-xl border border-gray-100 hover:border-yellow-300 hover:shadow-2xl transition-all duration-500 hover:-translate-y-3">
                <div class="w-20 h-20 bg-gradient-to-br from-yellow-500 to-yellow-400 rounded-2xl flex items-center justify-center shadow-xl mx-auto mb-6 transform group-hover:rotate-6 transition-transform duration-500">
                    <i class="fas fa-envelope text-black text-3xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-center text-gray-900 mb-4 group-hover:text-yellow-600 transition-colors">Email Us</h3>
                <p class="text-center text-gray-600 text-lg mb-4">
                    Get a reply within 24 hours
                </p>
                <a href="mailto:support@doramart.com" 
                   class="block text-center text-yellow-600 font-bold hover:text-yellow-500 transition text-xl">
                    support@doramart.com
                </a>
            </div>

            <!-- Phone Card -->
            <div class="group bg-gradient-to-b from-white to-yellow-50/30 p-10 rounded-3xl shadow-xl border border-gray-100 hover:border-yellow-300 hover:shadow-2xl transition-all duration-500 hover:-translate-y-3">
                <div class="w-20 h-20 bg-gradient-to-br from-yellow-500 to-yellow-400 rounded-2xl flex items-center justify-center shadow-xl mx-auto mb-6 transform group-hover:rotate-6 transition-transform duration-500">
                    <i class="fas fa-phone-alt text-black text-3xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-center text-gray-900 mb-4 group-hover:text-yellow-600 transition-colors">Call Us</h3>
                <p class="text-center text-gray-600 text-lg mb-4">
                    Available 9 AM - 10 PM
                </p>
                <a href="tel:+8801234567890" 
                   class="block text-center text-yellow-600 font-bold hover:text-yellow-500 transition text-xl">
                    +880 1234 567 890
                </a>
            </div>

            <!-- Live Chat Card -->
            <div class="group bg-gradient-to-b from-white to-yellow-50/30 p-10 rounded-3xl shadow-xl border border-gray-100 hover:border-yellow-300 hover:shadow-2xl transition-all duration-500 hover:-translate-y-3">
                <div class="w-20 h-20 bg-gradient-to-br from-yellow-500 to-yellow-400 rounded-2xl flex items-center justify-center shadow-xl mx-auto mb-6 transform group-hover:rotate-6 transition-transform duration-500">
                    <i class="fas fa-comment-dots text-black text-3xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-center text-gray-900 mb-4 group-hover:text-yellow-600 transition-colors">Live Chat</h3>
                <p class="text-center text-gray-600 text-lg mb-4">
                    Instant help from our team
                </p>
                <button class="w-full bg-yellow-500 hover:bg-yellow-400 text-black font-bold py-3 px-8 rounded-xl shadow-md hover:shadow-lg transition-all duration-300">
                    Start Chat Now
                </button>
            </div>
        </div>

        <!-- Help Topics Grid -->
        <div class="text-center mb-16">
            <h2 class="text-4xl lg:text-5xl font-black bg-gradient-to-r from-gray-900 to-gray-800 bg-clip-text text-transparent mb-6">
                Popular Help Topics
            </h2>
            <p class="text-xl text-gray-600">
                Quick guides to get you started
            </p>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            <div class="group bg-white p-8 rounded-2xl shadow-lg border border-gray-100 hover:border-yellow-300 hover:shadow-2xl transition-all duration-500 hover:-translate-y-2">
                <div class="w-14 h-14 bg-gradient-to-br from-yellow-500 to-yellow-400 rounded-xl flex items-center justify-center mb-6 shadow-lg group-hover:rotate-6 transition-transform">
                    <i class="fas fa-shopping-cart text-black text-2xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-3 group-hover:text-yellow-600 transition-colors">How to Shop</h3>
                <p class="text-gray-600 leading-relaxed">
                    Step-by-step guide to browsing, adding to cart, and checking out.
                </p>
            </div>

            <div class="group bg-white p-8 rounded-2xl shadow-lg border border-gray-100 hover:border-yellow-300 hover:shadow-2xl transition-all duration-500 hover:-translate-y-2">
                <div class="w-14 h-14 bg-gradient-to-br from-yellow-500 to-yellow-400 rounded-xl flex items-center justify-center mb-6 shadow-lg group-hover:rotate-6 transition-transform">
                    <i class="fas fa-truck text-black text-2xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-3 group-hover:text-yellow-600 transition-colors">Delivery & Shipping</h3>
                <p class="text-gray-600 leading-relaxed">
                    Delivery times, charges, tracking, and international shipping info.
                </p>
            </div>

            <div class="group bg-white p-8 rounded-2xl shadow-lg border border-gray-100 hover:border-yellow-300 hover:shadow-2xl transition-all duration-500 hover:-translate-y-2">
                <div class="w-14 h-14 bg-gradient-to-br from-yellow-500 to-yellow-400 rounded-xl flex items-center justify-center mb-6 shadow-lg group-hover:rotate-6 transition-transform">
                    <i class="fas fa-credit-card text-black text-2xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-3 group-hover:text-yellow-600 transition-colors">Payments & Refunds</h3>
                <p class="text-gray-600 leading-relaxed">
                    Accepted methods, secure payment, returns & refund policy explained.
                </p>
            </div>

            <!-- Add more topics as needed -->
        </div>

        <!-- Final CTA -->
        <div class="mt-20 text-center">
            <div class="bg-gradient-to-r from-yellow-50 to-white p-12 rounded-3xl shadow-2xl max-w-4xl mx-auto border border-yellow-100">
                <h3 class="text-3xl md:text-4xl font-black text-gray-900 mb-6">
                    Need More Help?
                </h3>
                <p class="text-xl text-gray-600 mb-10">
                    Our support team is available round the clock
                </p>
                <div class="flex flex-col sm:flex-row gap-6 justify-center items-center">
                    <a href="mailto:support@doramart.com" 
                       class="flex items-center gap-3 bg-yellow-500 hover:bg-yellow-400 text-black font-bold px-10 py-5 rounded-xl shadow-xl hover:shadow-2xl transform hover:-translate-y-1 transition-all duration-300 text-lg">
                        <i class="fas fa-envelope"></i> Email Support
                    </a>
                    <a href="<?= BASE_URL ?>pages/contact.php" 
                       class="flex items-center gap-3 border-2 border-yellow-500 text-yellow-600 hover:bg-yellow-50 font-bold px-10 py-5 rounded-xl shadow-xl hover:shadow-2xl transform hover:-translate-y-1 transition-all duration-300 text-lg">
                        <i class="fas fa-headset"></i> Live Chat
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<?php 
include __DIR__ . '/../includes/footer.php';
?>