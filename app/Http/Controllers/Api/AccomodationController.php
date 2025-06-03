<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\HomestayResource;
use App\Http\Resources\RoomTypeResouce;
use App\Http\Resources\TransportResource;
use App\Models\Homestay;
use App\Models\RoomType;
use App\Models\Transportations;
use Illuminate\Http\Request;

class AccomodationController extends Controller
{
    public function getAllHomestays(Request $request)
    {
        $village = $request->village;
        $homestays = Homestay::with(['user', 'roomTypes'])->where('village_id', $village);
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
        $slug = $request->input('slug');
        $homestay = Homestay::with(['user', 'roomTypes.imageRoom'])->where('slug', $slug)->first();

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

    public function getAllTransportations(Request $request)
    {
        $village = $request->village;
        $trans = Transportations::with(['user'])->where('village_id', $village);
        if ($request->has('manager')) {
            $manager = $request->input('manager');
            $trans = $trans->where('manager', $manager)
                ->latest()
                ->get();
        } else {
            $trans = $trans
                ->latest()
                ->get();
        }



        return response()->json([
            'status' => 'success',
            'message' => 'transportations fetched successfully',
            'data' => TransportResource::collection($trans),
        ], 200);
    }

    public function getTranportation(Request $request)
    {
        $slug = $request->input('slug');
        $transportation = Transportations::with(['user'])->where('slug', $slug)->first();

        if (!$transportation) {
            return response()->json([
                'status' => 'error',
                'message' => 'Transportation not found',
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Transportation fetched successfully',
            'data' => new TransportResource($transportation),
        ], 200);
    }
}
