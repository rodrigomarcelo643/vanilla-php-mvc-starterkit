<?php

class Controller
{
    // Client Views
    public function client($view, $data = [])
    {
        extract($data);
        include 'app/views/layouts/client/header.php';
        include "app/views/$view.php";
        include 'app/views/layouts/client/footer.php';
    }
    // Admin Views
    public function admin($view, $data = [])
    {
        extract($data);
        include 'app/views/layouts/admin/header.php';
        include "app/views/$view.php";
        include 'app/views/layouts/admin/footer.php';
    }
    // User Views
    public function app($view, $data = [])
    {
        extract($data);
        include 'app/views/layouts/app/header.php';
        include "app/views/$view.php";
        include 'app/views/layouts/app/footer.php';
    }
    // Auth Views
    public function auth($view, $data = [])
    {
        extract($data);
        include 'app/views/layouts/auth/header.php';
        include "app/views/$view.php";
        include 'app/views/layouts/auth/footer.php';
    }

    public function superadmin($view, $data = [])
    {
        extract($data);
        include 'app/views/layouts/superadmin/header.php';
        include "app/views/$view.php";
        include 'app/views/layouts/superadmin/footer.php';
    }
}