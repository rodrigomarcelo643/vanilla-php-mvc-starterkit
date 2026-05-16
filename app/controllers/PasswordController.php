<?php

class PasswordController extends Controller
{
    public function forgotPassword(): void
    {
        if (Auth::check()) {
            Router::redirect('dashboard');
        }
        $this->auth('auth/forgot-password', ['title' => 'Forgot Password']);
    }

    public function resetPassword(): void
    {
        $token = $_GET['token'] ?? '';

        if (!$token) {
            Router::redirect('forgot-password');
        }

        require_once 'app/models/PasswordReset.php';
        $record = (new PasswordReset())->findByToken($token);

        if (!$record) {
            $this->auth('auth/forgot-password', [
                'title'        => 'Forgot Password',
                'expiredToken' => true,
            ]);
            return;
        }

        $this->auth('auth/reset-password', [
            'title' => 'Reset Password',
            'token' => $token,
        ]);
    }

    // ── AJAX ──────────────────────────────────────────────────

    public function ajaxForgotPassword(): void
    {
        $email = trim($_POST['email'] ?? '');

        if (!$email || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            Router::json(['success' => false, 'message' => 'Please enter a valid email address.']);
        }

        require_once 'app/models/User.php';
        require_once 'app/models/Admin.php';
        require_once 'app/models/PasswordReset.php';

        // Check users first, then admins
        $user = (new User())->findByEmail($email) ?: (new Admin())->findByEmail($email);

        // Always respond with success to prevent email enumeration
        if (!$user) {
            Router::json(['success' => true, 'message' => 'If that email exists, a reset link has been sent.']);
        }

        $token     = (new PasswordReset())->createToken($email);
        $resetLink = rtrim(BASE_URL, '/') . '/reset-password?token=' . $token;

        $sent = Mailer::make()
            ->to($email, $user['name'])
            ->subject('Reset your ' . APP_NAME . ' password')
            ->html($this->resetEmailTemplate($user['name'], $resetLink))
            ->send();

        if (!$sent) {
            Router::json(['success' => false, 'message' => 'Failed to send email. Please try again.']);
        }

        Router::json(['success' => true, 'message' => 'If that email exists, a reset link has been sent.']);
    }

    public function ajaxResetPassword(): void
    {
        $token    = trim($_POST['token']    ?? '');
        $password = trim($_POST['password'] ?? '');
        $confirm  = trim($_POST['confirm']  ?? '');

        if (!$token || !$password || !$confirm) {
            Router::json(['success' => false, 'message' => 'All fields are required.']);
        }

        if (strlen($password) < 8) {
            Router::json(['success' => false, 'message' => 'Password must be at least 8 characters.']);
        }

        if ($password !== $confirm) {
            Router::json(['success' => false, 'message' => 'Passwords do not match.']);
        }

        require_once 'app/models/PasswordReset.php';
        require_once 'app/models/User.php';
        require_once 'app/models/Admin.php';

        $resetModel = new PasswordReset();
        $record     = $resetModel->findByToken($token);

        if (!$record) {
            Router::json(['success' => false, 'message' => 'This reset link has expired or is invalid.']);
        }

        $email     = $record['email'];
        $userModel = new User();
        $user      = $userModel->findByEmail($email);

        if ($user) {
            $userModel->updatePassword((int) $user['id'], $password);
        } else {
            $adminModel = new Admin();
            $admin      = $adminModel->findByEmail($email);

            if (!$admin) {
                Router::json(['success' => false, 'message' => 'Account not found.']);
            }

            $adminModel->updatePassword((int) $admin['id'], $password);
        }

        $resetModel->deleteByToken($token);

        Router::json(['success' => true, 'redirect' => BASE_URL . '/login']);
    }

    // ── Email template ────────────────────────────────────────

    private function resetEmailTemplate(string $name, string $resetLink): string
    {
        $appName = APP_NAME;
        $year    = date('Y');

        return <<<HTML
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Reset your password</title>
        </head>
        <body style="margin:0;padding:0;background-color:#f4f4f5;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,sans-serif;">
            <table width="100%" cellpadding="0" cellspacing="0" style="background-color:#f4f4f5;padding:40px 16px;">
                <tr>
                    <td align="center">
                        <table width="100%" cellpadding="0" cellspacing="0" style="max-width:560px;">

                            <!-- Logo -->
                            <tr>
                                <td align="center" style="padding-bottom:24px;">
                                    <table cellpadding="0" cellspacing="0">
                                        <tr>
                                            <td style="background-color:#18181b;border-radius:10px;width:36px;height:36px;text-align:center;vertical-align:middle;">
                                                <span style="color:#ffffff;font-size:18px;font-weight:700;line-height:36px;">&#9889;</span>
                                            </td>
                                            <td style="padding-left:10px;">
                                                <span style="font-size:15px;font-weight:600;color:#18181b;">{$appName}</span>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>

                            <!-- Card -->
                            <tr>
                                <td style="background-color:#ffffff;border-radius:12px;border:1px solid #e4e4e7;padding:40px 40px 32px;">

                                    <!-- Heading -->
                                    <p style="margin:0 0 8px;font-size:22px;font-weight:600;color:#18181b;letter-spacing:-0.3px;">Reset your password</p>
                                    <p style="margin:0 0 28px;font-size:14px;color:#71717a;line-height:1.6;">
                                        Hi {$name}, we received a request to reset the password for your <strong style="color:#18181b;">{$appName}</strong> account.
                                    </p>

                                    <!-- Divider -->
                                    <hr style="border:none;border-top:1px solid #f4f4f5;margin:0 0 28px;">

                                    <!-- CTA -->
                                    <p style="margin:0 0 20px;font-size:14px;color:#3f3f46;">Click the button below to choose a new password. This link expires in <strong>1 hour</strong>.</p>

                                    <table cellpadding="0" cellspacing="0" style="margin-bottom:28px;">
                                        <tr>
                                            <td style="background-color:#18181b;border-radius:8px;">
                                                <a href="{$resetLink}"
                                                   style="display:inline-block;padding:12px 28px;font-size:14px;font-weight:600;color:#ffffff;text-decoration:none;letter-spacing:0.1px;">
                                                    Reset Password
                                                </a>
                                            </td>
                                        </tr>
                                    </table>

                                    <!-- Fallback link -->
                                    <p style="margin:0 0 6px;font-size:12px;color:#a1a1aa;">If the button doesn't work, copy and paste this link into your browser:</p>
                                    <p style="margin:0 0 28px;font-size:12px;word-break:break-all;">
                                        <a href="{$resetLink}" style="color:#4f46e5;text-decoration:underline;">{$resetLink}</a>
                                    </p>

                                    <!-- Divider -->
                                    <hr style="border:none;border-top:1px solid #f4f4f5;margin:0 0 20px;">

                                    <!-- Security note -->
                                    <p style="margin:0;font-size:12px;color:#a1a1aa;line-height:1.6;">
                                        If you didn't request a password reset, you can safely ignore this email. Your password will not be changed.
                                    </p>
                                </td>
                            </tr>

                            <!-- Footer -->
                            <tr>
                                <td align="center" style="padding-top:24px;">
                                    <p style="margin:0;font-size:12px;color:#a1a1aa;">&copy; {$year} {$appName}. All rights reserved.</p>
                                </td>
                            </tr>

                        </table>
                    </td>
                </tr>
            </table>
        </body>
        </html>
        HTML;
    }
}
