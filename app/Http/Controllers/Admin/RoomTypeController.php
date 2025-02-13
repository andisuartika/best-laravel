<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\Facility;
use App\Models\Homestay;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Admin\StoreRoomTypeRequest;
use App\Models\ImageRoom;
use App\Models\Manager;
use App\Models\RoomType;
use App\Models\User;

class RoomTypeController extends Controller
{
    public function index(Request $request)
    {
        $homestays = Homestay::where('village_id', Auth::user()->village_id)->get();

        $allRoomType = RoomType::whereHas('homestay', function ($query) {
            $query->where('village_id', Auth::user()->village_id);
        })
            ->when($request->search, function ($query, $search) {
                $query->where('name', 'like', '%' . $search . '%');
            })
            ->when($request->homestay, function ($query, $homestay) {
                $query->whereHas('homestay', function ($query) use ($homestay) {
                    $query->where('homestay', $homestay);
                });
            })
            ->latest()->paginate(10);


        if (Auth::user()->hasRole('pengelola')) {
            $homestays = Homestay::where('manager', Auth::user()->id)->get();

            $allRoomType = RoomType::whereHas('homestay', function ($query) {
                $query->where('manager', Auth::user()->id);
            })
                ->when($request->search, function ($query, $search) {
                    $query->where('name', 'like', '%' . $search . '%');
                })
                ->when($request->homestay, function ($query, $homestay) {
                    $query->whereHas('homestay', function ($query) use ($homestay) {
                        $query->where('homestay', $homestay);
                    });
                })
                ->latest()->paginate(10);
        }

        return view('admin.accomodation.room.room-type', compact('allRoomType', 'homestays'));
    }

    public function filter(Request $request)
    {
        $allRoomType = RoomType::where('homestay', $request->code)->get();
        return response()->json($allRoomType);
    }

    public function create()
    {
        $facilities = Facility::all();
        $homestays = Homestay::where('village_id', Auth::user()->village_id)->get();

        if (Auth::user()->hasRole('pengelola')) {
            $homestays = Homestay::where('manager', Auth::user()->id)->get();
        }

        return view('admin.accomodation.room.form-room-type', compact('facilities', 'homestays'));
    }

    public function store(StoreRoomTypeRequest $request)
    {
        DB::beginTransaction();

        try {
            // Set up data
            $code = $this->getCode($request->homestay);
            $path = $this->uploadImg($request, $code);
            $facilities = json_encode($request->facilities);

            $homestay = Homestay::where('code', $request->homestay)->first();

            // Konversi Price
            $price = str_replace('.', '', $request->price);

            // Create Room Type
            RoomType::create([
                'manager' => $homestay->manager,
                'homestay' => $request->homestay,
                'code' => $code,
                'name' => $request->name,
                'description' => $request->description,
                'capacity' => $request->capacity,
                'price' => $price,
                'facilities' => $facilities,
                'thumbnail' => $path,
                'status' => 'OPEN'
            ]);

            // Commit transaction
            DB::commit();

            return redirect()->route('room-type.index')->with('success', 'Room Type created successfully');
        } catch (Exception $e) {
            // Rollback transaction jika terjadi error
            DB::rollBack();
            dd($e);
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function edit(string $id)
    {
        $type = RoomType::findOrFail($id);
        $facilities = Facility::all();
        $homestays = Homestay::where('village_id', Auth::user()->village_id)->get();
        return view('admin.accomodation.room.form-room-type', compact('facilities', 'homestays', 'type'));
    }

    public function update(StoreRoomTypeRequest $request, $id)
    {
        DB::beginTransaction();

        try {
            // Set up data
            $type = RoomType::findOrFail($id);
            $facilities = json_encode($request->facilities);
            // Konversi Price
            $price = str_replace('.', '', $request->price);

            // Update Room Type
            $type->update([
                'name' => $request->name,
                'description' => $request->description,
                'capacity' => $request->capacity,
                'price' => $price,
                'facilities' => $facilities,
            ]);

            // Update Thumbanil
            if ($request->hasFile('thumbnail')) {
                $this->deleteImg($type->thumbnail);
                $path = $this->uploadImg($request, $type->code);
                $type->update([
                    'thumbnail' => $path,
                ]);
            }

            // Commit transaction
            DB::commit();

            return redirect()->route('room-type.index')->with('success', 'Tipe kamar berhasil diupdate!');
        } catch (Exception $e) {
            // Rollback transaction jika terjadi error
            DB::rollBack();

            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function destroy(string $id)
    {
        DB::beginTransaction();
        try {
            $roomType = RoomType::findOrFail($id);

            // Hapus destinasi gallery
            $images = ImageRoom::where('room_type', $roomType->code)->get();
            foreach ($images as $image) {
                $this->deleteImg($image->url);
                // Delete Image
                $image->delete();
            }

            // Hapus thubmnail dan destinasi
            $this->deleteImg($roomType->thumbnail);
            $roomType->delete();

            // Commit transaction
            DB::commit();

            return back()->with('success', 'Tipe Kamar Berhasil dihapus!');
        } catch (Exception $e) {
            // Rollback transaction jika terjadi error
            DB::rollBack();

            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    private function getCode($homestay)
    {
        $village_id = Auth::user()->village_id;
        // Membuat Code Tipe Kamar Dengan Code Penginapan
        $roomType = RoomType::where('homestay', $homestay)->latest()->first();
        $lastCode = $roomType ? $roomType->code : null;

        if ($lastCode) {
            // Mendapatkan angka setelah kode terakhir
            $lastIncrement = intval(substr($lastCode, -3));
            $nextIncrement = $lastIncrement + 1;
        } else {
            // Jika belum ada pengguna di desa ini
            $nextIncrement = 1;
        }

        // Format kode pengguna dengan padding 3 digit
        // 01 untuk homestay
        $format = $homestay . '-';
        $code = sprintf("%s%03d", $format, $nextIncrement);
        return $code;
    }

    private function uploadImg(Request $request, $code)
    {
        $village_id = Auth::user()->village_id;
        if ($request->hasFile('thumbnail')) {
            // Dapatkan file gambar
            $image = $request->file('thumbnail');
            // Buat nama file yang unik
            $name = $code . '-' . $image->getClientOriginalName();
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
