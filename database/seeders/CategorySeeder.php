<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::create([
            'code' => '510811',
            'name' => 'NATURAL',
            'description' => 'NATURAL',
        ]);
        Category::create([
            'code' => '510812',
            'name' => 'CULTURE',
            'description' => 'CULTURE',
        ]);
        Category::create([
            'code' => '510813',
            'name' => 'ARTIFICIAL',
            'description' => 'ARTIFICIAL',
        ]);
    }
}
