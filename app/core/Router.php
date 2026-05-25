<?php

require_once __DIR__ . '/Route.php';

class Router
{
    private static array $routes = [];

    private static array $middlewareMap = [
        'auth'       => 'AuthMiddleware',
        'guest'      => 'GuestMiddleware',
        'admin'      => 'AdminMiddleware',
        'superadmin' => 'SuperAdminMiddleware',
    ];

    // ── Registration ─────────────────────────────────────────

    public static function get(string $uri, array|callable $action): Route
    {
        self::$routes['GET'][$uri] = [
            'action'     => $action,
            'middleware' => [],
        ];
        return new Route('GET', $uri);
    }

    public static function post(string $uri, array|callable $action): Route
    {
        self::$routes['POST'][$uri] = [
            'action'     => $action,
            'middleware' => [],
        ];
        return new Route('POST', $uri);
    }

    public static function hasRoute(string $method, string $uri): bool
    {
        return isset(self::$routes[strtoupper($method)][$uri]);
    }

    public static function any(string $uri, array|callable $action): Route
    {
        self::$routes['GET'][$uri]  = [
            'action'     => $action,
            'middleware' => [],
        ];
        self::$routes['POST'][$uri] = [
            'action'     => $action,
            'middleware' => [],
        ];
        return new Route(['GET', 'POST'], $uri);
    }

    public static function addMiddlewareToRoute(array|string $methods, string $uri, array|string $middleware): void
    {
        $methods = (array) $methods;
        $middlewares = (array) $middleware;

        foreach ($methods as $method) {
            $method = strtoupper($method);
            if (isset(self::$routes[$method][$uri])) {
                self::$routes[$method][$uri]['middleware'] = array_merge(
                    self::$routes[$method][$uri]['middleware'],
                    $middlewares
                );
            }
        }
    }

    // ── Dispatch ─────────────────────────────────────────────

    public static function dispatch(): void
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri    = self::parseUri();

        $map = self::$routes[$method] ?? [];

        if (array_key_exists($uri, $map)) {
            $routeData  = $map[$uri];
            $action     = is_array($routeData) && isset($routeData['action']) ? $routeData['action'] : $routeData;
            $middleware = is_array($routeData) && isset($routeData['middleware']) ? $routeData['middleware'] : [];

            self::runMiddleware($middleware, function() use ($action) {
                self::callAction($action);
            });
            return;
        }

        // POST fallback → try GET (e.g. browser typing /api/login directly)
        if ($method === 'POST') {
            $fallback = self::$routes['GET'][$uri] ?? null;
            if ($fallback) {
                $action     = is_array($fallback) && isset($fallback['action']) ? $fallback['action'] : $fallback;
                $middleware = is_array($fallback) && isset($fallback['middleware']) ? $fallback['middleware'] : [];

                self::runMiddleware($middleware, function() use ($action) {
                    self::callAction($action);
                });
                return;
            }
        }

        self::call('ErrorController', 'notFound');
    }

    private static function runMiddleware(array $middlewares, callable $destination): void
    {
        $pipeline = array_reduce(
            array_reverse($middlewares),
            function ($next, $middlewareName) {
                return function () use ($next, $middlewareName) {
                    $className = self::$middlewareMap[$middlewareName] ?? null;
                    if (!$className) {
                        $next();
                        return;
                    }

                    $file = "app/middlewares/{$className}.php";
                    if (file_exists($file)) {
                        require_once $file;
                    }

                    if (class_exists($className)) {
                        $middlewareInstance = new $className();
                        $middlewareInstance->handle($next);
                    } else {
                        $next();
                    }
                };
            },
            $destination
        );

        $pipeline();
    }

    // ── URI Parser ───────────────────────────────────────────

    public static function parseUri(): string
    {
        $uri = $_SERVER['REQUEST_URI'] ?? '/';

        // Extract only the PATH portion of BASE_URL (strips protocol + host + port)
        // e.g. "http://localhost/starterkit" → "/starterkit"
        $basePath = rtrim(parse_url(BASE_URL, PHP_URL_PATH) ?? '', '/');
        if ($basePath !== '' && str_starts_with($uri, $basePath)) {
            $uri = substr($uri, strlen($basePath));
        }

        // Strip query string (?foo=bar)
        if (str_contains($uri, '?')) {
            $uri = strstr($uri, '?', true);
        }

        $uri = trim($uri, '/');

        // Root URL returns '' so Router::get('', fn) matches correctly
        return $uri;
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
        // Use the actual current host+port so redirects work on both Apache and php kit serve
        $scheme   = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
        $host     = $_SERVER['HTTP_HOST'];                              // e.g. localhost:8000
        $basePath = rtrim(parse_url(BASE_URL, PHP_URL_PATH) ?? '', '/'); // e.g. /starterkit
        header('Location: ' . $scheme . '://' . $host . $basePath . '/' . ltrim($path, '/'));
        exit;
    }

    // ── Internal ─────────────────────────────────────────────

    private static function callAction(array|callable $action): void
    {
        if (is_callable($action)) {
            $action();
            return;
        }
        [$controller, $method] = $action;
        self::call($controller, $method);
    }

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
