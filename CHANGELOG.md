# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/) and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

---

## [Unreleased]

### Added
- Dark mode support across all views (admin, app, client, auth)
- Toggle switch for dark/light mode in settings (admin + app)
- Vertical divider between brand panel and form panel on all auth pages
- Avatar image display in admin users table with initial fallback
- `avatar` column included in `User::getAll()` query

### Changed
- Auth pages (login, register, forgot-password, reset-password) form panel background inherits from body to remove visual seam in dark mode
- Login brand panel stat updated from `PHP 8` to `PHP 8+`

### Fixed
- Status badge in users table missing dark mode variants
- Duplicate comment in register page brand panel

---

## [1.0.0] — 2025-01-01

### Added
- PHP 8+ vanilla MVC architecture (Router, Controller, Model, Auth, Session, Database, Mailer)
- Session-based authentication — login, register, logout, password reset
- Role-based routing — admin, app, client, and AJAX route groups
- Full admin panel — collapsible sidebar, topbar, user management, data tables
- App panel — authenticated user home, profile, settings
- Client panel — public home, about, blog, docs pages
- Avatar upload with image preview and AJAX crop
- `.env`-driven configuration — no hardcoded credentials
- Tailwind CSS + Alpine.js via CDN — no build step
- PHPUnit 11 test suite — 77 tests across unit and feature suites
- GitHub Actions workflows — lint, quality, secret scan, SQL validate, deploy
- Composer managed — PHPMailer, PHPUnit
- AI assistant context files — `.agent/` and `.claude/`

[Unreleased]: https://github.com/rodrigomarcelo643/php-vanilla-mvc-starterkit/compare/v1.0.0...HEAD
[1.0.0]: https://github.com/rodrigomarcelo643/php-vanilla-mvc-starterkit/releases/tag/v1.0.0
