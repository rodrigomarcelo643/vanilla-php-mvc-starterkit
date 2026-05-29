<?php

session_start();

// ── Global Error Boundary ──────────────────────────────────────
set_error_handler(function ($severity, $message, $file, $line) {
    if (!(error_reporting() & $severity)) {
        return false;
    }
    throw new ErrorException($message, 0, $severity, $file, $line);
});

set_exception_handler(function ($exception) {
    error_log($exception->getMessage() . ' in ' . $exception->getFile() . ':' . $exception->getLine());

    while (ob_get_level() > 0) {
        ob_end_clean();
    }

    // Define safe fallback constants so that the error page rendering doesn't crash on undefined constants
    if (!defined('APP_NAME')) {
        define('APP_NAME', 'Starter Kit');
    }
    if (!defined('BASE_URL')) {
        define('BASE_URL', '');
    }

    if (!class_exists('Router')) {
        require_once __DIR__ . '/app/core/Router.php';
    }
    if (!class_exists('Controller')) {
        require_once __DIR__ . '/app/core/Controller.php';
    }
    if (!class_exists('ErrorController')) {
        require_once __DIR__ . '/app/controllers/ErrorController.php';
    }

    (new ErrorController())->internalError($exception);
    exit;
});

// ── Load .env ─────────────────────────────────────────────────
$envPath = __DIR__ . '/.env';
if (!file_exists($envPath)) {
    throw new Exception("The .env file could not be found. Please create a .env file in the root directory.");
}

$env = @parse_ini_file($envPath);
if ($env === false) {
    throw new Exception("The .env file contains syntax errors and could not be parsed. Please check for formatting issues (e.g., missing newlines, unquoted spaces, or concatenated values).");
}

foreach ($env as $key => $value) {
    // parse_ini_file converts true/false/yes/no/on/off to 1/"" — normalize back to strings
    if ($value === 1 || $value === '1') {
        $_ENV[$key] = 'true';
    } elseif ($value === '' || $value === 0 || $value === '0') {
        // Only treat as false for known boolean keys to avoid clobbering real empty strings
        if (in_array($key, ['MAINTENANCE_MODE', 'APP_DEBUG'])) {
            $_ENV[$key] = 'false';
        } else {
            $_ENV[$key] = $value;
        }
    } else {
        $_ENV[$key] = $value;
    }
}


// ── HTTP Security Headers ──────────────────────────────────────
header('X-Frame-Options: SAMEORIGIN');
header('X-Content-Type-Options: nosniff');
header('Referrer-Policy: strict-origin-when-cross-origin');
header("Content-Security-Policy: default-src 'self'; script-src 'self' 'unsafe-inline' 'unsafe-eval' https://cdn.tailwindcss.com https://unpkg.com; style-src 'self' 'unsafe-inline' https://fonts.googleapis.com; font-src 'self' https://fonts.gstatic.com; img-src 'self' data: https:; connect-src 'self' https://api.github.com;");

// ── CSRF Token (session-scoped, used by Ajax.post header) ─────
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
define('CSRF_TOKEN', $_SESSION['csrf_token']);

// ── Autoload (PHPMailer + future packages) ────────────────────
require_once __DIR__ . '/vendor/autoload.php';

require_once 'app/core/Router.php';
require_once 'routes/web.php';