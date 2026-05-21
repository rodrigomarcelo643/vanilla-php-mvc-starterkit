<?php
/**
 * PHP Built-in Server Router
 * Mimics the .htaccess RewriteRule: routes all non-file requests to index.php
 */
$uri = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

// Strip the BASE_URL path prefix if present (e.g. /starterkit)
$env = parse_ini_file(__DIR__ . '/.env');
$basePath = rtrim(parse_url($env['BASE_URL'] ?? '', PHP_URL_PATH) ?? '', '/');
if ($basePath !== '' && str_starts_with($uri, $basePath)) {
    $stripped = substr($uri, strlen($basePath));
} else {
    $stripped = $uri;
}

// If the file physically exists (JS, CSS, images, etc.), serve it directly
$filePath = __DIR__ . $uri;
if ($uri !== '/' && file_exists($filePath) && !is_dir($filePath)) {
    return false;
}

// Otherwise route through index.php
require_once __DIR__ . '/index.php';
