<?php

global $argv;
$args = array_slice($argv, 2);

$controllerNameArg = null;
foreach ($args as $arg) {
    if (!str_starts_with($arg, '--')) {
        $controllerNameArg = $arg;
        break;
    }
}

if (!$controllerNameArg) {
    Output::line();
    echo "\033[36m  What should the controller be named? (e.g., admin/user): \033[0m";
    $controllerNameArg = trim(fgets(STDIN));
    if (!$controllerNameArg) {
        Output::line();
        Output::error('Controller name is required.');
        Output::line();
        exit(1);
    }
}

$controllerNameArg = str_replace('\\', '/', $controllerNameArg);
$parts = explode('/', $controllerNameArg);
$namePart = array_pop($parts);

$panel = 'app';
$subDir = '';

if (count($parts) > 0) {
    $validPanels = ['admin', 'auth', 'superadmin', 'client', 'app'];
    if (in_array(strtolower($parts[0]), $validPanels)) {
        $panel = strtolower(array_shift($parts));
    }
    
    if (count($parts) > 0) {
        $subDir = '/' . implode('/', $parts);
    }
}

if (in_array('--admin', $args)) $panel = 'admin';
elseif (in_array('--auth', $args)) $panel = 'auth';
elseif (in_array('--superadmin', $args)) $panel = 'superadmin';
elseif (in_array('--client', $args)) $panel = 'client';

$name = ucfirst(str_replace('Controller', '', $namePart)) . 'Controller';
$isResource = in_array('--resource', $args);

$dir  = KIT_ROOT . "/app/controllers/$panel$subDir";
$path = "$dir/{$name}.php";

Output::line();

if (file_exists($path)) {
    Output::error("Controller \033[33m$name\033[0m already exists at \033[36m$panel$subDir\033[0m.");
    Output::line();
    exit(1);
}

Output::info("Creating controller \033[33m$name\033[0m at \033[36m$panel$subDir\033[0m...");

if (!is_dir($dir)) {
    mkdir($dir, 0777, true);
}

$viewBaseName = strtolower(str_replace('Controller', '', $name));
$viewPathBase = $panel . $subDir . '/' . $viewBaseName;

if ($isResource) {
    $stub = <<<PHP
<?php

class {$name} extends Controller
{
    public function index(): void
    {
        \$this->{$panel}('{$viewPathBase}/index', ['title' => '{$name}']);
    }

    public function create(): void
    {
        \$this->{$panel}('{$viewPathBase}/create', ['title' => 'Create {$name}']);
    }

    public function store(): void
    {
        // Handle store logic
    }

    public function show(int \$id): void
    {
        \$this->{$panel}('{$viewPathBase}/show', ['title' => 'Show {$name}']);
    }

    public function edit(int \$id): void
    {
        \$this->{$panel}('{$viewPathBase}/edit', ['title' => 'Edit {$name}']);
    }

    public function update(int \$id): void
    {
        // Handle update logic
    }

    public function destroy(int \$id): void
    {
        // Handle destroy logic
    }
}
PHP;
} else {
    $stub = <<<PHP
<?php

class {$name} extends Controller
{
    public function index(): void
    {
        \$this->{$panel}('{$viewPathBase}', ['title' => '{$name}']);
    }
}
PHP;
}

file_put_contents($path, $stub);

Output::line();
Output::success("Created: \033[36mapp/controllers/$panel$subDir/\033[33m{$name}.php\033[0m");
if ($isResource) {
    Output::success("Included resource methods (CRUD).");
}
Output::line();
