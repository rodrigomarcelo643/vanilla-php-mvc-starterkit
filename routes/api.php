<?php

// ── Root / Welcome ────────────────────────────────────────────
if (!Router::hasRoute('GET', '')) {
    Router::get('', function () {
        Router::json([
            'status'  => 'success',
            'engine'  => 'MARDEV Starter Kit',
            'version' => '1.1.4',
            'message' => 'REST API is running.',
            'docs'    => 'See /api for available endpoints.',
        ]);
    });
}

// ── API Info ──────────────────────────────────────────────────
Router::get('api', function () {
    Router::json([
        'status'    => 'success',
        'engine'    => 'MARDEV Starter Kit REST API',
        'version'   => '1.1.4',
        'endpoints' => [
            'POST /api/auth/login'                  => 'Login',
            'POST /api/auth/register'               => 'Register',
            'POST /api/auth/logout'                 => 'Logout',
            'POST /api/auth/forgot-password'        => 'Forgot Password',
            'POST /api/auth/reset-password'         => 'Reset Password',
            'GET  /api/admin/dashboard'             => 'Get Admin Dashboard Stats',
            'GET  /api/admin/users'                 => 'Get All Users',
            'POST /api/admin/users'                 => 'Create User',
            'POST /api/admin/users/update'          => 'Update User',
            'POST /api/admin/users/delete'          => 'Delete User',
            'GET  /api/superadmin/dashboard'        => 'Get Superadmin Dashboard Stats',
            'GET  /api/superadmin/admins'           => 'Get All Admins',
            'POST /api/superadmin/admins'           => 'Create Admin',
            'POST /api/superadmin/admins/update'    => 'Update Admin',
            'POST /api/superadmin/admins/delete'    => 'Delete Admin',
            'GET  /api/superadmin/users'            => 'Get All Users (superadmin overview)',
            'GET  /api/profile'                     => 'Get User Profile Info',
            'POST /api/profile/avatar'              => 'Upload Avatar',
            'POST /api/profile/update'              => 'Update Profile',
            'POST /api/profile/change-password'     => 'Change Password',
            'GET  /api/app/home'                    => 'Get User Home Info',
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
Router::get('api/admin/users',           ['UserController',     'index'])->middleware('admin');
Router::post('api/admin/users',          ['UserController',     'ajaxCreate'])->middleware('admin');
Router::post('api/admin/users/update',   ['UserController',     'ajaxUpdate'])->middleware('admin');
Router::post('api/admin/users/delete',   ['UserController',     'ajaxDelete'])->middleware('admin');

// ── Super Admin / Admin Management API ───────────────────────
Router::get('api/superadmin/admins',        ['SuperAdminDashboardController', 'admins'])->middleware('superadmin');
Router::post('api/superadmin/admins',        ['SuperAdminAdminController', 'ajaxCreate'])->middleware('superadmin');
Router::post('api/superadmin/admins/update', ['SuperAdminAdminController', 'ajaxUpdate'])->middleware('superadmin');
Router::post('api/superadmin/admins/delete', ['SuperAdminAdminController', 'ajaxDelete'])->middleware('superadmin');

// ── Super Admin / User Overview API ──────────────────────────
Router::get('api/superadmin/users',         ['SuperAdminUserController',  'index'])->middleware('superadmin');

// ── Dashboards API ───────────────────────────────────────────
Router::get('api/admin/dashboard',          ['DashboardController',       'index'])->middleware('admin');
Router::get('api/superadmin/dashboard',     ['SuperAdminDashboardController', 'index'])->middleware('superadmin');

// ── Profile / User Settings API ──────────────────────────────
Router::get('api/profile',                  ['ProfileController', 'index'])->middleware('auth');
Router::post('api/profile/avatar',          ['ProfileController', 'ajaxUploadAvatar'])->middleware('auth');
Router::post('api/profile/update',          ['ProfileController', 'ajaxUpdateProfile'])->middleware('auth');
Router::post('api/profile/change-password', ['ProfileController', 'ajaxChangePassword'])->middleware('auth');

// ── App / Authenticated User API ─────────────────────────────
Router::get('api/app/home',                 ['AppController',     'home'])->middleware('auth');

// ── Health Check ──────────────────────────────────────────────
Router::get('api/ping', function () {
    Router::json([
        'status'    => 'success',
        'message'   => 'pong',
        'timestamp' => date('Y-m-d H:i:s'),
    ]);
});

