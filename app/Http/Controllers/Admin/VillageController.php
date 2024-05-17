<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InfoVillage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VillageController extends Controller
{
    public function index()
    {
        $village_id = Auth::user()->village_id;
        $village = InfoVillage::where('village_id', $village_id)->first();
        return view('admin.desa.info-desa', compact('village'));
    }

    public function store(Request $request)
    {
        $village_id = Auth::user()->village_id;

        if ($request->section == 'profile') {
            // Update or Create Profile Desa Wisata
            InfoVillage::updateOrCreate(
                [
                    'village_id' => $village_id,
                ],
                [
                    'profile' => $request->profile,
                ]
            );

            $village = InfoVillage::where('village_id', $village_id)->first();
            // Update Gambar Profile
            if ($request->hasFile('profile-img')) {
                // Hapus Gambar Lama
                if ($village->profile_img != null) {
                    unlink(public_path($village->profile_img));
                }

                // Upload Gambar
                $extension = $request->file('profile-img')->getClientOriginalExtension();
                $fileName = $village_id . '-' . time() . '.' . $extension;

                $request->file('profile-img')->storeAs('public/uploads/village/' . $village_id, $fileName);
                $url = 'storage/uploads/village/' . $village_id . '/' . $fileName;


                $village->update([
                    'profile_img' => $url,
                ]);
            }
            return back()->with('success', 2);
        }

        if ($request->section == 'welcoming') {
            // Update or Create Welcoming Desa Wisata
            InfoVillage::updateOrCreate(
                [
                    'village_id' => $village_id,
                ],
                [
                    'welcoming' => $request->welcoming,
                ]
            );

            $village = InfoVillage::where('village_id', $village_id)->first();
            // Update Gambar Welcoming
            if ($request->hasFile('welcoming-img')) {
                // Hapus Gambar Lama
                if ($village->welcoming_img != null) {
                    unlink(public_path($village->welcoming_img));
                }

                // Upload Gambar
                $extension = $request->file('welcoming-img')->getClientOriginalExtension();
                $fileName = $village_id . '-' . time() . '.' . $extension;

                $request->file('welcoming-img')->storeAs('public/uploads/village/' . $village_id, $fileName);
                $url = 'storage/uploads/village/' . $village_id . '/' . $fileName;


                $village->update([
                    'welcoming_img' => $url,
                ]);
            }
            return back()->with('success', 3);
        }

        if ($request->section == 'destination') {
            // Update or Create Destination Desa Wisata
            InfoVillage::updateOrCreate(
                [
                    'village_id' => $village_id,
                ],
                [
                    'destination' => $request->destination,
                ]
            );

            $village = InfoVillage::where('village_id', $village_id)->first();
            // Update Gambar Destination
            if ($request->hasFile('destination-img')) {
                // Hapus Gambar Lama
                if ($village->destination_img != null) {
                    unlink(public_path($village->destination_img));
                }

                // Upload Gambar
                $extension = $request->file('destination-img')->getClientOriginalExtension();
                $fileName = $village_id . '-' . time() . '.' . $extension;

                $request->file('destination-img')->storeAs('public/uploads/village/' . $village_id, $fileName);
                $url = 'storage/uploads/village/' . $village_id . '/' . $fileName;


                $village->update([
                    'destination_img' => $url,
                ]);
            }
            return back()->with('success', 4);
        }

        if ($request->section == 'accomodation') {
            // Update or Create Accomodation Desa Wisata
            InfoVillage::updateOrCreate(
                [
                    'village_id' => $village_id,
                ],
                [
                    'accomodation' => $request->accomodation,
                ]
            );

            $village = InfoVillage::where('village_id', $village_id)->first();
            // Update Gambar Accomodation
            if ($request->hasFile('accomodation-img')) {
                // Hapus Gambar Lama
                if ($village->accomodation_img != null) {
                    unlink(public_path($village->accomodation_img));
                }

                // Upload Gambar
                $extension = $request->file('accomodation-img')->getClientOriginalExtension();
                $fileName = $village_id . '-' . time() . '.' . $extension;

                $request->file('accomodation-img')->storeAs('public/uploads/village/' . $village_id, $fileName);
                $url = 'storage/uploads/village/' . $village_id . '/' . $fileName;


                $village->update([
                    'accomodation_img' => $url,
                ]);
            }
            return back()->with('success', 4);
        }
    }
}
