<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Wallet;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class WalletSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::transaction(function () {
            $users = User::role('pengelola')->get();

            foreach ($users as $user) {
                Wallet::firstOrCreate(['user_id' => $user->id], [
                    'balance' => 0,
                ]);
            }

            // Admin Desa
            $admins = User::role('admin')->get();
            foreach ($admins as $user) {
                Wallet::firstOrCreate(['user_id' => $user->id], [
                    'balance' => 0,
                ]);
            }

            Wallet::firstOrCreate(['user_id' => 1], [
                'balance' => 0,
            ]);
        });
    }
}
