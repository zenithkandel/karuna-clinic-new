<?php
/**
 * Header Template
 * Karuna Swasthya Clinic - Modern & Clean Header
 */

// Include configuration files
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/functions.php';

$currentPage = getCurrentPage();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?php echo SITE_NAME; ?> - <?php echo SITE_TAGLINE; ?>">
    <meta name="keywords" content="healthcare, diabetes, clinic, orthopedic, physiotherapy, Pokhara">
    <meta name="author" content="<?php echo SITE_NAME; ?>">
    
    <title><?php echo isset($pageTitle) ? $pageTitle . ' - ' . SITE_NAME : SITE_NAME; ?></title>
    
    <!-- Favicon -->
    <link rel="shortcut icon" href="<?php echo SITE_URL; ?>assets/images/favicon.ico" type="image/x-icon">
    
    <!-- CSS Files -->
    <link rel="stylesheet" href="<?php echo SITE_URL; ?>CSS/all.css">
    <link rel="stylesheet" href="<?php echo SITE_URL; ?>CSS/style.css">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <script>
        // Prevent flash of unstyled content - Set theme immediately
        (function() {
            const theme = localStorage.getItem('theme') || 'light';
            document.documentElement.setAttribute('data-theme', theme);
            if (theme === 'dark') {
                document.documentElement.classList.add('dark');
            }
        })();
    </script>
</head>
<body>
    
    <!-- Navigation -->
    <nav class="navbar">
        <div class="nav-container">
            <div class="nav-wrapper">
                <!-- Logo -->
                <div class="nav-logo">
                    <a href="<?php echo SITE_URL; ?>" class="logo-link">
                        <div class="logo-icon">
                            K
                        </div>
                        <div class="logo-text">
                            <span class="logo-title">Karuna</span>
                            <span class="logo-subtitle">Swasthya Clinic</span>
                        </div>
                    </a>
                </div>

                <!-- Desktop Navigation -->
                <div class="nav-menu">
                    <a href="<?php echo SITE_URL; ?>" class="nav-link <?php echo isActive('index'); ?>">
                        <i class="fas fa-home"></i>
                        Home
                    </a>
                    <a href="<?php echo SITE_URL; ?>pages/about.php" class="nav-link <?php echo isActive('about'); ?>">
                        <i class="fas fa-info-circle"></i>
                        About
                    </a>
                    <a href="<?php echo SITE_URL; ?>pages/services.php" class="nav-link <?php echo isActive('services'); ?>">
                        <i class="fas fa-stethoscope"></i>
                        Services
                    </a>
                    <a href="<?php echo SITE_URL; ?>pages/doctors.php" class="nav-link <?php echo isActive('doctors'); ?>">
                        <i class="fas fa-user-md"></i>
                        Doctors
                    </a>
                    <a href="<?php echo SITE_URL; ?>pages/contact.php" class="btn-primary nav-contact">
                        <i class="fas fa-phone"></i>
                        Contact
                    </a>
                </div>

                <!-- Right Side Controls -->
                <div class="nav-controls">
                    <!-- Theme Toggle -->
                    <button id="theme-toggle" class="theme-toggle" aria-label="Toggle theme">
                        <i id="theme-icon" class="fas fa-moon"></i>
                    </button>

                    <!-- Mobile Menu Button -->
                    <button id="mobile-menu-button" class="mobile-menu-button" aria-label="Toggle menu">
                        <span class="hamburger-line"></span>
                        <span class="hamburger-line"></span>
                        <span class="hamburger-line"></span>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Navigation Menu -->
        <div id="mobile-menu" class="mobile-menu">
            <div class="mobile-menu-content">
                <a href="<?php echo SITE_URL; ?>" class="mobile-nav-link <?php echo isActive('index'); ?>">
                    <i class="fas fa-home"></i>
                    Home
                </a>
                <a href="<?php echo SITE_URL; ?>pages/about.php" class="mobile-nav-link <?php echo isActive('about'); ?>">
                    <i class="fas fa-info-circle"></i>
                    About
                </a>
                <a href="<?php echo SITE_URL; ?>pages/services.php" class="mobile-nav-link <?php echo isActive('services'); ?>">
                    <i class="fas fa-stethoscope"></i>
                    Services
                </a>
                <a href="<?php echo SITE_URL; ?>pages/doctors.php" class="mobile-nav-link <?php echo isActive('doctors'); ?>">
                    <i class="fas fa-user-md"></i>
                    Doctors
                </a>
                <a href="<?php echo SITE_URL; ?>pages/contact.php" class="mobile-nav-link mobile-nav-contact">
                    <i class="fas fa-phone"></i>
                    Contact Us
                </a>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="main-content">