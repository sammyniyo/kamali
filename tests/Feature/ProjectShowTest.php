<?php

namespace Tests\Feature;

use App\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProjectShowTest extends TestCase
{
    use RefreshDatabase;

    public function test_project_detail_page_renders(): void
    {
        $project = Project::factory()->create([
            'title' => 'Test Pavilion Alpha',
        ]);

        $this->get(route('projects.show', ['slug' => $project->slug]))
            ->assertOk()
            ->assertSee('Test Pavilion Alpha', false);
    }

    public function test_project_detail_includes_structured_data_and_og_tags(): void
    {
        $project = Project::factory()->create([
            'title' => 'Harbor Gallery',
            'description' => 'A civic gallery along the waterfront.',
        ]);

        $response = $this->get(route('projects.show', ['slug' => $project->slug]));

        $response->assertOk();
        $response->assertSee('application/ld+json', false);
        $response->assertSee('Harbor Gallery', false);
        $response->assertSee('og:title', false);
        $response->assertSee('rel="canonical"', false);
    }

    public function test_unknown_project_slug_returns_404(): void
    {
        $this->get(route('projects.show', ['slug' => 'does-not-exist-xyz']))
            ->assertNotFound();
    }
}
