<?php

class AppController extends Controller
{
    public function home()
    {
        $this->app('app/home', ['title' => 'Home']);
    }

    public function profile()
    {
        $session = Session::get('user');
        $this->app('app/profile', ['title' => 'Profile', 'user' => $session]);
    }

    public function settings()
    {
        $this->app('app/settings', ['title' => 'Settings']);
    }
}
