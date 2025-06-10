<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class FacilitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $facilities = [
            ['name' => 'Air Conditioner', 'description' => 'Room equipped with air conditioning.', 'icon' => 'assets/facilities/ac.png'],
            ['name' => 'Accessible', 'description' => 'Facilities accessible for people with disabilities.', 'icon' => 'assets/facilities/accessible.png'],
            ['name' => 'Balcony', 'description' => 'Private balcony attached to the room.', 'icon' => 'assets/facilities/balcony.png'],
            ['name' => 'Bathroom', 'description' => 'Private bathroom with basic amenities.', 'icon' => 'assets/facilities/bathroom.png'],
            ['name' => 'Bed', 'description' => 'Comfortable bed included in the room.', 'icon' => 'assets/facilities/bed.png'],
            ['name' => 'Bench', 'description' => 'Outdoor or indoor bench for seating.', 'icon' => 'assets/facilities/bench.png'],
            ['name' => 'Breakfast', 'description' => 'Complimentary breakfast is provided.', 'icon' => 'assets/facilities/breakfast.png'],
            ['name' => 'CCTV', 'description' => 'CCTV security surveillance available.', 'icon' => 'assets/facilities/cctv.png'],
            ['name' => 'Desk', 'description' => 'Working desk available in the room.', 'icon' => 'assets/facilities/desk.png'],
            ['name' => 'Drinking Water', 'description' => 'Free drinking water is available.', 'icon' => 'assets/facilities/drink-water.png'],
            ['name' => 'Garden', 'description' => 'Access to garden area.', 'icon' => 'assets/facilities/garden.png'],
            ['name' => 'Hanger', 'description' => 'Clothes hangers provided.', 'icon' => 'assets/facilities/hanger.png'],
            ['name' => 'Information', 'description' => 'Information center or help desk available.', 'icon' => 'assets/facilities/information.png'],
            ['name' => 'Lobby', 'description' => 'Common lobby area for guests.', 'icon' => 'assets/facilities/lobby.png'],
            ['name' => 'Map', 'description' => 'Tourist map or navigation assistance.', 'icon' => 'assets/facilities/map.png'],
            ['name' => 'Mini Bar', 'description' => 'Mini bar with refreshments in the room.', 'icon' => 'assets/facilities/mini-bar.png'],
            [
                'name' => 'Parking',
                'description' => 'Designated parking area for vehicles.',
                'icon' => 'assets/facilities/parking.png'
            ],
            [
                'name' => 'Restaurant',
                'description' => 'On-site restaurant serving food and beverages.',
                'icon' => 'assets/facilities/restaurant.png'
            ],
            [
                'name' => 'Smoking Area',
                'description' => 'Designated smoking area available.',
                'icon' => 'assets/facilities/smoking-area.png'
            ],
            [
                'name' => 'Souvenir Shop',
                'description' => 'Gift shop with local souvenirs and items.',
                'icon' => 'assets/facilities/souvenir-shop.png'
            ],
            [
                'name' => 'Swimming Pool',
                'description' => 'Outdoor or indoor swimming pool for guests.',
                'icon' => 'assets/facilities/swimming-pool.png'
            ],
            [
                'name' => 'Toilet',
                'description' => 'Clean public restroom facility.',
                'icon' => 'assets/facilities/toilet.png'
            ],
            [
                'name' => 'Tracking',
                'description' => 'Trail and hiking area nearby.',
                'icon' => 'assets/facilities/tracking.png'
            ],
            [
                'name' => 'Trash Bin',
                'description' => 'Waste bins provided for garbage disposal.',
                'icon' => 'assets/facilities/trash.png'
            ],
            [
                'name' => 'Television',
                'description' => 'Television available in the room.',
                'icon' => 'assets/facilities/tv.png'
            ],
            [
                'name' => 'Water Heater',
                'description' => 'Hot water system for showers and sinks.',
                'icon' => 'assets/facilities/water-heater.png'
            ],
            [
                'name' => 'Wi-Fi',
                'description' => 'Wireless internet connection available.',
                'icon' => 'assets/facilities/wifi.png'
            ],
        ];

        DB::table('facilities')->insert($facilities);
    }
}
