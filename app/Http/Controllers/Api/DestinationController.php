<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\DestinationImgResource;
use App\Http\Resources\DestinationResource;
use Illuminate\Http\Request;
use App\Models\Destination;
use App\Models\DestinationImage;
use App\Models\DestinationPrice;

class DestinationController extends Controller
{
    public function getAllDestinations(Request $request)
    {
        $village = $request->village;
        $destinations = Destination::with(['categories', 'user', 'images', 'prices' => function ($query) {
            $now = now();
            $query->where('valid_from', '<=', $now)->where('valid_to', '>=', $now);
        }])->where('village_id', $village);
        if ($request->has('category')) {
            $category = $request->input('category');
            $destinations = $destinations
                ->whereJsonContains('category', $category)
                ->latest()
                ->get();
        } else if ($request->has('manager')) {
            $manager = $request->input('manager');
            $destinations = $destinations->where('manager', $manager)
                ->latest()
                ->get();
        } else {
            $destinations = $destinations
                ->latest()
                ->get();
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Destinations fetched successfully',
            'data' => DestinationResource::collection($destinations),
        ], 200);
    }

    public function getDestination(Request $request)
    {
        $code = $request->input('code');
        $destination = Destination::with(['categories', 'user', 'images', 'prices' => function ($query) {
            $now = now();
            $query->where('valid_from', '<=', $now)->where('valid_to', '>=', $now);
        }])->where('code', $code)->first();


        if (!$destination) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data destination tidak ditemukan',
                'data' => null,
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Destination fetched successfully',
            'data' => new DestinationResource($destination),
        ], 200);
    }
}
