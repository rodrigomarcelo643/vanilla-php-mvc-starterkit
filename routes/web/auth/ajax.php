<?php

// ── Auth AJAX Routes ──────────────────────────────────────────
Router::post('ajax/login',           ['AuthController',     'ajaxLogin']);
Router::post('ajax/register',        ['AuthController',     'ajaxRegister']);
Router::post('ajax/logout',          ['AuthController',     'ajaxLogout']);
Router::post('ajax/forgot-password', ['PasswordController', 'ajaxForgotPassword']);
Router::post('ajax/reset-password',  ['PasswordController', 'ajaxResetPassword']);
