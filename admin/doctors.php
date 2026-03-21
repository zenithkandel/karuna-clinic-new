<?php
require_once __DIR__ . '/_init.php';
requireAdminLogin();

$pageTitle = 'Manage Doctors';
$pdo = $db->getPdo();
$csrf = generateCSRFToken();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['csrf_token']) || !verifyCSRFToken($_POST['csrf_token'])) {
        setFlashMessage('error', 'Invalid security token.');
        redirect('doctors.php');
    }

    $action = $_POST['action'] ?? '';
    $payload = [
        trim((string) ($_POST['name'] ?? '')),
        trim((string) ($_POST['title'] ?? '')),
        trim((string) ($_POST['specialization'] ?? '')),
        trim((string) ($_POST['qualification'] ?? '')),
        (int) ($_POST['experience_years'] ?? 0),
        trim((string) ($_POST['bio'] ?? '')),
        trim((string) ($_POST['image'] ?? '')),
        trim((string) ($_POST['phone'] ?? '')),
        trim((string) ($_POST['email'] ?? '')),
        trim((string) ($_POST['schedule'] ?? '{}')),
        isset($_POST['is_active']) ? 1 : 0
    ];

    if ($action === 'create') {
        $stmt = $pdo->prepare('INSERT INTO doctors (name, title, specialization, qualification, experience_years, bio, image, phone, email, schedule, is_active) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
        $ok = $stmt->execute($payload);
        setFlashMessage($ok ? 'success' : 'error', $ok ? 'Doctor added.' : 'Failed to add doctor.');
        redirect('doctors.php');
    }

    if ($action === 'update') {
        $stmt = $pdo->prepare('UPDATE doctors SET name = ?, title = ?, specialization = ?, qualification = ?, experience_years = ?, bio = ?, image = ?, phone = ?, email = ?, schedule = ?, is_active = ? WHERE id = ?');
        $ok = $stmt->execute(array_merge($payload, [(int) ($_POST['id'] ?? 0)]));
        setFlashMessage($ok ? 'success' : 'error', $ok ? 'Doctor updated.' : 'Failed to update doctor.');
        redirect('doctors.php');
    }

    if ($action === 'delete') {
        $stmt = $pdo->prepare('DELETE FROM doctors WHERE id = ?');
        $ok = $stmt->execute([(int) ($_POST['id'] ?? 0)]);
        setFlashMessage($ok ? 'success' : 'error', $ok ? 'Doctor deleted.' : 'Failed to delete doctor.');
        redirect('doctors.php');
    }
}

$editDoctor = null;
if (isset($_GET['edit'])) {
    $stmt = $pdo->prepare('SELECT * FROM doctors WHERE id = ?');
    $stmt->execute([(int) $_GET['edit']]);
    $editDoctor = $stmt->fetch();
}

$doctors = $pdo->query('SELECT * FROM doctors ORDER BY id DESC')->fetchAll();
$flash = getFlashMessage();

include __DIR__ . '/_layout_top.php';
?>

<h1><i class="fas fa-user-doctor"></i> Manage Doctors</h1>
<?php if ($flash): ?>
    <div class="flash <?php echo htmlspecialchars($flash['type']); ?>"><?php echo htmlspecialchars($flash['message']); ?>
    </div><?php endif; ?>

<section class="panel" style="margin-bottom:16px;">
    <h2><?php echo $editDoctor ? 'Edit Doctor' : 'Add New Doctor'; ?></h2>
    <form method="post">
        <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrf); ?>">
        <input type="hidden" name="action" value="<?php echo $editDoctor ? 'update' : 'create'; ?>">
        <?php if ($editDoctor): ?><input type="hidden" name="id"
                value="<?php echo (int) $editDoctor['id']; ?>"><?php endif; ?>

        <div class="grid-cards" style="grid-template-columns: repeat(auto-fit, minmax(260px,1fr));">
            <div class="form-row"><label>Name</label><input name="name" required
                    value="<?php echo htmlspecialchars($editDoctor['name'] ?? ''); ?>"></div>
            <div class="form-row"><label>Title</label><input name="title"
                    value="<?php echo htmlspecialchars($editDoctor['title'] ?? ''); ?>"></div>
            <div class="form-row"><label>Specialization</label><input name="specialization"
                    value="<?php echo htmlspecialchars($editDoctor['specialization'] ?? ''); ?>"></div>
            <div class="form-row"><label>Qualification</label><input name="qualification"
                    value="<?php echo htmlspecialchars($editDoctor['qualification'] ?? ''); ?>"></div>
            <div class="form-row"><label>Experience Years</label><input type="number" name="experience_years"
                    value="<?php echo htmlspecialchars((string) ($editDoctor['experience_years'] ?? 0)); ?>"></div>
            <div class="form-row"><label>Image Filename (assets/images/...)</label><input name="image"
                    value="<?php echo htmlspecialchars($editDoctor['image'] ?? ''); ?>"></div>
            <div class="form-row"><label>Phone</label><input name="phone"
                    value="<?php echo htmlspecialchars($editDoctor['phone'] ?? ''); ?>"></div>
            <div class="form-row"><label>Email</label><input name="email" type="email"
                    value="<?php echo htmlspecialchars($editDoctor['email'] ?? ''); ?>"></div>
        </div>
        <div class="form-row"><label>Schedule JSON</label><textarea name="schedule"
                rows="3"><?php echo htmlspecialchars($editDoctor['schedule'] ?? '{}'); ?></textarea></div>
        <div class="form-row"><label>Bio</label><textarea name="bio"
                rows="4"><?php echo htmlspecialchars($editDoctor['bio'] ?? ''); ?></textarea></div>
        <div class="form-row" style="display:flex; align-items:center; gap:10px;"><input type="checkbox"
                name="is_active" <?php echo !isset($editDoctor['is_active']) || (int) $editDoctor['is_active'] === 1 ? 'checked' : ''; ?>><label>Active</label></div>
        <div class="btn-row">
            <button class="btn btn-accent" type="submit"><i class="fas fa-floppy-disk"></i>
                <?php echo $editDoctor ? 'Update' : 'Create'; ?></button>
            <?php if ($editDoctor): ?><a class="btn btn-ghost" href="doctors.php"><i class="fas fa-xmark"></i>
                    Cancel</a><?php endif; ?>
        </div>
    </form>
</section>

<section class="panel">
    <h2>Doctor List</h2>
    <table class="data-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Specialization</th>
                <th>Phone</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($doctors as $doctor): ?>
                <tr>
                    <td><?php echo (int) $doctor['id']; ?></td>
                    <td><?php echo htmlspecialchars($doctor['name']); ?></td>
                    <td><?php echo htmlspecialchars($doctor['specialization']); ?></td>
                    <td><?php echo htmlspecialchars($doctor['phone'] ?? '-'); ?></td>
                    <td><?php echo (int) $doctor['is_active'] === 1 ? 'Active' : 'Inactive'; ?></td>
                    <td>
                        <div class="btn-row">
                            <a class="btn btn-ghost" href="doctors.php?edit=<?php echo (int) $doctor['id']; ?>"><i
                                    class="fas fa-pen"></i> Edit</a>
                            <form method="post" onsubmit="return confirm('Delete this doctor?');">
                                <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrf); ?>">
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="id" value="<?php echo (int) $doctor['id']; ?>">
                                <button class="btn" style="border:1px solid var(--gray-300);" type="submit"><i
                                        class="fas fa-trash"></i> Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</section>

<?php include __DIR__ . '/_layout_bottom.php';
