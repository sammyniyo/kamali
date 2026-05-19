<?php

/**
 * Upload to public_html/diagnostic.php (or public_html/public/diagnostic.php)
 * Visit https://yourdomain.com/diagnostic.php — DELETE after fixing.
 */

header('Content-Type: text/plain; charset=utf-8');

echo "PHP: ".PHP_VERSION."\n";
echo "Document root: ".($_SERVER['DOCUMENT_ROOT'] ?? '?')."\n";
echo "Script: ".(__FILE__)."\n\n";

$checks = [
    'index in docroot' => is_file(($_SERVER['DOCUMENT_ROOT'] ?? '').'/index.php'),
    'public/index.php' => is_file(($_SERVER['DOCUMENT_ROOT'] ?? '').'/public/index.php'),
    'vendor (docroot)' => is_file(($_SERVER['DOCUMENT_ROOT'] ?? '').'/vendor/autoload.php'),
    'vendor (../kamali)' => is_file(dirname(__DIR__).'/kamali/vendor/autoload.php'),
    'vendor (parent)' => is_file(dirname(__DIR__).'/vendor/autoload.php'),
    'mod_rewrite' => function_exists('apache_get_modules')
        ? in_array('mod_rewrite', apache_get_modules(), true)
        : null,
];

foreach ($checks as $label => $ok) {
    $mark = $ok === true ? '[OK] ' : ($ok === null ? '[??] ' : '[--] ');
    echo $mark.$label."\n";
}

echo "\nIf [OK] public/index.php but site is 403: set document root to .../public in hPanel.\n";
echo "If Git is in public_html root: use public_html-laravel-in-root.htaccess from the repo.\n";
