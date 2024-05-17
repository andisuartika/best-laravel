<?php

namespace Database\Seeders;

use App\Models\SubCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SubCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SubCategory::create([
            'category' => '510811',
            'code' => '51081101',
            'name' => 'FOREST',
            'description' => 'FOREST',
        ]);
        SubCategory::create([
            'category' => '510811',
            'code' => '51081102',
            'name' => 'AGRO',
            'description' => 'AGRO',
        ]);
        SubCategory::create([
            'category' => '510811',
            'code' => '51081103',
            'name' => 'NAUTICAL',
            'description' => 'NAUTICAL',
        ]);
        SubCategory::create([
            'category' => '510811',
            'code' => '51081104',
            'name' => 'TIRTA',
            'description' => 'TIRTA',
        ]);

        SubCategory::create([
            'category' => '510812',
            'code' => '51081201',
            'name' => 'ART',
            'description' => 'ART',
        ]);
        SubCategory::create([
            'category' => '510812',
            'code' => '51081202',
            'name' => 'CULTURAL HERITAGE',
            'description' => 'CULTURAL HERITAGE',
        ]);
        SubCategory::create([
            'category' => '510812',
            'code' => '51081203',
            'name' => 'TRADISIONAL GAME',
            'description' => 'TRADISIONAL GAME',
        ]);
        SubCategory::create([
            'category' => '510812',
            'code' => '51081204',
            'name' => 'TRADISIONAL SPORT',
            'description' => 'TRADISIONAL SPORT',
        ]);
        SubCategory::create([
            'category' => '510812',
            'code' => '51081205',
            'name' => 'ORAL TRADITION',
            'description' => 'ORAL TRADITION',
        ]);
        SubCategory::create([
            'category' => '510812',
            'code' => '51081206',
            'name' => 'MANUSCRIPT',
            'description' => 'MANUSCRIPT',
        ]);
        SubCategory::create([
            'category' => '510812',
            'code' => '51081207',
            'name' => 'CUSTOMS',
            'description' => 'CUSTOMS',
        ]);
        SubCategory::create([
            'category' => '510812',
            'code' => '51081208',
            'name' => 'RITUAL',
            'description' => 'RITUAL',
        ]);
        SubCategory::create([
            'category' => '510812',
            'code' => '51081209',
            'name' => 'TRADITIONAL KNOWLADGE',
            'description' => 'TRADITIONAL KNOWLADGE',
        ]);
        SubCategory::create([
            'category' => '510812',
            'code' => '51081210',
            'name' => 'TRADITIONAL TECHNOLOGY',
            'description' => 'TRADITIONAL TECHNOLOGY',
        ]);
        SubCategory::create([
            'category' => '510812',
            'code' => '51081211',
            'name' => 'LANGUAGE',
            'description' => 'LANGUAGE',
        ]);
        SubCategory::create([
            'category' => '510813',
            'code' => '51081301',
            'name' => 'AGRICULTURE',
            'description' => 'AGRICULTURE',
        ]);
        SubCategory::create([
            'category' => '510813',
            'code' => '51081302',
            'name' => 'ENTERTAINMENT',
            'description' => 'ENTERTAINMENT',
        ]);
        SubCategory::create([
            'category' => '510813',
            'code' => '51081303',
            'name' => 'THEMATIC PARK',
            'description' => 'THEMATIC PARK',
        ]);
    }
}
