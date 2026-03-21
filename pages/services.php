<?php
$pageTitle = 'Services';
include_once '../includes/header.php';

$db = DatabaseHelper::getInstance();
$services = $db->getActiveServices();
?>

<section class="page-banner" style="background-image:url('../assets/images/hero-main.webp');">
    <div>
        <h1>Medical Services</h1>
        <p>Comprehensive treatment and diagnostic support under one clinic.</p>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="section-head">
            <h2><i class="fas fa-stethoscope"></i> What We Provide</h2>
            <p>From diabetes management to diagnostics and rehabilitation, our service catalog is built for practical
                and accessible healthcare.</p>
        </div>

        <div class="grid-cards">
            <?php foreach ($services as $service): ?>
                <article class="info-card">
                    <i class="<?php echo htmlspecialchars($service['icon']); ?>"></i>
                    <h3><?php echo htmlspecialchars($service['name']); ?></h3>
                    <p><?php echo htmlspecialchars($service['description']); ?></p>
                    <a href="../pages/contact.php#appointment-form" style="color: var(--accent); font-weight:700;">Request
                        Appointment <i class="fas fa-arrow-right"></i></a>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="section" style="padding-top: 0;">
    <div class="container media-split">
        <div class="image-pane" style="background-image:url('../assets/images/site1.jpg');"></div>
        <div class="text-pane">
            <h2><i class="fas fa-shield-heart"></i> Why Patients Trust Us</h2>
            <ul>
                <li><i class="fas fa-check"></i> Experienced specialists and ethical care</li>
                <li><i class="fas fa-check"></i> Transparent explanation of diagnosis and treatment</li>
                <li><i class="fas fa-check"></i> Follow-up planning for chronic conditions</li>
                <li><i class="fas fa-check"></i> Convenient support through phone and email</li>
            </ul>
            <a class="btn btn-accent" href="../pages/contact.php"><i class="fas fa-phone"></i> Contact Clinic</a>
        </div>
    </div>
</section>

<?php include_once '../includes/footer.php'; ?>