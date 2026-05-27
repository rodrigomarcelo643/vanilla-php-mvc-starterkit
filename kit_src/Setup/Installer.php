<?php

namespace Setup;

class Installer
{
    public static function install($event = null)
    {
        $choice = getenv('INSTALLER_PRESET') ?: '1';

        if (!getenv('INSTALLER_PRESET')) {
            // 1. Get input using Composer IO if available, otherwise direct console fallback
            if ($event && method_exists($event, 'getIO')) {
                $io = $event->getIO();
                $io->write('');
                $io->write('<fg=blue>  ┌────────────────────────────────────────────────┐</>');
                $io->write('<fg=blue>  │</>  <options=bold>Choose Your Installation Preset</>               <fg=blue>│</>');
                $io->write('<fg=blue>  └────────────────────────────────────────────────┘</>');
                $io->write('');
                $io->write('  <comment>[1]</comment> <options=bold>Full Stack</options=bold>      — Alpine.js + AJAX Monolith  <info>← default</info>');
                $io->write('  <comment>[2]</comment> <options=bold>REST API</options=bold>        — Full Stack with JS Frontend');
                $io->write('  <comment>[3]</comment> <options=bold>Backend Only</options=bold>    — REST API, No UI');
                $io->write('  <comment>[4]</comment> <options=bold>jQuery Stack</options=bold>    — Full Stack with jQuery AJAX');
                $io->write('');

                $choice = $io->ask('  <question>Select an option</question> [<comment>1</comment>]: ', '1');
            } else {
                // Fallback for direct execution
                $isWin = strtoupper(substr(PHP_OS, 0, 3)) === 'WIN';
                
                $menu  = "\n";
                $menu .= "\033[1;34m  ┌────────────────────────────────────────────────┐\033[0m\n";
                $menu .= "\033[1;34m  │\033[0m  \033[1;37mChoose Your Installation Preset\033[0m               \033[1;34m│\033[0m\n";
                $menu .= "\033[1;34m  └────────────────────────────────────────────────┘\033[0m\n";
                $menu .= "\n";
                $menu .= "  \033[1;33m[1]\033[0m \033[1mFull Stack\033[0m      — Alpine.js + AJAX Monolith  \033[1;32m← default\033[0m\n";
                $menu .= "  \033[1;33m[2]\033[0m \033[1mREST API\033[0m        — Full Stack with JS Frontend\n";
                $menu .= "  \033[1;33m[3]\033[0m \033[1mBackend Only\033[0m    — REST API, No UI\n";
                $menu .= "  \033[1;33m[4]\033[0m \033[1mjQuery Stack\033[0m    — Full Stack with jQuery AJAX\n";
                $menu .= "\n";
                $menu .= "  \033[1;36mSelect an option\033[0m [\033[1;33m1\033[0m]: ";

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
        }

        // 2. Sanitize and apply choice
        $choice = preg_replace('/[^1-9]/', '', $choice);
        if (!in_array($choice, ['1', '2', '3', '4'])) {
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
                "    }\n\n" .
                "    /**\n" .
                "     * CSRF is not applicable for pure REST API mode.\n" .
                "     * Auth is enforced via session guards in the constructor.\n" .
                "     */\n" .
                "    protected function verifyCsrf(): void\n" .
                "    {\n" .
                "        // No-op: REST API endpoints are protected by session auth guards, not CSRF tokens.\n" .
                "    }\n" .
                "}\n";
            file_put_contents($basePath . 'app/core/Controller.php', $apiControllerContent);

            // 4. Update controllers and routes/api.php to rename 'ajaxX' methods to 'apiX'
            $controllers = array_merge(glob($basePath . 'app/controllers/*.php') ?: [], glob($basePath . 'app/controllers/*/*.php') ?: []);
            foreach ($controllers as $ctrl) {
                if (file_exists($ctrl)) {
                    $content = file_get_contents($ctrl);
                    $content = preg_replace('/function (ajax|api|jquery)([A-Z])/', 'function api$2', $content);
                    file_put_contents($ctrl, $content);
                }
            }
            $apiRouteFile = $basePath . 'routes/api.php';
            if (file_exists($apiRouteFile)) {
                $content = file_get_contents($apiRouteFile);
                $content = preg_replace("/'(ajax|api|jquery)([A-Z][a-zA-Z0-9_]*)'/", "'api$2'", $content);
                file_put_contents($apiRouteFile, $content);
            }

            // 5. Overwrite app/controllers/ErrorController.php to output JSON responses for all error types
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
                "    }\n\n" .
                "    public function forbidden()\n" .
                "    {\n" .
                "        Router::json([\n" .
                "            'status' => 'error',\n" .
                "            'message' => 'Forbidden',\n" .
                "            'code' => 403\n" .
                "        ], 403);\n" .
                "    }\n\n" .
                "    public function internalError(\$exception = null)\n" .
                "    {\n" .
                "        \$response = [\n" .
                "            'status' => 'error',\n" .
                "            'message' => 'Internal Server Error',\n" .
                "            'code' => 500\n" .
                "        ];\n" .
                "        if (\$exception !== null && (\$_ENV['APP_DEBUG'] ?? 'false') === 'true') {\n" .
                "            \$response['debug'] = [\n" .
                "                'message' => \$exception->getMessage(),\n" .
                "                'file' => \$exception->getFile(),\n" .
                "                'line' => \$exception->getLine(),\n" .
                "                'trace' => explode(\"\\n\", \$exception->getTraceAsString())\n" .
                "            ];\n" .
                "        }\n" .
                "        Router::json(\$response, 500);\n" .
                "    }\n\n" .
                "    public function notImplemented()\n" .
                "    {\n" .
                "        Router::json([\n" .
                "            'status' => 'error',\n" .
                "            'message' => 'Not Implemented',\n" .
                "            'code' => 501\n" .
                "        ], 501);\n" .
                "    }\n\n" .
                "    public function serviceUnavailable()\n" .
                "    {\n" .
                "        Router::json([\n" .
                "            'status' => 'error',\n" .
                "            'message' => 'Service Unavailable',\n" .
                "            'code' => 503\n" .
                "        ], 503);\n" .
                "    }\n\n" .
                "    public function maintenance()\n" .
                "    {\n" .
                "        Router::json([\n" .
                "            'status' => 'error',\n" .
                "            'message' => 'Service Unavailable (Maintenance Mode)',\n" .
                "            'code' => 503\n" .
                "        ], 503);\n" .
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
            
            // 3. Update all JS files to directly call /api/ REST endpoints instead of /ajax/
            $jsFiles = array_merge(glob($basePath . 'js/*.js') ?: [], glob($basePath . 'js/*/*.js') ?: []);
            $apiMap = [
                "'/ajax/login'"           => "'/api/auth/login'",
                "'/ajax/register'"        => "'/api/auth/register'",
                "'/ajax/logout'"          => "'/api/auth/logout'",
                "'/ajax/forgot-password'" => "'/api/auth/forgot-password'",
                "'/ajax/reset-password'"  => "'/api/auth/reset-password'",
                "'/ajax/users/create'"    => "'/api/admin/users'",
                "'/ajax/users/update'"    => "'/api/admin/users/update'",
                "'/ajax/users/delete'"    => "'/api/admin/users/delete'",
                "'/ajax/admins/create'"   => "'/api/superadmin/admins'",
                "'/ajax/admins/update'"   => "'/api/superadmin/admins/update'",
                "'/ajax/admins/delete'"   => "'/api/superadmin/admins/delete'",
                "'/ajax/avatar'"          => "'/api/profile/avatar'",
                "'/ajax/profile'"         => "'/api/profile/update'",
                "'/ajax/change-password'" => "'/api/profile/change-password'",
            ];
            foreach ($jsFiles as $jsFile) {
                if (file_exists($jsFile) && basename($jsFile) !== 'ajax.js' && basename($jsFile) !== 'jquery.min.js' && basename($jsFile) !== 'jquery_ajax.js') {
                    $jsContent = file_get_contents($jsFile);
                    $jsContent = strtr($jsContent, $apiMap);
                    file_put_contents($jsFile, $jsContent);
                }
            }

            // 4. Update controllers and routes/api.php to rename 'ajaxX' methods to 'apiX'
            $controllers = array_merge(glob($basePath . 'app/controllers/*.php') ?: [], glob($basePath . 'app/controllers/*/*.php') ?: []);
            foreach ($controllers as $ctrl) {
                if (file_exists($ctrl)) {
                    $content = file_get_contents($ctrl);
                    $content = preg_replace('/function (ajax|api|jquery)([A-Z])/', 'function api$2', $content);
                    file_put_contents($ctrl, $content);
                }
            }
            $apiRouteFile = $basePath . 'routes/api.php';
            if (file_exists($apiRouteFile)) {
                $content = file_get_contents($apiRouteFile);
                $content = preg_replace("/'(ajax|api|jquery)([A-Z][a-zA-Z0-9_]*)'/", "'api$2'", $content);
                file_put_contents($apiRouteFile, $content);
            }

            // 5. Overwrite app/core/Controller.php — smart API detector, authorization constructor, and view json interceptor
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
                "    }\n\n" .
                "    /**\n" .
                "     * Skip CSRF for API requests — they use session auth guards.\n" .
                "     * Web/AJAX requests still validate the X-CSRF-Token header.\n" .
                "     */\n" .
                "    protected function verifyCsrf(): void\n" .
                "    {\n" .
                "        if (\$this->isApiRequest()) {\n" .
                "            return;\n" .
                "        }\n" .
                "        \$headerToken  = \$_SERVER['HTTP_X_CSRF_TOKEN'] ?? '';\n" .
                "        \$sessionToken = \$_SESSION['csrf_token']       ?? '';\n" .
                "        if (!\$headerToken || !\$sessionToken || !hash_equals(\$sessionToken, \$headerToken)) {\n" .
                "            http_response_code(403);\n" .
                "            header('Content-Type: application/json');\n" .
                "            echo json_encode(['success' => false, 'message' => 'Invalid or missing CSRF token.']);\n" .
                "            exit;\n" .
                "        }\n" .
                "    }\n" .
                "}\n";
            file_put_contents($basePath . 'app/core/Controller.php', $apiControllerContent);

            self::log("✔ Full Stack REST API configured. Old AJAX routes removed. Frontend requests mapped to /api/* successfully.", $event);
        } elseif ($choice === '4') {
            self::log("Configuring as jQuery Full Stack...", $event);

            // 1. Download jQuery minified into js/jquery.min.js
            $jqDest = $basePath . 'js/jquery.min.js';
            if (!file_exists($jqDest)) {
                $jqUrl = 'https://code.jquery.com/jquery-3.7.1.min.js';
                $jqSrc = @file_get_contents($jqUrl);
                if ($jqSrc !== false) {
                    file_put_contents($jqDest, $jqSrc);
                    self::log("  ✔ jQuery 3.7.1 downloaded to js/jquery.min.js", $event);
                } else {
                    self::log("  ⚠ Could not download jQuery. Add it manually to js/jquery.min.js.", $event);
                }
            }

            // 2. Overwrite js/ajax.js with a jQuery $.ajax wrapper (rename to jquery_ajax.js)
            //    — identical public API to the native fetch wrapper (Ajax.post / Ajax.get)
            //    — so ALL existing JS files (auth.js, users.js, profile.js, etc.) work unchanged
            $jsAjaxContent =
                "/**\n" .
                " * Ajax — jQuery \$.ajax wrapper\n" .
                " * Compatible drop-in for the native fetch-based Ajax helper.\n" .
                " * Requires jQuery (js/jquery.min.js).\n" .
                " */\n" .
                "const Ajax = {\n" .
                "    /**\n" .
                "     * POST form data to a URL\n" .
                "     * @param {string} url\n" .
                "     * @param {FormData|object} data\n" .
                "     * @returns {Promise<object>}\n" .
                "     */\n" .
                "    post(url, data) {\n" .
                "        const fd = data instanceof FormData ? data : (() => {\n" .
                "            const f = new FormData();\n" .
                "            Object.entries(data).forEach(([k, v]) => f.append(k, v));\n" .
                "            return f;\n" .
                "        })();\n\n" .
                "        return new Promise((resolve, reject) => {\n" .
                "            \$.ajax({\n" .
                "                url,\n" .
                "                method: 'POST',\n" .
                "                data: fd,\n" .
                "                processData: false,\n" .
                "                contentType: false,\n" .
                "                headers: {\n" .
                "                    'X-Requested-With': 'XMLHttpRequest',\n" .
                "                    'X-CSRF-Token': (document.querySelector('meta[name=csrf-token]') || {}).content || '',\n" .
                "                },\n" .
                "                success: resolve,\n" .
                "                error: (xhr) => {\n" .
                "                    try { resolve(JSON.parse(xhr.responseText)); }\n" .
                "                    catch { reject(new Error(xhr.statusText || 'Network Error')); }\n" .
                "                },\n" .
                "            });\n" .
                "        });\n" .
                "    },\n\n" .
                "    /**\n" .
                "     * GET request\n" .
                "     * @param {string} url\n" .
                "     * @returns {Promise<object>}\n" .
                "     */\n" .
                "    get(url) {\n" .
                "        return new Promise((resolve, reject) => {\n" .
                "            \$.ajax({\n" .
                "                url,\n" .
                "                method: 'GET',\n" .
                "                headers: {\n" .
                "                    'X-Requested-With': 'XMLHttpRequest',\n" .
                "                    'X-CSRF-Token': (document.querySelector('meta[name=csrf-token]') || {}).content || '',\n" .
                "                },\n" .
                "                success: resolve,\n" .
                "                error: (xhr) => {\n" .
                "                    try { resolve(JSON.parse(xhr.responseText)); }\n" .
                "                    catch { reject(new Error(xhr.statusText || 'Network Error')); }\n" .
                "                },\n" .
                "            });\n" .
                "        });\n" .
                "    },\n" .
                "};\n";
            file_put_contents($basePath . 'js/jquery_ajax.js', $jsAjaxContent);
            if (file_exists($basePath . 'js/ajax.js')) unlink($basePath . 'js/ajax.js');

            // 3. Rename route files and update file contents to use 'jquery' instead of 'ajax'
            $routeGroups = ['auth', 'admin', 'superadmin', 'app'];
            foreach ($routeGroups as $group) {
                $oldPath = $basePath . "routes/web/$group/ajax.php";
                $newPath = $basePath . "routes/web/$group/jquery.php";
                if (file_exists($oldPath)) {
                    rename($oldPath, $newPath);
                    $content = file_get_contents($newPath);
                    $content = str_replace('ajax/', 'jquery/', $content);
                    $content = str_replace('AJAX Routes', 'jQuery Routes', $content);
                    $content = preg_replace("/'(ajax|api|jquery)([A-Z][a-zA-Z0-9_]*)'/", "'jquery$2'", $content);
                    file_put_contents($newPath, $content);
                }
            }

            // 3.5 Update controllers and routes/api.php to rename 'ajaxX' methods to 'jqueryX'
            $controllers = array_merge(glob($basePath . 'app/controllers/*.php') ?: [], glob($basePath . 'app/controllers/*/*.php') ?: []);
            foreach ($controllers as $ctrl) {
                if (file_exists($ctrl)) {
                    $content = file_get_contents($ctrl);
                    $content = preg_replace('/function (ajax|api|jquery)([A-Z])/', 'function jquery$2', $content);
                    file_put_contents($ctrl, $content);
                }
            }
            $apiRouteFile = $basePath . 'routes/api.php';
            if (file_exists($apiRouteFile)) {
                $content = file_get_contents($apiRouteFile);
                $content = preg_replace("/'(ajax|api|jquery)([A-Z][a-zA-Z0-9_]*)'/", "'jquery$2'", $content);
                file_put_contents($apiRouteFile, $content);
            }

            // 4. Update routes/web.php
            $webPhpPath = $basePath . 'routes/web.php';
            if (file_exists($webPhpPath)) {
                $webPhp = file_get_contents($webPhpPath);
                $webPhp = str_replace('ajax.php', 'jquery.php', $webPhp);
                file_put_contents($webPhpPath, $webPhp);
            }

            // 5. Update layout footers to load js/jquery.min.js and js/jquery_ajax.js instead of js/ajax.js
            $footers = glob($basePath . 'app/views/layouts/*/footer.php');
            foreach ($footers as $fFile) {
                if (file_exists($fFile)) {
                    $html = file_get_contents($fFile);
                    $html = str_replace(
                        'js/ajax.js',
                        "js/jquery.min.js\"></script>\n<script src=\"<?= BASE_URL ?>/js/jquery_ajax.js",
                        $html
                    );
                    file_put_contents($fFile, $html);
                }
            }

            // 6. Update all JS files to point to /jquery/ endpoints
            $jsFiles = array_merge(glob($basePath . 'js/*.js') ?: [], glob($basePath . 'js/*/*.js') ?: []);
            foreach ($jsFiles as $jsFile) {
                if (file_exists($jsFile) && basename($jsFile) !== 'jquery.min.js' && basename($jsFile) !== 'jquery_ajax.js') {
                    $jsContent = file_get_contents($jsFile);
                    $jsContent = str_replace("'/ajax/", "'/jquery/", $jsContent);
                    file_put_contents($jsFile, $jsContent);
                }
            }

            // 7. Update inline /ajax/ paths inside PHP view files (e.g. admins.php has
            //    inline <script> blocks with BASE_URL + '/ajax/admins/...' that the
            //    JS-only pass above does not reach).
            $viewFiles = self::getPhpViewFiles($basePath . 'app/views');
            foreach ($viewFiles as $vFile) {
                $vContent = file_get_contents($vFile);
                if (strpos($vContent, "'/ajax/") !== false) {
                    $vContent = str_replace("'/ajax/", "'/jquery/", $vContent);
                    file_put_contents($vFile, $vContent);
                }
            }

            self::log("✔ jQuery Full Stack configured. Files renamed, routes updated to /jquery/*, js/ajax.js replaced with js/jquery_ajax.js.", $event);
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

    /**
     * Recursively collect all .php files under $dir.
     */
    private static function getPhpViewFiles(string $dir): array
    {
        $files = [];
        if (!is_dir($dir)) return $files;
        $it = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($dir, \RecursiveDirectoryIterator::SKIP_DOTS)
        );
        foreach ($it as $file) {
            if ($file->isFile() && $file->getExtension() === 'php') {
                $files[] = $file->getPathname();
            }
        }
        return $files;
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
