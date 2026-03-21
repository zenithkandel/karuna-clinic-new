<?php
require_once __DIR__ . '/_init.php';
requireAdminLogin();

$pageTitle = 'Manage Testimonials';
$pdo = $db->getPdo();
$csrf = generateCSRFToken();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['csrf_token']) || !verifyCSRFToken($_POST['csrf_token'])) {
        setFlashMessage('error', 'Invalid security token.');
        redirect('testimonials.php');
    }

    $action = $_POST['action'] ?? '';
    $payload = [
        trim((string)($_POST['patient_name'] ?? '')),
        (int)($_POST['rating'] ?? 5),
        trim((string)($_POST['testimonial'] ?? '')),
        trim((string)($_POST['image'] ?? '')),
        isset($_POST['is_approved']) ? 1 : 0,
        isset($_POST['is_active']) ? 1 : 0
    ];

    if ($action === 'create') {
        $stmt = $pdo->prepare('INSERT INTO testimonials (patient_name, rating, testimonial, image, is_approved, is_active) VALUES (?, ?, ?, ?, ?, ?)');
        $ok = $stmt->execute($payload);
        setFlashMessage($ok ? 'success' : 'error', $ok ? 'Testimonial added.' : 'Failed to add testimonial.');
        redirect('testimonials.php');
    }

    if ($action === 'update') {
        $stmt = $pdo->prepare('UPDATE testimonials SET patient_name = ?, rating = ?, testimonial = ?, image = ?, is_approved = ?, is_active = ? WHERE id = ?');
        $ok = $stmt->execute(array_merge($payload, [(int)($_POST['id'] ?? 0)]));
        setFlashMessage($ok ? 'success' : 'error', $ok ? 'Testimonial updated.' : 'Failed to update testimonial.');
        redirect('testimonials.php');
    }

    if ($action === 'delete') {
        $stmt = $pdo->prepare('DELETE FROM testimonials WHERE id = ?');
        $ok = $stmt->execute([(int)($_POST['id'] ?? 0)]);
        setFlashMessage($ok ? 'success' : 'error', $ok ? 'Testimonial deleted.' : 'Failed to delete testimonial.');
        redirect('testimonials.php');
    }
}

$editItem = null;
if (isset($_GET['edit'])) {
    $stmt = $pdo->prepare('SELECT * FROM testimonials WHERE id = ?');
    $stmt->execute([(int)$_GET['edit']]);
    $editItem = $stmt->fetch();
}

$items = $pdo->query('SELECT * FROM testimonials ORDER BY id DESC')->fetchAll();
$flash = getFlashMessage();

include __DIR__ . '/_layout_top.php';
?>

<h1><i class="fas fa-star"></i> Manage Testimonials</h1>
<?php if ($flash): ?><div class="flash <?php echo htmlspecialchars($flash['type']); ?>"><?php echo htmlspecialchars($flash['message']); ?></div><?php endif; ?>

<section class="panel" style="margin-bottom:16px;">
    <h2><?php echo $editItem ? 'Edit Testimonial' : 'Add Testimonial'; ?></h2>
    <form method="post">
        <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrf); ?>">
        <input type="hidden" name="action" value="<?php echo $editItem ? 'update' : 'create'; ?>">
        <?php if ($editItem): ?><input type="hidden" name="id" value="<?php echo (int)$editItem['id']; ?>"><?php endif; ?>

        <div class="grid-cards" style="grid-template-columns: repeat(auto-fit,minmax(260px,1fr));">
            <div class="form-row"><label>Patient Name</label><input name="patient_name" required value="<?php echo htmlspecialchars($editItem['patient_name'] ?? ''); ?>"></div>
            <div class="form-row"><label>Rating (1-5)</label><input type="number" min="1" max="5" name="rating" value="<?php echo htmlspecialchars((string)($editItem['rating'] ?? 5)); ?>"></div>
            <div class="form-row"><label>Image</label><input name="image" value="<?php echo htmlspecialchars($editItem['image'] ?? ''); ?>"></div>
        </div>
        <div class="form-row"><label>Testimonial</label><textarea name="testimonial" rows="4"><?php echo htmlspecialchars($editItem['testimonial'] ?? ''); ?></textarea></div>
        <div class="grid-cards" style="grid-template-columns: repeat(auto-fit,minmax(200px,1fr));">
            <div class="form-row" style="display:flex; align-items:center; gap:10px;"><input type="checkbox" name="is_approved" <?php echo !empty($editItem) && (int)$editItem['is_approved'] === 1 ? 'checked' : ''; ?>><label>Approved</label></div>
            <div class="form-row" style="display:flex; align-items:center; gap:10px;"><input type="checkbox" name="is_active" <?php echo !isset($editItem['is_active']) || (int)($editItem['is_active'] ?? 1) === 1 ? 'checked' : ''; ?>><label>Active</label></div>
        </div>
        <div class="btn-row"><button class="btn btn-accent" type="submit"><i class="fas fa-floppy-disk"></i> <?php echo $editItem ? 'Update' : 'Create'; ?></button><?php if ($editItem): ?><a class="btn btn-ghost" href="testimonials.php"><i class="fas fa-xmark"></i> Cancel</a><?php endif; ?></div>
    </form>
</section>

<section class="panel">
    <h2>Testimonials</h2>
    <table class="data-table">
        <thead><tr><th>ID</th><th>Patient</th><th>Rating</th><th>Approved</th><th>Active</th><th>Actions</th></tr></thead>
        <tbody>
            <?php foreach ($items as $item): ?>
                <tr>
                    <td><?php echo (int)$item['id']; ?></td>
                    <td><?php echo htmlspecialchars($item['patient_name']); ?></td>
                    <td><?php echo (int)$item['rating']; ?></td>
                    <td><?php echo (int)$item['is_approved'] === 1 ? 'Yes' : 'No'; ?></td>
                    <td><?php echo (int)$item['is_active'] === 1 ? 'Yes' : 'No'; ?></td>
                    <td>
                        <div class="btn-row">
                            <a class="btn btn-ghost" href="testimonials.php?edit=<?php echo (int)$item['id']; ?>"><i class="fas fa-pen"></i> Edit</a>
                            <form method="post" onsubmit="return confirm('Delete this testimonial?');">
                                <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrf); ?>">
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="id" value="<?php echo (int)$item['id']; ?>">
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
