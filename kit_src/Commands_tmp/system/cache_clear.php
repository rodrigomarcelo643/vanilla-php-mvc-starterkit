<?php
$cacheDir = KIT_ROOT . '/app/storage/cache';
if (is_dir($cacheDir)) {
    $files = glob("$cacheDir/*.*");
    if (empty($files)) {
        Output::line('Cache is already empty.');
    } else {
        array_map('unlink', $files);
        Output::success('Cache cleared successfully.');
    }
} else {
    Output::line('No cache directory found (app/storage/cache).');
}
