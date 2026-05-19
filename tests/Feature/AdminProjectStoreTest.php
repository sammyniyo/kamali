<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminProjectStoreTest extends TestCase
{
    use RefreshDatabase;

    private function admin(): User
    {
        return User::factory()->create(['is_admin' => true]);
    }

    public function test_store_assigns_incremental_sort_order(): void
    {
        Storage::fake('public');
        $admin = $this->admin();
        Project::factory()->create(['sort_order' => 7]);

        $this->actingAs($admin)
            ->from(route('admin.projects.create'))
            ->post(route('admin.projects.store'), [
                'title' => 'Riverside Annex',
                'slug' => 'riverside-annex',
                'description' => 'A riverside residential study.',
                'location' => 'Kigali',
                'year' => 2025,
                'category' => 'residential',
                'status' => 'finished',
            ])
            ->assertRedirect();

        $p = Project::query()->where('slug', 'riverside-annex')->first();
        $this->assertNotNull($p);
        $this->assertSame(8, $p->sort_order);
    }

    public function test_store_rejects_duplicate_gallery_binaries(): void
    {
        Storage::fake('public');
        $admin = $this->admin();

        $seed = UploadedFile::fake()->image('dup.jpg', 20, 20);
        $bytes = file_get_contents($seed->getRealPath());
        $tmpA = tempnam(sys_get_temp_dir(), 'dupa');
        $tmpB = tempnam(sys_get_temp_dir(), 'dupb');
        file_put_contents($tmpA, $bytes);
        file_put_contents($tmpB, $bytes);

        $fileA = new UploadedFile($tmpA, 'a.jpg', 'image/jpeg', null, true);
        $fileB = new UploadedFile($tmpB, 'b.jpg', 'image/jpeg', null, true);

        $this->actingAs($admin)
            ->from(route('admin.projects.create'))
            ->post(route('admin.projects.store'), [
                'title' => 'Dup gallery',
                'slug' => 'dup-gallery',
                'description' => 'Testing duplicate uploads.',
                'location' => 'Kigali',
                'year' => 2025,
                'category' => 'residential',
                'status' => 'finished',
                'gallery' => [$fileA, $fileB],
            ])
            ->assertSessionHasErrors('gallery');

        $this->assertDatabaseMissing('projects', ['slug' => 'dup-gallery']);
    }

    public function test_store_rejects_gallery_file_identical_to_cover(): void
    {
        Storage::fake('public');
        $admin = $this->admin();

        $seed = UploadedFile::fake()->image('same.jpg', 20, 20);
        $bytes = file_get_contents($seed->getRealPath());
        $tmpC = tempnam(sys_get_temp_dir(), 'cov');
        $tmpG = tempnam(sys_get_temp_dir(), 'gal');
        file_put_contents($tmpC, $bytes);
        file_put_contents($tmpG, $bytes);

        $cover = new UploadedFile($tmpC, 'cover.jpg', 'image/jpeg', null, true);
        $gallery = new UploadedFile($tmpG, 'gal.jpg', 'image/jpeg', null, true);

        $this->actingAs($admin)
            ->from(route('admin.projects.create'))
            ->post(route('admin.projects.store'), [
                'title' => 'Same cover and gallery',
                'slug' => 'same-cover-gallery',
                'description' => 'Testing cover vs gallery duplicate.',
                'location' => 'Kigali',
                'year' => 2025,
                'category' => 'residential',
                'status' => 'finished',
                'cover_image' => $cover,
                'gallery' => [$gallery],
            ])
            ->assertSessionHasErrors('gallery');

        $this->assertDatabaseMissing('projects', ['slug' => 'same-cover-gallery']);
    }
}
