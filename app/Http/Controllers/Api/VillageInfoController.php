<?php

namespace App\Http\Controllers\Api;

use App\Models\InfoVillage;
use Illuminate\Http\Request;
use App\Models\ContactVillage;
use App\Models\GalleryVillage;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redis;
use App\Http\Resources\GalleryResource;

class VillageInfoController extends Controller
{
    public function getVillage(Request $request)
    {
        $village = $request->village;

        $village_info = InfoVillage::where('village_id', $village)->first();
        return response()->json([
            'status' => 'success',
            'message' => 'village fetched successfully',
            'data' => $village_info,
        ], 200);
    }


    public function getContact(Request $request)
    {
        $village = $request->village;

        $contact = ContactVillage::where('village_id', $village)->get();
        return response()->json([
            'status' => 'success',
            'message' => 'Contact fetched successfully',
            'data' => $contact,
        ], 200);
    }

    public function galleries(Request $request)
    {
        $village = $request->village;

        $galleries = GalleryVillage::where('village_id', $village)->get();
        return response()->json([
            'status' => 'success',
            'message' => 'Galleries fetched successfully',
            'data' => GalleryResource::collection($galleries),
        ], 200);
    }
}
