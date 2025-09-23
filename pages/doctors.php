<?php
/**
 * Doctors Page - Karuna Swasthya Clinic
 * Meet our medical team with detailed doctor profiles
 */

$pageTitle = "Our Doctors";
include_once '../includes/header.php';

// Get doctors from database
require_once '../includes/DatabaseHelper.php';
$db = DatabaseHelper::getInstance();
$doctors = $db->getActiveDoctors();
?>

<!-- Doctors Hero Section -->
<section class="hero hero--green" id="doctors-hero">
    <div class="container">
        <div class="hero-content center">
            <h1 class="hero-title"><i class="fas fa-user-md"></i> Meet Our Medical Team</h1>
            <p class="hero-subtitle max-width-medium">Our experienced and qualified medical professionals are dedicated to providing you with the highest quality healthcare services with compassion and expertise.</p>
            <div class="hero-actions center">
                <a href="../pages/contact.php" class="btn btn-primary"><i class="fas fa-calendar-plus"></i> Book Consultation</a>
            </div>
        </div>
    </div>
</section>

<!-- Doctors Team Introduction -->
<section class="section" id="team-intro">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">Excellence in Medical Care</h2>
            <p class="section-subtitle max-width-medium">At Karuna Swasthya Clinic, our medical team consists of highly qualified doctors with years of experience in their respective specializations. We are committed to providing personalized care and the latest medical treatments to ensure the best outcomes for our patients.</p>
        </div>
        <div class="features-grid">
            <div class="feature-item">
                <div class="feature-icon-circle bg-blue"><i class="fas fa-graduation-cap"></i></div>
                <h3 class="feature-title">Highly Qualified</h3>
                <p class="feature-text">Advanced medical degrees and certifications from recognized institutions.</p>
            </div>
            <div class="feature-item">
                <div class="feature-icon-circle bg-green"><i class="fas fa-award"></i></div>
                <h3 class="feature-title">Experienced</h3>
                <p class="feature-text">Years of practical experience treating complex medical conditions.</p>
            </div>
            <div class="feature-item">
                <div class="feature-icon-circle bg-purple"><i class="fas fa-heart"></i></div>
                <h3 class="feature-title">Compassionate</h3>
                <p class="feature-text">Patient‑centered approach with empathy and dedication.</p>
            </div>
        </div>
    </div>
</section>

<!-- Doctors Profiles -->
<section class="section section-alt" id="doctor-profiles">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title"><i class="fas fa-stethoscope"></i> Our Medical Specialists</h2>
            <p class="section-subtitle">Get to know our dedicated medical professionals</p>
        </div>
        <div class="profiles-list">
            <?php foreach ($doctors as $index => $doctor): $schedule = json_decode($doctor['schedule'], true); $isEven = $index % 2 === 0; ?>
            <article class="doctor-profile-card <?php echo $isEven ? '' : 'reverse'; ?>">
                <div class="doctor-profile-media">
                    <img src="../assets/images/<?php echo htmlspecialchars($doctor['image']); ?>" alt="<?php echo htmlspecialchars($doctor['name']); ?>" class="doctor-image-lg" />
                </div>
                <div class="doctor-details">
                    <header class="doctor-header">
                        <h3 class="doctor-name-large"><?php echo htmlspecialchars($doctor['name']); ?></h3>
                        <p class="doctor-role"><?php echo htmlspecialchars($doctor['title']); ?> &mdash; <?php echo htmlspecialchars($doctor['specialization']); ?></p>
                    </header>
                    <div class="doctor-meta-grid">
                        <div class="meta-block">
                            <h4 class="meta-title"><i class="fas fa-graduation-cap"></i> Qualifications</h4>
                            <p class="meta-text"><?php echo htmlspecialchars($doctor['qualification']); ?></p>
                        </div>
                        <div class="meta-block">
                            <h4 class="meta-title"><i class="fas fa-clock"></i> Experience</h4>
                            <p class="meta-text"><span class="highlight-number"><?php echo isset($doctor['experience_years']) ? $doctor['experience_years'] : 'N/A'; ?></span> years of medical practice</p>
                        </div>
                    </div>
                    <div class="doctor-bio-block">
                        <h4 class="meta-title"><i class="fas fa-info-circle"></i> About Dr. <?php echo explode(' ', $doctor['name'])[count(explode(' ', $doctor['name']))-1]; ?></h4>
                        <p class="meta-text"><?php echo htmlspecialchars($doctor['bio']); ?></p>
                    </div>
                    <?php if ($schedule && is_array($schedule)): ?>
                    <div class="doctor-schedule-block">
                        <h4 class="meta-title"><i class="fas fa-calendar-alt"></i> Available Schedule</h4>
                        <div class="schedule-grid">
                            <?php $days = ['monday' => 'Mon', 'tuesday' => 'Tue', 'wednesday' => 'Wed', 'thursday' => 'Thu', 'friday' => 'Fri', 'saturday' => 'Sat', 'sunday' => 'Sun'];
                            foreach ($days as $day => $shortName): $time = isset($schedule[$day]) ? $schedule[$day] : 'closed'; $isAvailable = $time !== 'closed'; ?>
                            <div class="schedule-day <?php echo $isAvailable ? 'available' : 'closed'; ?>">
                                <span class="day-label"><?php echo $shortName; ?></span>
                                <span class="day-time"><?php echo $isAvailable ? date('g A', strtotime(explode('-', $time)[0])) . '-' . date('g A', strtotime(explode('-', $time)[1])) : 'Closed'; ?></span>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <?php endif; ?>
                    <div class="doctor-contact-links">
                        <?php if (!empty($doctor['phone'])): ?>
                        <a href="tel:<?php echo htmlspecialchars($doctor['phone']); ?>" class="contact-link"><i class="fas fa-phone"></i> <?php echo htmlspecialchars($doctor['phone']); ?></a>
                        <?php endif; ?>
                        <?php if (!empty($doctor['email'])): ?>
                        <a href="mailto:<?php echo htmlspecialchars($doctor['email']); ?>" class="contact-link"><i class="fas fa-envelope"></i> <?php echo htmlspecialchars($doctor['email']); ?></a>
                        <?php endif; ?>
                    </div>
                    <div class="doctor-actions">
                        <a href="../pages/contact.php" class="btn btn-primary"><i class="fas fa-calendar-plus"></i> Book Appointment</a>
                        <button class="btn btn-secondary" onclick="showDoctorDetails('<?php echo addslashes($doctor['name']); ?>', '<?php echo addslashes($doctor['specialization']); ?>', '<?php echo addslashes($doctor['bio']); ?>')"><i class="fas fa-info-circle"></i> More Details</button>
                    </div>
                </div>
            </article>
            <?php endforeach; ?>
        </div>
        <?php if (empty($doctors)): ?>
        <div class="empty-state">
            <div class="empty-icon"><i class="fas fa-user-md"></i></div>
            <h3 class="empty-title">No Doctors Available</h3>
            <p class="empty-text">Please contact us for information about available doctors and appointments.</p>
            <a href="../pages/contact.php" class="btn btn-primary"><i class="fas fa-phone"></i> Contact Us</a>
        </div>
        <?php endif; ?>
    </div>
</section>

<!-- Why Choose Our Doctors -->
<section class="section" id="why-choose-team">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">Why Choose Our Medical Team?</h2>
            <p class="section-subtitle">Our commitment to excellence in healthcare</p>
        </div>
        <div class="features-grid">
            <div class="feature-item">
                <div class="feature-icon-circle bg-blue"><i class="fas fa-certificate"></i></div>
                <h3 class="feature-title">Board Certified</h3>
                <p class="feature-text">Board‑certified professionals with recognized qualifications.</p>
            </div>
            <div class="feature-item">
                <div class="feature-icon-circle bg-green"><i class="fas fa-microscope"></i></div>
                <h3 class="feature-title">Latest Knowledge</h3>
                <p class="feature-text">Up‑to‑date with the latest medical research & treatments.</p>
            </div>
            <div class="feature-item">
                <div class="feature-icon-circle bg-purple"><i class="fas fa-handshake"></i></div>
                <h3 class="feature-title">Patient-Centered</h3>
                <p class="feature-text">Focused on relationships & personalized care.</p>
            </div>
            <div class="feature-item">
                <div class="feature-icon-circle bg-blue"><i class="fas fa-clock"></i></div>
                <h3 class="feature-title">Available</h3>
                <p class="feature-text">Convenient scheduling to meet your needs.</p>
            </div>
        </div>
    </div>
</section>

<!-- Call to Action -->
<section class="cta-section cta-section--accent" id="doctors-cta">
    <div class="container">
        <div class="cta-content">
            <h2 class="cta-title">Ready to Meet Our Doctors?</h2>
            <p class="cta-subtitle">Schedule your consultation today and experience personalized healthcare with our expert medical team.</p>
            <div class="cta-actions">
                <a href="../pages/contact.php" class="btn btn-primary"><i class="fas fa-calendar-plus"></i> Book Appointment</a>
                <a href="tel:+9779766597210" class="btn btn-secondary"><i class="fas fa-phone"></i> Call Now</a>
            </div>
        </div>
    </div>
</section>

<!-- Doctor Details Modal -->
<div id="doctorModal" class="modal-overlay" style="display:none;">
    <div class="modal">
        <div class="modal-header">
            <h3 id="modalDoctorName" class="modal-title"></h3>
            <button onclick="closeDoctorModal()" class="modal-close" aria-label="Close modal"><i class="fas fa-times"></i></button>
        </div>
        <div id="modalDoctorSpecialization" class="meta-text" style="font-weight:600; color: var(--color-primary); margin-bottom: var(--spacing-sm);"></div>
        <div id="modalDoctorBio" class="meta-text" style="margin-bottom: var(--spacing-lg);"></div>
        <div class="modal-actions" style="display:flex; gap: var(--spacing-sm);">
            <a href="../pages/contact.php" class="btn btn-primary" style="flex:1;"><i class="fas fa-calendar-plus"></i> Book Appointment</a>
            <button onclick="closeDoctorModal()" class="btn btn-secondary" style="flex:1;">Close</button>
        </div>
    </div>
</div>

<script>
function showDoctorDetails(name, specialization, bio) {
    const modal = document.getElementById('doctorModal');
    document.getElementById('modalDoctorName').textContent = name;
    document.getElementById('modalDoctorSpecialization').textContent = specialization;
    document.getElementById('modalDoctorBio').textContent = bio;
    modal.style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

function closeDoctorModal() {
    const modal = document.getElementById('doctorModal');
    modal.style.display = 'none';
    document.body.style.overflow = '';
}

document.getElementById('doctorModal').addEventListener('click', (e) => {
    if (e.target.id === 'doctorModal') closeDoctorModal();
});

document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') closeDoctorModal();
});
</script>

<?php include_once '../includes/footer.php'; ?>