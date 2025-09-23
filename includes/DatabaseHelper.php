<?php
/**
 * Database Helper Class
 * Karuna Swasthya Clinic - Database Operations
 */

require_once __DIR__ . '/../config/database.php';

class DatabaseHelper {
    private static $instance = null;
    private $pdo;
    
    private function __construct() {
        $this->pdo = getDBConnection();
    }
    
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    /**
     * Get all active services
     */
    public function getActiveServices() {
        try {
            $stmt = $this->pdo->query("SELECT * FROM active_services");
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            error_log("Error fetching services: " . $e->getMessage());
            return [];
        }
    }
    
    /**
     * Get all active doctors
     */
    public function getActiveDoctors() {
        try {
            $stmt = $this->pdo->query("SELECT * FROM active_doctors");
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            error_log("Error fetching doctors: " . $e->getMessage());
            return [];
        }
    }
    
    /**
     * Get doctor by ID
     */
    public function getDoctorById($id) {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM doctors WHERE id = ? AND is_active = 1");
            $stmt->execute([$id]);
            return $stmt->fetch();
        } catch (PDOException $e) {
            error_log("Error fetching doctor: " . $e->getMessage());
            return null;
        }
    }
    
    /**
     * Save appointment
     */
    public function saveAppointment($data) {
        try {
            $stmt = $this->pdo->prepare("
                INSERT INTO appointments 
                (doctor_id, patient_name, patient_email, patient_phone, appointment_date, appointment_time, service_type, message) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)
            ");
            
            return $stmt->execute([
                $data['doctor_id'] ?? null,
                $data['patient_name'],
                $data['patient_email'],
                $data['patient_phone'],
                $data['appointment_date'],
                $data['appointment_time'],
                $data['service_type'] ?? null,
                $data['message'] ?? null
            ]);
        } catch (PDOException $e) {
            error_log("Error saving appointment: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Save contact message
     */
    public function saveContactMessage($data) {
        try {
            $stmt = $this->pdo->prepare("
                INSERT INTO contact_messages (name, email, phone, subject, message) 
                VALUES (?, ?, ?, ?, ?)
            ");
            
            return $stmt->execute([
                $data['name'],
                $data['email'],
                $data['phone'] ?? null,
                $data['subject'] ?? null,
                $data['message']
            ]);
        } catch (PDOException $e) {
            error_log("Error saving contact message: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Get approved testimonials
     */
    public function getApprovedTestimonials($limit = 10) {
        try {
            $stmt = $this->pdo->prepare("
                SELECT * FROM testimonials 
                WHERE is_approved = 1 AND is_active = 1 
                ORDER BY created_at DESC 
                LIMIT ?
            ");
            $stmt->execute([$limit]);
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            error_log("Error fetching testimonials: " . $e->getMessage());
            return [];
        }
    }
    
    /**
     * Get site setting by key
     */
    public function getSetting($key) {
        try {
            $stmt = $this->pdo->prepare("SELECT setting_value FROM site_settings WHERE setting_key = ?");
            $stmt->execute([$key]);
            $result = $stmt->fetch();
            return $result ? $result['setting_value'] : null;
        } catch (PDOException $e) {
            error_log("Error fetching setting: " . $e->getMessage());
            return null;
        }
    }
    
    /**
     * Update site setting
     */
    public function updateSetting($key, $value) {
        try {
            $stmt = $this->pdo->prepare("
                INSERT INTO site_settings (setting_key, setting_value) 
                VALUES (?, ?) 
                ON DUPLICATE KEY UPDATE setting_value = VALUES(setting_value)
            ");
            return $stmt->execute([$key, $value]);
        } catch (PDOException $e) {
            error_log("Error updating setting: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Get recent appointments
     */
    public function getRecentAppointments($limit = 10) {
        try {
            $stmt = $this->pdo->prepare("
                SELECT a.*, d.name as doctor_name 
                FROM appointments a 
                LEFT JOIN doctors d ON a.doctor_id = d.id 
                ORDER BY a.created_at DESC 
                LIMIT ?
            ");
            $stmt->execute([$limit]);
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            error_log("Error fetching appointments: " . $e->getMessage());
            return [];
        }
    }
    
    /**
     * Check if database is properly set up
     */
    public function isDatabaseSetup() {
        try {
            // Check if key tables exist
            $tables = ['services', 'doctors', 'appointments', 'contact_messages'];
            foreach ($tables as $table) {
                $stmt = $this->pdo->query("SHOW TABLES LIKE '$table'");
                if ($stmt->rowCount() === 0) {
                    return false;
                }
            }
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }
    
    /**
     * Get database statistics
     */
    public function getStats() {
        try {
            $stats = [];
            
            // Count services
            $stmt = $this->pdo->query("SELECT COUNT(*) as count FROM services WHERE is_active = 1");
            $stats['services'] = $stmt->fetch()['count'];
            
            // Count doctors
            $stmt = $this->pdo->query("SELECT COUNT(*) as count FROM doctors WHERE is_active = 1");
            $stats['doctors'] = $stmt->fetch()['count'];
            
            // Count appointments
            $stmt = $this->pdo->query("SELECT COUNT(*) as count FROM appointments");
            $stats['appointments'] = $stmt->fetch()['count'];
            
            // Count contact messages
            $stmt = $this->pdo->query("SELECT COUNT(*) as count FROM contact_messages");
            $stats['messages'] = $stmt->fetch()['count'];
            
            return $stats;
        } catch (PDOException $e) {
            error_log("Error fetching stats: " . $e->getMessage());
            return ['services' => 0, 'doctors' => 0, 'appointments' => 0, 'messages' => 0];
        }
    }
}
?>