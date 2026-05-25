<?php

class UserController extends Controller
{
    public function index(): void
    {
        require_once 'app/models/User.php';
        $this->admin('admin/users', [
            'title' => 'Users',
            'users' => (new User())->getAll(),
        ]);
    }

    public function ajaxCreate(): void
    {
        require_once 'app/models/User.php';

        $name     = trim($_POST['name']     ?? '');
        $email    = trim($_POST['email']    ?? '');
        $password = trim($_POST['password'] ?? '');
        $role     = trim($_POST['role']     ?? 'user');
        $status   = trim($_POST['status']   ?? 'active');

        if (!$name || !$email || !$password) {
            Router::json(['success' => false, 'message' => 'Name, email and password are required.']);
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            Router::json(['success' => false, 'message' => 'Invalid email address.']);
        }
        if (strlen($password) < 6) {
            Router::json(['success' => false, 'message' => 'Password must be at least 6 characters.']);
        }

        $id = (new User())->adminCreate($name, $email, $password, $role, $status);
        if ($id === false) {
            Router::json(['success' => false, 'message' => 'Email is already registered.']);
        }

        Router::json(['success' => true, 'message' => 'User created.', 'id' => $id]);
    }

    public function ajaxUpdate(): void
    {
        require_once 'app/models/User.php';

        $id     = (int) ($_POST['id']     ?? 0);
        $name   = trim($_POST['name']     ?? '');
        $email  = trim($_POST['email']    ?? '');
        $role   = trim($_POST['role']     ?? 'user');
        $status = trim($_POST['status']   ?? 'active');

        if (!$id || !$name || !$email) {
            Router::json(['success' => false, 'message' => 'All fields are required.']);
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            Router::json(['success' => false, 'message' => 'Invalid email address.']);
        }

        $ok = (new User())->update($id, $name, $email, $role, $status);
        if (!$ok) {
            Router::json(['success' => false, 'message' => 'Email is already taken.']);
        }

        Router::json(['success' => true, 'message' => 'User updated.']);
    }

    public function ajaxDelete(): void
    {
        require_once 'app/models/User.php';

        $id = (int) ($_POST['id'] ?? 0);
        if (!$id) {
            Router::json(['success' => false, 'message' => 'Invalid user.']);
        }

        (new User())->delete($id);
        Router::json(['success' => true, 'message' => 'User deleted.']);
    }
}
