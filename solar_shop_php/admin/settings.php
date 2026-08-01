<?php
require_once __DIR__ . '/includes/header.php';

$db = getDB();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $settings = [
        'site_name' => sanitize($_POST['site_name']),
        'tagline' => sanitize($_POST['tagline']),
        'phone' => sanitize($_POST['phone']),
        'alt_phone' => sanitize($_POST['alt_phone']),
        'email' => sanitize($_POST['email']),
        'address' => sanitize($_POST['address']),
        'whatsapp' => sanitize($_POST['whatsapp']),
        'google_map' => trim($_POST['google_map'])
    ];

    try {
        $stmt = $db->prepare("INSERT INTO site_settings (setting_key, setting_value) VALUES (:key, :val) ON CONFLICT(setting_key) DO UPDATE SET setting_value = :val");
        foreach ($settings as $key => $val) {
            try {
                // Try SQLite ON CONFLICT syntax or MySQL ON DUPLICATE KEY UPDATE syntax
                $stmt->execute([':key' => $key, ':val' => $val]);
            } catch (Exception $subErr) {
                // Fallback for MySQL
                $db->prepare("INSERT INTO site_settings (setting_key, setting_value) VALUES (:key, :val) ON DUPLICATE KEY UPDATE setting_value = :val")->execute([':key' => $key, ':val' => $val]);
            }
        }
        set_flash('success', 'Site settings updated successfully!');
    } catch (Exception $e) {
        set_flash('danger', 'Error updating settings: ' . $e->getMessage());
    }
}
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="font-weight-bold mb-0">Website Contact &amp; Business Settings</h4>
</div>

<div class="card border-0 shadow-sm rounded-4 max-w-800">
    <div class="card-body p-4">
        <form action="" method="POST">
            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label class="form-label font-weight-bold">Shop / Business Name</label>
                    <input type="text" name="site_name" class="form-control" value="<?php echo htmlspecialchars(get_site_setting('site_name', 'Solar Panel Shop')); ?>" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label font-weight-bold">Tagline</label>
                    <input type="text" name="tagline" class="form-control" value="<?php echo htmlspecialchars(get_site_setting('tagline', 'Clean, Renewable & Unlimited Solar Energy')); ?>">
                </div>
            </div>

            <div class="row g-3 mb-3">
                <div class="col-md-4">
                    <label class="form-label font-weight-bold">Primary Phone Number</label>
                    <input type="text" name="phone" class="form-control" value="<?php echo htmlspecialchars(get_site_setting('phone', '+91 98765 43210')); ?>" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label font-weight-bold">Alternate Phone Number</label>
                    <input type="text" name="alt_phone" class="form-control" value="<?php echo htmlspecialchars(get_site_setting('alt_phone', '+91 98123 45678')); ?>">
                </div>
                <div class="col-md-4">
                    <label class="form-label font-weight-bold">WhatsApp Number (Without + or spaces)</label>
                    <input type="text" name="whatsapp" class="form-control" value="<?php echo htmlspecialchars(get_site_setting('whatsapp', '919876543210')); ?>" required>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label font-weight-bold">Official Email Address</label>
                <input type="email" name="email" class="form-control" value="<?php echo htmlspecialchars(get_site_setting('email', 'info@solarpanelshop.com')); ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label font-weight-bold">Shop Office Address</label>
                <textarea name="address" class="form-control" rows="2" required><?php echo htmlspecialchars(get_site_setting('address', 'Plot No. 45, Solar Energy Park, Sector 62, Noida, UP')); ?></textarea>
            </div>

            <div class="mb-4">
                <label class="form-label font-weight-bold">Google Map Embed Embed URL (src attribute)</label>
                <textarea name="google_map" class="form-control" rows="3"><?php echo htmlspecialchars(get_site_setting('google_map')); ?></textarea>
                <small class="text-muted">Paste Google Maps embed <code>src="..."</code> URL here.</small>
            </div>

            <button type="submit" class="btn btn-solar-primary btn-lg px-5">Save Settings <i class="fa-solid fa-check ms-2"></i></button>
        </form>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
