<?php
$pageTitle = 'About Us';
include_once '../includes/header.php';

$db = DatabaseHelper::getInstance();
$stats = $db->getStats();
?>

<section class="page-banner"
    style="background-image:url('https://images.unsplash.com/photo-1579684385127-1ef15d508118?auto=format&fit=crop&w=1700&q=80');">
    <div>
        <h1>Care That Feels Human and Clinical</h1>
        <p>Karuna Swasthya Clinic blends calm surroundings, specialist insight, and practical treatment planning.</p>
    </div>
</section>

<section class="section">
    <div class="container split-story">
        <div class="story-image reveal"
            style="background-image:url('https://images.unsplash.com/photo-1559839734-2b71ea197ec2?auto=format&fit=crop&w=1200&q=80');">
        </div>
        <article class="story-panel reveal">
            <h2><i class="fas fa-bullseye"></i> Mission and Vision</h2>
            <p>We are dedicated to accessible, dependable healthcare with special attention to diabetes care, orthopedic
                concerns, preventive guidance, and patient education.</p>
            <ul class="story-points">
                <li><i class="fas fa-check"></i> Clear communication before and after consultation</li>
                <li><i class="fas fa-check"></i> Diagnosis-first approach with realistic treatment goals</li>
                <li><i class="fas fa-check"></i> Respectful care for all age groups and families</li>
                <li><i class="fas fa-check"></i> Continuous follow-up for chronic and lifestyle conditions</li>
            </ul>
            <a class="btn btn-accent" href="../pages/contact.php#appointment-form"><i class="fas fa-calendar-check"></i>
                Schedule Visit</a>
        </article>
    </div>
</section>

<section class="stats-strip">
    <div class="container">
        <div class="stats-grid">
            <article class="stat reveal"><strong><?php echo (int) $stats['services']; ?>+</strong><span>Service
                    Streams</span></article>
            <article class="stat reveal">
                <strong><?php echo (int) $stats['doctors']; ?>+</strong><span>Consultants</span></article>
            <article class="stat reveal"><strong><?php echo (int) $stats['appointments']; ?>+</strong><span>Patient
                    Visits</span></article>
            <article class="stat reveal"><strong>15+</strong><span>Years in Practice</span></article>
        </div>
    </div>
</section>

<section class="highlight-contact">
    <div class="container">
        <div class="contact-cards">
            <article class="contact-card reveal">
                <h4><i class="fas fa-phone-volume"></i> Emergency Phone</h4>
                <p><a
                        href="tel:<?php echo htmlspecialchars(getSiteSettingValue('clinic_phone', CLINIC_PHONE)); ?>"><?php echo htmlspecialchars(getSiteSettingValue('clinic_phone', CLINIC_PHONE)); ?></a>
                </p>
            </article>
            <article class="contact-card reveal">
                <h4><i class="fas fa-clock"></i> Clinic Hours</h4>
                <p><?php echo htmlspecialchars(getSiteSettingValue('clinic_hours', CLINIC_HOURS)); ?></p>
            </article>
            <article class="contact-card reveal">
                <h4><i class="fas fa-location-dot"></i> Location</h4>
                <p><?php echo htmlspecialchars(getSiteSettingValue('clinic_address', CLINIC_ADDRESS)); ?></p>
            </article>
            <article class="contact-card reveal">
                <h4><i class="fas fa-envelope"></i> Email Desk</h4>
                <p><a
                        href="mailto:<?php echo htmlspecialchars(getSiteSettingValue('clinic_email', CLINIC_EMAIL)); ?>"><?php echo htmlspecialchars(getSiteSettingValue('clinic_email', CLINIC_EMAIL)); ?></a>
                </p>
            </article>
        </div>
    </div>
</section>

<?php include_once '../includes/footer.php'; ?>