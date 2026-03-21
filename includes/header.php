<?php
/**
 * Header Template
 * Shared top bar, navigation, and page shell.
 */

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/functions.php';

$currentPage = getCurrentPage();
$clinicName = getSiteSettingValue('clinic_name', SITE_NAME);
$clinicTagline = getSiteSettingValue('clinic_tagline', SITE_TAGLINE);
$clinicPhone = getSiteSettingValue('clinic_phone', CLINIC_PHONE);
$clinicTelephone = getSiteSettingValue('clinic_telephone', CLINIC_TELEPHONE);
$clinicEmail = getSiteSettingValue('clinic_email', CLINIC_EMAIL);
$clinicAddress = getSiteSettingValue('clinic_address', CLINIC_ADDRESS);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description"
        content="<?php echo htmlspecialchars($clinicName); ?> - <?php echo htmlspecialchars($clinicTagline); ?>">
    <meta name="keywords" content="clinic, diabetes center, healthcare, doctors, pokhara">
    <meta name="author" content="<?php echo htmlspecialchars($clinicName); ?>">

    <title>
        <?php echo isset($pageTitle) ? htmlspecialchars($pageTitle) . ' | ' . htmlspecialchars($clinicName) : htmlspecialchars($clinicName); ?>
    </title>

    <link rel="shortcut icon" href="<?php echo SITE_URL; ?>assets/images/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="<?php echo SITE_URL; ?>CSS/all.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="<?php echo SITE_URL; ?>CSS/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,500;9..144,700&family=Manrope:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">
</head>

<body>
    <div class="site-shell">
        <header class="main-header">
            <div class="top-contact-strip">
                <div class="container split-row">
                    <div class="quick-contact">
                        <a href="tel:<?php echo htmlspecialchars($clinicPhone); ?>"><i class="fas fa-phone-volume"></i>
                            <?php echo htmlspecialchars($clinicPhone); ?></a>
                        <a href="tel:<?php echo htmlspecialchars($clinicTelephone); ?>"><i class="fas fa-phone"></i>
                            <?php echo htmlspecialchars($clinicTelephone); ?></a>
                        <a href="mailto:<?php echo htmlspecialchars($clinicEmail); ?>"><i class="fas fa-envelope"></i>
                            <?php echo htmlspecialchars($clinicEmail); ?></a>
                    </div>
                    <div class="quick-address"><i class="fas fa-location-dot"></i>
                        <?php echo htmlspecialchars($clinicAddress); ?></div>
                </div>
            </div>

            <div class="nav-wrap">
                <div class="container nav-row">
                    <a href="<?php echo SITE_URL; ?>index.php" class="brand-lockup">
                        <img src="<?php echo SITE_URL; ?>assets/images/logo.png"
                            alt="<?php echo htmlspecialchars($clinicName); ?>">
                        <span>
                            <strong><?php echo htmlspecialchars($clinicName); ?></strong>
                            <small><?php echo htmlspecialchars($clinicTagline); ?></small>
                        </span>
                    </a>

                    <button class="mobile-toggle" id="mobile-toggle" aria-label="Toggle navigation">
                        <i class="fas fa-bars"></i>
                    </button>

                    <nav class="main-nav" id="main-nav">
                        <a href="<?php echo SITE_URL; ?>index.php"
                            class="<?php echo isActive('index') ? 'active' : ''; ?>"><i class="fas fa-house"></i>
                            Home</a>
                        <a href="<?php echo SITE_URL; ?>pages/about.php"
                            class="<?php echo isActive('about') ? 'active' : ''; ?>"><i class="fas fa-circle-info"></i>
                            About</a>
                        <a href="<?php echo SITE_URL; ?>pages/services.php"
                            class="<?php echo isActive('services') ? 'active' : ''; ?>"><i
                                class="fas fa-stethoscope"></i> Services</a>
                        <a href="<?php echo SITE_URL; ?>pages/doctors.php"
                            class="<?php echo isActive('doctors') ? 'active' : ''; ?>"><i
                                class="fas fa-user-doctor"></i> Doctors</a>
                        <a href="<?php echo SITE_URL; ?>pages/contact.php"
                            class="<?php echo isActive('contact') ? 'active' : ''; ?>"><i
                                class="fas fa-address-book"></i> Contact</a>
                    </nav>

                    <a class="primary-action" href="<?php echo SITE_URL; ?>pages/contact.php#appointment-form"><i
                            class="fas fa-calendar-check"></i> Appointment</a>
                </div>
            </div>
        </header>

        <main>