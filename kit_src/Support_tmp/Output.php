<?php

class Output
{
    static function info(string $msg)  { echo "\033[36m$msg\033[0m\n"; }
    static function success(string $msg) { echo "\033[32m✔ $msg\033[0m\n"; }
    static function error(string $msg)   { echo "\033[31m✘ $msg\033[0m\n"; }
    static function warn(string $msg)    { echo "\033[33m⚠ $msg\033[0m\n"; }
    static function line(string $msg = '') { echo "$msg\n"; }
    static function label(string $label, string $value) {
        echo "  \033[33m$label\033[0m  $value\n";
    }
}
