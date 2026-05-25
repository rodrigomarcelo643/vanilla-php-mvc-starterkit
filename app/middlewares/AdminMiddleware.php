<?php

class AdminMiddleware
{
    /**
     * Handle the incoming request.
     *
     * @param callable $next
     * @return mixed
     */
    public function handle(callable $next)
    {
        $role = Session::get('user')['role'] ?? '';
        if (!Auth::check() || !in_array($role, ['admin', 'superadmin'])) {
            if (Router::isAjax() || str_starts_with(Router::parseUri(), 'api/')) {
                Router::json(['success' => false, 'message' => 'Unauthorized.'], 401);
            } else {
                Router::redirect('login');
            }
        }
        return $next();
    }
}
