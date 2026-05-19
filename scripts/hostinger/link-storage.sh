#!/usr/bin/env bash
# Link or copy storage for Hostinger (exec() is often disabled — do not use artisan storage:link).

set -euo pipefail

ROOT="$(cd "$(dirname "$0")/../.." && pwd)"
cd "$ROOT"

PHP_BIN="${PHP_BIN:-php}"

echo "→ public/storage (PHP symlink or copy, no exec)"
$PHP_BIN scripts/hostinger/link-storage.php
