<?php
header('Content-Type: text/plain; charset=utf-8');
ini_set('display_errors', 1);
error_reporting(E_ALL);

echo "=== Starter Kit Cache Clearing Tool ===\n\n";

$directories = [
    __DIR__ . '/storage/cache',
    __DIR__ . '/storage/logs',
    __DIR__ . '/app/storage/cache'
];

foreach ($directories as $dir) {
    if (!is_dir($dir)) {
        echo "Directory not found: $dir\n  Attempting to create it... ";
        if (@mkdir($dir, 0775, true)) {
            echo "Created successfully!\n";
            @file_put_contents($dir . '/index.html', '');
        } else {
            echo "Failed to create directory.\n";
            continue;
        }
    }

    echo "Checking directory: $dir\n";
    
    // Find all files inside the directory (recursive or simple)
    $files = glob($dir . '/*');
    $clearedCount = 0;
    
    foreach ($files as $file) {
        if (is_file($file)) {
            $filename = basename($file);
            // Keep .gitkeep or index.html if present
            if ($filename === '.gitkeep' || $filename === 'index.html' || $filename === '.htaccess') {
                continue;
            }
            if (@unlink($file)) {
                echo "  Deleted file: $filename\n";
                $clearedCount++;
            } else {
                echo "  Failed to delete file: $filename\n";
            }
        }
    }
    
    if ($clearedCount === 0) {
        echo "  Directory is already empty or clean.\n";
    } else {
        echo "  Successfully cleared $clearedCount file(s).\n";
    }
    echo "\n";
}

echo "Cache clearing process finished!\n";
