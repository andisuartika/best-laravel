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
        // User::factory()->create([
        //     'name' => 'Super Admin',
        //     'email' => 'super.admin@mail.com',
        //     'phone' => '123123',
        //     'role' => 'SUPER ADMIN',
        //     'password' => Hash::make('123123')
        // ]);
        // User::factory()->create([
        //     'name' => 'Admin Desa Sudaji',
        //     'email' => 'sudaji.admin@mail.com',
        //     'phone' => '321321',
        //     'role' => 'ADMIN DESA',
        //     'village_id' => '5108070005',
        //     'password' => Hash::make('123123')
        // ]);
    }
}
