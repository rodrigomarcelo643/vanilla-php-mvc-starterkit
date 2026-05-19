<?php

class Router
{
    private static array $routes = [];

    // ── Registration ─────────────────────────────────────────

    public static function get(string $uri, array $action): void
    {
        self::$routes['GET'][$uri] = $action;
    }

    public static function post(string $uri, array $action): void
    {
        self::$routes['POST'][$uri] = $action;
    }

    public static function any(string $uri, array $action): void
    {
        self::$routes['GET'][$uri]  = $action;
        self::$routes['POST'][$uri] = $action;
    }

    // ── Dispatch ─────────────────────────────────────────────

    public static function dispatch(): void
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri    = self::parseUri();

        $map = self::$routes[$method] ?? [];

        if (array_key_exists($uri, $map)) {
            [$controller, $action] = $map[$uri];
            self::call($controller, $action);
            return;
        }

        // POST fallback → try GET (e.g. browser typing /ajax/login directly)
        if ($method === 'POST') {
            $fallback = self::$routes['GET'][$uri] ?? null;
            if ($fallback) {
                [$controller, $action] = $fallback;
                self::call($controller, $action);
                return;
            }
        }

        self::call('ErrorController', 'notFound');
    }

    // ── URI Parser ───────────────────────────────────────────

    public static function parseUri(): string
    {
        // Use REQUEST_URI for clean URLs (/login, /dashboard, etc.)
        $uri = $_SERVER['REQUEST_URI'] ?? '/';

        // Strip base path if app lives in a subfolder
        $base = rtrim(BASE_URL, '/');
        if ($base !== '' && str_starts_with($uri, $base)) {
            $uri = substr($uri, strlen($base));
        }

        // Strip query string (?foo=bar)
        if (str_contains($uri, '?')) {
            $uri = strstr($uri, '?', true);
        }

        $uri = trim($uri, '/');

        return $uri === '' ? '/' : $uri;
    }

    // ── Helpers ──────────────────────────────────────────────

    public static function isAjax(): bool
    {
        return !empty($_SERVER['HTTP_X_REQUESTED_WITH'])
            && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
    }

    public static function json(array $data, int $status = 200): void
    {
        http_response_code($status);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data);
        exit;
    }

    public static function redirect(string $path): void
    {
        header('Location: ' . BASE_URL . '/' . ltrim($path, '/'));
        exit;
    }

    // ── Internal ─────────────────────────────────────────────

    private static function call(string $controller, string $action): void
    {
        $candidates = [
            "app/controllers/{$controller}.php",
            "app/controllers/admin/{$controller}.php",
            "app/controllers/superadmin/{$controller}.php",
            "app/controllers/client/{$controller}.php",
            "app/controllers/auth/{$controller}.php",
        ];

        foreach ($candidates as $file) {
            if (file_exists($file)) {
                require_once $file;
                (new $controller())->$action();
                return;
            }
        }

        require_once 'app/controllers/ErrorController.php';
        (new ErrorController())->notFound();
    }
}
