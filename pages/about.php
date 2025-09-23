<?php
/**
 * About Page - Karuna Swasthya Clinic
 * Information about the clinic, doctors, and services
 */

$pageTitle = "About Us";
include_once '../includes/header.php';

// Get dynamic content from database
require_once '../includes/DatabaseHelper.php';
$db = DatabaseHelper::getInstance();
$doctors = $db->getActiveDoctors();
$stats = $db->getStats();
?>

<!-- About Hero Section -->
<section class="hero hero--green" id="about-hero">
    <div class="container">
        <div class="hero-content center">
            <h1 class="hero-title"><i class="fas fa-info-circle"></i> About Us</h1>
            <p class="hero-subtitle max-width-medium">Dedicated to providing quality healthcare services with compassionate care and modern medical facilities in Pokhara.</p>
        </div>
    </div>
</section>

<!-- About Content -->
<section class="section" id="mission-vision">
    <div class="container">
        <div class="about-content">
            <div class="about-image">
                <img src="../assets/images/site1.jpg" alt="About Karuna Clinic" class="about-img" />
            </div>
            <div class="about-text">
                <h2 class="about-title">Our Mission & Vision</h2>
                <p class="about-description"><?php echo SITE_NAME; ?> is committed to providing comprehensive healthcare services with a focus on diabetes management, orthopedic problems, and general medical care. Our experienced team of medical professionals is dedicated to providing quality healthcare services at affordable prices.</p>
                <div class="about-features">
                    <div class="feature-item minimal left">
                        <i class="fas fa-check-circle feature-icon"></i>
                        <span class="feature-text">Expert Medical Care</span>
                    </div>
                    <div class="feature-item minimal left">
                        <i class="fas fa-check-circle feature-icon"></i>
                        <span class="feature-text">Modern Facilities</span>
                    </div>
                    <div class="feature-item minimal left">
                        <i class="fas fa-check-circle feature-icon"></i>
                        <span class="feature-text">Affordable Healthcare</span>
                    </div>
                    <div class="feature-item minimal left">
                        <i class="fas fa-check-circle feature-icon"></i>
                        <span class="feature-text">Patient-Centered Care</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Statistics Section -->
<section class="section section-alt" id="impact-numbers">
    <div class="container">
        <div class="section-header small">
            <h2 class="section-title">Our Impact in Numbers</h2>
            <p class="section-subtitle">Serving the Pokhara community with dedication and excellence</p>
        </div>
        <div class="stats-grid">
            <div class="stats-card"><div class="stats-number stats-blue"><?php echo $stats['services']; ?>+</div><div class="stats-label">Medical Services</div></div>
            <div class="stats-card"><div class="stats-number stats-green"><?php echo $stats['doctors']; ?>+</div><div class="stats-label">Expert Doctors</div></div>
            <div class="stats-card"><div class="stats-number stats-purple"><?php echo $stats['appointments']; ?>+</div><div class="stats-label">Appointments Served</div></div>
            <div class="stats-card"><div class="stats-number stats-orange">15+</div><div class="stats-label">Years Experience</div></div>
        </div>
    </div>
</section>

<!-- Our Doctors Section -->
<section class="section" id="about-team">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title"><i class="fas fa-user-md"></i> Meet Our Medical Team</h2>
            <p class="section-subtitle">Experienced and qualified medical professionals dedicated to your health</p>
        </div>
        <div class="doctors-grid">
            <?php foreach ($doctors as $doctor): $schedule = json_decode($doctor['schedule'], true); ?>
            <div class="doctor-card">
                <div class="doctor-image-container">
                    <img src="../assets/images/<?php echo htmlspecialchars($doctor['image']); ?>" alt="<?php echo htmlspecialchars($doctor['name']); ?>" class="doctor-image" />
                </div>
                <div class="doctor-info">
                    <h3 class="doctor-name"><?php echo htmlspecialchars($doctor['name']); ?></h3>
                    <p class="doctor-specialization"><?php echo htmlspecialchars($doctor['title']); ?> - <?php echo htmlspecialchars($doctor['specialization']); ?></p>
                    <p class="doctor-bio"><?php echo htmlspecialchars($doctor['bio']); ?></p>
                    <div class="doctor-schedule"><i class="fas fa-clock"></i> Experience: <?php echo isset($doctor['experience_years']) ? $doctor['experience_years'] : 'N/A'; ?> years</div>
                    <div class="section-cta" style="margin-top: var(--spacing-lg); text-align:left;">
                        <a href="../pages/contact.php" class="btn btn-primary"><i class="fas fa-calendar-plus"></i> Book Appointment</a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Why Choose Us -->
<section class="cta-section" id="why-choose">
    <div class="container">
        <div class="cta-content">
            <h2 class="cta-title">Why Choose Karuna Swasthya Clinic?</h2>
            <p class="cta-subtitle">We are committed to providing the best healthcare experience for our patients</p>
            <div class="features-grid">
                <div class="feature-item">
                    <div class="feature-icon-circle bg-purple"><i class="fas fa-heart"></i></div>
                    <h3 class="feature-title">Compassionate Care</h3>
                    <p class="feature-text">We treat every patient with dignity, respect, and genuine concern.</p>
                </div>
                <div class="feature-item">
                    <div class="feature-icon-circle bg-blue"><i class="fas fa-microscope"></i></div>
                    <h3 class="feature-title">Advanced Technology</h3>
                    <p class="feature-text">Modern diagnostic tools for accurate diagnosis and treatment.</p>
                </div>
                <div class="feature-item">
                    <div class="feature-icon-circle bg-green"><i class="fas fa-clock"></i></div>
                    <h3 class="feature-title">Convenient Hours</h3>
                    <p class="feature-text">Extended hours and emergency services when you need us most.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include_once '../includes/footer.php'; ?>