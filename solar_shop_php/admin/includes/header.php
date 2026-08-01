<?php
require_once __DIR__ . '/auth.php';

$adminPage = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - <?php echo SITE_NAME; ?></title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="<?php echo SITE_URL; ?>/assets/css/style.css">
</head>
<body class="bg-light">

<div class="container-fluid">
    <div class="row">
        <!-- Sidebar Navigation -->
        <div class="col-md-3 col-lg-2 px-0 admin-sidebar d-flex flex-column">
            <div class="p-4 border-bottom border-success text-center">
                <a href="<?php echo SITE_URL; ?>/admin/index.php" class="text-white text-decoration-none fs-4 font-weight-bold">
                    <i class="fa-solid fa-sun text-warning me-2"></i> Solar Admin
                </a>
            </div>

            <div class="p-3 flex-grow-1">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link <?php echo $adminPage == 'index.php' ? 'active' : ''; ?>" href="<?php echo SITE_URL; ?>/admin/index.php">
                            <i class="fa-solid fa-gauge me-2"></i> Dashboard Overview
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo $adminPage == 'products.php' ? 'active' : ''; ?>" href="<?php echo SITE_URL; ?>/admin/products.php">
                            <i class="fa-solid fa-solar-panel me-2"></i> Products
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo $adminPage == 'projects.php' ? 'active' : ''; ?>" href="<?php echo SITE_URL; ?>/admin/projects.php">
                            <i class="fa-solid fa-images me-2"></i> Projects Gallery
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo $adminPage == 'inquiries.php' ? 'active' : ''; ?>" href="<?php echo SITE_URL; ?>/admin/inquiries.php">
                            <i class="fa-solid fa-envelope-open-text me-2"></i> Inquiries &amp; Surveys
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo $adminPage == 'testimonials.php' ? 'active' : ''; ?>" href="<?php echo SITE_URL; ?>/admin/testimonials.php">
                            <i class="fa-solid fa-star me-2"></i> Testimonials
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo $adminPage == 'blogs.php' ? 'active' : ''; ?>" href="<?php echo SITE_URL; ?>/admin/blogs.php">
                            <i class="fa-solid fa-newspaper me-2"></i> Blogs &amp; Articles
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo $adminPage == 'settings.php' ? 'active' : ''; ?>" href="<?php echo SITE_URL; ?>/admin/settings.php">
                            <i class="fa-solid fa-sliders me-2"></i> Site Settings
                        </a>
                    </li>
                </ul>
            </div>

            <div class="p-3 border-top border-success">
                <a href="<?php echo SITE_URL; ?>/index.php" target="_blank" class="btn btn-sm btn-outline-light w-100 mb-2"><i class="fa-solid fa-arrow-up-right-from-square me-1"></i> View Live Site</a>
                <a href="<?php echo SITE_URL; ?>/admin/logout.php" class="btn btn-sm btn-danger w-100"><i class="fa-solid fa-power-off me-1"></i> Logout</a>
            </div>
        </div>

        <!-- Main Content Body -->
        <div class="col-md-9 col-lg-10 p-4 ms-auto">
            <!-- Header Top Bar -->
            <div class="d-flex justify-content-between align-items-center mb-4 pb-3 border-bottom">
                <h4 class="font-weight-bold mb-0 text-dark">Solar Control Panel</h4>
                <div class="d-flex align-items-center gap-3">
                    <span class="badge bg-success px-3 py-2 fs-6"><i class="fa-solid fa-user-shield me-1"></i> <?php echo htmlspecialchars($_SESSION['admin_name']); ?></span>
                </div>
            </div>
            
            <?php get_flash(); ?>
