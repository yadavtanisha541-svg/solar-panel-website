<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../includes/functions.php';

// Auth Guard Check
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    set_flash('danger', 'Please log in to access the Admin Panel.');
    header('Location: ' . SITE_URL . '/admin/login.php');
    exit;
}
