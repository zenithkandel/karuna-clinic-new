<?php
require_once __DIR__ . '/_init.php';
requireAdminLogin();

$pageTitle = 'Manage Messages';
$pdo = $db->getPdo();
$csrf = generateCSRFToken();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['csrf_token']) || !verifyCSRFToken($_POST['csrf_token'])) {
        setFlashMessage('error', 'Invalid security token.');
        redirect('messages.php');
    }

    $action = $_POST['action'] ?? '';

    if ($action === 'create') {
        $stmt = $pdo->prepare('INSERT INTO contact_messages (name, email, phone, subject, message, is_read) VALUES (?, ?, ?, ?, ?, ?)');
        $ok = $stmt->execute([
            trim((string) ($_POST['name'] ?? '')),
            trim((string) ($_POST['email'] ?? '')),
            trim((string) ($_POST['phone'] ?? '')),
            trim((string) ($_POST['subject'] ?? '')),
            trim((string) ($_POST['message'] ?? '')),
            isset($_POST['is_read']) ? 1 : 0
        ]);
        setFlashMessage($ok ? 'success' : 'error', $ok ? 'Message created.' : 'Failed to create message.');
        redirect('messages.php');
    }

    if ($action === 'update') {
        $stmt = $pdo->prepare('UPDATE contact_messages SET name = ?, email = ?, phone = ?, subject = ?, message = ?, is_read = ? WHERE id = ?');
        $ok = $stmt->execute([
            trim((string) ($_POST['name'] ?? '')),
            trim((string) ($_POST['email'] ?? '')),
            trim((string) ($_POST['phone'] ?? '')),
            trim((string) ($_POST['subject'] ?? '')),
            trim((string) ($_POST['message'] ?? '')),
            isset($_POST['is_read']) ? 1 : 0,
            (int) ($_POST['id'] ?? 0)
        ]);
        setFlashMessage($ok ? 'success' : 'error', $ok ? 'Message updated.' : 'Failed to update message.');
        redirect('messages.php');
    }

    if ($action === 'delete') {
        $stmt = $pdo->prepare('DELETE FROM contact_messages WHERE id = ?');
        $ok = $stmt->execute([(int) ($_POST['id'] ?? 0)]);
        setFlashMessage($ok ? 'success' : 'error', $ok ? 'Message deleted.' : 'Failed to delete message.');
        redirect('messages.php');
    }
}

$editMessage = null;
if (isset($_GET['edit'])) {
    $stmt = $pdo->prepare('SELECT * FROM contact_messages WHERE id = ?');
    $stmt->execute([(int) $_GET['edit']]);
    $editMessage = $stmt->fetch();
}

$messages = $pdo->query('SELECT * FROM contact_messages ORDER BY id DESC LIMIT 500')->fetchAll();
$flash = getFlashMessage();

include __DIR__ . '/_layout_top.php';
?>

<h1><i class="fas fa-inbox"></i> Manage Messages</h1>
<?php if ($flash): ?>
    <div class="flash <?php echo htmlspecialchars($flash['type']); ?>"><?php echo htmlspecialchars($flash['message']); ?>
    </div><?php endif; ?>

<section class="panel" style="margin-bottom:16px;">
    <h2><?php echo $editMessage ? 'Edit Message' : 'Create Message'; ?></h2>
    <form method="post">
        <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrf); ?>">
        <input type="hidden" name="action" value="<?php echo $editMessage ? 'update' : 'create'; ?>">
        <?php if ($editMessage): ?><input type="hidden" name="id"
                value="<?php echo (int) $editMessage['id']; ?>"><?php endif; ?>

        <div class="grid-cards" style="grid-template-columns: repeat(auto-fit, minmax(240px,1fr));">
            <div class="form-row"><label>Name</label><input name="name" required
                    value="<?php echo htmlspecialchars($editMessage['name'] ?? ''); ?>"></div>
            <div class="form-row"><label>Email</label><input name="email" type="email" required
                    value="<?php echo htmlspecialchars($editMessage['email'] ?? ''); ?>"></div>
            <div class="form-row"><label>Phone</label><input name="phone"
                    value="<?php echo htmlspecialchars($editMessage['phone'] ?? ''); ?>"></div>
            <div class="form-row"><label>Subject</label><input name="subject"
                    value="<?php echo htmlspecialchars($editMessage['subject'] ?? ''); ?>"></div>
        </div>
        <div class="form-row"><label>Message</label><textarea name="message" rows="4"
                required><?php echo htmlspecialchars($editMessage['message'] ?? ''); ?></textarea></div>
        <div class="form-row" style="display:flex; align-items:center; gap:10px;"><input type="checkbox" name="is_read"
                <?php echo !empty($editMessage) && (int) $editMessage['is_read'] === 1 ? 'checked' : ''; ?>><label>Mark as
                read</label></div>
        <div class="btn-row"><button class="btn btn-accent" type="submit"><i class="fas fa-floppy-disk"></i>
                <?php echo $editMessage ? 'Update' : 'Create'; ?></button><?php if ($editMessage): ?><a
                    class="btn btn-ghost" href="messages.php"><i class="fas fa-xmark"></i> Cancel</a><?php endif; ?></div>
    </form>
</section>

<section class="panel">
    <h2>Message Inbox</h2>
    <table class="data-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Status</th>
                <th>Sender</th>
                <th>Email / Phone</th>
                <th>Subject</th>
                <th>Message</th>
                <th>Received</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($messages as $message): ?>
                <tr>
                    <td><?php echo (int) $message['id']; ?></td>
                    <td><?php echo (int) $message['is_read'] === 1 ? 'Read' : 'Unread'; ?></td>
                    <td><?php echo htmlspecialchars($message['name']); ?></td>
                    <td><?php echo htmlspecialchars($message['email']); ?><br><?php echo htmlspecialchars($message['phone'] ?? '-'); ?>
                    </td>
                    <td><?php echo htmlspecialchars($message['subject'] ?? '-'); ?></td>
                    <td><?php echo nl2br(htmlspecialchars($message['message'])); ?></td>
                    <td><?php echo htmlspecialchars($message['created_at']); ?></td>
                    <td>
                        <div class="btn-row">
                            <a class="btn btn-ghost" href="messages.php?edit=<?php echo (int) $message['id']; ?>"><i
                                    class="fas fa-pen"></i> Edit</a>
                            <form method="post" onsubmit="return confirm('Delete this message?');">
                                <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrf); ?>">
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="id" value="<?php echo (int) $message['id']; ?>">
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
