<?php

// ── Auth Page Routes ──────────────────────────────────────────
Router::get('login',           ['AuthController',     'login']);
Router::get('register',        ['AuthController',     'register']);
Router::get('forgot-password', ['PasswordController', 'forgotPassword']);
Router::get('reset-password',  ['PasswordController', 'resetPassword']);
