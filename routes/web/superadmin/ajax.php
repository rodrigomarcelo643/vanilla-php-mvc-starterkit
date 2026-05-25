<?php

// ── Super Admin AJAX Routes ───────────────────────────────────
Router::post('ajax/admins/create', ['SuperAdminAdminController', 'ajaxCreate'])->middleware('superadmin');
Router::post('ajax/admins/update', ['SuperAdminAdminController', 'ajaxUpdate'])->middleware('superadmin');
Router::post('ajax/admins/delete', ['SuperAdminAdminController', 'ajaxDelete'])->middleware('superadmin');
