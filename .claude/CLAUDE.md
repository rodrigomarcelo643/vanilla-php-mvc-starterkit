# Starter Kit — Claude Context

## What this project is
A lightweight PHP MVC boilerplate — no Laravel, no Symfony. Everything is hand-rolled.
Built for rapid project starts with admin panel, auth, and role-based routing baked in.

## Stack
| Layer      | Technology                        |
|------------|-----------------------------------|
| Backend    | PHP 8.0+, custom MVC              |
| Database   | MySQL via PDO (`app/core/Database.php`) |
| Frontend   | Tailwind CSS 3 (CDN), Alpine.js 3 (CDN) |
| Auth       | Session-based (`app/core/Auth.php`) |
| Routing    | Custom static Router (`app/core/Router.php`) |

## Key entry points
- `index.php` — starts session, loads `.env`, boots router
- `routes/web.php` — requires all route files, calls `Router::dispatch()`
- `app/core/Router.php` — `get()`, `post()`, `any()`, `dispatch()`, `json()`, `redirect()`
- `app/core/Controller.php` — `admin()`, `app()`, `client()`, `auth()` render helpers

## Panels & their routes
- **Client** (public): `routes/web/client.php` → views in `app/views/client/`
- **Admin**: `routes/web/admin.php` → views in `app/views/admin/`
- **App** (logged-in user): `routes/web/app.php` → views in `app/views/app/`
- **Auth + AJAX**: `routes/web/ajax.php`

## Database tables
`users`, `admins`, `sessions`, `password_resets`, `activity_logs`
Schema + seed: `database/starter.sql`

## Rules for code generation
1. Never hardcode credentials — always use `$_ENV['KEY']`
2. Controllers must be thin — DB logic goes in models
3. AJAX responses must use `Router::json(['key' => 'value'])`
4. All redirects via `Router::redirect('path')`
5. Sanitize output with `htmlspecialchars()` in views
6. No jQuery — Alpine.js or vanilla JS only
7. New controllers extend `Controller`, new models extend `Model`
8. Follow existing file naming: `PascalCaseController.php`, `snake_case.php` views
