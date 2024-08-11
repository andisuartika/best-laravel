<?php

namespace App\Http\Controllers;

use App\Models\District;
use App\Models\Province;
use App\Models\Regency;
use App\Models\Village;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class APIWilayah extends Controller
{
    public function run()
    {
        // Get Province
        $response = Http::get('https://www.emsifa.com/api-wilayah-indonesia/api/provinces.json');
        $data = json_decode($response->body(), true);
        foreach ($data as $obj) {
            Province::create(array(
                'code' => $obj['id'], 'name' => $obj['name']
            ));
        }

        // Get Regencies
        $response = Http::get('https://www.emsifa.com/api-wilayah-indonesia/api/regencies/51.json');
        $data = json_decode($response->body(), true);
        foreach ($data as $obj) {
            Regency::create(array(
                'province_id' => $obj['province_id'], 'code' => $obj['id'], 'name' => $obj['name']
            ));
        }

        // Get Disctricts
        $response = Http::get('https://www.emsifa.com/api-wilayah-indonesia/api/districts/5108.json');
        $data = json_decode($response->body(), true);
        foreach ($data as $obj) {
            District::create(array(
                'regency_id' => $obj['regency_id'], 'code' => $obj['id'], 'name' => $obj['name']
            ));
        }

        // Get All Village
        $districts = District::all();
        foreach ($districts as $district) {
            $url = 'https://www.emsifa.com/api-wilayah-indonesia/api/villages/' . $district->code . '.json';
            $response = Http::get($url);
            $data = json_decode($response->body(), true);
            foreach ($data as $obj) {
                Village::create(array(
                    'district_id' => $obj['district_id'], 'code' => $obj['id'], 'name' => $obj['name']
                ));
            }
        }

        return true;
    }
}
