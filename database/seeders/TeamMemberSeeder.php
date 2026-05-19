<?php

namespace Database\Seeders;

use App\Models\TeamMember;
use Illuminate\Database\Seeder;

class TeamMemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $members = [
            [
                'name' => 'Ariana Kamali',
                'role' => 'Principal Architect',
                'bio' => 'Ariana leads the studio with a focus on proportion, craft, and quiet luxury — translating complex briefs into clear architectural narratives.',
                'linkedin_url' => 'https://linkedin.com',
                'sort_order' => 1,
            ],
            [
                'name' => 'Milo Abramowitz',
                'role' => 'Design Director',
                'bio' => 'Milo oversees concept development and design quality across the portfolio, balancing editorial clarity with spatial warmth.',
                'linkedin_url' => 'https://linkedin.com',
                'sort_order' => 2,
            ],
            [
                'name' => 'Cameron Williamson',
                'role' => 'Project Architect',
                'bio' => 'Cameron coordinates teams through documentation and construction, ensuring the concept survives every detail.',
                'linkedin_url' => 'https://linkedin.com',
                'sort_order' => 3,
            ],
            [
                'name' => 'Pena Doshinov',
                'role' => 'Interior Architect',
                'bio' => 'Pena crafts material palettes and joinery systems that feel calm, tactile, and precise.',
                'linkedin_url' => 'https://linkedin.com',
                'sort_order' => 4,
            ],
            [
                'name' => 'Rina Kato',
                'role' => 'Landscape Architect',
                'bio' => 'Rina designs courtyards and terraces as spatial continuations — tuned to light, texture, and season.',
                'linkedin_url' => 'https://linkedin.com',
                'sort_order' => 5,
            ],
            [
                'name' => 'Noah Martins',
                'role' => 'Visualisation Lead',
                'bio' => 'Noah develops visual narratives for clients and stakeholders — rendering atmosphere, not just form.',
                'linkedin_url' => 'https://linkedin.com',
                'sort_order' => 6,
            ],
        ];

        foreach ($members as $m) {
            TeamMember::query()->create($m);
        }
    }
}
