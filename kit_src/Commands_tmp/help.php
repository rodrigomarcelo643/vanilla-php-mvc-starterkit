<?php

echo "\n  \033[33mUsage:\033[0m\n";
echo "    \033[32mphp kit\033[0m \033[36m[command]\033[0m \033[90m[arguments] [options]\033[0m\n\n";

echo "  \033[33mAvailable Commands:\033[0m\n\n";

$categories = [
    'Database' => [
        'db:fresh'          => ['Drop all tables and re-import initial schema', ''],
        'db:seed'           => ['Import database/starter.sql into the database', ''],
        'migrate'           => ['Run pending migrations', ''],
        'migrate:rollback'  => ['Rollback the last batch of migrations', ''],
    ],
    'Make (Scaffolding)' => [
        'make:controller'   => ['Generate a new Controller class', '[Name] [--admin...] [--resource]'],
        'make:model'        => ['Generate a new Model class', '[Name] [--resource]'],
        'make:view'         => ['Generate a new View template file', '[folder/name] [--resource]'],
        'make:middleware'   => ['Generate a new Middleware class', '[Name]'],
        'make:migration'    => ['Generate a new Migration class', '[Name]'],
        'make:auth'         => ['Generate full Authentication scaffolding', ''],
    ],
    'Routing' => [
        'route:list'        => ['Display a list of all registered application routes', ''],
    ],
    'System' => [
        'tinker'            => ['Start an interactive PHP REPL session', ''],
        'serve'             => ['Start the local PHP built-in dev server', '[host?] [port?]'],
        'key:generate'      => ['Generate and apply a new APP_KEY in .env', ''],
        'cache:clear'       => ['Clear application cache files', ''],
        'logs:clear'        => ['Clear application log files', ''],
        'optimize:clear'    => ['Clear all compiled caches and logs at once', ''],
    ],
];

foreach ($categories as $category => $commands) {
    echo "  \033[1;36m{$category}\033[0m\n";
    foreach ($commands as $cmd => [$desc, $args]) {
        $cmdStr = str_pad($cmd, 22);
        echo "    \033[32m{$cmdStr}\033[0m \033[37m{$desc}\033[0m";
        if ($args) {
            echo " \033[90m{$args}\033[0m";
        }
        echo "\n";
    }
    echo "\n";
}
