#!/usr/bin/env bash
# Zip local uploads for FTP upload to Hostinger.
# Usage: bash scripts/pack-uploads.sh

set -euo pipefail

ROOT="$(cd "$(dirname "$0")/.." && pwd)"
SRC="$ROOT/storage/app/public"
OUT="$ROOT/kamali-uploads.zip"

if [[ ! -d "$SRC" ]]; then
    echo "No uploads at $SRC"
    exit 1
fi

cd "$SRC"
zip -r "$OUT" . -x "*.DS_Store"
echo "Created: $OUT"
echo ""
echo "On Hostinger (SSH):"
echo "  cd ~/kamali   # your app root"
echo "  unzip -o kamali-uploads.zip -d storage/app/public/"
echo "  bash scripts/hostinger/link-storage.sh"
