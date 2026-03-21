<?php
$pageTitle = 'Doctors';
include_once '../includes/header.php';

$db = DatabaseHelper::getInstance();
$doctors = $db->getActiveDoctors();
?>

<section class="page-banner" style="background-image:url('../assets/images/site1.jpg');">
    <div>
        <h1>Meet Our Doctors</h1>
        <p>Qualified professionals committed to accurate treatment and patient trust.</p>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="section-head">
            <h2><i class="fas fa-user-doctor"></i> Clinical Team</h2>
            <p>Our doctors provide specialist-level consultation, guided treatment plans, and patient-focused
                communication.</p>
        </div>

        <div class="doctor-grid">
            <?php foreach ($doctors as $doctor): ?>
                <article class="doctor-card">
                    <img src="../assets/images/<?php echo htmlspecialchars($doctor['image']); ?>"
                        alt="<?php echo htmlspecialchars($doctor['name']); ?>">
                    <div class="doctor-body">
                        <h3><?php echo htmlspecialchars($doctor['name']); ?></h3>
                        <p class="doctor-meta"><?php echo htmlspecialchars($doctor['title']); ?> |
                            <?php echo htmlspecialchars($doctor['specialization']); ?></p>
                        <p><strong><i class="fas fa-graduation-cap"></i> Qualification:</strong>
                            <?php echo htmlspecialchars($doctor['qualification']); ?></p>
                        <p><strong><i class="fas fa-clock"></i> Experience:</strong>
                            <?php echo (int) $doctor['experience_years']; ?> years</p>
                        <p><?php echo htmlspecialchars($doctor['bio']); ?></p>
                        <div class="btn-row" style="margin-top: 10px;">
                            <a class="btn btn-accent" href="../pages/contact.php#appointment-form"><i
                                    class="fas fa-calendar-plus"></i> Book</a>
                            <?php if (!empty($doctor['phone'])): ?>
                                <a class="btn" style="border:1px solid var(--line);"
                                    href="tel:<?php echo htmlspecialchars($doctor['phone']); ?>"><i class="fas fa-phone"></i>
                                    Call</a>
                            <?php endif; ?>
                        </div>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<?php include_once '../includes/footer.php'; ?>