<?php

$host = $arg1 ?? 'localhost';
$port = $arg2 ?? '8000';

// Detect subfolder from BASE_URL (e.g. http://localhost/starterkit → /starterkit)
$basePath = rtrim(parse_url(BASE_URL ?? '', PHP_URL_PATH) ?? '', '/');

Output::line();
Output::success("Dev server started → \033[1;36mhttp://{$host}:{$port}\033[0m");

if ($basePath !== '') {
    Output::warn("Your BASE_URL has a subfolder: \033[33m{$basePath}\033[33m");
    Output::warn("With 'php kit serve', open: \033[1;36mhttp://{$host}:{$port}{$basePath}\033[0m");
} else {
    Output::info("Open: \033[1;36mhttp://{$host}:{$port}\033[0m");
}

Output::info('Press Ctrl+C to stop.');
Output::line();
Output::line("  \033[33m" . str_pad('STATUS', 8) . str_pad('METHOD', 8) . "URI\033[0m");
Output::line('  ' . str_repeat('─', 60));

$cmd = "php -S {$host}:{$port} -t \"" . KIT_ROOT . "\" \"" . KIT_ROOT . "/server.php\"";
$proc = proc_open($cmd, [
    0 => STDIN,
    1 => ['pipe', 'w'],
    2 => ['pipe', 'w'],
], $pipes);

if (!is_resource($proc)) {
    Output::error('Failed to start the dev server.');
    exit(1);
}

// PHP built-in server logs go to stderr
stream_set_blocking($pipes[2], false);
stream_set_blocking($pipes[1], false);

while (proc_get_status($proc)['running']) {
    $line = fgets($pipes[2]);
    if ($line === false || $line === '') {
        usleep(50000);
        continue;
    }

    $line = trim($line);

    // Match: [date] host [STATUS]: METHOD /uri
    if (preg_match('/\[(\d+)\]: (GET|POST|PUT|PATCH|DELETE|HEAD|OPTIONS) (.+)/', $line, $m)) {
        $status = (int) $m[1];
        $method = $m[2];
        $uri    = $m[3];

        $statusColor = match(true) {
            $status >= 500             => "\033[1;31m", // bright red
            $status >= 400             => "\033[31m",   // red
            $status >= 300             => "\033[33m",   // yellow
            $status >= 200             => "\033[32m",   // green
            default                    => "\033[37m",
        };

        $methodColor = match($method) {
            'GET'                      => "\033[32m",   // green
            'POST'                     => "\033[34m",   // blue
            'PUT', 'PATCH'             => "\033[33m",   // yellow
            'DELETE'                   => "\033[31m",   // red
            default                    => "\033[37m",
        };

        $statusBadge = $statusColor . str_pad($status, 8) . "\033[0m";
        $methodBadge = $methodColor . str_pad($method, 8) . "\033[0m";

        echo "  {$statusBadge}{$methodBadge}{$uri}\n";
    } elseif (stripos($line, 'started') !== false || stripos($line, 'listening') !== false) {
        // Suppress — we already printed our own header
    } else {
        // Fallback: dim unknown server messages
        echo "  \033[90m$line\033[0m\n";
    }
}

proc_close($proc);
Output::line();
Output::info('Dev server stopped.');
Output::line();
