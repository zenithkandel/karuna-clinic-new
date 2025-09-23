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
<section class="py-20 bg-gradient-to-br from-blue-600 to-blue-800 text-white">
    <div class="container mx-auto px-6">
        <div class="text-center animate-fadeInUp">
            <h1 class="text-4xl lg:text-5xl font-bold mb-6">
                <i class="fas fa-stethoscope mr-3"></i>
                Our Medical Services
            </h1>
            <p class="text-xl text-blue-100 max-w-3xl mx-auto mb-8">
                Comprehensive healthcare services with modern facilities and experienced medical professionals dedicated to your well-being.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="../pages/contact.php" class="btn-primary bg-white text-blue-600 hover:bg-gray-100">
                    <i class="fas fa-calendar-plus mr-2"></i>
                    Book Appointment
                </a>
                <a href="../pages/contact.php" class="btn-secondary border-white text-white hover:bg-white hover:text-blue-600">
                    <i class="fas fa-phone mr-2"></i>
                    Call Now
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Services Overview -->
<section class="py-20">
    <div class="container mx-auto px-6">
        <div class="text-center mb-16 animate-on-scroll">
            <h2 class="text-4xl font-bold mb-6 text-gray-800 dark:text-white">
                Why Choose Our Services?
            </h2>
            <p class="text-xl text-gray-600 dark:text-gray-300 max-w-3xl mx-auto">
                We provide quality healthcare services with a patient-centered approach, modern equipment, and affordable pricing.
            </p>
        </div>
        
        <div class="grid md:grid-cols-3 gap-8 mb-16">
            <div class="text-center animate-on-scroll">
                <div class="w-16 h-16 bg-blue-100 dark:bg-blue-900 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-user-md text-2xl text-blue-600 dark:text-blue-400"></i>
                </div>
                <h3 class="text-xl font-bold mb-4 text-gray-800 dark:text-white">Expert Doctors</h3>
                <p class="text-gray-600 dark:text-gray-300">
                    Experienced and qualified medical professionals with years of expertise in their respective fields.
                </p>
            </div>
            
            <div class="text-center animate-on-scroll">
                <div class="w-16 h-16 bg-green-100 dark:bg-green-900 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-microscope text-2xl text-green-600 dark:text-green-400"></i>
                </div>
                <h3 class="text-xl font-bold mb-4 text-gray-800 dark:text-white">Modern Equipment</h3>
                <p class="text-gray-600 dark:text-gray-300">
                    State-of-the-art medical equipment and diagnostic tools for accurate diagnosis and effective treatment.
                </p>
            </div>
            
            <div class="text-center animate-on-scroll">
                <div class="w-16 h-16 bg-purple-100 dark:bg-purple-900 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-heart text-2xl text-purple-600 dark:text-purple-400"></i>
                </div>
                <h3 class="text-xl font-bold mb-4 text-gray-800 dark:text-white">Compassionate Care</h3>
                <p class="text-gray-600 dark:text-gray-300">
                    Patient-centered care with empathy, respect, and dedication to improving your health and well-being.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Services Grid -->
<section class="py-20 bg-gray-50 dark:bg-gray-800">
    <div class="container mx-auto px-6">
        <div class="text-center mb-16 animate-on-scroll">
            <h2 class="text-4xl font-bold mb-6 text-gray-800 dark:text-white">
                <i class="fas fa-hospital mr-3"></i>
                Medical Services We Offer
            </h2>
            <p class="text-xl text-gray-600 dark:text-gray-300">
                Comprehensive healthcare services to meet all your medical needs
            </p>
        </div>
        
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php foreach ($services as $service): ?>
            <div class="service-card animate-on-scroll">
                <div class="text-center">
                    <div class="w-20 h-20 bg-gradient-to-br from-blue-500 to-purple-600 rounded-xl flex items-center justify-center mx-auto mb-6 shadow-lg">
                        <i class="<?php echo htmlspecialchars($service['icon']); ?> text-2xl text-white"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-4 text-gray-800 dark:text-white">
                        <?php echo htmlspecialchars($service['name']); ?>
                    </h3>
                    <p class="text-gray-600 dark:text-gray-300 mb-6 leading-relaxed">
                        <?php echo htmlspecialchars($service['description']); ?>
                    </p>
                    <div class="space-y-3">
                        <a href="../pages/contact.php" class="btn-primary w-full justify-center">
                            <i class="fas fa-calendar-plus mr-2"></i>
                            Book Appointment
                        </a>
                        <button class="btn-secondary w-full justify-center" onclick="showServiceDetails('<?php echo addslashes($service['name']); ?>', '<?php echo addslashes($service['description']); ?>')">
                            <i class="fas fa-info-circle mr-2"></i>
                            Learn More
                        </button>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        
        <?php if (empty($services)): ?>
        <div class="text-center py-12 animate-on-scroll">
            <i class="fas fa-exclamation-circle text-6xl text-gray-400 dark:text-gray-600 mb-6"></i>
            <h3 class="text-2xl font-bold text-gray-600 dark:text-gray-400 mb-4">No Services Available</h3>
            <p class="text-gray-500 dark:text-gray-500">
                Please contact us for information about available medical services.
            </p>
            <a href="../pages/contact.php" class="btn-primary mt-6">
                <i class="fas fa-phone mr-2"></i>
                Contact Us
            </a>
        </div>
        <?php endif; ?>
    </div>
</section>

<!-- Service Statistics -->
<section class="py-20">
    <div class="container mx-auto px-6">
        <div class="text-center mb-12 animate-on-scroll">
            <h2 class="text-3xl font-bold mb-4 text-gray-800 dark:text-white">
                Our Service Impact
            </h2>
            <p class="text-xl text-gray-600 dark:text-gray-300">
                Numbers that reflect our commitment to quality healthcare
            </p>
        </div>
        
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
            <div class="stats-card animate-on-scroll">
                <div class="text-3xl font-bold text-blue-600 mb-2 counter" data-target="<?php echo $stats['services']; ?>">0</div>
                <div class="text-gray-600 dark:text-gray-300 font-medium">Medical Services</div>
            </div>
            <div class="stats-card animate-on-scroll">
                <div class="text-3xl font-bold text-green-600 mb-2 counter" data-target="<?php echo $stats['doctors']; ?>">0</div>
                <div class="text-gray-600 dark:text-gray-300 font-medium">Expert Doctors</div>
            </div>
            <div class="stats-card animate-on-scroll">
                <div class="text-3xl font-bold text-purple-600 mb-2 counter" data-target="<?php echo $stats['appointments']; ?>">0</div>
                <div class="text-gray-600 dark:text-gray-300 font-medium">Appointments Served</div>
            </div>
            <div class="stats-card animate-on-scroll">
                <div class="text-3xl font-bold text-orange-600 mb-2 counter" data-target="15">0</div>
                <div class="text-gray-600 dark:text-gray-300 font-medium">Years Experience</div>
            </div>
        </div>
    </div>
</section>

<!-- Emergency Services -->
<section class="py-20 bg-red-600 text-white">
    <div class="container mx-auto px-6">
        <div class="text-center animate-on-scroll">
            <h2 class="text-4xl font-bold mb-6">
                <i class="fas fa-ambulance mr-3"></i>
                Emergency Services Available
            </h2>
            <p class="text-xl text-red-100 max-w-3xl mx-auto mb-8">
                We provide 24/7 emergency consultation services. For urgent medical situations, contact us immediately.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="tel:+9779766597210" class="btn-primary bg-white text-red-600 hover:bg-gray-100 text-lg px-8 py-4">
                    <i class="fas fa-phone mr-2"></i>
                    Call Emergency: +977 976-659-7210
                </a>
                <a href="../pages/contact.php" class="btn-secondary border-white text-white hover:bg-white hover:text-red-600 text-lg px-8 py-4">
                    <i class="fas fa-envelope mr-2"></i>
                    Send Message
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Call to Action -->
<section class="py-20">
    <div class="container mx-auto px-6">
        <div class="text-center animate-on-scroll">
            <h2 class="text-4xl font-bold mb-6 text-gray-800 dark:text-white">
                Ready to Get Started?
            </h2>
            <p class="text-xl text-gray-600 dark:text-gray-300 max-w-3xl mx-auto mb-8">
                Book your appointment today and experience quality healthcare services at Karuna Swasthya Clinic.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="../pages/contact.php" class="btn-primary text-lg px-8 py-4">
                    <i class="fas fa-calendar-plus mr-2"></i>
                    Book Appointment Now
                </a>
                <a href="../pages/about.php" class="btn-secondary text-lg px-8 py-4">
                    <i class="fas fa-info-circle mr-2"></i>
                    Learn More About Us
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Service Details Modal -->
<div id="serviceModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4" style="display: none;">
    <div class="bg-white dark:bg-gray-800 rounded-2xl max-w-md w-full p-6 shadow-2xl">
        <div class="flex items-center justify-between mb-4">
            <h3 id="modalTitle" class="text-2xl font-bold text-gray-800 dark:text-white"></h3>
            <button onclick="closeServiceModal()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 text-2xl">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <p id="modalDescription" class="text-gray-600 dark:text-gray-300 mb-6 leading-relaxed"></p>
        <div class="flex gap-3">
            <a href="../pages/contact.php" class="btn-primary flex-1 justify-center">
                <i class="fas fa-calendar-plus mr-2"></i>
                Book Now
            </a>
            <button onclick="closeServiceModal()" class="btn-secondary flex-1 justify-center">
                Close
            </button>
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