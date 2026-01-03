<?php
$page = 'faq';
include __DIR__ . '/../includes/header.php';
include __DIR__ . '/../includes/topbar.php';
include __DIR__ . '/../includes/navbar.php';
?>

<!-- Hero Section -->
<section class="relative pt-16 pb-20 bg-gradient-to-br from-gray-50 via-white to-yellow-50 overflow-hidden">
    <!-- Subtle Background Pattern -->
    <div class="absolute inset-0 opacity-10 pointer-events-none">
        <div class="w-full h-full bg-[radial-gradient(circle_at_15%_85%,rgba(251,191,36,0.1)_0%,transparent_50%),radial-gradient(circle_at_85%_15%,rgba(251,191,36,0.1)_0%,transparent_50%)]"></div>
    </div>

    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
        <div class="inline-flex items-center gap-3 bg-yellow-400/10 border border-yellow-400/30 px-6 py-3 rounded-full mb-8 backdrop-blur-sm">
            <div class="w-2.5 h-2.5 bg-yellow-500 rounded-full animate-ping"></div>
            <span class="text-yellow-700 font-semibold uppercase tracking-wider text-sm">Got Questions?</span>
        </div>

        <h1 class="text-5xl md:text-6xl lg:text-7xl font-black bg-gradient-to-r from-gray-900 via-gray-800 to-black bg-clip-text text-transparent mb-6 leading-tight">
            Frequently Asked <span class="text-yellow-500">Questions</span>
        </h1>

        <p class="text-xl md:text-2xl text-gray-600 max-w-3xl mx-auto leading-relaxed">
            Find quick answers to common questions about shopping, orders, payments, and more.
        </p>
    </div>
</section>

<!-- FAQ Accordion Section -->
<section class="py-20 bg-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="space-y-6">
            <!-- FAQ Item 1 -->
            <div class="faq-item bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden transition-all duration-300 hover:shadow-2xl hover:border-yellow-200 group">
                <button class="faq-toggle w-full px-8 py-6 text-left flex justify-between items-center focus:outline-none">
                    <span class="text-xl md:text-2xl font-bold text-gray-900 group-hover:text-yellow-600 transition-colors">
                        How can I place an order?
                    </span>
                    <span class="text-yellow-500 text-2xl font-bold transition-transform duration-300 group-hover:rotate-180">
                        +
                    </span>
                </button>
                <div class="faq-content px-8 pb-6 text-gray-600 text-lg leading-relaxed max-h-0 overflow-hidden transition-all duration-500 ease-in-out">
                    <p>Browse our products, add items to your cart, proceed to checkout, select payment method and complete your order. You'll receive an instant confirmation email.</p>
                </div>
            </div>

            <!-- FAQ Item 2 -->
            <div class="faq-item bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden transition-all duration-300 hover:shadow-2xl hover:border-yellow-200 group">
                <button class="faq-toggle w-full px-8 py-6 text-left flex justify-between items-center focus:outline-none">
                    <span class="text-xl md:text-2xl font-bold text-gray-900 group-hover:text-yellow-600 transition-colors">
                        What payment methods do you accept?
                    </span>
                    <span class="text-yellow-500 text-2xl font-bold transition-transform duration-300 group-hover:rotate-180">
                        +
                    </span>
                </button>
                <div class="faq-content px-8 pb-6 text-gray-600 text-lg leading-relaxed max-h-0 overflow-hidden transition-all duration-500 ease-in-out">
                    <p>We accept all major credit/debit cards, mobile banking (bKash, Nagad, Rocket), cash on delivery (COD), and secure online payment gateways.</p>
                </div>
            </div>

            <!-- FAQ Item 3 -->
            <div class="faq-item bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden transition-all duration-300 hover:shadow-2xl hover:border-yellow-200 group">
                <button class="faq-toggle w-full px-8 py-6 text-left flex justify-between items-center focus:outline-none">
                    <span class="text-xl md:text-2xl font-bold text-gray-900 group-hover:text-yellow-600 transition-colors">
                        Can I track my order status?
                    </span>
                    <span class="text-yellow-500 text-2xl font-bold transition-transform duration-300 group-hover:rotate-180">
                        +
                    </span>
                </button>
                <div class="faq-content px-8 pb-6 text-gray-600 text-lg leading-relaxed max-h-0 overflow-hidden transition-all duration-500 ease-in-out">
                    <p>Yes! After shipping, you'll receive a tracking number via email/SMS. Track your order in real-time from your account dashboard or our tracking page.</p>
                </div>
            </div>

            <!-- FAQ Item 4 -->
            <div class="faq-item bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden transition-all duration-300 hover:shadow-2xl hover:border-yellow-200 group">
                <button class="faq-toggle w-full px-8 py-6 text-left flex justify-between items-center focus:outline-none">
                    <span class="text-xl md:text-2xl font-bold text-gray-900 group-hover:text-yellow-600 transition-colors">
                        How can I contact customer support?
                    </span>
                    <span class="text-yellow-500 text-2xl font-bold transition-transform duration-300 group-hover:rotate-180">
                        +
                    </span>
                </button>
                <div class="faq-content px-8 pb-6 text-gray-600 text-lg leading-relaxed max-h-0 overflow-hidden transition-all duration-500 ease-in-out">
                    <p>Reach us via live chat (available 9 AM - 10 PM), email at support@doramart.com, or phone at +880 1234-567890. We're here to help!</p>
                </div>
            </div>

            <!-- Add more FAQs as needed -->
        </div>

        <!-- Still have questions? CTA -->
        <div class="mt-16 text-center">
            <div class="bg-gradient-to-r from-yellow-50 to-white p-10 rounded-3xl shadow-xl max-w-3xl mx-auto border border-yellow-100">
                <h3 class="text-3xl font-bold text-gray-900 mb-4">
                    Still Have Questions?
                </h3>
                <p class="text-xl text-gray-600 mb-8">
                    Our support team is ready to help you 24/7
                </p>
                <a href="<?= BASE_URL ?>pages/contact.php" 
                   class="inline-flex items-center gap-3 bg-yellow-500 hover:bg-yellow-400 text-black font-bold px-10 py-5 rounded-xl shadow-lg hover:shadow-2xl transform hover:-translate-y-1 transition-all duration-300 text-lg">
                    Contact Support <span class="text-xl">→</span>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Custom JS for Accordion -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const toggles = document.querySelectorAll('.faq-toggle');
    
    toggles.forEach(toggle => {
        toggle.addEventListener('click', function() {
            const content = this.nextElementSibling;
            const isOpen = content.style.maxHeight && content.style.maxHeight !== '0px';
            
            // Close all other items
            document.querySelectorAll('.faq-content').forEach(item => {
                item.style.maxHeight = '0px';
            });
            
            // Toggle current item
            if (!isOpen) {
                content.style.maxHeight = content.scrollHeight + 'px';
            }
        });
    });
});
</script>

<?php 
include __DIR__ . '/../includes/footer.php';
?>