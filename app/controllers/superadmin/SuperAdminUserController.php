<?php

class SuperAdminUserController extends Controller
{
    public function index(): void
    {
        require_once 'app/models/User.php';
        $this->superadmin('superadmin/users', [
            'title' => 'Users',
            'users' => (new User())->getAll(),
        ]);
    }
}
