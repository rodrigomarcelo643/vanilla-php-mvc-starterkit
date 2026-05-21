<?php
global $argv;
$args = array_slice($argv, 2);
$nameArg = $args[0] ?? null;

if (!$nameArg) {
    Output::line();
    echo "\033[36m  What should the middleware be named? (e.g., AuthMiddleware): \033[0m";
    $nameArg = trim(fgets(STDIN));
    if (!$nameArg) {
        Output::error('Name is required.'); exit(1);
    }
}

$name = ucfirst($nameArg);
if (!str_ends_with($name, 'Middleware')) $name .= 'Middleware';

$path = KIT_ROOT . "/app/middlewares/{$name}.php";
$dir = dirname($path);

if (file_exists($path)) { Output::error("$name already exists."); exit(1); }
if (!is_dir($dir)) mkdir($dir, 0755, true);

$stub = <<<PHP
<?php

class {$name}
{
    public function handle(): void
    {
        // Example logic:
        // if (!isset(\$_SESSION['user_id'])) {
        //     header('Location: /login');
        //     exit;
        // }
    }
}
PHP;

file_put_contents($path, $stub);
Output::success("Created: app/middlewares/{$name}.php");
