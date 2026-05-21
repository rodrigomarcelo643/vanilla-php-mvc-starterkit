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

$groups = [];
foreach ($routes as $route) {
    [$method, $uri, $action] = $route;
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
