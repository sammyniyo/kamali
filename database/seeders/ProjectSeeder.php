<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $projects = [
            [
                'title' => 'Buckingham Palace Annex',
                'location' => 'London, United Kingdom',
                'year' => 2024,
                'category' => 'civic',
                'status' => 'finished',
                'featured' => true,
                'surface_area' => 4200,
                'client_name' => 'Royal Estates',
                'architect_name' => 'Kamali Studio',
                'description' => 'A restrained extension that preserves ceremonial proportion while introducing contemporary light courts and a museum-grade envelope.',
            ],
            [
                'title' => 'Les Palais Blués',
                'location' => 'Cannes, France',
                'year' => 2023,
                'category' => 'residential',
                'status' => 'finished',
                'featured' => true,
                'surface_area' => 980,
                'client_name' => 'Private Client',
                'architect_name' => 'Kamali Studio',
                'description' => 'A coastal villa built around shadow and reflection — stone plinths, bronze screens, and a quiet interior sequence.',
            ],
            [
                'title' => 'Fulham Town Hall Extension',
                'location' => 'London, United Kingdom',
                'year' => 2026,
                'category' => 'civic',
                'status' => 'under_construction',
                'featured' => true,
                'surface_area' => 6100,
                'client_name' => 'Fulham Council',
                'architect_name' => 'Kamali Studio',
                'description' => 'A new public atrium and council chambers with a warm timber ceiling and a calm civic threshold.',
            ],
            [
                'title' => 'The White Apartment',
                'location' => 'Stockholm, Sweden',
                'year' => 2022,
                'category' => 'residential',
                'status' => 'finished',
                'featured' => false,
                'surface_area' => 165,
                'client_name' => 'Nordic Atelier',
                'architect_name' => 'Kamali Studio',
                'description' => 'An interior designed as a gallery: plaster tones, concealed storage, and a light-controlled art wall.',
            ],
            [
                'title' => 'The Modern Versailles',
                'location' => 'New York, USA',
                'year' => 2025,
                'category' => 'residential',
                'status' => 'under_construction',
                'featured' => true,
                'surface_area' => 1850,
                'client_name' => 'Briar Group',
                'architect_name' => 'Kamali Studio',
                'description' => 'A contemporary estate with a symmetrical plan, limestone colonnade, and an orchard courtyard.',
            ],
            [
                'title' => 'Ridge House',
                'location' => 'Lake Tahoe, USA',
                'year' => 2021,
                'category' => 'residential',
                'status' => 'finished',
                'featured' => false,
                'surface_area' => 540,
                'client_name' => 'Sierra Holdings',
                'architect_name' => 'Kamali Studio',
                'description' => 'Charcoal timber volumes anchored to a stone ridge — framed views, warm thresholds, and deep eaves.',
            ],
            [
                'title' => 'Atrium Office Pavilion',
                'location' => 'Dubai, UAE',
                'year' => 2024,
                'category' => 'commercial',
                'status' => 'finished',
                'featured' => true,
                'surface_area' => 7200,
                'client_name' => 'Marsa Developments',
                'architect_name' => 'Kamali Studio',
                'description' => 'A workplace arranged around a shaded atrium with a bronze mesh veil and high-performance glazing.',
            ],
            [
                'title' => 'Civic Library Courtyard',
                'location' => 'Copenhagen, Denmark',
                'year' => 2020,
                'category' => 'civic',
                'status' => 'finished',
                'featured' => false,
                'surface_area' => 3100,
                'client_name' => 'City of Copenhagen',
                'architect_name' => 'Kamali Studio',
                'description' => 'A new reading courtyard and archive wing calibrated for soft daylight and acoustic calm.',
            ],
            [
                'title' => 'Harbor Gallery',
                'location' => 'Lisbon, Portugal',
                'year' => 2022,
                'category' => 'commercial',
                'status' => 'finished',
                'featured' => false,
                'surface_area' => 2600,
                'client_name' => 'Harbor Arts',
                'architect_name' => 'Kamali Studio',
                'description' => 'A gallery and event space with a deep entry loggia and movable partitions for flexible exhibitions.',
            ],
            [
                'title' => 'Crescent Retail Arcade',
                'location' => 'Milan, Italy',
                'year' => 2025,
                'category' => 'commercial',
                'status' => 'under_construction',
                'featured' => false,
                'surface_area' => 4300,
                'client_name' => 'Crescent Properties',
                'architect_name' => 'Kamali Studio',
                'description' => 'A retail passage defined by rhythmic arches, stone floors, and controlled sightlines to courtyard gardens.',
            ],
            [
                'title' => 'Civic Transit Hall',
                'location' => 'Tokyo, Japan',
                'year' => 2026,
                'category' => 'civic',
                'status' => 'under_construction',
                'featured' => false,
                'surface_area' => 12500,
                'client_name' => 'Metro Authority',
                'architect_name' => 'Kamali Studio',
                'description' => 'A transit hall designed as a vaulted promenade — clear wayfinding, warm materials, and generous daylight.',
            ],
            [
                'title' => 'Courtyard House No. 7',
                'location' => 'Barcelona, Spain',
                'year' => 2019,
                'category' => 'residential',
                'status' => 'finished',
                'featured' => false,
                'surface_area' => 320,
                'client_name' => 'Private Client',
                'architect_name' => 'Kamali Studio',
                'description' => 'A compact courtyard home with limestone walls and a lightwell stair — crafted for Mediterranean shade and breeze.',
            ],
        ];

        foreach ($projects as $i => $p) {
            Project::query()->create([
                ...$p,
                'slug' => Str::slug($p['title']),
                'sort_order' => $i + 1,
                'gallery' => [],
                'cover_image' => null,
            ]);
        }
    }
}
