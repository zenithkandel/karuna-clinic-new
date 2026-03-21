<?php
require_once __DIR__ . '/_init.php';
requireAdminLogin();

$pageTitle = 'Dashboard';
$stats = $db->getStats();
$recentAppointments = $db->getRecentAppointments(8);
$flash = getFlashMessage();
include __DIR__ . '/_layout_top.php';
?>

<h1><i class="fas fa-chart-line"></i> Dashboard</h1>
<?php if ($flash): ?>
    <div class="flash <?php echo htmlspecialchars($flash['type']); ?>"><?php echo htmlspecialchars($flash['message']); ?></div>
<?php endif; ?>

<section class="admin-grid">
    <article class="admin-stat"><strong><?php echo (int) $stats['appointments']; ?></strong><p>Total Appointments</p></article>
    <article class="admin-stat"><strong><?php echo (int) $stats['messages']; ?></strong><p>Total Messages</p></article>
    <article class="admin-stat"><strong><?php echo (int) $stats['unread_messages']; ?></strong><p>Unread Messages</p></article>
    <article class="admin-stat"><strong><?php echo (int) $stats['notices']; ?></strong><p>Active Notices</p></article>
</section>

<section class="panel">
    <h2><i class="fas fa-calendar-days"></i> Recent Appointments</h2>
    <table class="data-table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Phone</th>
                <th>Date</th>
                <th>Time</th>
                <th>Doctor</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($recentAppointments as $appointment): ?>
                <tr>
                    <td><?php echo htmlspecialchars($appointment['patient_name']); ?></td>
                    <td><?php echo htmlspecialchars($appointment['patient_phone']); ?></td>
                    <td><?php echo htmlspecialchars($appointment['appointment_date']); ?></td>
                    <td><?php echo htmlspecialchars($appointment['appointment_time']); ?></td>
                    <td><?php echo htmlspecialchars($appointment['doctor_name'] ?? 'Any'); ?></td>
                </tr>
            <?php endforeach; ?>
            <?php if (empty($recentAppointments)): ?>
                <tr><td colspan="5">No appointment records yet.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</section>

<?php include __DIR__ . '/_layout_bottom.php';
