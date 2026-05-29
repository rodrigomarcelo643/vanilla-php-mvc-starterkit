<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

echo "<h1>Starterkit Environment Diagnostics</h1>";
echo "PHP Version: " . phpversion() . "<br>";
echo "Current Directory: " . __DIR__ . "<br>";

$env_exists = file_exists(__DIR__ . '/.env') ? 'Yes' : 'No';
echo "Does .env exist? " . $env_exists . "<br>";

if ($env_exists === 'Yes') {
    $env = @parse_ini_file(__DIR__ . '/.env');
    if ($env === false) {
        echo "Failed to parse .env file!<br>";
    } else {
        echo ".env loaded successfully. Keys present:<br>";
        echo "<pre>";
        print_r(array_keys($env));
        echo "</pre>";
    }
} else {
    echo "Please create a .env file on Hostinger in the root directory!<br>";
}
