<?php
require_once __DIR__ . '/_init.php';
requireAdminLogin();

$pageTitle = 'Manage Admin Users';
$pdo = $db->getPdo();
$csrf = generateCSRFToken();
$currentAdmin = getCurrentAdmin();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['csrf_token']) || !verifyCSRFToken($_POST['csrf_token'])) {
        setFlashMessage('error', 'Invalid security token.');
        redirect('admin-users.php');
    }

    $action = $_POST['action'] ?? '';

    if ($action === 'create') {
        $password = trim((string)($_POST['password'] ?? ''));
        if ($password === '') {
            setFlashMessage('error', 'Password is required for new admin user.');
            redirect('admin-users.php');
        }

        $stmt = $pdo->prepare('INSERT INTO admin_users (username, email, password_hash, full_name, role, is_active) VALUES (?, ?, ?, ?, ?, ?)');
        $ok = $stmt->execute([
            trim((string)($_POST['username'] ?? '')),
            trim((string)($_POST['email'] ?? '')),
            password_hash($password, PASSWORD_DEFAULT),
            trim((string)($_POST['full_name'] ?? '')),
            trim((string)($_POST['role'] ?? 'staff')),
            isset($_POST['is_active']) ? 1 : 0
        ]);
        setFlashMessage($ok ? 'success' : 'error', $ok ? 'Admin user created.' : 'Failed to create admin user.');
        redirect('admin-users.php');
    }

    if ($action === 'update') {
        $id = (int)($_POST['id'] ?? 0);
        $stmt = $pdo->prepare('UPDATE admin_users SET username = ?, email = ?, full_name = ?, role = ?, is_active = ? WHERE id = ?');
        $ok = $stmt->execute([
            trim((string)($_POST['username'] ?? '')),
            trim((string)($_POST['email'] ?? '')),
            trim((string)($_POST['full_name'] ?? '')),
            trim((string)($_POST['role'] ?? 'staff')),
            isset($_POST['is_active']) ? 1 : 0,
            $id
        ]);

        $password = trim((string)($_POST['password'] ?? ''));
        if ($ok && $password !== '') {
            $pstmt = $pdo->prepare('UPDATE admin_users SET password_hash = ? WHERE id = ?');
            $ok = $pstmt->execute([password_hash($password, PASSWORD_DEFAULT), $id]);
        }

        setFlashMessage($ok ? 'success' : 'error', $ok ? 'Admin user updated.' : 'Failed to update admin user.');
        redirect('admin-users.php');
    }

    if ($action === 'delete') {
        $id = (int)($_POST['id'] ?? 0);
        if (!empty($currentAdmin) && (int)$currentAdmin['id'] === $id) {
            setFlashMessage('error', 'You cannot delete your own admin account.');
            redirect('admin-users.php');
        }
        $stmt = $pdo->prepare('DELETE FROM admin_users WHERE id = ?');
        $ok = $stmt->execute([$id]);
        setFlashMessage($ok ? 'success' : 'error', $ok ? 'Admin user deleted.' : 'Failed to delete admin user.');
        redirect('admin-users.php');
    }
}

$editUser = null;
if (isset($_GET['edit'])) {
    $stmt = $pdo->prepare('SELECT * FROM admin_users WHERE id = ?');
    $stmt->execute([(int)$_GET['edit']]);
    $editUser = $stmt->fetch();
}

$users = $pdo->query('SELECT * FROM admin_users ORDER BY id DESC')->fetchAll();
$flash = getFlashMessage();

include __DIR__ . '/_layout_top.php';
?>

<h1><i class="fas fa-users-cog"></i> Manage Admin Users</h1>
<?php if ($flash): ?><div class="flash <?php echo htmlspecialchars($flash['type']); ?>"><?php echo htmlspecialchars($flash['message']); ?></div><?php endif; ?>

<section class="panel" style="margin-bottom:16px;">
    <h2><?php echo $editUser ? 'Edit Admin User' : 'Add Admin User'; ?></h2>
    <form method="post">
        <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrf); ?>">
        <input type="hidden" name="action" value="<?php echo $editUser ? 'update' : 'create'; ?>">
        <?php if ($editUser): ?><input type="hidden" name="id" value="<?php echo (int)$editUser['id']; ?>"><?php endif; ?>

        <div class="grid-cards" style="grid-template-columns: repeat(auto-fit,minmax(240px,1fr));">
            <div class="form-row"><label>Username</label><input name="username" required value="<?php echo htmlspecialchars($editUser['username'] ?? ''); ?>"></div>
            <div class="form-row"><label>Email</label><input name="email" type="email" required value="<?php echo htmlspecialchars($editUser['email'] ?? ''); ?>"></div>
            <div class="form-row"><label>Full Name</label><input name="full_name" value="<?php echo htmlspecialchars($editUser['full_name'] ?? ''); ?>"></div>
            <div class="form-row"><label>Role</label><select name="role"><?php foreach (['admin','staff'] as $role): ?><option value="<?php echo $role; ?>" <?php echo ($editUser['role'] ?? 'staff') === $role ? 'selected' : ''; ?>><?php echo ucfirst($role); ?></option><?php endforeach; ?></select></div>
            <div class="form-row"><label>Password <?php echo $editUser ? '(leave empty to keep)' : ''; ?></label><input name="password" type="password" <?php echo $editUser ? '' : 'required'; ?>></div>
            <div class="form-row" style="display:flex; align-items:center; gap:10px;"><input type="checkbox" name="is_active" <?php echo !isset($editUser['is_active']) || (int)($editUser['is_active'] ?? 1) === 1 ? 'checked' : ''; ?>><label>Active</label></div>
        </div>
        <div class="btn-row"><button class="btn btn-accent" type="submit"><i class="fas fa-floppy-disk"></i> <?php echo $editUser ? 'Update' : 'Create'; ?></button><?php if ($editUser): ?><a class="btn btn-ghost" href="admin-users.php"><i class="fas fa-xmark"></i> Cancel</a><?php endif; ?></div>
    </form>
</section>

<section class="panel">
    <h2>Admin Users</h2>
    <table class="data-table">
        <thead><tr><th>ID</th><th>Username</th><th>Email</th><th>Role</th><th>Status</th><th>Last Login</th><th>Actions</th></tr></thead>
        <tbody>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?php echo (int)$user['id']; ?></td>
                    <td><?php echo htmlspecialchars($user['username']); ?></td>
                    <td><?php echo htmlspecialchars($user['email']); ?></td>
                    <td><?php echo htmlspecialchars($user['role']); ?></td>
                    <td><?php echo (int)$user['is_active'] === 1 ? 'Active' : 'Inactive'; ?></td>
                    <td><?php echo htmlspecialchars($user['last_login'] ?? '-'); ?></td>
                    <td>
                        <div class="btn-row">
                            <a class="btn btn-ghost" href="admin-users.php?edit=<?php echo (int)$user['id']; ?>"><i class="fas fa-pen"></i> Edit</a>
                            <?php if ((int)$user['id'] !== (int)($currentAdmin['id'] ?? 0)): ?>
                            <form method="post" onsubmit="return confirm('Delete this admin user?');">
                                <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrf); ?>">
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="id" value="<?php echo (int)$user['id']; ?>">
                                <button class="btn" style="border:1px solid var(--line);" type="submit"><i class="fas fa-trash"></i> Delete</button>
                            </form>
                            <?php endif; ?>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</section>

<?php include __DIR__ . '/_layout_bottom.php';
