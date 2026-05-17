<?php

// ── Admin AJAX Routes ─────────────────────────────────────────
Router::post('ajax/users/create', ['UserController', 'ajaxCreate']);
Router::post('ajax/users/update', ['UserController', 'ajaxUpdate']);
Router::post('ajax/users/delete', ['UserController', 'ajaxDelete']);
