# Getting Started with XPTrackr

XPTrackr is a gamified habit tracker that uses XP and currency systems to make building habits engaging and rewarding.

## Prerequisites

- Docker and Docker Compose
- Git

## Initial Setup

1. **Clone the repository**
   ```bash
   git clone <repository-url>
   cd XPTrackr
   ```

2. **Set up environment variables**
   ```bash
   cp .env.sample .env
   ```
   
   Edit `.env` and update any values as needed, especially:
   - Generate a new `SECRET_KEY_BASE` with: `docker-compose run --rm backend ./bin/rails secret`

3. **Set up development tools (optional)**
   ```bash
   ln -s Makefile.sample Makefile
   ```
   This symlinks the sample Makefile, providing convenient shortcuts for common Docker commands.

## Running the Application

1. **Start the services**
   ```bash
   docker-compose up
   # Or with Makefile: make up
   ```

2. **Create and migrate the database** (in a new terminal)
   ```bash
   docker-compose exec backend ./bin/rails db:create
   docker-compose exec backend ./bin/rails db:migrate
   # Or with Makefile: make migrate
   ```

3. **Visit the application**
   Open [http://localhost:3000](http://localhost:3000) in your browser

## Development Workflow

### Common Commands

| Task | Docker Compose Command | Makefile Shortcut |
|------|------------------------|-------------------|
| Start services | `docker-compose up` | `make up` |
| Stop services | `docker-compose down` | `make down` |
| Rails console | `docker-compose exec backend ./bin/rails console` | `make console` |
| Run migrations | `docker-compose exec backend ./bin/rails db:migrate` | `make migrate` |
| Run tests | `docker-compose exec -e RAILS_ENV=test backend ./bin/rails test` | `make test` |
| Bundle install | `docker-compose exec backend bundle install` | `make bundle` |
| View logs | `docker-compose logs -f backend` | `make logs` |

### Database Management

**Create databases for all environments:**
```bash
# Development (default)
docker-compose exec backend ./bin/rails db:create

# Test environment  
docker-compose exec -e RAILS_ENV=test backend ./bin/rails db:create
docker-compose exec -e RAILS_ENV=test backend ./bin/rails db:migrate
```

**Reset database:**
```bash
docker-compose exec backend ./bin/rails db:reset
# Or: make reset
```

### Running Tests

```bash
# Run all tests
docker-compose exec -e RAILS_ENV=test backend ./bin/rails test
# Or: make test

# Make sure test database is migrated first
docker-compose exec -e RAILS_ENV=test backend ./bin/rails db:migrate
# Or: make test-migrate
```

### Generating Code

```bash
# Generate a model
docker-compose exec backend ./bin/rails generate model User name:string email:string
# Or: make gen-model name=User fields="name:string email:string"

# Generate a controller
docker-compose exec backend ./bin/rails generate controller Users
# Or: make gen-controller name=Users

# Generate a migration
docker-compose exec backend ./bin/rails generate migration AddAgeToUsers age:integer
# Or: make gen-migration name=AddAgeToUsers
```

## Project Structure

```
XPTrackr/
├── backend/                 # Rails application
│   ├── app/                # Application code
│   ├── config/             # Configuration files
│   ├── db/                 # Database migrations and schema
│   └── ...
├── doc/                    # Documentation
│   └── GETTING_STARTED.md # This file
├── docker/                 # Docker configuration
│   └── Dockerfile.rails    # Rails container definition
├── docker-compose.yml      # Development environment setup
├── .env.sample            # Environment variables template
└── Makefile.sample        # Development shortcuts template
```

## Environment Management

The application uses a clever database configuration that automatically handles different environments:

- **Development**: Uses `xptrackr_development` database
- **Test**: Uses `xptrackr_test` database  
- **Production**: Uses `xptrackr_production` database

All using the same PostgreSQL instance but different database names based on the `RAILS_ENV`.

## Troubleshooting

### Services won't start
```bash
# Check if ports are in use
docker-compose ps
docker ps

# Rebuild containers if needed
docker-compose build --no-cache
```

### Database connection issues
```bash
# Make sure database service is running
docker-compose up db

# Check database logs
docker-compose logs db
```

### Permission issues
```bash
# Reset Docker volumes if needed
docker-compose down -v
docker-compose up
```

### Clear everything and start fresh
```bash
docker-compose down -v --remove-orphans
docker-compose build --no-cache
docker-compose up
```

## Development Tips

1. **Use the Makefile**: If you symlinked `Makefile.sample` to `Makefile`, you can run `make help` to see all available shortcuts.

2. **Multiple terminals**: Keep one terminal running `docker-compose up` for logs, and use another for running commands.

3. **Database changes**: After pulling changes that include migrations, run:
   ```bash
   make migrate
   make test-migrate  # Don't forget the test database!
   ```

4. **Adding gems**: After modifying the Gemfile:
   ```bash
   make bundle
   docker-compose restart backend
   ```

## Next Steps

- Read the main README for architecture and design decisions
- Check out the Rails application in the `backend/` directory
- Start building features! The foundation is ready for your habit-tracking magic.

## Getting Help

- Check Docker logs: `make logs` or `docker-compose logs backend`
- Access Rails console: `make console` or `docker-compose exec backend ./bin/rails console`
- Reset everything: `make down` then `make up` with fresh database creation
