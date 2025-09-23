<?php
/**
 * Database Configuration
 * Karuna Swasthya Clinic - Database Connection
 */

// Database configuration
define('DB_HOST', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'karuna_clinic');

// Create connection
function getDBConnection() {
    try {
        $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4", 
                      DB_USERNAME, 
                      DB_PASSWORD, 
                      [
                          PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                          PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                          PDO::ATTR_EMULATE_PREPARES => false
                      ]);
        return $pdo;
    } catch(PDOException $e) {
        error_log("Database connection failed: " . $e->getMessage());
        die("Database connection failed. Please try again later.");
    }
}

// Test database connection
function testDBConnection() {
    try {
        $pdo = getDBConnection();
        return true;
    } catch(Exception $e) {
        return false;
    }
}
?>