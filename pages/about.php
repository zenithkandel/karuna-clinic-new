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
<section class="py-20 bg-gradient-to-br from-green-600 to-green-800 text-white">
    <div class="container mx-auto px-6">
        <div class="text-center animate-fadeInUp">
            <h1 class="text-4xl lg:text-5xl font-bold mb-6">
                <i class="fas fa-info-circle mr-3"></i>
                About Us
            </h1>
            <p class="text-xl text-green-100 max-w-3xl mx-auto">
                Dedicated to providing quality healthcare services with compassionate care and modern medical facilities in Pokhara.
            </p>
        </div>
    </div>
</section>

<!-- About Content -->
<section class="py-20">
    <div class="container mx-auto px-6">
        <div class="flex flex-col lg:flex-row items-center gap-12 mb-20">
            <!-- About Image -->
            <div class="lg:w-1/2 animate-on-scroll">
                <img src="../assets/images/site1.jpg" 
                     alt="About Karuna Clinic" 
                     class="w-full h-auto rounded-2xl shadow-lg">
            </div>
            
            <!-- About Content -->
            <div class="lg:w-1/2 animate-on-scroll">
                <h2 class="text-4xl font-bold mb-6 text-gray-800 dark:text-white">
                    Our Mission & Vision
                </h2>
                <p class="text-lg text-gray-600 dark:text-gray-300 mb-6 leading-relaxed">
                    <?php echo SITE_NAME; ?> is committed to providing comprehensive healthcare services 
                    with a focus on diabetes management, orthopedic problems, and general medical care. 
                    Our experienced team of medical professionals is dedicated to providing quality 
                    healthcare services at affordable prices.
                </p>
                
                <div class="space-y-4 mb-8">
                    <div class="flex items-start">
                        <i class="fas fa-check-circle text-green-500 mr-3 mt-1"></i>
                        <div>
                            <h4 class="font-semibold text-gray-800 dark:text-white">Expert Medical Care</h4>
                            <p class="text-gray-600 dark:text-gray-300">Experienced doctors and medical professionals</p>
                        </div>
                    </div>
                    <div class="flex items-start">
                        <i class="fas fa-check-circle text-green-500 mr-3 mt-1"></i>
                        <div>
                            <h4 class="font-semibold text-gray-800 dark:text-white">Modern Facilities</h4>
                            <p class="text-gray-600 dark:text-gray-300">State-of-the-art medical equipment and facilities</p>
                        </div>
                    </div>
                    <div class="flex items-start">
                        <i class="fas fa-check-circle text-green-500 mr-3 mt-1"></i>
                        <div>
                            <h4 class="font-semibold text-gray-800 dark:text-white">Affordable Healthcare</h4>
                            <p class="text-gray-600 dark:text-gray-300">Quality medical care at reasonable prices</p>
                        </div>
                    </div>
                    <div class="flex items-start">
                        <i class="fas fa-check-circle text-green-500 mr-3 mt-1"></i>
                        <div>
                            <h4 class="font-semibold text-gray-800 dark:text-white">Patient-Centered Care</h4>
                            <p class="text-gray-600 dark:text-gray-300">Compassionate care focused on patient needs</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Statistics Section -->
<section class="py-16 bg-gray-50 dark:bg-gray-800">
    <div class="container mx-auto px-6">
        <div class="text-center mb-12 animate-on-scroll">
            <h2 class="text-3xl font-bold mb-4 text-gray-800 dark:text-white">
                Our Impact in Numbers
            </h2>
            <p class="text-xl text-gray-600 dark:text-gray-300">
                Serving the Pokhara community with dedication and excellence
            </p>
        </div>
        
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
            <div class="stats-card p-8 text-center">
                <div class="text-4xl font-bold text-blue-600 mb-2"><?php echo $stats['services']; ?>+</div>
                <div class="text-gray-600 dark:text-gray-300">Medical Services</div>
            </div>
            <div class="stats-card p-8 text-center">
                <div class="text-4xl font-bold text-green-600 mb-2"><?php echo $stats['doctors']; ?>+</div>
                <div class="text-gray-600 dark:text-gray-300">Expert Doctors</div>
            </div>
            <div class="stats-card p-8 text-center">
                <div class="text-4xl font-bold text-purple-600 mb-2"><?php echo $stats['appointments']; ?>+</div>
                <div class="text-gray-600 dark:text-gray-300">Appointments Served</div>
            </div>
            <div class="stats-card p-8 text-center">
                <div class="text-4xl font-bold text-orange-600 mb-2">15+</div>
                <div class="text-gray-600 dark:text-gray-300">Years Experience</div>
            </div>
        </div>
    </div>
</section>

<!-- Our Doctors Section -->
<section class="py-20">
    <div class="container mx-auto px-6">
        <div class="text-center mb-16 animate-on-scroll">
            <h2 class="text-4xl font-bold mb-4 text-gray-800 dark:text-white">
                <i class="fas fa-user-md text-blue-600 mr-3"></i>
                Meet Our Medical Team
            </h2>
            <p class="text-xl text-gray-600 dark:text-gray-300">
                Experienced and qualified medical professionals dedicated to your health
            </p>
        </div>
        
        <div class="grid md:grid-cols-2 gap-12">
            <?php foreach ($doctors as $doctor): 
                $schedule = json_decode($doctor['schedule'], true);
            ?>
            <div class="doctor-card animate-on-scroll">
                <div class="p-8">
                    <div class="flex items-center mb-6">
                        <img src="../assets/images/<?php echo htmlspecialchars($doctor['image']); ?>" 
                             alt="<?php echo htmlspecialchars($doctor['name']); ?>" 
                             class="w-24 h-24 rounded-full object-cover mr-6">
                        <div>
                            <h3 class="text-2xl font-bold mb-2 text-gray-800 dark:text-white">
                                <?php echo htmlspecialchars($doctor['name']); ?>
                            </h3>
                            <p class="text-blue-600 dark:text-blue-400 font-semibold">
                                <?php echo htmlspecialchars($doctor['title']); ?>
                            </p>
                            <p class="text-gray-600 dark:text-gray-300">
                                <?php echo htmlspecialchars($doctor['specialization']); ?>
                            </p>
                        </div>
                    </div>
                    
                    <div class="mb-6">
                        <h4 class="font-semibold text-gray-800 dark:text-white mb-2">Qualifications:</h4>
                        <p class="text-gray-600 dark:text-gray-300">
                            <?php echo htmlspecialchars($doctor['qualification']); ?>
                        </p>
                    </div>
                    
                    <div class="mb-6">
                        <h4 class="font-semibold text-gray-800 dark:text-white mb-2">About:</h4>
                        <p class="text-gray-600 dark:text-gray-300">
                            <?php echo htmlspecialchars($doctor['bio']); ?>
                        </p>
                    </div>
                    
                    <div class="flex items-center justify-between">
                        <div>
                            <div class="flex items-center text-sm text-gray-500 dark:text-gray-400 mb-2">
                                <i class="fas fa-clock mr-2"></i>
                                Experience: <?php echo isset($doctor['experience_years']) ? $doctor['experience_years'] : 'N/A'; ?> years
                            </div>
                            <div class="flex items-center text-sm text-gray-500 dark:text-gray-400">
                                <i class="fas fa-envelope mr-2"></i>
                                <?php echo htmlspecialchars($doctor['email']); ?>
                            </div>
                        </div>
                        <a href="../pages/contact.php" class="btn-primary">
                            Book Appointment
                        </a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Why Choose Us -->
<section class="py-20 bg-blue-600 text-white">
    <div class="container mx-auto px-6">
        <div class="text-center mb-16 animate-on-scroll">
            <h2 class="text-4xl font-bold mb-6">
                Why Choose Karuna Swasthya Clinic?
            </h2>
            <p class="text-xl text-blue-100">
                We are committed to providing the best healthcare experience for our patients
            </p>
        </div>
        
        <div class="grid md:grid-cols-3 gap-8">
            <div class="text-center animate-on-scroll">
                <div class="w-20 h-20 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-heart text-3xl"></i>
                </div>
                <h3 class="text-xl font-bold mb-4">Compassionate Care</h3>
                <p class="text-blue-100">
                    We treat every patient with dignity, respect, and genuine concern for their well-being.
                </p>
            </div>
            
            <div class="text-center animate-on-scroll">
                <div class="w-20 h-20 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-microscope text-3xl"></i>
                </div>
                <h3 class="text-xl font-bold mb-4">Advanced Technology</h3>
                <p class="text-blue-100">
                    Modern medical equipment and latest diagnostic tools for accurate diagnosis and treatment.
                </p>
            </div>
            
            <div class="text-center animate-on-scroll">
                <div class="w-20 h-20 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-clock text-3xl"></i>
                </div>
                <h3 class="text-xl font-bold mb-4">Convenient Hours</h3>
                <p class="text-blue-100">
                    Extended operating hours and emergency services to serve you when you need us most.
                </p>
            </div>
        </div>
    </div>
</section>

<?php include_once '../includes/footer.php'; ?>