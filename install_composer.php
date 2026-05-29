<?php
header('Content-Type: text/plain; charset=utf-8');
echo "Running composer install...\n\n";

$deployPath = __DIR__;
$output = [];
$returnCode = 0;

exec("cd {$deployPath} && composer install --no-dev --optimize-autoloader --no-interaction 2>&1", $output, $returnCode);

foreach ($output as $line) {
    echo $line . "\n";
}

echo "\nExit code: {$returnCode}\n";
echo $returnCode === 0 ? "\n✅ Composer install succeeded!" : "\n❌ Composer install failed.";
