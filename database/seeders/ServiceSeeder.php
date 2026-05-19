<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $services = [
            ['Residential Architecture', 'Bespoke homes shaped by light, sequence, and restraint.', 'home'],
            ['Commercial Architecture', 'Workplaces and retail environments with editorial clarity.', 'building'],
            ['Interior Design', 'Material palettes, joinery, and atmosphere — down to the handle.', 'pen-tool'],
            ['Landscape Architecture', 'Courtyards, terraces, and site strategy that completes the story.', 'map'],
            ['Urban Planning', 'Context-led frameworks that balance density, calm, and movement.', 'layers'],
            ['Project Management', 'Precision delivery from concept to completion with steady communication.', 'compass'],
        ];

        foreach ($services as $i => [$title, $description, $icon]) {
            Service::query()->create([
                'title' => $title,
                'slug' => Str::slug($title),
                'description' => $description,
                'icon_name' => $icon,
                'sort_order' => $i + 1,
            ]);
        }
    }
}
