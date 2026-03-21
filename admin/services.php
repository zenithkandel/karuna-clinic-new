<?php
require_once __DIR__ . '/_init.php';
requireAdminLogin();

$pageTitle = 'Manage Services';
$pdo = $db->getPdo();
$csrf = generateCSRFToken();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['csrf_token']) || !verifyCSRFToken($_POST['csrf_token'])) {
        setFlashMessage('error', 'Invalid security token.');
        redirect('services.php');
    }

    $action = $_POST['action'] ?? '';
    if ($action === 'create') {
        $stmt = $pdo->prepare('INSERT INTO services (name, description, icon, is_active) VALUES (?, ?, ?, ?)');
        $ok = $stmt->execute([
            trim((string) ($_POST['name'] ?? '')),
            trim((string) ($_POST['description'] ?? '')),
            trim((string) ($_POST['icon'] ?? 'fas fa-stethoscope')),
            isset($_POST['is_active']) ? 1 : 0
        ]);
        setFlashMessage($ok ? 'success' : 'error', $ok ? 'Service added.' : 'Failed to add service.');
        redirect('services.php');
    }

    if ($action === 'update') {
        $stmt = $pdo->prepare('UPDATE services SET name = ?, description = ?, icon = ?, is_active = ? WHERE id = ?');
        $ok = $stmt->execute([
            trim((string) ($_POST['name'] ?? '')),
            trim((string) ($_POST['description'] ?? '')),
            trim((string) ($_POST['icon'] ?? 'fas fa-stethoscope')),
            isset($_POST['is_active']) ? 1 : 0,
            (int) ($_POST['id'] ?? 0)
        ]);
        setFlashMessage($ok ? 'success' : 'error', $ok ? 'Service updated.' : 'Failed to update service.');
        redirect('services.php');
    }

    if ($action === 'delete') {
        $stmt = $pdo->prepare('DELETE FROM services WHERE id = ?');
        $ok = $stmt->execute([(int) ($_POST['id'] ?? 0)]);
        setFlashMessage($ok ? 'success' : 'error', $ok ? 'Service deleted.' : 'Failed to delete service.');
        redirect('services.php');
    }
}

$editService = null;
if (isset($_GET['edit'])) {
    $stmt = $pdo->prepare('SELECT * FROM services WHERE id = ?');
    $stmt->execute([(int) $_GET['edit']]);
    $editService = $stmt->fetch();
}

$services = $pdo->query('SELECT * FROM services ORDER BY id DESC')->fetchAll();
$flash = getFlashMessage();

include __DIR__ . '/_layout_top.php';
?>

<h1><i class="fas fa-stethoscope"></i> Manage Services</h1>
<?php if ($flash): ?>
    <div class="flash <?php echo htmlspecialchars($flash['type']); ?>"><?php echo htmlspecialchars($flash['message']); ?>
    </div><?php endif; ?>

<section class="panel" style="margin-bottom:16px;">
    <h2><?php echo $editService ? 'Edit Service' : 'Add New Service'; ?></h2>
    <form method="post">
        <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrf); ?>">
        <input type="hidden" name="action" value="<?php echo $editService ? 'update' : 'create'; ?>">
        <?php if ($editService): ?><input type="hidden" name="id"
                value="<?php echo (int) $editService['id']; ?>"><?php endif; ?>

        <div class="form-row"><label>Name</label><input name="name" required
                value="<?php echo htmlspecialchars($editService['name'] ?? ''); ?>"></div>
        <div class="form-row"><label>Icon Class</label><input name="icon"
                value="<?php echo htmlspecialchars($editService['icon'] ?? 'fas fa-stethoscope'); ?>"></div>
        <div class="form-row"><label>Description</label><textarea name="description"
                rows="4"><?php echo htmlspecialchars($editService['description'] ?? ''); ?></textarea></div>
        <div class="form-row" style="display:flex; align-items:center; gap:10px;"><input type="checkbox"
                name="is_active" <?php echo !isset($editService['is_active']) || (int) $editService['is_active'] === 1 ? 'checked' : ''; ?>><label>Active</label></div>
        <div class="btn-row">
            <button class="btn btn-accent" type="submit"><i class="fas fa-floppy-disk"></i>
                <?php echo $editService ? 'Update' : 'Create'; ?></button>
            <?php if ($editService): ?><a class="btn btn-ghost" href="services.php"><i class="fas fa-xmark"></i>
                    Cancel</a><?php endif; ?>
        </div>
    </form>
</section>

<section class="panel">
    <h2>Service List</h2>
    <table class="data-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Icon</th>
                <th>Description</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($services as $service): ?>
                <tr>
                    <td><?php echo (int) $service['id']; ?></td>
                    <td><?php echo htmlspecialchars($service['name']); ?></td>
                    <td><i class="<?php echo htmlspecialchars($service['icon']); ?>"></i>
                        <?php echo htmlspecialchars($service['icon']); ?></td>
                    <td><?php echo htmlspecialchars($service['description'] ?? ''); ?></td>
                    <td><?php echo (int) $service['is_active'] === 1 ? 'Active' : 'Inactive'; ?></td>
                    <td>
                        <div class="btn-row">
                            <a class="btn btn-ghost" href="services.php?edit=<?php echo (int) $service['id']; ?>"><i
                                    class="fas fa-pen"></i> Edit</a>
                            <form method="post" onsubmit="return confirm('Delete this service?');">
                                <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrf); ?>">
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="id" value="<?php echo (int) $service['id']; ?>">
                                <button class="btn" style="border:1px solid var(--line);" type="submit"><i
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
