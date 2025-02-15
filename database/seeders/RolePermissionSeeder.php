<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // Buat permissions
        $permissions = [
            'view-dashboard', // Akses dashboard
            'view-destination', // Akses destinasi
            'view-accomodation', // Akses akomodasi
            'view-tour', // Akses tour
            'manage-all-village',   // Kelola semua desa
            'manage-village', // Kelola desa
            'manage-destination', // Kelola destinasi
            'manage-accomodation', // Kelola akomodasi
            'manage-tour', // Kelola tour
            'manage-user', // Kelola user
        ];

        foreach ($permissions as $permission) {
            // Periksa apakah izin sudah ada sebelum membuatnya
            if (!Permission::where('name', $permission)->exists()) {
                Permission::create(['name' => $permission]);
            }
        }

        // Buat roles dan assign permissions
        $superAdminRole = Role::firstOrCreate(['name' => 'super admin']);
        $superAdminRole->syncPermissions([
            'view-dashboard', // Akses dashboard
            'view-destination', // Akses destinasi
            'view-accomodation', // Akses akomodasi
            'view-tour', // Akses tour
            'manage-all-village',   // Kelola semua desa
        ]);

        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $adminRole->syncPermissions([
            'view-dashboard', // Akses dashboard
            'manage-village', // Kelola desa
            'manage-destination', // Kelola destinasi
            'manage-accomodation', // Kelola akomodasi
            'manage-tour', // Kelola tour
            'manage-user', // Kelola user
        ]);

        $pengelolaRole = Role::firstOrCreate(['name' => 'pengelola']);
        $pengelolaRole->syncPermissions([
            'view-dashboard', // Akses dashboard
            'manage-destination', // Kelola destinasi
            'manage-accomodation', // Kelola akomodasi
            'manage-tour', // Kelola tour
        ]);
    }
}
