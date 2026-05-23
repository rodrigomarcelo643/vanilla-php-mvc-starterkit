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
            
            // Delete only physical frontend directories
            self::deleteDir($basePath . 'app/views');
            self::deleteDir($basePath . 'assets');
            self::deleteDir($basePath . 'js');
            
            // We KEEP routes/web intact so all backend default starter routes and controllers still exist!
            // We KEEP the original routes/web.php because it loads all nested route files!
            
            // Overwrite app/core/Controller.php to intercept view loading and output clean JSON instead
            $apiControllerContent = "<?php\n\n" .
                "class Controller\n" .
                "{\n" .
                "    public function client(\$view, \$data = [])\n" .
                "    {\n" .
                "        Router::json([\n" .
                "            'status' => 'success',\n" .
                "            'view' => \$view,\n" .
                "            'data' => \$data\n" .
                "        ]);\n" .
                "    }\n\n" .
                "    public function admin(\$view, \$data = [])\n" .
                "    {\n" .
                "        Router::json([\n" .
                "            'status' => 'success',\n" .
                "            'view' => \$view,\n" .
                "            'data' => \$data\n" .
                "        ]);\n" .
                "    }\n\n" .
                "    public function app(\$view, \$data = [])\n" .
                "    {\n" .
                "        Router::json([\n" .
                "            'status' => 'success',\n" .
                "            'view' => \$view,\n" .
                "            'data' => \$data\n" .
                "        ]);\n" .
                "    }\n\n" .
                "    public function auth(\$view, \$data = [])\n" .
                "    {\n" .
                "        Router::json([\n" .
                "            'status' => 'success',\n" .
                "            'view' => \$view,\n" .
                "            'data' => \$data\n" .
                "        ]);\n" .
                "    }\n\n" .
                "    public function superadmin(\$view, \$data = [])\n" .
                "    {\n" .
                "        Router::json([\n" .
                "            'status' => 'success',\n" .
                "            'view' => \$view,\n" .
                "            'data' => \$data\n" .
                "        ]);\n" .
                "    }\n" .
                "}\n";

            file_put_contents($basePath . 'app/core/Controller.php', $apiControllerContent);

            // Overwrite app/controllers/ErrorController.php to output JSON 404
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

            self::log("✔ Frontend UI removed. Backend MVC REST API configured successfully.", $event);
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
