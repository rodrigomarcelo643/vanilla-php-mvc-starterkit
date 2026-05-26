<?php

class Controller
{
    // Client Views
    public function client($view, $data = [])
    {
        extract($data);
        include 'app/views/layouts/client/header.php';
        include "app/views/$view.php";
        include 'app/views/layouts/client/footer.php';
    }
    // Admin Views
    public function admin($view, $data = [])
    {
        extract($data);
        include 'app/views/layouts/admin/header.php';
        include "app/views/$view.php";
        include 'app/views/layouts/admin/footer.php';
    }
    // User Views
    public function app($view, $data = [])
    {
        extract($data);
        include 'app/views/layouts/app/header.php';
        include "app/views/$view.php";
        include 'app/views/layouts/app/footer.php';
    }
    // Auth Views
    public function auth($view, $data = [])
    {
        extract($data);
        include 'app/views/layouts/auth/header.php';
        include "app/views/$view.php";
        include 'app/views/layouts/auth/footer.php';
    }

    public function superadmin($view, $data = [])
    {
        extract($data);
        include 'app/views/layouts/superadmin/header.php';
        include "app/views/$view.php";
        include 'app/views/layouts/superadmin/footer.php';
    }

    /**
     * Verify the CSRF token sent as an X-CSRF-Token request header.
     * Ajax.js injects this automatically on every POST from the meta tag.
     * Aborts with 403 if the token is missing or does not match the session.
     */
    protected function verifyCsrf(): void
    {
        $headerToken  = $_SERVER['HTTP_X_CSRF_TOKEN'] ?? '';
        $sessionToken = $_SESSION['csrf_token']       ?? '';

        if (!$headerToken || !$sessionToken || !hash_equals($sessionToken, $headerToken)) {
            http_response_code(403);
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Invalid or missing CSRF token.']);
            exit;
        }
    }
}