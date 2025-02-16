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

        if ($request->has('category')) {
            $category = $request->input('category');
            $destinations = Destination::where('village_id', $village)
                ->whereJsonContains('category', $category)
                ->latest()
                ->get();
        } else if ($request->has('manager')) {
            $manager = $request->input('manager');
            $destinations = Destination::where('manager', $manager)
                ->latest()
                ->get();
        } else {
            $destinations = Destination::where('village_id', $village)
                ->latest()
                ->get();
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Destinations fetched successfully',
            'data' => $destinations,
        ], 200);
    }

    public function getDestination(Request $request)
    {
        $code = $request->input('code');
        $destination = Destination::with(['categories', 'user'])->where('code', $code)->first();
        dd($destination);
        $galleries = DestinationImage::where('destination', $code)->get();
        $tickets = DestinationPrice::where('destination_id', $code)->get();

        $activeTickets = $tickets->filter(function ($ticket) {
            $now = now();
            return $ticket->valid_from <= $now && $ticket->valid_to >= $now;
        });

        if (!$destination) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data destination tidak ditemukan',
                'data' => null,
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Destinations fetched successfully',
            'data' => [
                'destination' => new DestinationResource($destination),
                'galleries' => DestinationImgResource::collection($galleries),
                'tickets' => $activeTickets,
            ],
        ], 200);
    }
}
