<?php

// ── Authentication API ────────────────────────────────────────
Router::post('api/auth/login',           ['AuthController',     'ajaxLogin']);
Router::post('api/auth/register',        ['AuthController',     'ajaxRegister']);
Router::post('api/auth/logout',          ['AuthController',     'ajaxLogout']);
Router::post('api/auth/forgot-password', ['PasswordController', 'ajaxForgotPassword']);
Router::post('api/auth/reset-password',  ['PasswordController', 'ajaxResetPassword']);

// ── Admin / User Management API ──────────────────────────────
Router::post('api/admin/users',          ['UserController',     'ajaxCreate']);
Router::post('api/admin/users/update',   ['UserController',     'ajaxUpdate']);
Router::post('api/admin/users/delete',   ['UserController',     'ajaxDelete']);

// ── Super Admin / Admin Management API ───────────────────────
Router::post('api/superadmin/admins',        ['SuperAdminAdminController', 'ajaxCreate']);
Router::post('api/superadmin/admins/update', ['SuperAdminAdminController', 'ajaxUpdate']);
Router::post('api/superadmin/admins/delete', ['SuperAdminAdminController', 'ajaxDelete']);

// ── Profile / User Settings API ──────────────────────────────
Router::post('api/profile/avatar',          ['ProfileController', 'ajaxUploadAvatar']);
Router::post('api/profile/update',          ['ProfileController', 'ajaxUpdateProfile']);
Router::post('api/profile/change-password', ['ProfileController', 'ajaxChangePassword']);

// ── Core / Ping API ──────────────────────────────────────────
Router::get('api/ping',                     ['HomeController',    'ping']);
