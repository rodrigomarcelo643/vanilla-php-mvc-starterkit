<?php

class OAuthController extends Controller
{
    // ── Google ────────────────────────────────────────────────

    public function googleRedirect(): void
    {
        if (!GOOGLE_CLIENT_ID) {
            Session::flash('toast', ['message' => 'Google OAuth is not configured yet.', 'type' => 'error']);
            Router::redirect('login');
        }

        $state = bin2hex(random_bytes(16));
        Session::set('oauth_state', $state);

        $params = http_build_query([
            'client_id'     => GOOGLE_CLIENT_ID,
            'redirect_uri'  => GOOGLE_REDIRECT_URI,
            'response_type' => 'code',
            'scope'         => 'openid email profile',
            'state'         => $state,
            'prompt'        => 'select_account',
        ]);

        header('Location: https://accounts.google.com/o/oauth2/v2/auth?' . $params);
        exit;
    }

    public function googleCallback(): void
    {
        $this->verifyState();

        $code = $_GET['code'] ?? '';
        if (!$code) Router::redirect('login');

        $token = $this->httpPost('https://oauth2.googleapis.com/token', [
            'code'          => $code,
            'client_id'     => GOOGLE_CLIENT_ID,
            'client_secret' => GOOGLE_CLIENT_SECRET,
            'redirect_uri'  => GOOGLE_REDIRECT_URI,
            'grant_type'    => 'authorization_code',
        ]);

        if (empty($token['access_token'])) Router::redirect('login');

        $profile = $this->httpGet(
            'https://www.googleapis.com/oauth2/v3/userinfo',
            $token['access_token']
        );

        $this->handleOAuthUser([
            'provider'    => 'google',
            'provider_id' => $profile['sub']        ?? '',
            'name'        => $profile['name']        ?? '',
            'email'       => $profile['email']       ?? '',
            'avatar'      => $profile['picture']     ?? '',
        ]);
    }

    // ── GitHub ────────────────────────────────────────────────

    public function githubRedirect(): void
    {
        if (!GITHUB_CLIENT_ID) {
            Session::flash('toast', ['message' => 'GitHub OAuth is not configured yet.', 'type' => 'error']);
            Router::redirect('login');
        }

        $state = bin2hex(random_bytes(16));
        Session::set('oauth_state', $state);

        $params = http_build_query([
            'client_id'    => GITHUB_CLIENT_ID,
            'redirect_uri' => GITHUB_REDIRECT_URI,
            'scope'        => 'user:email',
            'state'        => $state,
        ]);

        header('Location: https://github.com/login/oauth/authorize?' . $params);
        exit;
    }

    public function githubCallback(): void
    {
        $this->verifyState();

        $code = $_GET['code'] ?? '';
        if (!$code) Router::redirect('login');

        $token = $this->httpPost('https://github.com/login/oauth/access_token', [
            'client_id'     => GITHUB_CLIENT_ID,
            'client_secret' => GITHUB_CLIENT_SECRET,
            'code'          => $code,
            'redirect_uri'  => GITHUB_REDIRECT_URI,
        ], ['Accept: application/json']);

        if (empty($token['access_token'])) Router::redirect('login');

        $profile = $this->httpGet('https://api.github.com/user', $token['access_token'], [
            'User-Agent: ' . APP_NAME,
        ]);

        // GitHub may not expose email publicly — fetch from /user/emails
        $email = $profile['email'] ?? '';
        if (!$email) {
            $emails = $this->httpGet('https://api.github.com/user/emails', $token['access_token'], [
                'User-Agent: ' . APP_NAME,
            ]);
            foreach ((array) $emails as $e) {
                if (!empty($e['primary']) && !empty($e['verified'])) {
                    $email = $e['email'];
                    break;
                }
            }
        }

        $this->handleOAuthUser([
            'provider'    => 'github',
            'provider_id' => (string) ($profile['id']         ?? ''),
            'name'        => $profile['name'] ?? $profile['login'] ?? '',
            'email'       => $email,
            'avatar'      => $profile['avatar_url'] ?? '',
        ]);
    }

    // ── Shared logic ──────────────────────────────────────────

    private function handleOAuthUser(array $data): void
    {
        require_once 'app/models/User.php';
        $userModel = new User();

        // Existing user → log in directly
        if ($data['email'] && $userModel->emailExists($data['email'])) {
            $user = $userModel->findByEmail($data['email']);
            Session::set('user', [
                'id'     => $user['id'],
                'name'   => $user['name'],
                'email'  => $user['email'],
                'role'   => $user['role'] ?? 'user',
                'avatar' => $user['avatar'] ?? $data['avatar'],
            ]);
            Session::flash('toast', ['message' => 'Welcome back, ' . $user['name'] . '!', 'type' => 'success']);
            Router::redirect('app/home');
        }

        // New user → store prefill in session, redirect to register
        Session::set('oauth_prefill', [
            'name'     => $data['name'],
            'email'    => $data['email'],
            'avatar'   => $data['avatar'],
            'provider' => $data['provider'],
        ]);
        Session::flash('toast', ['message' => 'Almost there! Complete your profile to finish signing up.', 'type' => 'info']);
        Router::redirect('register');
    }

    private function verifyState(): void
    {
        $state         = $_GET['state']    ?? '';
        $storedState   = Session::get('oauth_state') ?? '';
        Session::set('oauth_state', null);

        if (!$state || $state !== $storedState) {
            Router::redirect('login');
        }
    }

    // ── HTTP helpers ──────────────────────────────────────────

    private function httpPost(string $url, array $fields, array $headers = []): array
    {
        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST           => true,
            CURLOPT_POSTFIELDS     => http_build_query($fields),
            CURLOPT_HTTPHEADER     => array_merge(['Content-Type: application/x-www-form-urlencoded'], $headers),
            CURLOPT_TIMEOUT        => 10,
        ]);
        $res = curl_exec($ch);
        unset($ch);
        return json_decode($res, true) ?? [];
    }

    private function httpGet(string $url, string $token, array $extraHeaders = []): array
    {
        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER     => array_merge(["Authorization: Bearer $token"], $extraHeaders),
            CURLOPT_TIMEOUT        => 10,
        ]);
        $res = curl_exec($ch);
        unset($ch);
        return json_decode($res, true) ?? [];
    }
}
