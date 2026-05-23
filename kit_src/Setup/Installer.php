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
            
            self::deleteDir($basePath . 'app/views');
            self::deleteDir($basePath . 'assets');
            self::deleteDir($basePath . 'js');
            self::deleteDir($basePath . 'routes/web');
            
            // Overwrite routes/web.php to act as the main API router
            $apiRouteContent = "<?php\n\n" .
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
                "// ── Routes ────────────────────────────────────────────────────\n" .
                "Router::get('/', ['HomeController', 'index']);\n" .
                "Router::get('api/ping', ['HomeController', 'ping']);\n\n" .
                "// ── Dispatch ──────────────────────────────────────────────────\n" .
                "Router::dispatch();\n";
                
            file_put_contents($basePath . 'routes/web.php', $apiRouteContent);

            // Overwrite app/controllers/client/HomeController.php to return JSON
            $homeControllerContent = "<?php\n\n" .
                "class HomeController extends Controller\n" .
                "{\n" .
                "    public function index()\n" .
                "    {\n" .
                "        Router::json([\n" .
                "            'status' => 'success',\n" .
                "            'message' => 'Welcome to the Vanilla PHP REST API Boilerplate',\n" .
                "            'version' => '1.0'\n" .
                "        ]);\n" .
                "    }\n\n" .
                "    public function ping()\n" .
                "    {\n" .
                "        Router::json([\n" .
                "            'status' => 'ok',\n" .
                "            'timestamp' => time()\n" .
                "        ]);\n" .
                "    }\n" .
                "}\n";

            @mkdir($basePath . 'app/controllers/client', 0755, true);
            file_put_contents($basePath . 'app/controllers/client/HomeController.php', $homeControllerContent);

            self::log("✔ Frontend UI removed. Backend Only REST API configured.", $event);
        } elseif ($choice === '2') {
            self::log("✔ Configuring as REST API (Full Stack with JS)...", $event);
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
