<?php
$facebook = getSiteSettingValue('facebook_url', '#');
$instagram = getSiteSettingValue('instagram_url', '#');
$linkedin = getSiteSettingValue('linkedin_url', '#');
?>
    </main>

    <footer class="site-footer">
        <div class="container footer-grid">
            <section>
                <h3><i class="fas fa-hospital"></i> Karuna Swasthya Clinic</h3>
                <p>Patient-first healthcare with dedicated diabetes care, orthopedic guidance, and general medical consultation in Pokhara.</p>
            </section>
            <section>
                <h3><i class="fas fa-phone"></i> Call Now</h3>
                <p><a href="tel:<?php echo htmlspecialchars(getSiteSettingValue('clinic_phone', CLINIC_PHONE)); ?>"><?php echo htmlspecialchars(getSiteSettingValue('clinic_phone', CLINIC_PHONE)); ?></a></p>
                <p><a href="tel:<?php echo htmlspecialchars(getSiteSettingValue('clinic_telephone', CLINIC_TELEPHONE)); ?>"><?php echo htmlspecialchars(getSiteSettingValue('clinic_telephone', CLINIC_TELEPHONE)); ?></a></p>
            </section>
            <section>
                <h3><i class="fas fa-envelope-open-text"></i> Reach Us</h3>
                <p><a href="mailto:<?php echo htmlspecialchars(getSiteSettingValue('clinic_email', CLINIC_EMAIL)); ?>"><?php echo htmlspecialchars(getSiteSettingValue('clinic_email', CLINIC_EMAIL)); ?></a></p>
                <p><?php echo htmlspecialchars(getSiteSettingValue('clinic_address', CLINIC_ADDRESS)); ?></p>
            </section>
            <section>
                <h3><i class="fas fa-share-nodes"></i> Follow</h3>
                <div class="social-row">
                    <a href="<?php echo htmlspecialchars($facebook); ?>" target="_blank" rel="noopener"><i class="fab fa-facebook-f"></i></a>
                    <a href="<?php echo htmlspecialchars($instagram); ?>" target="_blank" rel="noopener"><i class="fab fa-instagram"></i></a>
                    <a href="<?php echo htmlspecialchars($linkedin); ?>" target="_blank" rel="noopener"><i class="fab fa-linkedin-in"></i></a>
                    <a href="<?php echo SITE_URL; ?>admin/login.php" title="Admin Portal"><i class="fas fa-user-shield"></i></a>
                </div>
            </section>
        </div>
        <div class="copyright">&copy; <?php echo date('Y'); ?> Karuna Swasthya Clinic. All rights reserved.</div>
    </footer>
</div>
<script src="<?php echo SITE_URL; ?>JS/app.js"></script>
</body>
</html>
