# Security Policy

## Supported Versions

| Version | Supported |
|---------|-----------|
| 1.x     | ✅ Yes    |

---

## Reporting a Vulnerability

**Do not open a public GitHub issue for security vulnerabilities.**

Report vulnerabilities privately by emailing the maintainer or using [GitHub's private vulnerability reporting](https://github.com/rodrigomarcelo643/php-vanilla-mvc-starterkit/security/advisories/new).

Include:
- A clear description of the vulnerability
- Steps to reproduce
- Potential impact
- Any suggested fix (optional)

You will receive a response within **72 hours**. If confirmed, a patch will be released as soon as possible and credited to you (unless you prefer to remain anonymous).

---

## Security Practices in This Project

- Passwords are hashed with **bcrypt** via `password_hash()` — never stored in plain text.
- All database queries use **PDO prepared statements** — no raw string interpolation.
- Password reset tokens are **single-use** and expire after **1 hour**.
- User input rendered in views is escaped with `htmlspecialchars()`.
- Credentials and secrets are loaded from **`.env`** — never hardcoded.
- The `.env` file is listed in `.gitignore` and never committed.
- The `storage/uploads/` directory has an `.htaccess` that blocks direct PHP execution.

---

## Recommendations for Deployment

- Always set `APP_ENV=production` and disable PHP error display in production.
- Use HTTPS — never serve this application over plain HTTP.
- Restrict database user permissions to only what the app needs (SELECT, INSERT, UPDATE, DELETE).
- Rotate `DB_PASS` and mail credentials regularly.
- Enable the `secret-scan.yml` GitHub Actions workflow to catch accidental credential commits.
