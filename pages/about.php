<?php
$pageTitle = 'About Us';
include_once '../includes/header.php';

$db = DatabaseHelper::getInstance();
$stats = $db->getStats();
?>

<section class="page-banner" style="background-image:url('../assets/images/site1.jpg');">
    <div>
        <h1>About Karuna Swasthya Clinic</h1>
        <p>Trusted clinical care with a strong focus on diabetes and general wellness.</p>
    </div>
</section>

<section class="section">
    <div class="container media-split">
        <div class="image-pane" style="background-image:url('../assets/images/hero-main.webp');"></div>
        <div class="text-pane">
            <h2><i class="fas fa-bullseye"></i> Mission and Approach</h2>
            <p>Karuna Swasthya Clinic and Diabetes Center delivers practical, quality healthcare services with patient-centered consultation and clear treatment plans.</p>
            <ul>
                <li><i class="fas fa-check"></i> Diabetes-focused care and long-term management</li>
                <li><i class="fas fa-check"></i> Orthopedic and trauma consultation support</li>
                <li><i class="fas fa-check"></i> Preventive checkups and counseling for families</li>
                <li><i class="fas fa-check"></i> Experienced medical team in Pokhara</li>
            </ul>
        </div>
    </div>
</section>

<section class="stats-strip">
    <div class="container">
        <div class="stats-grid">
            <div class="stat"><strong><?php echo (int)$stats['services']; ?>+</strong><span>Service Lines</span></div>
            <div class="stat"><strong><?php echo (int)$stats['doctors']; ?>+</strong><span>Specialists</span></div>
            <div class="stat"><strong><?php echo (int)$stats['appointments']; ?>+</strong><span>Appointments</span></div>
            <div class="stat"><strong>15+</strong><span>Years of Care</span></div>
        </div>
    </div>
</section>

<section class="highlight-contact">
    <div class="container">
        <div class="contact-cards">
            <article class="contact-card">
                <h4><i class="fas fa-phone-volume"></i> Emergency Contact</h4>
                <p><a href="tel:<?php echo htmlspecialchars(getSiteSettingValue('clinic_phone', CLINIC_PHONE)); ?>"><?php echo htmlspecialchars(getSiteSettingValue('clinic_phone', CLINIC_PHONE)); ?></a></p>
            </article>
            <article class="contact-card">
                <h4><i class="fas fa-clock"></i> Clinic Hours</h4>
                <p><?php echo htmlspecialchars(getSiteSettingValue('clinic_hours', CLINIC_HOURS)); ?></p>
            </article>
            <article class="contact-card">
                <h4><i class="fas fa-location-dot"></i> Address</h4>
                <p><?php echo htmlspecialchars(getSiteSettingValue('clinic_address', CLINIC_ADDRESS)); ?></p>
            </article>
            <article class="contact-card">
                <h4><i class="fas fa-calendar-check"></i> Need Consultation?</h4>
                <p><a href="../pages/contact.php#appointment-form">Book an appointment today</a></p>
            </article>
        </div>
    </div>
</section>

<?php include_once '../includes/footer.php'; ?>
