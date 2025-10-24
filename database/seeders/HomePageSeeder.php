<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\HomePage;

class HomePageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        HomePage::updateOrCreate(
            ['id' => 1],
            [
                'main_title' => 'Made for More',
                'main_subtitle' => 'Indian Creek 2026',
                'main_video' => 'https://www.youtube.com/embed/jYEsgNVv23Y?si=qjsEzRyVW7qWDOTV',
                'show_video' => true,
                'show_directions_section' => true,
                'hero_button_text' => 'Explore 2026 Camps',
                'hero_button_url' => '/camp-page',
                'map_title' => 'Spend your week at camp',
                'map_highlight' => '(not in the bus)',
                'map_description' => 'Ideally located in Southern Indiana, ICBC is easy to get to from all parts of the South, and Midwest.',
                'map_image' => '/map.png',
                'map_link' => 'https://maps.app.goo.gl/N6jxLGrDyv1xpXoF6',
                'map_distances' => [
                    ['city' => 'Nashville', 'distance' => '2 hours'],
                    ['city' => 'Indianapolis', 'distance' => '2 hours'],
                    ['city' => 'Washington D.C.', 'distance' => '8 hours'],
                    ['city' => 'St. Louis', 'distance' => '4 hours'],
                    ['city' => 'Chicago', 'distance' => '5 hours'],
                ],
            ]
        );
    }
}
