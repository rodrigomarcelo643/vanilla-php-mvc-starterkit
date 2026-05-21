<?php

Output::line();
Output::warn('This will drop all tables in "' . DB_NAME . '" and re-import starter.sql.');
echo "\033[36m  Continue? [y/N]: \033[0m";
$confirm = strtolower(trim(fgets(STDIN)));
if ($confirm !== 'y') {
    Output::line();
    Output::info('  Aborted.');
    Output::line();
    exit(0);
}

Output::line();
Output::info('Refreshing database...');

try {
    $pdo = new PDO(
        'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4',
        DB_USER, DB_PASS,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );

    $pdo->exec('SET FOREIGN_KEY_CHECKS = 0');
    $tables = $pdo->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);
    
    if (empty($tables)) {
        Output::line("  \033[37mNo tables to drop.\033[0m");
    } else {
        foreach ($tables as $table) {
            $pdo->exec("DROP TABLE IF EXISTS `$table`");
            Output::line("  \033[31m-\033[0m Dropped: \033[33m$table\033[0m");
        }
    }
    
    $pdo->exec('SET FOREIGN_KEY_CHECKS = 1');

    Output::line();
    Output::info('Seeding from starter.sql...');
    $sql = file_get_contents(KIT_ROOT . '/database/starter.sql');
    $pdo->exec($sql);
    
    Output::line();
    Output::success('Database refreshed and seeded successfully.');
    Output::line();
} catch (PDOException $e) {
    Output::line();
    Output::error('Fresh failed: ' . $e->getMessage());
    Output::line();
    exit(1);
}
