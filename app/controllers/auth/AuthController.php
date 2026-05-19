<?php

class AuthController extends Controller
{
    public function login()
    {
        if (Auth::check()) {
            $role = Session::get('user')['role'] ?? 'user';
            header('Location: ' . BASE_URL . ($role === 'admin' ? '/dashboard' : '/app/home'));
            exit;
        }
        $this->auth('auth/login', ['title' => 'Sign in']);
    }

    public function register()
    {
        if (Auth::check()) {
            $role = Session::get('user')['role'] ?? 'user';
            header('Location: ' . BASE_URL . ($role === 'admin' ? '/dashboard' : '/app/home'));
            exit;
        }
        $this->auth('auth/register', ['title' => 'Create account']);
    }

    public function ajaxLogin()
    {
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

        // Check users table first, then admins table
        $user = (new User())->findByEmail($email);
        if (!$user) {
            $user = (new Admin())->findByEmail($email);
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

        $redirect = BASE_URL . ($user['role'] === 'admin' ? '/admin/dashboard' : '/app/home');
        Router::json(['success' => true, 'redirect' => $redirect]);
    }

    public function ajaxRegister()
    {
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

        Router::json(['success' => true, 'redirect' => BASE_URL . '/app/home']);
    }

    public function ajaxLogout()
    {
        Session::destroy();
        Router::json(['success' => true, 'redirect' => BASE_URL . '/']);
    }
}