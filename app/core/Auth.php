<?php

class Auth
{
    // Check User Session Auth
    public static function check()
    {
        return isset($_SESSION['user']);
    }
}