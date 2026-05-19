<?php

namespace Database\Seeders;

use App\Models\Partner;
use Illuminate\Database\Seeder;

class PartnerSeeder extends Seeder
{
    public function run(): void
    {
        $partners = [
            ['name' => 'ArchDaily', 'note' => 'Press'],
            ['name' => 'Dezeen', 'note' => 'Press'],
            ['name' => 'WALLPAPER*', 'note' => 'Press'],
            ['name' => 'Domus', 'note' => 'Press'],
            ['name' => 'AD Magazine', 'note' => 'Press'],
            ['name' => 'World-Architects', 'note' => 'Press'],
            ['name' => 'A+ Awards', 'note' => 'Awards'],
            ['name' => 'RIBA', 'note' => 'Institution'],
            ['name' => 'IF Design', 'note' => 'Awards'],
            ['name' => 'WAF', 'note' => 'Awards'],
        ];

        foreach ($partners as $i => $row) {
            Partner::query()->updateOrCreate(
                ['name' => $row['name']],
                [
                    'note' => $row['note'],
                    'is_visible' => true,
                    'sort_order' => $i + 1,
                ]
            );
        }
    }
}
