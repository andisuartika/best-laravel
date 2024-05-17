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
        // $response = Http::get('https://www.emsifa.com/api-wilayah-indonesia/api/villages/5108090.json');
        // $data = json_decode($response->body(), true);
        // foreach ($data as $obj) {
        //     Village::create(array(
        //         'district_id' => $obj['district_id'], 'code' => $obj['id'], 'name' => $obj['name']
        //     ));
        // }

        // return true;
    }
}
