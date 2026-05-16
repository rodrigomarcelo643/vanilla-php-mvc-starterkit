<?php

class DashboardController extends Controller
{
    public function index()
    {
        if (!Auth::check()) {
            header('Location: ' . BASE_URL . '/login');
            exit;
        }
        require_once 'app/models/User.php';
        $userModel   = new User();
        $totalUsers  = $userModel->count();
        $recentUsers = array_slice($userModel->getAll(), 0, 5);

        $this->admin('admin/dashboard', [
            'title'       => 'Dashboard',
            'totalUsers'  => $totalUsers,
            'recentUsers' => $recentUsers,
        ]);
    }

    public function users()
    {
        if (!Auth::check()) {
            header('Location: ' . BASE_URL . '/login');
            exit;
        }
        require_once 'app/models/User.php';
        $userModel = new User();

        $this->admin('admin/users', [
            'title' => 'Users',
            'users' => $userModel->getAll(),
        ]);
    }

    public function settings()
    {
        if (!Auth::check()) {
            header('Location: ' . BASE_URL . '/login');
            exit;
        }
        $this->admin('admin/settings', ['title' => 'Settings']);
    }
}
