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

// Auth
require_once 'routes/web/auth/pages.php';
require_once 'routes/web/auth/ajax.php';

// Client / Public
require_once 'routes/web/client/pages.php';

// Admin
require_once 'routes/web/admin/pages.php';
require_once 'routes/web/admin/ajax.php';

// App / Authenticated User
require_once 'routes/web/app/pages.php';
require_once 'routes/web/app/ajax.php';

// ── Dispatch ──────────────────────────────────────────────────
Router::dispatch();
