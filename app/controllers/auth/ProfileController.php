<?php

class ProfileController extends Controller
{
    public function index(): void
    {
        $user = $this->freshUser();
        $role = $user['role'] ?? 'user';
        $data = ['title' => 'Profile', 'user' => $user];

        if ($role === 'superadmin') {
            $this->superadmin('superadmin/profile', $data);
        } elseif ($role === 'admin' || $role === 'editor') {
            $this->admin('admin/profile', $data);
        } else {
            $this->client('client/profile', $data);
        }
    }

    public function ajaxUploadAvatar(): void
    {
        $file = $_FILES['avatar'] ?? null;

        if (!$file || $file['error'] !== UPLOAD_ERR_OK) {
            Router::json(['success' => false, 'message' => 'No file uploaded.']);
        }

        // ── Validate ──────────────────────────────────────────
        $allowed   = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        $maxBytes  = 2 * 1024 * 1024; // 2 MB
        $finfo     = new finfo(FILEINFO_MIME_TYPE);
        $mimeType  = $finfo->file($file['tmp_name']);

        if (!in_array($mimeType, $allowed)) {
            Router::json(['success' => false, 'message' => 'Only JPG, PNG, GIF and WEBP images are allowed.']);
        }

        if ($file['size'] > $maxBytes) {
            Router::json(['success' => false, 'message' => 'Image must be under 2 MB.']);
        }

        // ── Store ─────────────────────────────────────────────
        $ext      = match ($mimeType) {
            'image/jpeg' => 'jpg',
            'image/png'  => 'png',
            'image/gif'  => 'gif',
            'image/webp' => 'webp',
        };

        $session    = Session::get('user');
        $uploadDir  = __DIR__ . '/../../../storage/uploads/avatars/';
        $filename   = 'avatar_' . $session['id'] . '_' . time() . '.' . $ext;
        $destPath   = $uploadDir . $filename;
        $avatarUrl  = BASE_URL . '/storage/uploads/avatars/' . $filename;

        // Delete old avatar file if it exists
        $this->deleteOldAvatar($session['avatar'] ?? null);

        if (!move_uploaded_file($file['tmp_name'], $destPath)) {
            Router::json(['success' => false, 'message' => 'Failed to save image. Check storage permissions.']);
        }

        // ── Update DB ─────────────────────────────────────────
        $role = $session['role'] ?? 'user';

        if ($role === 'superadmin') {
            require_once 'app/models/SuperAdmin.php';
            (new SuperAdmin())->updateAvatar((int) $session['id'], $avatarUrl);
        } elseif ($role === 'admin') {
            require_once 'app/models/Admin.php';
            (new Admin())->updateAvatar((int) $session['id'], $avatarUrl);
        } else {
            require_once 'app/models/User.php';
            (new User())->updateAvatar((int) $session['id'], $avatarUrl);
        }

        // ── Update session ────────────────────────────────────
        $session['avatar'] = $avatarUrl;
        Session::set('user', $session);

        Router::json(['success' => true, 'avatar' => $avatarUrl]);
    }

    public function ajaxUpdateProfile(): void
    {
        $session = Session::get('user');
        $name    = trim($_POST['name']  ?? '');
        $email   = trim($_POST['email'] ?? '');

        if (!$name || !$email) {
            Router::json(['success' => false, 'message' => 'Name and email are required.']);
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            Router::json(['success' => false, 'message' => 'Invalid email address.']);
        }

        $id    = (int) $session['id'];
        $role  = $session['role'] ?? 'user';
        $model = $this->resolveModel($role);

        if (!$model->updateProfile($id, $name, $email)) {
            Router::json(['success' => false, 'message' => 'Email is already taken by another account.']);
        }

        $session['name']  = $name;
        $session['email'] = $email;
        Session::set('user', $session);

        Router::json(['success' => true, 'message' => 'Profile updated successfully.', 'name' => $name, 'email' => $email]);
    }

    public function ajaxChangePassword(): void
    {
        $session  = Session::get('user');
        $current  = trim($_POST['current_password']  ?? '');
        $password = trim($_POST['new_password']      ?? '');
        $confirm  = trim($_POST['confirm_password']  ?? '');

        if (!$current || !$password || !$confirm) {
            Router::json(['success' => false, 'message' => 'All fields are required.']);
        }

        if (strlen($password) < 8) {
            Router::json(['success' => false, 'message' => 'New password must be at least 8 characters.']);
        }

        if ($password !== $confirm) {
            Router::json(['success' => false, 'message' => 'New passwords do not match.']);
        }

        $id    = (int) $session['id'];
        $role  = $session['role'] ?? 'user';
        $model = $this->resolveModel($role);

        if (!$model->verifyPassword($id, $current)) {
            Router::json(['success' => false, 'message' => 'Current password is incorrect.']);
        }

        $model->updatePassword($id, $password);

        Router::json(['success' => true, 'message' => 'Password changed successfully.']);
    }

    // ── Helpers ───────────────────────────────────────────────

    private function resolveModel(string $role): User|Admin|SuperAdmin
    {
        if ($role === 'superadmin') {
            require_once 'app/models/SuperAdmin.php';
            return new SuperAdmin();
        }
        if ($role === 'admin') {
            require_once 'app/models/Admin.php';
            return new Admin();
        }
        require_once 'app/models/User.php';
        return new User();
    }

    private function freshUser(): array
    {
        $session = Session::get('user');
        $role    = $session['role'] ?? 'user';
        $model   = $this->resolveModel($role);
        $record  = $model->findByEmail($session['email'] ?? '');

        if ($record) {
            $session['name']   = $record['name'];
            $session['email']  = $record['email'];
            $session['avatar'] = $record['avatar']  ?? null;
            $session['status'] = $record['status']  ?? 'active';
            $session['role']   = $record['role']    ?? $role;
            Session::set('user', $session);
        }

        return $session;
    }

    private function deleteOldAvatar(?string $avatarUrl): void
    {
        if (!$avatarUrl) return;

        $base = rtrim(BASE_URL, '/');
        $path = __DIR__ . '/../../../' . ltrim(str_replace($base, '', $avatarUrl), '/');
        $real = realpath($path);
        $dir  = realpath(__DIR__ . '/../../../storage/uploads/avatars/');

        // Only delete if the file is inside the avatars directory
        if ($real && $dir && str_starts_with($real, $dir) && is_file($real)) {
            unlink($real);
        }
    }
}
