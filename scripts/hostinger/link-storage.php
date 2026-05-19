<?php

/**
 * Create public/storage without artisan (Hostinger disables exec()).
 * Usage: php scripts/hostinger/link-storage.php
 */

$root = dirname(__DIR__, 2);
$target = $root.'/storage/app/public';
$link = $root.'/public/storage';

if (! is_dir($target)) {
    mkdir($target, 0755, true);
}

// Remove old link or directory
if (is_link($link)) {
    unlink($link);
} elseif (is_dir($link)) {
    $iterator = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($link, RecursiveDirectoryIterator::SKIP_DOTS),
        RecursiveIteratorIterator::CHILD_FIRST
    );
    foreach ($iterator as $file) {
        $file->isDir() ? rmdir($file->getPathname()) : unlink($file->getPathname());
    }
    rmdir($link);
}

if (@symlink($target, $link)) {
    echo "✓ Symlink created: public/storage → storage/app/public\n";
    exit(0);
}

echo "Symlink not allowed — copying files to public/storage\n";
if (! is_dir($link)) {
    mkdir($link, 0755, true);
}

$copyTree = function (string $from, string $to) use (&$copyTree): void {
    if (! is_dir($from)) {
        return;
    }
    if (! is_dir($to)) {
        mkdir($to, 0755, true);
    }
    foreach (scandir($from) ?: [] as $entry) {
        if ($entry === '.' || $entry === '..') {
            continue;
        }
        $src = $from.'/'.$entry;
        $dst = $to.'/'.$entry;
        if (is_dir($src)) {
            $copyTree($src, $dst);
        } elseif (is_file($src)) {
            copy($src, $dst);
        }
    }
};

$copyTree($target, $link);
echo "✓ Files copied to public/storage\n";
echo "  Tip: set FILESYSTEM_PUBLIC_ROOT in .env to your public/storage path so new admin uploads work without re-running this script.\n";
