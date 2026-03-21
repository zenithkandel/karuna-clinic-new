<?php
$pageTitle = 'Services';
include_once '../includes/header.php';

$db = DatabaseHelper::getInstance();
$services = $db->getActiveServices();
?>

<section class="page-banner"
    style="background-image:url('https://images.unsplash.com/photo-1551887373-6ed7c3c6f63d?auto=format&fit=crop&w=1700&q=80');">
    <div>
        <h1>Modern Clinical Services</h1>
        <p>Consultation, diagnostics, and follow-up services tailored for practical outcomes.</p>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="section-head reveal">
            <h2><i class="fas fa-stethoscope"></i> Our Service Portfolio</h2>
            <p>Designed to support acute needs and long-term condition management with a calm and professional clinic
                experience.</p>
        </div>
        <div class="grid-cards">
            <?php foreach ($services as $service): ?>
                <article class="info-card reveal">
                    <i class="<?php echo htmlspecialchars($service['icon']); ?>"></i>
                    <h3><?php echo htmlspecialchars($service['name']); ?></h3>
                    <p><?php echo htmlspecialchars($service['description']); ?></p>
                    <a href="../pages/contact.php#appointment-form" style="color: var(--accent); font-weight: 800;">Request
                        Consultation <i class="fas fa-arrow-right"></i></a>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="section" style="padding-top: 0;">
    <div class="container media-split">
        <div class="image-pane reveal"
            style="background-image:url('https://images.unsplash.com/photo-1516549655169-df83a0774514?auto=format&fit=crop&w=1300&q=80');">
        </div>
        <article class="text-pane reveal">
            <h2><i class="fas fa-shield-heart"></i> Why Patients Return</h2>
            <p>From your first consultation to your follow-up visit, we prioritize clarity and continuity in care.</p>
            <ul>
                <li><i class="fas fa-check"></i> Systematic checkups and specialist referrals</li>
                <li><i class="fas fa-check"></i> Structured guidance for diabetes and lifestyle health</li>
                <li><i class="fas fa-check"></i> Responsive communication with the clinic desk</li>
                <li><i class="fas fa-check"></i> Patient-first appointment experience</li>
            </ul>
            <a class="btn btn-accent" href="../pages/contact.php"><i class="fas fa-phone"></i> Talk to Clinic</a>
        </article>
    </div>
</section>

<?php include_once '../includes/footer.php'; ?>