<?php

class ErrorController extends Controller
{
    private function shouldReturnJson(): bool
    {
        $uri = Router::parseUri();
        return Router::isAjax() || str_starts_with($uri, 'api/') || $uri === 'api';
    }

    public function notFound()
    {
        if ($this->shouldReturnJson()) {
            Router::json([
                'status' => 'error',
                'message' => 'Resource not found',
                'code' => 404
            ], 404);
        }
        http_response_code(404);
        include 'app/views/errors/404.php';
    }

    public function forbidden()
    {
        if ($this->shouldReturnJson()) {
            Router::json([
                'status' => 'error',
                'message' => 'Forbidden',
                'code' => 403
            ], 403);
        }
        http_response_code(403);
        include 'app/views/errors/403.php';
    }

    public function internalError($exception = null)
    {
        if ($this->shouldReturnJson()) {
            $response = [
                'status' => 'error',
                'message' => 'Internal Server Error',
                'code' => 500
            ];
            if ($exception !== null && ($_ENV['APP_DEBUG'] ?? 'false') === 'true') {
                $response['debug'] = [
                    'message' => $exception->getMessage(),
                    'file' => $exception->getFile(),
                    'line' => $exception->getLine(),
                    'trace' => explode("\n", $exception->getTraceAsString())
                ];
            }
            Router::json($response, 500);
        }
        http_response_code(500);
        include 'app/views/errors/500.php';
    }

    public function notImplemented()
    {
        if ($this->shouldReturnJson()) {
            Router::json([
                'status' => 'error',
                'message' => 'Not Implemented',
                'code' => 501
            ], 501);
        }
        http_response_code(501);
        include 'app/views/errors/501.php';
    }

    public function serviceUnavailable()
    {
        if ($this->shouldReturnJson()) {
            Router::json([
                'status' => 'error',
                'message' => 'Service Unavailable',
                'code' => 503
            ], 503);
        }
        http_response_code(503);
        include 'app/views/errors/503.php';
    }

    public function maintenance()
    {
        if ($this->shouldReturnJson()) {
            Router::json([
                'status' => 'error',
                'message' => 'Service Unavailable (Maintenance Mode)',
                'code' => 503
            ], 503);
        }
        http_response_code(503);
        include 'app/views/errors/maintenance.php';
    }
}