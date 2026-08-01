<?php
// Compiler to generate 100% full styled static HTML pages for Vercel & local viewing
$pages = [
    'index.php' => 'index.html',
    'calculator.php' => 'calculator.html',
    'products.php' => 'products.html',
    'services.php' => 'services.html',
    'about.php' => 'about.html',
    'contact.php' => 'contact.html',
    'faq.php' => 'faq.html',
    'projects.php' => 'projects.html'
];

$baseUrl = 'http://localhost:8000';

foreach ($pages as $phpFile => $htmlFile) {
    $url = $baseUrl . '/' . $phpFile;
    $content = @file_get_contents($url);
    
    if ($content !== false && !empty($content)) {
        // Convert internal PHP links to static HTML links
        $content = str_replace([
            'http://localhost:8000/index.php',
            'http://localhost:8000/calculator.php',
            'http://localhost:8000/products.php',
            'http://localhost:8000/services.php',
            'http://localhost:8000/about.php',
            'http://localhost:8000/contact.php',
            'http://localhost:8000/faq.php',
            'http://localhost:8000/projects.php',
            'index.php',
            'calculator.php',
            'products.php',
            'services.php',
            'about.php',
            'contact.php',
            'faq.php',
            'projects.php'
        ], [
            'index.html',
            'calculator.html',
            'products.html',
            'services.html',
            'about.html',
            'contact.html',
            'faq.html',
            'projects.html',
            'index.html',
            'calculator.html',
            'products.html',
            'services.html',
            'about.html',
            'contact.html',
            'faq.html',
            'projects.html'
        ], $content);

        // Fix asset URLs to relative paths
        $content = str_replace('http://localhost:8000/assets/', 'assets/', $content);
        $content = str_replace('http://localhost:8000/', './', $content);

        file_put_contents($htmlFile, $content);
        echo "Successfully Compiled: {$phpFile} -> {$htmlFile} (" . strlen($content) . " bytes)\n";
    } else {
        echo "Failed to fetch: {$url}\n";
    }
}
