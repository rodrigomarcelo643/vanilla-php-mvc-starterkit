<?php

class SuperAdminAdminController extends Controller
{
    public function ajaxCreate(): void
    {
        require_once 'app/models/Admin.php';

        $name     = trim($_POST['name']     ?? '');
        $email    = trim($_POST['email']    ?? '');
        $password = trim($_POST['password'] ?? '');
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

        $id = (new Admin())->adminCreate($name, $email, $password, $status);
        if ($id === false) {
            Router::json(['success' => false, 'message' => 'Email is already registered.']);
        }

        Router::json(['success' => true, 'message' => 'Admin created.', 'id' => $id]);
    }

    public function ajaxUpdate(): void
    {
        require_once 'app/models/Admin.php';

        $id     = (int) ($_POST['id']     ?? 0);
        $name   = trim($_POST['name']     ?? '');
        $email  = trim($_POST['email']    ?? '');
        $status = trim($_POST['status']   ?? 'active');

        if (!$id || !$name || !$email) {
            Router::json(['success' => false, 'message' => 'All fields are required.']);
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            Router::json(['success' => false, 'message' => 'Invalid email address.']);
        }

        $ok = (new Admin())->update($id, $name, $email, $status);
        if (!$ok) {
            Router::json(['success' => false, 'message' => 'Email is already taken.']);
        }

        Router::json(['success' => true, 'message' => 'Admin updated.']);
    }

    public function ajaxDelete(): void
    {
        require_once 'app/models/Admin.php';

        $id = (int) ($_POST['id'] ?? 0);
        if (!$id) {
            Router::json(['success' => false, 'message' => 'Invalid admin.']);
        }

        (new Admin())->delete($id);
        Router::json(['success' => true, 'message' => 'Admin deleted.']);
    }
}
