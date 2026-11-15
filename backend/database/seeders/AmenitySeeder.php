<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AmenitySeeder extends Seeder
{
    public function run(): void
    {
        $amenities = [
            ['name' => 'Wi-Fi', 'icon' => 'wifi'],
            ['name' => 'Air Conditioning', 'icon' => 'air-vent'],
            ['name' => 'Parking', 'icon' => 'car'],
            ['name' => 'Elevator', 'icon' => 'arrow-up-down'],
            ['name' => 'Generator', 'icon' => 'zap'],
            ['name' => 'Security', 'icon' => 'shield-check'],
            ['name' => 'CCTV', 'icon' => 'cctv'],
            ['name' => 'Swimming Pool', 'icon' => 'waves'],
            ['name' => 'Gym', 'icon' => 'dumbbell'],
            ['name' => 'Rooftop Access', 'icon' => 'building-2'],
            ['name' => 'Balcony', 'icon' => 'fence'],
            ['name' => 'Gas Connection', 'icon' => 'flame'],
            ['name' => 'Water Supply', 'icon' => 'droplets'],
            ['name' => 'Furnished', 'icon' => 'sofa'],
            ['name' => 'Pet Friendly', 'icon' => 'paw-print'],
            ['name' => 'Washing Machine', 'icon' => 'washing-machine'],
            ['name' => 'Refrigerator', 'icon' => 'refrigerator'],
            ['name' => 'Nearby Public Transport', 'icon' => 'bus'],
        ];

        foreach ($amenities as $amenity) {
            DB::table('amenities')->updateOrInsert(
                ['name' => $amenity['name']],
                [
                    'icon' => $amenity['icon'],
                    'is_active' => true,
                    'updated_at' => now(),
                    'created_at' => now(),
                ]
            );
        }
    }
}
