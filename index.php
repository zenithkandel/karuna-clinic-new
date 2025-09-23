<?php
/**
 * Homepage - Karuna Swasthya Clinic
 * Main landing page with hero section, services, and contact information
 */

$pageTitle = "Home";
include_once 'includes/header.php';

// Get dynamic content from database
require_once 'includes/DatabaseHelper.php';
$db = DatabaseHelper::getInstance();

// Check if database is set up
if (!$db->isDatabaseSetup()) {
    echo '<div class="alert alert-warning">Database not set up. Please run the setup script.</div>';
}

$services = $db->getActiveServices();
$doctors = $db->getActiveDoctors();
$stats = $db->getStats();
?>

<!-- Hero Section -->
<section class="hero">
    <div class="container">
        <div class="hero-content">
            <!-- Hero Text -->
            <div class="hero-text">
                <h1 class="hero-title">
                    <?php echo SITE_NAME; ?>
                </h1>
                <p class="hero-subtitle">
                    Experience professional healthcare and diabetes treatment from expert medical professionals in the heart of Pokhara.
                </p>
                
                <div class="hero-buttons">
                    <a href="pages/contact.php" class="btn btn-primary btn-lg">
                        <i class="fas fa-calendar-check"></i>
                        Book Appointment
                    </a>
                    <a href="tel:<?php echo CLINIC_PHONE; ?>" class="btn btn-outline btn-lg hero-call-btn">
                        <i class="fas fa-phone"></i>
                        Call Now
                    </a>
                </div>
                
                <!-- Quick Info -->
                <div class="hero-info">
                    <div class="hero-info-item">
                        <i class="fas fa-clock"></i>
                        <span><?php echo CLINIC_HOURS; ?></span>
                    </div>
                    <div class="hero-info-item">
                        <i class="fas fa-map-marker-alt"></i>
                        <span>Pokhara, Kaski</span>
                    </div>
                </div>
            </div>
            
            <!-- Hero Image -->
            <div class="hero-image">
                <img src="assets/images/hero-main.webp" 
                     alt="Karuna Clinic Healthcare" 
                     class="hero-img">
            </div>
        </div>
    </div>
</section>

<!-- Services Section -->
<section class="section section-alt" id="services">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">
                <i class="fas fa-stethoscope"></i>
                Our Medical Services
            </h2>
            <p class="section-subtitle">
                Comprehensive healthcare services with modern facilities and experienced medical professionals
            </p>
        </div>
        
        <div class="services-grid">
            <?php foreach (array_slice($services, 0, 4) as $service): ?>
            <div class="service-card">
                <div class="service-icon">
                    <i class="<?php echo htmlspecialchars($service['icon']); ?>"></i>
                </div>
                <h3 class="card-title">
                    <?php echo htmlspecialchars($service['name']); ?>
                </h3>
                <p class="card-content">
                    <?php echo htmlspecialchars($service['description']); ?>
                </p>
            </div>
            <?php endforeach; ?>
        </div>
        
        <!-- Additional Services -->
        <div class="additional-services">
            <h3 class="additional-services-title">Specialized Care</h3>
            <div class="service-tags">
                <?php foreach (array_slice($services, 4) as $service): ?>
                <span class="service-tag">
                    <i class="<?php echo htmlspecialchars($service['icon']); ?>"></i>
                    <?php echo htmlspecialchars($service['name']); ?>
                </span>
                <?php endforeach; ?>
            </div>
        </div>
        
        <!-- Statistics -->
        <div class="stats-section">
            <div class="stats-grid">
                <div class="stats-card">
                    <div class="stats-number stats-blue"><?php echo $stats['services']; ?></div>
                    <div class="stats-label">Services</div>
                </div>
                <div class="stats-card">
                    <div class="stats-number stats-green"><?php echo $stats['doctors']; ?></div>
                    <div class="stats-label">Expert Doctors</div>
                </div>
                <div class="stats-card">
                    <div class="stats-number stats-purple"><?php echo $stats['appointments']; ?></div>
                    <div class="stats-label">Appointments</div>
                </div>
                <div class="stats-card">
                    <div class="stats-number stats-orange">24/7</div>
                    <div class="stats-label">Emergency Care</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- About Section -->
<section class="section" id="about">
    <div class="container">
        <div class="about-content">
            <!-- About Image -->
            <div class="about-image">
                <img src="assets/images/site1.jpg" 
                     alt="About Karuna Clinic" 
                     class="about-img">
            </div>
            
            <!-- About Content -->
            <div class="about-text">
                <h2 class="about-title">
                    About <?php echo SITE_NAME; ?>
                </h2>
                <p class="about-description">
                    We provide comprehensive healthcare services focusing on diabetes management, orthopedic problems, 
                    and general medical care. Our experienced team of medical professionals is dedicated to providing 
                    quality healthcare services at affordable prices.
                </p>
                
                <!-- Key Features -->
                <div class="about-features">
                    <div class="feature-item">
                        <i class="fas fa-check-circle feature-icon"></i>
                        <span class="feature-text">Expert Medical Professionals</span>
                    </div>
                    <div class="feature-item">
                        <i class="fas fa-check-circle feature-icon"></i>
                        <span class="feature-text">Modern Medical Equipment</span>
                    </div>
                    <div class="feature-item">
                        <i class="fas fa-check-circle feature-icon"></i>
                        <span class="feature-text">Affordable Healthcare</span>
                    </div>
                    <div class="feature-item">
                        <i class="fas fa-check-circle feature-icon"></i>
                        <span class="feature-text">24/7 Emergency Support</span>
                    </div>
                </div>
                
                <a href="pages/about.php" class="btn btn-primary">
                    <i class="fas fa-info-circle"></i>
                    Learn More About Us
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Doctors Section -->
<section class="section section-alt" id="doctors">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">
                <i class="fas fa-user-md"></i>
                Our Medical Team
            </h2>
            <p class="section-subtitle">
                Experienced and qualified medical professionals dedicated to your health
            </p>
        </div>
        
        <div class="doctors-grid">
            <?php foreach ($doctors as $doctor): 
                $schedule = json_decode($doctor['schedule'], true);
                $workingDays = [];
                foreach ($schedule as $day => $hours) {
                    if ($hours !== 'closed') {
                        $workingDays[] = ucfirst($day);
                    }
                }
                $scheduleText = !empty($workingDays) ? implode('-', array_slice($workingDays, 0, 2)) : 'Available';
            ?>
            <div class="doctor-card">
                <div class="doctor-image-container">
                    <img src="assets/images/<?php echo htmlspecialchars($doctor['image']); ?>" 
                         alt="<?php echo htmlspecialchars($doctor['name']); ?>" 
                         class="doctor-image">
                </div>
                <div class="doctor-info">
                    <h3 class="doctor-name">
                        <?php echo htmlspecialchars($doctor['name']); ?>
                    </h3>
                    <p class="doctor-specialization">
                        <?php echo htmlspecialchars($doctor['specialization']); ?>
                    </p>
                    <p class="doctor-bio">
                        <?php echo htmlspecialchars($doctor['bio']); ?>
                    </p>
                    <div class="doctor-schedule">
                        <i class="fas fa-calendar"></i>
                        Available: <?php echo $scheduleText; ?>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        
        <div class="section-cta">
            <a href="pages/doctors.php" class="btn btn-primary">
                <i class="fas fa-users"></i>
                View All Doctors
            </a>
        </div>
    </div>
</section>

<!-- Contact CTA Section -->
<section class="cta-section">
    <div class="container">
        <div class="cta-content">
            <h2 class="cta-title">
                Ready to Take Care of Your Health?
            </h2>
            <p class="cta-subtitle">
                Book an appointment today and experience quality healthcare from our expert medical team.
            </p>
            
            <div class="cta-buttons">
                <a href="pages/contact.php" class="btn btn-white">
                    <i class="fas fa-calendar-check"></i>
                    Book Appointment
                </a>
                <a href="tel:<?php echo CLINIC_PHONE; ?>" class="btn btn-outline-white">
                    <i class="fas fa-phone"></i>
                    <?php echo formatPhone(CLINIC_PHONE); ?>
                </a>
            </div>
        </div>
    </div>
</section>

<?php include_once 'includes/footer.php'; ?>