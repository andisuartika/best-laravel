<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\HomestayResource;
use App\Http\Resources\RoomTypeResouce;
use App\Models\Homestay;
use App\Models\RoomType;
use Illuminate\Http\Request;

class AccomodationController extends Controller
{
    public function getAllHomestays(Request $request)
    {
        $village = $request->village;
        $homestays = Homestay::with(['user'])->where('village_id', $village);
        if ($request->has('manager')) {
            $manager = $request->input('manager');
            $homestays = $homestays->where('manager', $manager)
                ->latest()
                ->get();
        } else {
            $homestays = $homestays
                ->latest()
                ->get();
        }

        return response()->json([
            'status' => 'success',
            'message' => 'homestays fetched successfully',
            'data' => HomestayResource::collection($homestays),
        ], 200);
    }


    public function getHomestay(Request $request)
    {
        $code = $request->input('code');
        $homestay = Homestay::with(['user', 'roomTypes.imageRoom'])->where('code', $code)->first();

        if (!$homestay) {
            return response()->json([
                'status' => 'error',
                'message' => 'Homestay not found',
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Homestay fetched successfully',
            'data' => new HomestayResource($homestay),
        ], 200);
    }

    public function getRoomType(Request $request)
    {
        $code = $request->input('code');
        $roomType = RoomType::with(['rooms'])->where('code', $code)->first();

        if (!$roomType) {
            return response()->json([
                'status' => 'error',
                'message' => 'Room Type not found',
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Room Type fetched successfully',
            'data' => new RoomTypeResouce($roomType),
        ], 200);
    }
}
