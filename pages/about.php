<?php
$page = 'about';
include __DIR__ . '/../includes/header.php';
include __DIR__ . '/../includes/topbar.php';
include __DIR__ . '/../includes/navbar.php';
?>

<section class="py-16 bg-gradient-to-b from-gray-50 to-white">
    <div class="max-w-7xl mx-auto px-4">

        <!-- Title -->
        <div class="text-center max-w-3xl mx-auto mb-12">
            <h1 class="text-4xl md:text-5xl font-extrabold text-gray-900 mb-4">
                About DoraMart
            </h1>
            <p class="text-lg text-gray-600 leading-relaxed">
                DoraMart is a customer-centric e-commerce platform committed to delivering
                quality products, seamless shopping, and trusted digital experiences.
            </p>
        </div>

        <!-- Who We Are -->
        <div class="grid md:grid-cols-2 gap-14 items-center mb-20">
            <div>
                <h2 class="text-3xl font-bold text-gray-900 mb-5">Who We Are</h2>
                <p class="text-gray-600 leading-relaxed mb-5">
                    DoraMart is built to redefine online shopping by combining innovation,
                    reliability, and simplicity. We aim to make every purchase smooth,
                    secure, and satisfying for our customers.
                </p>
                <p class="text-gray-600 leading-relaxed">
                    From daily essentials to the latest trends, DoraMart offers a curated
                    selection of products that meet high standards of quality and value.
                </p>
            </div>
            <div class="relative">
                <img 
                    src="../assets/img/about.jpg" 
                    alt="About DoraMart"
                    class="rounded-2xl shadow-xl w-full h-[350px] object-cover"
                >
            </div>
        </div>

        <!-- Mission Vision Values -->
        <div class="grid md:grid-cols-3 gap-10 mb-20">
            <div class="bg-white p-10 rounded-2xl shadow-lg hover:shadow-xl transition transform hover:-translate-y-1">
                <div class="text-yellow-500 text-4xl mb-4">
                    <i class="fas fa-bullseye"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-3">Our Mission</h3>
                <p class="text-gray-600 leading-relaxed">
                    To provide a reliable and secure e-commerce platform that delivers exceptional value and convenience to customers.
                </p>
            </div>
            <div class="bg-white p-10 rounded-2xl shadow-lg hover:shadow-xl transition transform hover:-translate-y-1">
                <div class="text-yellow-500 text-4xl mb-4">
                    <i class="fas fa-eye"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-3">Our Vision</h3>
                <p class="text-gray-600 leading-relaxed">
                    To become a trusted digital marketplace recognized for innovation, transparency, and customer satisfaction.
                </p>
            </div>
            <div class="bg-white p-10 rounded-2xl shadow-lg hover:shadow-xl transition transform hover:-translate-y-1">
                <div class="text-yellow-500 text-4xl mb-4">
                    <i class="fas fa-handshake"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-3">Our Core Values</h3>
                <p class="text-gray-600 leading-relaxed">
                    Integrity, quality assurance, transparency, and a customer-first mindset guide everything we do.
                </p>
            </div>
        </div>

        <!-- Why Choose Us -->
        <div class="text-center">
            <h2 class="text-3xl font-bold text-gray-900 mb-12">Why Choose DoraMart?</h2>
            <div class="grid sm:grid-cols-2 md:grid-cols-4 gap-8">
                <div class="bg-white p-8 rounded-2xl shadow-lg hover:shadow-xl transition transform hover:-translate-y-1">
                    <div class="text-yellow-500 mb-4 text-3xl">
                        <i class="fas fa-shipping-fast"></i>
                    </div>
                    <h4 class="font-semibold text-gray-900 text-lg mb-2">Fast & Reliable Delivery</h4>
                    <p class="text-sm text-gray-600 leading-relaxed">
                        Efficient logistics ensuring timely delivery across the country.
                    </p>
                </div>
                <div class="bg-white p-8 rounded-2xl shadow-lg hover:shadow-xl transition transform hover:-translate-y-1">
                    <div class="text-yellow-500 mb-4 text-3xl">
                        <i class="fas fa-lock"></i>
                    </div>
                    <h4 class="font-semibold text-gray-900 text-lg mb-2">Secure Payments</h4>
                    <p class="text-sm text-gray-600 leading-relaxed">
                        Advanced payment security to protect your transactions and data.
                    </p>
                </div>
                <div class="bg-white p-8 rounded-2xl shadow-lg hover:shadow-xl transition transform hover:-translate-y-1">
                    <div class="text-yellow-500 mb-4 text-3xl">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <h4 class="font-semibold text-gray-900 text-lg mb-2">Quality Assurance</h4>
                    <p class="text-sm text-gray-600 leading-relaxed">
                        Every product is verified to meet strict quality standards.
                    </p>
                </div>
                <div class="bg-white p-8 rounded-2xl shadow-lg hover:shadow-xl transition transform hover:-translate-y-1">
                    <div class="text-yellow-500 mb-4 text-3xl">
                        <i class="fas fa-headset"></i>
                    </div>
                    <h4 class="font-semibold text-gray-900 text-lg mb-2">Dedicated Support</h4>
                    <p class="text-sm text-gray-600 leading-relaxed">
                        Professional customer support available whenever you need assistance.
                    </p>
                </div>
            </div>
        </div>

    </div>
</section>

<?php 
include __DIR__ . '/../includes/footer.php';
?>
