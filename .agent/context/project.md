# Starter Kit — Agent Context

## Project Overview
- **Name:** Starter Kit
- **Version:** 1.2.0
- **Developer:** MarDev — Software Developer
- **Stack:** PHP 8.0+ · MySQL · Tailwind CSS 3 (CDN) · Alpine.js 3 (CDN)
- **Pattern:** Custom MVC (no framework)
- **Auth:** Session-based with role support (`user`, `editor`, `admin`, `superadmin`)
- **OAuth:** Google + GitHub (optional, credential-driven)

## Directory Map
```
starterkit/
├── app/
│   ├── config/
│   │   ├── app.php          APP_NAME, BASE_URL
│   │   ├── database.php     DB_* constants
│   │   ├── mail.php         MAIL_* constants
│   │   └── oauth.php        GOOGLE_*/GITHUB_* constants
│   ├── controllers/
│   │   ├── auth/            AuthController, OAuthController, PasswordController, ProfileController
│   │   ├── admin/           DashboardController, UserController
│   │   ├── superadmin/      SuperAdminDashboardController, SuperAdminAdminController
│   │   ├── client/          AppController, HomeController
│   │   └── ErrorController.php
│   ├── core/                Router, Controller, Model, Auth, Session, Database, Mailer
│   ├── helpers/             helper.php
│   ├── models/              User, Admin, SuperAdmin, PasswordReset
│   └── views/
│       ├── admin/           dashboard, profile, settings, users
│       ├── app/             home, profile, settings
│       ├── auth/            login, register, forgot-password, reset-password
│       ├── client/          home, about, blog, docs, profile
│       ├── superadmin/      dashboard, admins, users, profile, settings
│       ├── components/      admin/, app/, client/, superadmin/, shared/
│       ├── errors/          404.php
│       └── layouts/         admin/, app/, auth/, client/, superadmin/ (header + footer)
├── assets/css/              admin.css, animations.css, style.css, skeleton.css, custom.css
├── database/                starter.sql
├── js/
│   ├── admin/               admin.js, users.js
│   ├── ajax.js              Ajax.post / Ajax.get fetch wrapper
│   ├── app.js               App.toast(), App.alert(), App.setLoading(), App.logout()
│   ├── auth.js              login/register/forgot/reset handlers
│   ├── avatar.js            drag & drop avatar upload
│   ├── logout.js            logout confirmation modal
│   ├── profile.js           profile edit + password change
│   ├── settings.js          theme sync
│   ├── sidebar.js           Ctrl+B shortcut
│   └── theme.js             dark/light toggle
├── routes/
│   ├── web.php              bootstrap + loads all route files + dispatch
│   └── web/
│       ├── auth/            pages.php, ajax.php, oauth.php
│       ├── admin/           pages.php, ajax.php
│       ├── superadmin/      pages.php, ajax.php
│       ├── app/             pages.php, ajax.php
│       └── client/          pages.php
├── storage/uploads/avatars/
├── tests/                   unit/ + feature/ PHPUnit suites
├── .env                     secrets (gitignored)
├── .env.example             template
└── index.php                entry point
```

## Core Patterns

### Adding a route
```php
// routes/web/client/pages.php
Router::get('contact', ['HomeController', 'contact']);
```

### Adding a controller method
```php
public function contact(): void
{
    $this->client('client/contact', ['title' => 'Contact']);
}
```

### AJAX response
```php
Router::json(['success' => true, 'message' => 'Done']);
```

### Redirect
```php
Router::redirect('dashboard');
```

### Flash toast (set then read once on next page)
```php
// Set (in controller before redirect)
Session::flash('toast', ['message' => 'Saved!', 'type' => 'success']);

// Read (auto-handled in all layout footers)
$toast = Session::flash('toast');
```

### Toast from JS
```js
App.toast('Message here', 'success'); // types: success | error | info
```

## Panels & Layouts
| Panel      | Route prefix    | Layout                        | Guard         |
|------------|-----------------|-------------------------------|---------------|
| Client     | `/`             | `layouts/client/`             | none          |
| Auth       | `/login` etc.   | `layouts/auth/`               | guest only    |
| App        | `/app/`         | `layouts/app/`                | role: user    |
| Admin      | `/admin/`       | `layouts/admin/`              | role: admin   |
| Super Admin| `/superadmin/`  | `layouts/superadmin/`         | role: superadmin |

## OAuth Flow
1. User clicks Google/GitHub button → `oauth/{provider}` → provider login
2. Callback → token exchange → profile fetch
3. **Existing email** → log in directly, flash toast, redirect to dashboard
4. **New email** → store `oauth_prefill` in session, redirect to `/register`
5. Register page auto-fills name + email (readonly), user sets password only
6. On register submit → `oauth_prefill` cleared

## Environment Variables
| Key                  | Description                        |
|----------------------|------------------------------------|
| APP_NAME             | Application display name           |
| BASE_URL             | Subfolder path e.g. `/starterkit`  |
| DB_HOST              | Database host                      |
| DB_NAME              | Database name                      |
| DB_USER              | Database user                      |
| DB_PASS              | Database password                  |
| MAIL_*               | SMTP mailer config                 |
| GOOGLE_CLIENT_ID     | Google OAuth client ID             |
| GOOGLE_CLIENT_SECRET | Google OAuth client secret         |
| GITHUB_CLIENT_ID     | GitHub OAuth client ID             |
| GITHUB_CLIENT_SECRET | GitHub OAuth client secret         |

## Database Tables
| Table           | Purpose                              |
|-----------------|--------------------------------------|
| users           | App users (roles: user, editor)      |
| admins          | Admin panel accounts                 |
| super_admins    | Highest-privilege accounts           |
| sessions        | Session tracking                     |
| password_resets | Password reset tokens                |
| activity_logs   | User action audit trail              |

## Default Credentials (dev seed)
| Role        | Email                  | Password |
|-------------|------------------------|----------|
| Super Admin | superadmin@starter.com | password |
| Admin       | admin@starter.com      | password |
| User        | alice@example.com      | password |

## Rules for code generation
1. Never hardcode credentials — always use `$_ENV['KEY']`
2. Controllers must be thin — DB logic goes in models
3. AJAX responses must use `Router::json(['key' => 'value'])`
4. All redirects via `Router::redirect('path')`
5. Sanitize output with `htmlspecialchars()` in views
6. No jQuery — Alpine.js or vanilla JS only
7. New controllers extend `Controller`, new models extend `Model`
8. File naming: `PascalCaseController.php`, `snake_case.php` views
9. Dynamic CSS classes injected via JS must use inline styles (Tailwind CDN can't scan JS)
10. Flash toasts are set via `Session::flash('toast', [...])` and auto-read in all layout footers
