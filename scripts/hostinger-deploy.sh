#!/usr/bin/env bash
# Hostinger shared hosting — run via SSH from the project root.
# Usage: bash scripts/hostinger-deploy.sh

set -euo pipefail

ROOT="$(cd "$(dirname "$0")/.." && pwd)"
cd "$ROOT"

echo "→ Hostinger deploy: $ROOT"

if [[ ! -f .env ]]; then
    echo "ERROR: .env missing. Create it in hPanel File Manager or: cp .env.example .env"
    exit 1
fi

PHP_BIN="${PHP_BIN:-php}"

# Hostinger often uses a specific PHP binary, e.g.:
# PHP_BIN=/opt/alt/php82/usr/bin/php bash scripts/hostinger-deploy.sh

if [[ -f composer.phar ]]; then
    COMPOSER="$PHP_BIN composer.phar"
elif command -v composer >/dev/null 2>&1; then
    COMPOSER="composer"
else
    echo "→ Downloading composer.phar"
    $PHP_BIN -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
    $PHP_BIN composer-setup.php --quiet
    rm -f composer-setup.php
    COMPOSER="$PHP_BIN composer.phar"
fi

echo "→ composer install"
$COMPOSER install --no-dev --optimize-autoloader --no-interaction

if command -v npm >/dev/null 2>&1; then
    echo "→ npm build"
    npm ci --omit=dev 2>/dev/null || npm install --omit=dev
    npm run build
else
    echo "WARN: npm not found. Build on your Mac (npm run build) and upload public/build/ via FTP."
fi

echo "→ storage (link or copy for shared hosting)"
bash scripts/hostinger/link-storage.sh
$PHP_BIN artisan migrate --force
$PHP_BIN artisan config:cache
$PHP_BIN artisan route:cache
$PHP_BIN artisan view:cache

chmod -R ug+rwx storage bootstrap/cache 2>/dev/null || true

echo "✓ Done. Document root must point to: $ROOT/public"
