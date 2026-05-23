<?php

class SuperAdminUserController extends Controller
{
    private function guard(): void
    {
        if (!Auth::check() || (Session::get('user')['role'] ?? '') !== 'superadmin') {
            header('Location: ' . BASE_URL . '/login');
            exit;
        }
    }

    public function index(): void
    {
        $this->guard();
        require_once 'app/models/User.php';
        $this->superadmin('superadmin/users', [
            'title' => 'Users',
            'users' => (new User())->getAll(),
        ]);
    }
}
