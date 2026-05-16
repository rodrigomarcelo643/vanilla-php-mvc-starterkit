<?php

// ── Admin Routes ──────────────────────────────────────────────
Router::get('dashboard',        ['DashboardController', 'index']);
Router::get('admin/users',      ['DashboardController', 'users']);
Router::get('admin/settings',   ['DashboardController', 'settings']);
