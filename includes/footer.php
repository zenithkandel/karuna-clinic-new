    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white">
        <div class="container mx-auto px-6 py-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Clinic Info -->
                <div>
                    <div class="flex items-center mb-4">
                        <img src="<?php echo SITE_URL; ?>assets/images/logo.png" alt="<?php echo SITE_NAME; ?>" class="h-10 w-auto">
                        <span class="ml-3 text-lg font-bold"><?php echo SITE_NAME; ?></span>
                    </div>
                    <p class="text-gray-300 mb-4"><?php echo SITE_TAGLINE; ?></p>
                    <p class="text-gray-400 text-sm"><?php echo CLINIC_ADDRESS; ?></p>
                </div>

                <!-- Contact Info -->
                <div>
                    <h3 class="text-lg font-semibold mb-4">Contact Information</h3>
                    <div class="space-y-2">
                        <div class="flex items-center">
                            <i class="fas fa-phone mr-3 text-blue-400"></i>
                            <span><?php echo formatPhone(CLINIC_PHONE); ?></span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-phone-alt mr-3 text-blue-400"></i>
                            <span><?php echo CLINIC_TELEPHONE; ?></span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-envelope mr-3 text-blue-400"></i>
                            <span><?php echo CLINIC_EMAIL; ?></span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-clock mr-3 text-blue-400"></i>
                            <span><?php echo CLINIC_HOURS; ?></span>
                        </div>
                    </div>
                </div>

                <!-- Quick Links -->
                <div>
                    <h3 class="text-lg font-semibold mb-4">Quick Links</h3>
                    <div class="space-y-2">
                        <a href="<?php echo SITE_URL; ?>pages/services.php" class="block text-gray-300 hover:text-blue-400 transition-colors duration-300">
                            <i class="fas fa-chevron-right mr-2"></i>Our Services
                        </a>
                        <a href="<?php echo SITE_URL; ?>pages/doctors.php" class="block text-gray-300 hover:text-blue-400 transition-colors duration-300">
                            <i class="fas fa-chevron-right mr-2"></i>Our Doctors
                        </a>
                        <a href="<?php echo SITE_URL; ?>pages/contact.php" class="block text-gray-300 hover:text-blue-400 transition-colors duration-300">
                            <i class="fas fa-chevron-right mr-2"></i>Book Appointment
                        </a>
                        <a href="<?php echo SITE_URL; ?>pages/about.php" class="block text-gray-300 hover:text-blue-400 transition-colors duration-300">
                            <i class="fas fa-chevron-right mr-2"></i>About Us
                        </a>
                    </div>
                </div>
            </div>

            <div class="border-t border-gray-700 mt-8 pt-6">
                <div class="flex flex-col md:flex-row justify-between items-center">
                    <p class="text-gray-400 text-sm">© <?php echo date('Y'); ?> <?php echo SITE_NAME; ?>. All rights reserved.</p>
                    <div class="flex space-x-4 mt-4 md:mt-0">
                        <a href="#" class="text-gray-400 hover:text-blue-400 transition-colors duration-300">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-blue-400 transition-colors duration-300">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-blue-400 transition-colors duration-300">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-blue-400 transition-colors duration-300">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Back to Top Button -->
    <button id="back-to-top" class="fixed bottom-4 right-4 bg-blue-600 text-white p-3 rounded-full shadow-lg hover:bg-blue-700 transition-all duration-300 opacity-0 invisible">
        <i class="fas fa-chevron-up"></i>
    </button>

    <!-- JavaScript -->
    <script src="<?php echo SITE_URL; ?>JS/app.js"></script>
</body>
</html>