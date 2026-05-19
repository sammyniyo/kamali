<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::query()->updateOrCreate(
            ['email' => 'admin@kamali.test'],
            [
                'name' => 'Admin',
                'password' => Hash::make('password'),
                'is_admin' => true,
            ]
        );

        // Only seed content for empty databases; avoids unique slug collisions on repeated runs.
        if (\App\Models\Service::query()->doesntExist()) {
            $this->call([
                ServiceSeeder::class,
                TeamMemberSeeder::class,
                ProjectSeeder::class,
                ContactMessageSeeder::class,
            ]);
        }

        if (\App\Models\Blog::query()->doesntExist()) {
            $this->call(BlogSeeder::class);
        }

        if (\App\Models\Partner::query()->doesntExist()) {
            $this->call(PartnerSeeder::class);
        }
    }
}
