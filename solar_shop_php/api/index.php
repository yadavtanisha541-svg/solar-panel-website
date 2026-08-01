<?php
// Vercel Serverless PHP Router
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Serve static assets directly with correct content types
$assetPath = __DIR__ . '/..' . $uri;
if (file_exists($assetPath) && !is_dir($assetPath) && str_starts_with($uri, '/assets/')) {
    $ext = pathinfo($assetPath, PATHINFO_EXTENSION);
    $mimeTypes = [
        'css'  => 'text/css',
        'js'   => 'application/javascript',
        'png'  => 'image/png',
        'jpg'  => 'image/jpeg',
        'jpeg' => 'image/jpeg',
        'svg'  => 'image/svg+xml',
        'mp4'  => 'video/mp4',
        'json' => 'application/json'
    ];
    if (isset($mimeTypes[$ext])) {
        header('Content-Type: ' . $mimeTypes[$ext]);
    }
    readfile($assetPath);
    exit;
}

// Force HTML content type header for PHP rendered pages so browser renders HTML instead of downloading file
header('Content-Type: text/html; charset=utf-8');

// Route mapping
if ($uri === '/' || $uri === '/index' || $uri === '/index.php') {
    require __DIR__ . '/../index.php';
} elseif ($uri === '/calculator' || $uri === '/calculator.php') {
    require __DIR__ . '/../calculator.php';
} elseif ($uri === '/products' || $uri === '/products.php') {
    require __DIR__ . '/../products.php';
} elseif ($uri === '/product-detail' || $uri === '/product-detail.php') {
    require __DIR__ . '/../product-detail.php';
} elseif ($uri === '/services' || $uri === '/services.php') {
    require __DIR__ . '/../services.php';
} elseif ($uri === '/about' || $uri === '/about.php') {
    require __DIR__ . '/../about.php';
} elseif ($uri === '/contact' || $uri === '/contact.php') {
    require __DIR__ . '/../contact.php';
} elseif ($uri === '/faq' || $uri === '/faq.php') {
    require __DIR__ . '/../faq.php';
} elseif ($uri === '/projects' || $uri === '/projects.php') {
    require __DIR__ . '/../projects.php';
} elseif ($uri === '/blog' || $uri === '/blog.php') {
    require __DIR__ . '/../blog.php';
} elseif ($uri === '/blog-detail' || $uri === '/blog-detail.php') {
    require __DIR__ . '/../blog-detail.php';
} elseif (str_starts_with($uri, '/admin')) {
    $adminFile = __DIR__ . '/..' . $uri;
    if (file_exists($adminFile) && !is_dir($adminFile)) {
        require $adminFile;
    } else {
        require __DIR__ . '/../admin/index.php';
    }
} else {
    $targetFile = __DIR__ . '/..' . $uri;
    if (file_exists($targetFile) && !is_dir($targetFile)) {
        require $targetFile;
    } else {
        require __DIR__ . '/../index.php';
    }
}
