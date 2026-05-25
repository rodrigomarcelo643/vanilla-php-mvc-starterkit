<?php

// ── App AJAX Routes ───────────────────────────────────────────
Router::post('ajax/avatar',          ['ProfileController', 'ajaxUploadAvatar'])->middleware('auth');
Router::post('ajax/profile',         ['ProfileController', 'ajaxUpdateProfile'])->middleware('auth');
Router::post('ajax/change-password', ['ProfileController', 'ajaxChangePassword'])->middleware('auth');
