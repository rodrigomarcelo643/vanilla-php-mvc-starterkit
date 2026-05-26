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

// Detect active installation preset and route files to parse
$hasAjaxRoutes = file_exists(KIT_ROOT . '/routes/web/auth/ajax.php')
              || file_exists(KIT_ROOT . '/routes/web/app/ajax.php')
              || file_exists(KIT_ROOT . '/routes/web/admin/ajax.php')
              || file_exists(KIT_ROOT . '/routes/web/superadmin/ajax.php');

$hasJqueryRoutes = file_exists(KIT_ROOT . '/routes/web/auth/jquery.php')
                || file_exists(KIT_ROOT . '/routes/web/app/jquery.php')
                || file_exists(KIT_ROOT . '/routes/web/admin/jquery.php')
                || file_exists(KIT_ROOT . '/routes/web/superadmin/jquery.php');

$isJqueryPreset = file_exists(KIT_ROOT . '/js/jquery.min.js');

$routeFiles = [];
$activePreset = '';

if ($isJqueryPreset && $hasJqueryRoutes) {
    $activePreset = 'jQuery Stack (Option 4)';
    $routeFiles = [
        KIT_ROOT . '/routes/web/auth/jquery.php',
        KIT_ROOT . '/routes/web/app/jquery.php',
        KIT_ROOT . '/routes/web/admin/jquery.php',
        KIT_ROOT . '/routes/web/superadmin/jquery.php',
    ];
} elseif ($hasAjaxRoutes) {
    $activePreset = 'Full Stack (Option 1 - Alpine.js)';
    $routeFiles = [
        KIT_ROOT . '/routes/web/auth/ajax.php',
        KIT_ROOT . '/routes/web/app/ajax.php',
        KIT_ROOT . '/routes/web/admin/ajax.php',
        KIT_ROOT . '/routes/web/superadmin/ajax.php',
    ];
} else {
    // Determine REST API vs Backend Only
    $hasViews = is_dir(KIT_ROOT . '/app/views') && count(scandir(KIT_ROOT . '/app/views')) > 2;
    if ($hasViews) {
        $activePreset = 'REST API (Option 2 - Full Stack JS)';
    } else {
        $activePreset = 'Backend Only (Option 3 - REST API, No UI)';
    }
    $routeFiles = [
        KIT_ROOT . '/routes/api.php',
    ];
}

// Append pages routes if not Backend Only (Option 3), so they are testable
if (is_dir(KIT_ROOT . '/routes/web')) {
    $pageFiles = [
        KIT_ROOT . '/routes/web/auth/pages.php',
        KIT_ROOT . '/routes/web/auth/oauth.php',
        KIT_ROOT . '/routes/web/client/pages.php',
        KIT_ROOT . '/routes/web/superadmin/pages.php',
        KIT_ROOT . '/routes/web/admin/pages.php',
        KIT_ROOT . '/routes/web/app/pages.php',
    ];
    foreach ($pageFiles as $pf) {
        if (file_exists($pf)) {
            $routeFiles[] = $pf;
        }
    }
}

$apiRoutes = [];

// Always include api/ping (health check) as a standard test route
$apiRoutes[] = ['method' => 'GET', 'path' => 'api/ping'];

foreach ($routeFiles as $file) {
    if (!file_exists($file)) {
        continue;
    }
    $content = file_get_contents($file);
    preg_match_all('/Router::(get|post|any|put|patch|delete)\s*\(\s*[\'"]([^\'"]*)[\'"]/i', $content, $matches);
    if (!empty($matches[2])) {
        foreach ($matches[2] as $i => $path) {
            $method = strtoupper($matches[1][$i]);
            if ($method === 'ANY') {
                $apiRoutes[] = ['method' => 'GET', 'path' => $path];
                $apiRoutes[] = ['method' => 'POST', 'path' => $path];
            } else {
                $apiRoutes[] = ['method' => $method, 'path' => $path];
            }
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
    
    // Normalize path by stripping api/, ajax/, jquery/ prefixes
    $normalized = $path;
    if (str_starts_with($normalized, 'api/')) {
        $normalized = substr($normalized, 4);
    } elseif (str_starts_with($normalized, 'ajax/')) {
        $normalized = substr($normalized, 5);
    } elseif (str_starts_with($normalized, 'jquery/')) {
        $normalized = substr($normalized, 7);
    }
    
    if (str_starts_with($normalized, 'auth') || $normalized === 'login' || $normalized === 'register' || $normalized === 'logout' || $normalized === 'forgot-password' || $normalized === 'reset-password') {
        return 'AUTHENTICATION & SESSION';
    }
    if (str_starts_with($normalized, 'admin') || str_starts_with($normalized, 'users')) {
        return 'ADMIN MANAGEMENT';
    }
    if (str_starts_with($normalized, 'superadmin') || str_starts_with($normalized, 'admins')) {
        return 'SUPERADMIN CONTROL';
    }
    if (str_starts_with($normalized, 'profile') || $normalized === 'avatar' || $normalized === 'change-password') {
        return 'PROFILE & SETTINGS';
    }
    if (str_starts_with($normalized, 'app')) {
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

function formatHtmlPreview($html) {
    // Extract title
    $title = '';
    if (preg_match('/<title>(.*?)<\/title>/si', $html, $matches)) {
        $title = trim($matches[1]);
    }
    
    // Strip styles, scripts, and head block to avoid garbage in preview
    $cleanHtml = preg_replace('/<(script|style|head)\b[^>]*>(.*?)<\/\1>/si', '', $html);
    
    // Convert typical layout elements
    preg_match_all('/<h[1-4]\b[^>]*>(.*?)<\/h[1-4]>/si', $cleanHtml, $headingMatches);
    
    $preview = "";
    if ($title) {
        $preview .= "  \033[1;36mPage Title:\033[0m {$title}\n\n";
    }
    
    if (!empty($headingMatches[1])) {
        $preview .= "  \033[1;33mPage Headings / Structure:\033[0m\n";
        foreach (array_slice($headingMatches[1], 0, 10) as $h) {
            $hText = trim(strip_tags($h));
            if ($hText) {
                $preview .= "    • {$hText}\n";
            }
        }
        $preview .= "\n";
    }
    
    return $preview;
}

function parseHtmlTable($html) {
    // 1. Try static HTML table parsing first
    $tableData = null;
    if (preg_match_all('/<table\b[^>]*>(.*?)<\/table>/si', $html, $tableMatches)) {
        foreach ($tableMatches[1] as $tableContent) {
            // Ignore skeleton tables containing loading indicators
            if (strpos($tableContent, 'skeleton-base') !== false || strpos($tableContent, 'skeleton') !== false) {
                continue;
            }
            
            $headers = [];
            if (preg_match('/<thead\b[^>]*>(.*?)<\/thead>/si', $tableContent, $theadMatch)) {
                preg_match_all('/<th\b[^>]*>(.*?)<\/th>/si', $theadMatch[1], $thMatches);
                foreach ($thMatches[1] as $th) {
                    $headers[] = trim(strip_tags($th));
                }
            }
            
            $rows = [];
            if (preg_match('/<tbody\b[^>]*>(.*?)<\/tbody>/si', $tableContent, $tbodyMatch)) {
                preg_match_all('/<tr\b[^>]*>(.*?)<\/tr>/si', $tbodyMatch[1], $trMatches);
                foreach ($trMatches[1] as $tr) {
                    preg_match_all('/<td\b[^>]*>(.*?)<\/td>/si', $tr, $tdMatches);
                    $row = [];
                    foreach ($tdMatches[1] as $td) {
                        $tdClean = preg_replace('/<br\s*\/?>/i', "\n", $td);
                        $tdClean = trim(strip_tags($tdClean));
                        $tdClean = preg_replace('/\s+/', ' ', $tdClean);
                        $row[] = $tdClean;
                    }
                    if (!empty($row)) {
                        $rows[] = $row;
                    }
                }
            }
            
            if (empty($headers) && !empty($rows)) {
                foreach (range(1, count($rows[0])) as $num) {
                    $headers[] = "Col " . $num;
                }
            }
            
            if (!empty($rows)) {
                $tableData = ['headers' => $headers, 'rows' => $rows];
                break; // Found a valid parsed static table, stop searching
            }
        }
    }
    
    // 2. If no table rows are found, check if there's an Alpine.js dataset embedded in x-data
    if (!$tableData || empty($tableData['rows'])) {
        $tableData = parseAlpineDataset($html);
    }
    
    return $tableData;
}

function parseAlpineDataset($html) {
    if (preg_match('/x-data="[A-Za-z]+Table\((.*?)\)"/si', $html, $match) || 
        preg_match('/x-data="[A-Za-z]+\((.*?)\)"/si', $html, $match)) {
        
        $decodedJson = html_entity_decode($match[1], ENT_QUOTES | ENT_HTML5);
        $items = json_decode($decodedJson, true);
        
        if (is_array($items) && !empty($items)) {
            $firstItem = reset($items);
            if (is_array($firstItem)) {
                $excludedKeys = ['password', 'password_hash', 'remember_token', 'updated_at', 'deleted_at', 'avatar_url', 'bio'];
                $filteredHeaders = [];
                $validKeys = [];
                foreach (array_keys($firstItem) as $k) {
                    if (!in_array($k, $excludedKeys)) {
                        $filteredHeaders[] = ucfirst($k);
                        $validKeys[] = $k;
                    }
                }
                
                $rows = [];
                foreach ($items as $item) {
                    $row = [];
                    foreach ($validKeys as $k) {
                        $val = $item[$k] ?? '';
                        if (is_bool($val)) $val = $val ? 'true' : 'false';
                        if (is_array($val)) $val = json_encode($val);
                        $row[] = (string)$val;
                    }
                    $rows[] = $row;
                }
                
                return ['headers' => $filteredHeaders, 'rows' => $rows];
            }
        }
    }
    
    return null;
}

function renderVisualTable($headers, $rows) {
    $rows = array_slice($rows, 0, 10);
    if (empty($rows)) return;
    
    $widths = [];
    foreach ($headers as $i => $h) {
        $widths[$i] = strlen($h);
    }
    foreach ($rows as $row) {
        foreach ($row as $i => $val) {
            if (!isset($widths[$i])) {
                $widths[$i] = 0;
            }
            $widths[$i] = max($widths[$i], strlen($val));
        }
    }
    
    // Draw Top Border
    $topBorder = "    ┌";
    foreach ($widths as $i => $w) {
        $topBorder .= str_repeat('─', $w + 2);
        if ($i < count($widths) - 1) {
            $topBorder .= "┬";
        }
    }
    $topBorder .= "┐";
    echo $topBorder . "\n";
    
    // Draw Header
    $headerLine = "    │";
    foreach ($headers as $i => $h) {
        $headerLine .= " \033[1;36m" . str_pad($h, $widths[$i]) . "\033[0m ";
        if ($i < count($headers) - 1) {
            $headerLine .= "│";
        }
    }
    $headerLine .= "│";
    echo $headerLine . "\n";
    
    // Draw Separator
    $separator = "    ├";
    foreach ($widths as $i => $w) {
        $separator .= str_repeat('─', $w + 2);
        if ($i < count($widths) - 1) {
            $separator .= "┼";
        }
    }
    $separator .= "┤";
    echo $separator . "\n";
    
    // Draw Rows
    foreach ($rows as $row) {
        $rowLine = "    │";
        foreach ($widths as $i => $w) {
            $val = $row[$i] ?? '';
            $rowLine .= " " . str_pad($val, $w) . " ";
            if ($i < count($widths) - 1) {
                $rowLine .= "│";
            }
        }
        $rowLine .= "│";
        echo $rowLine . "\n";
    }
    
    // Draw Bottom Border
    $bottomBorder = "    └";
    foreach ($widths as $i => $w) {
        $bottomBorder .= str_repeat('─', $w + 2);
        if ($i < count($widths) - 1) {
            $bottomBorder .= "┴";
        }
    }
    $bottomBorder .= "┘";
    echo $bottomBorder . "\n";
}

// ── Main Loop ──

while (true) {
    // Clear Terminal Screen for Clean UI
    echo "\033[2J\033[H";
    
    // Print Header
    echo "\033[1;35m=========================================================\033[0m\n";
    echo "\033[1;36m  MARDEV BACKEND API INTERACTIVE CLI TESTER\033[0m\n";
    echo "\033[1;35m=========================================================\033[0m\n";
    echo "Target host:   \033[1;33m{$targetHost}\033[0m\n";
    echo "Active preset: \033[1;32m{$activePreset}\033[0m\n";
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
            $isHtml = (strpos(strtolower($headers), 'content-type: text/html') !== false) 
                   || (strpos(strtolower($body), '<html') !== false) 
                   || (strpos(strtolower($body), '<!doctype') !== false);
            
            if ($isHtml) {
                $tableData = parseHtmlTable($body);
                if ($tableData && !empty($tableData['rows'])) {
                    echo "  \033[1;33m[ VISUAL TABLE CONTENT (MAX 10 ROWS) ]\033[0m\n\n";
                    renderVisualTable($tableData['headers'], $tableData['rows']);
                    echo "\n";
                } else {
                    echo "  \033[1;36m[ Rendered HTML Preview ]:\033[0m\n";
                    echo formatHtmlPreview($body) . "\n";
                }
            } else {
                echo "  \033[1;31m[Non-JSON Output]:\033[0m\n";
                echo substr($body, 0, 1000) . (strlen($body) > 1000 ? "..." : "") . "\n";
            }
        }
    }
    
    // Detect redirect target
    $redirectUrl = null;
    $decodedArray = json_decode($body, true);
    if (is_array($decodedArray) && isset($decodedArray['redirect'])) {
        $redirectUrl = $decodedArray['redirect'];
    }
    if (!$redirectUrl && preg_match('/^Location:\s*([^\r\n]+)/im', $headers, $match)) {
        $redirectUrl = trim($match[1]);
    }
    
    if ($redirectUrl) {
        echo "\n\033[1;35m=========================================================\033[0m\n";
        echo "  \033[1;36mREDIRECT DETECTED\033[0m\n";
        echo "\033[1;35m=========================================================\033[0m\n";
        echo "  Target URL: \033[1;33m{$redirectUrl}\033[0m\n\n";
        echo "  \033[1;32m[Y]\033[0m Follow redirect (Interactive Area Browser)\n";
        echo "  \033[1;30m[N]\033[0m Return to main menu\n";
        
        $followChoice = strtoupper(promptInput("\nFollow redirect? [Y/n]: "));
        if ($followChoice === '' || $followChoice === 'Y' || $followChoice === 'YES') {
            // Resolve full URL
            $resolvedRedirectUrl = $redirectUrl;
            if (!str_starts_with($redirectUrl, 'http://') && !str_starts_with($redirectUrl, 'https://')) {
                $hostParts = parse_url($targetHost);
                $hostRoot = ($hostParts['scheme'] ?? 'http') . '://' . ($hostParts['host'] ?? 'localhost') . (isset($hostParts['port']) ? ':' . $hostParts['port'] : '');
                if (str_starts_with($redirectUrl, '/')) {
                    $resolvedRedirectUrl = $hostRoot . $redirectUrl;
                } else {
                    $resolvedRedirectUrl = rtrim($targetHost, '/') . '/' . $redirectUrl;
                }
            }
            
            // Check if we are in admin/superadmin dashboard space
            $isDashboardSpace = (strpos($resolvedRedirectUrl, '/admin') !== false) 
                             || (strpos($resolvedRedirectUrl, '/superadmin') !== false);
            
            if ($isDashboardSpace) {
                // RUN DYNAMIC INTERACTIVE BROWSER
                $currentPageUrl = $resolvedRedirectUrl;
                while ($currentPageUrl !== null) {
                    echo "\033[2J\033[H";
                    echo "\033[1;35m=========================================================\033[0m\n";
                    echo "  \033[1;36mNAVIGATING TO:\033[0m \033[1;32m{$currentPageUrl}\033[0m\n";
                    echo "\033[1;35m=========================================================\033[0m\n";
                    echo "Sending request...\n";
                    
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, $currentPageUrl);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_HEADER, true);
                    curl_setopt($ch, CURLOPT_COOKIEJAR, $cookieJar);
                    curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieJar);
                    curl_setopt($ch, CURLOPT_HTTPHEADER, [
                        'X-Requested-With: XMLHttpRequest',
                        'Accept: application/json'
                    ]);
                    
                    $response = curl_exec($ch);
                    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                    $headerSize = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
                    curl_close($ch);
                    
                    if ($response === false) {
                        echo "\033[1;31mError: Connection failed to {$currentPageUrl}\033[0m\n";
                        promptInput("Press [ENTER] to return...");
                        break;
                    }
                    
                    $headers = substr($response, 0, $headerSize);
                    $body = substr($response, $headerSize);
                    
                    echo "\033[2J\033[H";
                    
                    $title = '';
                    if (preg_match('/<title>(.*?)<\/title>/si', $body, $titleMatch)) {
                        $title = trim($titleMatch[1]);
                    }
                    
                    echo "\033[1;35m=========================================================\033[0m\n";
                    echo "  \033[1;36mDASHBOARD BROWSER: " . strtoupper($title ?: 'Admin Area') . "\033[0m\n";
                    echo "\033[1;35m=========================================================\033[0m\n";
                    echo "  URL:    \033[1;32m{$currentPageUrl}\033[0m\n";
                    echo "  Status: \033[1;33m{$httpCode}\033[0m\n";
                    echo "\033[1;35m=========================================================\033[0m\n\n";
                    
                    // Render Visual HTML Table if present
                    $tableData = parseHtmlTable($body);
                    if ($tableData && !empty($tableData['rows'])) {
                        echo "  \033[1;33m[ VISUAL TABLE CONTENT (MAX 10 ROWS) ]\033[0m\n\n";
                        renderVisualTable($tableData['headers'], $tableData['rows']);
                        echo "\n";
                    } else {
                        echo "  \033[1;36m[ Page Content Preview ]\033[0m\n";
                        echo formatHtmlPreview($body) . "\n";
                    }
                    
                    $isSuperadmin = (strpos($currentPageUrl, 'superadmin') !== false);
                    
                    echo "\033[1;35m=========================================================\033[0m\n";
                    echo "  \033[1;36mDASHBOARD NAVIGATION MENU\033[0m\n";
                    echo "\033[1;35m=========================================================\033[0m\n";
                    
                    if ($isSuperadmin) {
                        echo "  \033[1;32m[1]\033[0m Superadmin Dashboard  (GET superadmin/dashboard)\n";
                        echo "  \033[1;32m[2]\033[0m Manage Admins         (GET superadmin/admins)\n";
                        echo "  \033[1;32m[3]\033[0m View All Users        (GET superadmin/users)\n";
                        echo "  \033[1;32m[4]\033[0m Superadmin Settings   (GET superadmin/settings)\n";
                        echo "  \033[1;32m[5]\033[0m Superadmin Profile    (GET superadmin/profile)\n";
                    } else {
                        echo "  \033[1;32m[1]\033[0m Admin Dashboard       (GET admin/dashboard)\n";
                        echo "  \033[1;32m[2]\033[0m Manage Users          (GET admin/users)\n";
                        echo "  \033[1;32m[3]\033[0m Admin Settings        (GET admin/settings)\n";
                        echo "  \033[1;32m[4]\033[0m Admin Profile         (GET admin/profile)\n";
                    }
                    echo "  \033[1;31m[B]\033[0m Go Back / Return to Route Menu\n";
                    
                    $navChoice = strtoupper(promptInput("\nChoose navigation option: "));
                    if ($navChoice === 'B' || $navChoice === 'BACK') {
                        break;
                    }
                    
                    $targetPath = '';
                    if ($isSuperadmin) {
                        $targetPath = match ($navChoice) {
                            '1' => 'superadmin/dashboard',
                            '2' => 'superadmin/admins',
                            '3' => 'superadmin/users',
                            '4' => 'superadmin/settings',
                            '5' => 'superadmin/profile',
                            default => ''
                        };
                    } else {
                        $targetPath = match ($navChoice) {
                            '1' => 'admin/dashboard',
                            '2' => 'admin/users',
                            '3' => 'admin/settings',
                            '4' => 'admin/profile',
                            default => ''
                        };
                    }
                    
                    if ($targetPath !== '') {
                        $hostParts = parse_url($targetHost);
                        $hostRoot = ($hostParts['scheme'] ?? 'http') . '://' . ($hostParts['host'] ?? 'localhost') . (isset($hostParts['port']) ? ':' . $hostParts['port'] : '');
                        if (str_starts_with($targetPath, '/')) {
                            $currentPageUrl = $hostRoot . $targetPath;
                        } else {
                            $currentPageUrl = rtrim($targetHost, '/') . '/' . $targetPath;
                        }
                    } else {
                        echo "\033[1;31mInvalid option.\033[0m\n";
                        promptInput("Press [ENTER] to continue...");
                    }
                }
            } else {
                // Non-dashboard standard single redirect
                echo "\033[2J\033[H";
                echo "\033[1;35m=========================================================\033[0m\n";
                echo "  \033[1;36mFOLLOWING REDIRECT DETAILS\033[0m\n";
                echo "\033[1;35m=========================================================\033[0m\n";
                echo "  Method: \033[1;33mGET\033[0m\n";
                echo "  URL:    \033[1;32m{$resolvedRedirectUrl}\033[0m\n";
                echo "\nSending request...\n";
                
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $resolvedRedirectUrl);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_HEADER, true);
                curl_setopt($ch, CURLOPT_COOKIEJAR, $cookieJar);
                curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieJar);
                curl_setopt($ch, CURLOPT_HTTPHEADER, [
                    'X-Requested-With: XMLHttpRequest',
                    'Accept: application/json'
                ]);
                
                $response = curl_exec($ch);
                $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                $headerSize = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
                curl_close($ch);
                
                if ($response !== false) {
                    $headers = substr($response, 0, $headerSize);
                    $body = substr($response, $headerSize);
                    
                    $statusColor = "\033[1;31m";
                    if ($httpCode >= 200 && $httpCode < 300) $statusColor = "\033[1;32m";
                    if ($httpCode >= 300 && $httpCode < 400) $statusColor = "\033[1;33m";
                    
                    echo "\n\033[1;35m=========================================================\033[0m\n";
                    echo "  \033[1;36mRESPONSE DETAILS (FOLLOWED REDIRECT)\033[0m\n";
                    echo "\033[1;35m=========================================================\033[0m\n";
                    echo "  Status: {$statusColor}{$httpCode}\033[0m\n\n";
                    
                    if (trim($body) === '') {
                        echo "  \033[1;30m[Empty Response]\033[0m\n";
                    } else {
                        $decoded = json_decode($body);
                        if ($decoded !== null) {
                            echo colorizeJson($body) . "\n";
                        } else {
                            $isHtml = (strpos(strtolower($headers), 'content-type: text/html') !== false) 
                                   || (strpos(strtolower($body), '<html') !== false) 
                                   || (strpos(strtolower($body), '<!doctype') !== false);
                            
                            if ($isHtml) {
                                echo "  \033[1;36m[Rendered HTML Preview]:\033[0m\n";
                                echo formatHtmlPreview($body) . "\n";
                            } else {
                                echo "  \033[1;31m[Non-JSON Output]:\033[0m\n";
                                echo substr($body, 0, 1000) . (strlen($body) > 1000 ? "..." : "") . "\n";
                            }
                        }
                    }
                } else {
                    echo "\033[1;31mError: Connection failed during redirect.\033[0m\n";
                }
            }
        }
    }
    
    promptInput("\n\033[1;32mPress [ENTER] to return to the route menu...\033[0m");
}
