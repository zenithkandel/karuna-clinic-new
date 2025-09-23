    </main>

    <!-- Footer -->
    <footer class="site-footer">
        <div class="footer-top">
            <div class="container">
                <div class="accent-ring" aria-hidden="true"></div>
                <div class="footer-grid">
                    <!-- Brand / About -->
                    <div class="footer-col footer-brand">
                        <div class="footer-logo">
                            <img src="<?php echo SITE_URL; ?>assets/images/logo.png" alt="<?php echo SITE_NAME; ?>" class="footer-logo-img" />
                            <div class="footer-logo-text">
                                <span class="footer-site-name"><?php echo SITE_NAME; ?></span>
                                <span class="footer-tagline"><?php echo SITE_TAGLINE; ?></span>
                            </div>
                        </div>
                        <p class="footer-address"><?php echo CLINIC_ADDRESS; ?></p>
                    </div>

                    <!-- Contact Information -->
                    <div class="footer-col footer-contact">
                        <h3 class="footer-heading">Contact Information</h3>
                        <ul class="footer-list">
                            <li class="footer-list-item">
                                <i class="fas fa-phone"></i>
                                <span><?php echo formatPhone(CLINIC_PHONE); ?></span>
                            </li>
                            <li class="footer-list-item">
                                <i class="fas fa-phone-alt"></i>
                                <span><?php echo CLINIC_TELEPHONE; ?></span>
                            </li>
                            <li class="footer-list-item">
                                <i class="fas fa-envelope"></i>
                                <span><?php echo CLINIC_EMAIL; ?></span>
                            </li>
                            <li class="footer-list-item">
                                <i class="fas fa-clock"></i>
                                <span><?php echo CLINIC_HOURS; ?></span>
                            </li>
                        </ul>
                    </div>

                    <!-- Quick Links -->
                    <div class="footer-col footer-links">
                        <h3 class="footer-heading">Quick Links</h3>
                        <ul class="footer-list">
                            <li><a class="footer-link" href="<?php echo SITE_URL; ?>pages/services.php"><i class="fas fa-chevron-right"></i> <span>Our Services</span></a></li>
                            <li><a class="footer-link" href="<?php echo SITE_URL; ?>pages/doctors.php"><i class="fas fa-chevron-right"></i> <span>Our Doctors</span></a></li>
                            <li><a class="footer-link" href="<?php echo SITE_URL; ?>pages/contact.php"><i class="fas fa-chevron-right"></i> <span>Book Appointment</span></a></li>
                            <li><a class="footer-link" href="<?php echo SITE_URL; ?>pages/about.php"><i class="fas fa-chevron-right"></i> <span>About Us</span></a></li>
                        </ul>
                        <div class="footer-newsletter">
                            <form action="#" method="post" onsubmit="event.preventDefault();alert('Demo only');">
                                <input type="email" name="newsletter_email" placeholder="Email for updates" aria-label="Email address" required>
                                <button class="btn btn-primary" type="submit">Subscribe</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <div class="container footer-bottom-inner">
                <p class="footer-copy">© <?php echo date('Y'); ?> <?php echo SITE_NAME; ?>. All rights reserved.</p>
                <div class="social-links">
                    <a href="#" class="social-link" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="social-link" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="social-link" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="social-link" aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Back to Top Button -->
    <button id="back-to-top" class="back-to-top" aria-label="Back to top">
        <i class="fas fa-chevron-up"></i>
    </button>

    <!-- JavaScript -->
    <script src="<?php echo SITE_URL; ?>JS/app.js"></script>
</body>
</html>