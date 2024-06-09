<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\Destination;
use Illuminate\Http\Request;
use App\Models\DestinationImage;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class DestinationGalleryController extends Controller
{
    public function index(Destination $destination)
    {
        $galleries = DestinationImage::where('destination', $destination->code)->latest()->get();
        return view('admin.destination.wisata.gallery-wisata', compact('destination', 'galleries'));
    }

    public function store(Destination $destination, Request $request)
    {
        DB::beginTransaction();
        try {
            $request->validate([
                'image' => 'required|image|mimes:jpg,png|max:2048',
            ]);
            $url = $this->uploadImg($request, $destination);

            DestinationImage::create([
                'destination' => $destination->code,
                'title' => $request->title,
                'description' => $request->description,
                'url' => $url,
            ]);

            // Commit transaction
            DB::commit();

            return redirect()->back()->with('success', 'Gambar Destinasi Berhasil ditambahkan');
        } catch (Exception $e) {
            // Rollback transaction jika terjadi error
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function destroy(Request $request)
    {
        $image = DestinationImage::findOrFail($request->id);
        // Hapus Thubmnail
        $this->deleteImg($image->url);
        $image->delete();
        return back()->with('success', 'Gambar Berhasil dihapus!');
    }

    private function uploadImg(Request $request, $destination)
    {
        if ($request->hasFile('image')) {
            // Dapatkan file gambar
            $image = $request->file('image');
            // Buat nama file yang unik
            $name = $destination->code . '-' .  time() . '-' . $image->getClientOriginalName();
            // Tentukan path penyimpanan
            $path = $image->storeAs('public/uploads/village/' . $destination->village_id . '/destinations', $name);
            $url = 'storage/uploads/village/' . $destination->village_id . '/destinations' . '/' . $name;
            return $url;
        }
        return null;
    }

    private function deleteImg($url)
    {
        unlink(public_path($url));
    }
}
