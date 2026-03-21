<?php
header('Content-Type: application/json');

require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/includes/DatabaseHelper.php';

$response = ['success' => false, 'message' => 'Request failed.'];

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $response['message'] = 'Invalid request method.';
    echo json_encode($response);
    exit;
}

if (!isset($_POST['csrf_token']) || !verifyCSRFToken($_POST['csrf_token'])) {
    $response['message'] = 'Security token mismatch. Please refresh and try again.';
    echo json_encode($response);
    exit;
}

$formType = $_POST['form_type'] ?? '';
$db = DatabaseHelper::getInstance();

try {
    if ($formType === 'appointment') {
        $response = processAppointment($db, $_POST);
    } elseif ($formType === 'contact') {
        $response = processContact($db, $_POST);
    } else {
        $response['message'] = 'Unknown form type.';
    }
} catch (Exception $e) {
    error_log('Form processing error: ' . $e->getMessage());
    $response['message'] = 'Unexpected error occurred while processing the form.';
}

echo json_encode($response);
exit;

function processAppointment($db, $input) {
    $required = ['patient_name', 'patient_phone', 'appointment_date', 'appointment_time'];
    foreach ($required as $field) {
        if (empty($input[$field])) {
            return ['success' => false, 'message' => 'Please fill all required appointment fields.'];
        }
    }

    $cleanPhone = preg_replace('/[^0-9+]/', '', (string)$input['patient_phone']);
    if (strlen($cleanPhone) < 10) {
        return ['success' => false, 'message' => 'Please enter a valid phone number.'];
    }

    if (!empty($input['patient_email']) && !filter_var($input['patient_email'], FILTER_VALIDATE_EMAIL)) {
        return ['success' => false, 'message' => 'Please enter a valid email address.'];
    }

    if (strtotime($input['appointment_date']) < strtotime(date('Y-m-d'))) {
        return ['success' => false, 'message' => 'Appointment date cannot be in the past.'];
    }

    $payload = [
        'doctor_id' => !empty($input['doctor_id']) ? (int)$input['doctor_id'] : null,
        'patient_name' => sanitizeInput($input['patient_name']),
        'patient_email' => !empty($input['patient_email']) ? sanitizeInput($input['patient_email']) : null,
        'patient_phone' => sanitizeInput($input['patient_phone']),
        'appointment_date' => sanitizeInput($input['appointment_date']),
        'appointment_time' => sanitizeInput($input['appointment_time']),
        'service_type' => !empty($input['service_type']) ? sanitizeInput($input['service_type']) : null,
        'message' => !empty($input['message']) ? sanitizeInput($input['message']) : null,
    ];

    if (!$db->saveAppointment($payload)) {
        return ['success' => false, 'message' => 'Failed to save appointment. Please try again.'];
    }

    $recipient = $db->getSetting('message_forward_email', CLINIC_EMAIL);
    $subject = 'New Appointment Request - ' . $payload['patient_name'];
    $body = "New appointment request received:\n\n"
        . "Name: {$payload['patient_name']}\n"
        . "Phone: {$payload['patient_phone']}\n"
        . "Email: " . ($payload['patient_email'] ?? '-') . "\n"
        . "Date: {$payload['appointment_date']}\n"
        . "Time: {$payload['appointment_time']}\n"
        . "Service: " . ($payload['service_type'] ?? '-') . "\n"
        . "Message: " . ($payload['message'] ?? '-') . "\n";

    sendNotificationEmail($recipient, $subject, $body);

    return ['success' => true, 'message' => 'Appointment request submitted successfully.'];
}

function processContact($db, $input) {
    $required = ['name', 'email', 'message'];
    foreach ($required as $field) {
        if (empty($input[$field])) {
            return ['success' => false, 'message' => 'Please fill all required contact fields.'];
        }
    }

    if (!filter_var($input['email'], FILTER_VALIDATE_EMAIL)) {
        return ['success' => false, 'message' => 'Please enter a valid email address.'];
    }

    if (strlen(trim((string)$input['message'])) < 10) {
        return ['success' => false, 'message' => 'Message should be at least 10 characters.'];
    }

    $payload = [
        'name' => sanitizeInput($input['name']),
        'email' => sanitizeInput($input['email']),
        'phone' => !empty($input['phone']) ? sanitizeInput($input['phone']) : null,
        'subject' => !empty($input['subject']) ? sanitizeInput($input['subject']) : null,
        'message' => sanitizeInput($input['message']),
    ];

    if (!$db->saveContactMessage($payload)) {
        return ['success' => false, 'message' => 'Failed to send message. Please try again.'];
    }

    $recipient = $db->getSetting('message_forward_email', CLINIC_EMAIL);
    $subject = 'New Contact Message - ' . $payload['name'];
    $body = "New contact message received:\n\n"
        . "Name: {$payload['name']}\n"
        . "Email: {$payload['email']}\n"
        . "Phone: " . ($payload['phone'] ?? '-') . "\n"
        . "Subject: " . ($payload['subject'] ?? '-') . "\n"
        . "Message: {$payload['message']}\n";

    sendNotificationEmail($recipient, $subject, $body);

    return ['success' => true, 'message' => 'Message sent successfully.'];
}

function sendNotificationEmail($to, $subject, $body) {
    if (!filter_var($to, FILTER_VALIDATE_EMAIL)) {
        return false;
    }

    $headers = [];
    $headers[] = 'MIME-Version: 1.0';
    $headers[] = 'Content-type: text/plain; charset=UTF-8';
    $headers[] = 'From: Karuna Clinic <noreply@karunaclinic.local>';

    return @mail($to, $subject, $body, implode("\r\n", $headers));
}
