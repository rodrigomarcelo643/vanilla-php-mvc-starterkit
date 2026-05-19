<?php

// ── Super Admin Page Routes ───────────────────────────────────
Router::get('superadmin/dashboard', ['SuperAdminDashboardController', 'index']);
Router::get('superadmin/admins',    ['SuperAdminDashboardController', 'admins']);
Router::get('superadmin/users',     ['SuperAdminDashboardController', 'users']);
Router::get('superadmin/settings',  ['SuperAdminDashboardController', 'settings']);
Router::get('superadmin/profile',   ['SuperAdminDashboardController', 'profile']);
