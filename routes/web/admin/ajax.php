<?php

// ── Admin AJAX Routes ─────────────────────────────────────────
Router::post('ajax/users/create', ['UserController', 'ajaxCreate'])->middleware('admin');
Router::post('ajax/users/update', ['UserController', 'ajaxUpdate'])->middleware('admin');
Router::post('ajax/users/delete', ['UserController', 'ajaxDelete'])->middleware('admin');
