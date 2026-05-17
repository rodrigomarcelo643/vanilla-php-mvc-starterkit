<?php

class AppController extends Controller
{
    private function guard(): void
    {
        if (!Auth::check()) {
            header('Location: ' . BASE_URL . '/login');
            exit;
        }
    }

    public function home()
    {
        $this->guard();
        $this->app('app/home', ['title' => 'Home']);
    }

    public function profile()
    {
        $this->guard();
        $session = Session::get('user');
        $this->app('app/profile', ['title' => 'Profile', 'user' => $session]);
    }

    public function settings()
    {
        $this->guard();
        $this->app('app/settings', ['title' => 'Settings']);
    }
}
