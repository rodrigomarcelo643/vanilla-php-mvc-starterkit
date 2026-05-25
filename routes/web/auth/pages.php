<?php

// ── Auth Page Routes ──────────────────────────────────────────
Router::get('login',           ['AuthController',     'login'])->middleware('guest');
Router::get('register',        ['AuthController',     'register'])->middleware('guest');
Router::get('forgot-password', ['PasswordController', 'forgotPassword'])->middleware('guest');
Router::get('reset-password',  ['PasswordController', 'resetPassword'])->middleware('guest');
