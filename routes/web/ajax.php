<?php

// ── Auth Routes ───────────────────────────────────────────────
Router::get('login',           ['AuthController',     'login']);
Router::get('register',        ['AuthController',     'register']);
Router::get('forgot-password', ['PasswordController', 'forgotPassword']);
Router::get('reset-password',  ['PasswordController', 'resetPassword']);

// ── AJAX Routes ───────────────────────────────────────────────
Router::post('ajax/login',           ['AuthController',     'ajaxLogin']);
Router::post('ajax/register',        ['AuthController',     'ajaxRegister']);
Router::post('ajax/logout',          ['AuthController',     'ajaxLogout']);
Router::post('ajax/forgot-password', ['PasswordController', 'ajaxForgotPassword']);
Router::post('ajax/reset-password',  ['PasswordController', 'ajaxResetPassword']);
Router::post('ajax/avatar',          ['ProfileController',  'ajaxUploadAvatar']);
Router::post('ajax/profile',         ['ProfileController',  'ajaxUpdateProfile']);
Router::post('ajax/users/create', ['UserController', 'ajaxCreate']);
Router::post('ajax/users/update', ['UserController', 'ajaxUpdate']);
Router::post('ajax/users/delete', ['UserController', 'ajaxDelete']);

