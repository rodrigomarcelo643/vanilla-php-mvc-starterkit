<?php
Output::info('Running migrations...');
$dir = KIT_ROOT . '/database/migrations';
if (!is_dir($dir)) {
    Output::line('  No migrations directory found.');
    exit(0);
}

try {
    $pdo = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4', DB_USER, DB_PASS, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    $pdo->exec("CREATE TABLE IF NOT EXISTS `migrations` (`id` INT AUTO_INCREMENT PRIMARY KEY, `migration` VARCHAR(255) NOT NULL, `batch` INT NOT NULL)");
    
    $ran = $pdo->query("SELECT migration FROM migrations")->fetchAll(PDO::FETCH_COLUMN);
    $batch = (int) $pdo->query("SELECT MAX(batch) FROM migrations")->fetchColumn() + 1;
    
    $files = glob("$dir/*.php");
    if ($files) {
        sort($files);
    } else {
        $files = [];
    }
    $migratedAny = false;
    
    foreach ($files as $file) {
        $basename = basename($file);
        if (in_array($basename, $ran)) continue;
        
        require_once $file;
        $className = preg_replace('/^\d{4}_\d{2}_\d{2}_\d{6}_/', '', $basename);
        $className = str_replace('.php', '', $className);
        $className = str_replace(' ', '', ucwords(str_replace('_', ' ', $className)));
        
        if (class_exists($className)) {
            $migration = new $className();
            $migration->up($pdo);
            
            $stmt = $pdo->prepare("INSERT INTO migrations (migration, batch) VALUES (?, ?)");
            $stmt->execute([$basename, $batch]);
            
            Output::success("Migrated: $basename");
            $migratedAny = true;
        } else {
            Output::error("Class $className not found in $basename");
        }
    }
    
    if (!$migratedAny) {
        Output::line('  Nothing to migrate.');
    }
} catch (Exception $e) {
    Output::error("Migration failed: " . $e->getMessage());
    exit(1);
}
