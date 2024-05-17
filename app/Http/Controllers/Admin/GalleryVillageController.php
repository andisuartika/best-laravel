<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\GalleryVillage;
use Illuminate\Support\Facades\Auth;

class GalleryVillageController extends Controller
{
    public function index()
    {

        $village_id = Auth::user()->village_id;
        $galleries = GalleryVillage::where('village_id', $village_id)->get();
        return view('admin.desa.gallery', compact('galleries'));
    }

    public function store(Request $request)
    {
        $village_id = Auth::user()->village_id;

        if ($request->hasFile('image')) {
            // Upload Gambar
            $extension = $request->file('image')->getClientOriginalExtension();
            $fileName = $village_id . '-' . time() . '.' . $extension;

            $request->file('image')->storeAs('public/uploads/village/' . $village_id . '/galleries' . '/', $fileName);
            $url = 'storage/uploads/village/' . $village_id . '/galleries' . '/' . $fileName;


            GalleryVillage::create([
                'village_id' => $village_id,
                'title' => $request->title,
                'description' => $request->description,
                'image' => $url,
            ]);
        }
        return back()->with('success', 'Image Berhasil ditambahkan!');
    }

    public function delete(Request $request)
    {
        $gallery = GalleryVillage::find($request->id);
        unlink(public_path($gallery->image));
        $gallery->delete();
        return back()->with('success', 'Gambar Berhasil dihapus!');
    }
}
