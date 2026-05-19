#!/usr/bin/env bash
# Show the latest Laravel error (run on server via SSH).

ROOT="$(cd "$(dirname "$0")/../.." && pwd)"
LOG="$ROOT/storage/logs/laravel.log"

if [[ ! -f "$LOG" ]]; then
    echo "No log at $LOG"
    echo "Try: chmod -R 775 storage && visit the site once"
    exit 1
fi

tail -80 "$LOG"
