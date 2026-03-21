<?php
$pageTitle = 'Home';
include_once 'includes/header.php';

$db = DatabaseHelper::getInstance();
$services = $db->getActiveServices();
$doctors = $db->getActiveDoctors();
$stats = $db->getStats();
$notices = $db->getNotices(true, 6);
$latestNotice = !empty($notices) ? $notices[0] : null;
?>

<section class="hero" style="background-image:url('https://images.unsplash.com/photo-1666214280391-8ff5bd3c0bf0?auto=format&fit=crop&w=1800&q=80');">
    <div class="container">
        <div class="hero-box reveal">
            <p class="hero-kicker">Karuna Swasthya Clinic</p>
            <h1>Calm Spaces. Precise Care. Better Health Journeys.</h1>
            <p>Professional diabetes and general healthcare support with a warm clinical experience designed for trust, clarity, and continuity of care in Pokhara.</p>
            <div class="btn-row">
                <a class="btn btn-accent" href="pages/contact.php#appointment-form"><i class="fas fa-calendar-check"></i> Book Appointment</a>
                <a class="btn btn-outline" href="tel:<?php echo htmlspecialchars(getSiteSettingValue('clinic_phone', CLINIC_PHONE)); ?>"><i class="fas fa-phone"></i> Call Now</a>
            </div>
        </div>
    </div>
</section>

<?php if (!empty($notices)): ?>
<section class="notice-board">
    <div class="container">
        <div class="section-head" style="padding-top: 22px; margin-bottom: 8px;">
            <h2><i class="fas fa-bullhorn"></i> Clinic Notices</h2>
            <p>Latest updates from the clinic desk.</p>
        </div>
        <div class="notice-list">
            <?php foreach ($notices as $notice): ?>
            <article class="notice-card reveal">
                <h4><?php echo htmlspecialchars($notice['title']); ?></h4>
                <p><?php echo htmlspecialchars($notice['description']); ?></p>
                <?php if (!empty($notice['target_url'])): ?>
                <a href="<?php echo htmlspecialchars($notice['target_url']); ?>" target="_blank" rel="noopener">Open Notice <i class="fas fa-arrow-right"></i></a>
                <?php endif; ?>
            </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<section class="section">
    <div class="container">
        <div class="section-head reveal">
            <h2><i class="fas fa-stethoscope"></i> Core Services for Everyday and Long-Term Care</h2>
            <p>Built around consultation quality, timely diagnosis, and practical treatment pathways.</p>
        </div>
        <div class="grid-cards">
            <?php foreach (array_slice($services, 0, 8) as $service): ?>
            <article class="info-card reveal">
                <i class="<?php echo htmlspecialchars($service['icon']); ?>"></i>
                <h3><?php echo htmlspecialchars($service['name']); ?></h3>
                <p><?php echo htmlspecialchars($service['description']); ?></p>
            </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="section" style="padding-top: 0;">
    <div class="container split-story">
        <div class="story-image reveal" style="background-image:url('https://images.unsplash.com/photo-1576091160550-2173dba999ef?auto=format&fit=crop&w=1200&q=80');"></div>
        <article class="story-panel reveal">
            <h2><i class="fas fa-heart-pulse"></i> A Welcoming Clinical Experience</h2>
            <p>Our approach combines medical rigor with communication that patients and families can understand, so treatment decisions feel confident and informed.</p>
            <ul class="story-points">
                <li><i class="fas fa-check"></i> Specialist-led consultation and diabetes follow-up</li>
                <li><i class="fas fa-check"></i> Clear treatment explanation with realistic care plans</li>
                <li><i class="fas fa-check"></i> Preventive guidance for long-term wellbeing</li>
                <li><i class="fas fa-check"></i> Fast communication through phone and appointment desk</li>
            </ul>
            <a class="btn btn-accent" href="pages/about.php"><i class="fas fa-circle-info"></i> Explore Our Story</a>
        </article>
    </div>
</section>

<section class="stats-strip">
    <div class="container">
        <div class="stats-grid">
            <article class="stat reveal"><strong><?php echo (int) $stats['services']; ?>+</strong><span>Active Services</span></article>
            <article class="stat reveal"><strong><?php echo (int) $stats['doctors']; ?>+</strong><span>Specialists</span></article>
            <article class="stat reveal"><strong><?php echo (int) $stats['appointments']; ?>+</strong><span>Appointments</span></article>
            <article class="stat reveal"><strong>24/7</strong><span>Urgent Support</span></article>
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="section-head reveal">
            <h2><i class="fas fa-user-doctor"></i> Meet Our Medical Team</h2>
            <p>Trusted doctors focused on evidence-based and compassionate treatment.</p>
        </div>
        <div class="doctor-grid">
            <?php foreach ($doctors as $doctor): ?>
            <article class="doctor-card reveal">
                <img src="assets/images/<?php echo htmlspecialchars($doctor['image']); ?>" alt="<?php echo htmlspecialchars($doctor['name']); ?>">
                <div class="doctor-body">
                    <h3><?php echo htmlspecialchars($doctor['name']); ?></h3>
                    <p class="doctor-meta"><?php echo htmlspecialchars($doctor['specialization']); ?></p>
                    <p><?php echo htmlspecialchars($doctor['bio']); ?></p>
                    <div class="btn-row" style="margin-top: 10px;">
                        <a class="btn btn-accent" href="pages/contact.php#appointment-form"><i class="fas fa-calendar-plus"></i> Consult</a>
                    </div>
                </div>
            </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="highlight-contact">
    <div class="container">
        <div class="contact-cards">
            <article class="contact-card reveal">
                <h4><i class="fas fa-phone-volume"></i> Priority Phone</h4>
                <p><a href="tel:<?php echo htmlspecialchars(getSiteSettingValue('clinic_phone', CLINIC_PHONE)); ?>"><?php echo htmlspecialchars(getSiteSettingValue('clinic_phone', CLINIC_PHONE)); ?></a></p>
            </article>
            <article class="contact-card reveal">
                <h4><i class="fas fa-phone"></i> Telephone</h4>
                <p><a href="tel:<?php echo htmlspecialchars(getSiteSettingValue('clinic_telephone', CLINIC_TELEPHONE)); ?>"><?php echo htmlspecialchars(getSiteSettingValue('clinic_telephone', CLINIC_TELEPHONE)); ?></a></p>
            </article>
            <article class="contact-card reveal">
                <h4><i class="fas fa-envelope"></i> Email</h4>
                <p><a href="mailto:<?php echo htmlspecialchars(getSiteSettingValue('clinic_email', CLINIC_EMAIL)); ?>"><?php echo htmlspecialchars(getSiteSettingValue('clinic_email', CLINIC_EMAIL)); ?></a></p>
            </article>
            <article class="contact-card reveal">
                <h4><i class="fas fa-location-dot"></i> Visit Us</h4>
                <p><?php echo htmlspecialchars(getSiteSettingValue('clinic_address', CLINIC_ADDRESS)); ?></p>
            </article>
        </div>
    </div>
</section>

<?php if ($latestNotice): ?>
<div class="notice-modal" id="latest-notice-modal" data-notice-id="<?php echo (int) $latestNotice['id']; ?>">
    <div class="notice-modal-card" role="dialog" aria-modal="true" aria-labelledby="latestNoticeTitle">
        <button class="notice-close" type="button" aria-label="Close notice popup" data-notice-close>
            <i class="fas fa-xmark"></i>
        </button>
        <?php if (!empty($latestNotice['image'])): ?>
        <img class="notice-modal-media" src="<?php echo htmlspecialchars($latestNotice['image']); ?>" alt="Latest notice image">
        <?php endif; ?>
        <div class="notice-modal-body">
            <h3 id="latestNoticeTitle"><i class="fas fa-bullhorn"></i> <?php echo htmlspecialchars($latestNotice['title']); ?></h3>
            <p><?php echo htmlspecialchars($latestNotice['description']); ?></p>
            <div class="notice-modal-actions">
                <?php if (!empty($latestNotice['target_url'])): ?>
                <a class="btn btn-accent" href="<?php echo htmlspecialchars($latestNotice['target_url']); ?>" target="_blank" rel="noopener" data-notice-view>
                    <i class="fas fa-arrow-up-right-from-square"></i> Open Notice
                </a>
                <?php endif; ?>
                <button class="btn btn-ghost" type="button" data-notice-close>
                    <i class="fas fa-check"></i> Mark as Seen
                </button>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<?php include_once 'includes/footer.php'; ?>
