<?php
/**
 * Form Processing Script
 * Handles appointment booking and contact messages
 */

header('Content-Type: application/json');

// Include required files
require_once 'config/config.php';
require_once 'includes/functions.php';
require_once 'includes/DatabaseHelper.php';

// Initialize response
$response = ['success' => false, 'message' => ''];

// Check if request is POST and AJAX
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $response['message'] = 'Invalid request method';
    echo json_encode($response);
    exit;
}

// Verify CSRF token
if (!isset($_POST['csrf_token']) || !verifyCSRFToken($_POST['csrf_token'])) {
    $response['message'] = 'Invalid security token';
    echo json_encode($response);
    exit;
}

// Get form type
$formType = $_POST['form_type'] ?? '';

try {
    $db = DatabaseHelper::getInstance();
    
    switch ($formType) {
        case 'appointment':
            $result = handleAppointmentForm($db, $_POST);
            break;
            
        case 'contact':
            $result = handleContactForm($db, $_POST);
            break;
            
        default:
            throw new Exception('Invalid form type');
    }
    
    $response = $result;
    
} catch (Exception $e) {
    error_log('Form processing error: ' . $e->getMessage());
    $response['message'] = 'An error occurred while processing your request. Please try again.';
}

echo json_encode($response);
exit;

/**
 * Handle appointment booking form
 */
function handleAppointmentForm($db, $data) {
    // Validate required fields
    $requiredFields = ['patient_name', 'patient_phone', 'appointment_date', 'appointment_time'];
    foreach ($requiredFields as $field) {
        if (empty($data[$field])) {
            return ['success' => false, 'message' => 'Please fill in all required fields.'];
        }
    }
    
    // Validate date (must be in the future)
    $appointmentDate = $data['appointment_date'];
    if (strtotime($appointmentDate) < strtotime(date('Y-m-d'))) {
        return ['success' => false, 'message' => 'Appointment date must be in the future.'];
    }
    
    // Validate phone number
    $phone = sanitizeInput($data['patient_phone']);
    if (!preg_match('/^(\+977)?[98]\d{9}$/', str_replace([' ', '-'], '', $phone))) {
        return ['success' => false, 'message' => 'Please enter a valid phone number.'];
    }
    
    // Validate email if provided
    if (!empty($data['patient_email'])) {
        $email = sanitizeInput($data['patient_email']);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return ['success' => false, 'message' => 'Please enter a valid email address.'];
        }
    }
    
    // Prepare appointment data
    $appointmentData = [
        'doctor_id' => !empty($data['doctor_id']) ? (int)$data['doctor_id'] : null,
        'patient_name' => sanitizeInput($data['patient_name']),
        'patient_email' => !empty($data['patient_email']) ? sanitizeInput($data['patient_email']) : null,
        'patient_phone' => $phone,
        'appointment_date' => $appointmentDate,
        'appointment_time' => sanitizeInput($data['appointment_time']),
        'service_type' => !empty($data['service_type']) ? sanitizeInput($data['service_type']) : null,
        'message' => !empty($data['message']) ? sanitizeInput($data['message']) : null
    ];
    
    // Save to database
    if ($db->saveAppointment($appointmentData)) {
        // Send notification email (you can implement this later)
        // sendAppointmentNotification($appointmentData);
        
        return [
            'success' => true, 
            'message' => 'Appointment booked successfully! We will contact you soon to confirm.'
        ];
    } else {
        return ['success' => false, 'message' => 'Failed to book appointment. Please try again.'];
    }
}

/**
 * Handle contact form
 */
function handleContactForm($db, $data) {
    // Validate required fields
    $requiredFields = ['name', 'email', 'message'];
    foreach ($requiredFields as $field) {
        if (empty($data[$field])) {
            return ['success' => false, 'message' => 'Please fill in all required fields.'];
        }
    }
    
    // Validate email
    $email = sanitizeInput($data['email']);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return ['success' => false, 'message' => 'Please enter a valid email address.'];
    }
    
    // Validate message length
    $message = sanitizeInput($data['message']);
    if (strlen($message) < 10) {
        return ['success' => false, 'message' => 'Message must be at least 10 characters long.'];
    }
    
    // Prepare contact data
    $contactData = [
        'name' => sanitizeInput($data['name']),
        'email' => $email,
        'phone' => !empty($data['phone']) ? sanitizeInput($data['phone']) : null,
        'subject' => !empty($data['subject']) ? sanitizeInput($data['subject']) : null,
        'message' => $message
    ];
    
    // Save to database
    if ($db->saveContactMessage($contactData)) {
        // Send notification email (you can implement this later)
        // sendContactNotification($contactData);
        
        return [
            'success' => true, 
            'message' => 'Message sent successfully! We will get back to you soon.'
        ];
    } else {
        return ['success' => false, 'message' => 'Failed to send message. Please try again.'];
    }
}

/**
 * Send appointment notification email (placeholder)
 */
function sendAppointmentNotification($data) {
    // TODO: Implement email notification
    // You can use PHPMailer or similar library
    return true;
}

/**
 * Send contact notification email (placeholder)
 */
function sendContactNotification($data) {
    // TODO: Implement email notification
    // You can use PHPMailer or similar library
    return true;
}
?>