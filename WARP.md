# WARP.md

This file provides guidance to WARP (warp.dev) when working with code in this repository.

## Project Overview

XPTrackr is a Laravel 12 application using:
- PHP 8.2+
- Vite for asset compilation
- Tailwind CSS (v4) for styling
- Pest for testing
- Laravel Pint for code formatting
- SQLite as the default database

## Essential Commands

### Development Environment

**Start the full development environment:**
```bash
composer run dev
```
This runs concurrently: Laravel server, queue worker, Pail logs, and Vite dev server.

**Install dependencies:**
```bash
composer install
npm install
```

**Set up the application:**
```bash
cp .env.example .env
php artisan key:generate
php artisan migrate
```

### Testing

**Run all tests:**
```bash
composer test
# or
php artisan test
```

**Run a specific test file:**
```bash
php artisan test tests/Feature/ExampleTest.php
```

**Run tests with coverage:**
```bash
php artisan test --coverage
```

### Code Quality

**Format code with Laravel Pint:**
```bash
./vendor/bin/pint
```

**Format specific file:**
```bash
./vendor/bin/pint app/Http/Controllers/Controller.php
```

### Build & Assets

**Build for production:**
```bash
npm run build
```

**Watch for development:**
```bash
npm run dev
```

### Database

**Run migrations:**
```bash
php artisan migrate
```

**Rollback migrations:**
```bash
php artisan migrate:rollback
```

**Fresh database with seeds:**
```bash
php artisan migrate:fresh --seed
```

### Artisan Commands

**Create a new controller:**
```bash
php artisan make:controller NameController
```

**Create a new model with migration:**
```bash
php artisan make:model ModelName -m
```

**Clear all caches:**
```bash
php artisan optimize:clear
```

## Architecture Overview

### Directory Structure

```
XPTrackr/
├── app/                    # Application code
│   ├── Http/              # HTTP layer (Controllers, Middleware)
│   ├── Models/            # Eloquent models
│   └── Providers/         # Service providers
├── bootstrap/             # Framework bootstrap files
├── config/                # Configuration files
├── database/              # Database migrations, factories, seeders
├── public/                # Public assets and entry point
├── resources/             # Views, raw assets (CSS, JS)
├── routes/                # Application routes
│   ├── web.php           # Web routes
│   └── console.php       # Console commands
├── storage/               # Compiled files, logs, uploads
├── tests/                 # Test files (Pest)
│   ├── Feature/          # Feature tests
│   └── Unit/             # Unit tests
└── vendor/                # Composer dependencies
```

### Key Concepts

1. **MVC Pattern**: Laravel follows Model-View-Controller pattern
   - Models in `app/Models/`
   - Views in `resources/views/`
   - Controllers in `app/Http/Controllers/`

2. **Routing**: All web routes defined in `routes/web.php`

3. **Database**: Uses Eloquent ORM with migrations in `database/migrations/`

4. **Frontend**: Vite handles asset compilation with entry points:
   - CSS: `resources/css/app.css`
   - JS: `resources/js/app.js`

5. **Testing**: Pest PHP testing framework with tests organized in:
   - Feature tests: End-to-end application testing
   - Unit tests: Individual component testing

6. **Service Container**: Laravel's dependency injection container manages class dependencies

7. **Middleware**: HTTP middleware for filtering requests in `app/Http/Middleware/`

### Development Workflow

1. Routes define application endpoints (`routes/web.php`)
2. Controllers handle requests and return responses
3. Models interact with database through Eloquent ORM
4. Views render HTML responses (Blade templating)
5. Migrations manage database schema changes
6. Tests ensure code quality and functionality

### Configuration

- Environment variables in `.env` file
- Application config in `config/` directory
- Database uses SQLite by default (created automatically)

### Queue System

Laravel's queue system is configured and can be used for background jobs. The development command automatically starts a queue listener.

### Logging

Logs are available through Laravel Pail in development (automatically tailed with `composer run dev`) or in `storage/logs/`.
