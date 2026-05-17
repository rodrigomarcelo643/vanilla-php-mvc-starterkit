<?php

// ── Bootstrap ─────────────────────────────────────────────────
require_once 'app/config/app.php';
require_once 'app/config/database.php';
require_once 'app/config/mail.php';
require_once 'app/helpers/helper.php';
require_once 'app/core/Database.php';
require_once 'app/core/Model.php';
require_once 'app/core/Session.php';
require_once 'app/core/Auth.php';
require_once 'app/core/Controller.php';
require_once 'app/core/Mailer.php';

// ── Route Files ───────────────────────────────────────────────
require_once 'routes/web/client.php';
require_once 'routes/web/admin.php';
require_once 'routes/web/app.php';
require_once 'routes/web/ajax.php';

// ── Dispatch ──────────────────────────────────────────────────
Router::dispatch();
