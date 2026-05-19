<?php

namespace Tests\Feature;

use App\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SitemapTest extends TestCase
{
    use RefreshDatabase;

    public function test_sitemap_renders_xml_with_static_and_project_urls(): void
    {
        Project::factory()->create(['slug' => 'pavilion-one']);

        $response = $this->get('/sitemap.xml');

        $response->assertOk();
        $response->assertHeader('Content-Type', 'application/xml; charset=UTF-8');
        $response->assertSee('<urlset', false);
        $response->assertSee('/projects/pavilion-one', false);
        $response->assertSee('/about', false);
        $response->assertSee('/blog', false);
    }
}
