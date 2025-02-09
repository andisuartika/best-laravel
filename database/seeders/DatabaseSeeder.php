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
            RolePermissionSeeder::class,
        ]);
        $superadmin = User::factory()->create([
            'name' => 'Super Admin',
            'email' => 'super.admin@mail.com',
            'phone' => '123123',
            'password' => Hash::make('123123')
        ]);
        $superadmin->assignRole('super admin');

        $admin = User::factory()->create([
            'name' => 'Desa Ambengan',
            'email' => 'admin.ambengan@mail.com',
            'phone' => '08223345671',
            'village_id' => '5108050003',
            'password' => Hash::make('123123')
        ]);
        $admin->assignRole('admin');

        $pengelola = User::factory()->create([
            'name' => 'Gatep Lawas',
            'email' => 'gateplawas@mail.com',
            'phone' => '085787621',
            'village_id' => '5108050003',
            'password' => Hash::make('123123')
        ]);
        $pengelola->assignRole('pengelola');
    }
}
