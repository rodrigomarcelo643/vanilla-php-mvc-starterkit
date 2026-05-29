<?php
/**
 * PHP Built-in Server Router
 * Mimics the .htaccess RewriteRule: routes all non-file requests to index.php
 */
$uri = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

// Strip the BASE_URL path prefix if present (e.g. /starterkit)
$env = @parse_ini_file(__DIR__ . '/.env');
if ($env === false) {
    $env = [];
}

$basePath = rtrim(parse_url($env['BASE_URL'] ?? '', PHP_URL_PATH) ?? '', '/');
if ($basePath !== '' && str_starts_with($uri, $basePath)) {
    $stripped = substr($uri, strlen($basePath));
} else {
    $stripped = $uri;
}

// Check if the file physically exists either at the stripped path or full path (JS, CSS, images, etc.) and serve it directly
$fileToServe = null;
if ($stripped !== '/' && file_exists(__DIR__ . $stripped) && !is_dir(__DIR__ . $stripped)) {
    $fileToServe = __DIR__ . $stripped;
} elseif ($uri !== '/' && file_exists(__DIR__ . $uri) && !is_dir(__DIR__ . $uri)) {
    $fileToServe = __DIR__ . $uri;
}

if ($fileToServe !== null) {
    // Detect mime type
    $ext = strtolower(pathinfo($fileToServe, PATHINFO_EXTENSION));
    $mimeTypes = [
        'css'   => 'text/css',
        'js'    => 'application/javascript',
        'png'   => 'image/png',
        'jpg'   => 'image/jpeg',
        'jpeg'  => 'image/jpeg',
        'gif'   => 'image/gif',
        'svg'   => 'image/svg+xml',
        'ico'   => 'image/x-icon',
        'json'  => 'application/json',
        'woff'  => 'font/woff',
        'woff2' => 'font/woff2',
        'ttf'   => 'font/ttf',
        'otf'   => 'font/otf',
    ];
    $contentType = $mimeTypes[$ext] ?? 'application/octet-stream';
    header("Content-Type: {$contentType}");
    readfile($fileToServe);
    exit;
}

// Otherwise route through index.php
require_once __DIR__ . '/index.php';

