<?php

namespace App\Http\Controllers\FE;

use App\Models\Destination;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MundukTourismController extends Controller
{
    var $village_code = '5108040006';
    public function destination()
    {
        $destinations = Destination::where('village_id', $this->village_code)->with('categories')->latest()->paginate(3);
        return view('fe.munduk-tourism.destination', compact('destinations'));
    }

    public function detailDestination($slug)
    {
        $name = str_replace('-', ' ', $slug);

        $destination = Destination::where('village_id', $this->village_code)->where('name', 'LIKE', "%{$name}%")->with('categories', 'user', 'images', 'prices')->first();
        return view('fe.munduk-tourism.detail-destination', compact('destination'));
    }
}
