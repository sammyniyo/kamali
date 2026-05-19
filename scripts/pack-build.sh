#!/usr/bin/env bash
# Zip Vite build for FTP if you do not deploy via git.
set -euo pipefail

ROOT="$(cd "$(dirname "$0")/.." && pwd)"
cd "$ROOT"

npm run build

cd public
zip -r "$ROOT/kamali-build.zip" build -x "*.DS_Store"
echo "Created kamali-build.zip — on server:"
echo "  cd public_html && unzip -o kamali-build.zip"
