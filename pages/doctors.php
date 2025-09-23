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
<section class="py-20 bg-gradient-to-br from-green-600 to-green-800 text-white">
    <div class="container mx-auto px-6">
        <div class="text-center animate-fadeInUp">
            <h1 class="text-4xl lg:text-5xl font-bold mb-6">
                <i class="fas fa-user-md mr-3"></i>
                Meet Our Medical Team
            </h1>
            <p class="text-xl text-green-100 max-w-3xl mx-auto mb-8">
                Our experienced and qualified medical professionals are dedicated to providing you with the highest quality healthcare services with compassion and expertise.
            </p>
            <a href="../pages/contact.php" class="btn-primary bg-white text-green-600 hover:bg-gray-100">
                <i class="fas fa-calendar-plus mr-2"></i>
                Book Consultation
            </a>
        </div>
    </div>
</section>

<!-- Doctors Team Introduction -->
<section class="py-20">
    <div class="container mx-auto px-6">
        <div class="text-center mb-16 animate-on-scroll">
            <h2 class="text-4xl font-bold mb-6 text-gray-800 dark:text-white">
                Excellence in Medical Care
            </h2>
            <p class="text-xl text-gray-600 dark:text-gray-300 max-w-4xl mx-auto leading-relaxed">
                At Karuna Swasthya Clinic, our medical team consists of highly qualified doctors with years of experience in their respective specializations. We are committed to providing personalized care and the latest medical treatments to ensure the best outcomes for our patients.
            </p>
        </div>
        
        <div class="grid md:grid-cols-3 gap-8">
            <div class="text-center animate-on-scroll">
                <div class="w-16 h-16 bg-blue-100 dark:bg-blue-900 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-graduation-cap text-2xl text-blue-600 dark:text-blue-400"></i>
                </div>
                <h3 class="text-xl font-bold mb-4 text-gray-800 dark:text-white">Highly Qualified</h3>
                <p class="text-gray-600 dark:text-gray-300">
                    All our doctors hold advanced medical degrees and certifications from recognized institutions.
                </p>
            </div>
            
            <div class="text-center animate-on-scroll">
                <div class="w-16 h-16 bg-green-100 dark:bg-green-900 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-award text-2xl text-green-600 dark:text-green-400"></i>
                </div>
                <h3 class="text-xl font-bold mb-4 text-gray-800 dark:text-white">Experienced</h3>
                <p class="text-gray-600 dark:text-gray-300">
                    Years of practical experience in treating patients and managing complex medical conditions.
                </p>
            </div>
            
            <div class="text-center animate-on-scroll">
                <div class="w-16 h-16 bg-purple-100 dark:bg-purple-900 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-heart text-2xl text-purple-600 dark:text-purple-400"></i>
                </div>
                <h3 class="text-xl font-bold mb-4 text-gray-800 dark:text-white">Compassionate</h3>
                <p class="text-gray-600 dark:text-gray-300">
                    Patient-centered approach with empathy and dedication to improving health outcomes.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Doctors Profiles -->
<section class="py-20 bg-gray-50 dark:bg-gray-800">
    <div class="container mx-auto px-6">
        <div class="text-center mb-16 animate-on-scroll">
            <h2 class="text-4xl font-bold mb-6 text-gray-800 dark:text-white">
                <i class="fas fa-stethoscope mr-3"></i>
                Our Medical Specialists
            </h2>
            <p class="text-xl text-gray-600 dark:text-gray-300">
                Get to know our dedicated medical professionals
            </p>
        </div>
        
        <div class="space-y-12">
            <?php foreach ($doctors as $index => $doctor): 
                $schedule = json_decode($doctor['schedule'], true);
                $isEven = $index % 2 === 0;
            ?>
            <div class="doctor-profile-card <?php echo $isEven ? 'lg:flex-row' : 'lg:flex-row-reverse'; ?> animate-on-scroll">
                <div class="flex flex-col lg:flex lg:items-center lg:gap-12 bg-white dark:bg-gray-900 rounded-2xl overflow-hidden shadow-xl">
                    <!-- Doctor Image -->
                    <div class="lg:w-1/3 flex-shrink-0">
                        <div class="relative overflow-hidden">
                            <img src="../assets/images/<?php echo htmlspecialchars($doctor['image']); ?>" 
                                 alt="<?php echo htmlspecialchars($doctor['name']); ?>" 
                                 class="w-full h-80 lg:h-96 object-cover">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent"></div>
                        </div>
                    </div>
                    
                    <!-- Doctor Information -->
                    <div class="lg:w-2/3 p-8">
                        <div class="mb-6">
                            <h3 class="text-3xl font-bold mb-2 text-gray-800 dark:text-white">
                                <?php echo htmlspecialchars($doctor['name']); ?>
                            </h3>
                            <p class="text-xl text-blue-600 dark:text-blue-400 font-semibold mb-2">
                                <?php echo htmlspecialchars($doctor['title']); ?>
                            </p>
                            <p class="text-lg text-gray-600 dark:text-gray-300 font-medium">
                                <?php echo htmlspecialchars($doctor['specialization']); ?>
                            </p>
                        </div>
                        
                        <div class="grid md:grid-cols-2 gap-6 mb-8">
                            <div>
                                <h4 class="font-bold text-gray-800 dark:text-white mb-3 flex items-center">
                                    <i class="fas fa-graduation-cap mr-2 text-blue-600"></i>
                                    Qualifications
                                </h4>
                                <p class="text-gray-600 dark:text-gray-300 leading-relaxed">
                                    <?php echo htmlspecialchars($doctor['qualification']); ?>
                                </p>
                            </div>
                            
                            <div>
                                <h4 class="font-bold text-gray-800 dark:text-white mb-3 flex items-center">
                                    <i class="fas fa-clock mr-2 text-green-600"></i>
                                    Experience
                                </h4>
                                <p class="text-gray-600 dark:text-gray-300">
                                    <span class="text-2xl font-bold text-green-600">
                                        <?php echo isset($doctor['experience_years']) ? $doctor['experience_years'] : 'N/A'; ?>
                                    </span> years of medical practice
                                </p>
                            </div>
                        </div>
                        
                        <div class="mb-8">
                            <h4 class="font-bold text-gray-800 dark:text-white mb-3 flex items-center">
                                <i class="fas fa-info-circle mr-2 text-purple-600"></i>
                                About Dr. <?php echo explode(' ', $doctor['name'])[count(explode(' ', $doctor['name']))-1]; ?>
                            </h4>
                            <p class="text-gray-600 dark:text-gray-300 leading-relaxed">
                                <?php echo htmlspecialchars($doctor['bio']); ?>
                            </p>
                        </div>
                        
                        <!-- Schedule Information -->
                        <?php if ($schedule && is_array($schedule)): ?>
                        <div class="mb-8">
                            <h4 class="font-bold text-gray-800 dark:text-white mb-3 flex items-center">
                                <i class="fas fa-calendar-alt mr-2 text-orange-600"></i>
                                Available Schedule
                            </h4>
                            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-7 gap-2">
                                <?php 
                                $days = ['monday' => 'Mon', 'tuesday' => 'Tue', 'wednesday' => 'Wed', 'thursday' => 'Thu', 'friday' => 'Fri', 'saturday' => 'Sat', 'sunday' => 'Sun'];
                                foreach ($days as $day => $shortName): 
                                    $time = isset($schedule[$day]) ? $schedule[$day] : 'closed';
                                    $isAvailable = $time !== 'closed';
                                ?>
                                <div class="text-center p-2 rounded-lg <?php echo $isAvailable ? 'bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200' : 'bg-gray-100 dark:bg-gray-700 text-gray-500 dark:text-gray-400'; ?>">
                                    <div class="font-semibold text-xs mb-1"><?php echo $shortName; ?></div>
                                    <div class="text-xs">
                                        <?php echo $isAvailable ? date('g A', strtotime(explode('-', $time)[0])) . '-' . date('g A', strtotime(explode('-', $time)[1])) : 'Closed'; ?>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <?php endif; ?>
                        
                        <!-- Contact Information -->
                        <div class="flex flex-col sm:flex-row gap-4 mb-6">
                            <?php if (!empty($doctor['phone'])): ?>
                            <a href="tel:<?php echo htmlspecialchars($doctor['phone']); ?>" 
                               class="flex items-center text-gray-600 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition-colors duration-200">
                                <i class="fas fa-phone mr-2"></i>
                                <?php echo htmlspecialchars($doctor['phone']); ?>
                            </a>
                            <?php endif; ?>
                            
                            <?php if (!empty($doctor['email'])): ?>
                            <a href="mailto:<?php echo htmlspecialchars($doctor['email']); ?>" 
                               class="flex items-center text-gray-600 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition-colors duration-200">
                                <i class="fas fa-envelope mr-2"></i>
                                <?php echo htmlspecialchars($doctor['email']); ?>
                            </a>
                            <?php endif; ?>
                        </div>
                        
                        <!-- Action Buttons -->
                        <div class="flex flex-col sm:flex-row gap-4">
                            <a href="../pages/contact.php" class="btn-primary flex-1 justify-center">
                                <i class="fas fa-calendar-plus mr-2"></i>
                                Book Appointment
                            </a>
                            <button onclick="showDoctorDetails('<?php echo addslashes($doctor['name']); ?>', '<?php echo addslashes($doctor['specialization']); ?>', '<?php echo addslashes($doctor['bio']); ?>')" 
                                    class="btn-secondary flex-1 justify-center">
                                <i class="fas fa-info-circle mr-2"></i>
                                More Details
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        
        <?php if (empty($doctors)): ?>
        <div class="text-center py-12 animate-on-scroll">
            <i class="fas fa-user-md text-6xl text-gray-400 dark:text-gray-600 mb-6"></i>
            <h3 class="text-2xl font-bold text-gray-600 dark:text-gray-400 mb-4">No Doctors Available</h3>
            <p class="text-gray-500 dark:text-gray-500 mb-6">
                Please contact us for information about available doctors and appointments.
            </p>
            <a href="../pages/contact.php" class="btn-primary">
                <i class="fas fa-phone mr-2"></i>
                Contact Us
            </a>
        </div>
        <?php endif; ?>
    </div>
</section>

<!-- Why Choose Our Doctors -->
<section class="py-20">
    <div class="container mx-auto px-6">
        <div class="text-center mb-16 animate-on-scroll">
            <h2 class="text-4xl font-bold mb-6 text-gray-800 dark:text-white">
                Why Choose Our Medical Team?
            </h2>
            <p class="text-xl text-gray-600 dark:text-gray-300">
                Our commitment to excellence in healthcare
            </p>
        </div>
        
        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
            <div class="text-center animate-on-scroll">
                <div class="w-20 h-20 bg-blue-100 dark:bg-blue-900 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-certificate text-3xl text-blue-600 dark:text-blue-400"></i>
                </div>
                <h3 class="text-lg font-bold mb-3 text-gray-800 dark:text-white">Board Certified</h3>
                <p class="text-gray-600 dark:text-gray-300 text-sm">
                    All doctors are board-certified with recognized medical qualifications.
                </p>
            </div>
            
            <div class="text-center animate-on-scroll">
                <div class="w-20 h-20 bg-green-100 dark:bg-green-900 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-microscope text-3xl text-green-600 dark:text-green-400"></i>
                </div>
                <h3 class="text-lg font-bold mb-3 text-gray-800 dark:text-white">Latest Knowledge</h3>
                <p class="text-gray-600 dark:text-gray-300 text-sm">
                    Continuously updated with the latest medical research and treatments.
                </p>
            </div>
            
            <div class="text-center animate-on-scroll">
                <div class="w-20 h-20 bg-purple-100 dark:bg-purple-900 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-handshake text-3xl text-purple-600 dark:text-purple-400"></i>
                </div>
                <h3 class="text-lg font-bold mb-3 text-gray-800 dark:text-white">Patient-Centered</h3>
                <p class="text-gray-600 dark:text-gray-300 text-sm">
                    Focused on building relationships and providing personalized care.
                </p>
            </div>
            
            <div class="text-center animate-on-scroll">
                <div class="w-20 h-20 bg-orange-100 dark:bg-orange-900 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-clock text-3xl text-orange-600 dark:text-orange-400"></i>
                </div>
                <h3 class="text-lg font-bold mb-3 text-gray-800 dark:text-white">Available</h3>
                <p class="text-gray-600 dark:text-gray-300 text-sm">
                    Convenient scheduling and availability to meet your healthcare needs.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Call to Action -->
<section class="py-20 bg-gradient-to-br from-blue-600 to-purple-700 text-white">
    <div class="container mx-auto px-6">
        <div class="text-center animate-on-scroll">
            <h2 class="text-4xl font-bold mb-6">
                Ready to Meet Our Doctors?
            </h2>
            <p class="text-xl text-blue-100 max-w-3xl mx-auto mb-8">
                Schedule your consultation today and experience personalized healthcare with our expert medical team.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="../pages/contact.php" class="btn-primary bg-white text-blue-600 hover:bg-gray-100 text-lg px-8 py-4">
                    <i class="fas fa-calendar-plus mr-2"></i>
                    Book Appointment
                </a>
                <a href="tel:+9779766597210" class="btn-secondary border-white text-white hover:bg-white hover:text-blue-600 text-lg px-8 py-4">
                    <i class="fas fa-phone mr-2"></i>
                    Call Now
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Doctor Details Modal -->
<div id="doctorModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4" style="display: none;">
    <div class="bg-white dark:bg-gray-800 rounded-2xl max-w-2xl w-full p-6 shadow-2xl max-h-[90vh] overflow-y-auto">
        <div class="flex items-center justify-between mb-6">
            <h3 id="modalDoctorName" class="text-2xl font-bold text-gray-800 dark:text-white"></h3>
            <button onclick="closeDoctorModal()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 text-2xl">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div id="modalDoctorSpecialization" class="text-lg text-blue-600 dark:text-blue-400 font-semibold mb-4"></div>
        <div id="modalDoctorBio" class="text-gray-600 dark:text-gray-300 mb-6 leading-relaxed"></div>
        <div class="flex gap-3">
            <a href="../pages/contact.php" class="btn-primary flex-1 justify-center">
                <i class="fas fa-calendar-plus mr-2"></i>
                Book Appointment
            </a>
            <button onclick="closeDoctorModal()" class="btn-secondary flex-1 justify-center">
                Close
            </button>
        </div>
    </div>
</div>

<script>
function showDoctorDetails(name, specialization, bio) {
    document.getElementById('modalDoctorName').textContent = name;
    document.getElementById('modalDoctorSpecialization').textContent = specialization;
    document.getElementById('modalDoctorBio').textContent = bio;
    document.getElementById('doctorModal').style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

function closeDoctorModal() {
    document.getElementById('doctorModal').style.display = 'none';
    document.body.style.overflow = 'auto';
}

// Close modal on outside click
document.getElementById('doctorModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeDoctorModal();
    }
});

// Close modal on escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeDoctorModal();
    }
});
</script>

<?php include_once '../includes/footer.php'; ?>