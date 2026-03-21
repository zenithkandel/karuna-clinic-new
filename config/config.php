<?php
/**
 * Application Configuration
 * Karuna Swasthya Clinic - Main Configuration File
 */

// Site Configuration
define('SITE_NAME', 'Karuna Swasthya Clinic');
define('SITE_TAGLINE', 'Professional Healthcare & Diabetes Care');

// Dynamic base URL detection
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https://' : 'http://';
$host = $_SERVER['HTTP_HOST'] ?? 'localhost';
$scriptPath = dirname($_SERVER['SCRIPT_NAME'] ?? '');
// Navigate to project root from wherever the script is loaded
$rootPath = rtrim(str_replace('\\', '/', $scriptPath), '/');
// Remove /admin, /pages, /includes, /config segments to get to project root
$rootPath = preg_replace('#/(admin|pages|includes|config)$#', '', $rootPath);
define('SITE_URL', $protocol . $host . $rootPath . '/');

// Contact Information
define('CLINIC_PHONE', '+977 9766597210');
define('CLINIC_TELEPHONE', '061-591885');
define('CLINIC_EMAIL', 'karunaswasthyaclinic@gmail.com');
define('CLINIC_ADDRESS', 'Ratna Chowk, Street No 22, Pokhara, Kaski');

// Operating Hours
define('CLINIC_HOURS', 'Sun-Fri: 7:00 AM - 7:00 PM');
define('CLINIC_EMERGENCY', '24/7 Emergency Services');

// Theme Settings
define('DEFAULT_THEME', 'light');
define('ENABLE_THEME_SWITCHING', true);

// Security Settings
define('CSRF_TOKEN_NAME', 'csrf_token');
define('SESSION_TIMEOUT', 3600); // 1 hour

// Error Reporting (set to false in production)
define('DEBUG_MODE', true);

if (DEBUG_MODE) {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
}

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>