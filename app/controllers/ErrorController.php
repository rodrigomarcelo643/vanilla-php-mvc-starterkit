<?php

class ErrorController extends Controller
{
    public function notFound()
    {
        http_response_code(404);
        include 'app/views/errors/404.php';
    }

    public function forbidden()
    {
        http_response_code(403);
        include 'app/views/errors/403.php';
    }

    public function internalError($exception = null)
    {
        http_response_code(500);
        include 'app/views/errors/500.php';
    }

    public function notImplemented()
    {
        http_response_code(501);
        include 'app/views/errors/501.php';
    }

    public function serviceUnavailable()
    {
        http_response_code(503);
        include 'app/views/errors/503.php';
    }

    public function maintenance()
    {
        http_response_code(503);
        include 'app/views/errors/maintenance.php';
    }
}