<?php
global $argv;
$args = array_slice($argv, 2);
$nameArg = $args[0] ?? null;

if (!$nameArg) {
    Output::line();
    echo "\033[36m  What should the migration be named? (e.g., create_users_table): \033[0m";
    $nameArg = trim(fgets(STDIN));
    if (!$nameArg) {
        Output::error('Name is required.'); exit(1);
    }
}

$snakeName = strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', str_replace(['-', ' '], '_', $nameArg)));
$timestamp = date('Y_m_d_His');
$filename = "{$timestamp}_{$snakeName}.php";

$path = KIT_ROOT . "/database/migrations/{$filename}";
$dir = dirname($path);
if (!is_dir($dir)) mkdir($dir, 0755, true);

$className = str_replace(' ', '', ucwords(str_replace('_', ' ', $snakeName)));

$stub = <<<PHP
<?php

class {$className}
{
    public function up(PDO \$db): void
    {
        \$sql = "CREATE TABLE IF NOT EXISTS `new_table` (
            `id` INT AUTO_INCREMENT PRIMARY KEY,
            `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )";
        \$db->exec(\$sql);
    }

    public function down(PDO \$db): void
    {
        \$db->exec("DROP TABLE IF EXISTS `new_table`");
    }
}
PHP;

file_put_contents($path, $stub);
Output::success("Created Migration: database/migrations/{$filename}");
