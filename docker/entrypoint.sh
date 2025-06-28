#!/bin/sh
set -e

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
