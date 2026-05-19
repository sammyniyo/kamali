<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminBlogStoreTest extends TestCase
{
    use RefreshDatabase;

    private function admin(): User
    {
        return User::factory()->create(['is_admin' => true]);
    }

    public function test_guest_cannot_access_blog_admin(): void
    {
        $this->get(route('admin.blogs.index'))->assertRedirect();
    }

    public function test_admin_can_create_published_post(): void
    {
        $admin = $this->admin();

        $this->actingAs($admin)
            ->from(route('admin.blogs.create'))
            ->post(route('admin.blogs.store'), [
                'title' => 'Opening the studio',
                'excerpt' => 'Short intro.',
                'body' => '<p>Paragraph one.</p><p>Paragraph two.</p>',
                'published_at' => now()->subMinute()->format('Y-m-d\TH:i'),
            ])
            ->assertRedirect();

        $this->assertDatabaseHas('blogs', [
            'title' => 'Opening the studio',
            'slug' => 'opening-the-studio',
        ]);
    }
}
