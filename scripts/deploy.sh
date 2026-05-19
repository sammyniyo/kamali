#!/usr/bin/env bash
# Run on the server from the project root after git pull.
# Usage: bash scripts/deploy.sh

set -euo pipefail

ROOT="$(cd "$(dirname "$0")/.." && pwd)"
cd "$ROOT"

echo "→ Deploying Kamali from $ROOT"

if [[ ! -f .env ]]; then
    echo "ERROR: .env missing. Copy .env.example to .env and configure it first."
    exit 1
fi

if ! command -v php >/dev/null 2>&1; then
    echo "ERROR: php not found."
    exit 1
fi

if ! command -v composer >/dev/null 2>&1; then
    echo "ERROR: composer not found."
    exit 1
fi

echo "→ composer install (production)"
composer install --no-dev --optimize-autoloader --no-interaction

if command -v npm >/dev/null 2>&1; then
    echo "→ npm install & build"
    npm ci --omit=dev 2>/dev/null || npm install --omit=dev
    npm run build
else
    echo "WARN: npm not found — run 'npm ci && npm run build' if assets are missing."
fi

echo "→ artisan maintenance"
php artisan storage:link --force 2>/dev/null || true
php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "→ permissions"
chmod -R ug+rwx storage bootstrap/cache 2>/dev/null || true

echo "✓ Deploy finished. Ensure your web server document root is: $ROOT/public"
