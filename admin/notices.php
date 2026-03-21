<?php
require_once __DIR__ . '/_init.php';
requireAdminLogin();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['csrf_token']) || !verifyCSRFToken($_POST['csrf_token'])) {
        setFlashMessage('error', 'Invalid security token.');
        redirect('notices.php');
    }

    if (isset($_POST['delete_notice'])) {
        $db->deleteNotice((int) $_POST['notice_id']);
        setFlashMessage('success', 'Notice deleted successfully.');
        redirect('notices.php');
    }

    $title = sanitizeInput($_POST['title'] ?? '');
    $description = sanitizeInput($_POST['description'] ?? '');
    $targetUrl = sanitizeInput($_POST['target_url'] ?? '');
    $isActive = isset($_POST['is_active']) ? 1 : 0;
    $imagePath = null;

    if (empty($title) || empty($description)) {
        setFlashMessage('error', 'Title and description are required.');
        redirect('notices.php');
    }

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

    $db->createNotice([
        'title' => $title,
        'description' => $description,
        'target_url' => $targetUrl ?: null,
        'image' => $imagePath,
        'is_active' => $isActive,
        'created_by' => $admin['id'] ?? null
    ]);

    setFlashMessage('success', 'Notice published successfully.');
    redirect('notices.php');
}

$pageTitle = 'Notices';
$notices = $db->getNotices(false, 200);
$flash = getFlashMessage();
$csrf = generateCSRFToken();

include __DIR__ . '/_layout_top.php';
?>

<h1><i class="fas fa-bullhorn"></i> Manage Notices</h1>
<?php if ($flash): ?>
    <div class="flash <?php echo htmlspecialchars($flash['type']); ?>"><?php echo htmlspecialchars($flash['message']); ?>
    </div>
<?php endif; ?>

<section class="panel" style="margin-bottom: 16px;">
    <h2>Create New Notice</h2>
    <form method="post" enctype="multipart/form-data">
        <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrf); ?>">
        <div class="form-row">
            <label for="title">Title</label>
            <input id="title" name="title" required>
        </div>
        <div class="form-row">
            <label for="description">Description</label>
            <textarea id="description" name="description" rows="4" required></textarea>
        </div>
        <div class="form-row">
            <label for="target_url">Target URL</label>
            <input id="target_url" name="target_url" placeholder="https://...">
        </div>
        <div class="form-row">
            <label for="notice_image">Image</label>
            <input id="notice_image" type="file" name="notice_image" accept="image/*">
        </div>
        <div class="form-row" style="display:flex; align-items:center; gap:10px;">
            <input id="is_active" type="checkbox" name="is_active" checked>
            <label for="is_active">Publish now</label>
        </div>
        <button class="btn btn-accent" type="submit"><i class="fas fa-plus"></i> Publish Notice</button>
    </form>
</section>

<section class="panel">
    <h2>All Notices</h2>
    <table class="data-table">
        <thead>
            <tr>
                <th>Title</th>
                <th>Description</th>
                <th>Link</th>
                <th>Image</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($notices as $notice): ?>
                <tr>
                    <td><?php echo htmlspecialchars($notice['title']); ?></td>
                    <td><?php echo htmlspecialchars($notice['description']); ?></td>
                    <td>
                        <?php if (!empty($notice['target_url'])): ?>
                            <a href="<?php echo htmlspecialchars($notice['target_url']); ?>" target="_blank"
                                rel="noopener">Open</a>
                        <?php else: ?>-
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if (!empty($notice['image'])): ?>
                            <img src="../<?php echo htmlspecialchars($notice['image']); ?>" alt="Notice"
                                style="width:80px; height:50px; object-fit:cover;">
                        <?php else: ?>-
                        <?php endif; ?>
                    </td>
                    <td><?php echo (int) $notice['is_active'] === 1 ? 'Active' : 'Draft'; ?></td>
                    <td>
                        <form method="post" onsubmit="return confirm('Delete this notice?');">
                            <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrf); ?>">
                            <input type="hidden" name="notice_id" value="<?php echo (int) $notice['id']; ?>">
                            <button class="btn" style="border:1px solid var(--line);" type="submit"
                                name="delete_notice">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
            <?php if (empty($notices)): ?>
                <tr>
                    <td colspan="6">No notices published yet.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</section>

<?php include __DIR__ . '/_layout_bottom.php';
