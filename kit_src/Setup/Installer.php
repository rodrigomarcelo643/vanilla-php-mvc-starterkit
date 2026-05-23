<?php

namespace Setup;

class Installer
{
    public static function install($event = null)
    {
        $choice = '1';

        // 1. Get input using Composer IO if available, otherwise direct console fallback
        if ($event && method_exists($event, 'getIO')) {
            $io = $event->getIO();
            $io->write("<info>====================================================</info>");
            $io->write("<info>       Welcome to Vanilla PHP MVC Starter Kit       </info>");
            $io->write("<info>====================================================</info>");
            $io->write("");
            
            $prompt = "Which preset would you like to install?\n" .
                      "  [1] Full Stack (Alpine.js + AJAX Monolith) - Default\n" .
                      "  [2] REST API (Full Stack with JS)\n" .
                      "  [3] Backend Only (REST API, No UI)\n\n" .
                      "Select an option [1]: ";
            
            $choice = $io->ask($prompt, '1');
        } else {
            // Fallback for direct execution
            $isWin = strtoupper(substr(PHP_OS, 0, 3)) === 'WIN';
            
            $menu  = "\n\033[1;36m====================================================\033[0m\n";
            $menu .= "\033[1;36m       Welcome to Vanilla PHP MVC Starter Kit       \033[0m\n";
            $menu .= "\033[1;36m====================================================\033[0m\n\n";
            $menu .= "Which preset would you like to install?\n";
            $menu .= "  [1] Full Stack (Alpine.js + AJAX Monolith) - Default\n";
            $menu .= "  [2] REST API (Full Stack with JS)\n";
            $menu .= "  [3] Backend Only (REST API, No UI)\n";
            $menu .= "\nSelect an option [1]: ";

            $conIn = null;
            $conOut = null;

            if ($isWin) {
                // Try to open CON device
                $conIn = @fopen('CON', 'r');
                if (!$conIn) {
                    $conIn = @fopen('CONIN$', 'r');
                }
                $conOut = @fopen('CON', 'w');
                if (!$conOut) {
                    $conOut = @fopen('CONOUT$', 'w');
                }
            } else {
                $tty = @fopen('/dev/tty', 'r+');
                $conIn = $tty;
                $conOut = $tty;
            }

            if ($conOut) {
                fwrite($conOut, $menu);
                if ($isWin) fclose($conOut);
            } else {
                echo $menu;
                if (ob_get_level()) ob_flush();
                flush();
            }

            if ($conIn) {
                $line = fgets($conIn);
                fclose($conIn);
                if ($line !== false) {
                    $digit = preg_replace('/[^1-9]/', '', $line);
                    if ($digit !== '') {
                        $choice = $digit;
                    }
                }
            } else {
                if (defined('STDIN') && STDIN !== false) {
                    stream_set_blocking(STDIN, true);
                    $line = fgets(STDIN);
                    if ($line !== false) {
                        $digit = preg_replace('/[^1-9]/', '', $line);
                        if ($digit !== '') $choice = $digit;
                    }
                }
            }
        }

        // 2. Sanitize and apply choice
        $choice = preg_replace('/[^1-9]/', '', $choice);
        if (!in_array($choice, ['1', '2', '3'])) {
            $choice = '1';
        }

        $basePath = dirname(__DIR__, 2) . '/';

        if ($choice === '3') {
            self::log("Configuring as Backend Only (REST API)...", $event);
            
            // 1. Delete only physical frontend directories
            self::deleteDir($basePath . 'app/views');
            self::deleteDir($basePath . 'assets');
            self::deleteDir($basePath . 'js');
            
            // 2. Delete the ENTIRE routes/web/ subfolder — no views exist so ALL page routes are dead weight
            self::deleteDir($basePath . 'routes/web');

            // 3. Overwrite routes/web.php — PURE API bootstrap, no page routes at all
            $webRouteContent = "<?php\n\n" .
                "// ── Bootstrap ─────────────────────────────────────────────────\n" .
                "require_once 'app/config/app.php';\n" .
                "require_once 'app/config/database.php';\n" .
                "require_once 'app/config/mail.php';\n" .
                "require_once 'app/config/oauth.php';\n" .
                "require_once 'app/helpers/helper.php';\n" .
                "require_once 'app/core/Database.php';\n" .
                "require_once 'app/core/Model.php';\n" .
                "require_once 'app/core/Session.php';\n" .
                "require_once 'app/core/Auth.php';\n" .
                "require_once 'app/core/Controller.php';\n" .
                "require_once 'app/core/Mailer.php';\n\n" .
                "// ── REST API Routes ───────────────────────────────────────────\n" .
                "require_once 'routes/api.php';\n\n" .
                "// ── Dispatch ──────────────────────────────────────────────────\n" .
                "Router::dispatch();\n";
            file_put_contents($basePath . 'routes/web.php', $webRouteContent);

            // 4. Overwrite app/core/Controller.php — smart API detector, authorization constructor, and view json interceptor
            $apiControllerContent = "<?php\n\n" .
                "class Controller\n" .
                "{\n" .
                "    private function isApiRequest(): bool\n" .
                "    {\n" .
                "        \$uri = \$_SERVER['REQUEST_URI'] ?? '';\n" .
                "        \$basePath = rtrim(parse_url(BASE_URL, PHP_URL_PATH) ?? '', '/');\n" .
                "        if (\$basePath !== '' && str_starts_with(\$uri, \$basePath)) {\n" .
                "            \$uri = substr(\$uri, strlen(\$basePath));\n" .
                "        }\n" .
                "        \$uri = trim(\$uri, '/');\n" .
                "        return str_starts_with(\$uri, 'api/') || str_starts_with(\$uri, 'api');\n" .
                "    }\n\n" .
                "    public function __construct()\n" .
                "    {\n" .
                "        if (\$this->isApiRequest()) {\n" .
                "            \$uri = \$_SERVER['REQUEST_URI'] ?? '';\n" .
                "            \$basePath = rtrim(parse_url(BASE_URL, PHP_URL_PATH) ?? '', '/');\n" .
                "            if (\$basePath !== '' && str_starts_with(\$uri, \$basePath)) {\n" .
                "                \$uri = substr(\$uri, strlen(\$basePath));\n" .
                "            }\n" .
                "            \$uri = trim(\$uri, '/');\n\n" .
                "            // Automatically check authentication for protected API groups\n" .
                "            if (str_starts_with(\$uri, 'api/admin/') || str_starts_with(\$uri, 'api/admin')) {\n" .
                "                \$role = Session::get('user')['role'] ?? '';\n" .
                "                if (!Auth::check() || !in_array(\$role, ['admin', 'superadmin'])) {\n" .
                "                    Router::json(['status' => 'error', 'message' => 'Unauthorized or Unauthenticated. (Admin access required)', 'code' => 401], 401);\n" .
                "                }\n" .
                "            }\n" .
                "            if (str_starts_with(\$uri, 'api/superadmin/') || str_starts_with(\$uri, 'api/superadmin')) {\n" .
                "                \$role = Session::get('user')['role'] ?? '';\n" .
                "                if (!Auth::check() || \$role !== 'superadmin') {\n" .
                "                    Router::json(['status' => 'error', 'message' => 'Unauthorized or Unauthenticated. (Superadmin access required)', 'code' => 401], 401);\n" .
                "                }\n" .
                "            }\n" .
                "            if (str_starts_with(\$uri, 'api/profile') || str_starts_with(\$uri, 'api/app/')) {\n" .
                "                if (!Auth::check()) {\n" .
                "                    Router::json(['status' => 'error', 'message' => 'Unauthenticated. Please login.', 'code' => 401], 401);\n" .
                "                }\n" .
                "            }\n" .
                "        }\n" .
                "    }\n\n" .
                "    // Client Views\n" .
                "    public function client(\$view, \$data = [])\n" .
                "    {\n" .
                "        if (\$this->isApiRequest()) {\n" .
                "            Router::json(['status' => 'success', 'view' => \$view, 'data' => \$data]);\n" .
                "        }\n" .
                "        extract(\$data);\n" .
                "        include 'app/views/layouts/client/header.php';\n" .
                "        include \"app/views/\$view.php\";\n" .
                "        include 'app/views/layouts/client/footer.php';\n" .
                "    }\n\n" .
                "    // Admin Views\n" .
                "    public function admin(\$view, \$data = [])\n" .
                "    {\n" .
                "        if (\$this->isApiRequest()) {\n" .
                "            Router::json(['status' => 'success', 'view' => \$view, 'data' => \$data]);\n" .
                "        }\n" .
                "        extract(\$data);\n" .
                "        include 'app/views/layouts/admin/header.php';\n" .
                "        include \"app/views/\$view.php\";\n" .
                "        include 'app/views/layouts/admin/footer.php';\n" .
                "    }\n\n" .
                "    // User Views\n" .
                "    public function app(\$view, \$data = [])\n" .
                "    {\n" .
                "        if (\$this->isApiRequest()) {\n" .
                "            Router::json(['status' => 'success', 'view' => \$view, 'data' => \$data]);\n" .
                "        }\n" .
                "        extract(\$data);\n" .
                "        include 'app/views/layouts/app/header.php';\n" .
                "        include \"app/views/\$view.php\";\n" .
                "        include 'app/views/layouts/app/footer.php';\n" .
                "    }\n\n" .
                "    // Auth Views\n" .
                "    public function auth(\$view, \$data = [])\n" .
                "    {\n" .
                "        if (\$this->isApiRequest()) {\n" .
                "            Router::json(['status' => 'success', 'view' => \$view, 'data' => \$data]);\n" .
                "        }\n" .
                "        extract(\$data);\n" .
                "        include 'app/views/layouts/auth/header.php';\n" .
                "        include \"app/views/\$view.php\";\n" .
                "        include 'app/views/layouts/auth/footer.php';\n" .
                "    }\n\n" .
                "    public function superadmin(\$view, \$data = [])\n" .
                "    {\n" .
                "        if (\$this->isApiRequest()) {\n" .
                "            Router::json(['status' => 'success', 'view' => \$view, 'data' => \$data]);\n" .
                "        }\n" .
                "        extract(\$data);\n" .
                "        include 'app/views/layouts/superadmin/header.php';\n" .
                "        include \"app/views/\$view.php\";\n" .
                "        include 'app/views/layouts/superadmin/footer.php';\n" .
                "    }\n" .
                "}\n";
            file_put_contents($basePath . 'app/core/Controller.php', $apiControllerContent);


            // 5. Overwrite app/controllers/ErrorController.php to output JSON 404
            $errorControllerContent = "<?php\n\n" .
                "class ErrorController extends Controller\n" .
                "{\n" .
                "    public function notFound()\n" .
                "    {\n" .
                "        Router::json([\n" .
                "            'status' => 'error',\n" .
                "            'message' => 'Resource not found',\n" .
                "            'code' => 404\n" .
                "        ], 404);\n" .
                "    }\n" .
                "}\n";
            file_put_contents($basePath . 'app/controllers/ErrorController.php', $errorControllerContent);

            self::log("✔ Frontend UI removed. Backend MVC REST API configured successfully. Old AJAX routes removed.", $event);
        } elseif ($choice === '2') {
            self::log("Configuring as Full Stack REST API with JS...", $event);
            
            // 1. Delete the old AJAX route files
            @unlink($basePath . 'routes/web/auth/ajax.php');
            @unlink($basePath . 'routes/web/admin/ajax.php');
            @unlink($basePath . 'routes/web/superadmin/ajax.php');
            @unlink($basePath . 'routes/web/app/ajax.php');
            
            // 2. Overwrite routes/web.php to exclude AJAX files
            $webRouteContent = "<?php\n\n" .
                "// ── Bootstrap ─────────────────────────────────────────────────\n" .
                "require_once 'app/config/app.php';\n" .
                "require_once 'app/config/database.php';\n" .
                "require_once 'app/config/mail.php';\n" .
                "require_once 'app/config/oauth.php';\n" .
                "require_once 'app/helpers/helper.php';\n" .
                "require_once 'app/core/Database.php';\n" .
                "require_once 'app/core/Model.php';\n" .
                "require_once 'app/core/Session.php';\n" .
                "require_once 'app/core/Auth.php';\n" .
                "require_once 'app/core/Controller.php';\n" .
                "require_once 'app/core/Mailer.php';\n\n" .
                "// ── Route Files ───────────────────────────────────────────────\n\n" .
                "// Auth\n" .
                "if (file_exists('routes/web/auth/pages.php')) {\n" .
                "    require_once 'routes/web/auth/pages.php';\n" .
                "}\n" .
                "if (file_exists('routes/web/auth/oauth.php')) {\n" .
                "    require_once 'routes/web/auth/oauth.php';\n" .
                "}\n\n" .
                "// Client / Public\n" .
                "if (file_exists('routes/web/client/pages.php')) {\n" .
                "    require_once 'routes/web/client/pages.php';\n" .
                "}\n\n" .
                "// Super Admin\n" .
                "if (file_exists('routes/web/superadmin/pages.php')) {\n" .
                "    require_once 'routes/web/superadmin/pages.php';\n" .
                "}\n\n" .
                "// Admin\n" .
                "if (file_exists('routes/web/admin/pages.php')) {\n" .
                "    require_once 'routes/web/admin/pages.php';\n" .
                "}\n\n" .
                "// App / Authenticated User\n" .
                "if (file_exists('routes/web/app/pages.php')) {\n" .
                "    require_once 'routes/web/app/pages.php';\n" .
                "}\n\n" .
                "// ── API Routes ────────────────────────────────────────────────\n" .
                "if (file_exists('routes/api.php')) {\n" .
                "    require_once 'routes/api.php';\n" .
                "}\n\n" .
                "// ── Dispatch ──────────────────────────────────────────────────\n" .
                "Router::dispatch();\n";
            file_put_contents($basePath . 'routes/web.php', $webRouteContent);
            
            // 3. Overwrite js/ajax.js to seamlessly map all /ajax/ frontend calls to /api/ REST endpoints
            $jsAjaxContent = "/**\n" .
                " * Ajax — lightweight fetch wrapper with REST API mapping\n" .
                " */\n" .
                "const Ajax = {\n" .
                "    _mapUrl(url) {\n" .
                "        return url.replace('/ajax/login', '/api/auth/login')\n" .
                "                  .replace('/ajax/register', '/api/auth/register')\n" .
                "                  .replace('/ajax/logout', '/api/auth/logout')\n" .
                "                  .replace('/ajax/forgot-password', '/api/auth/forgot-password')\n" .
                "                  .replace('/ajax/reset-password', '/api/auth/reset-password')\n" .
                "                  .replace('/ajax/users/create', '/api/admin/users')\n" .
                "                  .replace('/ajax/users/update', '/api/admin/users/update')\n" .
                "                  .replace('/ajax/users/delete', '/api/admin/users/delete')\n" .
                "                  .replace('/ajax/admins/create', '/api/superadmin/admins')\n" .
                "                  .replace('/ajax/admins/update', '/api/superadmin/admins/update')\n" .
                "                  .replace('/ajax/admins/delete', '/api/superadmin/admins/delete')\n" .
                "                  .replace('/ajax/avatar', '/api/profile/avatar')\n" .
                "                  .replace('/ajax/profile', '/api/profile/update')\n" .
                "                  .replace('/ajax/change-password', '/api/profile/change-password');\n" .
                "    },\n\n" .
                "    post(url, data) {\n" .
                "        url = this._mapUrl(url);\n" .
                "        const body = data instanceof FormData ? data : (() => {\n" .
                "            const fd = new FormData();\n" .
                "            Object.entries(data).forEach(([k, v]) => fd.append(k, v));\n" .
                "            return fd;\n" .
                "        })();\n\n" .
                "        return fetch(url, {\n" .
                "            method: 'POST',\n" .
                "            headers: { 'X-Requested-With': 'XMLHttpRequest' },\n" .
                "            body,\n" .
                "        }).then(res => res.json());\n" .
                "    },\n\n" .
                "    get(url) {\n" .
                "        url = this._mapUrl(url);\n" .
                "        return fetch(url, {\n" .
                "            headers: { 'X-Requested-With': 'XMLHttpRequest' },\n" .
                "        }).then(res => res.json());\n" .
                "    },\n" .
                "};\n";
            file_put_contents($basePath . 'js/ajax.js', $jsAjaxContent);

            // 4. Overwrite app/core/Controller.php — smart API detector, authorization constructor, and view json interceptor
            $apiControllerContent = "<?php\n\n" .
                "class Controller\n" .
                "{\n" .
                "    private function isApiRequest(): bool\n" .
                "    {\n" .
                "        \$uri = \$_SERVER['REQUEST_URI'] ?? '';\n" .
                "        \$basePath = rtrim(parse_url(BASE_URL, PHP_URL_PATH) ?? '', '/');\n" .
                "        if (\$basePath !== '' && str_starts_with(\$uri, \$basePath)) {\n" .
                "            \$uri = substr(\$uri, strlen(\$basePath));\n" .
                "        }\n" .
                "        \$uri = trim(\$uri, '/');\n" .
                "        return str_starts_with(\$uri, 'api/') || str_starts_with(\$uri, 'api');\n" .
                "    }\n\n" .
                "    public function __construct()\n" .
                "    {\n" .
                "        if (\$this->isApiRequest()) {\n" .
                "            \$uri = \$_SERVER['REQUEST_URI'] ?? '';\n" .
                "            \$basePath = rtrim(parse_url(BASE_URL, PHP_URL_PATH) ?? '', '/');\n" .
                "            if (\$basePath !== '' && str_starts_with(\$uri, \$basePath)) {\n" .
                "                \$uri = substr(\$uri, strlen(\$basePath));\n" .
                "            }\n" .
                "            \$uri = trim(\$uri, '/');\n\n" .
                "            // Automatically check authentication for protected API groups\n" .
                "            if (str_starts_with(\$uri, 'api/admin/') || str_starts_with(\$uri, 'api/admin')) {\n" .
                "                \$role = Session::get('user')['role'] ?? '';\n" .
                "                if (!Auth::check() || !in_array(\$role, ['admin', 'superadmin'])) {\n" .
                "                    Router::json(['status' => 'error', 'message' => 'Unauthorized or Unauthenticated. (Admin access required)', 'code' => 401], 401);\n" .
                "                }\n" .
                "            }\n" .
                "            if (str_starts_with(\$uri, 'api/superadmin/') || str_starts_with(\$uri, 'api/superadmin')) {\n" .
                "                \$role = Session::get('user')['role'] ?? '';\n" .
                "                if (!Auth::check() || \$role !== 'superadmin') {\n" .
                "                    Router::json(['status' => 'error', 'message' => 'Unauthorized or Unauthenticated. (Superadmin access required)', 'code' => 401], 401);\n" .
                "                }\n" .
                "            }\n" .
                "            if (str_starts_with(\$uri, 'api/profile') || str_starts_with(\$uri, 'api/app/')) {\n" .
                "                if (!Auth::check()) {\n" .
                "                    Router::json(['status' => 'error', 'message' => 'Unauthenticated. Please login.', 'code' => 401], 401);\n" .
                "                }\n" .
                "            }\n" .
                "        }\n" .
                "    }\n\n" .
                "    // Client Views\n" .
                "    public function client(\$view, \$data = [])\n" .
                "    {\n" .
                "        if (\$this->isApiRequest()) {\n" .
                "            Router::json(['status' => 'success', 'view' => \$view, 'data' => \$data]);\n" .
                "        }\n" .
                "        extract(\$data);\n" .
                "        include 'app/views/layouts/client/header.php';\n" .
                "        include \"app/views/\$view.php\";\n" .
                "        include 'app/views/layouts/client/footer.php';\n" .
                "    }\n\n" .
                "    // Admin Views\n" .
                "    public function admin(\$view, \$data = [])\n" .
                "    {\n" .
                "        if (\$this->isApiRequest()) {\n" .
                "            Router::json(['status' => 'success', 'view' => \$view, 'data' => \$data]);\n" .
                "        }\n" .
                "        extract(\$data);\n" .
                "        include 'app/views/layouts/admin/header.php';\n" .
                "        include \"app/views/\$view.php\";\n" .
                "        include 'app/views/layouts/admin/footer.php';\n" .
                "    }\n\n" .
                "    // User Views\n" .
                "    public function app(\$view, \$data = [])\n" .
                "    {\n" .
                "        if (\$this->isApiRequest()) {\n" .
                "            Router::json(['status' => 'success', 'view' => \$view, 'data' => \$data]);\n" .
                "        }\n" .
                "        extract(\$data);\n" .
                "        include 'app/views/layouts/app/header.php';\n" .
                "        include \"app/views/\$view.php\";\n" .
                "        include 'app/views/layouts/app/footer.php';\n" .
                "    }\n\n" .
                "    // Auth Views\n" .
                "    public function auth(\$view, \$data = [])\n" .
                "    {\n" .
                "        if (\$this->isApiRequest()) {\n" .
                "            Router::json(['status' => 'success', 'view' => \$view, 'data' => \$data]);\n" .
                "        }\n" .
                "        extract(\$data);\n" .
                "        include 'app/views/layouts/auth/header.php';\n" .
                "        include \"app/views/\$view.php\";\n" .
                "        include 'app/views/layouts/auth/footer.php';\n" .
                "    }\n\n" .
                "    public function superadmin(\$view, \$data = [])\n" .
                "    {\n" .
                "        if (\$this->isApiRequest()) {\n" .
                "            Router::json(['status' => 'success', 'view' => \$view, 'data' => \$data]);\n" .
                "        }\n" .
                "        extract(\$data);\n" .
                "        include 'app/views/layouts/superadmin/header.php';\n" .
                "        include \"app/views/\$view.php\";\n" .
                "        include 'app/views/layouts/superadmin/footer.php';\n" .
                "    }\n" .
                "}\n";
            file_put_contents($basePath . 'app/core/Controller.php', $apiControllerContent);

            self::log("✔ Full Stack REST API configured. Old AJAX routes removed. Frontend requests mapped to /api/* successfully.", $event);
        } else {
            self::log("✔ Configuring as Full Stack Monolith (Default)...", $event);
        }
    }

    private static function log($message, $event = null)
    {
        if ($event && method_exists($event, 'getIO')) {
            $event->getIO()->write("<info>{$message}</info>");
        } else {
            echo "\033[32m{$message}\033[0m\n";
        }
    }

    private static function deleteDir($dirPath)
    {
        if (!is_dir($dirPath)) return;
        $objects = scandir($dirPath);
        foreach ($objects as $object) {
            if ($object != "." && $object != "..") {
                if (is_dir($dirPath . DIRECTORY_SEPARATOR . $object) && !is_link($dirPath . "/" . $object)) {
                    self::deleteDir($dirPath . DIRECTORY_SEPARATOR . $object);
                } else {
                    unlink($dirPath . DIRECTORY_SEPARATOR . $object);
                }
            }
        }
        rmdir($dirPath);
    }
}

// Support running directly from CLI: php kit_src/Setup/Installer.php
if (php_sapi_name() === 'cli' && basename(__FILE__) === basename($_SERVER['SCRIPT_FILENAME'] ?? '')) {
    Installer::install();
}
