<?php

// ── Super Admin AJAX Routes ───────────────────────────────────
Router::post('ajax/admins/create', ['SuperAdminAdminController', 'ajaxCreate']);
Router::post('ajax/admins/update', ['SuperAdminAdminController', 'ajaxUpdate']);
Router::post('ajax/admins/delete', ['SuperAdminAdminController', 'ajaxDelete']);
