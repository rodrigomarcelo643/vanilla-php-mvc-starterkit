<?php

$key     = 'base64:' . base64_encode(random_bytes(32));
$envFile = KIT_ROOT . '/.env';
$env     = file_get_contents($envFile);

if (str_contains($env, 'APP_KEY=')) {
    $env = preg_replace('/^APP_KEY=.*/m', "APP_KEY=\"{$key}\"", $env);
} else {
    $env .= "\nAPP_KEY=\"{$key}\"\n";
}

file_put_contents($envFile, $env);
Output::success("APP_KEY set: {$key}");
