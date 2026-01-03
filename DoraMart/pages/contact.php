<?php
$page = 'contact';
include __DIR__ . '/../includes/header.php';
include __DIR__ . '/../includes/topbar.php';
include __DIR__ . '/../includes/navbar.php';
?>

<!-- Hero Section -->
<section class="relative overflow-hidden pt-16 pb-32 bg-gradient-to-br from-gray-50 via-white to-yellow-50">
    <!-- Subtle Pattern -->
    <div class="absolute inset-0 opacity-10 pointer-events-none">
        <div class="w-full h-full bg-[radial-gradient(circle_at_10%_90%,rgba(251,191,36,0.08)_0%,transparent_50%),radial-gradient(circle_at_90%_10%,rgba(251,191,36,0.08)_0%,transparent_50%)]"></div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="text-center max-w-4xl mx-auto">
            <div class="inline-flex items-center gap-3 bg-yellow-400/10 border border-yellow-400/30 px-6 py-3 rounded-full mb-8 backdrop-blur-sm">
                <div class="w-2.5 h-2.5 bg-yellow-500 rounded-full animate-ping"></div>
                <span class="text-yellow-700 font-semibold uppercase tracking-wider text-sm">We're Here For You</span>
            </div>

            <h1 class="text-5xl md:text-7xl font-black bg-gradient-to-r from-gray-900 via-gray-800 to-black bg-clip-text text-transparent mb-6 leading-tight">
                Get in <span class="text-yellow-500">Touch</span>
            </h1>

            <p class="text-xl md:text-2xl text-gray-600 leading-relaxed max-w-3xl mx-auto mb-12">
                Have questions? Ideas? Just want to say hi? We'd love to hear from you!
            </p>

            <div class="flex flex-col sm:flex-row gap-6 justify-center">
                <a href="#contact-form" class="btn btn-warning text-black font-bold px-10 py-5 text-lg shadow-xl hover:shadow-2xl transform hover:-translate-y-1 transition-all duration-300">
                    Send Message
                </a>
                <a href="#locations" class="btn btn-outline btn-warning text-black font-bold px-10 py-5 text-lg border-2 shadow-xl hover:shadow-2xl transform hover:-translate-y-1 transition-all duration-300">
                    Find Us
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Main Contact Section -->
<section id="contact-form" class="py-24 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid lg:grid-cols-2 gap-16 xl:gap-20 items-start">

            <!-- Contact Form - Premium Look -->
            <div class="bg-white rounded-3xl shadow-2xl p-10 lg:p-14 border border-gray-100 hover:shadow-3xl transition-shadow duration-500">
                <div class="mb-10">
                    <h2 class="text-3xl lg:text-4xl font-black text-gray-900 mb-3">
                        Send Us a Message
                    </h2>
                    <p class="text-gray-600 text-lg">
                        We usually reply within 24 hours
                    </p>
                </div>

                <form action="../includes/contact_process.php" method="POST" class="space-y-6">
                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <label for="name" class="block text-gray-700 font-medium mb-2">Full Name</label>
                            <input type="text" name="name" id="name" required
                                   class="w-full border border-gray-200 rounded-xl p-4 focus:outline-none focus:border-yellow-500 focus:ring-2 focus:ring-yellow-200 transition duration-300">
                        </div>
                        <div>
                            <label for="email" class="block text-gray-700 font-medium mb-2">Email Address</label>
                            <input type="email" name="email" id="email" required
                                   class="w-full border border-gray-200 rounded-xl p-4 focus:outline-none focus:border-yellow-500 focus:ring-2 focus:ring-yellow-200 transition duration-300">
                        </div>
                    </div>

                    <div>
                        <label for="subject" class="block text-gray-700 font-medium mb-2">Subject</label>
                        <input type="text" name="subject" id="subject" required
                               class="w-full border border-gray-200 rounded-xl p-4 focus:outline-none focus:border-yellow-500 focus:ring-2 focus:ring-yellow-200 transition duration-300">
                    </div>

                    <div>
                        <label for="message" class="block text-gray-700 font-medium mb-2">Your Message</label>
                        <textarea name="message" id="message" rows="7" required
                                  class="w-full border border-gray-200 rounded-xl p-4 focus:outline-none focus:border-yellow-500 focus:ring-2 focus:ring-yellow-200 transition duration-300 resize-none"></textarea>
                    </div>

                    <button type="submit" 
                            class="w-full bg-yellow-500 hover:bg-yellow-400 text-black font-bold text-lg px-8 py-5 rounded-xl shadow-xl hover:shadow-2xl transform hover:-translate-y-1 transition-all duration-300">
                        Send Message →
                    </button>
                </form>
            </div>

            <!-- Contact Information - Elegant Cards -->
            <div class="space-y-8" id="locations">
                <div class="group bg-white p-10 rounded-3xl shadow-xl border border-gray-100 hover:border-yellow-300 hover:shadow-2xl transition-all duration-500">
                    <div class="flex items-start gap-6">
                        <div class="w-16 h-16 bg-gradient-to-br from-yellow-500 to-yellow-400 rounded-2xl flex items-center justify-center shadow-xl flex-shrink-0">
                            <i class="fas fa-map-marker-alt text-black text-2xl"></i>
                        </div>
                        <div>
                            <h4 class="text-2xl font-bold text-gray-900 mb-3 group-hover:text-yellow-600 transition-colors">Our Address</h4>
                            <p class="text-gray-600 leading-relaxed text-lg">
                                123 DoraMart Street,<br>
                                Tech Hub, Innovation City, 12345
                            </p>
                        </div>
                    </div>
                </div>

                <div class="group bg-white p-10 rounded-3xl shadow-xl border border-gray-100 hover:border-yellow-300 hover:shadow-2xl transition-all duration-500">
                    <div class="flex items-start gap-6">
                        <div class="w-16 h-16 bg-gradient-to-br from-yellow-500 to-yellow-400 rounded-2xl flex items-center justify-center shadow-xl flex-shrink-0">
                            <i class="fas fa-phone-alt text-black text-2xl"></i>
                        </div>
                        <div>
                            <h4 class="text-2xl font-bold text-gray-900 mb-3 group-hover:text-yellow-600 transition-colors">Phone Us</h4>
                            <p class="text-gray-600 leading-relaxed text-lg">
                                +1 (234) 567-8900<br>
                                +1 (987) 654-3210
                            </p>
                        </div>
                    </div>
                </div>

                <div class="group bg-white p-10 rounded-3xl shadow-xl border border-gray-100 hover:border-yellow-300 hover:shadow-2xl transition-all duration-500">
                    <div class="flex items-start gap-6">
                        <div class="w-16 h-16 bg-gradient-to-br from-yellow-500 to-yellow-400 rounded-2xl flex items-center justify-center shadow-xl flex-shrink-0">
                            <i class="fas fa-envelope text-black text-2xl"></i>
                        </div>
                        <div>
                            <h4 class="text-2xl font-bold text-gray-900 mb-3 group-hover:text-yellow-600 transition-colors">Email Us</h4>
                            <p class="text-gray-600 leading-relaxed text-lg">
                                support@doramart.com<br>
                                info@doramart.com
                            </p>
                        </div>
                    </div>
                </div>

                <div class="group bg-white p-10 rounded-3xl shadow-xl border border-gray-100 hover:border-yellow-300 hover:shadow-2xl transition-all duration-500">
                    <div class="flex items-start gap-6">
                        <div class="w-16 h-16 bg-gradient-to-br from-yellow-500 to-yellow-400 rounded-2xl flex items-center justify-center shadow-xl flex-shrink-0">
                            <i class="fas fa-clock text-black text-2xl"></i>
                        </div>
                        <div>
                            <h4 class="text-2xl font-bold text-gray-900 mb-3 group-hover:text-yellow-600 transition-colors">Working Hours</h4>
                            <p class="text-gray-600 leading-relaxed text-lg">
                                Monday - Friday: 9:00 AM - 6:00 PM<br>
                                Saturday & Sunday: Closed
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Map Section (Optional - Google Maps) -->
<section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-4xl font-black text-gray-900 mb-4">
                Find Us Here
            </h2>
            <p class="text-xl text-gray-600">
                Visit our office or just say hi!
            </p>
        </div>
        <div class="rounded-3xl overflow-hidden shadow-2xl border border-gray-200">
            <!-- Replace with your Google Maps embed -->
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d193595.15830869428!2d-74.119763973046!3d40.69740344223377!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89c24fa5d33f083b%3A0xc80b8f06e177fe62!2sNew%20York%2C%20NY%2C%20USA!5e0!3m2!1sen!2sbd!4v1690000000000" 
                    width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
    </div>
</section>

<?php 
include __DIR__ . '/../includes/footer.php';
?>