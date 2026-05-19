<?php

namespace App\Support;

use App\Models\Partner;
use App\Models\Project;
use Illuminate\Support\Str;

class StudioStats
{
    /**
     * @return list<array{value: int, suffix: string, label: string}>
     */
    public static function forHomepage(): array
    {
        $years = max(1, (int) date('Y') - (int) config('kamali.founded_year', 2010));
        $projects = Project::query()->where('status', 'finished')->count();
        $countries = self::countriesReached();
        $recognition = Partner::query()->visible()->count();
        if ($recognition === 0) {
            $recognition = count(config('kamali.recognition', []));
        }

        return [
            [
                'value' => $years,
                'suffix' => '+',
                'label' => 'Years Experience',
            ],
            [
                'value' => $projects,
                'suffix' => '',
                'label' => 'Projects Completed',
            ],
            [
                'value' => $recognition,
                'suffix' => '',
                'label' => 'Press & Awards',
            ],
            [
                'value' => $countries,
                'suffix' => '',
                'label' => 'Countries',
            ],
        ];
    }

    public static function countriesReached(): int
    {
        $fromProjects = Project::query()
            ->whereNotNull('location')
            ->where('location', '!=', '')
            ->pluck('location')
            ->map(fn (string $location) => self::countryFromLocation($location))
            ->filter();

        $home = trim((string) config('kamali.address.country', ''));
        if ($home !== '') {
            $fromProjects->push($home);
        }

        return $fromProjects->unique()->count();
    }

    private static function countryFromLocation(string $location): ?string
    {
        $location = trim($location);
        if ($location === '') {
            return null;
        }

        if (str_contains($location, ',')) {
            return trim(Str::afterLast($location, ','));
        }

        return $location;
    }
}
