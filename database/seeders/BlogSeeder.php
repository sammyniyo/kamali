<?php

namespace Database\Seeders;

use App\Models\Blog;
use Illuminate\Database\Seeder;

class BlogSeeder extends Seeder
{
    public function run(): void
    {
        Blog::query()->updateOrCreate(
            ['slug' => 'material-quiet-in-luxury-interiors'],
            [
                'title' => 'Material quiet in luxury interiors',
                'excerpt' => 'How restrained palettes and honest textures shape calm residential spaces without losing warmth.',
                'body' => '<p>Luxury is often mistaken for excess. In our residential work, we look for the opposite: fewer materials, repeated with discipline, so the eye can rest.</p><p>Stone, timber, and plaster each carry a voice. When those voices compete, rooms feel busy. When one leads and the others support, the architecture reads as confident.</p><p>We sketch in natural light early — not as decoration, but as a material that changes the wall throughout the day. That rhythm becomes the experience clients remember.</p>',
                'published_at' => now()->subDays(12),
            ]
        );

        Blog::query()->updateOrCreate(
            ['slug' => 'civic-clarity-at-city-scale'],
            [
                'title' => 'Civic clarity at city scale',
                'excerpt' => 'Public buildings should announce their purpose without shouting. Notes from a recent civic competition.',
                'body' => '<p>Civic architecture carries a responsibility that private work does not: it must be legible to strangers, safe for children, and durable for decades.</p><p>We start with circulation clarity — where you enter, how you orient, where daylight lands in waiting zones. Those decisions are kindness.</p><p>Facades follow. Expression grows from structure and shading needs, not from a mood board. The result tends to be quieter — and longer-lasting.</p>',
                'published_at' => now()->subDays(5),
            ]
        );

        Blog::query()->updateOrCreate(
            ['slug' => 'draft-site-logistics-checklist'],
            [
                'title' => 'Draft: site logistics checklist',
                'excerpt' => 'Internal notes — not published on the public site.',
                'body' => '<p>This post is intentionally left unpublished to exercise draft behavior in the admin panel.</p>',
                'published_at' => null,
            ]
        );
    }
}
