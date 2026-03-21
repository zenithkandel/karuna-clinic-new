<?php
require_once __DIR__ . '/_init.php';
requireAdminLogin();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['mark_read'])) {
    if (isset($_POST['csrf_token']) && verifyCSRFToken($_POST['csrf_token'])) {
        $db->markMessageRead((int) $_POST['message_id']);
        setFlashMessage('success', 'Message marked as read.');
    }
    redirect('messages.php');
}

$pageTitle = 'Messages';
$messages = $db->getContactMessages(500);
$flash = getFlashMessage();
$csrf = generateCSRFToken();

include __DIR__ . '/_layout_top.php';
?>

<h1><i class="fas fa-inbox"></i> Message Inbox</h1>
<?php if ($flash): ?>
    <div class="flash <?php echo htmlspecialchars($flash['type']); ?>"><?php echo htmlspecialchars($flash['message']); ?>
    </div>
<?php endif; ?>

<section class="panel">
    <table class="data-table">
        <thead>
            <tr>
                <th>Status</th>
                <th>Sender</th>
                <th>Email / Phone</th>
                <th>Subject</th>
                <th>Message</th>
                <th>Received</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($messages as $message): ?>
                <tr>
                    <td><?php echo (int) $message['is_read'] === 1 ? 'Read' : 'Unread'; ?></td>
                    <td><?php echo htmlspecialchars($message['name']); ?></td>
                    <td>
                        <?php echo htmlspecialchars($message['email']); ?><br>
                        <?php echo htmlspecialchars($message['phone'] ?? '-'); ?>
                    </td>
                    <td><?php echo htmlspecialchars($message['subject'] ?? '-'); ?></td>
                    <td><?php echo nl2br(htmlspecialchars($message['message'])); ?></td>
                    <td><?php echo htmlspecialchars($message['created_at']); ?></td>
                    <td>
                        <?php if ((int) $message['is_read'] === 0): ?>
                            <form method="post">
                                <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrf); ?>">
                                <input type="hidden" name="message_id" value="<?php echo (int) $message['id']; ?>">
                                <button class="btn" style="border:1px solid var(--line);" name="mark_read" type="submit">Mark
                                    Read</button>
                            </form>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            <?php if (empty($messages)): ?>
                <tr>
                    <td colspan="7">No messages found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</section>

<?php include __DIR__ . '/_layout_bottom.php';
