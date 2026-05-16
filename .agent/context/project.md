# Starter Kit — Agent Context

## Project Overview
- **Name:** Starter Kit
- **Version:** 1.0.0
- **Developer:** MarDev — Software Developer
- **Stack:** PHP 8.0+ · MySQL · Tailwind CSS 3 · Alpine.js 3
- **Pattern:** Custom MVC (no framework)
- **Auth:** Session-based with role support (`user`, `editor`, `admin`)

## Directory Map
```
Project/
├── app/
│   ├── config/         app.php, database.php  (read from .env)
│   ├── controllers/    AppController, AuthController, DashboardController,
│   │                   ErrorController, HomeController, ProfileController
│   ├── core/           Router, Controller, Model, Auth, Session, Database
│   ├── helpers/        helper.php
│   ├── models/         Admin.php, User.php
│   └── views/
│       ├── admin/      dashboard, profile, settings, users
│       ├── app/        home, profile, settings
│       ├── auth/       login, register
│       ├── client/     home, about, blog, docs, profile
│       ├── components/ admin/, app/, client/ partials
│       ├── errors/     404.php
│       └── layouts/    admin/, app/, auth/, client/ (header + footer)
├── assets/             css/, js/, images/, fonts/, vendor/
├── database/           starter.sql
├── routes/
│   ├── web.php         bootstrap + dispatch
│   └── web/
│       ├── admin.php
│       ├── app.php
│       ├── client.php
│       └── ajax.php
├── storage/            logs/, cache/, uploads/
├── .env                secrets (gitignored)
├── .env.example        template
└── index.php           entry point
```

## Core Patterns

### Adding a route
```php
// routes/web/client.php
Router::get('contact', ['HomeController', 'contact']);
```

### Adding a controller method
```php
// app/controllers/HomeController.php
public function contact(): void
{
    $this->client('client/contact', ['title' => 'Contact']);
}
```

### Adding a model query
```php
// app/models/User.php
public function findByEmail(string $email): array|false
{
    $stmt = $this->db->prepare('SELECT * FROM users WHERE email = ?');
    $stmt->execute([$email]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
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

## Environment Variables
| Key        | Description              |
|------------|--------------------------|
| APP_NAME   | Application display name |
| BASE_URL   | Subfolder path e.g. `/PHP_Sideline/Project` |
| DB_HOST    | Database host            |
| DB_NAME    | Database name            |
| DB_USER    | Database user            |
| DB_PASS    | Database password        |

## Database Tables
| Table            | Purpose                        |
|------------------|--------------------------------|
| users            | App users with roles           |
| admins           | Admin panel accounts           |
| sessions         | Session tracking               |
| password_resets  | Password reset tokens          |
| activity_logs    | User action audit trail        |

## Default Credentials (dev seed)
| Role  | Email             | Password |
|-------|-------------------|----------|
| Admin | admin@starter.com | password |
| User  | alice@example.com | password |
