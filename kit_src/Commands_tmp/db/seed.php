<?php

Output::info('Seeding database from database/starter.sql ...');

$sqlPath = defined('KIT_ROOT') ? KIT_ROOT . '/database/starter.sql' : dirname(__DIR__, 2) . '/database/starter.sql';
$sql = file_get_contents($sqlPath);
if (!$sql) {
    Output::error('Could not read database/starter.sql');
    exit(1);
}

// Replace hardcoded DB name in SQL with the one from .env
$sql = preg_replace('/CREATE DATABASE IF NOT EXISTS `[^`]+`/i', 'CREATE DATABASE IF NOT EXISTS `' . DB_NAME . '`', $sql);
$sql = preg_replace('/USE `[^`]+`;/i', 'USE `' . DB_NAME . '`;', $sql);

try {
    $pdo = new PDO(
        'mysql:host=' . DB_HOST . ';charset=utf8mb4',
        DB_USER, DB_PASS,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
    $pdo->exec('CREATE DATABASE IF NOT EXISTS `' . DB_NAME . '` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci');
    $pdo->exec('USE `' . DB_NAME . '`');
    $pdo->exec($sql);
    Output::success('Database "' . DB_NAME . '" seeded successfully.');
} catch (PDOException $e) {
    Output::error('Seed failed: ' . $e->getMessage());
    exit(1);
}
