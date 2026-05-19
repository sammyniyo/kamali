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

COUNT=$(find "$SRC" -type f ! -name '.gitignore' | wc -l | tr -d ' ')
if [[ "$COUNT" -eq 0 ]]; then
    echo "ERROR: No uploaded files in $SRC (only .gitignore?)."
    echo "Upload images in admin on your Mac first, then run this script again."
    exit 1
fi

cd "$SRC"
zip -r "$OUT" . -x "*.DS_Store" ".gitignore"
SIZE=$(du -h "$OUT" | cut -f1)

echo "Created: $OUT ($SIZE, $COUNT files)"
echo ""
echo "On Hostinger — upload the zip to your APP ROOT (folder with artisan), then SSH:"
echo ""
echo "  cd ~/domains/YOUR_DOMAIN/public_html    # or wherever artisan lives"
echo "  unzip -o kamali-uploads.zip -d public/storage/"
echo ""
echo "Or if using storage/app/public:"
echo "  unzip -o kamali-uploads.zip -d storage/app/public/"
echo "  php scripts/hostinger/link-storage.php"
echo ""
echo "Add to .env on server (recommended, no symlinks needed):"
echo "  FILESYSTEM_PUBLIC_ROOT=/home/u736264619/domains/YOUR_DOMAIN/public_html/public/storage"
