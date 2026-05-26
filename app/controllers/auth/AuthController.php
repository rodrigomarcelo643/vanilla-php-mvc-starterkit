<?php

class AuthController extends Controller
{
    public function login()
    {
        $this->auth('auth/login', ['title' => 'Sign in']);
    }

    public function register()
    {
        $this->auth('auth/register', ['title' => 'Create account']);
    }

    public function ajaxLogin()
    {
        $this->verifyCsrf();
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            Router::json(['success' => false, 'message' => 'Method not allowed'], 405);
        }

        $email    = trim($_POST['email']    ?? '');
        $password = trim($_POST['password'] ?? '');

        if (!$email || !$password) {
            Router::json(['success' => false, 'message' => 'All fields are required.']);
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            Router::json(['success' => false, 'message' => 'Invalid email address.']);
        }

        require_once 'app/models/User.php';
        require_once 'app/models/Admin.php';
        require_once 'app/models/SuperAdmin.php';

        // Check users, then admins, then super_admins
        $user = (new User())->findByEmail($email);
        if (!$user) {
            $user = (new Admin())->findByEmail($email);
        }
        if (!$user) {
            $user = (new SuperAdmin())->findByEmail($email);
        }

        if (!$user || !password_verify($password, $user['password'])) {
            Router::json(['success' => false, 'message' => 'Invalid email or password.']);
        }

        if (($user['status'] ?? 'active') === 'inactive') {
            Router::json(['success' => false, 'message' => 'Your account is inactive. Contact support.']);
        }

        Session::set('user', [
            'id'     => $user['id'],
            'name'   => $user['name'],
            'email'  => $user['email'],
            'role'   => $user['role'] ?? 'admin',
            'avatar' => $user['avatar'] ?? null,
        ]);

        $redirect = match($user['role']) {
            'admin'      => BASE_URL . '/admin/dashboard',
            'superadmin' => BASE_URL . '/superadmin/dashboard',
            default      => BASE_URL . '/app/home',
        };
        Router::json(['success' => true, 'redirect' => $redirect]);
    }

    public function ajaxRegister()
    {
        $this->verifyCsrf();
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            Router::json(['success' => false, 'message' => 'Method not allowed'], 405);
        }

        $name     = trim($_POST['name']     ?? '');
        $email    = trim($_POST['email']    ?? '');
        $password = trim($_POST['password'] ?? '');

        if (!$name || !$email || !$password) {
            Router::json(['success' => false, 'message' => 'All fields are required.']);
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            Router::json(['success' => false, 'message' => 'Invalid email address.']);
        }

        if (strlen($password) < 6) {
            Router::json(['success' => false, 'message' => 'Password must be at least 6 characters.']);
        }

        require_once 'app/models/User.php';
        $userModel = new User();

        if ($userModel->emailExists($email)) {
            Router::json(['success' => false, 'message' => 'Email is already registered.']);
        }

        $id = $userModel->create($name, $email, $password);

        Session::set('user', [
            'id'    => $id,
            'name'  => $name,
            'email' => $email,
            'role'  => 'user',
        ]);
        Session::set('oauth_prefill', null);

        Router::json(['success' => true, 'redirect' => BASE_URL . '/app/home']);
    }

    public function ajaxLogout()
    {
        $this->verifyCsrf();
        Session::destroy();
        Router::json(['success' => true, 'redirect' => BASE_URL . '/login']);
    }
}