<?php
require_once __DIR__ . '/_init.php';
requireAdminLogin();

$pageTitle = 'Manage Appointments';
$pdo = $db->getPdo();
$csrf = generateCSRFToken();

$doctors = $pdo->query('SELECT id, name FROM doctors ORDER BY name ASC')->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['csrf_token']) || !verifyCSRFToken($_POST['csrf_token'])) {
        setFlashMessage('error', 'Invalid security token.');
        redirect('appointments.php');
    }

    $action = $_POST['action'] ?? '';

    if ($action === 'create') {
        $stmt = $pdo->prepare('INSERT INTO appointments (doctor_id, patient_name, patient_email, patient_phone, appointment_date, appointment_time, service_type, message, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)');
        $ok = $stmt->execute([
            !empty($_POST['doctor_id']) ? (int)$_POST['doctor_id'] : null,
            trim((string)($_POST['patient_name'] ?? '')),
            trim((string)($_POST['patient_email'] ?? '')),
            trim((string)($_POST['patient_phone'] ?? '')),
            trim((string)($_POST['appointment_date'] ?? '')),
            trim((string)($_POST['appointment_time'] ?? '')),
            trim((string)($_POST['service_type'] ?? '')),
            trim((string)($_POST['message'] ?? '')),
            trim((string)($_POST['status'] ?? 'pending'))
        ]);
        setFlashMessage($ok ? 'success' : 'error', $ok ? 'Appointment created.' : 'Failed to create appointment.');
        redirect('appointments.php');
    }

    if ($action === 'update') {
        $stmt = $pdo->prepare('UPDATE appointments SET doctor_id = ?, patient_name = ?, patient_email = ?, patient_phone = ?, appointment_date = ?, appointment_time = ?, service_type = ?, message = ?, status = ? WHERE id = ?');
        $ok = $stmt->execute([
            !empty($_POST['doctor_id']) ? (int)$_POST['doctor_id'] : null,
            trim((string)($_POST['patient_name'] ?? '')),
            trim((string)($_POST['patient_email'] ?? '')),
            trim((string)($_POST['patient_phone'] ?? '')),
            trim((string)($_POST['appointment_date'] ?? '')),
            trim((string)($_POST['appointment_time'] ?? '')),
            trim((string)($_POST['service_type'] ?? '')),
            trim((string)($_POST['message'] ?? '')),
            trim((string)($_POST['status'] ?? 'pending')),
            (int)($_POST['id'] ?? 0)
        ]);
        setFlashMessage($ok ? 'success' : 'error', $ok ? 'Appointment updated.' : 'Failed to update appointment.');
        redirect('appointments.php');
    }

    if ($action === 'delete') {
        $stmt = $pdo->prepare('DELETE FROM appointments WHERE id = ?');
        $ok = $stmt->execute([(int)($_POST['id'] ?? 0)]);
        setFlashMessage($ok ? 'success' : 'error', $ok ? 'Appointment deleted.' : 'Failed to delete appointment.');
        redirect('appointments.php');
    }
}

$editAppointment = null;
if (isset($_GET['edit'])) {
    $stmt = $pdo->prepare('SELECT * FROM appointments WHERE id = ?');
    $stmt->execute([(int)$_GET['edit']]);
    $editAppointment = $stmt->fetch();
}

$appointments = $pdo->query('SELECT a.*, d.name AS doctor_name FROM appointments a LEFT JOIN doctors d ON d.id = a.doctor_id ORDER BY a.id DESC')->fetchAll();
$flash = getFlashMessage();

include __DIR__ . '/_layout_top.php';
?>

<h1><i class="fas fa-calendar-check"></i> Manage Appointments</h1>
<?php if ($flash): ?><div class="flash <?php echo htmlspecialchars($flash['type']); ?>"><?php echo htmlspecialchars($flash['message']); ?></div><?php endif; ?>

<section class="panel" style="margin-bottom:16px;">
    <h2><?php echo $editAppointment ? 'Edit Appointment' : 'Create Appointment'; ?></h2>
    <form method="post">
        <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrf); ?>">
        <input type="hidden" name="action" value="<?php echo $editAppointment ? 'update' : 'create'; ?>">
        <?php if ($editAppointment): ?><input type="hidden" name="id" value="<?php echo (int)$editAppointment['id']; ?>"><?php endif; ?>

        <div class="grid-cards" style="grid-template-columns: repeat(auto-fit,minmax(240px,1fr));">
            <div class="form-row"><label>Patient Name</label><input name="patient_name" required value="<?php echo htmlspecialchars($editAppointment['patient_name'] ?? ''); ?>"></div>
            <div class="form-row"><label>Phone</label><input name="patient_phone" required value="<?php echo htmlspecialchars($editAppointment['patient_phone'] ?? ''); ?>"></div>
            <div class="form-row"><label>Email</label><input name="patient_email" type="email" value="<?php echo htmlspecialchars($editAppointment['patient_email'] ?? ''); ?>"></div>
            <div class="form-row"><label>Date</label><input name="appointment_date" type="date" value="<?php echo htmlspecialchars($editAppointment['appointment_date'] ?? ''); ?>"></div>
            <div class="form-row"><label>Time</label><input name="appointment_time" type="time" value="<?php echo htmlspecialchars($editAppointment['appointment_time'] ?? ''); ?>"></div>
            <div class="form-row"><label>Doctor</label><select name="doctor_id"><option value="">Any</option><?php foreach ($doctors as $doctor): ?><option value="<?php echo (int)$doctor['id']; ?>" <?php echo isset($editAppointment['doctor_id']) && (int)$editAppointment['doctor_id'] === (int)$doctor['id'] ? 'selected' : ''; ?>><?php echo htmlspecialchars($doctor['name']); ?></option><?php endforeach; ?></select></div>
            <div class="form-row"><label>Service Type</label><input name="service_type" value="<?php echo htmlspecialchars($editAppointment['service_type'] ?? ''); ?>"></div>
            <div class="form-row"><label>Status</label><select name="status"><?php foreach (['pending','confirmed','cancelled','completed'] as $st): ?><option value="<?php echo $st; ?>" <?php echo ($editAppointment['status'] ?? 'pending') === $st ? 'selected' : ''; ?>><?php echo ucfirst($st); ?></option><?php endforeach; ?></select></div>
        </div>
        <div class="form-row"><label>Message</label><textarea name="message" rows="3"><?php echo htmlspecialchars($editAppointment['message'] ?? ''); ?></textarea></div>
        <div class="btn-row"><button class="btn btn-accent" type="submit"><i class="fas fa-floppy-disk"></i> <?php echo $editAppointment ? 'Update' : 'Create'; ?></button><?php if ($editAppointment): ?><a class="btn btn-ghost" href="appointments.php"><i class="fas fa-xmark"></i> Cancel</a><?php endif; ?></div>
    </form>
</section>

<section class="panel">
    <h2>Appointment List</h2>
    <table class="data-table">
        <thead><tr><th>ID</th><th>Patient</th><th>Phone</th><th>Date</th><th>Time</th><th>Doctor</th><th>Status</th><th>Actions</th></tr></thead>
        <tbody>
            <?php foreach ($appointments as $appointment): ?>
                <tr>
                    <td><?php echo (int)$appointment['id']; ?></td>
                    <td><?php echo htmlspecialchars($appointment['patient_name']); ?></td>
                    <td><?php echo htmlspecialchars($appointment['patient_phone']); ?></td>
                    <td><?php echo htmlspecialchars($appointment['appointment_date']); ?></td>
                    <td><?php echo htmlspecialchars($appointment['appointment_time']); ?></td>
                    <td><?php echo htmlspecialchars($appointment['doctor_name'] ?? 'Any'); ?></td>
                    <td><?php echo htmlspecialchars($appointment['status']); ?></td>
                    <td>
                        <div class="btn-row">
                            <a class="btn btn-ghost" href="appointments.php?edit=<?php echo (int)$appointment['id']; ?>"><i class="fas fa-pen"></i> Edit</a>
                            <form method="post" onsubmit="return confirm('Delete this appointment?');">
                                <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrf); ?>">
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="id" value="<?php echo (int)$appointment['id']; ?>">
                                <button class="btn" style="border:1px solid var(--line);" type="submit"><i class="fas fa-trash"></i> Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</section>

<?php include __DIR__ . '/_layout_bottom.php';
