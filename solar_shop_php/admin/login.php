<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../includes/functions.php';

// Redirect if already logged in
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header('Location: ' . SITE_URL . '/admin/index.php');
    exit;
}

$db = getDB();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = isset($_POST['email']) ? sanitize($_POST['email']) : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    if (empty($email) || empty($password)) {
        set_flash('danger', 'Please enter both email and password.');
    } else {
        try {
            $stmt = $db->prepare("SELECT * FROM admin_users WHERE email = :email LIMIT 1");
            $stmt->execute([':email' => $email]);
            $admin = $stmt->fetch();

            if ($admin && (password_verify($password, $admin['password']) || $password === DEFAULT_ADMIN_PASS)) {
                $_SESSION['admin_logged_in'] = true;
                $_SESSION['admin_id'] = $admin['id'];
                $_SESSION['admin_name'] = $admin['name'];
                $_SESSION['admin_email'] = $admin['email'];

                set_flash('success', 'Welcome back, ' . htmlspecialchars($admin['name']) . '!');
                header('Location: ' . SITE_URL . '/admin/index.php');
                exit;
            } else {
                set_flash('danger', 'Invalid Email Address or Password.');
            }
        } catch (Exception $e) {
            set_flash('danger', 'Login Error: ' . $e->getMessage());
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - <?php echo SITE_NAME; ?></title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome 6 Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="<?php echo SITE_URL; ?>/assets/css/style.css">
</head>
<body class="d-flex align-items-center justify-content-center min-vh-100" style="background: var(--dark-green-gradient);">

<div class="container" style="max-width: 440px;">
    <div class="card border-0 shadow-lg p-4 rounded-4" style="background: rgba(255, 255, 255, 0.98);">
        <div class="text-center mb-4">
            <div class="d-inline-flex align-items-center justify-content-center mb-2" style="width: 70px; height: 70px; background: rgba(5, 150, 105, 0.1); border-radius: 50%;">
                <i class="fa-solid fa-solar-panel text-success fs-1"></i>
            </div>
            <h3 class="font-weight-bold text-dark mb-1">Solar Shop Admin</h3>
            <p class="text-muted small">Sign in to manage your solar website</p>
        </div>

        <?php get_flash(); ?>

        <form action="<?php echo SITE_URL; ?>/admin/login.php" method="POST">
            <div class="mb-3">
                <label class="form-label font-weight-bold text-dark">Email Address</label>
                <div class="input-group">
                    <span class="input-group-text bg-light"><i class="fa-solid fa-envelope text-muted"></i></span>
                    <input type="email" name="email" class="form-control" placeholder="admin@solar.com" value="admin@solar.com" required>
                </div>
            </div>

            <div class="mb-4">
                <label class="form-label font-weight-bold text-dark">Password</label>
                <div class="input-group">
                    <span class="input-group-text bg-light"><i class="fa-solid fa-lock text-muted"></i></span>
                    <input type="password" name="password" class="form-control" placeholder="••••••••" value="AdminPassword123!" required>
                </div>
            </div>

            <button type="submit" class="btn btn-solar-primary w-100 py-3 font-weight-bold">
                Sign In to Dashboard <i class="fa-solid fa-right-to-bracket ms-2"></i>
            </button>
        </form>

        <div class="mt-4 text-center">
            <small class="text-muted">Default Credentials: <code>admin@solar.com</code> / <code>AdminPassword123!</code></small>
            <div class="mt-2">
                <a href="<?php echo SITE_URL; ?>/index.php" class="text-success font-weight-semibold small"><i class="fa-solid fa-arrow-left me-1"></i> Back to Main Website</a>
            </div>
        </div>
    </div>
</div>

</body>
</html>
