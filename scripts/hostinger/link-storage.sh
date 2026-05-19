#!/usr/bin/env bash
# Link public/storage → storage/app/public (or copy if symlinks are blocked).

set -euo pipefail

ROOT="$(cd "$(dirname "$0")/../.." && pwd)"
cd "$ROOT"

PHP_BIN="${PHP_BIN:-php}"

if $PHP_BIN artisan storage:link --force 2>/dev/null; then
    echo "✓ storage:link created"
    exit 0
fi

echo "Symlink failed — copying files to public/storage (Hostinger fallback)"

rm -rf public/storage
mkdir -p public/storage
cp -a storage/app/public/. public/storage/ 2>/dev/null || true

echo "✓ Files copied to public/storage"
echo "  After new uploads in admin, run this script again OR fix symlinks in hPanel."
