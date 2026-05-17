# Contributing

Thanks for taking the time to contribute to PHP Vanilla MVC Starter Kit.

---

## Before You Start

- Check [open issues](https://github.com/rodrigomarcelo643/php-vanilla-mvc-starterkit/issues) before opening a new one.
- For large changes, open an issue first to discuss the approach.
- All contributions must target the `master` branch via a pull request.

---

## Setup

```bash
git clone https://github.com/rodrigomarcelo643/php-vanilla-mvc-starterkit.git
cd php-vanilla-mvc-starterkit
composer install
cp .env.example .env
# Edit .env with your local DB credentials
# Import database/starter.sql via phpMyAdmin
```

---

## Workflow

1. Fork the repo and create a branch from `master`:
   ```bash
   git checkout -b feat/your-feature
   ```
2. Make your changes following the conventions below.
3. Run the test suite before pushing:
   ```bash
   composer test
   ```
4. Push your branch and open a pull request.

---

## Branch Naming

| Type | Pattern | Example |
|------|---------|---------|
| Feature | `feat/<name>` | `feat/dark-mode` |
| Bug fix | `fix/<name>` | `fix/login-redirect` |
| Chore | `chore/<name>` | `chore/update-deps` |
| Docs | `docs/<name>` | `docs/readme-update` |

---

## Commit Messages

Follow [Conventional Commits](https://www.conventionalcommits.org/):

```
feat(scope): short description
fix(scope): short description
chore: short description
docs: short description
refactor(scope): short description
test(scope): short description
```

Examples:
```
feat(auth): add remember me checkbox to login form
fix(router): handle trailing slash on nested routes
chore: update PHPUnit to 11.x
```

---

## Code Style

- **PHP** — PSR-12. Run `composer lint` to check.
- **HTML/Views** — Tailwind utility classes, no inline `style` unless unavoidable.
- **JavaScript** — Vanilla JS or Alpine.js only, no external frameworks.
- No hardcoded credentials, URLs, or environment-specific values — use `.env`.

---

## Project Structure

```
app/controllers/   — MVC controllers
app/core/          — Router, Model, Auth, Session, Database, Mailer
app/models/        — Data models
app/views/         — Layouts, components, pages (admin/app/client/auth)
routes/web/        — Route files (admin, app, client, ajax)
tests/             — PHPUnit unit and feature suites
assets/            — CSS, JS
database/          — starter.sql schema and seed
```

---

## Tests

- Unit tests live in `tests/unit/` — no database required.
- Feature tests live in `tests/feature/` — require a running MySQL instance with `.env` credentials.
- Test data is created and cleaned up automatically.

```bash
composer test          # all tests
composer test:unit     # unit only
composer test:feature  # feature only
```

---

## Pull Request Checklist

- [ ] Branch is up to date with `master`
- [ ] Tests pass (`composer test`)
- [ ] No hardcoded credentials or debug output left in
- [ ] CHANGELOG.md updated under `[Unreleased]`
- [ ] PR description explains what changed and why
