# Git Hooks

This directory contains git hooks for the XPTrackr project.

## Installation

### Method 1: Using the install script (Recommended)
```bash
bash .githooks/install.sh
```

This will create symlinks from `.git/hooks/` to the hooks in this directory.

### Method 2: Configure Git to use this directory
```bash
git config core.hooksPath .githooks
```

This tells Git to look for hooks in `.githooks/` instead of `.git/hooks/`.

## Available Hooks

### pre-commit
Runs before each commit to check for:
- **Debug statements**: `dd()`, `dump()`, `var_dump()`, `print_r()`, `die()`, `exit()`, `ray()`, `ddd()`
- **PHP syntax errors**: Uses `php -l` to check for parse errors
- **Code style**: Runs Laravel Pint if available

If any check fails, the commit is aborted but your commit message is preserved.

## Bypassing Hooks

If you need to commit without running hooks (emergency fixes, etc.):
```bash
git commit --no-verify
```

## Development

To add a new hook:
1. Create the hook file in `.githooks/`
2. Make it executable: `chmod +x .githooks/hook-name`
3. Run the install script or commit and have other developers run it

## Troubleshooting

- If hooks aren't running, ensure they're executable: `chmod +x .githooks/*`
- Check that symlinks are properly created: `ls -la .git/hooks/`
- For hook debugging, add `set -x` at the top of the hook script