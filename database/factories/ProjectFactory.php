<?php

namespace Database\Factories;

use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Project>
 */
class ProjectFactory extends Factory
{
    protected $model = Project::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake()->unique()->sentence(fake()->numberBetween(2, 4));
        $category = fake()->randomElement(['residential', 'commercial', 'civic']);
        $status = fake()->randomElement(['finished', 'under_construction']);

        return [
            'title' => Str::of($title)->replace('.', '')->toString(),
            'slug' => null,
            'description' => fake()->paragraphs(3, true),
            'location' => fake()->city() . ', ' . fake()->country(),
            'year' => fake()->numberBetween(2012, 2026),
            'category' => $category,
            'status' => $status,
            'cover_image' => null,
            'gallery' => [],
            'featured' => fake()->boolean(20),
            'sort_order' => 0,
            'architect_name' => fake()->name(),
            'client_name' => fake()->company(),
            'surface_area' => fake()->numberBetween(80, 3200),
        ];
    }
}
