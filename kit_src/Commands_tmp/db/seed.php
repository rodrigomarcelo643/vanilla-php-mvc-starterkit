<?php

Output::info('Seeding database from database/starter.sql ...');

$sql = file_get_contents(KIT_ROOT . '/database/starter.sql');
if (!$sql) {
    Output::error('Could not read database/starter.sql');
    exit(1);
}

try {
    $pdo = new PDO(
        'mysql:host=' . DB_HOST . ';charset=utf8mb4',
        DB_USER, DB_PASS,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
    $pdo->exec($sql);
    Output::success('Database seeded successfully.');
} catch (PDOException $e) {
    Output::error('Seed failed: ' . $e->getMessage());
    exit(1);
}
