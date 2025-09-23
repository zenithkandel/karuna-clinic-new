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
<section class="hero-section">
    <div class="container mx-auto px-6 relative z-10">
        <div class="flex items-center justify-between flex-col lg:flex-row">
            <!-- Hero Content -->
            <div class="lg:w-1/2 animate-fadeInLeft">
                <h1 class="text-4xl lg:text-6xl font-bold text-white mb-6 leading-tight">
                    <?php echo SITE_NAME; ?>
                </h1>
                <p class="text-xl text-white/90 mb-8 leading-relaxed">
                    Experience professional healthcare and diabetes treatment from expert medical professionals in the heart of Pokhara.
                </p>
                
                <div class="flex flex-col sm:flex-row gap-4 mb-8">
                    <a href="pages/contact.php" class="btn-primary text-lg px-8 py-4">
                        <i class="fas fa-calendar-check mr-2"></i>
                        Book Appointment
                    </a>
                    <a href="tel:<?php echo CLINIC_PHONE; ?>" class="btn-secondary text-lg px-8 py-4 bg-white/10 border-white text-white hover:bg-white hover:text-blue-600">
                        <i class="fas fa-phone mr-2"></i>
                        Call Now
                    </a>
                </div>
                
                <!-- Quick Info -->
                <div class="flex flex-col sm:flex-row gap-6 text-white/80">
                    <div class="flex items-center">
                        <i class="fas fa-clock mr-2 text-blue-300"></i>
                        <span><?php echo CLINIC_HOURS; ?></span>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-map-marker-alt mr-2 text-blue-300"></i>
                        <span>Pokhara, Kaski</span>
                    </div>
                </div>
            </div>
            
            <!-- Hero Image -->
            <div class="lg:w-1/2 mt-12 lg:mt-0 animate-fadeInRight">
                <img src="assets/images/hero-main.webp" 
                     alt="Karuna Clinic Healthcare" 
                     class="w-full h-auto rounded-2xl shadow-2xl animate-float">
            </div>
        </div>
    </div>
</section>

<!-- Services Section -->
<section class="py-20 bg-gray-50 dark:bg-gray-800" id="services">
    <div class="container mx-auto px-6">
        <div class="text-center mb-16 animate-on-scroll">
            <h2 class="text-4xl font-bold mb-4 text-gray-800 dark:text-white">
                <i class="fas fa-stethoscope text-blue-600 mr-3"></i>
                Our Medical Services
            </h2>
            <p class="text-xl text-gray-600 dark:text-gray-300 max-w-3xl mx-auto">
                Comprehensive healthcare services with modern facilities and experienced medical professionals
            </p>
        </div>
        
        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
            <?php foreach (array_slice($services, 0, 4) as $service): ?>
            <div class="service-card animate-on-scroll">
                <i class="<?php echo htmlspecialchars($service['icon']); ?> service-icon"></i>
                <h3 class="text-xl font-bold mb-3 text-gray-800 dark:text-white">
                    <?php echo htmlspecialchars($service['name']); ?>
                </h3>
                <p class="text-gray-600 dark:text-gray-300">
                    <?php echo htmlspecialchars($service['description']); ?>
                </p>
            </div>
            <?php endforeach; ?>
        </div>
        
        <!-- Additional Services -->
        <div class="mt-16 text-center animate-on-scroll">
            <h3 class="text-2xl font-bold mb-8 text-gray-800 dark:text-white">Specialized Care</h3>
            <div class="flex flex-wrap justify-center gap-4">
                <?php foreach (array_slice($services, 4) as $service): ?>
                <span class="px-6 py-3 bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 rounded-full">
                    <i class="<?php echo htmlspecialchars($service['icon']); ?> mr-2"></i>
                    <?php echo htmlspecialchars($service['name']); ?>
                </span>
                <?php endforeach; ?>
            </div>
        </div>
        
        <!-- Statistics -->
        <div class="mt-16 animate-on-scroll">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
                <div class="stats-card p-6 rounded-lg shadow-lg">
                    <div class="text-3xl font-bold text-blue-600 mb-2"><?php echo $stats['services']; ?></div>
                    <div class="text-gray-600 dark:text-gray-300">Services</div>
                </div>
                <div class="stats-card p-6 rounded-lg shadow-lg">
                    <div class="text-3xl font-bold text-green-600 mb-2"><?php echo $stats['doctors']; ?></div>
                    <div class="text-gray-600 dark:text-gray-300">Expert Doctors</div>
                </div>
                <div class="stats-card p-6 rounded-lg shadow-lg">
                    <div class="text-3xl font-bold text-purple-600 mb-2"><?php echo $stats['appointments']; ?></div>
                    <div class="text-gray-600 dark:text-gray-300">Appointments</div>
                </div>
                <div class="stats-card p-6 rounded-lg shadow-lg">
                    <div class="text-3xl font-bold text-orange-600 mb-2">24/7</div>
                    <div class="text-gray-600 dark:text-gray-300">Emergency Care</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- About Section -->
<section class="py-20" id="about">
    <div class="container mx-auto px-6">
        <div class="flex flex-col lg:flex-row items-center gap-12">
            <!-- About Image -->
            <div class="lg:w-1/2 animate-on-scroll">
                <img src="assets/images/site1.jpg" 
                     alt="About Karuna Clinic" 
                     class="w-full h-auto rounded-2xl shadow-lg">
            </div>
            
            <!-- About Content -->
            <div class="lg:w-1/2 animate-on-scroll">
                <h2 class="text-4xl font-bold mb-6 text-gray-800 dark:text-white">
                    About <?php echo SITE_NAME; ?>
                </h2>
                <p class="text-lg text-gray-600 dark:text-gray-300 mb-6 leading-relaxed">
                    We provide comprehensive healthcare services focusing on diabetes management, orthopedic problems, 
                    and general medical care. Our experienced team of medical professionals is dedicated to providing 
                    quality healthcare services at affordable prices.
                </p>
                
                <!-- Key Features -->
                <div class="space-y-4 mb-8">
                    <div class="flex items-center">
                        <i class="fas fa-check-circle text-green-500 mr-3"></i>
                        <span class="text-gray-700 dark:text-gray-300">Expert Medical Professionals</span>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-check-circle text-green-500 mr-3"></i>
                        <span class="text-gray-700 dark:text-gray-300">Modern Medical Equipment</span>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-check-circle text-green-500 mr-3"></i>
                        <span class="text-gray-700 dark:text-gray-300">Affordable Healthcare</span>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-check-circle text-green-500 mr-3"></i>
                        <span class="text-gray-700 dark:text-gray-300">24/7 Emergency Support</span>
                    </div>
                </div>
                
                <a href="pages/about.php" class="btn-primary">
                    <i class="fas fa-info-circle mr-2"></i>
                    Learn More About Us
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Doctors Section -->
<section class="py-20 bg-gray-50 dark:bg-gray-800" id="doctors">
    <div class="container mx-auto px-6">
        <div class="text-center mb-16 animate-on-scroll">
            <h2 class="text-4xl font-bold mb-4 text-gray-800 dark:text-white">
                <i class="fas fa-user-md text-blue-600 mr-3"></i>
                Our Medical Team
            </h2>
            <p class="text-xl text-gray-600 dark:text-gray-300">
                Experienced and qualified medical professionals dedicated to your health
            </p>
        </div>
        
        <div class="grid md:grid-cols-2 gap-8 max-w-4xl mx-auto">
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
            <div class="doctor-card animate-on-scroll">
                <img src="assets/images/<?php echo htmlspecialchars($doctor['image']); ?>" 
                     alt="<?php echo htmlspecialchars($doctor['name']); ?>" 
                     class="doctor-image">
                <div class="p-6">
                    <h3 class="text-xl font-bold mb-2 text-gray-800 dark:text-white">
                        <?php echo htmlspecialchars($doctor['name']); ?>
                    </h3>
                    <p class="text-blue-600 dark:text-blue-400 font-semibold mb-3">
                        <?php echo htmlspecialchars($doctor['specialization']); ?>
                    </p>
                    <p class="text-gray-600 dark:text-gray-300 mb-4">
                        <?php echo htmlspecialchars($doctor['bio']); ?>
                    </p>
                    <div class="flex items-center text-sm text-gray-500 dark:text-gray-400">
                        <i class="fas fa-calendar mr-2"></i>
                        Available: <?php echo $scheduleText; ?>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        
        <div class="text-center mt-12 animate-on-scroll">
            <a href="pages/doctors.php" class="btn-primary">
                <i class="fas fa-users mr-2"></i>
                View All Doctors
            </a>
        </div>
    </div>
</section>

<!-- Contact CTA Section -->
<section class="py-20 bg-blue-600 text-white">
    <div class="container mx-auto px-6 text-center">
        <div class="max-w-3xl mx-auto animate-on-scroll">
            <h2 class="text-4xl font-bold mb-6">
                Ready to Take Care of Your Health?
            </h2>
            <p class="text-xl mb-8 text-blue-100">
                Book an appointment today and experience quality healthcare from our expert medical team.
            </p>
            
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="pages/contact.php" class="btn-primary bg-white text-blue-600 hover:bg-gray-100 text-lg px-8 py-4">
                    <i class="fas fa-calendar-check mr-2"></i>
                    Book Appointment
                </a>
                <a href="tel:<?php echo CLINIC_PHONE; ?>" class="btn-secondary border-white text-white hover:bg-white hover:text-blue-600 text-lg px-8 py-4">
                    <i class="fas fa-phone mr-2"></i>
                    <?php echo formatPhone(CLINIC_PHONE); ?>
                </a>
            </div>
        </div>
    </div>
</section>

<?php include_once 'includes/footer.php'; ?>