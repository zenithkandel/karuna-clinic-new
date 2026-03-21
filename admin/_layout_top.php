<?php
if (!isset($pageTitle)) {
    $pageTitle = 'Admin';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($pageTitle); ?> | Admin</title>
    <link rel="stylesheet" href="../CSS/all.css">
    <link rel="stylesheet" href="../CSS/style.css">
</head>
<body>
<div class="admin-shell">
    <aside class="admin-side">
        <h2><i class="fas fa-user-shield"></i> Admin Portal</h2>
        <a href="index.php"><i class="fas fa-chart-line"></i> Dashboard</a>
        <a href="messages.php"><i class="fas fa-inbox"></i> Messages</a>
        <a href="notices.php"><i class="fas fa-bullhorn"></i> Notices</a>
        <a href="settings.php"><i class="fas fa-gear"></i> Settings</a>
        <a href="logout.php"><i class="fas fa-right-from-bracket"></i> Logout</a>
    </aside>
    <main class="admin-content">
