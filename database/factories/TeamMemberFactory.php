<?php

namespace Database\Factories;

use App\Models\TeamMember;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TeamMember>
 */
class TeamMemberFactory extends Factory
{
    protected $model = TeamMember::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'role' => fake()->randomElement([
                'Principal Architect',
                'Design Director',
                'Project Architect',
                'Interior Architect',
                'Landscape Architect',
                'Visualisation Lead',
            ]),
            'bio' => fake()->paragraphs(2, true),
            'photo' => null,
            'linkedin_url' => fake()->boolean(70) ? fake()->url() : null,
            'sort_order' => 0,
        ];
    }
}
