<?php
if (!isset($pageTitle)) {
    $pageTitle = 'Admin';
}
$adminCurrentPage = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($pageTitle); ?> | Admin</title>
    <link rel="stylesheet" href="../CSS/all.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="../CSS/style.css">
</head>

<body>
    <div class="admin-shell">
        <aside class="admin-side">
            <h2><i class="fas fa-user-shield"></i> Admin Portal</h2>
            <a class="<?php echo $adminCurrentPage === 'index.php' ? 'active' : ''; ?>" href="index.php"><i class="fas fa-chart-line"></i> Dashboard</a>
            <a class="<?php echo $adminCurrentPage === 'services.php' ? 'active' : ''; ?>" href="services.php"><i class="fas fa-stethoscope"></i> Manage Services</a>
            <a class="<?php echo $adminCurrentPage === 'doctors.php' ? 'active' : ''; ?>" href="doctors.php"><i class="fas fa-user-doctor"></i> Manage Doctors</a>
            <a class="<?php echo $adminCurrentPage === 'appointments.php' ? 'active' : ''; ?>" href="appointments.php"><i class="fas fa-calendar-check"></i> Manage Appointments</a>
            <a class="<?php echo $adminCurrentPage === 'messages.php' ? 'active' : ''; ?>" href="messages.php"><i class="fas fa-inbox"></i> Manage Messages</a>
            <a class="<?php echo $adminCurrentPage === 'notices.php' ? 'active' : ''; ?>" href="notices.php"><i class="fas fa-bullhorn"></i> Manage Notices</a>
            <a class="<?php echo $adminCurrentPage === 'testimonials.php' ? 'active' : ''; ?>" href="testimonials.php"><i class="fas fa-star"></i> Manage Testimonials</a>
            <a class="<?php echo $adminCurrentPage === 'admin-users.php' ? 'active' : ''; ?>" href="admin-users.php"><i class="fas fa-users-cog"></i> Manage Admin Users</a>
            <a class="<?php echo $adminCurrentPage === 'settings.php' ? 'active' : ''; ?>" href="settings.php"><i class="fas fa-gear"></i> Settings</a>
            <a href="logout.php"><i class="fas fa-right-from-bracket"></i> Logout</a>
        </aside>
        <main class="admin-content">