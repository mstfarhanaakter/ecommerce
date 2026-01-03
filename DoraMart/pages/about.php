<?php
$page = 'about';
include __DIR__ . '/../includes/header.php';
include __DIR__ . '/../includes/topbar.php';
include __DIR__ . '/../includes/navbar.php';
?>

<!-- Hero Section - Premium Gradient -->
<section class="relative overflow-hidden pt-16 pb-32 bg-gradient-to-br from-gray-50 via-white to-yellow-50">
    <!-- Animated Background Pattern -->
    <div class="absolute inset-0 opacity-10">
        <div class="absolute top-0 left-0 w-full h-full bg-[radial-gradient(circle_at_20%_80%,rgba(251,191,36,0.1)_0%,transparent_50%),radial-gradient(circle_at_80%_20%,rgba(251,191,36,0.1)_0%,transparent_50%),radial-gradient(circle_at_40%_40%,rgba(251,191,36,0.05)_0%,transparent_50%)]"></div>
    </div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="text-center max-w-4xl mx-auto">
            <div class="inline-flex items-center gap-3 bg-yellow-400/10 border border-yellow-400/30 px-6 py-3 rounded-full mb-8">
                <div class="w-2 h-2 bg-yellow-500 rounded-full animate-ping"></div>
                <span class="text-yellow-700 font-medium uppercase tracking-wider text-sm">Welcome to DoraMart</span>
            </div>
            <h1 class="text-5xl md:text-7xl lg:text-[5rem] font-black bg-gradient-to-r from-gray-900 via-gray-800 to-black bg-clip-text text-transparent mb-6 leading-tight">
                About <span class="text-yellow-500">DoraMart</span>
            </h1>
            <p class="text-xl md:text-2xl text-gray-600 leading-relaxed max-w-2xl mx-auto mb-12">
                Your trusted partner in premium e-commerce. Delivering quality, innovation, and unmatched shopping experiences since day one.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                <a href="<?= BASE_URL ?>category.php" class="btn btn-warning text-black font-bold px-8 py-4 text-lg shadow-xl hover:shadow-2xl transform hover:-translate-y-1 transition-all duration-300">
                    Shop Now
                </a>
                <a href="<?= BASE_URL ?>pages/contact.php" class="btn btn-outline btn-warning text-black font-bold px-8 py-4 text-lg border-2 shadow-xl hover:shadow-2xl transform hover:-translate-y-1 transition-all duration-300">
                    Contact Us
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Who We Are - Split Screen -->
<section class="py-24 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid lg:grid-cols-2 gap-16 items-center">
            <div class="order-2 lg:order-1">
                <div class="inline-flex items-center gap-2 bg-gradient-to-r from-yellow-500 to-yellow-400 text-black px-5 py-2 rounded-full font-bold mb-8 shadow-lg">
                    <i class="fas fa-info-circle"></i>
                    Who We Are
                </div>
                <h2 class="text-4xl lg:text-5xl font-black text-gray-900 mb-6 leading-tight">
                    Redefining <span class="bg-gradient-to-r from-yellow-500 to-yellow-400 bg-clip-text text-transparent">E-Commerce</span>
                </h2>
                <p class="text-xl text-gray-600 mb-8 leading-relaxed">
                    DoraMart is more than an online store—it's a seamless shopping revolution. We blend cutting-edge technology with 
                    customer-first principles to deliver unparalleled value, quality, and convenience.
                </p>
                <div class="grid md:grid-cols-2 gap-6 mb-12">
                    <div class="flex items-start gap-4 p-6 bg-gray-50/50 rounded-xl hover:bg-yellow-50/50 transition-all">
                        <div class="w-12 h-12 bg-gradient-to-r from-yellow-500 to-yellow-400 rounded-2xl flex items-center justify-center shadow-lg mt-1">
                            <i class="fas fa-rocket text-black text-xl"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-900 text-lg mb-1">Innovation First</h4>
                            <p class="text-gray-600">Advanced tech for smooth experiences</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4 p-6 bg-gray-50/50 rounded-xl hover:bg-yellow-50/50 transition-all">
                        <div class="w-12 h-12 bg-gradient-to-r from-yellow-500 to-yellow-400 rounded-2xl flex items-center justify-center shadow-lg mt-1">
                            <i class="fas fa-shield-alt text-black text-xl"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-900 text-lg mb-1">100% Secure</h4>
                            <p class="text-gray-600">Bank-level security protection</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="order-1 lg:order-2 relative group">
                <div class="relative">
                    <img 
                        src="<?= BASE_URL ?>assets/img/about.jpg" 
                        alt="DoraMart Team"
                        class="rounded-3xl shadow-2xl w-full h-[500px] lg:h-[600px] object-cover group-hover:scale-105 transition-transform duration-700"
                    >
                    <div class="absolute -inset-2 bg-gradient-to-r from-yellow-500/10 via-transparent to-yellow-400/10 rounded-3xl blur-xl opacity-75 group-hover:opacity-100 transition-all duration-700"></div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Mission Vision Values - Premium Cards -->
<section class="py-20 bg-gradient-to-b from-gray-50 to-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-20">
            <div class="inline-flex items-center gap-2 bg-gradient-to-r from-yellow-500 to-yellow-400 text-black px-6 py-3 rounded-full font-bold mb-8 shadow-lg mx-auto max-w-max">
                <i class="fas fa-compass"></i>
                Our Philosophy
            </div>
            <h2 class="text-4xl lg:text-5xl font-black bg-gradient-to-r from-gray-900 to-gray-700 bg-clip-text text-transparent mb-6">
                Mission • Vision • Values
            </h2>
        </div>
        
        <div class="grid md:grid-cols-3 gap-8">
            <!-- Mission -->
            <div class="group bg-white/70 backdrop-blur-sm p-10 rounded-3xl shadow-xl hover:shadow-2xl border border-gray-100/50 hover:border-yellow-200/50 transition-all duration-500 hover:-translate-y-4 cursor-pointer">
                <div class="w-20 h-20 bg-gradient-to-br from-yellow-500 to-yellow-400 rounded-2xl flex items-center justify-center shadow-xl group-hover:scale-110 transition-all duration-500 mx-auto mb-6">
                    <i class="fas fa-bullseye text-black text-2xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-4 text-center group-hover:text-yellow-600 transition-colors">Our Mission</h3>
                <p class="text-gray-600 leading-relaxed text-center">
                    Building the most reliable e-commerce platform with unmatched quality, speed, and customer satisfaction.
                </p>
            </div>

            <!-- Vision -->
            <div class="group bg-white/70 backdrop-blur-sm p-10 rounded-3xl shadow-xl hover:shadow-2xl border border-gray-100/50 hover:border-yellow-200/50 transition-all duration-500 hover:-translate-y-4 cursor-pointer">
                <div class="w-20 h-20 bg-gradient-to-br from-yellow-500 to-yellow-400 rounded-2xl flex items-center justify-center shadow-xl group-hover:scale-110 transition-all duration-500 mx-auto mb-6">
                    <i class="fas fa-eye text-black text-2xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-4 text-center group-hover:text-yellow-600 transition-colors">Our Vision</h3>
                <p class="text-gray-600 leading-relaxed text-center">
                    To be the #1 trusted digital marketplace globally, known for innovation and transparency.
                </p>
            </div>

            <!-- Values -->
            <div class="group bg-white/70 backdrop-blur-sm p-10 rounded-3xl shadow-xl hover:shadow-2xl border border-gray-100/50 hover:border-yellow-200/50 transition-all duration-500 hover:-translate-y-4 cursor-pointer">
                <div class="w-20 h-20 bg-gradient-to-br from-yellow-500 to-yellow-400 rounded-2xl flex items-center justify-center shadow-xl group-hover:scale-110 transition-all duration-500 mx-auto mb-6">
                    <i class="fas fa-handshake text-black text-2xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-4 text-center group-hover:text-yellow-600 transition-colors">Core Values</h3>
                <p class="text-gray-600 leading-relaxed text-center">
                    Integrity • Quality • Transparency • Customer First
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Why Choose Us - Stats + Features -->
<section class="py-24 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-20">
            <h2 class="text-4xl lg:text-5xl font-black bg-gradient-to-r from-gray-900 to-black bg-clip-text text-transparent mb-6">
                Why <span class="text-yellow-500">DoraMart</span>?
            </h2>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                Experience shopping like never before with our industry-leading features
            </p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <div class="group text-center p-10 rounded-3xl bg-gradient-to-b from-yellow-50 to-white shadow-xl hover:shadow-2xl border border-yellow-100/50 hover:border-yellow-300 transition-all duration-500 hover:-translate-y-3">
                <div class="w-20 h-20 bg-gradient-to-r from-yellow-500 to-yellow-400 rounded-3xl flex items-center justify-center mx-auto shadow-2xl group-hover:rotate-12 transition-all duration-700 mb-6">
                    <i class="fas fa-shipping-fast text-black text-2xl"></i>
                </div>
                <h4 class="text-2xl font-bold text-gray-900 mb-4 group-hover:text-yellow-600">Lightning Delivery</h4>
                <p class="text-gray-600 leading-relaxed">Same-day delivery in major cities, 2-3 days nationwide</p>
            </div>
            
            <div class="group text-center p-10 rounded-3xl bg-gradient-to-b from-yellow-50 to-white shadow-xl hover:shadow-2xl border border-yellow-100/50 hover:border-yellow-300 transition-all duration-500 hover:-translate-y-3">
                <div class="w-20 h-20 bg-gradient-to-r from-yellow-500 to-yellow-400 rounded-3xl flex items-center justify-center mx-auto shadow-2xl group-hover:rotate-12 transition-all duration-700 mb-6">
                    <i class="fas fa-lock text-black text-2xl"></i>
                </div>
                <h4 class="text-2xl font-bold text-gray-900 mb-4 group-hover:text-yellow-600">Bank-Grade Security</h4>
                <p class="text-gray-600 leading-relaxed">SSL encryption + fraud protection on every transaction</p>
            </div>
            
            <div class="group text-center p-10 rounded-3xl bg-gradient-to-b from-yellow-50 to-white shadow-xl hover:shadow-2xl border border-yellow-100/50 hover:border-yellow-300 transition-all duration-500 hover:-translate-y-3">
                <div class="w-20 h-20 bg-gradient-to-r from-yellow-500 to-yellow-400 rounded-3xl flex items-center justify-center mx-auto shadow-2xl group-hover:rotate-12 transition-all duration-700 mb-6">
                    <i class="fas fa-medal text-black text-2xl"></i>
                </div>
                <h4 class="text-2xl font-bold text-gray-900 mb-4 group-hover:text-yellow-600">Premium Quality</h4>
                <p class="text-gray-600 leading-relaxed">Every product rigorously tested & verified</p>
            </div>
            
            <div class="group text-center p-10 rounded-3xl bg-gradient-to-b from-yellow-50 to-white shadow-xl hover:shadow-2xl border border-yellow-100/50 hover:border-yellow-300 transition-all duration-500 hover:-translate-y-3">
                <div class="w-20 h-20 bg-gradient-to-r from-yellow-500 to-yellow-400 rounded-3xl flex items-center justify-center mx-auto shadow-2xl group-hover:rotate-12 transition-all duration-700 mb-6">
                    <i class="fas fa-headset text-black text-2xl"></i>
                </div>
                <h4 class="text-2xl font-bold text-gray-900 mb-4 group-hover:text-yellow-600">24/7 Support</h4>
                <p class="text-gray-600 leading-relaxed">Live chat, email & phone support around the clock</p>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-24 bg-gradient-to-r from-gray-900 to-black text-white">
    <div class="max-w-4xl mx-auto text-center px-4 sm:px-6 lg:px-8">
        <div class="inline-flex items-center gap-3 bg-yellow-500/20 border-2 border-yellow-500/30 px-8 py-4 rounded-3xl mb-8 backdrop-blur-sm">
            <i class="fas fa-crown text-yellow-500 text-2xl"></i>
            <span class="text-yellow-400 font-bold text-lg">Join 500K+ Happy Customers</span>
        </div>
        <h2 class="text-4xl lg:text-5xl font-black mb-6 leading-tight">
            Ready to Experience <span class="text-yellow-400">DoraMart</span>?
        </h2>
        <p class="text-xl text-gray-300 mb-12 max-w-2xl mx-auto leading-relaxed">
            Start shopping now and discover why thousands trust us for their everyday needs.
        </p>
        <div class="flex flex-col sm:flex-row gap-6 justify-center items-center">
            <a href="<?= BASE_URL ?>category.php" class="btn btn-warning btn-lg text-black font-bold px-12 py-5 text-xl shadow-2xl hover:shadow-3xl transform hover:scale-105 transition-all duration-300">
                Start Shopping
            </a>
            <a href="<?= BASE_URL ?>pages/contact.php" class="btn btn-outline btn-lg border-2 text-white font-bold px-12 py-5 text-xl shadow-2xl hover:shadow-3xl transform hover:scale-105 hover:text-black transition-all duration-300">
                Get In Touch
            </a>
        </div>
    </div>
</section>

<?php 
include __DIR__ . '/../includes/footer.php';
?>