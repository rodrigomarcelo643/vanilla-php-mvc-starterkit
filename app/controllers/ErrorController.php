<?php

class ErrorController extends Controller
{
    public function notFound()
    {
        include 'app/views/errors/404.php';
    }
}