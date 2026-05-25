<?php

class GuestMiddleware
{
    /**
     * Handle the incoming request.
     *
     * @param callable $next
     * @return mixed
     */
    public function handle(callable $next)
    {
        if (Auth::check()) {
            $role = Session::get('user')['role'] ?? 'user';
            $redirect = match($role) {
                'admin'      => 'admin/dashboard',
                'superadmin' => 'superadmin/dashboard',
                default      => 'app/home',
            };
            Router::redirect($redirect);
        }
        return $next();
    }
}
