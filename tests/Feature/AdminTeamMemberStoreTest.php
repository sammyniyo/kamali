<?php

namespace Tests\Feature;

use App\Models\TeamMember;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminTeamMemberStoreTest extends TestCase
{
    use RefreshDatabase;

    private function admin(): User
    {
        return User::factory()->create(['is_admin' => true]);
    }

    public function test_store_assigns_incremental_sort_order(): void
    {
        $admin = $this->admin();
        TeamMember::factory()->create(['sort_order' => 5, 'name' => 'Existing Member']);

        $this->actingAs($admin)
            ->from(route('admin.team.create'))
            ->post(route('admin.team.store'), [
                'name' => 'New Architect',
                'role' => 'Project Architect',
                'bio' => 'Bio text.',
            ])
            ->assertRedirect();

        $m = TeamMember::query()->where('name', 'New Architect')->first();
        $this->assertNotNull($m);
        $this->assertSame(6, $m->sort_order);
    }
}
