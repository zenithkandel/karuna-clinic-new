<?php
$pageTitle = 'Doctors';
include_once '../includes/header.php';

$db = DatabaseHelper::getInstance();
$doctors = $db->getActiveDoctors();
?>

<section class="page-banner"
    style="background-image:url('https://images.unsplash.com/photo-1551076805-e1869033e561?auto=format&fit=crop&w=1700&q=80');">
    <div>
        <h1>Specialists Who Listen and Lead</h1>
        <p>Meet the doctors behind our trusted care outcomes.</p>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="section-head reveal">
            <h2><i class="fas fa-user-doctor"></i> Clinical Team</h2>
            <p>Every consultation combines experience, discipline, and clear communication for patient confidence.</p>
        </div>

        <div class="doctor-grid">
            <?php foreach ($doctors as $doctor): ?>
                <article class="doctor-card reveal">
                    <img src="../assets/images/<?php echo htmlspecialchars($doctor['image'] ?? 'logo.png'); ?>"
                        alt="<?php echo htmlspecialchars($doctor['name'] ?? 'Doctor'); ?>">
                    <div class="doctor-body">
                        <h3><?php echo htmlspecialchars($doctor['name'] ?? 'Doctor'); ?></h3>
                        <p class="doctor-meta"><?php echo htmlspecialchars($doctor['title'] ?? 'Medical Specialist'); ?> |
                            <?php echo htmlspecialchars($doctor['specialization'] ?? 'General Care'); ?>
                        </p>
                        <p><strong><i class="fas fa-graduation-cap"></i> Qualification:</strong>
                            <?php echo htmlspecialchars($doctor['qualification'] ?? 'Not available'); ?></p>
                        <p><strong><i class="fas fa-clock"></i> Experience:</strong>
                            <?php echo isset($doctor['experience_years']) ? (int) $doctor['experience_years'] . ' years' : 'Not specified'; ?>
                        </p>
                        <p><?php echo htmlspecialchars($doctor['bio'] ?? ''); ?></p>
                        <div class="btn-row" style="margin-top: 10px;">
                            <a class="btn btn-accent" href="contact.php#appointment-form"><i
                                    class="fas fa-calendar-plus"></i> Book Consultation</a>
                            <?php if (!empty($doctor['phone'])): ?>
                                <a class="btn btn-outline"
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