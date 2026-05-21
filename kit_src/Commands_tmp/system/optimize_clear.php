<?php
Output::info('Clearing all application optimizations and caches...');
Output::line();

// Clear Cache
$cacheDir = KIT_ROOT . '/app/storage/cache';
if (is_dir($cacheDir)) {
    $files = glob("$cacheDir/*.*");
    if (!empty($files)) {
        array_map('unlink', $files);
        Output::success('Cache cleared successfully.');
    } else {
        Output::line('  - Cache already empty.');
    }
} else {
    Output::line('  - No cache directory found.');
}

// Clear Logs
$logsDir = KIT_ROOT . '/app/storage/logs';
if (is_dir($logsDir)) {
    $files = glob("$logsDir/*.*");
    if (!empty($files)) {
        array_map('unlink', $files);
        Output::success('Logs cleared successfully.');
    } else {
        Output::line('  - Logs already empty.');
    }
} else {
    Output::line('  - No logs directory found.');
}

Output::line();
Output::success('Application caches and logs have been cleared!');
