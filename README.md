# XPTrackr

A Laravel application for tracking experience points and user progression.

## About XPTrackr

XPTrackr is a web application built with Laravel that provides:

- Magic link authentication (passwordless login)
- User progression tracking with XP and levels
- Clean, modern UI built with Tailwind CSS
- Comprehensive test coverage with Pest and Laravel Dusk

## Getting Started

### Requirements

- PHP 8.2+
- MySQL 8.0+
- Node.js 18+
- Composer

### Installation

1. Clone the repository
2. Install dependencies:
   ```bash
   composer install
   npm install
   ```
3. Copy `.env.example` to `.env` and configure your database
4. Generate application key:
   ```bash
   php artisan key:generate
   ```
5. Run migrations:
   ```bash
   php artisan migrate
   ```
6. Build assets:
   ```bash
   npm run build
   ```

### Development Setup

#### Git Hooks

This project uses git hooks to maintain code quality. See [.githooks/README.md](.githooks/README.md) for setup instructions.

To install the hooks:
```bash
bash .githooks/install.sh
```

### Testing

Run the test suite:
```bash
php artisan test
```

Run browser tests with Dusk:
```bash
php artisan dusk
```

## Contributing

Contributions are welcome! Please ensure:

1. All tests pass
2. Code follows PSR-12 standards (run `./vendor/bin/pint`)
3. No debug statements are committed (enforced by pre-commit hooks)
4. New features include appropriate tests

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
