<?php

// ── Admin Page Routes ─────────────────────────────────────────
Router::get('admin/dashboard',  ['DashboardController', 'index']);
Router::get('admin/users',      ['DashboardController', 'users']);
Router::get('admin/settings',   ['DashboardController', 'settings']);
Router::get('admin/profile',    ['DashboardController', 'profile']);