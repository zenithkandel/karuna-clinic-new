<?php
/**
 * Header Template
 * Karuna Swasthya Clinic - Common Header
 */

// Include configuration files
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/functions.php';

$currentPage = getCurrentPage();
$currentTheme = getTheme();
?>
<!DOCTYPE html>
<html lang="en" data-theme="<?php echo $currentTheme; ?>">
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css">
    
    <!-- Custom CSS for animations and themes -->
    <style>
        :root[data-theme="light"] {
            --bg-primary: #ffffff;
            --bg-secondary: #f8fafc;
            --text-primary: #1f2937;
            --text-secondary: #6b7280;
            --accent-primary: #3b82f6;
            --accent-hover: #2563eb;
            --border-color: #e5e7eb;
        }
        
        :root[data-theme="dark"] {
            --bg-primary: #1f2937;
            --bg-secondary: #111827;
            --text-primary: #f9fafb;
            --text-secondary: #d1d5db;
            --accent-primary: #60a5fa;
            --accent-hover: #3b82f6;
            --border-color: #374151;
        }
        
        * {
            transition: background-color 0.3s ease, color 0.3s ease, border-color 0.3s ease;
        }
        
        body {
            background-color: var(--bg-primary);
            color: var(--text-primary);
        }
    </style>
</head>
<body>
    <!-- Theme Toggle Button (Fixed) -->
    <button id="theme-toggle" class="fixed top-4 right-4 z-50 p-3 rounded-full bg-blue-600 text-white shadow-lg hover:bg-blue-700 transition-all duration-300">
        <i class="fas fa-moon" id="theme-icon"></i>
    </button>

    <!-- Navigation -->
    <nav class="bg-white dark:bg-gray-900 shadow-md fixed w-full top-0 z-40 transition-all duration-300">
        <div class="container mx-auto px-6 py-3">
            <div class="flex items-center justify-between">
                <!-- Logo -->
                <div class="flex items-center">
                    <a href="<?php echo SITE_URL; ?>" class="flex items-center">
                        <img src="<?php echo SITE_URL; ?>assets/images/logo.png" alt="<?php echo SITE_NAME; ?>" class="h-12 w-auto">
                        <span class="ml-3 text-xl font-bold text-gray-800 dark:text-white"><?php echo SITE_NAME; ?></span>
                    </a>
                </div>

                <!-- Desktop Navigation -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="<?php echo SITE_URL; ?>" class="nav-link <?php echo isActive('index'); ?> text-gray-700 hover:text-blue-600 dark:text-gray-300 dark:hover:text-blue-400 transition-colors duration-300">
                        <i class="fas fa-home mr-2"></i>Home
                    </a>
                    <a href="<?php echo SITE_URL; ?>pages/about.php" class="nav-link <?php echo isActive('about'); ?> text-gray-700 hover:text-blue-600 dark:text-gray-300 dark:hover:text-blue-400 transition-colors duration-300">
                        <i class="fas fa-info-circle mr-2"></i>About
                    </a>
                    <a href="<?php echo SITE_URL; ?>pages/services.php" class="nav-link <?php echo isActive('services'); ?> text-gray-700 hover:text-blue-600 dark:text-gray-300 dark:hover:text-blue-400 transition-colors duration-300">
                        <i class="fas fa-stethoscope mr-2"></i>Services
                    </a>
                    <a href="<?php echo SITE_URL; ?>pages/doctors.php" class="nav-link <?php echo isActive('doctors'); ?> text-gray-700 hover:text-blue-600 dark:text-gray-300 dark:hover:text-blue-400 transition-colors duration-300">
                        <i class="fas fa-user-md mr-2"></i>Doctors
                    </a>
                    <a href="<?php echo SITE_URL; ?>pages/contact.php" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors duration-300">
                        <i class="fas fa-phone mr-2"></i>Contact
                    </a>
                </div>

                <!-- Mobile Menu Button -->
                <div class="md:hidden">
                    <button id="mobile-menu-button" class="text-gray-700 dark:text-gray-300 focus:outline-none">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                </div>
            </div>

            <!-- Mobile Navigation -->
            <div id="mobile-menu" class="md:hidden mt-4 pb-4 hidden">
                <a href="<?php echo SITE_URL; ?>" class="block py-2 px-4 text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-800 transition-colors duration-300">
                    <i class="fas fa-home mr-2"></i>Home
                </a>
                <a href="<?php echo SITE_URL; ?>pages/about.php" class="block py-2 px-4 text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-800 transition-colors duration-300">
                    <i class="fas fa-info-circle mr-2"></i>About
                </a>
                <a href="<?php echo SITE_URL; ?>pages/services.php" class="block py-2 px-4 text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-800 transition-colors duration-300">
                    <i class="fas fa-stethoscope mr-2"></i>Services
                </a>
                <a href="<?php echo SITE_URL; ?>pages/doctors.php" class="block py-2 px-4 text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-800 transition-colors duration-300">
                    <i class="fas fa-user-md mr-2"></i>Doctors
                </a>
                <a href="<?php echo SITE_URL; ?>pages/contact.php" class="block py-2 px-4 text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-800 transition-colors duration-300">
                    <i class="fas fa-phone mr-2"></i>Contact
                </a>
            </div>
        </div>
    </nav>

    <!-- Main Content (with top margin for fixed nav) -->
    <main class="pt-20">