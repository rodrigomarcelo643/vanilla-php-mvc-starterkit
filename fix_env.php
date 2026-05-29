<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
header('Content-Type: text/plain');

$envPath = __DIR__ . '/.env';
if (!file_exists($envPath)) {
    echo "Error: .env file does not exist on Hostinger!\n";
    exit;
}

$content = file_get_contents($envPath);
echo "--- Original .env content ---\n";
echo $content;
echo "\n-----------------------------\n";

// Fix concatenated SSH_PORT and SSH_USER line if present
$fixedContent = preg_replace('/SSH_PORT=(\d+)SSH_USER=(.+)/', "SSH_PORT=$1\nSSH_USER=$2", $content);

if ($content !== $fixedContent) {
    file_put_contents($envPath, $fixedContent);
    echo "Found and fixed the concatenated SSH_PORT and SSH_USER line!\n";
} else {
    echo "No concatenated SSH_PORT/SSH_USER line was found in the .env file.\n";
}

// Test parsing the .env file now
$env = @parse_ini_file($envPath);
if ($env === false) {
    echo "ERROR: The .env file STILL fails to parse!\n";
    
    // Line-by-line syntax validation to locate the exact invalid line
    $lines = file($envPath, FILE_IGNORE_NEW_LINES);
    foreach ($lines as $i => $line) {
        $trimmed = trim($line);
        if (empty($trimmed) || $trimmed[0] === ';' || $trimmed[0] === '#') {
            continue;
        }
        
        // Write a single line to a temporary file and try to parse it
        $tempFile = tempnam(sys_get_temp_dir(), 'ini');
        file_put_contents($tempFile, $line);
        $res = @parse_ini_file($tempFile);
        unlink($tempFile);
        
        if ($res === false) {
            echo "Line " . ($i + 1) . " has INVALID INI syntax: \"$line\"\n";
        }
    }
} else {
    echo "SUCCESS: The .env file was successfully parsed!\n";
    print_r(array_keys($env));
}
