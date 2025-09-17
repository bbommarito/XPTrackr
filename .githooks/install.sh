#!/bin/bash

# Colors for output
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
RED='\033[0;31m'
NC='\033[0m' # No Color

echo "🔧 Installing Git hooks..."

# Get the git directory
GIT_DIR=$(git rev-parse --git-dir 2> /dev/null)

if [ -z "$GIT_DIR" ]; then
    echo "${RED}Error: Not in a git repository${NC}"
    exit 1
fi

HOOKS_DIR="$GIT_DIR/hooks"
PROJECT_HOOKS_DIR=".githooks"

# Create hooks directory if it doesn't exist
mkdir -p "$HOOKS_DIR"

# Function to install a hook
install_hook() {
    local hook_name=$1
    local source_file="$PROJECT_HOOKS_DIR/$hook_name"
    local target_file="$HOOKS_DIR/$hook_name"
    
    if [ -f "$source_file" ]; then
        # Remove existing hook or backup
        if [ -f "$target_file" ]; then
            if [ -L "$target_file" ]; then
                echo "  Removing existing symlink for $hook_name"
                rm "$target_file"
            else
                echo "  Backing up existing $hook_name to $hook_name.backup"
                mv "$target_file" "$target_file.backup"
            fi
        fi
        
        # Create symlink
        ln -s "../../$source_file" "$target_file"
        chmod +x "$source_file"
        echo "${GREEN}  ✓ Installed $hook_name${NC}"
    fi
}

# Install all hooks
for hook in "$PROJECT_HOOKS_DIR"/*; do
    if [ -f "$hook" ] && [ "${hook##*/}" != "install.sh" ] && [ "${hook##*/}" != "README.md" ]; then
        install_hook "${hook##*/}"
    fi
done

echo ""
echo "${GREEN}✅ Git hooks installed successfully!${NC}"
echo ""
echo "To uninstall, run:"
echo "  rm $GIT_DIR/hooks/pre-commit"
echo ""
echo "${YELLOW}Note: You can also configure Git to use the .githooks directory directly:${NC}"
echo "  git config core.hooksPath .githooks"