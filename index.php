<?php

session_start();

// ── Load .env ─────────────────────────────────────────────────
$env = parse_ini_file(__DIR__ . '/.env');
foreach ($env as $key => $value) {
    $_ENV[$key] = $value;
}

// ── Autoload (PHPMailer + future packages) ────────────────────
require_once __DIR__ . '/vendor/autoload.php';

require_once 'app/core/Router.php';
require_once 'routes/web.php';
