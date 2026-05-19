<?php

namespace Database\Factories;

use App\Models\ContactMessage;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ContactMessage>
 */
class ContactMessageFactory extends Factory
{
    protected $model = ContactMessage::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->safeEmail(),
            'phone' => fake()->boolean(70) ? fake()->phoneNumber() : null,
            'subject' => fake()->sentence(6),
            'message' => fake()->paragraphs(2, true),
            'read_at' => fake()->boolean(20) ? fake()->dateTimeBetween('-3 months', 'now') : null,
        ];
    }
}
