<?php

namespace Tests\Feature;

use App\Models\Partner;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminPartnerStoreTest extends TestCase
{
    use RefreshDatabase;

    private function admin(): User
    {
        return User::factory()->create(['is_admin' => true]);
    }

    public function test_guest_cannot_access_partners_admin(): void
    {
        $this->get(route('admin.partners.index'))->assertRedirect();
    }

    public function test_admin_can_create_partner(): void
    {
        $admin = $this->admin();

        $this->actingAs($admin)
            ->from(route('admin.partners.create'))
            ->post(route('admin.partners.store'), [
                'name' => 'ArchDaily',
                'note' => 'Contractor',
                'is_visible' => '1',
            ])
            ->assertRedirect();

        $this->assertDatabaseHas('partners', [
            'name' => 'ArchDaily',
            'note' => 'Contractor',
            'is_visible' => true,
        ]);
    }

    public function test_press_strip_shows_visible_partner_with_note(): void
    {
        Partner::factory()->create([
            'name' => 'Dezeen',
            'note' => 'Press',
            'is_visible' => true,
            'sort_order' => 1,
        ]);
        Partner::factory()->create([
            'name' => 'Hidden Org',
            'note' => 'Should not show',
            'is_visible' => false,
            'sort_order' => 2,
        ]);

        $this->get(route('home'))
            ->assertOk()
            ->assertSee('Dezeen', false)
            ->assertDontSee('Hidden Org', false);
    }
}
