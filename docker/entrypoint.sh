#!/bin/sh
set -e

# Remove stale PID files that might prevent Rails from starting
if [ -f "/app/tmp/pids/server.pid" ]; then
    echo "Removing stale PID file..."
    rm -f /app/tmp/pids/server.pid
fi

# Ensure required directories exist with proper permissions
mkdir -p /app/tmp/pids
mkdir -p /app/log
mkdir -p /app/tmp/cache

# Ensure the rails user owns the app directory and subdirectories
# This is important for CI environments where volumes may have different ownership
if [ "$(id -u)" = "1000" ]; then
    # We're running as the rails user, try to fix permissions if possible
    # Only do this if we have write access to the parent directory
    if [ -w "/app" ]; then
        chmod -R 755 /app/tmp /app/log 2>/dev/null || true
    fi
fi

# Ensure bundle directory has correct permissions
# This handles cases where the volume is mounted fresh
if [ -d "${BUNDLE_PATH:-/usr/local/bundle}" ]; then
    # Check if we can write to the bundle path
    if ! touch "${BUNDLE_PATH:-/usr/local/bundle}/.write_test" 2>/dev/null; then
        echo "Warning: Bundle directory doesn't have write permissions. This might cause issues."
        echo "Consider running: docker-compose run --rm --user root backend chown -R rails:rails ${BUNDLE_PATH:-/usr/local/bundle}"
    else
        rm -f "${BUNDLE_PATH:-/usr/local/bundle}/.write_test"
    fi
fi

# Execute the original command
exec "$@"
