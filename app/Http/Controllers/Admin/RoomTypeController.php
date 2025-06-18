<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\User;
use App\Models\Manager;
use App\Models\Facility;
use App\Models\Homestay;
use App\Models\RoomRate;
use App\Models\RoomType;
use App\Models\ImageRoom;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Admin\StoreRoomTypeRequest;

class RoomTypeController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $isPengelola = $user->hasRole('pengelola');

        // Ambil homestay sesuai role
        $homestays = Homestay::when($isPengelola, function ($q) use ($user) {
            return $q->where('manager', $user->id);
        }, function ($q) use ($user) {
            return $q->where('village_id', $user->village_id);
        })->get();

        // Ambil room type dengan rate dan homestay sesuai role
        $today = now()->toDateString(); // ambil tanggal hari ini
        $allRoomType = RoomType::with(['rates' => function ($query) use ($today) {
            $query->whereDate('valid_from', '<=', $today)
                ->whereDate('valid_to', '>=', $today)
                ->orderByDesc('valid_from') // ambil yang terbaru
                ->limit(1); // hanya 1 harga aktif
        }])
            ->whereHas('homestay', function ($query) use ($user, $isPengelola) {
                $isPengelola
                    ? $query->where('manager', $user->id)
                    : $query->where('village_id', $user->village_id);
            })
            ->when($request->search, function ($query, $search) {
                $query->where('name', 'like', '%' . $search . '%');
            })
            ->when($request->homestay, function ($query, $homestay) {
                $query->where('homestay', $homestay); // ini field di RoomType
            })
            ->latest()
            ->paginate(10);


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
        try {
            DB::beginTransaction(); // Tambahkan jika belum ada
            // Set up data
            $code = $this->getCode($request->homestay);
            $path = $this->uploadImg($request, $code);
            $facilities = json_encode($request->facilities);

            $homestay = Homestay::where('code', $request->homestay)->first();

            // Create Room Type (tanpa kolom price lagi)
            $roomType = RoomType::create([
                'manager' => $homestay->manager,
                'homestay' => $request->homestay,
                'code' => $code,
                'name' => $request->name,
                'description' => $request->description,
                'capacity' => $request->capacity,
                'facilities' => $facilities,
                'thumbnail' => $path,
                'status' => 'OPEN'
            ]);

            // Loop untuk simpan Room Rates
            foreach ($request->rates as $rate) {
                $cleanPrice = str_replace('.', '', $rate['price']);
                RoomRate::create([
                    'room_type' => $roomType->code,
                    'name' => $rate['name'],
                    'price' => $cleanPrice,
                    'valid_from' => $rate['valid_from'],
                    'valid_to' => $rate['valid_to'],
                ]);
            }

            DB::commit();

            return redirect()->route('room-type.index')->with('success', 'Room Type created successfully');
        } catch (Exception $e) {
            DB::rollBack();
            dd($e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function edit(string $id)
    {
        $type = RoomType::with('rates')->findOrFail($id);
        $facilities = Facility::all();
        $homestays = Homestay::where('village_id', Auth::user()->village_id)->get();
        return view('admin.accomodation.room.form-room-type', compact('facilities', 'homestays', 'type'));
    }

    public function update(StoreRoomTypeRequest $request, $id)
    {

        try {
            DB::beginTransaction();

            // Ambil data tipe kamar
            $type = RoomType::findOrFail($id);
            $facilities = json_encode($request->facilities);

            // Update data tipe kamar
            $type->update([
                'name' => $request->name,
                'description' => $request->description,
                'capacity' => $request->capacity,
                'facilities' => $facilities,
            ]);

            // Update thumbnail jika ada file baru
            if ($request->hasFile('thumbnail')) {
                $this->deleteImg($type->thumbnail);
                $path = $this->uploadImg($request, $type->code);
                $type->update(['thumbnail' => $path]);
            }

            // Hapus semua rate lama
            RoomRate::where('room_type', $type->code)->delete();

            // Tambah ulang rate baru dari form
            foreach ($request->rates as $r) {
                $cleanPrice = str_replace('.', '', $r['price']);

                RoomRate::create([
                    'code' => Str::uuid(),
                    'room_type' => $type->code,
                    'name' => $r['name'],
                    'price' => $cleanPrice,
                    'valid_from' => $r['valid_from'],
                    'valid_to' => $r['valid_to'],
                ]);
            }

            DB::commit();

            return redirect()->route('room-type.index')->with('success', 'Tipe kamar berhasil diupdate!');
        } catch (Exception $e) {
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
            // Hapus semua rate
            RoomRate::where('room_type', $roomType->code)->delete();
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
