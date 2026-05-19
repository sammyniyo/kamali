<?php

namespace App\Support;

use Illuminate\Http\Request;

class ProjectPagination
{
    public static function publicPerPage(): int
    {
        return max(1, (int) config('kamali.projects_per_page', 12));
    }

    public static function adminPerPage(Request $request): int
    {
        $options = self::adminPerPageOptions();
        $default = (int) config('kamali.admin_projects_per_page', 15);
        $perPage = (int) $request->query('per_page', $default);

        return in_array($perPage, $options, true) ? $perPage : $default;
    }

    /**
     * @return list<int>
     */
    public static function adminPerPageOptions(): array
    {
        $options = config('kamali.admin_projects_per_page_options', [12, 20, 40]);

        return array_values(array_filter(
            array_map('intval', is_array($options) ? $options : [12, 20, 40]),
            fn (int $n) => $n > 0
        ));
    }

    /**
     * @return array<string, mixed>
     */
    public static function publicLinkData(string $itemLabel = 'projects'): array
    {
        return [
            'variant' => 'public',
            'itemLabel' => $itemLabel,
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public static function adminLinkData(): array
    {
        return [
            'variant' => 'admin',
            'itemLabel' => 'projects',
            'perPageOptions' => self::adminPerPageOptions(),
        ];
    }
}
