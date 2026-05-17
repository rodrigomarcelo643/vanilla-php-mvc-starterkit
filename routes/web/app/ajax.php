<?php

// ── App AJAX Routes ───────────────────────────────────────────
Router::post('ajax/avatar',          ['ProfileController', 'ajaxUploadAvatar']);
Router::post('ajax/profile',         ['ProfileController', 'ajaxUpdateProfile']);
Router::post('ajax/change-password', ['ProfileController', 'ajaxChangePassword']);
