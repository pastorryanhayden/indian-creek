<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use HomePage;

class HomePageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        HomePage::create([
            'main_title' => 'Made for More',
            'main_subtitle' => 'Indian Creek 2025',
            'main_video' => 'https://www.youtube.com/embed/jYEsgNVv23Y?si=qjsEzRyVW7qWDOTV',
            'show_video' => true,
            'show_directions_section' => true,
        ]);
    }
}
