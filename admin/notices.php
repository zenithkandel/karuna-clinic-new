<?php
require_once __DIR__ . '/_init.php';
requireAdminLogin();

$pageTitle = 'Manage Notices';
$pdo = $db->getPdo();
$csrf = generateCSRFToken();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['csrf_token']) || !verifyCSRFToken($_POST['csrf_token'])) {
        setFlashMessage('error', 'Invalid security token.');
        redirect('notices.php');
    }

    $action = $_POST['action'] ?? '';
    $title = trim((string) ($_POST['title'] ?? ''));
    $description = trim((string) ($_POST['description'] ?? ''));
    $targetUrl = trim((string) ($_POST['target_url'] ?? ''));
    $isActive = isset($_POST['is_active']) ? 1 : 0;

    $imagePath = trim((string) ($_POST['existing_image'] ?? ''));
    if (!empty($_FILES['notice_image']['name']) && is_uploaded_file($_FILES['notice_image']['tmp_name'])) {
        $ext = strtolower(pathinfo($_FILES['notice_image']['name'], PATHINFO_EXTENSION));
        $allowed = ['jpg', 'jpeg', 'png', 'webp', 'gif'];
        if (in_array($ext, $allowed, true)) {
            $filename = 'notice_' . time() . '_' . mt_rand(1000, 9999) . '.' . $ext;
            $target = __DIR__ . '/../assets/images/notices/' . $filename;
            if (move_uploaded_file($_FILES['notice_image']['tmp_name'], $target)) {
                $imagePath = 'assets/images/notices/' . $filename;
            }
        }
    }

    if ($action === 'create') {
        $stmt = $pdo->prepare('INSERT INTO notices (title, description, target_url, image, is_active, created_by) VALUES (?, ?, ?, ?, ?, ?)');
        $ok = $stmt->execute([$title, $description, $targetUrl ?: null, $imagePath ?: null, $isActive, $admin['id'] ?? null]);
        setFlashMessage($ok ? 'success' : 'error', $ok ? 'Notice created.' : 'Failed to create notice.');
        redirect('notices.php');
    }

    if ($action === 'update') {
        $stmt = $pdo->prepare('UPDATE notices SET title = ?, description = ?, target_url = ?, image = ?, is_active = ? WHERE id = ?');
        $ok = $stmt->execute([$title, $description, $targetUrl ?: null, $imagePath ?: null, $isActive, (int) ($_POST['id'] ?? 0)]);
        setFlashMessage($ok ? 'success' : 'error', $ok ? 'Notice updated.' : 'Failed to update notice.');
        redirect('notices.php');
    }

    if ($action === 'delete') {
        $stmt = $pdo->prepare('DELETE FROM notices WHERE id = ?');
        $ok = $stmt->execute([(int) ($_POST['id'] ?? 0)]);
        setFlashMessage($ok ? 'success' : 'error', $ok ? 'Notice deleted.' : 'Failed to delete notice.');
        redirect('notices.php');
    }
}

$editNotice = null;
if (isset($_GET['edit'])) {
    $stmt = $pdo->prepare('SELECT * FROM notices WHERE id = ?');
    $stmt->execute([(int) $_GET['edit']]);
    $editNotice = $stmt->fetch();
}

$notices = $pdo->query('SELECT * FROM notices ORDER BY id DESC')->fetchAll();
$flash = getFlashMessage();

include __DIR__ . '/_layout_top.php';
?>

<h1><i class="fas fa-bullhorn"></i> Manage Notices</h1>
<?php if ($flash): ?>
    <div class="flash <?php echo htmlspecialchars($flash['type']); ?>"><?php echo htmlspecialchars($flash['message']); ?>
    </div><?php endif; ?>

<section class="panel" style="margin-bottom:16px;">
    <h2><?php echo $editNotice ? 'Edit Notice' : 'Create Notice'; ?></h2>
    <form method="post" enctype="multipart/form-data">
        <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrf); ?>">
        <input type="hidden" name="action" value="<?php echo $editNotice ? 'update' : 'create'; ?>">
        <?php if ($editNotice): ?><input type="hidden" name="id"
                value="<?php echo (int) $editNotice['id']; ?>"><?php endif; ?>
        <input type="hidden" name="existing_image" value="<?php echo htmlspecialchars($editNotice['image'] ?? ''); ?>">

        <div class="form-row"><label>Title</label><input name="title" required
                value="<?php echo htmlspecialchars($editNotice['title'] ?? ''); ?>"></div>
        <div class="form-row"><label>Description</label><textarea name="description" rows="4"
                required><?php echo htmlspecialchars($editNotice['description'] ?? ''); ?></textarea></div>
        <div class="form-row"><label>Target URL</label><input name="target_url"
                value="<?php echo htmlspecialchars($editNotice['target_url'] ?? ''); ?>"></div>
        <div class="form-row"><label>Notice Image</label><input type="file" name="notice_image" accept="image/*"></div>
        <?php if (!empty($editNotice['image'])): ?>
            <p style="color:var(--ink-soft); margin-bottom:10px;">Current image:
                <?php echo htmlspecialchars($editNotice['image']); ?></p><?php endif; ?>
        <div class="form-row" style="display:flex; align-items:center; gap:10px;"><input type="checkbox"
                name="is_active" <?php echo !isset($editNotice['is_active']) || (int) ($editNotice['is_active'] ?? 1) === 1 ? 'checked' : ''; ?>><label>Active</label></div>
        <div class="btn-row"><button class="btn btn-accent" type="submit"><i class="fas fa-floppy-disk"></i>
                <?php echo $editNotice ? 'Update' : 'Create'; ?></button><?php if ($editNotice): ?><a
                    class="btn btn-ghost" href="notices.php"><i class="fas fa-xmark"></i> Cancel</a><?php endif; ?></div>
    </form>
</section>

<section class="panel">
    <h2>Notice List</h2>
    <table class="data-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Description</th>
                <th>Image</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($notices as $notice): ?>
                <tr>
                    <td><?php echo (int) $notice['id']; ?></td>
                    <td><?php echo htmlspecialchars($notice['title']); ?></td>
                    <td><?php echo htmlspecialchars($notice['description']); ?></td>
                    <td><?php if (!empty($notice['image'])): ?><img
                                src="../<?php echo htmlspecialchars($notice['image']); ?>" alt="Notice"
                                style="width:90px; height:58px; object-fit:cover;"><?php else: ?>-<?php endif; ?></td>
                    <td><?php echo (int) $notice['is_active'] === 1 ? 'Active' : 'Inactive'; ?></td>
                    <td>
                        <div class="btn-row">
                            <a class="btn btn-ghost" href="notices.php?edit=<?php echo (int) $notice['id']; ?>"><i
                                    class="fas fa-pen"></i> Edit</a>
                            <form method="post" onsubmit="return confirm('Delete this notice?');">
                                <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrf); ?>">
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="id" value="<?php echo (int) $notice['id']; ?>">
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
