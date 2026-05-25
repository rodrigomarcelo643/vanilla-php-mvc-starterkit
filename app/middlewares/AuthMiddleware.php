<?php

class AuthMiddleware
{
    /**
     * Handle the incoming request.
     *
     * @param callable $next
     * @return mixed
     */
    public function handle(callable $next)
    {
        if (!Auth::check()) {
            if (Router::isAjax() || str_starts_with(Router::parseUri(), 'api/')) {
                Router::json(['success' => false, 'message' => 'Unauthorized.'], 401);
            } else {
                Router::redirect('login');
            }
        }
        return $next();
    }
}
