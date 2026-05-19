<?php

namespace Tests\Feature;

use App\Models\Service;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminServiceStoreTest extends TestCase
{
    use RefreshDatabase;

    private function admin(): User
    {
        return User::factory()->create(['is_admin' => true]);
    }

    public function test_store_assigns_incremental_sort_order(): void
    {
        $admin = $this->admin();
        Service::factory()->create(['sort_order' => 12, 'title' => 'Existing Service', 'slug' => 'existing-service']);

        $this->actingAs($admin)
            ->from(route('admin.services.create'))
            ->post(route('admin.services.store'), [
                'title' => 'Facade Studies',
                'description' => 'Envelope and material studies.',
            ])
            ->assertRedirect();

        $s = Service::query()->where('title', 'Facade Studies')->first();
        $this->assertNotNull($s);
        $this->assertSame(13, $s->sort_order);
    }
}
