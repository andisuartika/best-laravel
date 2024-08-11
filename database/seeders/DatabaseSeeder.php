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

        $this->call([
            CategorySeeder::class,
            SubCategorySeeder::class,
        ]);
        User::factory()->create([
            'name' => 'Super Admin',
            'email' => 'super.admin@mail.com',
            'phone' => '123123',
            'role' => 'SUPER ADMIN',
            'password' => Hash::make('123123')
        ]);
        User::factory()->create([
            'name' => 'Desa Ambengan',
            'email' => 'admin.ambengan@mail.com',
            'phone' => '5108050003',
            'role' => 'ADMIN DESA',
            'village_id' => '5108050003',
            'password' => Hash::make('123123')
        ]);
    }
}
