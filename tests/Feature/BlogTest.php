<?php

namespace Tests\Feature;

use App\Models\Blog;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BlogTest extends TestCase
{
    use RefreshDatabase;

    public function test_blog_index_lists_only_published_posts(): void
    {
        Blog::factory()->create([
            'title' => 'Visible',
            'slug' => 'visible',
            'published_at' => now()->subDay(),
        ]);
        Blog::factory()->draft()->create([
            'title' => 'Hidden',
            'slug' => 'hidden',
        ]);

        $response = $this->get(route('blog.index'));

        $response->assertOk();
        $response->assertSee('Visible', false);
        $response->assertDontSee('Hidden', false);
    }

    public function test_blog_show_returns_404_for_draft(): void
    {
        Blog::factory()->draft()->create(['slug' => 'draft-post']);

        $this->get(route('blog.show', 'draft-post'))->assertNotFound();
    }

    public function test_blog_show_renders_published_post(): void
    {
        Blog::factory()->create([
            'title' => 'Hello World',
            'slug' => 'hello-world',
            'body' => '<p>First line.</p><p>Second line.</p>',
            'published_at' => now()->subHour(),
        ]);

        $this->get(route('blog.show', 'hello-world'))
            ->assertOk()
            ->assertSee('Hello World', false)
            ->assertSee('First line.', false);
    }
}
