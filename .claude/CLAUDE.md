# Starter Kit — Claude Context

## What this project is
A lightweight PHP MVC boilerplate — no Laravel, no Symfony. Everything is hand-rolled.
Built for rapid project starts with multi-panel layout, session auth, role-based routing,
OAuth (Google + GitHub), and a full super admin + admin panel baked in.

## Stack
| Layer      | Technology                                      |
|------------|-------------------------------------------------|
| Backend    | PHP 8.0+, custom MVC                            |
| Database   | MySQL via PDO (`app/core/Database.php`)         |
| Frontend   | Tailwind CSS 3 (CDN), Alpine.js 3 (CDN)         |
| Auth       | Session-based (`app/core/Auth.php`)             |
| OAuth      | Google + GitHub (`app/controllers/auth/OAuthController.php`) |
| Routing    | Custom static Router (`app/core/Router.php`)    |
| Mail       | PHPMailer (`app/core/Mailer.php`)               |

## Key entry points
- `index.php` — starts session, loads `.env`, boots router
- `routes/web.php` — requires all route files, calls `Router::dispatch()`
- `app/core/Router.php` — `get()`, `post()`, `any()`, `dispatch()`, `json()`, `redirect()`
- `app/core/Controller.php` — `admin()`, `app()`, `client()`, `auth()`, `superadmin()` render helpers
- `app/core/Session.php` — `set()`, `get()`, `destroy()`, `flash()`

## Panels & their routes
| Panel       | Route prefix     | Route files                          |
|-------------|------------------|--------------------------------------|
| Client      | `/`              | `routes/web/client/pages.php`        |
| Auth        | `/login` etc.    | `routes/web/auth/pages.php` + `ajax.php` + `oauth.php` |
| App         | `/app/`          | `routes/web/app/pages.php` + `ajax.php` |
| Admin       | `/admin/`        | `routes/web/admin/pages.php` + `ajax.php` |
| Super Admin | `/superadmin/`   | `routes/web/superadmin/pages.php` + `ajax.php` |

## OAuth flow
- Buttons on login + register link to `oauth/google` and `oauth/github`
- Existing email → direct login + flash toast + redirect to dashboard
- New email → `oauth_prefill` stored in session → redirect to `/register` with name/email auto-filled (readonly)
- After register → `oauth_prefill` cleared from session
- Credentials via `.env`: `GOOGLE_CLIENT_ID`, `GOOGLE_CLIENT_SECRET`, `GITHUB_CLIENT_ID`, `GITHUB_CLIENT_SECRET`

## Flash toast system
```php
// Set in any controller before redirect
Session::flash('toast', ['message' => 'Welcome!', 'type' => 'success']);
// types: success | error | info
```
All layout footers (auth, app, admin, superadmin) auto-read and fire `App.toast()` on page load.

## JS utilities (`js/app.js`)
```js
App.toast('Message', 'success');          // gradient toast bottom-right
App.alert('element-id', 'Message');       // inline alert box
App.setLoading('btn-id', 'spinner-id', true);
App.logout();
```
**Important:** Tailwind CDN cannot scan JS files. Any dynamic CSS classes injected via JS must use inline `style` attributes with raw CSS values.

## Database tables
| Table           | Purpose                           |
|-----------------|-----------------------------------|
| users           | App users (roles: user, editor)   |
| admins          | Admin panel accounts              |
| super_admins    | Highest-privilege accounts        |
| sessions        | Session tracking                  |
| password_resets | Password reset tokens             |
| activity_logs   | User action audit trail           |

## Default credentials (dev seed)
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
9. Dynamic JS-injected styles must use inline CSS, not Tailwind classes
10. Flash toasts auto-fire from layout footers — set with `Session::flash('toast', [...])`
