# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/) and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [1.1.2] — 2026-05-25

### Fixed
- **Installation Wizard:**
  - Updated method renaming regex in all presets (Option 2, 3, and 4) to support matching any of the prefixes (`ajax`, `api`, or `jquery`). This resolves user registration errors and allows switching between presets seamlessly or re-running the installer.

---

## [1.1.1] — 2026-05-25

### Changed
- **Installation Wizard:**
  - Option 4 (jQuery Stack) now physically renames `ajax.php` route files to `jquery.php` and updates internal controller method prefixes (`ajaxLogin` → `jqueryLogin`).
  - Option 2 (REST API) and Option 3 (Headless) now physically rename controller methods to `apiLogin` and update paths dynamically.
  - Option 2 (REST API) now rewrites all `js/*.js` files to use `/api/` endpoints directly, removing the need for a runtime path mapper.

---

## [1.1.0] — 2026-05-25

### Added

#### Middleware System
- New `app/core/Route.php` — fluent `->middleware()` chaining on route definitions
- `Router` upgraded with a static middleware map and an `array_reduce` pipeline runner
- `app/middlewares/AuthMiddleware.php` — blocks unauthenticated access; returns JSON `401` for AJAX/API requests
- `app/middlewares/GuestMiddleware.php` — redirects authenticated users to their role dashboard
- `app/middlewares/AdminMiddleware.php` — enforces `admin` or `superadmin` role
- `app/middlewares/SuperAdminMiddleware.php` — enforces exclusive `superadmin` role
- `php kit make:middleware` command added to the `kit` runner map

#### Installation Wizard
- New **[4] jQuery Stack** preset — Full Stack with jQuery `$.ajax` wrapper replacing native `fetch`
- Auto-downloads jQuery 3.7.1 minified to `js/jquery.min.js` on preset selection
- Injects `<script>` tag for jQuery into all layout headers (auth, admin, superadmin, app, client)
- `js/ajax.js` swapped for a drop-in jQuery wrapper — all existing JS files work unchanged
- All views, role panels, and controllers remain completely untouched in this preset

#### Route List (`php kit route:list`)
- API routes now hidden by default on **Full Stack (option 1)** only — they are internal AJAX backing routes, not a public API surface
- API routes correctly visible on **jQuery Stack (4)**, **REST API (2)**, and **Backend Only (3)** presets
- Preset auto-detected at runtime: presence of `ajax/` route files + absence of `jquery.min.js` → Full Stack
- Added `api` as a valid `--group` filter argument so API routes can still be explicitly listed with `php kit route:list --group=api`

### Changed
- All protected web, AJAX, and REST API routes now declare middleware via `->middleware(...)` instead of inline controller guards
- `routes/web/auth/pages.php` — `guest` middleware applied
- `routes/web/app/pages.php` & `ajax.php` — `auth` middleware applied
- `routes/web/admin/pages.php` & `ajax.php` — `admin` middleware applied
- `routes/web/superadmin/pages.php` & `ajax.php` — `superadmin` middleware applied
- `routes/api.php` — per-route `auth`, `admin`, and `superadmin` middlewares applied

### Removed
- Manual `guard()` and `guardAjax()` private methods removed from all controllers:
  - `AppController`, `DashboardController`, `UserController`
  - `SuperAdminDashboardController`, `SuperAdminUserController`, `SuperAdminAdminController`
  - `AuthController`, `ProfileController`, `PasswordController`

### Fixed
- `RouterTest` root URI assertions corrected to match `Router::parseUri()` empty-string output for the root path

---

## [1.0.0] — 2026-05-23


### Added

#### Core Architecture
- PHP 8+ vanilla MVC architecture (Router, Controller, Model, Auth, Session, Database, Mailer)
- Session-based authentication — login, register, logout, password reset
- Role-based routing — admin, superadmin, app, client, and AJAX route groups
- Full admin panel — collapsible sidebar, topbar, user management, data tables
- Super admin panel — dedicated `/superadmin/` panel with purple-accented UI, admin CRUD
- App panel — authenticated user home, profile, settings
- Client panel — public home, about, blog, docs pages
- Avatar upload with image preview and AJAX crop
- `.env`-driven configuration — no hardcoded credentials
- Tailwind CSS + Alpine.js via CDN — no build step
- PHPUnit 11 test suite — 77 tests across unit and feature suites
- GitHub Actions workflows — lint, quality, secret scan, SQL validate, deploy
- Composer managed — PHPMailer, PHPUnit
- AI assistant context files — `.agent/` and `.claude/`
- Dark mode support across all views (admin, app, client, auth)
- OAuth login — Google and GitHub sign-in with auto-prefill registration
- Flash toast system — `Session::flash()` with auto-dismiss and progress bar

#### REST API Layer (`routes/api.php`)
- Unified `/api/` route file — all API routes return JSON regardless of installation mode
- Smart `Controller::isApiRequest()` interceptor — detects `/api/` prefix and auto-switches to JSON output mode
- Constructor-based auth guard in base `Controller` — returns JSON `401`/`403` for unauthorized API requests instead of HTML redirects
- `GET /api/ping` — health check endpoint
- `GET /api` — API info and endpoint directory
- Full auth endpoints: login, register, logout, forgot/reset password
- Full admin endpoints: users CRUD + dashboard stats
- Full superadmin endpoints: admins CRUD + users overview + dashboard stats
- Profile endpoints: get profile, upload avatar, update profile, change password
- App endpoint: authenticated user home data
- `Router::hasRoute()` — prevents `routes/api.php` from overwriting pre-registered frontend page routes (used so root `/` serves HTML on Option 1 & 2, JSON only on Option 3)

#### Kit CLI — `php kit route:test`
- New interactive API endpoint tester command: `php kit route:test`
- Auto-resolves `BASE_URL` to a full `http://` host (handles relative paths like `/starterkit`)
- Pings `/api/ping` on startup to verify connectivity; falls back to manual host selection
- Parses all routes from `routes/api.php` dynamically at runtime — no hardcoded list
- Categorizes endpoints under: `SYSTEM / HEALTH CHECK`, `AUTHENTICATION & SESSION`, `ADMIN MANAGEMENT`, `SUPERADMIN CONTROL`, `PROFILE & SETTINGS`, `USER APPLICATIONS`
- Clears the terminal screen before each menu render and each response view — clean, distraction-free UI
- Session cookie persistence via `cURL` — login state carries over across multiple requests in the same session
- Colorized JSON output: keys → cyan, strings → green, numbers → yellow, booleans → magenta, null → grey
- `Press [ENTER] to return to the menu` prompt after every response — no accidental list scroll
- Custom route entry (any path + method) for ad-hoc testing
- Registered in `kit` runner map and documented in `php kit help`

### Changed
- `routes/web/client/pages.php` — root route changed from `'/'` to `''` to align with `Router::parseUri()` normalization
- `Router.php` — added `Router::hasRoute(string $method, string $uri): bool` utility method
- Auth pages form panel background inherits from body (removes visual seam in dark mode)
- Login brand panel stat updated from `PHP 8` to `PHP 8+`

### Fixed
- Status badge in users table missing dark mode variants
- Duplicate comment in register page brand panel
- `SuperAdminAdminController` GET route mapped to `SuperAdminDashboardController::admins()` (the correct list method)
- `AppController` GET route mapped to `AppController::home()` (not the non-existent `index()`)
- `AdminDashboardController` corrected to `DashboardController` matching actual class name

[1.1.0]: https://github.com/rodrigomarcelo643/vanilla-php-mvc-starterkit/compare/v1.0.0...v1.1.0
[1.0.0]: https://github.com/rodrigomarcelo643/vanilla-php-mvc-starterkit/releases/tag/v1.0.0
