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
        $allUsers    = $userModel->getAll();
        $totalUsers  = count($allUsers);
        $activeUsers = count(array_filter($allUsers, fn($u) => $u['status'] === 'active'));
        $inactiveUsers = $totalUsers - $activeUsers;
        $newThisMonth  = count(array_filter($allUsers, fn($u) =>
            date('Y-m', strtotime($u['created_at'])) === date('Y-m')
        ));
        $recentUsers = array_slice($allUsers, 0, 5);

        $this->admin('admin/dashboard', [
            'title'        => 'Dashboard',
            'totalUsers'   => $totalUsers,
            'activeUsers'  => $activeUsers,
            'inactiveUsers'=> $inactiveUsers,
            'newThisMonth' => $newThisMonth,
            'recentUsers'  => $recentUsers,
        ]);
    }

    public function profile()
    {
        if (!Auth::check()) {
            header('Location: ' . BASE_URL . '/login');
            exit;
        }
        $user = Session::get('user');
        $this->admin('admin/profile', ['title' => 'Profile', 'user' => $user]);
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
