<?php
Output::info('Rolling back last migration batch...');

try {
    $pdo = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4', DB_USER, DB_PASS, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    $pdo->exec("CREATE TABLE IF NOT EXISTS `migrations` (`id` INT AUTO_INCREMENT PRIMARY KEY, `migration` VARCHAR(255) NOT NULL, `batch` INT NOT NULL)");
    
    $batch = (int) $pdo->query("SELECT MAX(batch) FROM migrations")->fetchColumn();
    if ($batch === 0) {
        Output::line('  Nothing to rollback.');
        exit(0);
    }
    
    $stmt = $pdo->prepare("SELECT migration FROM migrations WHERE batch = ? ORDER BY id DESC");
    $stmt->execute([$batch]);
    $ran = $stmt->fetchAll(PDO::FETCH_COLUMN);
    
    $dir = KIT_ROOT . '/database/migrations';
    
    foreach ($ran as $basename) {
        $file = "$dir/$basename";
        if (file_exists($file)) {
            require_once $file;
            $className = preg_replace('/^\d{4}_\d{2}_\d{2}_\d{6}_/', '', $basename);
            $className = str_replace('.php', '', $className);
            $className = str_replace(' ', '', ucwords(str_replace('_', ' ', $className)));
            
            if (class_exists($className)) {
                $migration = new $className();
                if (method_exists($migration, 'down')) {
                    $migration->down($pdo);
                }
            }
        }
        
        $del = $pdo->prepare("DELETE FROM migrations WHERE migration = ?");
        $del->execute([$basename]);
        
        Output::line("  \033[33mRolled back:\033[0m $basename");
    }
    Output::success("Rollback complete.");
} catch (Exception $e) {
    Output::error("Rollback failed: " . $e->getMessage());
    exit(1);
}
