<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/functions.php';

$currentPage = basename($_SERVER['PHP_SELF']);
$phone = get_site_setting('phone', '+91 98765 43210');
$email = get_site_setting('email', 'info@solarpanelshop.com');
$whatsapp = get_site_setting('whatsapp', '919876543210');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($pageTitle) ? htmlspecialchars($pageTitle) . ' - ' . SITE_NAME : SITE_NAME . ' - Solar Energy Solutions'; ?></title>
    <meta name="description" content="Leading Solar Panel Installation, High Efficiency Inverters, Solar Batteries & Solar Water Heaters. Save up to 90% on electricity bills.">
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- FontAwesome 6 Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    
    <!-- AOS Animate On Scroll -->
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@1,600;1,700&family=Playfair+Display:ital,wght@1,600;1,700;1,800&family=Montserrat:wght@700;800;900&family=Plus+Jakarta+Sans:wght@500;600;700&display=swap" rel="stylesheet">
    
    <!-- Custom Theme CSS -->
    <link rel="stylesheet" href="<?php echo SITE_URL; ?>/assets/css/style.css">
</head>
<body>



<!-- Main Navbar -->
<nav class="navbar navbar-expand-lg navbar-solar fixed-top">
    <div class="container-fluid px-4 px-lg-5">
        <a class="navbar-brand me-4" href="<?php echo SITE_URL; ?>/index.php">
            <i class="fa-solid fa-sun fs-2 text-warning"></i>
            <span>Solar<span style="color: var(--primary-color);">Sphere</span></span>
        </a>
        <button class="navbar-toggler border-0 p-2 shadow-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileNavbar" aria-controls="mobileNavbar" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Right Side Offcanvas Mobile Menu & Desktop Navigation -->
        <div class="offcanvas-lg offcanvas-end bg-white" tabindex="-1" id="mobileNavbar" aria-labelledby="mobileNavbarLabel">
            <div class="offcanvas-header border-bottom py-3 px-4 d-lg-none">
                <a class="navbar-brand m-0" href="<?php echo SITE_URL; ?>/index.php">
                    <i class="fa-solid fa-sun fs-3 text-warning"></i>
                    <span class="fs-5 font-weight-bold">Solar<span style="color: var(--primary-color);">Sphere</span></span>
                </a>
                <button type="button" class="btn-close text-reset shadow-none" data-bs-dismiss="offcanvas" data-bs-target="#mobileNavbar" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body p-4 p-lg-0 align-items-center">
                <ul class="navbar-nav mx-auto mb-2 mb-lg-0 gap-1">
                    <li class="nav-item">
                        <a class="nav-link <?php echo $currentPage == 'index.php' ? 'active' : ''; ?>" href="<?php echo SITE_URL; ?>/index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo $currentPage == 'about.php' ? 'active' : ''; ?>" href="<?php echo SITE_URL; ?>/about.php">About Us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo $currentPage == 'products.php' || $currentPage == 'product-detail.php' ? 'active' : ''; ?>" href="<?php echo SITE_URL; ?>/products.php">Products</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo $currentPage == 'services.php' ? 'active' : ''; ?>" href="<?php echo SITE_URL; ?>/services.php">Services</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo $currentPage == 'calculator.php' ? 'active' : ''; ?>" href="<?php echo SITE_URL; ?>/calculator.php">Calculator</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo $currentPage == 'faq.php' ? 'active' : ''; ?>" href="<?php echo SITE_URL; ?>/faq.php">FAQ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo $currentPage == 'contact.php' ? 'active' : ''; ?>" href="<?php echo SITE_URL; ?>/contact.php">Contact Us</a>
                    </li>
                </ul>
                <div class="d-flex align-items-center ms-lg-auto mt-4 mt-lg-0">
                    <button class="btn btn-solar-nav w-100 w-lg-auto" data-bs-toggle="modal" data-bs-target="#siteSurveyModal" data-bs-dismiss="offcanvas">
                        <i class="fa-solid fa-clipboard-check me-1"></i> Free Site Survey
                    </button>
                </div>
            </div>
        </div>
    </div>
</nav>

<!-- Floating WhatsApp Button -->
<a href="https://api.whatsapp.com/send?phone=<?php echo $whatsapp; ?>&text=Hi%20Solar%20Shop,%20I%20want%20information%20regarding%20solar%20panel%20installation." class="whatsapp-float" target="_blank" title="Chat on WhatsApp">
    <i class="fa-brands fa-whatsapp"></i>
</a>
