<?php

echo "\n\033[1;36m====================================================\033[0m\n";
echo "\033[1;36m       Welcome to Vanilla PHP MVC Starter Kit       \033[0m\n";
echo "\033[1;36m====================================================\033[0m\n\n";
echo "Which preset would you like to install?\n";
echo "  [1] Full Stack (Alpine.js + AJAX Monolith) - Default\n";
echo "  [2] REST API (Full Stack with JS)\n";
echo "  [3] Backend Only (REST API, No UI)\n";
echo "\nSelect an option [1]: ";

if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
    $handle = fopen("CON", "r");
} else {
    $handle = fopen("/dev/tty", "r");
}

if ($handle !== false) {
    $choice = trim(fgets($handle));
    fclose($handle);
} else {
    $choice = '1';
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
