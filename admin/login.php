<?php
require_once __DIR__ . '/_init.php';

if (isAdminLoggedIn()) {
    redirect('index.php');
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['csrf_token']) || !verifyCSRFToken($_POST['csrf_token'])) {
        $error = 'Invalid security token.';
    } else {
        $username = sanitizeInput($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';

        $adminRow = $db->authenticateAdmin($username, $password);
        if ($adminRow) {
            $_SESSION['admin_user'] = [
                'id' => $adminRow['id'],
                'username' => $adminRow['username'],
                'full_name' => $adminRow['full_name'],
                'role' => $adminRow['role']
            ];
            redirect('index.php');
        }
        $error = 'Invalid login credentials.';
    }
}

$csrf = generateCSRFToken();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="stylesheet" href="../CSS/all.css">
    <link rel="stylesheet" href="../CSS/style.css">
</head>
<body>
<section class="section" style="min-height: 100vh; display:grid; place-items:center; padding: 24px;">
    <article class="panel" style="max-width: 460px; width: 100%;">
        <h2><i class="fas fa-user-shield"></i> Admin Login</h2>
        <p>Use your admin credentials to access messages, notices, and settings.</p>
        <?php if (!empty($error)): ?>
        <div class="flash error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        <form method="post">
            <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrf); ?>">
            <div class="form-row">
                <label for="username">Username</label>
                <input id="username" name="username" required>
            </div>
            <div class="form-row">
                <label for="password">Password</label>
                <input id="password" name="password" type="password" required>
            </div>
            <button class="btn btn-accent" type="submit"><i class="fas fa-right-to-bracket"></i> Login</button>
        </form>
        <p style="margin-top: 14px; color: var(--muted);">Default setup account: admin / admin123</p>
    </article>
</section>
</body>
</html>
