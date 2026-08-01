<?php
// Configuration & Constants

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Timezone
date_default_timezone_set('Asia/Kolkata');

// App Info
define('SITE_NAME', 'SolarSphere');
// Dynamic SITE_URL for Localhost, Vercel & Production
if (!defined('SITE_URL')) {
    $protocol = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') ? 'https://' : 'http://';
    $host = $_SERVER['HTTP_HOST'] ?? 'localhost:8000';
    define('SITE_URL', $protocol . $host);
}

// Database Credentials
define('DB_HOST', 'localhost');
define('DB_PORT', '3306');
define('DB_NAME', 'solar_shop_db');
define('DB_USER', 'root');
define('DB_PASS', '');

// Upload Paths
define('UPLOAD_DIR', __DIR__ . '/../assets/images/');
define('UPLOAD_URL', SITE_URL . '/assets/images/');

// Default Admin Credentials
define('DEFAULT_ADMIN_EMAIL', 'admin@solar.com');
define('DEFAULT_ADMIN_PASS', 'AdminPassword123!');
