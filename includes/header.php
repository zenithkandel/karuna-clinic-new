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
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
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
<body class="font-inter bg-white dark:bg-gray-900 text-gray-900 dark:text-white transition-all duration-300">
    
    <!-- Navigation -->
    <nav class="fixed top-0 left-0 right-0 z-50 bg-white/95 dark:bg-gray-900/95 backdrop-blur-sm border-b border-gray-200 dark:border-gray-700 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <!-- Logo -->
                <div class="flex items-center">
                    <a href="<?php echo SITE_URL; ?>" class="flex items-center group">
                        <div class="w-10 h-10 bg-gradient-to-br from-blue-600 to-blue-700 rounded-xl flex items-center justify-center text-white font-bold text-lg shadow-lg group-hover:shadow-xl transition-all duration-300">
                            K
                        </div>
                        <div class="ml-3">
                            <span class="text-xl font-bold text-gray-900 dark:text-white block leading-tight">Karuna</span>
                            <span class="text-xs text-gray-500 dark:text-gray-400 hidden sm:block">Swasthya Clinic</span>
                        </div>
                    </a>
                </div>

                <!-- Desktop Navigation -->
                <div class="hidden lg:flex items-center space-x-8">
                    <a href="<?php echo SITE_URL; ?>" class="nav-link <?php echo isActive('index'); ?>">
                        <i class="fas fa-home mr-2"></i>
                        Home
                    </a>
                    <a href="<?php echo SITE_URL; ?>pages/about.php" class="nav-link <?php echo isActive('about'); ?>">
                        <i class="fas fa-info-circle mr-2"></i>
                        About
                    </a>
                    <a href="<?php echo SITE_URL; ?>pages/services.php" class="nav-link <?php echo isActive('services'); ?>">
                        <i class="fas fa-stethoscope mr-2"></i>
                        Services
                    </a>
                    <a href="<?php echo SITE_URL; ?>pages/doctors.php" class="nav-link <?php echo isActive('doctors'); ?>">
                        <i class="fas fa-user-md mr-2"></i>
                        Doctors
                    </a>
                    <a href="<?php echo SITE_URL; ?>pages/contact.php" class="btn-primary ml-4">
                        <i class="fas fa-phone mr-2"></i>
                        Contact
                    </a>
                </div>

                <!-- Right Side Controls -->
                <div class="flex items-center space-x-4">
                    <!-- Theme Toggle -->
                    <button id="theme-toggle" class="p-2 rounded-lg bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700 transition-all duration-200" aria-label="Toggle theme">
                        <i id="theme-icon" class="fas fa-moon w-5 h-5"></i>
                    </button>

                    <!-- Mobile Menu Button -->
                    <button id="mobile-menu-button" class="lg:hidden p-2 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors duration-200" aria-label="Toggle menu">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Navigation Menu -->
        <div id="mobile-menu" class="lg:hidden bg-white dark:bg-gray-900 border-t border-gray-200 dark:border-gray-700 shadow-lg" style="display: none;">
            <div class="px-4 pt-2 pb-6 space-y-1">
                <a href="<?php echo SITE_URL; ?>" class="mobile-nav-link <?php echo isActive('index'); ?>">
                    <i class="fas fa-home mr-3 w-5"></i>
                    Home
                </a>
                <a href="<?php echo SITE_URL; ?>pages/about.php" class="mobile-nav-link <?php echo isActive('about'); ?>">
                    <i class="fas fa-info-circle mr-3 w-5"></i>
                    About
                </a>
                <a href="<?php echo SITE_URL; ?>pages/services.php" class="mobile-nav-link <?php echo isActive('services'); ?>">
                    <i class="fas fa-stethoscope mr-3 w-5"></i>
                    Services
                </a>
                <a href="<?php echo SITE_URL; ?>pages/doctors.php" class="mobile-nav-link <?php echo isActive('doctors'); ?>">
                    <i class="fas fa-user-md mr-3 w-5"></i>
                    Doctors
                </a>
                <a href="<?php echo SITE_URL; ?>pages/contact.php" class="mobile-nav-link-primary">
                    <i class="fas fa-phone mr-3 w-5"></i>
                    Contact Us
                </a>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="pt-16">