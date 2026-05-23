<?php

$isWin   = strtoupper(substr(PHP_OS, 0, 3)) === 'WIN';
$console = $isWin ? 'CON' : '/dev/tty';

// Open the real console device for both writing the menu AND reading input.
// This bypasses Composer's STDIN/STDOUT redirection entirely.
$con = @fopen($console, 'r+');

$menu  = "\n\033[1;36m====================================================\033[0m\n";
$menu .= "\033[1;36m       Welcome to Vanilla PHP MVC Starter Kit       \033[0m\n";
$menu .= "\033[1;36m====================================================\033[0m\n\n";
$menu .= "Which preset would you like to install?\n";
$menu .= "  [1] Full Stack (Alpine.js + AJAX Monolith) - Default\n";
$menu .= "  [2] REST API (Full Stack with JS)\n";
$menu .= "  [3] Backend Only (REST API, No UI)\n";
$menu .= "\nSelect an option [1]: ";

if ($con !== false) {
    fwrite($con, $menu);
} else {
    // Fallback: echo to stdout if console device not available
    echo $menu;
    if (ob_get_level()) ob_flush();
    flush();
}

$choice = '1'; // fallback default

// Read from the console device we already opened
if ($con !== false) {
    $line = fgets($con);
    fclose($con);
    if ($line !== false) {
        $digit = preg_replace('/[^1-9]/', '', $line);
        if ($digit !== '') {
            $choice = $digit;
        }
    }
} else {
    // Fallback: try STDIN
    if (defined('STDIN') && STDIN !== false) {
        stream_set_blocking(STDIN, true);
        $line = fgets(STDIN);
        if ($line !== false) {
            $digit = preg_replace('/[^1-9]/', '', $line);
            if ($digit !== '') {
                $choice = $digit;
            }
        }
    }
}

if ($choice === '3') {
    echo "\n\033[32mConfiguring as Backend Only (REST API)...\033[0m\n";
    
    $basePath = __DIR__ . '/../../';
    
    function deleteDir($dirPath) {
        if (!is_dir($dirPath)) return;
        $objects = scandir($dirPath);
        foreach ($objects as $object) {
            if ($object != "." && $object != "..") {
                if (is_dir($dirPath . DIRECTORY_SEPARATOR . $object) && !is_link($dirPath . "/" . $object)) {
                    deleteDir($dirPath . DIRECTORY_SEPARATOR . $object);
                } else {
                    unlink($dirPath . DIRECTORY_SEPARATOR . $object);
                }
            }
        }
        rmdir($dirPath);
    }
    
    // Remove UI files
    deleteDir($basePath . 'app/views');
    deleteDir($basePath . 'assets');
    deleteDir($basePath . 'js');
    deleteDir($basePath . 'routes/web');
    
    // Clear superadmin and app controllers which are UI specific
    // (Optional, but let's just leave the controllers for now or delete them if they rely on views)
    // To keep it simple, we will just override the main route.
    
    // Overwrite routes/web.php to act as the main API router
    $apiRouteContent = "<?php\n\n" .
        "Router::get('/', function() {\n" .
        "    Router::json([\n" .
        "        'status' => 'success',\n" .
        "        'message' => 'Welcome to the Vanilla PHP REST API Boilerplate',\n" .
        "        'version' => '1.0'\n" .
        "    ]);\n" .
        "});\n\n" .
        "Router::get('api/ping', function() {\n" .
        "    Router::json(['status' => 'ok', 'timestamp' => time()]);\n" .
        "});\n";
        
    file_put_contents($basePath . 'routes/web.php', $apiRouteContent);
    
    echo "\033[32m✔ Frontend UI removed. Backend Only REST API configured.\033[0m\n";
} elseif ($choice === '2') {
    echo "\n\033[32m✔ Configuring as REST API (Full Stack with JS)...\033[0m\n";
} else {
    echo "\n\033[32m✔ Configuring as Full Stack Monolith (Default)...\033[0m\n";
}

echo "\n";
