<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DailyVisit;

class DashboardController extends Controller
{
    public function index()
    {
        $today = now()->toDateString();
        $todayRow = DailyVisit::query()->where('date', $today)->first();

        $visitsToday = (int) ($todayRow?->visits ?? 0);
        $uniqueToday = (int) ($todayRow?->unique_visitors ?? 0);

        $visits7d = (int) DailyVisit::query()
            ->where('date', '>=', now()->subDays(6)->toDateString())
            ->sum('visits');
        $unique7d = (int) DailyVisit::query()
            ->where('date', '>=', now()->subDays(6)->toDateString())
            ->sum('unique_visitors');

        $visitsAll = (int) DailyVisit::query()->sum('visits');
        $uniqueAll = (int) DailyVisit::query()->sum('unique_visitors');

        $visitorChart = $this->visitorChartSeries(days: 30);

        return view('admin.dashboard', compact(
            'visitsToday',
            'uniqueToday',
            'visits7d',
            'unique7d',
            'visitsAll',
            'uniqueAll',
            'visitorChart'
        ));
    }

    /**
     * @return array{labels: list<string>, visits: list<int>, unique: list<int>}
     */
    private function visitorChartSeries(int $days): array
    {
        $start = now()->subDays(max(1, $days) - 1)->startOfDay();

        $rows = DailyVisit::query()
            ->where('date', '>=', $start->toDateString())
            ->orderBy('date')
            ->get()
            ->keyBy(fn ($row) => $row->date->toDateString());

        $labels = [];
        $visits = [];
        $unique = [];

        for ($i = 0; $i < $days; $i++) {
            $day = $start->copy()->addDays($i);
            $key = $day->toDateString();
            $row = $rows->get($key);

            $labels[] = $day->format('M j');
            $visits[] = (int) ($row?->visits ?? 0);
            $unique[] = (int) ($row?->unique_visitors ?? 0);
        }

        return [
            'labels' => $labels,
            'visits' => $visits,
            'unique' => $unique,
        ];
    }
}
