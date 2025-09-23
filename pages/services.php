<?php
/**
 * Services Page - Karuna Swasthya Clinic
 * Complete list of medical services offered by the clinic
 */

$pageTitle = "Our Services";
include_once '../includes/header.php';

// Get services from database
require_once '../includes/DatabaseHelper.php';
$db = DatabaseHelper::getInstance();
$services = $db->getActiveServices();
$stats = $db->getStats();
?>

<!-- Services Hero Section -->
<section class="hero hero--blue" id="services-hero">
    <div class="container">
        <div class="hero-content center">
            <h1 class="hero-title"><i class="fas fa-stethoscope"></i> Our Medical Services</h1>
            <p class="hero-subtitle max-width-medium">Comprehensive healthcare services with modern facilities and experienced medical professionals dedicated to your well-being.</p>
            <div class="hero-actions">
                <a href="../pages/contact.php" class="btn btn-white">
                    <i class="fas fa-calendar-plus"></i>
                    Book Appointment
                </a>
                <a href="../pages/contact.php" class="btn btn-outline-white">
                    <i class="fas fa-phone"></i>
                    Call Now
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Services Overview -->
<section class="section" id="services-overview">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">Why Choose Our Services?</h2>
            <p class="section-subtitle">We provide quality healthcare services with a patient-centered approach, modern equipment, and affordable pricing.</p>
        </div>
        <div class="features-grid">
            <div class="feature-item">
                <div class="feature-icon-circle bg-blue"><i class="fas fa-user-md"></i></div>
                <h3 class="feature-title">Expert Doctors</h3>
                <p class="feature-text">Experienced and qualified medical professionals with years of expertise in their respective fields.</p>
            </div>
            <div class="feature-item">
                <div class="feature-icon-circle bg-green"><i class="fas fa-microscope"></i></div>
                <h3 class="feature-title">Modern Equipment</h3>
                <p class="feature-text">State-of-the-art medical equipment and diagnostic tools for accurate diagnosis and effective treatment.</p>
            </div>
            <div class="feature-item">
                <div class="feature-icon-circle bg-purple"><i class="fas fa-heart"></i></div>
                <h3 class="feature-title">Compassionate Care</h3>
                <p class="feature-text">Patient-centered care with empathy, respect, and dedication to improving your health and well-being.</p>
            </div>
        </div>
    </div>
</section>

<!-- Services Grid -->
<section class="section section-alt" id="services-list">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title"><i class="fas fa-hospital"></i> Medical Services We Offer</h2>
            <p class="section-subtitle">Comprehensive healthcare services to meet all your medical needs</p>
        </div>
        <div class="services-grid large">
            <?php foreach ($services as $service): ?>
            <div class="service-card service-card-large">
                <div class="service-icon-circle gradient-blue">
                    <i class="<?php echo htmlspecialchars($service['icon']); ?>"></i>
                </div>
                <h3 class="card-title"><?php echo htmlspecialchars($service['name']); ?></h3>
                <p class="card-content"><?php echo htmlspecialchars($service['description']); ?></p>
                <div class="card-actions vertical">
                    <a href="../pages/contact.php" class="btn btn-primary full">
                        <i class="fas fa-calendar-plus"></i>
                        Book Appointment
                    </a>
                    <button class="btn btn-outline full" onclick="showServiceDetails('<?php echo addslashes($service['name']); ?>', '<?php echo addslashes($service['description']); ?>')">
                        <i class="fas fa-info-circle"></i>
                        Learn More
                    </button>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php if (empty($services)): ?>
            <div class="empty-state">
                <div class="empty-icon"><i class="fas fa-exclamation-circle"></i></div>
                <h3 class="empty-title">No Services Available</h3>
                <p class="empty-text">Please contact us for information about available medical services.</p>
                <a href="../pages/contact.php" class="btn btn-primary">
                    <i class="fas fa-phone"></i>
                    Contact Us
                </a>
            </div>
        <?php endif; ?>
    </div>
</section>

<!-- Service Statistics -->
<section class="section" id="service-impact">
    <div class="container">
        <div class="section-header small">
            <h2 class="section-title">Our Service Impact</h2>
            <p class="section-subtitle">Numbers that reflect our commitment to quality healthcare</p>
        </div>
        <div class="stats-grid">
            <div class="stats-card"><div class="stats-number stats-blue counter" data-target="<?php echo $stats['services']; ?>">0</div><div class="stats-label">Medical Services</div></div>
            <div class="stats-card"><div class="stats-number stats-green counter" data-target="<?php echo $stats['doctors']; ?>">0</div><div class="stats-label">Expert Doctors</div></div>
            <div class="stats-card"><div class="stats-number stats-purple counter" data-target="<?php echo $stats['appointments']; ?>">0</div><div class="stats-label">Appointments Served</div></div>
            <div class="stats-card"><div class="stats-number stats-orange counter" data-target="15">0</div><div class="stats-label">Years Experience</div></div>
        </div>
    </div>
</section>

<!-- Emergency Services -->
<section class="cta-section cta-section--danger">
    <div class="container">
        <div class="cta-content">
            <h2 class="cta-title"><i class="fas fa-ambulance"></i> Emergency Services Available</h2>
            <p class="cta-subtitle">We provide 24/7 emergency consultation services. For urgent medical situations, contact us immediately.</p>
            <div class="cta-buttons">
                <a href="tel:+9779766597210" class="btn btn-white">
                    <i class="fas fa-phone"></i>
                    Call Emergency: +977 976-659-7210
                </a>
                <a href="../pages/contact.php" class="btn btn-outline-white">
                    <i class="fas fa-envelope"></i>
                    Send Message
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Call to Action -->
<section class="section" id="services-final-cta">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">Ready to Get Started?</h2>
            <p class="section-subtitle">Book your appointment today and experience quality healthcare services at Karuna Swasthya Clinic.</p>
            <div class="hero-actions center">
                <a href="../pages/contact.php" class="btn btn-primary">
                    <i class="fas fa-calendar-plus"></i>
                    Book Appointment Now
                </a>
                <a href="../pages/about.php" class="btn btn-secondary">
                    <i class="fas fa-info-circle"></i>
                    Learn More About Us
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Service Details Modal -->
<div id="serviceModal" class="modal-overlay" style="display:none;">
    <div class="modal modal-sm">
        <div class="modal-header">
            <h3 id="modalTitle" class="modal-title"></h3>
            <button onclick="closeServiceModal()" class="modal-close" aria-label="Close service details"><i class="fas fa-times"></i></button>
        </div>
        <div class="modal-body">
            <p id="modalDescription" class="modal-text"></p>
        </div>
        <div class="modal-footer">
            <a href="../pages/contact.php" class="btn btn-primary">
                <i class="fas fa-calendar-plus"></i>
                Book Now
            </a>
            <button onclick="closeServiceModal()" class="btn btn-outline">Close</button>
        </div>
    </div>
</div>

<script>
function showServiceDetails(title, description) {
    document.getElementById('modalTitle').textContent = title;
    document.getElementById('modalDescription').textContent = description;
    document.getElementById('serviceModal').style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

function closeServiceModal() {
    document.getElementById('serviceModal').style.display = 'none';
    document.body.style.overflow = 'auto';
}

// Close modal on outside click
document.getElementById('serviceModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeServiceModal();
    }
});

// Close modal on escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeServiceModal();
    }
});
</script>

<?php include_once '../includes/footer.php'; ?>