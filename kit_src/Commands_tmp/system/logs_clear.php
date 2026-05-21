<?php
$logsDir = KIT_ROOT . '/app/storage/logs';
if (is_dir($logsDir)) {
    $files = glob("$logsDir/*.*");
    if (empty($files)) {
        Output::line('Logs are already empty.');
    } else {
        array_map('unlink', $files);
        Output::success('Logs cleared successfully.');
    }
} else {
    Output::line('No logs directory found (app/storage/logs).');
}
