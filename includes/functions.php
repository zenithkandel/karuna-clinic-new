<?php
/**
 * Common Functions
 * Karuna Swasthya Clinic - Utility Functions
 */

/**
 * Sanitize input data
 */
function sanitizeInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

/**
 * Generate CSRF Token
 */
function generateCSRFToken() {
    if (!isset($_SESSION[CSRF_TOKEN_NAME])) {
        $_SESSION[CSRF_TOKEN_NAME] = bin2hex(random_bytes(32));
    }
    return $_SESSION[CSRF_TOKEN_NAME];
}

/**
 * Verify CSRF Token
 */
function verifyCSRFToken($token) {
    return isset($_SESSION[CSRF_TOKEN_NAME]) && hash_equals($_SESSION[CSRF_TOKEN_NAME], $token);
}

/**
 * Redirect function
 */
function redirect($url) {
    header("Location: " . $url);
    exit();
}

/**
 * Get current page name
 */
function getCurrentPage() {
    return basename($_SERVER['PHP_SELF'], '.php');
}

/**
 * Format phone number for display
 */
function formatPhone($phone) {
    return preg_replace('/(\+977)(\s*)(\d{10})/', '$1 $3', $phone);
}

/**
 * Get theme preference
 */
function getTheme() {
    return isset($_COOKIE['theme']) ? $_COOKIE['theme'] : DEFAULT_THEME;
}

/**
 * Set theme preference
 */
function setTheme($theme) {
    setcookie('theme', $theme, time() + (365 * 24 * 60 * 60), '/'); // 1 year
}

/**
 * Check if current page is active (for navigation)
 */
function isActive($page) {
    return getCurrentPage() === $page ? 'active' : '';
}

/**
 * Debug function (only works when DEBUG_MODE is true)
 */
function debug($data, $die = false) {
    if (DEBUG_MODE) {
        echo '<pre>';
        var_dump($data);
        echo '</pre>';
        if ($die) die();
    }
}
?>