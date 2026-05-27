<?php

// ── Client / Public Page Routes ───────────────────────────────
Router::get('',        ['HomeController',    'index']);
Router::get('about',   ['HomeController',    'about']);
Router::get('docs',    ['HomeController',    'docs']);
Router::get('blog',    ['HomeController',    'blog']);
Router::get('profile', ['ProfileController', 'index']);
Router::get('terms',   ['LegalController',   'terms']);
Router::get('privacy', ['LegalController',   'privacy']);
