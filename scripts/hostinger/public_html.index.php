<?php

/**
 * Use ONLY if Hostinger cannot set the document root to kamali/public.
 *
 * 1. Clone the repo to /home/YOUR_USER/kamali (sibling of public_html).
 * 2. Copy this file to public_html/index.php
 * 3. Copy scripts/hostinger/public_html.htaccess to public_html/.htaccess
 *    (edit paths if your folder is not named "kamali")
 */

use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

$candidates = [
    dirname(__DIR__).'/kamali',
    dirname(__DIR__, 3).'/kamali',
];
$laravelRoot = null;
foreach ($candidates as $path) {
    if (is_file($path.'/vendor/autoload.php')) {
        $laravelRoot = $path;
        break;
    }
}
if ($laravelRoot === null) {
    http_response_code(500);
    exit('Laravel root not found. Edit scripts/hostinger/public_html.index.php and set $laravelRoot.');
}

if (file_exists($maintenance = $laravelRoot.'/storage/framework/maintenance.php')) {
    require $maintenance;
}

require $laravelRoot.'/vendor/autoload.php';

(require_once $laravelRoot.'/bootstrap/app.php')
    ->handleRequest(Request::capture());
