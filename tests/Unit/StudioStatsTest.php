<?php

namespace Tests\Unit;

use App\Models\Partner;
use App\Models\Project;
use App\Support\StudioStats;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StudioStatsTest extends TestCase
{
    use RefreshDatabase;

    public function test_homepage_stats_reflect_database_and_config(): void
    {
        config(['kamali.founded_year' => 2010]);
        config(['kamali.address.country' => 'Rwanda']);
        Partner::factory()->count(3)->create(['is_visible' => true]);

        Project::factory()->create([
            'status' => 'finished',
            'location' => 'London, United Kingdom',
        ]);
        Project::factory()->create([
            'status' => 'finished',
            'location' => 'Paris, France',
        ]);
        Project::factory()->create([
            'status' => 'under_construction',
            'location' => 'Tokyo, Japan',
        ]);

        $stats = StudioStats::forHomepage();

        $this->assertSame((int) date('Y') - 2010, $stats[0]['value']);
        $this->assertSame('+', $stats[0]['suffix']);
        $this->assertSame(2, $stats[1]['value']);
        $this->assertSame(3, $stats[2]['value']); // visible partners
        $this->assertSame(4, $stats[3]['value']);
    }
}
