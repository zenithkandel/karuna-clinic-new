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
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Plus+Jakarta+Sans:wght@500;600;700;800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="../CSS/all.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="../CSS/style.css">
</head>

<body style="background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%); min-height: 100vh;">
    <section class="section" style="min-height: 100vh; display:grid; place-items:center; padding: 24px;">
        <article class="panel" style="max-width: 420px; width: 100%;">
            <div style="text-align: center; margin-bottom: 1.5rem;">
                <div style="width: 64px; height: 64px; margin: 0 auto 1rem; background: linear-gradient(135deg, #0077B6, #005f92); border-radius: 12px; display: grid; place-items: center;">
                    <i class="fas fa-user-shield" style="font-size: 1.5rem; color: white;"></i>
                </div>
                <h2 style="margin-bottom: 0.5rem;">Admin Login</h2>
                <p style="color: var(--gray-500); margin: 0;">Sign in to access the admin portal</p>
            </div>
            <?php if (!empty($error)): ?>
                <div class="flash error"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>
            <form method="post">
                <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrf); ?>">
                <div class="form-row">
                    <label for="username">Username</label>
                    <input id="username" name="username" required placeholder="Enter your username">
                </div>
                <div class="form-row">
                    <label for="password">Password</label>
                    <input id="password" name="password" type="password" required placeholder="Enter your password">
                </div>
                <button class="btn btn-accent" type="submit" style="width: 100%; margin-top: 0.5rem;"><i class="fas fa-right-to-bracket"></i> Sign In</button>
            </form>
            <p style="margin-top: 1.25rem; text-align: center; color: var(--gray-400); font-size: 0.85rem;">Default: admin / admin123</p>
        </article>
    </section>
</body>

</html>