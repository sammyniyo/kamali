<?php

namespace Tests\Feature;

use App\Models\DailyVisit;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminDashboardVisitorsChartTest extends TestCase
{
    use RefreshDatabase;

    public function test_dashboard_includes_visitor_chart_for_admin(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);

        DailyVisit::query()->create([
            'date' => now()->subDay()->toDateString(),
            'visits' => 4,
            'unique_visitors' => 2,
        ]);

        $this->actingAs($admin)
            ->get(route('admin.dashboard'))
            ->assertOk()
            ->assertSee('adminVisitorsChart', false)
            ->assertSee('chart.umd.min.js', false);
    }
}
