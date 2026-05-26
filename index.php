<?php

session_start();

// ── Load .env ─────────────────────────────────────────────────
$env = parse_ini_file(__DIR__ . '/.env');
foreach ($env as $key => $value) {
    $_ENV[$key] = $value;
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