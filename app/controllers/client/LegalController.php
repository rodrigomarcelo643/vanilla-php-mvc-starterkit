<?php

class LegalController extends Controller
{
    public function terms()
    {
        $this->auth('auth/terms', ['title' => 'Terms of Service']);
    }

    public function privacy()
    {
        $this->auth('auth/privacy', ['title' => 'Privacy Policy']);
    }
}
