<?php
require_once __DIR__ . '/_init.php';
requireAdminLogin();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['csrf_token']) || !verifyCSRFToken($_POST['csrf_token'])) {
        setFlashMessage('error', 'Invalid security token.');
        redirect('settings.php');
    }

    $settingsToUpdate = [
        'clinic_phone',
        'clinic_telephone',
        'clinic_email',
        'clinic_address',
        'clinic_hours',
        'message_forward_email',
        'facebook_url',
        'instagram_url',
        'linkedin_url'
    ];

    foreach ($settingsToUpdate as $settingKey) {
        if (isset($_POST[$settingKey])) {
            $db->updateSetting($settingKey, trim((string) $_POST[$settingKey]));
        }
    }

    setFlashMessage('success', 'Settings updated successfully.');
    redirect('settings.php');
}

$pageTitle = 'Settings';
$flash = getFlashMessage();
$csrf = generateCSRFToken();
$settings = $db->getSettingsMap();

include __DIR__ . '/_layout_top.php';
?>

<h1><i class="fas fa-gear"></i> Clinic Settings</h1>
<?php if ($flash): ?>
    <div class="flash <?php echo htmlspecialchars($flash['type']); ?>"><?php echo htmlspecialchars($flash['message']); ?>
    </div>
<?php endif; ?>

<section class="panel">
    <h2>Communication and Contact Setup</h2>
    <form method="post">
        <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrf); ?>">

        <div class="form-row">
            <label for="message_forward_email">Message Forward Email (where contact and appointment emails are
                sent)</label>
            <input id="message_forward_email" name="message_forward_email" type="email"
                value="<?php echo htmlspecialchars($settings['message_forward_email'] ?? CLINIC_EMAIL); ?>" required>
        </div>

        <div class="form-row">
            <label for="clinic_phone">Primary Phone</label>
            <input id="clinic_phone" name="clinic_phone"
                value="<?php echo htmlspecialchars($settings['clinic_phone'] ?? CLINIC_PHONE); ?>">
        </div>

        <div class="form-row">
            <label for="clinic_telephone">Telephone</label>
            <input id="clinic_telephone" name="clinic_telephone"
                value="<?php echo htmlspecialchars($settings['clinic_telephone'] ?? CLINIC_TELEPHONE); ?>">
        </div>

        <div class="form-row">
            <label for="clinic_email">Public Email</label>
            <input id="clinic_email" name="clinic_email" type="email"
                value="<?php echo htmlspecialchars($settings['clinic_email'] ?? CLINIC_EMAIL); ?>">
        </div>

        <div class="form-row">
            <label for="clinic_address">Address</label>
            <input id="clinic_address" name="clinic_address"
                value="<?php echo htmlspecialchars($settings['clinic_address'] ?? CLINIC_ADDRESS); ?>">
        </div>

        <div class="form-row">
            <label for="clinic_hours">Operating Hours</label>
            <input id="clinic_hours" name="clinic_hours"
                value="<?php echo htmlspecialchars($settings['clinic_hours'] ?? CLINIC_HOURS); ?>">
        </div>

        <div class="form-row">
            <label for="facebook_url">Facebook URL</label>
            <input id="facebook_url" name="facebook_url"
                value="<?php echo htmlspecialchars($settings['facebook_url'] ?? '#'); ?>">
        </div>

        <div class="form-row">
            <label for="instagram_url">Instagram URL</label>
            <input id="instagram_url" name="instagram_url"
                value="<?php echo htmlspecialchars($settings['instagram_url'] ?? '#'); ?>">
        </div>

        <div class="form-row">
            <label for="linkedin_url">LinkedIn URL</label>
            <input id="linkedin_url" name="linkedin_url"
                value="<?php echo htmlspecialchars($settings['linkedin_url'] ?? '#'); ?>">
        </div>

        <button class="btn btn-accent" type="submit"><i class="fas fa-floppy-disk"></i> Save Settings</button>
    </form>
</section>

<?php include __DIR__ . '/_layout_bottom.php';
