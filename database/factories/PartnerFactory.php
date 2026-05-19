<?php

namespace Database\Factories;

use App\Models\Partner;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Partner>
 */
class PartnerFactory extends Factory
{
    protected $model = Partner::class;

    public function definition(): array
    {
        return [
            'name' => fake()->unique()->company(),
            'note' => fake()->optional()->sentence(4),
            'url' => fake()->optional()->url(),
            'logo' => null,
            'is_visible' => true,
            'sort_order' => 0,
        ];
    }
}
