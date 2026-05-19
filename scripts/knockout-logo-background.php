<?php

/**
 * Dark / near-black pixel knockout → transparent PNG (for logos on dark UIs).
 *
 * Run:
 *   php scripts/knockout-logo-background.php
 *   php scripts/knockout-logo-background.php /path/to/source.png /path/to/output.png
 */

$base = dirname(__DIR__) . '/public/images';
$src = $argv[1] ?? $base . '/kamali-logo.png';
$out = $argv[2] ?? $base . '/kamali-logo-mark.png';

if (! is_readable($src)) {
    fwrite(STDERR, "Missing source: {$src}\n");
    exit(1);
}

$blob = file_get_contents($src);
$im = imagecreatefromstring($blob);
if ($im === false) {
    fwrite(STDERR, "Could not decode image.\n");
    exit(1);
}

imagealphablending($im, false);
imagesavealpha($im, true);

$w = imagesx($im);
$h = imagesy($im);

// Only knock out true black / near-black so beige letterforms stay intact.
$cap = 52;

for ($y = 0; $y < $h; $y++) {
    for ($x = 0; $x < $w; $x++) {
        $rgb = imagecolorat($im, $x, $y);
        $r = ($rgb >> 16) & 0xFF;
        $g = ($rgb >> 8) & 0xFF;
        $b = $rgb & 0xFF;

        $isBlackField = $r < $cap && $g < $cap && $b < $cap;

        if ($isBlackField) {
            $col = imagecolorallocatealpha($im, 0, 0, 0, 127);
            imagesetpixel($im, $x, $y, $col);
        }
    }
}

imagealphablending($im, true);
imagesavealpha($im, true);

if (! imagepng($im, $out, 9)) {
    fwrite(STDERR, "Failed to write {$out}\n");
    exit(1);
}

imagedestroy($im);

echo "Wrote {$out}\n";
