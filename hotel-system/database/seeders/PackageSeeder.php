<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
{
    \App\Models\Package::create([
        'name' => 'Royal Wedding Package',
        'price' => 250000,
        'description' => 'A luxury experience including the Lakeside Garden and Master Suite.',
        'is_active' => true
    ]);

    \App\Models\Package::create([
        'name' => 'Sapphire Package',
        'price' => 150000,
        'description' => 'Perfect for intimate gatherings in the Rock House.',
        'is_active' => true
    ]);
}
}
