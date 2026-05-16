<?php

class HomeController extends Controller
{
    public function index()
    {
        $this->client('client/home', ['title' => 'Home']);
    }

    public function about()
    {
        $this->client('client/about', ['title' => 'About']);
    }

    public function docs()
    {
        $this->client('client/docs', ['title' => 'Docs']);
    }

    public function blog()
    {
        $this->client('client/blog', ['title' => 'Blog']);
    }
}
