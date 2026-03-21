<?php
$pageTitle = 'Contact';
include_once '../includes/header.php';

$db = DatabaseHelper::getInstance();
$doctors = $db->getActiveDoctors();
$services = $db->getActiveServices();
$csrf = generateCSRFToken();
?>

<section class="page-banner" style="background-image:url('../assets/images/hero-main.webp');">
    <div>
        <h1>Contact and Appointment</h1>
        <p>Reach the clinic directly, send your query, or request your consultation date.</p>
    </div>
</section>

<section class="highlight-contact">
    <div class="container">
        <div class="contact-cards">
            <article class="contact-card">
                <h4><i class="fas fa-phone-volume"></i> Priority Phone</h4>
                <p><a href="tel:<?php echo htmlspecialchars(getSiteSettingValue('clinic_phone', CLINIC_PHONE)); ?>"><?php echo htmlspecialchars(getSiteSettingValue('clinic_phone', CLINIC_PHONE)); ?></a></p>
            </article>
            <article class="contact-card">
                <h4><i class="fas fa-phone"></i> Telephone</h4>
                <p><a href="tel:<?php echo htmlspecialchars(getSiteSettingValue('clinic_telephone', CLINIC_TELEPHONE)); ?>"><?php echo htmlspecialchars(getSiteSettingValue('clinic_telephone', CLINIC_TELEPHONE)); ?></a></p>
            </article>
            <article class="contact-card">
                <h4><i class="fas fa-envelope"></i> Email</h4>
                <p><a href="mailto:<?php echo htmlspecialchars(getSiteSettingValue('clinic_email', CLINIC_EMAIL)); ?>"><?php echo htmlspecialchars(getSiteSettingValue('clinic_email', CLINIC_EMAIL)); ?></a></p>
            </article>
            <article class="contact-card">
                <h4><i class="fas fa-location-dot"></i> Clinic Address</h4>
                <p><?php echo htmlspecialchars(getSiteSettingValue('clinic_address', CLINIC_ADDRESS)); ?></p>
            </article>
        </div>
    </div>
</section>

<section class="section">
    <div class="container form-layout">
        <article class="panel" id="appointment-form">
            <h2><i class="fas fa-calendar-check"></i> Book Appointment</h2>
            <div id="appointmentFlash" class="flash" style="display:none;"></div>
            <form action="../process-form.php" method="post" data-ajax="true" data-flash-target="appointmentFlash">
                <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrf); ?>">
                <input type="hidden" name="form_type" value="appointment">

                <div class="form-row">
                    <label for="patient_name">Full Name</label>
                    <input id="patient_name" name="patient_name" required>
                </div>
                <div class="form-row">
                    <label for="patient_phone">Phone Number</label>
                    <input id="patient_phone" name="patient_phone" required>
                </div>
                <div class="form-row">
                    <label for="patient_email">Email</label>
                    <input id="patient_email" type="email" name="patient_email">
                </div>
                <div class="form-row">
                    <label for="appointment_date">Preferred Date</label>
                    <input id="appointment_date" type="date" name="appointment_date" min="<?php echo date('Y-m-d'); ?>" required>
                </div>
                <div class="form-row">
                    <label for="appointment_time">Preferred Time</label>
                    <select id="appointment_time" name="appointment_time" required>
                        <option value="">Select Time</option>
                        <option value="09:00">09:00 AM</option>
                        <option value="10:00">10:00 AM</option>
                        <option value="11:00">11:00 AM</option>
                        <option value="14:00">02:00 PM</option>
                        <option value="15:00">03:00 PM</option>
                        <option value="16:00">04:00 PM</option>
                    </select>
                </div>
                <div class="form-row">
                    <label for="doctor_id">Doctor</label>
                    <select id="doctor_id" name="doctor_id">
                        <option value="">Any Available</option>
                        <?php foreach ($doctors as $doctor): ?>
                        <option value="<?php echo (int)$doctor['id']; ?>"><?php echo htmlspecialchars($doctor['name']); ?> - <?php echo htmlspecialchars($doctor['specialization']); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-row">
                    <label for="service_type">Service</label>
                    <select id="service_type" name="service_type">
                        <option value="">Select Service</option>
                        <?php foreach ($services as $service): ?>
                        <option value="<?php echo htmlspecialchars($service['name']); ?>"><?php echo htmlspecialchars($service['name']); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-row">
                    <label for="appointment_message">Additional Note</label>
                    <textarea id="appointment_message" name="message" rows="4"></textarea>
                </div>
                <button class="btn btn-accent" type="submit"><i class="fas fa-paper-plane"></i> Submit Appointment</button>
            </form>
        </article>

        <article class="panel">
            <h2><i class="fas fa-envelope-open-text"></i> Send Message</h2>
            <div id="contactFlash" class="flash" style="display:none;"></div>
            <form action="../process-form.php" method="post" data-ajax="true" data-flash-target="contactFlash">
                <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrf); ?>">
                <input type="hidden" name="form_type" value="contact">

                <div class="form-row">
                    <label for="name">Full Name</label>
                    <input id="name" name="name" required>
                </div>
                <div class="form-row">
                    <label for="email">Email</label>
                    <input id="email" name="email" type="email" required>
                </div>
                <div class="form-row">
                    <label for="phone">Phone</label>
                    <input id="phone" name="phone">
                </div>
                <div class="form-row">
                    <label for="subject">Subject</label>
                    <input id="subject" name="subject">
                </div>
                <div class="form-row">
                    <label for="message">Message</label>
                    <textarea id="message" name="message" rows="6" required></textarea>
                </div>
                <button class="btn btn-accent" type="submit"><i class="fas fa-paper-plane"></i> Send Message</button>
            </form>
        </article>
    </div>
</section>

<?php include_once '../includes/footer.php'; ?>
