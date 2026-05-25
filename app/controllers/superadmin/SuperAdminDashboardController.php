<?php

class SuperAdminDashboardController extends Controller
{
    public function index()
    {
        require_once 'app/models/User.php';
        require_once 'app/models/Admin.php';
        $userModel   = new User();
        $adminModel  = new Admin();
        $allUsers    = $userModel->getAll();
        $allAdmins   = $adminModel->getAll();
        $totalUsers  = count($allUsers);
        $activeUsers = count(array_filter($allUsers, fn($u) => $u['status'] === 'active'));
        $newThisMonth = count(array_filter($allUsers, fn($u) =>
            date('Y-m', strtotime($u['created_at'])) === date('Y-m')
        ));
        $recentUsers = array_slice($allUsers, 0, 5);

        $this->superadmin('superadmin/dashboard', [
            'title'        => 'Super Admin Dashboard',
            'totalUsers'   => $totalUsers,
            'activeUsers'  => $activeUsers,
            'inactiveUsers'=> $totalUsers - $activeUsers,
            'newThisMonth' => $newThisMonth,
            'recentUsers'  => $recentUsers,
            'totalAdmins'  => count($allAdmins),
        ]);
    }

    public function admins()
    {
        require_once 'app/models/Admin.php';
        $this->superadmin('superadmin/admins', [
            'title'  => 'Admins',
            'admins' => (new Admin())->getAll(),
        ]);
    }

    public function profile()
    {
        $this->superadmin('superadmin/profile', [
            'title' => 'Profile',
            'user'  => Session::get('user'),
        ]);
    }

    public function settings()
    {
        $this->superadmin('superadmin/settings', ['title' => 'Settings']);
    }
}
