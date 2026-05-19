<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Support\ProjectPagination;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProjectsPaginationTest extends TestCase
{
    use RefreshDatabase;

    public function test_projects_index_paginates_with_summary(): void
    {
        $perPage = ProjectPagination::publicPerPage();

        Project::factory()->count($perPage + 1)->create([
            'status' => 'finished',
        ]);

        $firstPage = $this->get(route('projects.index'));
        $firstPage->assertOk();
        $firstPage->assertSee('Showing 1–'.$perPage.' of '.($perPage + 1).' projects', false);
        $firstPage->assertSee('Go to page 2', false);

        $secondPage = $this->get(route('projects.index', ['page' => 2]));
        $secondPage->assertOk();
        $secondPage->assertSee('Showing '.($perPage + 1).'–'.($perPage + 1).' of '.($perPage + 1).' projects', false);
    }

    public function test_projects_search_json_includes_pagination_html(): void
    {
        $perPage = ProjectPagination::publicPerPage();

        Project::factory()->count($perPage + 1)->create();

        $this->getJson(route('projects.search', ['page' => 2]))
            ->assertOk()
            ->assertJsonStructure(['total', 'grid_html', 'pagination_html'])
            ->assertJsonPath('total', $perPage + 1);
    }
}
