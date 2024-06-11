<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\RoomType;
use App\Models\ImageRoom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class RoomGalleryController extends Controller
{
    public function index($id)
    {
        $room = RoomType::findOrFail($id);
        $galleries = ImageRoom::where('room_type', $room->code)->latest()->get();
        $room = RoomType::findOrFail($id);
        return view('admin.accomodation.room.room-gallery', compact('galleries', 'room'));
    }

    public function store($id, Request $request)
    {
        DB::beginTransaction();
        try {
            $room = RoomType::findOrFail($id);
            $request->validate([
                'image' => 'required|image|mimes:jpg,png|max:2048',
            ]);
            $url = $this->uploadImg($request, $room->code);

            ImageRoom::create([
                'room_type' => $room->code,
                'title' => $request->title,
                'description' => $request->description,
                'url' => $url,
            ]);

            // Commit transaction
            DB::commit();

            return redirect()->back()->with('success', 'Gambar Kamar Berhasil ditambahkan');
        } catch (Exception $e) {
            // Rollback transaction jika terjadi error
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function destroy(Request $request)
    {
        $image = ImageRoom::findOrFail($request->id);
        // Hapus Thubmnail
        $this->deleteImg($image->url);
        $image->delete();
        return back()->with('success', 'Gambar Berhasil dihapus!');
    }

    private function uploadImg(Request $request, $room)
    {
        $village_id = Auth::user()->village_id;
        if ($request->hasFile('image')) {
            // Dapatkan file gambar
            $image = $request->file('image');
            // Buat nama file yang unik
            $name = $room . '-' .  time() . '-' . $image->getClientOriginalName();
            // Tentukan path penyimpanan
            $path = $image->storeAs('public/uploads/village/' . $village_id . '/homestays', $name);
            $url = 'storage/uploads/village/' . $village_id . '/homestays' . '/' . $name;
            return $url;
        }
        return null;
    }

    private function deleteImg($url)
    {
        unlink(public_path($url));
    }
}
