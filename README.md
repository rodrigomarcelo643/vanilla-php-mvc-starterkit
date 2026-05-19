<div align="center">

![Version](https://img.shields.io/badge/version-1.1.0-4F46E5?style=for-the-badge)
![PHP](https://img.shields.io/badge/PHP-8.0+-777BB4?style=for-the-badge&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-5.7+-4479A1?style=for-the-badge&logo=mysql&logoColor=white)
![TailwindCSS](https://img.shields.io/badge/Tailwind_CSS-3.x-06B6D4?style=for-the-badge&logo=tailwindcss&logoColor=white)
![Alpine.js](https://img.shields.io/badge/Alpine.js-3.x-8BC0D0?style=for-the-badge&logo=alpine.js&logoColor=white)
![PHPUnit](https://img.shields.io/badge/PHPUnit-11.x-3F9142?style=for-the-badge&logo=php&logoColor=white)
![Tests](https://img.shields.io/badge/tests-77%20passing-22C55E?style=for-the-badge)

# 🚀 Vanilla PHP MVC Starter Kit

### A clean PHP 8+ MVC boilerplate with a structured `js/` layer, split route files, super admin + admin panels, session auth with live password strength validation, role-based routing, AJAX fetch helpers, Alpine.js reactive UI, Tailwind CSS, and PHPUnit — zero frameworks, zero fluff.

[⭐ Star on GitHub](https://github.com/rodrigomarcelo643/php-vanilla-mvc-starterkit) · [📖 Docs](#️-installation) · [🧪 Tests](#-testing)

</div>

---

## 📌 About

**Vanilla PHP MVC Starter Kit** is a lightweight, zero-framework boilerplate for developers who want a clean starting point without the overhead of Laravel or Symfony. Built on pure PHP 8+, it ships with a hand-rolled MVC architecture, session-based authentication, role-based routing, and a full admin panel — all wired up and ready to go.

The frontend uses Tailwind CSS and Alpine.js via CDN, so there's no build pipeline to configure. AJAX helpers, avatar uploads, password reset flow, and a responsive multi-panel layout (super admin, admin, app, client) are included out of the box.

Backed by PHPUnit with 77 tests across unit and feature suites, GitHub Actions workflows for linting, quality checks, and deployment, and a single SQL file to get your database running in minutes.

**Start building in minutes, not hours.**

### What's included

- **Multi-panel layout** — Super Admin, Admin, App (authenticated users), and Client (public) views
- **Session authentication** — Login, registration, logout, and password reset out of the box
- **Role-based routing** — Segregated routes for super admin, admin, app, client, and AJAX calls
- **Super admin panel** — Highest-privilege panel with admin management, full user CRUD, purple-accented UI
- **Full admin panel** — Collapsible sidebar, topbar, user management, and data tables
- **AJAX helpers** — Lightweight fetch wrappers for POST/GET with JSON responses
- **Avatar uploads** — Image preview, crop, and AJAX upload built in
- **Environment config** — `.env`-driven configuration, no hardcoded credentials
- **Tailwind CSS + Alpine.js** — Modern UI via CDN, no build step required
- **Composer managed** — PHPMailer, PHPUnit, and more via a clean `composer.json`
- **77 PHPUnit tests** — Unit and feature suites with automatic cleanup

---

## 🖼️ UI Visuals

<div align="center">

**Home**
![Home](public/starter_home.png)

**Sign In**
![Sign In](public/starter_login.png)

**Sign Up**
![Sign Up](public/starter_signup.png)

**Forgot Password**
![Forgot Password](public/starter_forgot_password.png)

**Admin Dashboard**
![Admin Dashboard](public/starter_admin.png)

**User Panel**
![User Panel](public/starter_user.png)

</div>

> See the full visual walkthrough in [VISUALS.md](VISUALS.md)

---

## 📁 Project Structure

```
starterkit/
├── app/
│   ├── config/         # App, database & mail config (reads from .env)
│   ├── controllers/    # MVC controllers
│   │   └── superadmin/ # SuperAdminDashboardController, SuperAdminAdminController
│   ├── core/           # Router, Model, Auth, Session, Database, Mailer
│   ├── helpers/        # Global helper functions
│   ├── models/         # Data models (User, Admin, SuperAdmin, PasswordReset)
│   └── views/          # Layouts, components & pages (superadmin/admin/app/client/auth)
├── assets/             # CSS & fonts
├── database/
│   └── starter.sql     # Database schema + seed data
├── js/
│   ├── admin/          # Admin-specific JS (admin.js, users.js)
│   ├── ajax.js         # Fetch wrapper (Ajax.post / Ajax.get)
│   ├── app.js          # Global utilities (toast, alert, setLoading)
│   ├── auth.js         # Auth form handlers + strength meter
│   ├── avatar.js       # Avatar upload with drag & drop + XHR progress
│   ├── logout.js       # Logout confirmation modal
│   ├── profile.js      # Profile edit + change password handlers
│   ├── settings.js     # Settings page theme sync
│   ├── sidebar.js      # Sidebar keyboard shortcut (Ctrl+B)
│   └── theme.js        # Dark/light mode toggle
├── routes/
│   ├── web.php         # Entry point — loads all route files
│   └── web/
│       ├── superadmin/ # Super admin page + AJAX routes
│       ├── admin/      # Admin page + AJAX routes
│       ├── app/        # Authenticated user page + AJAX routes
│       ├── auth/       # Auth page + AJAX routes
│       └── client/     # Public/client page routes
├── storage/            # Uploads
├── tests/              # PHPUnit unit & feature suites
├── .agent/             # AI coding assistant context & prompt templates
├── .claude/            # Claude/Cursor context file
├── .github/workflows/  # CI/CD workflows
├── .env.example        # Environment template
├── .htaccess           # URL rewriting
├── composer.json       # Dependencies
└── index.php           # Application entry point
```

---

## ⚙️ Installation

### Requirements

- PHP **8.0+**
- MySQL **5.7+**
- Apache with **mod_rewrite** enabled (XAMPP / Laragon / WAMP)
- Composer

### Steps

**1. Clone the repository**

```bash
git clone https://github.com/rodrigomarcelo643/php-vanilla-mvc-starterkit.git
```

Place it inside your server's web root (e.g. `htdocs/` or `www/`).

**2. Install dependencies**

```bash
composer install
```

**3. Set up the database**

- Open **phpMyAdmin**
- Go to **Import** and select `database/starter.sql`
- This creates the `starter` database with tables and seed data

**4. Configure environment**

```bash
cp .env.example .env
```

Edit `.env` with your values:

```env
APP_NAME="Starter Kit"
BASE_URL="/your-folder-path"

DB_HOST=localhost
DB_NAME=starter
DB_USER=root
DB_PASS=
```

**5. Visit the app**

```
http://localhost/your-folder-path
```

### Default Credentials

| Role        | Email                    | Password |
| ----------- | ------------------------ | -------- |
| Super Admin | superadmin@starter.com   | password |
| Admin       | admin@starter.com        | password |
| User        | alice@example.com        | password |

---

## 🗺️ Routes Overview

| File              | Prefix          | Description                            |
| ----------------- | --------------- | -------------------------------------- |
| `client.php`      | `/`             | Public pages (home, about, blog…)      |
| `superadmin/pages.php` | `superadmin/` | Super admin dashboard, admins, users |
| `superadmin/ajax.php`  | `ajax/admins/` | Admin CRUD AJAX endpoints            |
| `admin.php`       | `admin/`        | Admin dashboard, users, settings       |
| `app.php`         | `app/`          | Authenticated user pages               |
| `ajax.php`        | `ajax/`         | Login, register + AJAX endpoints       |

---

## 👑 Super Admin Panel

The super admin is the highest-privilege role in the system. It has its own dedicated panel at `/superadmin/dashboard` with a purple-accented UI to distinguish it from the regular admin panel.

### What super admin can do

- **Dashboard** — Overview stats: total users, active/inactive users, total admins, new this month
- **Manage Admins** — Full CRUD: create, edit, delete admin accounts (`super_admins` table)
- **Manage Users** — Full CRUD on all user accounts (same as admin panel)
- **Profile** — Update name, email, avatar, and password
- **Settings** — Appearance and notification preferences

### Database table

Super admins are stored in a dedicated `super_admins` table, separate from both `users` and `admins`.

```sql
CREATE TABLE `super_admins` (
    `id`         INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `name`       VARCHAR(100) NOT NULL,
    `email`      VARCHAR(150) NOT NULL,
    `password`   VARCHAR(255) NOT NULL,
    `avatar`     VARCHAR(255) DEFAULT NULL,
    `status`     ENUM('active','inactive') NOT NULL DEFAULT 'active',
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `uq_super_admins_email` (`email`)
);
```

### New files added

```
app/models/SuperAdmin.php
app/controllers/superadmin/SuperAdminDashboardController.php
app/controllers/superadmin/SuperAdminAdminController.php
app/views/layouts/superadmin/header.php
app/views/layouts/superadmin/footer.php
app/views/components/superadmin/sidebar.php
app/views/components/superadmin/topbar.php
app/views/superadmin/dashboard.php
app/views/superadmin/admins.php
app/views/superadmin/users.php
app/views/superadmin/profile.php
app/views/superadmin/settings.php
routes/web/superadmin/pages.php
routes/web/superadmin/ajax.php
```

### Modified files

| File | Change |
|---|---|
| `app/core/Controller.php` | Added `superadmin()` layout method |
| `app/core/Router.php` | Added `app/controllers/superadmin/` to auto-discovery |
| `app/models/Admin.php` | Added `update()`, `delete()`, `adminCreate()` methods |
| `app/controllers/auth/AuthController.php` | Login checks `super_admins` table, redirects to `/superadmin/dashboard` |
| `app/controllers/auth/ProfileController.php` | Avatar upload, profile update, and password change support `superadmin` role |
| `app/controllers/admin/UserController.php` | Guard allows both `admin` and `superadmin` roles |
| `routes/web.php` | Loads super admin page + AJAX route files |
| `database/starter.sql` | Added `super_admins` table + seed account |

---

## 🧪 Testing

The project uses **PHPUnit 11** with 77 tests and 98 assertions across two suites.

```
tests/
├── bootstrap.php               — loads .env, constants, and core classes for CLI
├── unit/
│   ├── RouterTest.php          — URI parsing, query strings, trailing slashes, isAjax, route registration
│   ├── AuthSessionTest.php     — Auth::check, Session set/get/destroy, edge payloads
│   └── HelperTest.php          — dd() output wrapping, types, nested arrays
└── feature/
    ├── UserModelTest.php       — create, findByEmail, findById, emailExists, count, getAll, default role/status
    ├── AdminModelTest.php      — findByEmail, role normalization, password verify, getAll
    └── AuthValidationTest.php  — login/register validation, bcrypt, role redirects, inactive status
```

| Suite | Tests | Needs DB |
|---|---|---|
| Unit | 32 | No |
| Feature | 45 | Yes |
| **Total** | **77** | — |

### Running tests

```bash
# All tests
php vendor/phpunit/phpunit/phpunit

# Unit only (no database required)
php vendor/phpunit/phpunit/phpunit --testsuite Unit

# Feature only (requires MySQL running with .env credentials)
php vendor/phpunit/phpunit/phpunit --testsuite Feature
```

Or via Composer:

```bash
composer test           # all
composer test:unit      # unit only
composer test:feature   # feature only
```

Feature tests hit the real database. Make sure your `.env` credentials are correct and `database/starter.sql` has been imported before running the feature suite. Test data is created and cleaned up automatically — no permanent records are left behind.

---

## ⚙️ GitHub Workflows

All workflows live in `.github/workflows/` and are **inactive by default** — they only run when manually triggered via **Actions → Run workflow**. Uncomment the `push`/`pull_request` triggers inside each file to activate them.

| File | Purpose | Activate on |
|---|---|---|
| `php-lint.yml` | Syntax-checks every `.php` file with `php -l` | push / PR |
| `php-quality.yml` | PHPMD mess detection + PHPCS PSR-12 style check on `app/` | push / PR |
| `secret-scan.yml` | Gitleaks scan for hardcoded credentials and API keys | push / PR |
| `sql-validate.yml` | Imports `database/starter.sql` into MySQL and verifies all tables | SQL file changes |
| `deploy.yml` | rsync deploy to remote server over SSH | push to main |

### Enabling a workflow

1. Open the workflow file in `.github/workflows/`
2. Uncomment the `push` / `pull_request` block under `on:`
3. Commit and push — GitHub Actions picks it up automatically

### Deploy secrets

Before enabling `deploy.yml`, add these in **Settings → Secrets → Actions**:

| Secret | Value |
|---|---|
| `SSH_HOST` | Server IP or hostname |
| `SSH_USER` | SSH username |
| `SSH_PRIVATE_KEY` | Contents of your `id_rsa` private key |
| `DEPLOY_PATH` | Absolute path on server e.g. `/var/www/html/project` |

---

## 🤖 Agent Context (AI Coding Assistant)

This project ships with ready-made context files for AI coding assistants so they understand the architecture, conventions, and patterns without you having to explain them every time.

```
.claude/
└── CLAUDE.md             # Context file for Claude (Cursor, Claude.ai)

.agent/
├── context/
│   └── project.md        # Universal project map — stack, patterns, DB, env vars
└── prompts/
    ├── scaffold-feature.md   # Prompt template: new controller + view + route
    ├── scaffold-model.md     # Prompt template: new model with CRUD methods
    ├── scaffold-ajax.md      # Prompt template: new AJAX POST endpoint
    └── debug-review.md       # Prompt templates: debug routes, views, controllers
```

- **Claude / Cursor** — paste or reference `.claude/CLAUDE.md` at the start of a session
- **Any agent** — point it to `.agent/context/project.md` for the full project map
- **Prompt templates** — copy a template from `.agent/prompts/`, fill in the placeholders, and send it to your agent

---

<div align="center">

![Built with ❤️](https://img.shields.io/badge/built_with-❤️-E11D48?style=for-the-badge)
![MarDev](https://img.shields.io/badge/developed_by-MarDev-4F46E5?style=for-the-badge)

**Developed by [MarDev](https://github.com/rodrigomarcelo643) — Software Developer**

</div>
