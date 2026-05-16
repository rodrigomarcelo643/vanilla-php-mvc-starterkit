<?php

class Auth
{
    public static function check()
    {
        return isset($_SESSION['user']);
    }
}