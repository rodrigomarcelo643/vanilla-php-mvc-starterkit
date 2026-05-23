<?php

// [ignoring loop detection]

/**
 * MARDEV CLI Route Tester
 */

require_once KIT_ROOT . '/kit_src/Support_tmp/Output.php';

// Check curl extension
if (!extension_loaded('curl')) {
    Output::error("The CURL extension is required to run route tests.");
    exit(1);
}

// ── Watermark & Welcome ──
echo "\033[1;35m=========================================================\033[0m\n";
echo "\033[1;36m  MARDEV BACKEND API INTERACTIVE CLI TESTER\033[0m\n";
echo "\033[1;35m=========================================================\033[0m\n";

// ── Resolve Target Host ──
$targetHost = rtrim(BASE_URL, '/');
if (!str_starts_with($targetHost, 'http://') && !str_starts_with($targetHost, 'https://')) {
    $targetHost = 'http://localhost' . ($targetHost ? '/' . ltrim($targetHost, '/') : '');
}
$targetHost = rtrim($targetHost, '/');

echo "Checking default target host: \033[1;33m{$targetHost}\033[0m ... ";

$pingUrl = $targetHost . '/api/ping';
$ch = curl_init($pingUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 2);
$pingRes = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($httpCode === 200) {
    echo "\033[1;32m[CONNECTED]\033[0m\n";
} else {
    echo "\033[1;31m[FAILED (HTTP {$httpCode})]\033[0m\n";
    echo "\nWe couldn't connect to the resolved host ({$targetHost}).\n";
    echo "Is your local PHP web server running?\n\n";
    echo "1. Keep configured target host: {$targetHost}\n";
    echo "2. Use PHP Development Server: http://localhost:8000\n";
    echo "3. Enter a custom server URL\n";
    
    $choice = promptInput("Select target host option [1]: ");
    if ($choice === '2') {
        $targetHost = 'http://localhost:8000';
    } elseif ($choice === '3') {
        $targetHost = rtrim(promptInput("Enter custom host (e.g. http://localhost/myapp): "), '/');
    }
}

// Parse routes from routes/api.php
$apiFile = file_get_contents(KIT_ROOT . '/routes/api.php');
$apiRoutes = [];
preg_match_all('/Router::(get|post|any)\(([\'"])([^\'"]*)\2/i', $apiFile, $matches);
if (!empty($matches[3])) {
    foreach ($matches[3] as $i => $path) {
        $method = strtoupper($matches[1][$i]);
        if ($method === 'ANY') {
            $apiRoutes[] = ['method' => 'GET', 'path' => $path];
            $apiRoutes[] = ['method' => 'POST', 'path' => $path];
        } else {
            $apiRoutes[] = ['method' => $method, 'path' => $path];
        }
    }
}

// Ensure unique route items
$uniqueRoutes = [];
foreach ($apiRoutes as $route) {
    $key = $route['method'] . ':' . $route['path'];
    $uniqueRoutes[$key] = $route;
}
$apiRoutes = array_values($uniqueRoutes);

// Cookie file persistence to hold session ID
$cookieJar = KIT_ROOT . '/storage/logs/cli_session_cookie.txt';
if (file_exists($cookieJar)) {
    unlink($cookieJar); // Start fresh
}

// ── Helpers ──

function promptInput($prompt) {
    echo $prompt;
    return trim(fgets(STDIN));
}

function getCategory($path) {
    $path = trim($path, '/');
    if ($path === '' || $path === 'api' || $path === 'api/ping') {
        return 'SYSTEM / HEALTH CHECK';
    }
    if (str_starts_with($path, 'api/auth')) {
        return 'AUTHENTICATION & SESSION';
    }
    if (str_starts_with($path, 'api/admin')) {
        return 'ADMIN MANAGEMENT';
    }
    if (str_starts_with($path, 'api/superadmin')) {
        return 'SUPERADMIN CONTROL';
    }
    if (str_starts_with($path, 'api/profile')) {
        return 'PROFILE & SETTINGS';
    }
    if (str_starts_with($path, 'api/app')) {
        return 'USER APPLICATIONS';
    }
    return 'OTHER ENDPOINTS';
}

function colorizeJson($json) {
    $pretty = json_encode(json_decode($json), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    if (!$pretty) return $json;

    // Keys: "key": -> cyan
    $pretty = preg_replace('/"([^"]+)":/', "\033[1;36m\"$1\"\033[0m:", $pretty);
    // String values: : "value" -> green
    $pretty = preg_replace('/: \s*"(.*)"(,?)$/m', ": \033[0;32m\"$1\"\033[0m$2", $pretty);
    // Number values: : 123 -> yellow
    $pretty = preg_replace('/: \s*(-?\d+\.?\d*)(,?)$/m', ": \033[1;33m$1\033[0m$2", $pretty);
    // Boolean values: : true/false -> magenta
    $pretty = preg_replace('/: \s*(true|false)(,?)$/m', ": \033[1;35m$1\033[0m$2", $pretty);
    // Null values: : null -> grey
    $pretty = preg_replace('/: \s*(null)(,?)$/m', ": \033[1;30m$1\033[0m$2", $pretty);

    return $pretty;
}

// ── Main Loop ──

while (true) {
    // Clear Terminal Screen for Clean UI
    echo "\033[2J\033[H";
    
    // Print Header
    echo "\033[1;35m=========================================================\033[0m\n";
    echo "\033[1;36m  MARDEV BACKEND API INTERACTIVE CLI TESTER\033[0m\n";
    echo "\033[1;35m=========================================================\033[0m\n";
    echo "Target host: \033[1;33m{$targetHost}\033[0m\n";
    echo "\033[1;30mPress Ctrl+C at any time to exit the tester.\033[0m\n";
    echo "\033[1;35m---------------------------------------------------------\033[0m\n";
    
    // Group routes by category
    $categories = [];
    foreach ($apiRoutes as $idx => $r) {
        $cat = getCategory($r['path']);
        $categories[$cat][] = [
            'original_idx' => $idx,
            'route'        => $r
        ];
    }
    
    // Print Categorized List
    foreach ($categories as $catName => $items) {
        echo "\n\033[1;35m[ {$catName} ]\033[0m\n";
        foreach ($items as $item) {
            $idx = $item['original_idx'];
            $r = $item['route'];
            $num = str_pad($idx + 1, 2, ' ', STR_PAD_LEFT);
            $method = str_pad($r['method'], 6, ' ');
            $displayPath = $r['path'] === '' ? '/' : '/' . ltrim($r['path'], '/');
            echo "  [{$num}] \033[1;33m{$method}\033[0m {$displayPath}\n";
        }
    }
    
    $customIdx = count($apiRoutes) + 1;
    echo "\n\033[1;35m[ CONTROLS ]\033[0m\n";
    echo "  [{$customIdx}] \033[1;36mCUSTOM\033[0m Enter custom route path manually\n";
    echo "  [X]  \033[1;30mEXIT\033[0m   Exit Tester\n";
    
    $selection = strtoupper(promptInput("\nSelect a route (1-{$customIdx} or X): "));
    
    if ($selection === 'X' || $selection === 'EXIT') {
        echo "\nGoodbye!\n";
        break;
    }
    
    $route = null;
    $method = 'GET';
    $path = '';
    
    if (is_numeric($selection) && (int)$selection === $customIdx) {
        $path = ltrim(promptInput("Enter path (e.g. api/admin/users): "), '/');
        $method = strtoupper(promptInput("Enter method (GET/POST) [GET]: "));
        if (!in_array($method, ['GET', 'POST'])) $method = 'GET';
    } elseif (is_numeric($selection) && isset($apiRoutes[(int)$selection - 1])) {
        $route = $apiRoutes[(int)$selection - 1];
        $method = $route['method'];
        $path = $route['path'];
    } else {
        echo "\033[1;31mInvalid selection.\033[0m\n";
        promptInput("\nPress [ENTER] to return to the route menu...");
        continue;
    }
    
    $postParams = [];
    if ($method === 'POST') {
        echo "\nEnter POST parameters as key=value (comma-separated, e.g. email=admin@example.com,password=password)\n";
        $paramStr = promptInput("Parameters: ");
        if ($paramStr) {
            parse_str(str_replace(',', '&', $paramStr), $postParams);
        }
    }
    
    // Construct full URL
    $fullUrl = $targetHost . '/' . ltrim($path, '/');
    
    // Clear screen for displaying request and response
    echo "\033[2J\033[H";
    echo "\033[1;35m=========================================================\033[0m\n";
    echo "  \033[1;36mREQUEST DETAILS\033[0m\n";
    echo "\033[1;35m=========================================================\033[0m\n";
    echo "  Method: \033[1;33m{$method}\033[0m\n";
    echo "  URL:    \033[1;32m{$fullUrl}\033[0m\n";
    if (!empty($postParams)) {
        echo "  Body:   \033[1;30m" . json_encode($postParams) . "\033[0m\n";
    }
    echo "\nSending request...\n";
    
    // Make Request
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $fullUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HEADER, true);
    curl_setopt($ch, CURLOPT_COOKIEJAR, $cookieJar);
    curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieJar);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'X-Requested-With: XMLHttpRequest',
        'Accept: application/json'
    ]);
    
    if ($method === 'POST') {
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postParams));
    }
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $headerSize = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
    curl_close($ch);
    
    if ($response === false) {
        echo "\033[1;31mError: Connection failed.\033[0m\n";
        promptInput("\nPress [ENTER] to return to the route menu...");
        continue;
    }
    
    $headers = substr($response, 0, $headerSize);
    $body = substr($response, $headerSize);
    
    // Status Code Coloring
    $statusColor = "\033[1;31m"; // Red
    if ($httpCode >= 200 && $httpCode < 300) $statusColor = "\033[1;32m"; // Green
    if ($httpCode >= 300 && $httpCode < 400) $statusColor = "\033[1;33m"; // Yellow
    
    echo "\n\033[1;35m=========================================================\033[0m\n";
    echo "  \033[1;36mRESPONSE DETAILS\033[0m\n";
    echo "\033[1;35m=========================================================\033[0m\n";
    echo "  Status: {$statusColor}{$httpCode}\033[0m\n\n";
    
    if (trim($body) === '') {
        echo "  \033[1;30m[Empty Response]\033[0m\n";
    } else {
        $decoded = json_decode($body);
        if ($decoded !== null) {
            echo colorizeJson($body) . "\n";
        } else {
            echo "  \033[1;31m[Non-JSON Output]:\033[0m\n";
            echo substr($body, 0, 1000) . (strlen($body) > 1000 ? "..." : "") . "\n";
        }
    }
    
    promptInput("\n\033[1;32mPress [ENTER] to return to the route menu...\033[0m");
}
