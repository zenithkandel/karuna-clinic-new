<?php
/**
 * Contact Page - Karuna Swasthya Clinic
 * Contact form and appointment booking
 */

$pageTitle = "Contact Us";
include_once '../includes/header.php';

// Get dynamic content from database
require_once '../includes/DatabaseHelper.php';
$db = DatabaseHelper::getInstance();
$doctors = $db->getActiveDoctors();
$services = $db->getActiveServices();
?>

<!-- Contact Hero Section -->
<section class="py-20 bg-gradient-to-br from-blue-600 to-blue-800 text-white">
    <div class="container mx-auto px-6">
        <div class="text-center animate-fadeInUp">
            <h1 class="text-4xl lg:text-5xl font-bold mb-6">
                <i class="fas fa-phone-alt mr-3"></i>
                Contact Us
            </h1>
            <p class="text-xl text-blue-100 max-w-2xl mx-auto">
                Get in touch with our medical team to book an appointment or ask any questions about our healthcare services.
            </p>
        </div>
    </div>
</section>

<!-- Contact Information -->
<section class="py-16 bg-gray-50 dark:bg-gray-800">
    <div class="container mx-auto px-6">
        <div class="grid md:grid-cols-3 gap-8">
            <!-- Phone -->
            <div class="card text-center animate-on-scroll">
                <div class="w-16 h-16 bg-blue-100 dark:bg-blue-900 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-phone text-2xl text-blue-600"></i>
                </div>
                <h3 class="text-xl font-bold mb-2 text-gray-800 dark:text-white">Phone</h3>
                <p class="text-gray-600 dark:text-gray-300 mb-4">Call us for immediate assistance</p>
                <a href="tel:<?php echo CLINIC_PHONE; ?>" class="text-blue-600 hover:text-blue-800 font-semibold">
                    <?php echo formatPhone(CLINIC_PHONE); ?>
                </a>
                <br>
                <a href="tel:<?php echo CLINIC_TELEPHONE; ?>" class="text-blue-600 hover:text-blue-800 font-semibold">
                    <?php echo CLINIC_TELEPHONE; ?>
                </a>
            </div>

            <!-- Email -->
            <div class="card text-center animate-on-scroll">
                <div class="w-16 h-16 bg-green-100 dark:bg-green-900 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-envelope text-2xl text-green-600"></i>
                </div>
                <h3 class="text-xl font-bold mb-2 text-gray-800 dark:text-white">Email</h3>
                <p class="text-gray-600 dark:text-gray-300 mb-4">Send us your questions</p>
                <a href="mailto:<?php echo CLINIC_EMAIL; ?>" class="text-green-600 hover:text-green-800 font-semibold">
                    <?php echo CLINIC_EMAIL; ?>
                </a>
            </div>

            <!-- Location -->
            <div class="card text-center animate-on-scroll">
                <div class="w-16 h-16 bg-purple-100 dark:bg-purple-900 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-map-marker-alt text-2xl text-purple-600"></i>
                </div>
                <h3 class="text-xl font-bold mb-2 text-gray-800 dark:text-white">Location</h3>
                <p class="text-gray-600 dark:text-gray-300 mb-4">Visit our clinic</p>
                <p class="text-purple-600 font-semibold">
                    <?php echo CLINIC_ADDRESS; ?>
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Contact Forms Section -->
<section class="py-20">
    <div class="container mx-auto px-6">
        <div class="grid lg:grid-cols-2 gap-12">
            <!-- Appointment Form -->
            <div class="animate-on-scroll">
                <div class="card">
                    <h2 class="text-3xl font-bold mb-6 text-gray-800 dark:text-white">
                        <i class="fas fa-calendar-check text-blue-600 mr-3"></i>
                        Book Appointment
                    </h2>
                    <form id="appointmentForm" class="space-y-6">
                        <input type="hidden" name="csrf_token" value="<?php echo generateCSRFToken(); ?>">
                        <input type="hidden" name="form_type" value="appointment">
                        
                        <div class="form-group">
                            <label for="patient_name" class="form-label">Full Name *</label>
                            <input type="text" id="patient_name" name="patient_name" required 
                                   class="form-input" placeholder="Enter your full name">
                        </div>
                        
                        <div class="grid md:grid-cols-2 gap-4">
                            <div class="form-group">
                                <label for="patient_email" class="form-label">Email Address</label>
                                <input type="email" id="patient_email" name="patient_email" 
                                       class="form-input" placeholder="your@email.com">
                            </div>
                            <div class="form-group">
                                <label for="patient_phone" class="form-label">Phone Number *</label>
                                <input type="tel" id="patient_phone" name="patient_phone" required 
                                       class="form-input" placeholder="+977 98xxxxxxxx">
                            </div>
                        </div>
                        
                        <div class="grid md:grid-cols-2 gap-4">
                            <div class="form-group">
                                <label for="appointment_date" class="form-label">Preferred Date *</label>
                                <input type="date" id="appointment_date" name="appointment_date" required 
                                       class="form-input" min="<?php echo date('Y-m-d'); ?>">
                            </div>
                            <div class="form-group">
                                <label for="appointment_time" class="form-label">Preferred Time *</label>
                                <select id="appointment_time" name="appointment_time" required class="form-input">
                                    <option value="">Select time</option>
                                    <option value="09:00">9:00 AM</option>
                                    <option value="10:00">10:00 AM</option>
                                    <option value="11:00">11:00 AM</option>
                                    <option value="14:00">2:00 PM</option>
                                    <option value="15:00">3:00 PM</option>
                                    <option value="16:00">4:00 PM</option>
                                    <option value="17:00">5:00 PM</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="grid md:grid-cols-2 gap-4">
                            <div class="form-group">
                                <label for="doctor_id" class="form-label">Preferred Doctor</label>
                                <select id="doctor_id" name="doctor_id" class="form-input">
                                    <option value="">Any available doctor</option>
                                    <?php foreach ($doctors as $doctor): ?>
                                    <option value="<?php echo $doctor['id']; ?>">
                                        <?php echo htmlspecialchars($doctor['name']); ?> - <?php echo htmlspecialchars($doctor['specialization']); ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="service_type" class="form-label">Service Needed</label>
                                <select id="service_type" name="service_type" class="form-input">
                                    <option value="">Select service</option>
                                    <?php foreach ($services as $service): ?>
                                    <option value="<?php echo htmlspecialchars($service['name']); ?>">
                                        <?php echo htmlspecialchars($service['name']); ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="message" class="form-label">Additional Information</label>
                            <textarea id="message" name="message" rows="4" 
                                      class="form-input form-textarea" 
                                      placeholder="Please describe your symptoms or reason for visit..."></textarea>
                        </div>
                        
                        <button type="submit" class="btn-primary w-full">
                            <i class="fas fa-calendar-check mr-2"></i>
                            Book Appointment
                        </button>
                    </form>
                </div>
            </div>

            <!-- Contact Form -->
            <div class="animate-on-scroll">
                <div class="card">
                    <h2 class="text-3xl font-bold mb-6 text-gray-800 dark:text-white">
                        <i class="fas fa-envelope text-green-600 mr-3"></i>
                        Send Message
                    </h2>
                    <form id="contactForm" class="space-y-6">
                        <input type="hidden" name="csrf_token" value="<?php echo generateCSRFToken(); ?>">
                        <input type="hidden" name="form_type" value="contact">
                        
                        <div class="form-group">
                            <label for="contact_name" class="form-label">Full Name *</label>
                            <input type="text" id="contact_name" name="name" required 
                                   class="form-input" placeholder="Enter your full name">
                        </div>
                        
                        <div class="grid md:grid-cols-2 gap-4">
                            <div class="form-group">
                                <label for="contact_email" class="form-label">Email Address *</label>
                                <input type="email" id="contact_email" name="email" required 
                                       class="form-input" placeholder="your@email.com">
                            </div>
                            <div class="form-group">
                                <label for="contact_phone" class="form-label">Phone Number</label>
                                <input type="tel" id="contact_phone" name="phone" 
                                       class="form-input" placeholder="+977 98xxxxxxxx">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="subject" class="form-label">Subject</label>
                            <input type="text" id="subject" name="subject" 
                                   class="form-input" placeholder="What is this regarding?">
                        </div>
                        
                        <div class="form-group">
                            <label for="contact_message" class="form-label">Message *</label>
                            <textarea id="contact_message" name="message" rows="6" required 
                                      class="form-input form-textarea" 
                                      placeholder="Please enter your message here..."></textarea>
                        </div>
                        
                        <button type="submit" class="btn-primary w-full">
                            <i class="fas fa-paper-plane mr-2"></i>
                            Send Message
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Operating Hours -->
<section class="py-16 bg-blue-600 text-white">
    <div class="container mx-auto px-6">
        <div class="text-center animate-on-scroll">
            <h2 class="text-3xl font-bold mb-8">
                <i class="fas fa-clock mr-3"></i>
                Operating Hours
            </h2>
            <div class="grid md:grid-cols-2 gap-8 max-w-4xl mx-auto">
                <div class="bg-white/10 p-6 rounded-lg">
                    <h3 class="text-xl font-bold mb-4">Regular Hours</h3>
                    <p class="mb-2"><?php echo CLINIC_HOURS; ?></p>
                    <p class="text-blue-200">Closed on Saturdays</p>
                </div>
                <div class="bg-white/10 p-6 rounded-lg">
                    <h3 class="text-xl font-bold mb-4">Emergency Services</h3>
                    <p class="mb-2"><?php echo CLINIC_EMERGENCY; ?></p>
                    <p class="text-blue-200">Call <?php echo formatPhone(CLINIC_PHONE); ?></p>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
// Initialize forms when page loads
document.addEventListener('DOMContentLoaded', function() {
    // Handle appointment form
    const appointmentForm = document.getElementById('appointmentForm');
    if (appointmentForm) {
        handleFormSubmit(appointmentForm, 
            function(data) {
                // Success callback
                console.log('Appointment booked successfully:', data);
            },
            function(error) {
                // Error callback
                console.error('Appointment booking failed:', error);
            }
        );
    }
    
    // Handle contact form
    const contactForm = document.getElementById('contactForm');
    if (contactForm) {
        handleFormSubmit(contactForm,
            function(data) {
                // Success callback
                console.log('Message sent successfully:', data);
            },
            function(error) {
                // Error callback
                console.error('Message sending failed:', error);
            }
        );
    }
});
</script>

<?php include_once '../includes/footer.php'; ?>