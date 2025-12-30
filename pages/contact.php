<?php
$page = 'contact';
include __DIR__ . '/../includes/header.php';
include __DIR__ . '/../includes/topbar.php';
include __DIR__ . '/../includes/navbar.php';
?>

<section class="py-20 bg-gradient-to-b from-gray-50 to-white">
    <div class="max-w-7xl mx-auto px-2">

        <!-- Title Section -->
        <div class="text-center max-w-3xl mx-auto mb-15">
            <h1 class="text-5xl md:text-6xl font-extrabold text-gray-900 mb-4">
                Get in Touch
            </h1>
            <p class="text-lg md:text-xl text-gray-600 leading-relaxed">
                We’re here to help and answer any question you might have. We look forward to hearing from you!
            </p>
        </div>

        <div class="grid lg:grid-cols-2 gap-16 items-start">

            <!-- Contact Form -->
            <div class="bg-white rounded-3xl shadow-xl p-12 transition transform hover:-translate-y-1 hover:shadow-2xl">
                <form action="../includes/contact_process.php" method="POST" class="space-y-6">
                    
                    <div>
                        <label for="name" class="block text-gray-700 font-medium mb-2">Full Name</label>
                        <input type="text" name="name" id="name" required
                               class="w-full border border-gray-300 rounded-xl p-4 focus:outline-none focus:ring-2 focus:ring-yellow-500 transition">
                    </div>

                    <div>
                        <label for="email" class="block text-gray-700 font-medium mb-2">Email Address</label>
                        <input type="email" name="email" id="email" required
                               class="w-full border border-gray-300 rounded-xl p-4 focus:outline-none focus:ring-2 focus:ring-yellow-500 transition">
                    </div>

                    <div>
                        <label for="subject" class="block text-gray-700 font-medium mb-2">Subject</label>
                        <input type="text" name="subject" id="subject" required
                               class="w-full border border-gray-300 rounded-xl p-4 focus:outline-none focus:ring-2 focus:ring-yellow-500 transition">
                    </div>

                    <div>
                        <label for="message" class="block text-gray-700 font-medium mb-2">Message</label>
                        <textarea name="message" id="message" rows="6" required
                                  class="w-full border border-gray-300 rounded-xl p-4 focus:outline-none focus:ring-2 focus:ring-yellow-500 transition"></textarea>
                    </div>

                    <button type="submit" 
                            class="bg-yellow-500 text-white font-bold px-8 py-4 rounded-xl hover:bg-yellow-600 transition w-full">
                        Send Message
                    </button>

                </form>
            </div>

            <!-- Contact Information -->
            <div class="space-y-8">

                <div class="flex gap-6 items-start bg-white p-8 rounded-3xl shadow-xl hover:shadow-2xl transition">
                    <div class="text-yellow-500 text-4xl mt-1">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <div>
                        <h4 class="text-xl font-semibold text-gray-900 mb-1">Address</h4>
                        <p class="text-gray-600">
                            123 DoraMart Street,<br> Tech City, Country 12345
                        </p>
                    </div>
                </div>

                <div class="flex gap-6 items-start bg-white p-8 rounded-3xl shadow-xl hover:shadow-2xl transition">
                    <div class="text-yellow-500 text-4xl mt-1">
                        <i class="fas fa-phone-alt"></i>
                    </div>
                    <div>
                        <h4 class="text-xl font-semibold text-gray-900 mb-1">Phone</h4>
                        <p class="text-gray-600">
                            +1 234 567 890<br> +1 987 654 321
                        </p>
                    </div>
                </div>

                <div class="flex gap-6 items-start bg-white p-8 rounded-3xl shadow-xl hover:shadow-2xl transition">
                    <div class="text-yellow-500 text-4xl mt-1">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <div>
                        <h4 class="text-xl font-semibold text-gray-900 mb-1">Email</h4>
                        <p class="text-gray-600">
                            support@doramart.com<br> info@doramart.com
                        </p>
                    </div>
                </div>

                <div class="flex gap-6 items-start bg-white p-8 rounded-3xl shadow-xl hover:shadow-2xl transition">
                    <div class="text-yellow-500 text-4xl mt-1">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div>
                        <h4 class="text-xl font-semibold text-gray-900 mb-1">Working Hours</h4>
                        <p class="text-gray-600">
                            Mon - Fri: 9:00 AM - 6:00 PM<br> Sat - Sun: Closed
                        </p>
                    </div>
                </div>

            </div>

        </div>

    </div>
</section>

<?php
include __DIR__ . '/../includes/footer.php';
?>
