<?php

namespace Database\Factories;

use App\Models\Service;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Service>
 */
class ServiceFactory extends Factory
{
    protected $model = Service::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake()->unique()->words(fake()->numberBetween(2, 3), true);

        return [
            'title' => Str::title($title),
            'slug' => null,
            'description' => fake()->sentence(18),
            'icon_name' => fake()->randomElement(['home', 'building', 'pen-tool', 'map', 'layers', 'compass']),
            'sort_order' => 0,
        ];
    }
}
