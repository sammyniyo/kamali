<?php

namespace App\Support;

class KamaliMedia
{
    public static function teamPhoto(?string $path): string
    {
        if (filled($path)) {
            return asset('storage/'.ltrim((string) $path, '/'));
        }

        return asset(config('kamali.placeholder_avatar'));
    }

    public static function projectCover(?string $path, int $index = 0): string
    {
        if (filled($path)) {
            return asset('storage/'.ltrim((string) $path, '/'));
        }

        $fallbacks = config('kamali.placeholder_project_covers', []);
        if ($fallbacks === [] || ! is_array($fallbacks)) {
            return asset('images/renders/villa-greenwall.png');
        }

        $list = array_values($fallbacks);
        $key = $index % count($list);

        return asset($list[$key]);
    }

    public static function blogCover(?string $path, int $index = 0): string
    {
        return self::projectCover($path, $index);
    }

    public static function partnerLogo(?string $path): ?string
    {
        if (! filled($path)) {
            return null;
        }

        return asset('storage/'.ltrim((string) $path, '/'));
    }
}
