<?php

namespace Database\Seeders;

use App\Models\Rating;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RatingSeeder extends Seeder
{
    public function run(): void
    {
        // Contoh rateable type yang ada
        $rateables = [
            ['type' => \App\Models\Transportations::class, 'ids' => [1, 2, 3]],
            ['type' => \App\Models\Tour::class, 'ids' => [1, 2]],
            ['type' => \App\Models\Destination::class, 'ids' => [1, 2, 3, 4]],
            ['type' => \App\Models\Homestay::class, 'ids' => [1, 2]],
        ];

        foreach ($rateables as $rateable) {
            foreach ($rateable['ids'] as $id) {
                // Buat beberapa rating per item
                for ($i = 0; $i < 5; $i++) {
                    Rating::create([
                        'rateable_id'   => $id,
                        'rateable_type' => $rateable['type'],
                        'name'          => fake()->name,
                        'email'         => fake()->safeEmail,
                        'booking_code'  => 'BK' . rand(1000, 9999),
                        'rating'        => fake()->randomFloat(1, 3.0, 5.0),
                        'review'        => fake()->sentence(10),
                    ]);
                }
            }
        }
    }
}
