<?php

namespace Database\Factories;

use App\Models\Blog;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Blog>
 */
class BlogFactory extends Factory
{
    protected $model = Blog::class;

    public function definition(): array
    {
        $title = Str::title(fake()->unique()->words(fake()->numberBetween(3, 6), true));

        $paragraphs = collect(fake()->paragraphs(4))
            ->map(fn (string $p) => '<p>'.e($p).'</p>')
            ->implode('');

        return [
            'title' => $title,
            'slug' => null,
            'excerpt' => fake()->sentence(14),
            'cover_image' => null,
            'body' => $paragraphs,
            'published_at' => now()->subDays(fake()->numberBetween(0, 30)),
        ];
    }

    public function draft(): static
    {
        return $this->state(fn () => ['published_at' => null]);
    }
}
