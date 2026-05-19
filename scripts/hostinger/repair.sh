#!/usr/bin/env bash
# Fix common Hostinger 500 errors. Run from app root (where artisan lives).

set -euo pipefail

ROOT="$(cd "$(dirname "$0")/../.." && pwd)"
cd "$ROOT"
PHP_BIN="${PHP_BIN:-php}"

echo "→ App root: $ROOT"
echo "→ PHP: $($PHP_BIN -v | head -1)"

if [[ ! -f public/build/manifest.json ]]; then
    echo ""
    echo "ERROR: Missing public/build/manifest.json (causes 500)."
    echo "  On your Mac: npm run build && git push"
    echo "  Or: bash scripts/pack-build.sh, upload kamali-build.zip, unzip in public/"
    exit 1
fi

if [[ ! -f .env ]]; then
    echo "ERROR: .env missing"
    exit 1
fi

if ! grep -q '^APP_KEY=base64:' .env 2>/dev/null; then
    echo "→ Generating APP_KEY"
    $PHP_BIN artisan key:generate --force
fi

echo "→ Clear cached config (fixes wrong paths from local Mac)"
$PHP_BIN artisan config:clear
$PHP_BIN artisan route:clear
$PHP_BIN artisan view:clear
rm -f bootstrap/cache/config.php bootstrap/cache/routes-v7.php bootstrap/cache/events.php 2>/dev/null || true

echo "→ Permissions"
chmod -R 775 storage bootstrap/cache 2>/dev/null || true

echo "→ Database migrate + seed"
$PHP_BIN artisan migrate --force
$PHP_BIN artisan db:seed --force

echo "→ Storage"
$PHP_BIN scripts/hostinger/link-storage.php

echo "→ Rebuild caches"
$PHP_BIN artisan config:cache
$PHP_BIN artisan route:cache
$PHP_BIN artisan view:cache

echo ""
echo "✓ Repair done. If still 500, run:"
echo "  tail -50 storage/logs/laravel.log"
