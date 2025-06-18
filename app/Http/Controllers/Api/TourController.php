<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TourResource;
use App\Models\Tour;
use Illuminate\Http\Request;

class TourController extends Controller
{
    public function getAllTours(Request $request)
    {
        $village = $request->village;
        $tours = Tour::with(['user', 'destinations', 'rates'])->withCount('ratings')->where('village_id', $village);

        if ($request->has('manager')) {
            $manager = $request->input('manager');
            $tours = $tours->where('manager', $manager)
                ->latest()
                ->get();
        } else {
            $tours = $tours
                ->latest()
                ->get();
        }

        return response()->json([
            'status' => 'success',
            'message' => 'tours fetched successfully',
            'data' => TourResource::collection($tours),
        ], 200);
    }

    public function getTour(Request $request)
    {
        $slug = $request->input('slug');
        $tour = Tour::with(['user', 'destinations.images'])->withCount('ratings')->where('slug', $slug)->first();



        if (!$tour) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data tour tidak ditemukan',
                'data' => null,
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'tour fetched successfully',
            'data' => new TourResource($tour),
        ], 200);
    }
}
