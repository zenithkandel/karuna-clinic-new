<?php
$pageTitle = 'Home';
include_once 'includes/header.php';

$db = DatabaseHelper::getInstance();
$services = $db->getActiveServices();
$doctors = $db->getActiveDoctors();
$stats = $db->getStats();
$notices = $db->getNotices(true, 6);
?>

<section class="hero" style="background-image:url('assets/images/hero-main.webp');">
    <div class="container">
        <div class="hero-box">
            <h1>Karuna Swasthya Clinic and Diabetes Center</h1>
            <p>Evidence-based healthcare with experienced doctors for diabetes, orthopedic conditions, and general
                medical concerns in Pokhara.</p>
            <div class="btn-row">
                <a class="btn btn-accent" href="pages/contact.php#appointment-form"><i
                        class="fas fa-calendar-check"></i> Book Appointment</a>
                <a class="btn btn-outline"
                    href="tel:<?php echo htmlspecialchars(getSiteSettingValue('clinic_phone', CLINIC_PHONE)); ?>"><i
                        class="fas fa-phone"></i> Call Now</a>
            </div>
        </div>
    </div>
</section>

<?php if (!empty($notices)): ?>
    <section class="notice-board">
        <div class="container">
            <div class="section-head" style="padding-top:24px; margin-bottom: 0;">
                <h2><i class="fas fa-bullhorn"></i> Clinic Notices</h2>
            </div>
            <div class="notice-list">
                <?php foreach ($notices as $notice): ?>
                    <article class="notice-card">
                        <h4><?php echo htmlspecialchars($notice['title']); ?></h4>
                        <p><?php echo htmlspecialchars($notice['description']); ?></p>
                        <?php if (!empty($notice['target_url'])): ?>
                            <a href="<?php echo htmlspecialchars($notice['target_url']); ?>" target="_blank" rel="noopener">Open
                                Notice Link <i class="fas fa-arrow-right"></i></a>
                        <?php endif; ?>
                    </article>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
<?php endif; ?>

<section class="section">
    <div class="container">
        <div class="section-head">
            <h2><i class="fas fa-hospital"></i> Core Services</h2>
            <p>Clinical services designed around practical diagnosis, treatment, and follow-up support.</p>
        </div>
        <div class="grid-cards">
            <?php foreach (array_slice($services, 0, 6) as $service): ?>
                <article class="info-card">
                    <i class="<?php echo htmlspecialchars($service['icon']); ?>"></i>
                    <h3><?php echo htmlspecialchars($service['name']); ?></h3>
                    <p><?php echo htmlspecialchars($service['description']); ?></p>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="stats-strip">
    <div class="container">
        <div class="stats-grid">
            <div class="stat"><strong><?php echo (int) $stats['services']; ?>+</strong><span>Active Services</span></div>
            <div class="stat"><strong><?php echo (int) $stats['doctors']; ?>+</strong><span>Specialists</span></div>
            <div class="stat"><strong><?php echo (int) $stats['appointments']; ?>+</strong><span>Appointments</span>
            </div>
            <div class="stat"><strong>24/7</strong><span>Urgent Support</span></div>
        </div>
    </div>
</section>

<section class="section">
    <div class="container media-split">
        <div class="image-pane" style="background-image:url('assets/images/site1.jpg');"></div>
        <div class="text-pane">
            <h2><i class="fas fa-heart-pulse"></i> Focused, Reliable Care</h2>
            <p>We provide comprehensive care for diabetes management, orthopedic problems, and day-to-day medical needs
                under one clinic roof.</p>
            <ul>
                <li><i class="fas fa-check"></i> Professor-level consultation and follow-up</li>
                <li><i class="fas fa-check"></i> Supportive patient communication and health counseling</li>
                <li><i class="fas fa-check"></i> Practical treatment planning with clear steps</li>
                <li><i class="fas fa-check"></i> Accessible location in Pokhara for routine visits</li>
            </ul>
            <a class="btn btn-accent" href="pages/about.php"><i class="fas fa-circle-info"></i> Learn More</a>
        </div>
    </div>
</section>

<section class="section" style="padding-top: 0;">
    <div class="container">
        <div class="section-head">
            <h2><i class="fas fa-user-doctor"></i> Our Doctors</h2>
            <p>Dedicated specialists committed to accurate diagnosis and respectful care.</p>
        </div>
        <div class="doctor-grid">
            <?php foreach ($doctors as $doctor): ?>
                <article class="doctor-card">
                    <img src="assets/images/<?php echo htmlspecialchars($doctor['image']); ?>"
                        alt="<?php echo htmlspecialchars($doctor['name']); ?>">
                    <div class="doctor-body">
                        <h3><?php echo htmlspecialchars($doctor['name']); ?></h3>
                        <p class="doctor-meta"><?php echo htmlspecialchars($doctor['specialization']); ?></p>
                        <p><?php echo htmlspecialchars($doctor['bio']); ?></p>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="highlight-contact">
    <div class="container">
        <div class="contact-cards">
            <article class="contact-card">
                <h4><i class="fas fa-phone-volume"></i> Immediate Call</h4>
                <p><a
                        href="tel:<?php echo htmlspecialchars(getSiteSettingValue('clinic_phone', CLINIC_PHONE)); ?>"><?php echo htmlspecialchars(getSiteSettingValue('clinic_phone', CLINIC_PHONE)); ?></a>
                </p>
            </article>
            <article class="contact-card">
                <h4><i class="fas fa-phone"></i> Telephone</h4>
                <p><a
                        href="tel:<?php echo htmlspecialchars(getSiteSettingValue('clinic_telephone', CLINIC_TELEPHONE)); ?>"><?php echo htmlspecialchars(getSiteSettingValue('clinic_telephone', CLINIC_TELEPHONE)); ?></a>
                </p>
            </article>
            <article class="contact-card">
                <h4><i class="fas fa-envelope"></i> Email</h4>
                <p><a
                        href="mailto:<?php echo htmlspecialchars(getSiteSettingValue('clinic_email', CLINIC_EMAIL)); ?>"><?php echo htmlspecialchars(getSiteSettingValue('clinic_email', CLINIC_EMAIL)); ?></a>
                </p>
            </article>
            <article class="contact-card">
                <h4><i class="fas fa-location-dot"></i> Visit Clinic</h4>
                <p><?php echo htmlspecialchars(getSiteSettingValue('clinic_address', CLINIC_ADDRESS)); ?></p>
            </article>
        </div>
    </div>
</section>

<?php include_once 'includes/footer.php'; ?>