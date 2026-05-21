<?php

global $argv;
$args = array_slice($argv, 2);

$viewArg = null;
foreach ($args as $arg) {
    if (!str_starts_with($arg, '--')) {
        $viewArg = $arg;
        break;
    }
}

if (!$viewArg) {
    Output::line();
    echo "\033[36m  What should the view be named? (e.g., admin/dashboard): \033[0m";
    $viewArg = trim(fgets(STDIN));
    if (!$viewArg) {
        Output::line();
        Output::error('View name is required.');
        Output::line();
        exit(1);
    }
}

$isResource = in_array('--resource', $args);

Output::line();

if ($isResource) {
    // Treat viewArg as a folder and generate CRUD views
    $dir = KIT_ROOT . '/app/views/' . ltrim($viewArg, '/');
    if (!is_dir($dir)) {
        mkdir($dir, 0755, true);
    }
    
    $title = ucfirst(basename($viewArg));
    $views = ['index', 'create', 'edit', 'show'];
    
    Output::info("Creating resource views for \033[36m$viewArg\033[0m...");
    
    foreach ($views as $view) {
        $viewPath = "$dir/{$view}.php";
        if (file_exists($viewPath)) {
            Output::line("  \033[31m-\033[0m Skipped (already exists): \033[33m$view.php\033[0m");
            continue;
        }
        
        $actionTitle = ucfirst($view) . ' ' . $title;
        if ($view === 'index') $actionTitle = $title;
        
        $stub = <<<HTML
<div class="fade-in">
    <div class="mb-6">
        <h1 class="text-2xl font-semibold text-zinc-900 dark:text-zinc-100">{$actionTitle}</h1>
        <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">Page description here.</p>
    </div>
    <!-- Content for {$view} -->
</div>
HTML;
        file_put_contents($viewPath, $stub);
        Output::line("  \033[32m+\033[0m Created: \033[36mapp/views/$viewArg/\033[33m{$view}.php\033[0m");
    }
} else {
    $viewPath = KIT_ROOT . '/app/views/' . ltrim($viewArg, '/') . '.php';
    $dir      = dirname($viewPath);

    if (file_exists($viewPath)) { 
        Output::error("View already exists: \033[33m{$viewArg}.php\033[0m"); 
        Output::line();
        exit(1); 
    }
    
    if (!is_dir($dir)) mkdir($dir, 0755, true);

    Output::info("Creating view \033[36m$viewArg\033[0m...");

    $title = ucfirst(basename($viewArg));
    $stub  = <<<HTML
<div class="fade-in">
    <div class="mb-6">
        <h1 class="text-2xl font-semibold text-zinc-900 dark:text-zinc-100">{$title}</h1>
        <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">Page description here.</p>
    </div>
    <!-- Content -->
</div>
HTML;

    file_put_contents($viewPath, $stub);
    Output::success("Created: \033[36mapp/views/\033[33m{$viewArg}.php\033[0m");
}

Output::line();
