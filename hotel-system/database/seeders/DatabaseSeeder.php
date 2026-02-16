<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Package; // <--- Add this line
use Illuminate\Database\Seeder;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create 10 random users (Standard Laravel setup)
        User::factory(10)->create();

        // Add your Hotel Packages
        Package::create([
            'name' => 'Luxury Suite',
            'description' => 'A beautiful room with a sea view and private balcony.',
            'price' => 250.00,
        ]);

        Package::create([
            'name' => 'Standard Budget',
            'description' => 'Perfect for travelers looking for a comfortable stay at a low price.',
            'price' => 75.00,
        ]);
    }
}