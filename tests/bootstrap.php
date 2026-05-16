<?php

// ── Env ───────────────────────────────────────────────────────
$env = file_exists(__DIR__ . '/../.env')
    ? parse_ini_file(__DIR__ . '/../.env')
    : [];

foreach ($env as $key => $value) {
    $_ENV[$key] = $value;
}

// ── Constants (test overrides) ────────────────────────────────
define('APP_NAME', $_ENV['APP_NAME'] ?? 'Test App');
define('BASE_URL',  $_ENV['BASE_URL']  ?? '');
define('DB_HOST',   $_ENV['DB_HOST']   ?? 'localhost');
define('DB_NAME',   $_ENV['DB_NAME']   ?? 'starter');
define('DB_USER',   $_ENV['DB_USER']   ?? 'root');
define('DB_PASS',   $_ENV['DB_PASS']   ?? '');
define('MAIL_MAILER',       $_ENV['MAIL_MAILER']       ?? 'smtp');
define('MAIL_HOST',         $_ENV['MAIL_HOST']         ?? 'smtp.mailtrap.io');
define('MAIL_PORT',         (int) ($_ENV['MAIL_PORT']  ?? 2525));
define('MAIL_USERNAME',     $_ENV['MAIL_USERNAME']     ?? '');
define('MAIL_PASSWORD',     $_ENV['MAIL_PASSWORD']     ?? '');
define('MAIL_ENCRYPTION',   $_ENV['MAIL_ENCRYPTION']   ?? 'tls');
define('MAIL_FROM_ADDRESS', $_ENV['MAIL_FROM_ADDRESS'] ?? 'hello@example.com');
define('MAIL_FROM_NAME',    $_ENV['MAIL_FROM_NAME']    ?? 'Test App');

// ── Session (prevent headers-already-sent in CLI) ─────────────
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// ── Autoload vendor ───────────────────────────────────────────────────────────
require_once __DIR__ . '/../vendor/autoload.php';

// ── Core classes ──────────────────────────────────────────────
require_once __DIR__ . '/../app/core/Database.php';
require_once __DIR__ . '/../app/core/Model.php';
require_once __DIR__ . '/../app/core/Session.php';
require_once __DIR__ . '/../app/core/Auth.php';
require_once __DIR__ . '/../app/core/Router.php';
require_once __DIR__ . '/../app/core/Controller.php';
require_once __DIR__ . '/../app/core/Mailer.php';
require_once __DIR__ . '/../app/helpers/helper.php';
