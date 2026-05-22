<?php

$root    = defined('KIT_ROOT') ? KIT_ROOT : dirname(__DIR__, 2);
$envFile = $root . '/.env';
$env     = file_get_contents($envFile);
$folder  = basename($root);

// BASE_URL → /folder-name
$env = preg_replace('/^BASE_URL=.*/m', "BASE_URL=\"/{$folder}\"", $env);

// DB_NAME → folder name (lowercase, hyphens to underscores)
$dbName = strtolower(preg_replace('/[^a-zA-Z0-9_]/', '_', $folder));
$env = preg_replace('/^DB_NAME=.*/m', "DB_NAME={$dbName}", $env);

file_put_contents($envFile, $env);
Output::success("BASE_URL set to: /{$folder}");
Output::success("DB_NAME  set to: {$dbName}");
