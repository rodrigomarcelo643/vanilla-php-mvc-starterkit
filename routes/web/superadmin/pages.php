<?php

// ── Super Admin Page Routes ───────────────────────────────────
Router::get('superadmin/dashboard', ['SuperAdminDashboardController', 'index'])->middleware('superadmin');
Router::get('superadmin/admins',    ['SuperAdminDashboardController', 'admins'])->middleware('superadmin');
Router::get('superadmin/users',     ['SuperAdminUserController', 'index'])->middleware('superadmin');
Router::get('superadmin/settings',  ['SuperAdminDashboardController', 'settings'])->middleware('superadmin');
Router::get('superadmin/profile',   ['SuperAdminDashboardController', 'profile'])->middleware('superadmin');
