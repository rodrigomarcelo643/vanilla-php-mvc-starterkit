<?php

$routeDir = KIT_ROOT . '/routes/web';
$files    = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($routeDir));
$routes   = [];

foreach ($files as $file) {
    if ($file->getExtension() !== 'php') continue;
    $content = file_get_contents($file->getPathname());
    preg_match_all('/Router::(get|post|any)\s*\(\s*[\'"]([^\'"]+)[\'"]\s*,\s*\[\'([^\']+)\'\s*,\s*\'([^\']+)\'\]/', $content, $matches, PREG_SET_ORDER);
    foreach ($matches as $m) {
        $routes[] = [strtoupper($m[1]), $m[2], $m[3] . '@' . $m[4]];
    }
}

// ── Parse filters ─────────────────────────────────────────────
$argv = $_SERVER['argv'] ?? [];
$filterMethod = null;
$filterGroup = null;
$searchQuery = null;

for ($i = 2; $i < count($argv); $i++) {
    $arg = $argv[$i];
    
    if (strpos($arg, '=') !== false) {
        [$key, $val] = explode('=', $arg, 2);
        $key = ltrim($key, '-');
        if ($key === 'method' || $key === 'm') {
            $filterMethod = strtoupper($val);
        } elseif ($key === 'group' || $key === 'g') {
            $filterGroup = strtolower($val);
        } elseif ($key === 'search' || $key === 's') {
            $searchQuery = strtolower($val);
        }
    } else {
        if ($arg === '-m' || $arg === '--method') {
            $filterMethod = strtoupper($argv[++$i] ?? '');
        } elseif ($arg === '-g' || $arg === '--group') {
            $filterGroup = strtolower($argv[++$i] ?? '');
        } elseif ($arg === '-s' || $arg === '--search') {
            $searchQuery = strtolower($argv[++$i] ?? '');
        } else {
            $valUpper = strtoupper($arg);
            if (in_array($valUpper, ['GET', 'POST', 'ANY'])) {
                $filterMethod = $valUpper;
            } elseif (in_array(strtolower($arg), ['public', 'auth', 'authentication', 'oauth', 'app', 'admin', 'superadmin', 'ajax'])) {
                $filterGroup = strtolower($arg);
                if ($filterGroup === 'auth') $filterGroup = 'authentication';
            } else {
                $searchQuery = strtolower($arg);
            }
        }
    }
}

$groups = [];
foreach ($routes as $route) {
    [$method, $uri, $action] = $route;
    
    // 1. Method Filter
    if ($filterMethod && $method !== $filterMethod) {
        continue;
    }
    
    // Determine the route's group
    $first = explode('/', trim($uri, '/'))[0];
    if ($first === '' || !in_array($first, ['admin', 'superadmin', 'app', 'ajax', 'oauth'])) {
        if (in_array($first, ['login', 'register', 'forgot-password', 'reset-password'])) {
            $group = 'Authentication';
        } else {
            $group = 'Public';
        }
    } else {
        $group = ucfirst($first);
        if ($group === 'Oauth') $group = 'OAuth';
        if ($group === 'Ajax') $group = 'AJAX';
    }
    
    // 2. Group Filter
    if ($filterGroup && strtolower($group) !== $filterGroup) {
        continue;
    }
    
    // 3. Search Query Filter
    if ($searchQuery && strpos(strtolower($uri), $searchQuery) === false && strpos(strtolower($action), $searchQuery) === false) {
        continue;
    }
    
    $groups[$group][] = $route;
}

$order = ['Public', 'Authentication', 'OAuth', 'App', 'Admin', 'Superadmin', 'AJAX'];
uksort($groups, function($a, $b) use ($order) {
    $posA = array_search($a, $order);
    $posB = array_search($b, $order);
    if ($posA === false) $posA = 99;
    if ($posB === false) $posB = 99;
    if ($posA === $posB) return strcmp($a, $b);
    return $posA <=> $posB;
});

Output::line();

if ($filterMethod || $filterGroup || $searchQuery) {
    $active = [];
    if ($filterMethod) $active[] = "Method = \033[1;33m{$filterMethod}\033[0m";
    if ($filterGroup) $active[] = "Group = \033[1;33m" . ucfirst($filterGroup) . "\033[0m";
    if ($searchQuery) $active[] = "Search = \033[1;33m'{$searchQuery}'\033[0m";
    Output::line("  \033[1;30mActive Filters: " . implode(', ', $active) . "\033[0m");
    Output::line();
}

if (empty($groups)) {
    Output::line("  \033[1;31mNo matching routes found.\033[0m");
    Output::line();
} else {
    foreach ($groups as $group => $catRoutes) {
        Output::line("  \033[1;36m" . strtoupper($group) . " ROUTES\033[0m");
        Output::line("  \033[33m" . str_pad('METHOD', 8) . str_pad('URI', 40) . "ACTION\033[0m");
        Output::line('  ' . str_repeat('─', 70));
        
        foreach ($catRoutes as [$method, $uri, $action]) {
            $color = match($method) { 'GET' => "\033[32m", 'POST' => "\033[34m", default => "\033[36m" };
            echo "  {$color}" . str_pad($method, 8) . "\033[0m" . str_pad($uri, 40) . $action . "\n";
        }
        Output::line();
    }
}
