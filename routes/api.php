<?php

// ── Root / Welcome ────────────────────────────────────────────
Router::get('', function () {
    Router::json([
        'status'  => 'success',
        'engine'  => 'MARDEV Starter Kit',
        'version' => '1.3.3',
        'message' => 'REST API is running.',
        'docs'    => 'See /api for available endpoints.',
    ]);
});

// ── API Info ──────────────────────────────────────────────────
Router::get('api', function () {
    Router::json([
        'status'    => 'success',
        'engine'    => 'MARDEV Starter Kit REST API',
        'version'   => '1.3.3',
        'endpoints' => [
            'POST /api/auth/login'                  => 'Login',
            'POST /api/auth/register'               => 'Register',
            'POST /api/auth/logout'                 => 'Logout',
            'POST /api/auth/forgot-password'        => 'Forgot Password',
            'POST /api/auth/reset-password'         => 'Reset Password',
            'POST /api/admin/users'                 => 'Create User (admin)',
            'POST /api/admin/users/update'          => 'Update User (admin)',
            'POST /api/admin/users/delete'          => 'Delete User (admin)',
            'POST /api/superadmin/admins'           => 'Create Admin (superadmin)',
            'POST /api/superadmin/admins/update'    => 'Update Admin (superadmin)',
            'POST /api/superadmin/admins/delete'    => 'Delete Admin (superadmin)',
            'POST /api/profile/avatar'              => 'Upload Avatar',
            'POST /api/profile/update'              => 'Update Profile',
            'POST /api/profile/change-password'     => 'Change Password',
            'GET  /api/ping'                        => 'Health check',
        ],
    ]);
});

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

// ── Health Check ──────────────────────────────────────────────
Router::get('api/ping', function () {
    Router::json([
        'status'    => 'success',
        'message'   => 'pong',
        'timestamp' => date('Y-m-d H:i:s'),
    ]);
});
