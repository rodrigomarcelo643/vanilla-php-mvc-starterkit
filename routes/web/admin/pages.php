<?php

// ── Admin Page Routes ─────────────────────────────────────────
Router::get('admin/dashboard',  ['DashboardController', 'index'])->middleware('admin');
Router::get('admin/users',      ['UserController', 'index'])->middleware('admin');
Router::get('admin/settings',   ['DashboardController', 'settings'])->middleware('admin');
Router::get('admin/profile',    ['DashboardController', 'profile'])->middleware('admin');